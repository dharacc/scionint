<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $piereg = PieReg_Base::get_pr_global_options();
$_available_in_pro  = "";
if(!$this->piereg_pro_is_activate)  {
  $_available_in_pro  = ' - <span style="color:red;">'. __("Available in premium version","pie-register") . '</span>';
}
?>
<div class="pieregister-admin">
<div class="pie_restrictions_area">
    <div class="settings pad_bot_none">
        <h2 class="headingwidth"><?php _e("User Control",'pie-register') ?> <?php echo $_available_in_pro; ?></h2>
        <?php
        if(isset($this->pie_post_array['notice']) && !empty($this->pie_post_array['notice']) ){
          echo '<div id="message" class="updated fade msg_belowheading"><p><strong>' . $this->pie_post_array['notice'] . '.</strong></p></div>';
        }
        if( isset($this->pie_post_array['error_message']) && !empty( $this->pie_post_array['error_message'] ) )
          echo '<div style="clear: both;float: none;"><p class="error">' . $this->pie_post_array['error_message']  . "</p></div>";
        if( isset($this->pie_post_array['error']) && !empty( $this->pie_post_array['error'] ) )
          echo '<div style="clear: both;float: none;"><p class="error">' . $this->pie_post_array['error']  . "</p></div>";
        if(isset( $this->pie_post_array['success_message'] ) && !empty( $this->pie_post_array['success_message'] ))
          echo '<div style="clear: both;float: none;"><p class="success">' . $this->pie_post_array['success_message']  . "</p></div>";
        ?>
        <div class="invite-tabs restrictions-tabs clearfix">
          <ul>
            <li <?php if(!isset($_GET['allowed_users'])){ echo 'class="invite-active"'; } ?>><a href="admin.php?page=pie-black-listed-users&block_ussers"><?php _e("Block Users","pie-register") ?></a></li>
            <li <?php if(isset($_GET['allowed_users'])){ echo 'class="invite-active"'; } ?>><a href="admin.php?page=pie-black-listed-users&allowed_users"><?php _e("Allow Users","pie-register") ?></a></li>
          </ul>
        </div>
  </div>
    <div id="container" class="pieregister-admin pieregister-admin-restrictions">
        <?php 
          if(!isset($_GET['allowed_users'])){
            $this->require_once_file($this->plugin_dir.'/menus/restrictions/PieRegRestrictUsers.php');
          } else {
            $this->require_once_file($this->plugin_dir.'/menus/restrictions/PieRegAllowedUsers.php');
          }

         ?>
        
    </div> 
</div>
</div>