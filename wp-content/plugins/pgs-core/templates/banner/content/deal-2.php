<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_banner'] );
extract( $atts );

if ( ! empty( $list_items ) ) {
	$list_items = vc_param_group_parse_atts( $list_items );

	$list_item_sr = 0;
	foreach ( $list_items as $list_item ) {
		if ( isset( $list_item['title'] ) && ! empty( $list_item['title'] ) ) {
			$list_item_sr++;

			$list_item_classes   = array();
			$list_item_classes[] = 'pgscore_banner-text-wrap';
			$list_item_classes[] = 'pgscore_banner-text-wrap-' . $list_item_sr;
			if ( isset( $list_item['bg_color'] ) && ! empty( $list_item['bg_color'] ) ) {
				$list_item_classes[] = 'pgscore_banner-text-bg_color';
			}
			$text_show_hide = $list_item['text_show_hide'];

			$text_show_hide     = explode( ',', $text_show_hide ); // Convert to array
			$text1_hide_width   = array_diff( $show_hide_defaults, $text_show_hide ); // Get size which are not in provided list for hiding
			$text1_hide_width   = array_flip( $text1_hide_width ); // Reverse value to key
			$text1_hide_classes = array_intersect_key( $hide_classes, $text1_hide_width ); // get hide classes from hide widths
			if ( ! empty( $text1_hide_classes ) ) {
				$text1_hide_classes  = implode( ' ', $text1_hide_classes );
				$list_item_classes[] = $text1_hide_classes;
			}

			$list_item_classes = implode( ' ', array_filter( array_unique( $list_item_classes ) ) );

			// Text Style
			$text_style = array();
			if ( isset( $list_item['font_size'] ) && ! empty( $list_item['font_size'] ) ) {
				$font_size               = $list_item['font_size'];
				$font_size               = ( $font_size / 100 );
				$text_style['font-size'] = "font-size:{$font_size}em;";
			}
			if ( isset( $list_item['color'] ) && ! empty( $list_item['color'] ) ) {
				$color               = $list_item['color'];
				$text_style['color'] = "color:{$color};";
			}
			if ( isset( $list_item['bg_color'] ) && ! empty( $list_item['bg_color'] ) ) {
				$bg_color                       = $list_item['bg_color'];
				$text_style['background-color'] = "background-color:{$bg_color};";
			}

			if ( isset( $list_item['font_style'] ) && ! empty( $list_item['font_style'] ) ) {
				$font_style               = $list_item['font_style'];
				$text_style['font-style'] = "font-style:{$font_style};";
			}

			if ( isset( $list_item['font_weight'] ) && ! empty( $list_item['font_weight'] ) ) {
				$font_weight               = $list_item['font_weight'];
				$text_style['font-weight'] = "font-weight:{$font_weight};";
			}

			if ( isset( $list_item['text_transform'] ) && ! empty( $list_item['text_transform'] ) ) {
				$text_transform               = $list_item['text_transform'];
				$text_style['text-transform'] = "text-transform:{$text_transform};";
			}

			if ( isset( $list_item['letter_spacing'] ) && ! empty( $list_item['letter_spacing'] ) ) {
				$letter_spacing               = $list_item['letter_spacing'];
				$text_style['letter-spacing'] = "letter-spacing:{$letter_spacing}px;";
			}

			if ( isset( $list_item['line_height'] ) && ! empty( $list_item['line_height'] ) && pgscore_validate_css_unit( $list_item['line_height'], array( 'px', 'em', '%' ) ) ) {
				$line_height               = $list_item['line_height'];
				$text_style['line-height'] = "line-height:{$line_height};";
			}

			if ( isset( $list_item['use_google_font'] ) && $list_item['use_google_font'] = 'yes' ) {
				$google_font_css = ( isset( $list_item['banner_google_fonts'] ) ) ? pgscore_get_google_fonts_css( $list_item['banner_google_fonts'] ) : '';

				if ( ! empty( $google_font_css ) ) {
					$text_style = array_merge( $google_font_css, $text_style );
				}
			}

			$text_style = implode( ' ', array_filter( array_unique( $text_style ) ) );
			?>
			<div class="<?php echo esc_attr( $list_item_classes ); ?>">
				<div class="pgscore_banner-text" style="<?php echo esc_attr( $text_style ); ?>">
					<?php
					echo wp_kses(
						$list_item['title'],
						array(
							'br'   => array(),
							'span' => array(),
						)
					);
					?>
				</div>
			</div>
			<?php
		}
	}
}
pgscore_get_shortcode_templates( 'banner/button/content' );
if ( isset( $banner_link_enable ) && $banner_link_enable != true ) {
	pgscore_get_shortcode_templates( 'banner/deal/content' );
}
