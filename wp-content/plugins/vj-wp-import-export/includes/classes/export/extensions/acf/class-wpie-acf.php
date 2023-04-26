<?php


namespace wpie\export\acf;

if ( !defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'vj-wp-import-export' ) );
}

if ( file_exists( WPIE_EXPORT_CLASSES_DIR . '/class-wpie-export-base.php' ) ) {

        require_once(WPIE_EXPORT_CLASSES_DIR . '/class-wpie-export-base.php');
}

class WPIE_ACF extends \wpie\export\base\WPIE_Export_Base {

        private $AcfMeta       = [];
        private $duplicateMeta = [];
        private $type          = null;
        private $taxonomyType  = null;
        private $group         = [];

        public function __construct() {

                add_filter( 'wpie_pre_item_meta', array( $this, "wpie_pre_item_meta" ), 10, 2 );
        }

        public function wpie_pre_item_meta( $meta = [], $key = "" ) {

                if ( !empty( $this->AcfMeta ) && in_array( $key, $this->AcfMeta ) ) {

                        $meta[ "is_acf" ] = 1;
                }
                return $meta;
        }

        private function get_field_groups() {

                if ( !function_exists( '\acf_get_field_groups' ) ) {
                        return [];
                }

                $arg = [];

                if ( $this->type == "taxonomies" ) {
                        $arg = [ 'taxonomy' => $this->taxonomyType ];
                } elseif ( $this->type == "comments" || $this->type == "product_reviews" ) {
                        $arg = [ 'comment' => 'all' ];
                } elseif ( $this->type == "users" || $this->type == "shop_customer" ) {
                        $arg = [ 'user_role' => 'all' ];
                } else {
                        $arg = [ 'post_type' => $this->type ];
                }

                $this->addRemoveLocationFilters();

                $groups = \acf_get_field_groups( $arg );

                $this->addRemoveLocationFilters( "remove" );

                return $groups;
        }

        public function returnTrue() {

                return true;
        }

        private function acf_get_fields( $key ) {

                if ( !function_exists( '\acf_get_fields' ) ) {
                        return [];
                }
                return \acf_get_fields( $key );
        }

        private function addRemoveLocationFilters( $action = "add" ) {

                $filters = [];

                if ( $this->type == "taxonomies" ) {
                        //nothing to add
                } elseif ( $this->type == "comments" || $this->type == "product_reviews" ) {
                        $filters = [ 'comment' ];
                } elseif ( $this->type == "users" || $this->type == "shop_customer" ) {
                        $filters = [ 'current_user', 'current_user_role', 'user_form', 'user_role' ];
                } else {
                        $page    = [ 'page', 'page_parent', 'page_template', 'page_type' ];
                        $post    = [ 'post', 'post_category', 'post_format', 'post_status', 'post_taxonomy', 'post_template' ];
                        $filters = array_merge( $page, $post );
                }

                if ( empty( $filters ) ) {
                        return;
                }

                $fn = ($action === "remove" ? "remove_filter" : "add_filter");

                foreach ( $filters as $filter ) {
                        $fn( "acf/location/rule_match/" . $filter, [ $this, "returnTrue" ], 99999 );
                }
        }

        public function pre_process_fields( &$export_fields = [], $export_type = [], $export_taxonomy_type = "" ) {

                $this->duplicateMeta = [];

                $this->type = is_array( $export_type ) && isset( $export_type[ 0 ] ) ? $export_type[ 0 ] : $export_type;

                $this->taxonomyType = $export_taxonomy_type;

                $acfGroup = $this->get_field_groups();

                if ( empty( $acfGroup ) ) {
                        return;
                }

                $count = 1;

                foreach ( $acfGroup as $group ) {

                        $this->group = $group;

                        $key = isset( $group[ 'key' ] ) ? $group[ 'key' ] : (isset( $group[ 'ID' ] ) ? $group[ 'ID' ] : "");

                        $this->groupFields = $this->acf_get_fields( $key );

                        if ( !is_array( $this->groupFields ) ) {
                                continue;
                        }

                        $data = $this->getFields();

                        if ( empty( $data ) ) {
                                continue;
                        }
                        $fieldKey = 'wpie_acf_field_' . $count;

                        $title = isset( $group[ 'title' ] ) ? $group[ 'title' ] : "";

                        $export_fields[ $fieldKey ] = [ "title" => "ACF - " . $title, "data" => $data ];

                        $count++;
                }

                $this->removeDuplicates( $export_fields[ 'meta' ] );

                if ( !empty( $this->AcfMeta ) ) {

                        $export_fields[ 'meta' ] = array_diff( $export_fields[ 'meta' ], $this->AcfMeta );
                }
        }

