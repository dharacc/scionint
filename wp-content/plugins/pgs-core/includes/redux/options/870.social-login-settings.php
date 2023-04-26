<?php
/**
 * Social Login Settings
 *
 * @package PGS Core
 */

$pgssl_settings_url = add_query_arg( array(
    'page' => 'pgssl_settings',
), admin_url( 'options-general.php' ) );

return array(
	'title'            => esc_html__( 'Social Login', 'pgs-core' ),
	'id'               => 'socail-login-settings',
	'customizer_width' => '400px',
	'icon'             => 'fa fa-share-alt',
	'fields'           => array(
		array(
			'id'       => 'social_login',
			'type'     => 'switch',
			'title'    => esc_html__( 'Socail Login', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enable/Disable social login.', 'pgs-core' ),
			'default'  => true,
		),
		array(
			'id'    => 'socail_login_setup',
			'type'  => 'info',
			'style' => 'info',
			'desc'       => sprintf(
				wp_kses(
					/* translators: %1$s: social login settings link */
					__( 'To enable and configure social login settings, click <a href="%1$s">here</a>.', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
						),
					)
				),
				esc_url( $pgssl_settings_url )
			),
			'required'       => array(
				array( 'social_login', '=', true ),
			),
		),
	),
);
