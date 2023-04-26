<?php
if ( ! function_exists( 'ciyashop_is_activated' ) || ! ciyashop_is_activated() ) {
	return;
}

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {
	return;
}

global $pgscore_globals;

$theme_data   = $pgscore_globals['theme_data'];
$options_name = $pgscore_globals['options_name'];
$options_slug = $pgscore_globals['options_slug'];


// This line is only for altering the demo. Can be easily removed.
$options_name = apply_filters( 'redux_demo/opt_name', $options_name );

$footer_credit = sprintf(
	wp_kses(
		__( 'Developed By <a href="%1$s">%2$s</a>', 'pgs-core' ),
		array(
			'a' => array(
				'href' => true,
			),
		)
	),
	$theme_data->get( 'AuthorURI' ),
	$theme_data->get( 'Author' )
);


/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name'             => $options_name,                 // This is where your data is stored in the database and also becomes your global variable name.
	'display_name'         => $theme_data->get( 'Name' ),   // Name that appears at the top of your panel
	'display_version'      => $theme_data->get( 'Version' ), // Version that appears at the top of your panel
	'menu_type'            => 'submenu',                    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu'       => true,                         // Show the sections below the admin menu item or not

	'menu_title'           => esc_html__( 'Theme Options', 'pgs-core' ),
	'page_title'           => sprintf( esc_html__( '%s - Theme Options', 'pgs-core' ), $theme_data->get( 'Name' ) ),

	'google_api_key'       => '',                           // You will need to generate a Google API key to use this feature. Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_update_weekly' => false,                        // Set it you want google fonts to update weekly. A google_api_key value is required.
	'async_typography'     => true,                         // Must be defined to add google fonts to the typography module
	// Use a asynchronous font on the front end or font string
	// 'disable_google_fonts_link'=> true,                         // Disable this in case you want to create your own google fonts loader


	'admin_bar'            => true,                         // Show the panel pages on the admin bar
	'admin_bar_icon'       => 'dashicons-portfolio',        // Choose an icon for the admin bar menu
	'admin_bar_priority'   => 50,                           // Choose an priority for the admin bar menu

	'global_variable'      => $options_name,                 // Set a different name for your global variable other than the opt_name
	'dev_mode'             => false,                        // Show the time the page took to load, etc
	'update_notice'        => true,                         // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer'           => true,                         // Enable basic customizer support

	// 'open_expanded'            => true,                         // Allow you to start the panel in an expanded way initially.
	// 'disable_save_warn'        => true,                         // Disable the save warning when a user changes a field


	// OPTIONAL -> Give you extra features
	'page_priority'        => null,                         // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent'          => 'themes.php',                 // For a full list of options, visit: http://codex.wordpress.org  /Function_Reference/add_submenu_page#Parameters

	'page_permissions'     => 'manage_options',             // Permissions needed to access the options panel.
	'menu_icon'            => '',                           // Specify a custom URL to an icon

	'last_tab'             => '',                           // Force your panel to always open to a specific tab (by id)
	'page_icon'            => 'icon-themes',                // Icon displayed in the admin panel next to your menu_title
	'page_slug'            => $options_slug,                 // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
	'save_defaults'        => true,                         // On load save the defaults to DB before user clicks save or not
	'default_show'         => false,                        // If true, shows the default value next to each field that is not the default value.
	'default_mark'         => '*',                          // What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export'   => true,                         // Shows the Import/Export panel when not used as a field.


	// CAREFUL -> These options are for advanced use only
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,                         // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag'           => true,                         // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	'footer_credit'        => $footer_credit,               // Disable the footer credit of Redux. Please leave if you can help it.
	'intro_text'           => '',
	'footer_text'          => '',


	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database'             => '',                           // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'use_cdn'              => true,                         // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

	// HINTS
	'hints'                => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => '#dd3333',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'red',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	),
);

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = array(
	'id'    => 'potenza-website',
	'href'  => 'http://www.potenzaglobalsolutions.com',
	'title' => esc_html__( 'Potenza', 'pgs-core' ),
);

$args['admin_bar_links'][] = array(
	'href'  => 'https://potezasupport.ticksy.com/',
	'title' => esc_html__( 'Support', 'pgs-core' ),
);

$args['admin_bar_links'][] = array(
	'id'    => 'potenza-tf-profile',
	'href'  => 'https://themeforest.net/user/potenzaglobalsolutions',
	'title' => esc_html__( 'Themeforest Profile', 'pgs-core' ),
);


// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
	'url'   => 'https://www.facebook.com/potenzasolutions',
	'title' => esc_html__( 'Like us on Facebook', 'pgs-core' ),
	'icon'  => 'el el-facebook',
);
$args['share_icons'][] = array(
	'url'   => 'https://twitter.com/PotenzaGlobal',
	'title' => esc_html__( 'Follow us on Twitter', 'pgs-core' ),
	'icon'  => 'el el-twitter',
);
$args['share_icons'][] = array(
	'url'   => 'https://plus.google.com/+Potenzaglobalsolutions/posts',
	'title' => esc_html__( 'Follow us on Google+', 'pgs-core' ),
	'icon'  => 'el el-googleplus',
);
$args['share_icons'][] = array(
	'url'   => 'http://www.linkedin.com/company/potenza-global-solutions-pvt-ltd-',
	'title' => esc_html__( 'Find us on LinkedIn', 'pgs-core' ),
	'icon'  => 'el el-linkedin',
);
$args['share_icons'][] = array(
	'url'   => 'http://www.potenzaglobalsolutions.com/blogs/',
	'title' => esc_html__( 'Our Blog', 'pgs-core' ),
	'icon'  => 'el el-quotes',
);

Redux::setArgs( $options_name, $args );

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

$option_files = array(
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/100.layout-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/110.site-logo.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/120.sticky-header.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/130.1.site-preloader-option.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/130.2.back-to-top.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/200.0.header-section.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/200.1.site-header.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/200.2.topbar.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/200.4.search.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/250.0.page-header.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/251.0.page-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/300.0.footer.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/350.0.blog-post-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/350.1.blog-settings-.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/350.2.archive-sttings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/350.3.single-post.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/370.0.portfolio.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/400.color-scheme.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.0.woocommerce-section.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.1.products-listing.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.2.1.products-filter-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.2.single-product-setting.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.3.woocommerce-checkout.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.9.ciyashop-wishlist.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.4.product-quick-view.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.5.woocommerce-my-account.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.6.woocommerce-cookie-law-info.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.8.woocommerce_variable_products_attr.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/420.7.woocommerce-promo-popup.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/430.faq-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/500.0.site-info.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/500.1.social-profiles.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/500.2.site-contacts.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/500.3.opening-hours.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/600.social-sharing.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/700.0.typography.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/700.1.typography.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/750.extra-google-fonts.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/720.extra-google-fonts.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/800.404.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/850.instagram-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/870.social-login-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/900.performance.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/910.maintenance.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/920.custom-css-js.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/998.mailchimp-settings.php',
	trailingslashit( PGSCORE_PATH ) . 'includes/redux/options/999.sample-data.php',
);

$option_files = apply_filters( 'pgscore_redux_option_files', $option_files );

foreach ( $option_files as $option_file ) {
	if ( file_exists( $option_file ) ) {
		$option_data = include $option_file;
		if ( $option_data && is_array( $option_data ) ) {
			Redux::setSection( $options_name, $option_data );
		}
	}
}

/*
 * <--- END SECTIONS
 */