        private function getFields() {

                $data = [];

                foreach ( $this->groupFields as $field ) {
                        $data[] = [
                                'name'   => isset( $field[ 'label' ] ) ? $field[ 'label' ] : "",
                                'type'   => 'wpie-acf',
                                'acfKey' => isset( $field[ 'key' ] ) ? $field[ 'key' ] : "",
                        ];

                        $metaKey = isset( $field[ 'name' ] ) ? $field[ 'name' ] : "";

                        if ( !empty( $metaKey ) ) {
                                $this->duplicateMeta[] = $metaKey;
                        }

                        $fieldType = isset( $field[ 'type' ] ) ? $field[ 'type' ] : "";

                        if ( !empty( $fieldType ) && in_array( $fieldType, [ "group", "clone", "flexible_content", "repeater" ] ) ) {

                                $duplicates = $this->getDuplicateFields( $field );

                                if ( is_array( $duplicates ) && !empty( $duplicates ) ) {

                                        $this->duplicateMeta = array_merge( $this->duplicateMeta, $duplicates );
                                }
                        }
                }

                return $data;
        }

        private function removeDuplicates( $metas = [] ) {

                if ( empty( $this->duplicateMeta ) ) {
                        return [];
                }

                $found_data = [];

                foreach ( $this->duplicateMeta as $meta ) {

                        if ( empty( $meta ) ) {
                                continue;
                        }
                        if ( is_array( $meta ) ) {

                                $metaKey = isset( $meta[ 'key' ] ) ? $meta[ 'key' ] : "";

                                $regexp = isset( $meta[ 'regexp' ] ) ? $meta[ 'regexp' ] : "";

                                if ( !empty( $regexp ) ) {

                                        foreach ( $regexp as $exp ) {

                                                $exp = "/^" . $exp . "$/";

                                                $matches = preg_grep( $exp, $metas );

                                                if ( !empty( $matches ) ) {

                                                        $found_data = array_merge( $found_data, $matches );
                                                }
                                        }
                                }

                                if ( !empty( $metaKey ) && in_array( $metaKey, $metas ) ) {
                                        $found_data[] = "_" . $metaKey;
                                        $found_data[] = $metaKey;
                                }
                        } else {
                                $found_data[] = $meta;
                                $found_data[] = "_" . $meta;
                        }
                }

                $this->AcfMeta = array_unique( $found_data );

                unset( $found_data );
        }

