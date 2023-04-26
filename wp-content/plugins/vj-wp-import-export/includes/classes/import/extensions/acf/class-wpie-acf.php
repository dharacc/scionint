<?php


namespace wpie\import\acf;

if ( !defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'vj-wp-import-export' ) );
}

if ( file_exists( WPIE_IMPORT_CLASSES_DIR . '/extensions/acf/class-wpie-acf-base.php' ) ) {

        require_once(WPIE_IMPORT_CLASSES_DIR . '/extensions/acf/class-wpie-acf-base.php');
}

class WPIE_ACF extends \wpie\import\acf\base\WPIE_ACF_Base {

        public function get_field_groups( $type, $taxonomy ) {

                if ( !function_exists( '\acf_get_field_groups' ) ) {
                        return [];
                }

                $arg = [];

                if ( $type == "taxonomies" ) {
                        $arg = [ 'taxonomy' => $taxonomy ];
                } elseif ( $type == "comments" || $type == "product_reviews" ) {
                        $arg = [ 'comment' => 'all' ];
                } elseif ( $type == "users" || $type == "shop_customer" ) {
                        $arg = [ 'user_role' => 'all' ];
                } else {
                        $arg = [ 'post_type' => $type ];
                }

                $this->addRemoveLocationFilters( $type );

                $groups = \acf_get_field_groups( $arg );

                $this->addRemoveLocationFilters( $type, "remove" );

                return $groups;
        }

        public function returnTrue() {

                return true;
        }

        public function acf_get_fields( $key ) {

                if ( !function_exists( '\acf_get_fields' ) ) {
                        return [];
                }
                return \acf_get_fields( $key );
        }

        private function addRemoveLocationFilters( $type = "", $action = "add" ) {

                $filters = [];

                if ( $type == "taxonomies" ) {
                        //nothing to add
                } elseif ( $type == "comments" || $type == "product_reviews" ) {
                        $filters = [ 'comment' ];
                } elseif ( $type == "users" || $type == "shop_customer" ) {
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

}
