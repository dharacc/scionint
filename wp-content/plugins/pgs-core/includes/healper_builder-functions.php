<?php

if ( ! function_exists( 'ciyashop_get_header_wrapper_classes' ) ) {
	function ciyashop_get_header_wrapper_classes( $name, $args ) {

		$wrapper_id = '';
		$el_option  = array();

		$default_config = array(
			'row_layout'                 => 'row_flex',
			'row_height_desktop'         => 40,
			'row_height_mobile'          => 40,
			'desktop_hide'               => false,
			'desktop_sticky'             => false,
			'mobile_hide'                => false,
			'mobile_sticky'              => false,
			'header_color_color'         => '',
			'header_color_link_color'    => '',
			'header_color_hover_color'   => '',
			'bg_settings_bg_image'       => '',
			'bg_settings_bg_src'         => '',
			'bg_settings_bg_color'       => '',
			'bg_settings_bg_repeat'      => 'inherit',
			'bg_settings_bg_size'        => 'inherit',
			'bg_settings_bg_attachment'  => 'inherit',
			'bg_settings_bg_position'    => 'inherit',
			'border_bottom_width'        => 0,
			'border_bottom_style'        => 'solid',
			'border_bottom_border_width' => 'full_width',
			'border_bottom_color'        => '',
			'element_id'                 => '',
			'element_class'              => '',
		);

		if ( ! empty( $args ) ) {
			foreach ( $args as $arg ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default_config, $el_option );

		$desktop_hide   = 'desktop-hide-off';
		$desktop_sticky = 'desktop-sticky-off';
		$mobile_hide    = 'mobile-hide-off';
		$mobile_sticky  = 'mobile-sticky-off';

		if ( $el_option['desktop_hide'] ) {
			$desktop_hide = 'desktop-hide-on';
		}
		if ( $el_option['desktop_sticky'] ) {
			$desktop_sticky = 'desktop-sticky-on';
		}
		if ( $el_option['mobile_hide'] ) {
			$mobile_hide = 'mobile-hide-on';
		}
		if ( $el_option['mobile_sticky'] ) {
			$mobile_sticky = 'mobile-sticky-on';
		}

		$classes = array( 'header-row', 'header-' . $name, 'row-layout-' . $el_option['row_layout'], $desktop_hide, $desktop_sticky, $mobile_hide, $mobile_sticky, $el_option['element_class'] );
		$classes = implode( ' ', $classes );

		if ( '' != $el_option['element_id'] ) {
			$id = $name . '_' . $el_option['element_id'];
		}

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="' . $name . '_' . $el_option['element_id'] . '"';
		}

		$attr = array(
			'id'    => $wrapper_id,
			'class' => $classes,
		);

		return $attr;
	}
}

