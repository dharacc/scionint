<?php
/**
* Social networks configuration and setup
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_networks() {
	// HOOKABLE: 
	do_action( "pgssl_component_networks_start" );

	include "components.networks.setup.php";
	include "components.networks.sidebar.php"; 
?>
<form method="post" id="pgssl_setup_form" action="options.php">
	
	<?php settings_fields( 'pgssl_settings-group' ); ?>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
		
			<div id="postbox-container-2" class="postbox-container">
				
				<?php pgssl_component_networks_setup(); ?>
				
			</div><!-- #postbox-container-2 -->
			
			<div id="postbox-container-1" class="postbox-container">
				
				<?php pgssl_component_networks_sidebar(); ?>
				
			</div><!-- #postbox-container-1 -->
			
			
			
		</div><!-- #post-body -->

		<br class="clear">

	</div><!-- #poststuff -->
	
</form>
<?php
	// HOOKABLE: 
	do_action( "pgssl_component_networks_end" );
}

pgssl_component_networks();