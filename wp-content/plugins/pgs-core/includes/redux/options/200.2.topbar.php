<?php
return array(
	'title'            => esc_html__( 'Topbar', 'pgs-core' ),
	'id'               => 'appearance_subsection_topbar',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'    => 'cs_topbar_info',
			'type'  => 'info',
			'title' => __( 'Notice', 'pgs-core' ),
			'style' => 'warning',
			'icon'  => 'el el-info-circle',
			'desc'  => esc_html__( 'These Settings are not applicable for custom header, for the custom header, you can use header builder.', 'pgs-core' ),
		),
		array(
			'id'      => 'topbar_enable',
			'type'    => 'switch',
			'title'   => esc_html__( 'Topbar', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'       => 'topbar_mobile_enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Topbar Mobile', 'pgs-core' ),
			'default'  => true,
			'required' => array(
				array( 'topbar_enable', '=', 1 ),
			),
		),
		array(
			'id'          => 'topbar_layout',
			'type'        => 'sorter',
			'title'       => 'Layout',
			'subtitle'    => 'Select layout contents.',
			'description' => '<p>'
				. '<strong>' . esc_html__( 'Notes', 'pgs-core' ) . ':</strong>'
				. '<ol>'
				. '<li>' . sprintf(
					wp_kses(
						__( '<strong>Language</strong>: This content is <a href="%1$s" target="_blank">WPML</a> dependant and it will be available only if <a href="%1$s" target="_blank">WPML</a> is installed.', 'pgs-core' ),
						array(
							'a'      => array(
								'href'   => true,
								'target' => true,
							),
							'strong' => true,
						)
					),
					'https://wpml.org/'
				) . '</li>'
				. '<li>' . sprintf(
					wp_kses(
						__( '<strong>Currency</strong>: This content is <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> dependant and it will be available only if <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> is installed.', 'pgs-core' ),
						array(
							'a'      => array(
								'href'   => true,
								'target' => true,
							),
							'strong' => true,
						)
					),
					'https://wordpress.org/plugins/woocommerce-currency-switcher/'
				) . '</li>'
				. '<li>' . wp_kses(
					__( '<strong>Phone Number/Email</strong>: You can manage phone number and email in <strong>"Site Info"</strong> tab in <strong>CiyaShop Theme Settings</strong>.', 'pgs-core' ),
					array(
						'strong' => array(),
					)
				) . '</li>'
				. '<li>' . wp_kses(
					__( '<strong>Topbar Menu</strong>: You can manage topbar menu from <strong>Appearance > Menus</strong>.', 'pgs-core' ),
					array(
						'strong' => array(),
					)
				) . '</li>',
			'options'     => array(
				'Left'            => array(
					'language'     => esc_html__( 'Language', 'pgs-core' ),
					'currency'     => esc_html__( 'Currency', 'pgs-core' ),
					'phone_number' => esc_html__( 'Phone Number', 'pgs-core' ),
				),
				'Right'           => array(
					'topbar_menu' => esc_html__( 'Topbar Menu', 'pgs-core' ),
				),
				'Available Items' => array(
					'email'           => esc_html__( 'Email', 'pgs-core' ),
					'social_profiles' => esc_html__( 'Social Profiles', 'pgs-core' ),
				),
			),
			'limits'      => array(),
			'required'    => array(
				array( 'topbar_enable', '=', 1 ),
			),
		),
	),
);
