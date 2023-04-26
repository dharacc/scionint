<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_buddypress_sidebar() {
	$sections = array(
		'what_is_this' => 'pgssl_component_buddypress_sidebar_what_is_this',
	);

	$sections = apply_filters( 'pgssl_component_buddypress_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_buddypress_sidebar_sections', $action );
	}

	// HOOKABLE: 
	do_action( 'pgssl_component_buddypress_sidebar_sections' );
}

function pgssl_component_buddypress_sidebar_what_is_this() {
?>
<div class="postbox">
	<div class="inside">
		<h3><?php _pgssl_e("BuddyPress integration", 'pgssl-text-domain') ?></h3>

		<div style="padding:0 20px;">
			<p>
				<?php _pgssl_e( 'PGS Social Login can be now fully integrated with your <a href="https://buddypress.org" target="_blank">BuddyPress</a> installation. When enabled, user avatars display should work right out of the box with most WordPress themes and your BuddyPress installation', 'pgssl-text-domain') ?>.
			</p> 

			<p>
				<?php _pgssl_e( 'PGS Social Login also comes with BuddyPress xProfiles mappings. When this feature is enabled, PGS Social Login will try to automatically fill in Buddypress users profiles from their social networks profiles', 'pgssl-text-domain') ?>.
			</p> 
		</div>
	</div>
</div>
<?php
}