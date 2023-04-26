<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

$background_ele_styles = array();

if ( isset( $backround_img ) && ! empty( $backround_img ) ) {
	$back_image_arr          = wp_get_attachment_image_src( $backround_img, 'full' );
	$background_ele_styles[] = 'background-image: url("' . esc_url( $back_image_arr[0] ) . '");';
}

$element_hover_styles = array();
if ( isset( $background_options ) && 'border' === $background_options ) {
	if ( isset( $border_hover_color ) && ! empty( $border_hover_color ) ) {
		$element_hover_styles['border-color'] = $border_hover_color;
	}
	$border_width = ( isset( $border_width ) && ! empty( $border_width ) ) ? $border_width : 1;
	if ( $border_width > 10 ) {
		$border_width = 10;
	}
	if ( isset( $border_color ) && ! empty( $border_color ) ) {
		$background_ele_styles[] = 'border: ' . $border_width . 'px solid ' . $border_color . ';';
	}
} else {
	if ( isset( $element_hover_color ) && ! empty( $element_hover_color ) ) {
		$element_hover_styles['background-color'] = $element_hover_color;
	}
	if ( isset( $element_back_color ) && ! empty( $element_back_color ) ) {
		$background_ele_styles[] = 'background-color:' . $element_back_color . ';';
	}
}


?>
<div class="pgscore_info_box_2-inner inline_hover clearfix" style="<?php echo esc_attr( implode( '', $background_ele_styles ) ); ?>" data-trigger_ele="pgscore_info_box_2-title" data-hover_styles="<?php echo esc_attr( json_encode( $element_hover_styles ) ); ?>">
	<div class="pgscore_info_box_2-icon">
		<div class="pgscore_info_box_2-icon-wrap">
			<?php
			pgscore_get_shortcode_templates( 'info_box_2/content-parts/title' );
			?>
		</div>
	</div>
	
	<div class="pgscore_info_box_2-content">
		<div class="pgscore_info_box_2-content-wrap">
			<div class="pgscore_info_box_2-content-inner">
				<?php
				pgscore_get_shortcode_templates( 'info_box_2/content-parts/content' );
				?>
			</div>
		</div>
	</div>
</div>
