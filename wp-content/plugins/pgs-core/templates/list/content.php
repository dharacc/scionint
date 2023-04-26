<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_list'] );
extract( $atts );

$icon_html  = $pgscore_shortcodes['pgscore_list']['icon_html'];
$list_items = $pgscore_shortcodes['pgscore_list']['list_items'];

// List Classes
$list_classes   = array();
$list_classes[] = 'pgscore_list list';

if ( 'true' == $add_icon && ! empty( $icon_html ) ) {
	$list_classes[] = 'list-unstyled';
}

if ( 'true' == $add_icon ) {
	if ( $icon_style_type ) {
		$list_classes[] = 'icon-style-type-' . $icon_style_type;
	}
	if ( $icon_shape && 'default' !== $icon_style_type ) {
		$list_classes[] = 'icon-shape-' . $icon_shape;
	}
} else {
	if ( $list_style_type ) {
		$list_classes[] = 'icon-list-type-' . $list_style_type;
	}
}
$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );

$element_tag_style = array();
if ( $list_font_weight ) {
	$element_tag_style[] = "font-weight:{$list_font_weight};";
}
if ( $list_text_transform ) {
	$element_tag_style[] = "text-transform:{$list_text_transform};";
}
if ( $list_title_color ) {
	$element_tag_style[] = "color:{$list_title_color};";
}
$element_tag_style = implode( ';', array_filter( array_unique( $element_tag_style ) ) );

$hover_text_styles = array();
if ( ! empty( $list_title_hover_color ) ) {
	$hover_text_styles['color'] = $list_title_hover_color;
}
$prehover_style = array();
if ( ! empty( $list_title_color ) ) {
	$prehover_style['color'] = $list_title_color;
}
?>

<ul class="<?php echo esc_attr( $list_classes ); ?>">
	<?php
	foreach ( $list_items as $list_item ) {
		if ( isset( $list_item['content'] ) && ! empty( $list_item['content'] ) ) {

			$link_attr = '';

			if ( ! empty( $list_item['content_link'] ) ) {
				$link_attr = pgscore_vc_link_attr( $list_item['content_link'] );
			}
			?>
			<li>

				<?php echo ( 'true' == $add_icon && ! empty( $icon_html ) ) ? wp_kses( $icon_html, pgscore_allowed_html( array( 'i', 'span' ) ) ) . ' ' : ''; ?>
				<?php if ( $link_attr ) { ?>

					<<?php echo esc_html( $list_element_tag ); ?> class="pgscore-list-info inline_hover" style="<?php echo esc_attr( $element_tag_style ); ?>" data-hover_styles="<?php echo esc_attr( json_encode( $hover_text_styles ) ); ?>" data-prehover_style="<?php echo esc_attr( json_encode( $prehover_style ) ); ?>">
						<a class="inline_hover" style="<?php echo esc_attr( $element_tag_style ); ?>" 
							data-hover_styles="<?php echo esc_attr( json_encode( $hover_text_styles ) ); ?>" 
							data-prehover_style="<?php echo esc_attr( json_encode( $prehover_style ) ); ?>" <?php echo $link_attr; ?>>
							<?php echo esc_html( $list_item['content'] ); ?>
						</a>
					</<?php echo esc_html( $list_element_tag ); ?>>

				<?php } else { ?>
					<<?php echo esc_html( $list_element_tag ); ?> class="pgscore-list-info " style="<?php echo esc_attr( $element_tag_style ); ?>">
					<?php echo esc_html( $list_item['content'] ); ?>
					</<?php echo esc_html( $list_element_tag ); ?>>
				<?php } ?>
			</li>
			<?php
		}
	}
	?>
</ul>
