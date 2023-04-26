<?php
/********************************************************************
 *
 * Front CSS and JS
 *
 ********************************************************************/
add_action( 'wp_enqueue_scripts', 'pgscore_front_styles', 5 );
function pgscore_front_styles( $hook ) {

	// Gravity Form - Font Awesome Fix
	if ( class_exists( 'GFForms' ) ) {
		wp_deregister_style( 'gform_font_awesome' );
		wp_register_style( 'gform_font_awesome', get_parent_theme_file_uri( '/fonts/font-awesome/css/all.min.css' ) );
	}
}

add_action( 'wp_enqueue_scripts', 'pgscore_front_scripts' );
function pgscore_front_scripts( $hook ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'cloudimage-360-view', trailingslashit( PGSCORE_URL ) . 'js/cloudimage-360-view' . $suffix . '.js', array(), '', true );

	global $post, $ciyashop_options;
	if ( isset( $ciyashop_options['smart-product'] ) && $ciyashop_options['smart-product'] ) {
		if ( isset( $post->ID ) ) {
			$smart_product_value[] = get_post_meta( $post->ID, 'ciyashop_smart_product_id', true );
			if ( $smart_product_value ) {
				wp_enqueue_script( 'cloudimage-360-view' );
			}
		}
	}
}

/********************************************************************
 *
 * Admin CSS and JS
 *
 ********************************************************************/
