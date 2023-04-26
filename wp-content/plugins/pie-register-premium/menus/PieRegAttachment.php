<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

global $wpdb;    
global $piereg_dir_path;
$_available_in_pro 	= "";
	
if(!$this->piereg_pro_is_activate)	{
    $_available_in_pro 	= '- <span style="color:red;">'. __("Available in premium version","pie-register") . '</span>';
}	

$piereg    = get_option(OPTION_PIE_REGISTER);
if( isset($_GET['form_id']) )
{
    $form_id    = intval($_GET['form_id']);
}
else 
{
    $fields_id = get_option("piereg_form_fields_id"); 
    for($a = 1; $a <= $fields_id; $a++)
    {
        $option = get_option("piereg_form_field_option_".$a);
        if( !empty($option) && is_array($option) && isset($option['Id']) && (!isset($option['IsDeleted']) || trim($option['IsDeleted']) != 1) )
        {
            $form_id = $option['Id'];
            break;
        }
    }
}

if( file_exists(PIEREG_DIR_NAME."/classes/attachment_pagination.php") ) {
    include_once( PIEREG_DIR_NAME."/classes/attachment_pagination.php");
}
?>

<div id="container" class="pieregister-admin">
    <div class="right_section">
        <div class="" style="padding-bottom:0px;">
            <div class="attachment settings">            
                <h2 class="headingwidth">
                    <?php _e("Download Attachments",'pie-register'); ?> <?php echo $_available_in_pro; ?>
                </h2>
                
                <?php
                    if( isset($this->pie_post_array['error_message']) && !empty( $this->pie_post_array['error_message'] ) )
                    {
                        echo '<div style="clear: both;float: none;"><p class="error">' . $this->pie_post_array['error_message'] . "</p></div>";
                    }
                    if(isset( $this->pie_post_array['success_message'] ) && !empty( $this->pie_post_array['success_message'] ))
                    {
                        echo '<div style="clear: both;float: none;"><p class="success">' . $this->pie_post_array['success_message'] . "</p></div>";
                    }
                ?>
                
                    <div class="pieHelpTicket">                    
                        
                            <div style="clear:both;float:left;border-right:#ccc 1px solid;padding-right:5px;margin-right:5px;">
                                <form method="post" id="attachment_form">
                                    <?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'piereg_wp_attachment_per_page_nonce','piereg_attachment_per_page_nonce'); ?>
                                    <?php _e("Number of rows","pie-register"); ?>:
                                    <select name="pie_attachment_per_page_items">
                                    <?php
                                    $opt = get_option(OPTION_PIE_REGISTER);
                                    $per_page = ( ((int)$opt['attachments_pagination_number']) != 0)? (int)$opt['attachments_pagination_number'] : 10;
                                    for($per_page_item = 10; $per_page_item <= 50; $per_page_item +=10)
                                    {
                                        $checked = ($per_page == $per_page_item)? 'selected="selected"':'';
                                        echo '<option value="'.$per_page_item.'" '.$checked.'>'.$per_page_item.'</option>';
                                    }
                                    echo '<option value="75" '.(($per_page == "75")? 'selected="selected"':'').' >75</option>';
                                    echo '<option value="100" '.(($per_page == "100")? 'selected="selected"':'').' >100</option>';
                                    ?>
                                </select>
                                </form>
                            </div>
                        
                        <div style="float:left;">
                            <?php _e("Form","pie-register"); ?>:
                            <select name="form_id">
                            <?php 
                                $fields_id = get_option("piereg_form_fields_id"); 
                                for($a = 1; $a <= $fields_id; $a++)
                                {
                                    $option = get_option("piereg_form_field_option_".$a); 
                                    if( !empty($option) && is_array($option) && isset($option['Id']) && (!isset($option['IsDeleted']) || trim($option['IsDeleted']) != 1) )
                                    {
                                        ?>
                                        <option value="<?php echo $option['Id']; ?>" <?php echo $form_id == $option['Id'] ? 'selected' : '' ?>><?php echo $option['Title']; ?></option>
                                        <?php 
                                    }                                
                                } 
                            ?>
                            </select>
                        </div>                    
                        <a href="javascript:void(0);" class="button button-large button-primary pie-btn-download-all-user-documents" style="float:right;" data-context="all">
                                &nbsp; <?php _e("Download All User Documents","pie-register"); ?> &nbsp;
                        </a>
                    </div>
                
                <?php            
                    if ($_available_in_pro == "") 
                    {
                        $Pie_Attachment_Table = new Pie_Attachment_Table($form_id, false);
                    }
                    else
                    {
                        $Pie_Attachment_Table = new Pie_Attachment_Table($form_id, true);
                    }
                    
                    $Pie_Attachment_Table->set_order();
                    $Pie_Attachment_Table->set_orderby();
                    $Pie_Attachment_Table->prepare_items();
                    $Pie_Attachment_Table->search_box("Search", "search_invitaion_code");
                    $Pie_Attachment_Table->display();                
                    ?>
            </div>
        </div>    
    </div>
</div>