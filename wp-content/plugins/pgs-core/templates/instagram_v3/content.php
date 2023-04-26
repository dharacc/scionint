<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}

global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_instagram_v3'] );
extract( $atts );

$insta_classes = array(
	'insta_v3_wrapper',
	'insta_v3_style--' . $style,
	'insta_v3_list_type--' . $list_type,
);

$insta_classes = implode( ' ', array_filter( array_unique( $insta_classes ) ) );
?>
<div class="<?php echo esc_attr( $insta_classes ); ?>">
	<div class="insta_v3_content">
		<?php pgscore_get_shortcode_templates( 'instagram_v3/list_type/' . $list_type ); ?>
	</div>
</div>
