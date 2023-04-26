<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {
	return array(
		'id'               => 'woocommerce_cookie_law_info',
		'title'            => esc_html__( 'Cookie Law Info', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'cookies_info',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show Cookies Info', 'pgs-core' ),
				'subtitle' => esc_html__( 'Under EU privacy regulations, websites must make it clear to visitors what information about them is being stored. This specifically includes cookies. Turn on this option and user will see info box at the bottom of the page that your web-site is using cookies.', 'pgs-core' ),
				'default'  => true,
			),
			array(
				'id'       => 'cookies_text',
				'type'     => 'editor',
				'title'    => esc_html__( 'Popup Text', 'pgs-core' ),
				'subtitle' => esc_html__( 'Place here some information about cookies usage that will be shown in the popup.', 'pgs-core' ),
				'default'  => esc_html__( 'We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.', 'pgs-core' ),
				'required' => array( 'cookies_info', '=', 1 ),
			),
			array(
				'id'       => 'cookies_policy_page',
				'type'     => 'select',
				'title'    => esc_html__( 'Page with Details', 'pgs-core' ),
				'subtitle' => esc_html__( 'Choose page that will contain detailed information about your Privacy Policy', 'pgs-core' ),
				'data'     => 'pages',
				'required' => array( 'cookies_info', '=', 1 ),
			),
		),
	);
}
