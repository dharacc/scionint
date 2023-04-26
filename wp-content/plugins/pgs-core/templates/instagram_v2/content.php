<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_instagram_v2'] );
extract( $atts );

$title_void = ( $show_title && $show_title == 'true' && $title );

$btn_attr  = '';
$follow_us = '';

if ( $username ) {
	switch ( substr( $username, 0, 1 ) ) {
		case '#':
			$follow_us = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
			break;

		default:
			$follow_us = 'https://instagram.com/' . str_replace( '@', '', $username );
			break;
	}
}

if ( $follow_us ) {
	$btn_attr = 'href="' . esc_url( $follow_us ) . '"';
}

$button_void = ( $show_button == 'true' && $button_text && $btn_attr );

$header_void = ( $title_void || $button_void );

$insta_classes = array(
	'insta_v2_wrapper',
	'insta_v2_style--' . $style,
	'insta_v2_list_type--' . $list_type,
	'insta_v2_' . ( $header_void ? 'with' : 'without' ) . '_header',
);

$insta_classes = implode( ' ', array_filter( array_unique( $insta_classes ) ) );
?>
<div class="<?php echo esc_attr( $insta_classes ); ?>">
	<?php
	$insta_v2_header_classes = array( 'insta_v2_header' );

	$insta_v2_header_classes[] = 'insta_v2_header_' . ( $title_void ? 'with' : 'without' ) . '_title';
	$insta_v2_header_classes[] = 'insta_v2_header_' . ( $button_void ? 'with' : 'without' ) . '_button';

	$insta_v2_header_classes = implode( ' ', array_filter( array_unique( $insta_v2_header_classes ) ) );
	if ( $title_void || $button_void ) {
		?>
		<div class="<?php echo esc_attr( $insta_v2_header_classes ); ?>">
			<?php
			if ( $title_void ) {
				?>
				<div class="insta_v2_header--title">
					<?php echo wp_kses( "<{$title_el} class=\"insta_v2_title\">{$title}</{$title_el}>", pgscore_allowed_html( array( 'h2', 'h3', 'h4', 'h5', 'h6' ) ) ); ?>
				</div>
				<?php
			}
			if ( $button_void ) {
				?>
				<div class="insta_v2_header--button">
					<?php echo wp_kses( '<a ' . $btn_attr . '>' . ( $show_icon ? '<i class="fab fa-instagram"></i>' : '' ) . $button_text . '</a>', pgscore_allowed_html( array( 'a', 'i' ) ) ); ?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
	<div class="insta_v2_content">
		<?php pgscore_get_shortcode_templates( 'instagram_v2/list_type/' . $list_type ); ?>
	</div>
</div>
