<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_product_cat_carousel'] );
extract( $atts );

if ( $carousel_margin >= 50 ) {
	$carousel_margin = 50;
} elseif ( $carousel_margin <= 1 ) {
	$carousel_margin = 1;
}

$owl_options_args = array(
	'items'              => ( ! empty( $carousel_items_xl ) ) ? $carousel_items_xl : 3,
	'loop'               => false,
	'dots'               => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'pagination' === $slider_elements ),
	'nav'                => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'prevnext' === $slider_elements ),
	'margin'             => (int) $carousel_margin,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'smartSpeed'         => 1000,
	'responsive'         => array(
		'0'    => array(
			'items' => 1,
		),
		'576'  => array(
			'items' => ( ! empty( $carousel_items_sm ) ) ? $carousel_items_sm : 1,
		),
		'768'  => array(
			'items' => ( ! empty( $carousel_items_md ) ) ? $carousel_items_md : 2,
		),
		'992'  => array(
			'items' => ( ! empty( $carousel_items_lg ) ) ? $carousel_items_lg : 3,
		),
		'1200' => array(
			'items' => ( ! empty( $carousel_items_xl ) ) ? $carousel_items_xl : 3,
		),
	),
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = json_encode( $owl_options_args );

$category_title_styles       = array();
$category_hover_title_styles = array();

if ( isset( $category_title_font_size ) && ! empty( $category_title_font_size ) ) {
	if ( $category_title_font_size >= 80 ) {
		$category_title_font_size = 80;
	} elseif ( $category_title_font_size <= 10 ) {
		$category_title_font_size = 10;
	}
	$category_title_styles[] = 'font-size:' . $category_title_font_size . 'px;';
}
$category_count_styles = array();
if ( isset( $title_font_weight ) && ! empty( $title_font_weight ) ) { // title font-weight
	$category_title_styles[] = 'font-weight:' . $title_font_weight . ';';
}
if ( isset( $title_text_transform ) && ! empty( $title_text_transform ) ) { // title text-transform
	$category_title_styles[] = 'text-transform:' . $title_text_transform . ';';
}
if ( isset( $product_title_font_size ) && ! empty( $product_title_font_size ) ) {
	if ( $product_title_font_size >= 80 ) {
		$product_title_font_size = 80;
	} elseif ( $product_title_font_size <= 10 ) {
		$product_title_font_size = 10;
	}
	$category_count_styles[] = 'font-size:' . $product_title_font_size . 'px;';
}

// overlay styles for style-3 to style-6
$cat_overlay_style = array();
if ( isset( $category_background_color ) && ! empty( $category_background_color ) && ( ! in_array( $style, array( 'style-1', 'style-2' ) ) ) ) {
	$cat_overlay_style[] = 'background:' . $category_background_color . ';';
}