add_action( 'admin_enqueue_scripts', 'pgscore_admin_assets' );
function pgscore_admin_assets( $hook ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	/*
	 * Stylesheets
	 * */

	// Gravity Form - Font Awesome Fix
	if ( class_exists( 'GFForms' ) ) {
		wp_deregister_style( 'gform_font_awesome' );
		wp_register_style( 'gform_font_awesome', trailingslashit( PGSCORE_URL ) . 'css/font-awesome.min.css', null );
	}

	wp_enqueue_style( 'pgscore-vc-imagepicker', trailingslashit( PGSCORE_URL ) . 'css/image-picker' . $suffix . '.css' );
	
	if ( 'appearance_page_ciyashop-options' === $hook ) {
		wp_enqueue_style( 'jquery-confirm-bootstrap', trailingslashit( PGSCORE_URL ) . 'css/jquery-confirm/jquery-confirm-bootstrap' . $suffix . '.css' );
		wp_enqueue_style( 'jquery-confirm', trailingslashit( PGSCORE_URL ) . 'css/jquery-confirm/jquery-confirm' . $suffix . '.css' );
	}
	
	wp_enqueue_style( 'pgscore-admin-css', trailingslashit( PGSCORE_URL ) . 'css/pgscore-admin' . $suffix . '.css' );
	wp_register_style( 'header-builder-style', trailingslashit( PGSCORE_URL ) . 'css/header-builder' . $suffix . '.css' );

	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit.php' ) {
		wp_register_style( 'jquery-ui', trailingslashit( PGSCORE_URL ) . 'css/jquery-ui/jquery-ui' . $suffix . '.css' );
		wp_enqueue_style( 'pgscore-vc-admin', trailingslashit( PGSCORE_URL ) . 'css/vc-admin' . $suffix . '.css', array( 'jquery-ui' ) );
	}

	if ( get_post_type( get_the_ID() ) == 'size_guides' ) {
		wp_enqueue_style( 'pgscore-edittable-style', trailingslashit( PGSCORE_URL ) . '/css/jquery.edittable' . $suffix . '.css' );
	}

	/*
	 * Javascripts
	 * */
	wp_register_script( 'pgscore-vc-imagepicker', trailingslashit( PGSCORE_URL ) . 'js/image-picker' . $suffix . '.js', array( 'jquery' ), false, true );
	wp_register_script( 'ciyashop-color-picker-alpha', trailingslashit( PGSCORE_URL ) . 'js/wp-color-picker-alpha' . $suffix . '.js', array( 'jquery', 'wp-color-picker' ) );
	wp_register_script( 'header-builder-script', trailingslashit( PGSCORE_URL ) . 'js/header-builder' . $suffix . '.js', array( 'jquery', 'ciyashop-color-picker-alpha' ) );
	wp_register_script( 'jquery-confirm', trailingslashit( PGSCORE_URL ) . 'js/jquery-confirm' . $suffix . '.js', array( 'jquery' ) );
	wp_register_script( 'pgscore-admin-js', trailingslashit( PGSCORE_URL ) . 'js/pgscore-admin' . $suffix . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ) );

	$color_picker_strings = array(
		'clear'            => __( 'Clear', 'pgs-core' ),
		'clearAriaLabel'   => __( 'Clear color', 'pgs-core' ),
		'defaultString'    => __( 'Default', 'pgs-core' ),
		'defaultAriaLabel' => __( 'Select default color', 'pgs-core' ),
		'pick'             => __( 'Select Color', 'pgs-core' ),
		'defaultLabel'     => __( 'Color value', 'pgs-core' ),
	);
	wp_localize_script( 'ciyashop-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );

	// header builder strings
	$chl_string = array(
		'create_new_header' => esc_html__( 'Create New Header', 'pgs-core' ),
		'add_element'       => esc_html__( 'Add Element', 'pgs-core' ),
		'save'              => esc_html__( 'Save', 'pgs-core' ),
		'cancel'            => esc_html__( 'Cancel', 'pgs-core' ),
		'configure'         => esc_html__( 'Configure', 'pgs-core' ),
		'settings'          => esc_html__( 'Settings', 'pgs-core' ),
		'upload_image'      => esc_html__( 'Upload Image', 'pgs-core' ),
		'color'             => esc_html__( 'Color', 'pgs-core' ),
		'image_repeat'      => esc_html__( 'Image Repeat', 'pgs-core' ),
		'image_size'        => esc_html__( 'Image Size', 'pgs-core' ),
		'image_attachment'  => esc_html__( 'Image Attachment', 'pgs-core' ),
		'image_position'    => esc_html__( 'Image Position', 'pgs-core' ),
		'text_color'        => esc_html__( 'Text Color', 'pgs-core' ),
		'link_color'        => esc_html__( 'Link Color', 'pgs-core' ),
		'link_hover_color'  => esc_html__( 'Link Hover Color', 'pgs-core' ),
		'width'             => esc_html__( 'Width', 'pgs-core' ),
		'style'             => esc_html__( 'Style', 'pgs-core' ),
		'border_width'      => esc_html__( 'Border Width', 'pgs-core' ),
		'full_width'        => esc_html__( 'Full Width', 'pgs-core' ),
		'container'         => esc_html__( 'Container', 'pgs-core' ),
	);

	$chl_string = apply_filters( 'chl_string', $chl_string );
	wp_localize_script( 'header-builder-script', 'chl', $chl_string );

	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit.php' ) {
		wp_enqueue_script( 'pgscore-vc-imagepicker' );
	}

	if ( get_post_type( get_the_ID() ) == 'size_guides' ) {
		wp_enqueue_script( 'pgscore-edittable-script', trailingslashit( PGSCORE_URL ) . '/js/jquery.edittable' . $suffix . '.js', array( 'jquery' ) );
	}

	if ( $hook == 'toplevel_page_header-builder' || $hook == 'header-builder_page_header-layout' ) {
		wp_enqueue_editor();
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_style( 'select2', get_parent_theme_file_uri( '/css/select2.min.css' ) );
		wp_enqueue_script( 'select2', get_parent_theme_file_uri( '/js/select2/select2.min.js' ) );
		wp_enqueue_style( 'header-builder-style' );
		wp_enqueue_script( 'header-builder-script' );
	}

	// Localize the script with new data
	$translation_array = array(
		'set_possition' => __( 'Set Possition', 'pgs-core' ),
	);
	wp_localize_script( 'pgscore-admin-js', 'object', $translation_array );
	if ( 'appearance_page_ciyashop-options' === $hook ) {
		wp_enqueue_script( 'jquery-confirm' );
	}
	wp_enqueue_script( 'pgscore-admin-js' );
}
