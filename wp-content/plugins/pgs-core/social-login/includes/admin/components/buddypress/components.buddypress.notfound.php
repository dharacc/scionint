<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_buddypress_notfound() {
	// HOOKABLE:
	do_action( "pgssl_component_buddypress_notfound_start" );
?> 
<style>
#pgssl_div_warn { 
	padding: 10px;  
	border: 1px solid #ddd; 
	background-color: #fff; 
	
	width: 55%;
	margin: 0px auto;
	margin-top:30px;
}
</style>
<div id="pgssl_div_warn">
	<h3 style="margin:0px;"><?php _pgssl_e("BuddyPress plugin not found!", 'pgssl-text-domain') ?></h3> 

	<hr />

	<p>
		<?php _pgssl_e('<a href="https://buddypress.org/" target="_blank">BuddyPress</a> was not found on your website. The plugin is be either not installed or disabled.', 'pgssl-text-domain') ?>
	</p>
</div>
<?php
	do_action( "pgssl_component_buddypress_notfound_end" );
}