$overlay_element = '<div class="category-overlay"></div>';
if ( 'style-2' !== $style ) {
	if ( isset( $background_overlay ) && 'custom' === $background_overlay ) {
		if ( 'style-1' === $style && isset( $category_background_color ) && ! empty( $category_background_color ) ) {
			$overlay_element = '<div class="category-overlay" style="background: ' . $category_background_color . '"></div>';
		}
		if ( isset( $category_title_color ) && ! empty( $category_title_color ) ) { // title color
			$category_title_styles[] = 'color:' . $category_title_color . ';';
		}

		if ( isset( $product_title_color ) && ! empty( $product_title_color ) ) { // category counter color
			$category_count_styles[] = 'color:' . $product_title_color . ';';
		}

		// hover_styles
		if ( isset( $category_title_hover_color ) && ! empty( $category_title_hover_color ) ) {
			$category_hover_title_styles['color'] = $category_title_hover_color;
		}
	}
}
$border_style_2 = array();
if ( 'style-2' === $style ) { // Style 2
	if ( isset( $category_title_color_style_2 ) && ! empty( $category_title_color_style_2 ) ) { // title color
		$category_title_styles[] = 'color:' . $category_title_color_style_2 . ';';
	}

	if ( isset( $cat_count_color_style_2 ) && ! empty( $cat_count_color_style_2 ) ) { // category counter color
		$category_count_styles[] = 'color:' . $cat_count_color_style_2 . ';';
	}

	// hover_styles
	if ( isset( $category_title_hover_color_style_2 ) && ! empty( $category_title_hover_color_style_2 ) ) {
		$category_hover_title_styles['color'] = $category_title_hover_color_style_2;
	}

	// border styles
	if ( isset( $show_border_style_2 ) && $show_border_style_2 == true ) { // title font-size
		if ( isset( $border_width_style_2 ) ) {
			$border_width = $border_width_style_2;
			if ( $border_width_style_2 >= 10 ) {
				$border_width = 10;
			} elseif ( $border_width_style_2 <= 0 ) {
				$border_width = 0;
			}
			$border_style_2[] = 'border-width:' . $border_width . 'px;';
		}

		if ( isset( $border_color_style_2 ) && ! empty( $border_color_style_2 ) ) {
			$border_style_2[] = 'border-color:' . $border_color_style_2 . ';';
		}
		if ( isset( $border_style_style_2 ) && ! empty( $border_style_style_2 ) ) {
			$border_style_2[] = 'border-style:' . $border_style_style_2 . ';';
		}
	}
}
// html tag for category title
$tag = 'div';
if ( isset( $category_title_tag ) ) {
	$tag = $category_title_tag;
}
?>
<div class="pgs-core-category owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $product_cat_list as $category ) {
		$link_attr     = get_term_link( $category );
		$thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
		$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		if ( empty( $thumbnail_url ) ) {
			$thumbnail_url = apply_filters(
				'default_category_shortcode_img',
				array(
					get_template_directory_uri() . '/images/product-placeholder.jpg',
					'',
					'',
					'',
				)
			);
		}

		if ( $thumbnail_url && isset( $thumbnail_url[0] ) ) {
			$category_title = ( ! empty( $category->name ) ) ? esc_attr( $category->name ) : '';
			?>
			<div class="item">
				<div class="pgs-core-category-container">
					<div class="category-img-container" style="<?php echo esc_attr( implode( '', $border_style_2 ) ); ?>">
						<?php
						if ( 'style-1' === $style ) {
							echo $overlay_element; }
						?>
						<a href="<?php echo esc_url( $link_attr ); ?>" title="<?php esc_attr_e( $category_title ); ?>" >
						<?php
						if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
							echo '<img class="img-fluid center-block owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $thumbnail_url[0] ) . '" width="' . esc_attr( $thumbnail_url[1] ) . '" height="' . esc_attr( $thumbnail_url[2] ) . '" alt="' . esc_attr( $category_title ) . '">';
						} else {
							echo '<img class="img-fluid center-block" src="' . esc_url( $thumbnail_url[0] ) . '" width="' . esc_attr( $thumbnail_url[1] ) . '" height="' . esc_attr( $thumbnail_url[2] ) . '" alt="' . esc_attr( $category_title ) . '">';
						}
						?>
						</a>
					</div>
					<?php if ( $style == 'style-3' ) { ?>
					<div class="category-content-info">
					<?php } ?>
					<div class="category-content" style="<?php echo esc_attr( implode( '', $cat_overlay_style ) ); ?>">
						<?php
						if ( 'counter-up-title-bottom' === $title_counter_display ) {
							?>
								<?php if ( ! $hide_categories_count ) { ?>
								<span style="<?php echo esc_attr( implode( '', $category_count_styles ) ); ?>" class="product-count" >
									<?php echo esc_html( $category->count ); ?> <?php esc_html_e( 'Products', 'pgs-core' ); ?>
								</span>
								<?php } ?>
								<?php if ( ! empty( $category_title ) ) { ?>
								<<?php echo esc_html( $tag ); ?> class="category-title">
									<a class="inline_hover" data-hover_styles="<?php echo esc_attr( json_encode( $category_hover_title_styles ) ); ?>" style="<?php echo esc_attr( implode( '', $category_title_styles ) ); ?>" href="<?php echo esc_url( $link_attr ); ?>">
									  <?php echo esc_html( $category_title ); ?>
									</a>
								</<?php echo esc_html( $tag ); ?>>
									<?php
								}
						} else {
							if ( ! empty( $category_title ) ) {
								?>
									<<?php echo esc_html( $tag ); ?> class="category-title">
										<a class="inline_hover category-item-title" href="<?php echo esc_url( $link_attr ); ?>" data-hover_styles="<?php echo esc_attr( json_encode( $category_hover_title_styles ) ); ?>" style="<?php echo esc_attr( implode( '', $category_title_styles ) ); ?>">
											<?php echo esc_html( $category_title ); ?>
										</a>
									</<?php echo esc_html( $tag ); ?>>
									<?php
							}
							?>
								<?php if ( ! $hide_categories_count ) { ?>
								<span style="<?php echo esc_attr( implode( '', $category_count_styles ) ); ?>" class="product-count" >
									<?php echo esc_html( $category->count ); ?> <?php esc_html_e( 'Products', 'pgs-core' ); ?>
								</span>
								<?php } ?>
						<?php } ?>
					</div>
					
					<?php if ( 'style-3' === $style ) { ?>
					</div>    
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>
