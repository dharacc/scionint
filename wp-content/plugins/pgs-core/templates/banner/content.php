<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_banner'] );
extract( $atts );

$banner_style_data   = array();
$banner_classes      = array();
$banner_options_data = array();
$banner_padding_data = array();

if ( isset( $font_size_responsive ) && $font_size_responsive && $font_size_responsive == 'true' ) {
	$banner_options_data['font_size_responsive'] = true;
	$banner_options_data['font_size_xl']         = $font_size_xl;
	$banner_options_data['font_size_lg']         = $font_size_lg;
	$banner_options_data['font_size_md']         = $font_size_md;
	$banner_options_data['font_size_sm']         = $font_size_sm;
	$banner_options_data['font_size_xs']         = $font_size_xs;
} else {
	$banner_options_data['font_size_responsive'] = false;
}

$banner_options = '{}';
if ( is_array( $banner_options_data ) && ! empty( $banner_options_data ) ) {
	$banner_options = json_encode( $banner_options_data );
}

// Banner Style - Font Size
if ( ! empty( $font_size ) ) {
	$banner_style_data[] = 'font-size:' . esc_attr( $font_size ) . 'px;';
}

// Banner - Background Image
if ( ! empty( $banner_image ) ) {
	$banner_style_data[] = 'background-image: url("' . esc_url( $banner_image[0] ) . '");';
}

if ( ! isset( $style ) || empty( $style ) ) {
	$style = 'style-1';
}

if ( ! isset( $banner_effect ) || empty( $banner_effect ) ) {
	$banner_effect = 'none';
}

// Banner Classes
$banner_classes[] = 'pgscore_banner';
$banner_classes[] = esc_attr( 'pgscore_banner-style-' . $style );
$banner_classes[] = esc_attr( 'pgscore_banner-effect-' . $banner_effect );

$banner_style = '';
if ( ! empty( $banner_style_data ) ) {
	$banner_style = implode( ' ', array_filter( array_unique( $banner_style_data ) ) );
}
$banner_classes = implode( ' ', array_filter( array_unique( $banner_classes ) ) );

// Content Classes
$banner_css_class = '';

if ( isset( $banner_padding_responsive ) && $banner_padding_responsive != '' && $banner_padding_responsive == 'true' ) {
	$banner_padding_data['banner_padding_responsive'] = true;
	if ( isset( $banner_padding_xl ) && ! empty( $banner_padding_xl ) ) {
		$banner_padding_data['banner_padding_xl'] = vc_shortcode_custom_css_class( $banner_padding_xl );
	}
	if ( isset( $banner_padding_lg ) && ! empty( $banner_padding_lg ) ) {
		$banner_padding_data['banner_padding_lg'] = vc_shortcode_custom_css_class( $banner_padding_lg );
	}
	if ( isset( $banner_padding_md ) && ! empty( $banner_padding_md ) ) {
		$banner_padding_data['banner_padding_md'] = vc_shortcode_custom_css_class( $banner_padding_md );
	}
	if ( isset( $banner_padding_sm ) && ! empty( $banner_padding_sm ) ) {
		$banner_padding_data['banner_padding_sm'] = vc_shortcode_custom_css_class( $banner_padding_sm );
	}
	if ( isset( $banner_padding_xs ) && ! empty( $banner_padding_xs ) ) {
		$banner_padding_data['banner_padding_xs'] = vc_shortcode_custom_css_class( $banner_padding_xs );
	}
} else {
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
		$banner_css_class = vc_shortcode_custom_css_class( $banner_css, ' ' );
	}
}

$banner_padding_options = '{}';
if ( is_array( $banner_padding_data ) && ! empty( $banner_padding_data ) ) {
	$banner_padding_options = json_encode( $banner_padding_data );
}

$content_classes = array(
	'pgscore_banner-content',
);

if ( 'deal-2' === $style ) {
	$content_classes[] = 'pgscore_banner-content-hleft';
	$content_classes[] = 'pgscore_banner-content-vtop';
} else {
	$content_classes[] = 'pgscore_banner-content-' . $horizontal_align;
	$content_classes[] = 'pgscore_banner-content-' . $vertical_align;
}

$content_classes[] = $banner_css_class;
$content_classes   = implode( ' ', array_filter( array_unique( $content_classes ) ) );

if ( ( isset( $banner_link_enable ) && $banner_link_enable == true ) && ( isset( $banner_link_url ) && ! empty( $banner_link_url ) ) ) {

	$banner_link_url = vc_build_link( $banner_link_url );?>
	<a class="pgs_banner-link" href="<?php echo esc_url( $banner_link_url['url'] ); ?>" rel="alternate">
												<?php
}
?>
	<div class="<?php echo esc_attr( $banner_classes ); ?>" style="<?php echo esc_attr( $banner_style ); ?>" data-banner_options="<?php echo esc_attr( $banner_options ); ?>">
		
		<?php
		if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
			echo '<img class="pgscore_banner-image img-fluid inline ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" width="' . esc_attr( $banner_image[1] ) . '" height="' . esc_attr( $banner_image[2] ) . '" alt="' . esc_attr__( 'Banner', 'pgs-core' ) . '"  data-src="' . esc_url( $banner_image[0] ) . '">';
		} else {
			echo '<img class="pgscore_banner-image img-fluid inline" width="' . esc_attr( $banner_image[1] ) . '" height="' . esc_attr( $banner_image[2] ) . '" alt="' . esc_attr__( 'Banner', 'pgs-core' ) . '" src="' . esc_url( $banner_image[0] ) . '">';
		}
		?>
		
		<div class="<?php echo esc_attr( $content_classes ); ?>" data-banner_padding_options="<?php echo esc_attr( $banner_padding_options ); ?>">
			<div class="pgscore_banner-content-wrapper">
				<div class="pgscore_banner-content-inner-wrapper">
					<?php pgscore_get_shortcode_templates( 'banner/content/' . $style ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	if ( ( isset( $banner_link_enable ) && $banner_link_enable == true ) && ( isset( $banner_link_url ) && ! empty( $banner_link_url ) ) ) {
		?>
	</a><?php
	}?>
