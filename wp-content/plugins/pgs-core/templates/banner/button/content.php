<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_banner'] );
extract( $atts );

// Button Classes
$button_wrap_classes = array(
	'pgscore_banner-btn-wrap',
);

if ( isset( $button_style ) && ! empty( $button_style ) ) {
	$button_wrap_classes[] = 'pgscore_banner-btn-style-' . $button_style;
}

if ( 'link' != $button_style ) {
	$button_wrap_classes[] = 'pgscore_banner-btn-size-' . $button_size;
}

if ( isset( $button_shape ) && ! empty( $button_shape ) ) {
	$button_wrap_classes[] = 'pgscore_banner-btn-shape-' . $button_shape;
}

$button_wrap_classes = implode( ' ', array_filter( array_unique( $button_wrap_classes ) ) );

// Button Classes
$button_classes = array(
	'pgscore_banner-btn',
	'inline_hover',
);
$button_classes = implode( ' ', array_filter( array_unique( $button_classes ) ) );

// Button Styles
$button_styles = array();
if ( ! empty( $button_text_color ) ) {
	$button_styles[] = "color:{$button_text_color}";
}

if ( ! empty( $button_text_transform ) ) {
	$button_styles[] = "text-transform:{$button_text_transform}";
}

if ( isset( $button_letter_spacing ) && 0 != $button_letter_spacing ) {
	$button_styles[] = "letter-spacing:{$button_letter_spacing}px";
}

if ( $button_line_height && '' != $button_line_height && pgscore_validate_css_unit( $button_line_height, array( 'px', 'em', '%' ) ) ) {
	$button_styles[] = "line-height: {$button_line_height}";
}

if ( isset( $button_style ) && 'border' == $button_style && isset( $button_border_width ) ) {
	$button_styles[] = "border-width:{$button_border_width}px";
}

if ( isset( $button_style ) && 'border' == $button_style && isset( $button_border_color ) ) {
	$button_styles[] = "border-color:{$button_border_color}";
}

if ( isset( $button_style ) && 'flat' == $button_style && isset( $button_color ) ) {
	$button_styles[] = "background-color:{$button_color}";
}

$button_styles = implode( ';', array_filter( array_unique( $button_styles ) ) );

$hover_styles = array();

if ( $button_hover_text_color && '' != $button_hover_text_color ) {
	$hover_styles['color'] = $button_hover_text_color;
}
if ( $button_hover_background_color && '' != $button_hover_background_color && 'flat' == $button_style ) {
	$hover_styles['background-color'] = $button_hover_background_color;
}
if ( $button_hover_border_color && '' != $button_hover_border_color && 'border' == $button_style ) {
	$hover_styles['border-color'] = $button_hover_border_color;
}

// Link Attributes
$additional_url_vars = array(
	'style' => $button_styles,
);
$button_attr         = pgscore_vc_link_attr( $link_url, $button_classes, $additional_url_vars );

if ( ! empty( $button_text ) && ! empty( $button_attr ) ) {
	?>
	<div class="<?php echo esc_attr( $button_wrap_classes ); ?>">
		<?php
		$hov_str  = ' data-hover_styles="' . esc_attr( json_encode( $hover_styles ) ) . '">';
		$btn_str  = '<a ';
		$btn_str .= wp_kses( $button_attr, pgscore_allowed_html( array( 'a' ) ) );
		$btn_str .= '>';

		$from = '>';
		$from = '/' . preg_quote( $from, '/' ) . '/';
		$to   = $hov_str;

		echo preg_replace( $from, $to, $btn_str, 1 );
		echo esc_html( $button_text );
		?>
		</a>	</div>
	<?php
}