if ( ! function_exists( 'header_builder_html_phone_number' ) ) {
	function header_builder_html_phone_number( $args ) {

		if ( empty( $args ) || ! class_exists( 'Redux' ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'phone-number';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['phone_number'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="phone_number_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$site_phone = ( isset( $ciyashop_options['site_phone'] ) && ! empty( $ciyashop_options['site_phone'] ) ) ? $ciyashop_options['site_phone'] : false;

		if ( $site_phone ) {

			if ( function_exists( 'icl_register_string' ) && function_exists( 'icl_t' ) ) {
				icl_register_string( 'chl_site_phone', $site_phone, $site_phone );
				$site_phone = icl_t( 'chl_site_phone', $site_phone, $site_phone );
			}

			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<a href="<?php echo esc_url( 'tel:' . $site_phone ); ?>"><i class="fas fa-phone-alt">&nbsp;</i><?php echo esc_html( $site_phone ); ?></a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_email' ) ) {
	function header_builder_html_email( $args ) {

		if ( empty( $args ) || ! class_exists( 'Redux' ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'email';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['email'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="email_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$site_email = ( isset( $ciyashop_options['site_email'] ) && ! empty( $ciyashop_options['site_email'] ) ) ? sanitize_email( $ciyashop_options['site_email'] ) : false;

		if ( $site_email ) {

			if ( function_exists( 'icl_register_string' ) && function_exists( 'icl_t' ) ) {
				icl_register_string( 'chl_site_email', $site_email, $site_email );
				$site_email = icl_t( 'chl_site_email', $site_email, $site_email );
			}

			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<a href="<?php echo esc_url( 'mailto:' . sanitize_email( $site_email ) ); ?>"><i class="fa fa-envelope-o">&nbsp;</i><?php echo sanitize_email( $site_email ); ?></a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_cart' ) ) {
	function header_builder_html_cart( $args ) {

		if ( empty( $args ) || ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		if ( isset( $ciyashop_options['hide_price_for_guest_user'] ) && $ciyashop_options['hide_price_for_guest_user'] && ! is_user_logged_in() ) {
			return;
		}

		$options       = $header_elements['cart'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'cart woo-tools-cart woo-tools-action';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
			'cart_icon'     => 'icon_1',
			'cart_style'    => 'cart_count',
		);

		foreach ( $args['cart'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		foreach ( $options['params'] as $params ) {
			if ( 'cart_icon' === $params['param_name'] ) {
				$ciyashop_cart_icon = $params['options'][ $el_option['cart_icon'] ];

				$ciyashop_cart_icon = apply_filters( 'ciyashop_cart_icon', $ciyashop_cart_icon );
			}
		}

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="cart_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'] . ' ' . $el_option['cart_style'];
		}

		$wrapper_class .= ' ' . $el_option['cart_style'];

		$cart_contents_count = WC()->cart->get_cart_contents_count();
		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo sprintf( esc_attr__( 'View Cart (%s)', 'pgs-core' ), $cart_contents_count ); ?>">
				<span class="cart-icon"><?php echo $ciyashop_cart_icon; ?></span>
				<?php
				if ( 'cart_count' === $el_option['cart_style'] || 'cart_subtotal' === $el_option['cart_style'] ) {
					ciyashop_header_cart_count();
				}
				?>
			</a>

			<?php
			if ( 'cart_both' === $el_option['cart_style'] ) {
				?>
				<span class="woo-cart-count">
					<span>
					<?php
					/* translators: %s: number of items in cart */
					echo sprintf( _n( '%s item', '%s items', $cart_contents_count, 'pgs-core' ), number_format_i18n( $cart_contents_count ) );
					?>
					</span>
				</span>
				<?php
			}

			if ( 'cart_subtotal' === $el_option['cart_style'] || 'cart_both' === $el_option['cart_style'] ) {
				?>
				<span class="woo-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
				<?php
			}
			?>

			<div class="cart-contents"><?php the_widget( 'WC_Widget_Cart', 'title=' ); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_compare' ) ) {
	function header_builder_html_compare( $args ) {

		global $header_elements, $ciyashop_options, $yith_woocompare;

		if ( empty( $args ) || empty( $yith_woocompare ) ) {
			return;
		}

		$options       = $header_elements['compare'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'compare woo-tools-compare';

		$default = array(
			'compare_icon'  => 'icon_1',
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['compare'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}
		$el_option = array_merge( $default, $el_option );

		foreach ( $options['params'] as $params ) {

			if ( 'compare_icon' === $params['param_name'] ) {
				$ciyashop_compare_icon = $params['options'][ $el_option['compare_icon'] ];
				$ciyashop_compare_icon = apply_filters( 'ciyashop_compare_icon', $ciyashop_compare_icon );
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="compare_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<a href="<?php echo esc_url( add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ); ?>" class="compare" rel="nofollow">
				<?php echo $ciyashop_compare_icon; ?>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_wishlist' ) ) {
	function header_builder_html_wishlist( $args ) {

		global $header_elements, $ciyashop_options;

		if ( empty( $args ) ) {
			return;
		}

		$options       = $header_elements['wishlist'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'wishlist woo-tools-wishlist';

		$default = array(
			'wishlist_icon' => 'icon_1',
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['wishlist'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		foreach ( $options['params'] as $params ) {
			if ( 'wishlist_icon' == $params['param_name'] ) {
				$ciyashop_wishlist_icon = $params['options'][ $el_option['wishlist_icon'] ];
				$ciyashop_wishlist_icon = apply_filters( 'ciyashop_wishlist_icon', $ciyashop_wishlist_icon );
			}
		}

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="wishlist_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		if ( class_exists( 'YITH_WCWL' ) ) {
			$yith_wcwl    = YITH_WCWL();
			$wishlist_url = $yith_wcwl->get_wishlist_url();
			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<a href="<?php echo esc_url( $wishlist_url ); ?>">
					<?php echo $ciyashop_wishlist_icon; ?>
					<span class="wishlist ciyashop-wishlist-count">
						<?php echo YITH_WCWL()->count_products(); ?>
					</span>
				</a>
			</div>
			<?php
		} else {
			if ( ( isset( $ciyashop_options['show_wishlist'] ) && $ciyashop_options['show_wishlist'] ) ) {
				$cs_wishlist  = new Ciyashop_Wishlist();
				$wishlist_url = ( isset( $ciyashop_options['cs_wishlist_page'] ) && ! empty( $ciyashop_options['cs_wishlist_page'] ) ) ? get_permalink( $ciyashop_options['cs_wishlist_page'] ) : '#';
				?>
				<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
					<a href="<?php echo esc_url( $wishlist_url ); ?>">
						<?php echo $ciyashop_wishlist_icon; ?>
						<span class="wishlist ciyashop-wishlist-count">
						<?php echo esc_html( $cs_wishlist->count_products() ); ?>
						</span>
					</a>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'header_builder_html_social_profile' ) ) {
	function header_builder_html_social_profile( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'social-profile social_profiles-wrapper';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['social_profile'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$ciyashop_social_profiles = ciyashop_social_profiles();

		if ( ! empty( $ciyashop_social_profiles ) && is_array( $ciyashop_social_profiles ) ) {
			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			$social_content = '<ul class="header-social_profiles">';
			foreach ( $ciyashop_social_profiles as $ciyashop_social_profile ) {
				$social_content .= '<li class="header-social_profile">';
				$social_content .= '<a href="' . esc_url( $ciyashop_social_profile['link'] ) . '" target="_blank">' . $ciyashop_social_profile['icon'] . '</a>';
				$social_content .= '</li>';
			}
			$social_content .= '</ul>';
			echo wp_kses_post( $social_content );
			?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_html_block' ) ) {
	function header_builder_html_html_block( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'html-block html-block-wrapper';

		$default = array(
			'html_block_id' => '',
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['html_block'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$html_block_id = $el_option['html_block_id'];
		if ( $html_block_id ) {
			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<?php echo pgs_get_html_block( $html_block_id ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_space' ) ) {
	function header_builder_html_space( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$options = $header_elements['space'];

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'space space-wrapper';

		foreach ( $args['space'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		foreach ( $options['params'] as $params ) {
			$default = isset( $params['default'] ) ? $params['default'] : 10;
			$unit    = isset( $params['unit'] ) ? $params['unit'] : 'px';
		}

		$default = array(
			'space_width'   => $default,
			'element_id'    => '',
			'element_class' => '',
		);

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$space_width = $el_option['space_width'];

		if ( $space_width ) {
			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>" style="<?php echo esc_attr( 'width:' . $space_width . $unit . ';' ); ?>"></div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_text_block' ) ) {
	function header_builder_html_text_block( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'text-block text-block-wrapper';

		$default = array(
			'textarea_html' => '',
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['text_block'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$text_block = urldecode( $el_option['textarea_html'] );
		if ( $text_block ) {

			if ( function_exists( 'icl_register_string' ) && function_exists( 'icl_t' ) ) {
				icl_register_string( 'chl_text_block', $text_block, $text_block );

				$text_block = icl_t( 'chl_text_block', $text_block, $text_block );
			}

			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<?php echo $text_block; ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_button' ) ) {
	function header_builder_html_button( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'button button-wrapper';

		$default = array(
			'button_title'        => '',
			'button_link'         => '#',
			'button_new_tab'      => false,
			'button_type'         => 'default',
			'button_title_type'   => 'normal',
			'button_color_scheme' => 'light',
			'button_size'         => 'default',
			'button_shape'        => 'square',
			'element_id'          => '',
			'element_class'       => '',
		);

		foreach ( $args['button'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		$wrapper_class .= ' button-stype-' . $el_option['button_type'];
		$wrapper_class .= ' button-title-style-' . $el_option['button_title_type'];
		$wrapper_class .= ' button-color-scheme-' . $el_option['button_color_scheme'];
		$wrapper_class .= ' button-size-' . $el_option['button_size'];
		$wrapper_class .= ' button-shape-' . $el_option['button_shape'];

		if ( isset( $el_option['button_title'] ) && ! empty( $el_option['button_title'] ) ) {
			$button_title = $el_option['button_title'];
			$button_link  = $el_option['button_link'];

			if ( function_exists( 'icl_register_string' ) && function_exists( 'icl_t' ) ) {
				icl_register_string( 'chl_button_title', $button_title, $button_title );
				icl_register_string( 'chl_button_title', $button_link, $button_link );

				$button_title = icl_t( 'chl_button_title', $button_title, $button_title );
				$button_link  = icl_t( 'chl_button_title', $button_link, $button_link );
			}

			?>
			<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
				<a href="<?php echo esc_url( $button_link ); ?>" <?php echo ( $el_option['button_new_tab'] ) ? 'target="_blank"' : ''; ?>>
					<?php echo esc_html( $button_title ); ?>
				</a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'header_builder_html_search' ) ) {
	function header_builder_html_search( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options       = $header_elements['search'];
		$el_option     = array();
		$temp_array    = array();
		$wrapper_id    = '';
		$wrapper_class = 'search';
		$search_id     = uniqid( 'search_popup-' );

		foreach ( $args['search'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$array_key = str_replace( '[]', '', $arg['name'] );
				if ( array_key_exists( $array_key, $el_option ) ) {
					$temp = $el_option[ $array_key ];
					if ( is_array( $temp ) ) {
						array_push( $el_option[ $array_key ], $arg['value'] );
					} else {
						$el_option[ $array_key ] = array();
						array_push( $el_option[ $array_key ], $temp, $arg['value'] );
					}
				} else {
					$el_option[ $array_key ] = $arg['value'];
				}
			}
		}

		foreach ( $options['params'] as $params ) {
			$search_type             = isset( $params['search_type'] ) ? $params['search_type'] : 'search_form';
			$search_icon             = isset( $params['search_icon'] ) ? $params['search_icon'] : 'search_icon';
			$search_input_placehlder = isset( $params['search_input_placehlder'] ) ? $params['search_input_placehlder'] : esc_html__( 'Enter Search Keyword...', 'pgs-core' );
			$search_box_shape        = isset( $params['search_box_shape'] ) ? $params['search_box_shape'] : 'square';
			$search_box_background   = isset( $params['search_box_background'] ) ? $params['search_box_background'] : 'default';
			$search_content_type     = isset( $params['search_content_type'] ) ? $params['search_content_type'] : 'all';
			$show_categories         = isset( $params['show_categories'] ) ? $params['show_categories'] : true;
			if ( ( isset( $el_option['search_type'] ) && 'search_icon' === $el_option['search_type'] ) && 'search_icon' === $params['param_name'] ) {
				$ciyashop_search_icon = $params['options'][ $el_option['search_icon'] ];
			}
		}

		$default = array(
			'search_id'               => $search_id,
			'search_type'             => $search_type,
			'search_icon'             => $search_icon,
			'search_input_placehlder' => $search_input_placehlder,
			'search_box_shape'        => $search_box_shape,
			'search_box_background'   => $search_box_background,
			'search_content_type'     => $search_content_type,
			'show_categories'         => $show_categories,
			'element_id'              => '',
			'element_class'           => '',
		);

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="social_profile_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		if ( 'search_icon' === $el_option['search_type'] ) {
			$wrapper_class .= ' search-button-wrap';
		} else {
			$wrapper_class .= ' search_form-wrap';
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			if ( 'search_icon' === $el_option['search_type'] ) {
				add_action(
					'wp_footer',
					function() use ( $el_option ) {
						global $header_elements;
						?>
						<div id="<?php echo esc_attr( $el_option['search_id'] ); ?>" class="modal fade ciyashop-search-element-popup" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<div class="modal-content-inner">
										<?php header_search_popup( $el_option ); ?>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				);
				?>
				<button type="button" class="btn btn-primary btn-lg search-button" data-toggle="modal" data-target="#<?php echo esc_attr( $search_id ); ?>">
					<?php echo $ciyashop_search_icon; ?>
				</button>
				<div class="search-element-mobile-view">
					<button type="button" class="btn btn-primary btn-lg mobile-search-button search-button">
						<?php echo $ciyashop_search_icon; ?>
					</button>
					<div class="mobile-search-wrap">
						<div class="header-search-wrap">
							<?php header_search_popup( $el_option ); ?>
						</div>
					</div>
				</div>
				<?php
			} else {
				header_search_popup( $el_option );
			}
			?>
		</div>
		<?php
	}
}

function header_search_popup( $el_option ) {

	global $header_el_search_form_index;

	if ( empty( $header_el_search_form_index ) ) {
		$header_el_search_form_index = 0;
	}

	$search_form_id          = 'header-el-search-' . $header_el_search_form_index++;
	$search_placeholder_text = $el_option['search_input_placehlder'];

	if ( function_exists( 'icl_register_string' ) && function_exists( 'icl_t' ) ) {
		icl_register_string( 'chl_search_placeholder_text', $search_placeholder_text, $search_placeholder_text );

		$search_placeholder_text = icl_t( 'chl_search_placeholder_text', $search_placeholder_text, $search_placeholder_text );
	}

	$search_form_classes = 'search_form-inner';

	if ( 'search_form' === $el_option['search_type'] ) {
		$search_form_classes .= ' search-shape-' . $el_option['search_box_shape'];
		$search_form_classes .= ' search-bg-' . $el_option['search_box_background'];
	}
	?>
	<div class="<?php echo esc_attr( $search_form_classes ); ?>">
		<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">	
			<?php
			if ( ( 'post' === $el_option['search_content_type'] || 'product' === $el_option['search_content_type'] ) && ( 'false' != $el_option['show_categories'] ) ) {
				$taxonomy = ( 'product' === $el_option['search_content_type'] ) ? 'product_cat' : 'category';
				?>
				<div class="search_form-category-wrap">
					<?php
					$search_category = '';
					if ( isset( $_GET['search_category'] ) && '' != $_GET['search_category'] ) {
						$search_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
					}

					$args = array(
						'type'         => 'post',
						'child_of'     => 0,
						'parent'       => '',
						'orderby'      => 'id',
						'order'        => 'ASC',
						'hide_empty'   => false,
						'hierarchical' => 1,
						'exclude'      => '',
						'include'      => '',
						'number'       => '',
						'taxonomy'     => $taxonomy,
						'pad_counts'   => false,
					);

					$product_categories = get_categories( $args );

					if ( count( $product_categories ) > 0 ) {
						?>

						<select name="search_category" class="search_form-category">
							<option value='' selected><?php esc_html_e( 'All Categories', 'pgs-core' ); ?></option>
							<?php
							foreach ( $product_categories as $cat ) {
								?>
								<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php echo selected( esc_attr( $cat->term_id ), $search_category ); ?>>
									<?php echo esc_html( $cat->name ); ?>
								</option>
								<?php
							}
							?>
						</select>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
			<div class="search_form-input-wrap">
				<?php
				if ( 'all' !== $el_option['search_content_type'] ) {
					?>
					<input type="hidden" name="post_type" value="<?php echo esc_attr( $el_option['search_content_type'] ); ?>"/>
					<?php
				}
				?>
				<label class="screen-reader-text" for="<?php echo esc_attr( $search_form_id ); ?>">
					<?php esc_html_e( 'Search for:', 'pgs-core' ); ?>
				</label>
				<div class="search_form-search-field">
					<input type="text" id="<?php echo esc_attr( $search_form_id ); ?>" class="form-control search-form" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="<?php echo esc_attr( $search_placeholder_text ); ?>" />
				</div>
				<div class="search_form-search-button">
					<input value="" type="submit">
				</div>				
			</div>			
			<div class="ciyashop-auto-compalte-default ciyashop-empty">
				<ul class="ui-front ui-menu ui-widget ui-widget-content search_form-autocomplete"></ul>
			</div>
		</form>		
	</div>

	<?php
	if ( ( isset( $el_option['show_keywords'] ) && 'true' == $el_option['show_keywords'] ) && ( isset( $el_option['search_content_type'] ) && 'product' == $el_option['search_content_type'] ) && ( isset( $el_option['search_type'] ) && 'search_icon' == $el_option['search_type'] ) ) {
		if ( ! empty( $el_option['search_keywords_title'] ) && ! empty( $el_option['keywords'] ) ) {
			$category_ids       = $el_option['keywords'];
			$product_categories = $terms = get_terms(
				'product_cat',
				array(
					'include' => $category_ids,
					'orderby' => 'include',
				)
			);

			if ( ! is_wp_error( $product_categories ) ) {
				?>
				<div class="search_form-keywords-wrap">
					<div class="search_form-keywords-title">
						<?php echo esc_html( $el_option['search_keywords_title'] ); ?>
					</div>
					<div class="search_form-keywords">
						<ul class="search_form-keywords-list">
							<?php
							foreach ( $product_categories as $product_category ) {
								?>
								<li class="search_form-keyword-single">
									<a href="<?php echo esc_url( get_term_link( $product_category->term_id ) ); ?>" class="search-keyword" ><?php echo esc_html( $product_category->name ); ?></a>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'header_builder_html_divider' ) ) {
	function header_builder_html_divider( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options = $header_elements['divider'];

		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'divider divider-wrapper';

		foreach ( $args['divider'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		foreach ( $options['params'] as $params ) {
			$default = isset( $params['default'] ) ? $params['default'] : false;
		}

		$default = array(
			'divider_full_height' => $default,
			'element_id'          => '',
			'element_class'       => '',
		);

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="divider_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		if ( $el_option['divider_full_height'] ) {
			$wrapper_class .= ' divider-full-height';
		} else {
			$wrapper_class .= ' divider-default';
		}
		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>"></div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_account' ) ) {
	function header_builder_html_account( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options       = $header_elements['account'];
		$el_option     = array();
		$account_html  = '';
		$wrapper_id    = '';
		$wrapper_class = 'account account-wrapper';

		$default = array(
			'account_icon'  => 'icon_1',
			'account_text'  => '',
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['account'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}
		$el_option = array_merge( $default, $el_option );

		foreach ( $options['params'] as $params ) {
			if ( 'account_icon' == $params['param_name'] ) {
				$ciyashop_account_icon = $params['options'][ $el_option['account_icon'] ];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="compare_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}
		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			if ( ! is_user_logged_in() ) {
				if ( class_exists( 'WooCommerce' ) ) {
					if ( isset( $el_option['show_register_form'] ) && $el_option['show_register_form'] ) {
						$account_html = '<a href="javascript:void(0);" data-toggle="modal" data-target="#pgs_login_form">' . $ciyashop_account_icon . ' ' . esc_html( $el_option['account_text'], 'pgs-core' ) . '</a>';
					} else {
						$account_html = '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . $ciyashop_account_icon . ' ' . esc_html( $el_option['account_text'], 'pgs-core' ) . '</a>';
					}
				} else {
					$account_html = '<a href="' . esc_url( wp_login_url( home_url() ) ) . '" title="Login">' . $ciyashop_account_icon . ' ' . esc_html( $el_option['account_text'], 'pgs-core' ) . '</a>';
				}
			} elseif ( is_user_logged_in() ) {

				echo $ciyashop_account_icon;

				if ( class_exists( 'WooCommerce' ) ) {
					$account_html  = '<div class="ciyashop-myaccount">';
					$account_html .= '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" title="' . esc_attr__( 'My Account', 'pgs-core' ) . '" class="myaccount">' . esc_html__( 'My Account', 'pgs-core' ) . '</a>';
					$account_html .= '</div>';
				}

				$account_html .= '<a href="' . esc_url( wp_logout_url( home_url() ) ) . '" title="' . esc_attr__( 'Logout', 'pgs-core' ) . '" class="logout">' . esc_html__( 'Logout', 'pgs-core' ) . '</a>';
			}

			echo $account_html;
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_logo' ) ) {
	function header_builder_html_logo( $args ) {

		if ( empty( $args ) || ! class_exists( 'Redux' ) ) {
			return;
		}

		global $header_elements, $ciyashop_options;

		$options                  = $header_elements['logo'];
		$el_option                = array();
		$site_title_wrapper_id    = '';
		$site_title_wrapper_class = 'site-title-wrapper';
		$site_title_el            = is_front_page() ? 'h1' : 'div';
		$site_title_class         = is_front_page() ? 'site-title' : 'site-title';
		$site_title_class         = apply_filters( 'ciyashop_site_title_class', $site_title_class );

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['logo'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$site_title_wrapper_id .= 'id="logo_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$site_title_wrapper_class .= ' ' . $el_option['element_class'];
		}

		do_action( 'ciyashop_before_site_title_wrapper_start' );
		?>
		<div <?php echo esc_attr( $site_title_wrapper_id ); ?> class="<?php echo esc_attr( $site_title_wrapper_class ); ?>">
			<?php do_action( 'ciyashop_after_site_title_wrapper_start' ); ?>

			<<?php echo esc_attr( $site_title_el ); ?> class="<?php echo esc_attr( $site_title_class ); ?>">

				<?php do_action( 'ciyashop_before_site_title_link' ); ?>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

					<?php do_action( 'ciyashop_before_site_title' ); ?>

					<?php do_action( 'ciyashop_site_title' ); ?>

					<?php do_action( 'ciyashop_after_site_title' ); ?>

				</a>

				<?php do_action( 'ciyashop_after_site_title_link' ); ?>

			</<?php echo esc_attr( $site_title_el ); ?>>

			<?php do_action( 'ciyashop_before_site_title_wrapper_end' ); ?>
		</div>
		<?php
		do_action( 'ciyashop_after_site_title_wrapper_end' );
	}
}

if ( ! function_exists( 'header_builder_html_language' ) ) {
	function header_builder_html_language( $args ) {
		global $header_elements;

		if ( ! ciyashop_check_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && function_exists( 'icl_get_languages' ) ) {
			return;
		}

		$options       = $header_elements['language'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'language language-wrapper';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['language'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="language_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= $el_option['element_class'];
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php ciyashop_get_multi_lang(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_primary_menu' ) ) {
	function header_builder_html_primary_menu( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options       = $header_elements['primary_menu'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'primary-menu-wrapper';

		$default = array(
			'menu_alignment' => 'left',
			'element_id'     => '',
			'element_class'  => '',
		);

		foreach ( $args['primary_menu'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		$wrapper_class .= ' menu-alignment-' . $el_option['menu_alignment'];

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="primary_menu_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			do_action( 'ciyashop_before_header_nav' );
			?>
				<div class="primary-nav">
					<div class="header-nav-wrapper">
						<nav id="site-navigation" class="main-navigation">
							<?php
							$menu_obj        = $cs_mega_menu_enable = '';
							$theme_locations = get_nav_menu_locations();
							if ( isset( $theme_locations['primary'] ) ) {
								$menu_obj = get_term( $theme_locations['primary'], 'nav_menu' );
							}

							if ( isset( $menu_obj->term_id ) && $menu_obj->term_id ) {
								$menu_id             = $menu_obj->term_id;
								$cs_mega_menu_enable = get_post_meta( $menu_id, 'cs_megamenu_enable', true );
							}

							$primary_args = array(
								'theme_location'  => 'primary',
								'menu_class'      => 'menu primary-menu',
								'menu_id'         => 'primary-menu',
								'container'       => false,
								'container_id'    => 'menu-wrap-primary',
								'container_class' => 'menu-wrap',
							);

							if ( 'true' == $cs_mega_menu_enable ) {
								$primary_args['menu_class'] = $primary_args['menu_class'] . ' pgs_megamenu-enable';
								$primary_args['walker']     = new CiyaShop_Walker_Nav_Menu();
							}

							if ( has_nav_menu( 'primary' ) ) {
								wp_nav_menu( $primary_args );
							}
							?>
						</nav>
					</div>
				</div>
				<?php
				do_action( 'ciyashop_after_header_nav' );
				?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'header_builder_html_mobile_menu' ) ) {
	function header_builder_html_mobile_menu( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options       = $header_elements['mobile_menu'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = 'mobile-menu-wrapper';

		$default = array(
			'menu_alignment' => 'left',
			'element_id'     => '',
			'element_class'  => '',
		);

		foreach ( $args['mobile_menu'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		$wrapper_class .= ' menu-alignment-' . $el_option['menu_alignment'];

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="mobile_menu_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			do_action( 'ciyashop_before_header_nav' );
			?>
				<div class="primary-nav">
					<div class="header-nav-wrapper">
						<nav id="site-navigation-mobile">
							<?php
							if ( has_nav_menu( 'mobile_menu' ) ) {
								wp_nav_menu(
									array(
										'theme_location'  => 'mobile_menu',
										'menu_class'      => 'menu primary-menu-mobile',
										'menu_id'         => 'primary-menu-mobile',
										'container'       => false,
										'container_id'    => 'menu-wrap-primary-mobile',
										'container_class' => 'mobile-menu-wrap',
									)
								);
							} else {
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'menu_class'   => 'menu primary-menu',
											'menu_id'      => 'primary-menu',
											'container'    => false,
											'container_id' => 'menu-wrap-primary',
											'container_class' => 'menu-wrap',
										)
									);
								} else {
									wp_page_menu(
										array(
											'theme_location' => 'primary',
											'menu_id'    => false,
											'menu_class' => 'menu primary-menu',
											'container'  => 'div',
											'before'     => '<ul id="primary-menu" class="menu primary-menu nav-menu">',
											'after'      => '</ul>',
											'walker'     => new CiyaShop_Page_Nav_Walker(),
										)
									);
								}
							}
							?>
						</nav>
					</div>
				</div>
				<?php
				do_action( 'ciyashop_after_header_nav' );
				?>
			<div id="site-navigation-sticky-mobile-wrapper">
				<div id="site-navigation-sticky-mobile"></div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_menu' ) ) {
	function header_builder_html_menu( $args ) {

		if ( empty( $args ) ) {
			return;
		}

		global $header_elements;

		$options = $header_elements['menu'];

		$el_option     = array();
		$menu_bg_color = '';
		$wrapper_id    = '';
		$wrapper_class = 'menu-wrapper';

		$default = array(
			'menu'           => '',
			'menu_type'      => 'inline',
			'menu_alignment' => 'left',
			'menu_bg_color'  => '',
			'element_id'     => '',
			'element_class'  => '',
		);

		foreach ( $args['menu'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' == $el_option['menu'] ) {
			return;
		}

		$menu           = $el_option['menu'];
		$wrapper_class .= ' menu-style-' . $el_option['menu_type'];
		$wrapper_class .= ' menu-alignment-' . $el_option['menu_alignment'];
		$menu_object    = wp_get_nav_menu_object( $menu );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="menu_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= ' ' . $el_option['element_class'];
		}

		if ( isset( $el_option['hide_for_tablet'] ) && 'dropdown' === $el_option['menu_type'] ) {
			$wrapper_class .= ' menu-tablet-hide';
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php
			if ( 'dropdown' === $el_option['menu_type'] ) {
				if ( $el_option['menu_bg_color'] ) {
					$menu_bg_color .= 'style=background-color:' . $el_option['menu_bg_color'];
				}

				$menu_object = wp_get_nav_menu_object( $menu );
				do_action( 'ciyashop_before_category_menu_wrapper' );
				if ( $menu_object ) {
					?>
					<div class="category-nav">
						<div class="category-nav-wrapper">
							<div class="category-nav-title" <?php echo esc_attr( $menu_bg_color ); ?>>
								<i class="fa fa-bars"></i> <?php echo apply_filters( 'ciyashop_category_menu_title', $menu_object->name ); ?> <span class="arrow"><i class="fa fa-angle-down fa-indicator"></i></span>
							</div>
							<div class="category-nav-content">
								<?php
								wp_nav_menu(
									array(
										'menu_class'      => 'vertical-menu categories-menu',
										'menu'            => $menu,
										'container'       => 'div',
										'container_class' => 'vertical-menu-container menu-category-menu-container',
									)
								);
								?>
							</div>
						</div>
					</div>
					<?php
				}
				do_action( 'ciyashop_after_category_menu_wrapper' );
			} else {
				do_action( 'ciyashop_before_header_nav' );
				?>
					<div class="header-nav-wrapper">
						<nav class="main-navigation site-navigation">
							<?php
							$menu_args = array(
								'menu_class'      => 'ciyashop-secondary-menu ',
								'menu'            => $menu,
								'container'       => false,
								'container_class' => 'menu-wrap',
							);
							wp_nav_menu( $menu_args );
							?>
						</nav>
					</div>
					<?php
					do_action( 'ciyashop_after_header_nav' );
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'header_builder_html_currency' ) ) {
	function header_builder_html_currency( $args ) {

		global $header_elements, $WOOCS, $post;

		if ( empty( $args ) || empty( $WOOCS ) ) {
			return;
		}

		$options       = $header_elements['currency'];
		$el_option     = array();
		$wrapper_id    = '';
		$wrapper_class = '';

		$default = array(
			'element_id'    => '',
			'element_class' => '',
		);

		foreach ( $args['currency'] as $arg ) {
			if ( isset( $arg['name'] ) ) {
				$el_option[ $arg['name'] ] = $arg['value'];
			}
		}

		$el_option = array_merge( $default, $el_option );

		if ( '' != $el_option['element_id'] ) {
			$wrapper_id .= 'id="currency_' . $el_option['element_id'] . '"';
		}

		if ( '' != $el_option['element_class'] ) {
			$wrapper_class .= $el_option['element_class'];
		}

		?>
		<div <?php echo esc_attr( $wrapper_id ); ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<form method="post" action="#" class="woocommerce-currency-switcher-form" data-ver="<?php echo esc_attr( WOOCS_VERSION ); ?>">
				<input type="hidden" name="woocommerce-currency-switcher" value="<?php echo esc_attr( $WOOCS->current_currency ); ?>" />
				<select name="woocommerce-currency-switcher" class="ciyashop-woocommerce-currency-switcher ciyashop-select2" onchange="woocs_redirect(this.value);void(0);">
					<?php
					foreach ( $WOOCS->get_currencies() as $key => $currency ) {
						$option_txt  = apply_filters( 'woocs_currname_in_option', $currency['name'] );
						$option_txt .= ' (' . $currency['symbol'] . ')';
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $WOOCS->current_currency, $key ); ?>>
							<?php echo esc_html( $option_txt ); ?>
						</option>
						<?php
					}
					?>
				</select>
			</form>
		</div>
		<?php

	}
}
