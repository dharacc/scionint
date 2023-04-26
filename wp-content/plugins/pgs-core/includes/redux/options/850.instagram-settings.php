<?php
/**
 * Instagram Settings
 *
 * @package PGS Core
 */

$pgs_instawp_settings_url = add_query_arg( array(
    'page' => 'pgs_instawp',
), admin_url( 'options-general.php' ) );

return array(
	'title'            => esc_html__( 'Instagram', 'pgs-core' ),
	'id'               => 'instagram-settings',
	'customizer_width' => '400px',
	'icon'             => 'el el-instagram',
	'fields'           => array(
		array(
			'id'    => 'pgs_instawp_setup',
			'type'  => 'info',
			'style' => 'info',
			'desc'       => sprintf(
				wp_kses(
					/* translators: %1$s: social login settings link */
					__( 'Instagram now requires a <b>Facebook App</b> to get <b>Instagram App ID/App Secret</b>. New Instagram settings are moved to a separate page. To configure the <b>Instagram App ID/App Secret</b> and other settings, click <a href="%1$s">here</a>.', 'pgs-core' ),
					array(
						'b' => array(),
						'a' => array(
							'href'   => true,
						),
					)
				),
				esc_url( $pgs_instawp_settings_url )
			),
		),
	),
);
