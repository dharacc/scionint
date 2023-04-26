<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'WP_List_Table' ) )
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	
class Pie_Attachment_Table extends WP_List_Table
{
    private $order;
    private $orderby;
    private $form_id;
    private $non_pro;
    
    public function __construct($form_id, $non_pro)
    {
        $this->form_id = $form_id;
        $this->non_pro = $non_pro;
        
        parent :: __construct( array(
            'singular' => 'Pie Register Attachment',
            'plural'   => 'Pie Register Attachments',
            'ajax'     => true
        ) );
    }
    
    private function get_sql_results()
    {
        global $wpdb;
        $table_data = array();
        $form_user_ids = array();

        $sql = "SELECT `user_id` FROM {$wpdb->usermeta} where meta_key = 'user_registered_form_id' AND meta_value = {$this->form_id}";

        $sql_form_user_ids = $wpdb->get_results( $sql,ARRAY_A );
        if(!empty($sql_form_user_ids)){
            foreach($sql_form_user_ids as $sql_form_user_id){
                foreach($sql_form_user_id as $form_user_id){
                    array_push($form_user_ids,$form_user_id);
                }
            }
        }

        $args = array(
                'fields' => array( 'ID', 'user_login', 'user_email' )
        );
        $users = get_users( $args );
        
        foreach($users as $user) 
        {
            /**
             * Removed below query:
             * AND     SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX({$wpdb->usermeta}.meta_value, '/', -1), '.', 1), '_',-1) = %d
             * in version 3.2.1
             */
            if(in_array($user->ID,$form_user_ids)){
                $sql = "
                        SELECT user_id,meta_key,meta_value
                        FROM    {$wpdb->usermeta} 
                        WHERE   {$wpdb->usermeta}.meta_key LIKE '%pie_upload_%'
                        AND     {$wpdb->usermeta}.user_id = %d AND {$wpdb->usermeta}.meta_value != ''
                ";

                $pie_uploads = $wpdb->get_results( $wpdb->prepare( $sql, array($user->ID) ) );

                if (!empty($pie_uploads))
                {
                    $record = array(
                            'user_id'       => $user->ID,
                            'username'      => $user->user_login,
                            'email'         => $user->user_email,
                            'attachments'   => $pie_uploads
                    );
                    
                    $table_data[] = (object)$record;
                }
            }
        }
	
        if ( !$this->non_pro )
        {
            return $table_data;
        }
        else
        {
            return array();
        }
    }
    public function set_order()
    {
        $order = 'DESC';
        if ( isset( $_GET['order'] ) && $_GET['order'] )
            $order = $_GET['order'];
        $this->order = sanitize_key( $order );	// Lowercase alphanumeric characters, dashes and underscores are allowed
    }
    public function set_orderby()
    {
        $orderby = 'code_usage';
        if ( isset( $_GET['orderby'] ) && $_GET['orderby'] )
            $orderby = $_GET['orderby'];
        $this->orderby = sanitize_key( $orderby );	// Lowercase alphanumeric characters, dashes and underscores are allowed
    }
    public function search_box($text, $input_id)
    {
        return false;
    }
    public function ajax_user_can() 
    {
        return current_user_can( 'edit_posts' );
    }
    public function no_items() 
    {
         _e( 'No attachments were found', "pie-register" );
    }
    public function get_views()
    {
        return array();
    }
    function get_table_classes() {
        return array( 'widefat', 'fixed', 'pie-list-table', 'striped', $this->_args['plural'] );
    }
    public function get_columns()
    {
        $columns = array(
            'user_id'           => __( 'ID' ),
            'username'          => __( 'Username', "pie-register" ),
            'email'             => __( 'Email Address', "pie-register"),
            'attachments'       => __( 'Attachments', "pie-register")
        );
        
        return $columns;        
    }
    public function get_sortable_columns()
    {
        $sortable = array(
            //'user_id'           => array( 'user_id', true ),
            //'username'          => array( 'username', true ),
            //'email'             => array( 'email', true )
        );
        
        return $sortable;
    }
    public function prepare_items( )
    {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( 
            $columns,
            $hidden,
            $sortable 
        );

        // SQL results
        $posts = $this->get_sql_results();
                
        empty( $posts ) AND $posts = array();
        # >>>> Pagination
		
        $opt = get_option(OPTION_PIE_REGISTER);
        $per_page_item = (isset($opt['attachments_pagination_number']) && ((int)$opt['attachments_pagination_number']) != 0) ? (int)$opt['attachments_pagination_number'] : 10;
        unset($opt);
        
        $per_page     = $per_page_item;
        $current_page = $this->get_pagenum();
        $total_items  = count( $posts );
        $this->set_pagination_args( array (
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil( $total_items / $per_page )
        ) );
        $last_post = $current_page * $per_page;
        $first_post = $last_post - $per_page + 1;
        $last_post > $total_items AND $last_post = $total_items;
        // Setup the range of keys/indizes that contain 
        // the posts on the currently displayed page(d).
        // Flip keys with values as the range outputs the range in the values.
        $range = array_flip( range( $first_post - 1, $last_post - 1, 1 ) );
        // Filter out the posts we're not displaying on the current page.
        $posts_array = array_intersect_key( $posts, $range );
        # <<<< Pagination
        // Prepare the data
        
        foreach ( $posts_array as $key => $post )
        { 
            $user_id = $post->user_id;
            
            $posts[ $key ]->user_id = '<span>'.$post->user_id.'</span>';
            $posts[ $key ]->username = $post->username;
            $posts[ $key ]->email = $post->email;
            
            $attachments_html = '';
            
            if ( !empty($post->attachments[0]->meta_value) ) 
            {
                foreach($post->attachments as $attachment) 
                {
                    if($attachment->meta_value != ''){
                        $attachments_html .= basename($attachment->meta_value);
                        $attachments_html .= ' (<a href="'.$attachment->meta_value.'" target="_blank" download>Download</a>) <br />';
                    }                    
                }

                if (count($post->attachments) > 1) {
                    $attachments_html .= '<br />';
                    $attachments_html .= '<a href="javascript:void(0);" class="pie-btn-download-current-user-documents" data-context="user" data-id="'.$user_id.'">Download All Attachments</a>';
                }

            } 
            else 
            {
                $attachments_html .= 'Sorry, no attachments found.';
            }

            $posts[ $key ]->attachments = $attachments_html;
        }
        
        $this->items = $posts_array;	
    }
    public function column_default( $item, $column_name )
    {
        return $item->$column_name;
    }
    public function display_tablenav( $which ) {
        ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
            
            <div class="alignleft actions">
                <?php //Bulk option here ?>
            </div>
             
            <?php
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
            <br class="piereg_clear" />
        </div>
        <?php
    }
    public function extra_tablenav( $which )
    {
        global $wp_meta_boxes;
        $views = $this->get_views();
        if ( empty( $views ) )
            return;
        $this->views();
    }
}