        private function getDuplicateFields( $field ) {

                $field_list = [];

                if ( is_array( $field ) ) {

                        $type = isset( $field[ 'type' ] ) ? trim( strtolower( sanitize_text_field( $field[ 'type' ] ) ) ) : "";

                        if ( !empty( $type ) ) {

                                switch ( $type ) {
                                        case 'clone':
                                        case 'group':

                                                $name = isset( $field[ 'name' ] ) ? $field[ 'name' ] : "";

                                                $sub_fields = isset( $field[ 'sub_fields' ] ) ? $field[ 'sub_fields' ] : [];

                                                if ( !empty( $sub_fields ) ) {

                                                        foreach ( $sub_fields as $s_field ) {

                                                                $s_field_id = isset( $s_field[ 'key' ] ) ? $s_field[ 'key' ] : "";

                                                                $new_field = $this->getDuplicateFields( \acf_get_field( $s_field_id ) );

                                                                if ( !empty( $new_field ) ) {
                                                                        $key = isset( $new_field[ 'key' ] ) ? $new_field[ 'key' ] : "";

                                                                        $regexp = isset( $new_field[ 'regexp' ] ) ? $new_field[ 'regexp' ] : "";

                                                                        $field_list[] = [ "key" => $name . "_" . $key, 'regexp' => $regexp ];
                                                                }
                                                        }
                                                }

                                                break;
                                        case 'repeater':

                                                $name = isset( $field[ 'name' ] ) ? $field[ 'name' ] : "";

                                                $sub_fields = isset( $field[ 'sub_fields' ] ) ? $field[ 'sub_fields' ] : [
                                                ];

                                                if ( !empty( $sub_fields ) ) {

                                                        foreach ( $sub_fields as $s_key => $s_field ) {

                                                                $s_field_id = isset( $s_field[ 'key' ] ) ? $s_field[ 'key' ] : "";

                                                                $new_field = $this->getDuplicateFields( \acf_get_field( $s_field_id ) );

                                                                if ( !empty( $new_field ) ) {

                                                                        $key = isset( $new_field[ 'key' ] ) ? $new_field[ 'key' ] : "";

                                                                        $regexp = isset( $new_field[ 'regexp' ] ) && !empty( $new_field[ 'regexp' ] ) ? $new_field[ 'regexp' ] : $key;

                                                                        $field_list[] = [
                                                                                "key"    => $name . "_" . $s_key . "_" . $key,
                                                                                "regexp" => [ "_" . $name . "_.*" . $regexp, $name . "_.*" . $regexp . "_" ]
                                                                        ];
                                                                }
                                                        }
                                                }

                                                break;
                                        case 'flexible_content':

                                                $name = isset( $field[ 'name' ] ) ? $field[ 'name' ] : "";

                                                $layouts = isset( $field[ 'layouts' ] ) ? $field[ 'layouts' ] : [];

                                                if ( !empty( $layouts ) ) {
                                                        foreach ( $layouts as $_layout ) {

                                                                $sub_fields = isset( $_layout[ 'sub_fields' ] ) ? $_layout[ 'sub_fields' ] : [];

                                                                if ( !empty( $sub_fields ) ) {

                                                                        foreach ( $sub_fields as $s_key => $s_field ) {

                                                                                $s_field_id = isset( $s_field[ 'key' ] ) ? $s_field[ 'key' ] : "";

                                                                                $new_field = $this->getDuplicateFields( \acf_get_field( $s_field_id ) );

                                                                                if ( !empty( $new_field ) ) {

                                                                                        $key = isset( $new_field[ 'key' ] ) ? $new_field[ 'key' ] : "";

                                                                                        $regexp = isset( $new_field[ 'regexp' ] ) && !empty( $new_field[ 'regexp' ] ) ? $new_field[ 'regexp' ] : $key;

                                                                                        $field_list[] = [
                                                                                                "key"    => $name . "_" . $s_key . "_" . $key,
                                                                                                "regexp" => [ "_" . $name . "_.*" . $regexp, $name . "_.*" . $regexp . "_" ]
                                                                                        ];
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }


                                                break;

                                        default :
                                                $field_list[ "key" ] = isset( $field[ 'name' ] ) ? $field[ 'name' ] : "";

                                                break;
                                }
                        }
                }
                return $field_list;
        }

        public function change_export_labels( &$export_labels = array(), $field_type = "", $field_name = "", $field_label = "", $field_option = array() ) {

                if ( $field_type == "wpie-acf" ) {

                        $fieldKey = isset( $field_option[ 'acfKey' ] ) ? $field_option[ 'acfKey' ] : "";

                        $field = \acf_get_field( $fieldKey );

                        if ( !is_array( $field ) || !isset( $field[ "type" ] ) ) {
                                return;
                        }


                        $fieldType = isset( $field[ 'type' ] ) ? $field[ 'type' ] : "";

                        if ( !empty( $fieldType ) ) {

                                switch ( $fieldType ) {
                                        case 'link':
                                                unset( $export_labels[ $field_name ] );
                                                $export_labels[ $field_name . "_url" ]     = $field_label . " URL";
                                                $export_labels[ $field_name . "_title" ]   = $field_label . " Title";
                                                $export_labels[ $field_name . "_target" ]  = $field_label . " Target";
                                                break;
                                        case 'google_map':
                                                unset( $export_labels[ $field_name ] );
                                                $export_labels[ $field_name . "_address" ] = $field_label . " Address";
                                                $export_labels[ $field_name . "_lat" ]     = $field_label . " Lat";
                                                $export_labels[ $field_name . "_lng" ]     = $field_label . " Lng";
                                                break;
                                }
                        }
                }
        }

        public function process_addon_data( &$export_data = array(), $field_type = "", $field_name = "", $field_option = array(), $item = null, $site_date_format = "" ) {

                if ( $field_type !== "wpie-acf" ) {
                        return;
                }

                $fieldKey = isset( $field_option[ 'acfKey' ] ) ? $field_option[ 'acfKey' ] : "";

                $field = \acf_get_field( $fieldKey );

                if ( !is_array( $field ) || !isset( $field[ "type" ] ) ) {
                        return;
                }

                $fieldId = $this->getValidAcfId( $item );

                $fieldType = isset( $field[ 'type' ] ) ? $field[ 'type' ] : "";

                $fieldKey = isset( $field[ 'key' ] ) ? $field[ 'key' ] : "";

                if ( empty( $fieldType ) || empty( $fieldKey ) ) {
                        return;
                }

                $is_php = isset( $field_option[ 'isPhp' ] ) ? wpie_sanitize_field( $field_option[ 'isPhp' ] ) == 1 : false;

                $php_func = isset( $field_option[ 'phpFun' ] ) ? wpie_sanitize_field( $field_option[ 'phpFun' ] ) : "";

                $data = "";

                $delimiter = ",";

                $isAdded = false;

                switch ( $fieldType ) {
                        case 'repeater':
                        case 'flexible_content':
                        case 'clone':
                        case 'group':

                                $data = \get_field( $fieldKey, $fieldId, false );

                                break;
                        case 'google_map':

                                $isAdded = true;

                                $gmap_data = \get_field( $fieldKey, $fieldId );

                                if ( !is_array( $gmap_data ) || empty( $gmap_data ) ) {
                                        $gmap_data = [];
                                }

                                $export_data[ $field_name . "_address" ] = isset( $gmap_data[ 'address' ] ) ? $gmap_data[ 'address' ] : "";
                                $export_data[ $field_name . "_lat" ]     = isset( $gmap_data[ 'lat' ] ) ? $gmap_data[ 'lat' ] : "";
                                $export_data[ $field_name . "_lng" ]     = isset( $gmap_data[ 'lng' ] ) ? $gmap_data[ 'lng' ] : "";
                                unset( $export_data[ $field_name ] );

                                unset( $gmap_data );
                                break;
                        case 'link':

                                $isAdded = true;

                                $link_data = \get_field( $fieldKey, $fieldId );

                                if ( is_array( $link_data ) ) {

                                        $_url    = isset( $link_data[ 'url' ] ) ? $link_data[ 'url' ] : "";
                                        $_title  = isset( $link_data[ 'title' ] ) ? $link_data[ 'title' ] : "";
                                        $_target = isset( $link_data[ 'target' ] ) ? $link_data[ 'target' ] : "";
                                } else {
                                        $_url    = $link_data;
                                        $_title  = "";
                                        $_target = "";
                                }

                                $export_data[ $field_name . "_url" ]    = $_url;
                                $export_data[ $field_name . "_title" ]  = $_title;
                                $export_data[ $field_name . "_target" ] = $_target;
                                unset( $export_data[ $field_name ], $link_data );

                                break;
                        case 'page_link':

                                $page_link = \get_field( $fieldKey, $fieldId, false );

                                if ( !empty( $page_link ) ) {

                                        if ( is_array( $page_link ) ) {

                                                $page_link_data = array();

                                                foreach ( $page_link as $link_ids ) {
                                                        $page_link_data[] = \get_the_title( $link_ids );
                                                }
                                                if ( !empty( $page_link_data ) ) {
                                                        $data = implode( ",", $page_link_data );
                                                }
                                                unset( $page_link_data );
                                        } else {
                                                $data = $page_link;
                                        }
                                }

                                break;

                        case 'message':

                                $data = isset( $field[ 'message' ] ) && !empty( $field[ 'message' ] ) ? $field[ 'message' ] : "";

                                break;

                        case 'true_false':

                                $data = \get_field( $fieldKey, $fieldId ) ? "yes" : "no";

                                break;

                        case 'select':
                        case 'checkbox':
                        case 'page_link':
                        case 'radio':
                        case 'button_group':

                                $data = \get_field( $fieldKey, $fieldId );

                                if ( is_array( $data ) ) {

                                        $optiondata = array_values( $data );

                                        if ( isset( $optiondata[ 0 ] ) && is_array( $optiondata[ 0 ] ) ) {

                                                $new_data = array();

                                                foreach ( $optiondata as $_key => $_value ) {
                                                        $new_data[] = isset( $_value[ 'value' ] ) ? $_value[ 'value' ] : "";
                                                }

                                                $data = implode( $delimiter, $new_data );
                                        } elseif ( isset( $optiondata[ 'value' ] ) ) {
                                                $data = $optiondata[ 'value' ];
                                        } else {

                                                $data = implode( $delimiter, $optiondata );
                                        }
                                        unset( $optiondata );
                                }

                                break;

                        case 'date_picker':

                                $data = \get_field( $fieldKey, $fieldId, false );
                                $data = date( 'Y-m-d', strtotime( $data ) );

                                break;
                        case 'textarea':
                        case 'oembed':
                        case 'wysiwyg':
                        case 'wp_wysiwyg':
                        case 'date_time_picker':

                                $data = \get_field( $fieldKey, $fieldId, false );

                                break;

                        case 'gallery':

                                $data = \get_field( $fieldKey, $fieldId );

                                if ( is_array( $data ) ) {

                                        $gallery = array();

                                        foreach ( $data as $_key => $_value ) {
                                                if ( is_numeric( $_value ) ) {

                                                        $gallery[] = stripslashes_deep( wp_get_attachment_url( $_value ) );
                                                } elseif ( is_array( $_value ) ) {

                                                        $gallery[] = isset( $_value[ 'url' ] ) && !empty( $_value[ 'url' ] ) ? stripslashes_deep( $_value[ 'url' ] ) : "";
                                                }
                                        }
                                        $data = implode( $delimiter, $gallery );

                                        unset( $gallery );
                                }

                                break;

                        case 'file':
                        case 'image':
                                $data = \get_field( $fieldKey, $fieldId );

                                if ( is_numeric( $data ) ) {

                                        $data = wp_get_attachment_url( $data );
                                } elseif ( is_array( $data ) ) {

                                        $data = isset( $data[ 'url' ] ) && !empty( $data[ 'url' ] ) ? $data[ 'url' ] : "";
                                }
                                break;

                        case 'post_object':
                        case 'relationship':
                                $data = \get_field( $fieldKey, $fieldId );

                                if ( isset( $field[ 'multiple' ] ) && !empty( $field[ 'multiple' ] ) || ($field_type == "relationship" && is_array( $data )) ) {

                                        $post_data = [];

                                        if ( is_array( $data ) ) {

                                                foreach ( $data as $key => $pid ) {

                                                        if ( is_numeric( $pid ) ) {

                                                                $entry = get_post( $pid );

                                                                if ( $entry ) {
                                                                        $post_data[] = $entry->post_title;
                                                                }
                                                                unset( $entry );
                                                        } elseif ( isset( $pid->post_title ) ) {
                                                                $post_data[] = $pid->post_title;
                                                        }
                                                }
                                        }
                                        $data = implode( $delimiter, $post_data );

                                        unset( $post_data );
                                } else {
                                        if ( is_numeric( $data ) ) {

                                                $entry = get_post( $data );

                                                if ( $entry ) {
                                                        $data = $entry->post_title;
                                                }
                                                unset( $entry );
                                        } elseif ( is_array( $data ) ) {
                                                
                                        } elseif ( isset( $data->post_title ) ) {
                                                $data = $data->post_title;
                                        }
                                }
                                break;
                        case 'taxonomy':

                                $data = \get_field( $fieldKey, $fieldId );
                                if ( is_array( $data ) ) {

                                        $term_data = array();

                                        foreach ( $data as $key => $tid ) {

                                                if ( is_object( $tid ) && isset( $tid->name ) ) {
                                                        $term_data[] = $tid->name;
                                                } else {
                                                        $entry = get_term( $tid, $field[ 'taxonomy' ] );

                                                        if ( $entry && !is_wp_error( $entry ) ) {

                                                                $term_data[] = $entry->name;
                                                        }
                                                        unset( $entry );
                                                }
                                        }

                                        $data = implode( $delimiter, $term_data );

                                        unset( $term_data );
                                }

                                break;

                        case 'user':
                                $data = \get_field( $fieldKey, $fieldId );

                                if ( is_array( $data ) ) {

                                        $user_data = array();

                                        foreach ( $data as $key => $user ) {

                                                if ( is_array( $user ) && isset( $user[ 'user_email' ] ) ) {
                                                        $user_data[] = $user[ 'user_email' ];
                                                } else {
                                                        $user_entry = get_user_by( 'ID', $user );
                                                        if ( $user_entry ) {
                                                                $user_data[] = $user_entry->user_email;
                                                        }
                                                        unset( $user_entry );
                                                }
                                        }

                                        $data = implode( $delimiter, $user_data );

                                        unset( $user_data );
                                }

                                break;
                        default:

                                $data = \get_field( $fieldKey, $fieldId );

                                break;
                }

                if ( $isAdded === false ) {

                        $data = \wp_unslash( $data );

                        if ( is_array( $data ) ) {
                                $data = json_encode( $data );
                        } elseif ( $data === false || is_null( $data ) || ( is_string( $data ) && trim( $data ) === "" ) ) {
                                $data = "";
                        }

                        $export_data[ $field_name ] = $this->apply_user_function( $data, $is_php, $php_func );
                }
        }

        public function getValidAcfId( $item = 0 ) {

                if ( !is_object( $item ) ) {
                        return 0;
                }

                $id = 0;

                if ( isset( $item->post_type, $item->ID ) ) {

                        $id = $item->ID;
                } elseif ( isset( $item->roles, $item->ID ) ) {
                        $id = 'user_' . $item->ID;
                } elseif ( isset( $item->taxonomy, $item->term_id ) ) {
                        $id = 'term_' . $item->term_id;
                } elseif ( isset( $item->comment_ID ) ) {
                        $id = 'comment_' . $item->comment_ID;
                }

                return $id;
        }

}
