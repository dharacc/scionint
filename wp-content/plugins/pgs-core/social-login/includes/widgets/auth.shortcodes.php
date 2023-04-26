<?php
/**
 * pgs_social_login shortcode
 *
 * usage: [pgs_social_login enable_providers="facebook,google,twitter"]
 */
function pgssl_shortcode_pgs_social_login( $atts = array(), $content = null ) {
	$atts = shortcode_atts( array(
		'enable_providers' => '',
	), $atts, 'pgs_social_login' );
	
	if( is_user_logged_in() ) {
		return;
	}
	
	ob_start();
	?>
	<div class="pgssl-shortcode-login-wrapper">
		<?php pgssl_display_social_login( $atts ); ?>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'pgs_social_login', 'pgssl_shortcode_pgs_social_login' );