<?php
return array(
	'title'  => esc_html__( 'MailChimp Settings', 'pgs-core' ),
	'id'     => 'mailchimp_settings',
	'icon'   => 'fa fa-envelope',
	'fields' => array(
		array(
			'id'    => 'mailchimp_api_key',
			'type'  => 'text',
			'title' => esc_html__( 'MailChimp API Key', 'pgs-core' ),
			'desc'  => esc_html__( 'Enter MailChimp API Key here.', 'pgs-core' ),
		),
		array(
			'id'    => 'mailchimp_list_id',
			'type'  => 'text',
			'title' => esc_html__( 'MailChimp List ID', 'pgs-core' ),
			'desc'  => esc_html__( 'Enter MailChimp List ID here.', 'pgs-core' ),
		),
	),
);
