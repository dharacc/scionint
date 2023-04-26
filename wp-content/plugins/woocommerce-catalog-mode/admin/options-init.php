<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if( class_exists( 'Redux' ) ) {
        $framework = new Redux();
    } else {
        $framework = new weLaunch();
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "woocommerce_catalog_mode_options";

    $options = get_option('woocommerce_catalog_mode_options');

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'woocommerce_catalog_mode_options',
        'use_cdn' => TRUE,
        'dev_mode' => FALSE,
        'display_name' => 'WooCommerce Catalog Mode',
        'display_version' => '1.7.4',
        'page_title' => 'WooCommerce Catalog Mode',
        'update_notice' => TRUE,
        'intro_text' => '',
        'footer_text' => '&copy; '.date('Y').' weLaunch',
        'admin_bar' => TRUE,
        'menu_type' => 'submenu',
        'menu_title' => 'Catalog Mode',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'woocommerce',
        'page_parent_post_type' => 'your_post_type',
        'customizer' => FALSE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    global $weLaunchLicenses;
    if( (isset($weLaunchLicenses['woocommerce-catalog-mode']) && !empty($weLaunchLicenses['woocommerce-catalog-mode'])) || (isset($weLaunchLicenses['woocommerce-plugin-bundle']) && !empty($weLaunchLicenses['woocommerce-plugin-bundle'])) ) {
        $args['display_name'] = '<span class="dashicons dashicons-yes-alt" style="color: #9CCC65 !important;"></span> ' . $args['display_name'];
    } else {
        $args['display_name'] = '<span class="dashicons dashicons-dismiss" style="color: #EF5350 !important;"></span> ' . $args['display_name'];
    }

    $framework::setArgs( $opt_name, $args );

    /*
     *
     * ---> START SECTIONS
     *
     */

    $framework::setSection( $opt_name, array(
        'title'  => __( 'Catalog Mode', 'woocommerce-catalog-mode' ),
        'id'     => 'general',
        'desc'   => __( 'Need support? Please use the comment function on codecanyon.', 'woocommerce-catalog-mode' ),
        'icon'   => 'el el-home',
    ) );

    $framework::setSection( $opt_name, array(
        'title'      => __( 'General', 'woocommerce-catalog-mode' ),
            'desc'       => __( 'To get auto updates please <a href="' . admin_url('tools.php?page=welaunch-framework') . '">register your License here</a>.', 'woocommerce-catalog-mode' ),
        'id'         => 'general-settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enable',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable catalog mode to use the options below', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'removeAddToCart',
                'type'     => 'checkbox',
                'title'    => __( 'Remove add to cart button', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Removes the add to cart button on single product and category pages.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'removePrice',
                'type'     => 'checkbox',
                'title'    => __( 'Remove price', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Removes price on single product and category pages.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'redirectCartAndCheckoutPages',
                'type'     => 'checkbox',
                'title'    => __( 'Redirect Cart / Checkout Page', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Redirects the cart and checkout page to your home page.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'customFreePrice',
                'type'     => 'checkbox',
                'title'    => __( 'Show custom Free Price Text', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Instead of "Free".', 'woocommerce-catalog-mode' ),
                'default'  => 0
            ),
            array(
                'id'       => 'customFreePriceText',
                'type'     => 'text',
                'title'    => __('Free Price Text', 'woocommerce-catalog-mode'),
                'subtitle' => __( 'The text, that should replace the free text.', 'woocommerce-catalog-mode' ),
                'default'  => __( 'Available in store', 'woocommerce-catalog-mode'),
                'required' => array('customFreePrice','equals','1'),
            ),
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Enquiry Cart', 'woocommerce-catalog-mode' ),
        // 'desc'       => __( '', 'woocommerce-catalog-mode' ),
        'id'         => 'enquiry-cart',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enquiryCartEnable',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable the enquiry cart. Make sure you have not enabled to remove the add to cart button in general settings.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'enquiryCartRemoveCoupons',
                'type'     => 'checkbox',
                'title'    => __( 'Remove Coupons from Cart', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartRemoveCrossSells',
                'type'     => 'checkbox',
                'title'    => __( 'Remove Cross Sells from Cart', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartRemoveCheckout',
                'type'     => 'checkbox',
                'title'    => __( 'Remove Checkout from Cart', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartShowPrice',
                'type'     => 'checkbox',
                'title'    => __( 'Show price in Form', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartShowSKU',
                'type'     => 'checkbox',
                'title'    => __( 'Show SKU in Form', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartShowQuantity',
                'type'     => 'checkbox',
                'title'    => __( 'Show Quantity in Form', 'woocommerce-catalog-mode' ),
                'default'  => 1,
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartBasketBtnText',
                'type'     => 'text',
                'title'    => __('Add to Cart Button Text', 'woocommerce-catalog-mode'),
                'default'  => __( 'Add to Enquiry Basket', 'woocommerce-catalog-mode'),
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartBtnText',
                'type'     => 'text',
                'title'    => __('Enquiry Button Text', 'woocommerce-catalog-mode'),
                'default'  => __( 'Send Enquiry', 'woocommerce-catalog-mode'),
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartBtnAction',
                'type'     => 'select',
                'title'    => __('Button Action', 'woocommerce-catalog-mode'), 
                'subtitle' => __('What happens when the User clicks the button.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '1' => __('Open enquiry form', 'woocommerce-catalog-mode' ),
                    '2' => __('Go to custom URL', 'woocommerce-catalog-mode' ),
                ),
                'default'  => '1',
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartBtnActionHook',
                'type'     => 'select',
                'title'    => __('Button Action Hook', 'woocommerce-catalog-mode'), 
                'subtitle' => __('At what hook position should the button appear.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    'woocommerce_cart_actions' => __('woocommerce_cart_actions', 'woocommerce-catalog-mode' ),
                    'woocommerce_after_cart' => __('woocommerce_after_cart', 'woocommerce-catalog-mode' ),
                ),
                'default'  => 'woocommerce_cart_actions',
                'required' => array('enquiryCartEnable','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartModalTitle',
                'type'     => 'text',
                'title'    => __('Enquiry Title', 'woocommerce-catalog-mode'),
                'subtitle' => __('The title of the enquiry Modal', 'woocommerce-catalog-mode'),
                'default'  => 'Send Enquiry',
                'required' => array('enquiryCartBtnAction','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartContactform',
                'type'     => 'editor',
                'title'    => __('Enquiry contact form', 'woocommerce-catalog-mode'),
                'subtitle' => __('Please insert your contact form shortcode.', 'woocommerce-catalog-mode'),
                'required' => array('enquiryCartBtnAction','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartContactformProductsField',
                'type'     => 'text',
                'title'    => __('Products Field Name', 'woocommerce-catalog-mode'),
                'subtitle' => __('Set the field name of your Products field here, so that our plugin can copy selected Products into the field automatically.', 'woocommerce-catalog-mode'),
                'default'  => 'products',
                'required' => array('enquiryCartBtnAction','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartModalSize',
                'type'     => 'select',
                'title'    => __('Enquiry Modal size', 'woocommerce-catalog-mode'),
                'subtitle' => __('Size of the Enquiry modal.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    'modal-normal' => __('Normal', 'woocommerce-catalog-mode'),
                    'modal-sm' => __('Small', 'woocommerce-catalog-mode'),
                    'modal-lg' => __('Large', 'woocommerce-catalog-mode'),
                ),
                'default'  => 'modal-normal',
                'required' => array('enquiryCartBtnAction','equals','1'),
            ),
            array(
                'id'       => 'enquiryCartBtnActionURL',
                'type'     => 'text',
                'title'    => __('Button custom URL', 'woocommerce-catalog-mode'),
                'subtitle' => __('The URL where the user will be sent to when he clicked the button.', 'woocommerce-catalog-mode'),
                'validate' => 'url',
                'required' => array('enquiryCartBtnAction','equals','2'),
            ),
            array(
                'id'       => 'enquiryCartBtnActionURLTarget',
                'type'     => 'select',
                'title'    => __('Button custom URL target', 'woocommerce-catalog-mode'),
                'subtitle' => __('The target attribute of the link.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '_self' => __('_self (same Window)', 'woocommerce-catalog-mode'),
                    '_blank' => __('_blank (new Window)', 'woocommerce-catalog-mode'),
                    '_parent' => __('_parent (parent Window)', 'woocommerce-catalog-mode'),
                    '_top' => __('_top (full body of the Window)', 'woocommerce-catalog-mode'),
                ),
                'default'  => '_self',
                'required' => array('enquiryCartBtnAction','equals','2'),
            ),
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Product Categories', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Adds a custom enquiry / go to button in product category pages.', 'woocommerce-catalog-mode' ),
        'id'         => 'loop-button',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'loopButtonEnabled',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enables the custom button on loop pages.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'loopButtonAlwaysShow',
                'type'     => 'checkbox',
                'title'    => __( 'Always show loop button', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'This will prevent the loop button from disappear if the product is on the exclusion list.', 'woocommerce-catalog-mode' ),
                'default'  => '1',
                'required' => array('loopButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'loopButtonText',
                'type'     => 'text',
                'title'    => __('Button Text', 'woocommerce-catalog-mode'),
                'subtitle' => __('Text inside the custom button.', 'woocommerce-catalog-mode'),
                'default'  => 'Read more',
                'required' => array('loopButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'loopButtonAction',
                'type'     => 'select',
                'title'    => __('Button Action', 'woocommerce-catalog-mode'), 
                'subtitle' => __('What happens when the User clicks the button.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '1' => __('Go to product page', 'woocommerce-catalog-mode' ),
                    '2' => __('Go to custom URL', 'woocommerce-catalog-mode' ),
                    '3' => __('Enquiry Form', 'woocommerce-catalog-mode' ),
                ),
                'default'  => '1',
                'required' => array('loopButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'loopButtonActionURL',
                'type'     => 'text',
                'title'    => __('Button custom URL', 'woocommerce-catalog-mode'),
                'subtitle' => __('The URL where the user will be sent to when he clicked the button.', 'woocommerce-catalog-mode'),
                'validate' => 'url',
                'required' => array('loopButtonAction','equals','2'),
            ),
            array(
                'id'       => 'loopButtonActionURLTarget',
                'type'     => 'select',
                'title'    => __('Button custom URL target', 'woocommerce-catalog-mode'),
                'subtitle' => __('The target attribute of the link.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '_self' => __('_self (same Window)', 'woocommerce-catalog-mode'),
                    '_blank' => __('_blank (new Window)', 'woocommerce-catalog-mode'),
                    '_parent' => __('_parent (parent Window)', 'woocommerce-catalog-mode'),
                    '_top' => __('_top (full body of the Window)', 'woocommerce-catalog-mode'),
                ),
                'default'  => '_self',
                'required' => array('loopButtonAction','equals','2'),
            ),
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Single Product Pages', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Replace the add to cart button on single product pages with your own.', 'woocommerce-catalog-mode' ),
        'id'         => 'enquiry',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'singleProductButtonEnabled',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enables the single product custom button.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'singleProductButtonAlwaysShow',
                'type'     => 'checkbox',
                'title'    => __( 'Always show button', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'This will prevent the single product button from disappear if the product is on the exclusion list.', 'woocommerce-catalog-mode' ),
                'default'  => '1',
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'singleProductOnlyOutOfStock',
                'type'     => 'checkbox',
                'title'    => __( 'Only Out of Stock', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Only show the send enquiry button when product is out of stock.', 'woocommerce-catalog-mode' ),
                'default'  => '0',
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonText',
                'type'     => 'text',
                'title'    => __('Button Text', 'woocommerce-catalog-mode'),
                'subtitle' => __('Text inside the custom button.', 'woocommerce-catalog-mode'),
                'default'  => 'Read more',
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonPosition',
                'type'     => 'select',
                'title'    => __('Button Position', 'woocommerce-catalog-mode'),
                'subtitle' => __('Specify the positon of the Button.', 'woocommerce-catalog-mode'),
                'default'  => 'woocommerce_single_product_summary',
                'options'  => array( 
                    'woocommerce_before_single_product' => __('Before Single Product', 'woocommerce-catalog-mode'),
                    'woocommerce_before_single_product_summary' => __('Before Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_single_product_summary' => __('In Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_product_meta_start' => __('Before Meta Information', 'woocommerce-catalog-mode'),
                    'woocommerce_product_meta_end' => __('After Meta Information', 'woocommerce-catalog-mode'),
                    'woocommerce_after_single_product_summary' => __('After Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_after_single_product' => __('After Single Product', 'woocommerce-catalog-mode'),
                    'woocommerce_after_main_content' => __('After Main Product', 'woocommerce-catalog-mode'),
                ),
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
           array(
                'id'       => 'singleProductButtonPriority',
                'type'     => 'spinner',
                'title'    => __( 'Button Priority', 'woocommerce-catalog-mode' ),
                'min'      => '1',
                'step'     => '1',
                'max'      => '999',
                'default'  => '5',
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonAction',
                'type'     => 'select',
                'title'    => __('Button Action', 'woocommerce-catalog-mode'), 
                'subtitle' => __('What happens when the User clicks the button.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '1' => __('Open enquiry form', 'woocommerce-catalog-mode' ),
                    '2' => __('Go to custom URL', 'woocommerce-catalog-mode' ),
                ),
                'default'  => '1',
                'required' => array('singleProductButtonEnabled','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonActionURL',
                'type'     => 'text',
                'title'    => __('Button custom URL', 'woocommerce-catalog-mode'),
                'subtitle' => __('The URL where the user will be sent to when he clicked the button.', 'woocommerce-catalog-mode'),
                'validate' => 'url',
                'required' => array('singleProductButtonAction','equals','2'),
            ),
            array(
                'id'       => 'singleProductButtonActionURLTarget',
                'type'     => 'select',
                'title'    => __('Custom Button URL target', 'woocommerce-catalog-mode'),
                'subtitle' => __('The target attribute of the link.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '_self' => __('_self (same Window)', 'woocommerce-catalog-mode'),
                    '_blank' => __('_blank (new Window)', 'woocommerce-catalog-mode'),
                    '_parent' => __('_parent (parent Window)', 'woocommerce-catalog-mode'),
                    '_top' => __('_top (full body of the Window)', 'woocommerce-catalog-mode'),
                ),
                'default'  => '_self',
                'required' => array('singleProductButtonAction','equals','2'),
            ),
            array(
                'id'       => 'singleProductButtonModalTitle',
                'type'     => 'text',
                'title'    => __('Enquiry Title', 'woocommerce-catalog-mode'),
                'subtitle' => __('The title of the enquiry Modal', 'woocommerce-catalog-mode'),
                'default'  => 'Send Enquiry',
                'required' => array('singleProductButtonAction','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonModalPosition',
                'type'     => 'select',
                'title'    => __('Enquiry Position', 'woocommerce-catalog-mode'),
                'subtitle' => __('The position of the enquiry form. This helps <a href="http://contactform7.com/special-mail-tags/" target="_blank">special mail tags</a> to work correctly.', 'woocommerce-catalog-mode'),
                'default'  => 'wp_footer',
                'options'  => array(
                    'wp_footer' => __('Footer', 'woocommerce-catalog-mode'),      
                    'woocommerce_before_main_content' => __('Before Main Content', 'woocommerce-catalog-mode'),
                    'woocommerce_before_single_product' => __('Before Single Product', 'woocommerce-catalog-mode'),
                    'woocommerce_before_single_product_summary' => __('Before Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_single_product_summary' => __('In Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_product_meta_start' => __('Before Meta Information', 'woocommerce-catalog-mode'),
                    'woocommerce_product_meta_end' => __('After Meta Information', 'woocommerce-catalog-mode'),
                    'woocommerce_after_single_product_summary' => __('After Single Product Summary', 'woocommerce-catalog-mode'),
                    'woocommerce_after_single_product' => __('After Single Product', 'woocommerce-catalog-mode'),
                    'woocommerce_after_main_content' => __('After Main Product', 'woocommerce-catalog-mode'),
                ),
                'required' => array('singleProductButtonAction','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonContactform',
                'type'     => 'editor',
                'title'    => __('Enquiry contact form', 'woocommerce-catalog-mode'),
                'subtitle' => __('Please insert your contact form shortcode.', 'woocommerce-catalog-mode'),
                'required' => array('singleProductButtonAction','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonContactformSKUField',
                'type'     => 'text',
                'title'    => __('SKU Field Name', 'woocommerce-catalog-mode'),
                'subtitle' => __('Set the field name of your SKU field here, so that our plugin can copy selected SKU into the field automatically.', 'woocommerce-catalog-mode'),
                'default'  => 'sku',
                'required' => array('singleProductButtonAction','equals','1'),
            ),

            array(
                'id'       => 'singleProductButtonContactformSKUSelector',
                'type'     => 'text',
                'title'    => __('SKU Field Selector', 'woocommerce-catalog-mode'),
                'subtitle' => __('Inspect html code of your site if SKU data does not get overtaken.', 'woocommerce-catalog-mode'),
                'default'  => '.sku',
                'required' => array('singleProductButtonAction','equals','1'),
            ),
            
            array(
                'id'       => 'singleProductButtonContactformProductField',
                'type'     => 'text',
                'title'    => __('Product Field Name', 'woocommerce-catalog-mode'),
                'subtitle' => __('Set the field name of your Product field here, so that our plugin can copy selected Product into the field automatically.', 'woocommerce-catalog-mode'),
                'default'  => 'product',
                'required' => array('singleProductButtonAction','equals','1'),
            ),

            array(
                'id'       => 'singleProductButtonContactformProductSelector',
                'type'     => 'text',
                'title'    => __('Product Field Selector', 'woocommerce-catalog-mode'),
                'subtitle' => __('Inspect html code of your site if product data does not get overtaken.', 'woocommerce-catalog-mode'),
                'default'  => '[itemprop="name"]',
                'required' => array('singleProductButtonAction','equals','1'),
            ),
            array(
                'id'       => 'singleProductButtonContactformProductSelectorFallback',
                'type'     => 'text',
                'title'    => __('Product Field Selector Fallback', 'woocommerce-catalog-mode'),
                'subtitle' => __('Fallback if not value found for product field selector.', 'woocommerce-catalog-mode'),
                'default'  => '.single-product h1',
                'required' => array('singleProductButtonAction','equals','1'),
            ),

            array(
                'id'       => 'singleProductButtonModalSize',
                'type'     => 'select',
                'title'    => __('Enquiry Modal size', 'woocommerce-catalog-mode'),
                'subtitle' => __('Size of the Enquiry modal.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    'modal-normal' => __('Normal', 'woocommerce-catalog-mode'),
                    'modal-sm' => __('Small', 'woocommerce-catalog-mode'),
                    'modal-lg' => __('Large', 'woocommerce-catalog-mode'),
                ),
                'default'  => 'modal-normal',
                'required' => array('singleProductButtonAction','equals','1'),
            ),

        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Variation Products', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Configure if you want to show variations.', 'woocommerce-catalog-mode' ),
        'id'         => 'variations',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'variationsEnabled',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show variations.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'variationsDisplay',
                'type'     => 'select',
                'title'    => __( 'Display as', 'woocommerce-catalog-mode' ),
                'options'  => array(
                    'dropdown' => __('Dropdown', 'woocommerce-catalog-mode'),
                    'table' => __('Table', 'woocommerce-catalog-mode'),
                ),
                'default'  => 'table',
            ),
            array(
                'id'       => 'variationsShowImage',
                'type'     => 'checkbox',
                'title'    => __( 'Show Image', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show the variation Image.', 'woocommerce-catalog-mode' ),
                'required' => array('variationsDisplay','equals','table'),
            ),
            array(
                'id'       => 'variationsShowSKU',
                'type'     => 'checkbox',
                'title'    => __( 'Show SKU', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show the variation SKU.', 'woocommerce-catalog-mode' ),
                'required' => array('variationsDisplay','equals','table'),
            ),
            array(
                'id'       => 'variationsShowDescription',
                'type'     => 'checkbox',
                'title'    => __( 'Show Description', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show the variation description.', 'woocommerce-catalog-mode' ),
                'required' => array('variationsDisplay','equals','table'),
            ),
            array(
                'id'       => 'variationsShowPrice',
                'type'     => 'checkbox',
                'title'    => __( 'Show Price', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show the variation price.', 'woocommerce-catalog-mode' ),
                'required' => array('variationsDisplay','equals','table'),
            ),
            array(
                'id'       => 'variationsShowAttributes',
                'type'     => 'checkbox',
                'title'    => __( 'Show Attributes', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Enable to show the variation attributes.', 'woocommerce-catalog-mode' ),
                'required' => array('variationsDisplay','equals','table'),
            ),
          
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Exclusions', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'With the below settings you can exclude products / categories so that the price and add to cart will be shown.', 'woocommerce-catalog-mode' ),
        'id'         => 'exclusions',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'     =>'excludeProductCategories',
                'type' => 'select',
                'data' => 'categories',
                'args' => array('taxonomy' => array('product_cat')),
                'multi' => true,
                'title' => __('Exclude Product Categories', 'woocommerce-catalog-mode'), 
                'subtitle' => __('Which product categories should be excluded by the catalog mode.', 'woocommerce-catalog-mode'),
            ),
            array(
                'id'       => 'excludeProductCategoriesRevert',
                'type'     => 'checkbox',
                'title'    => __( 'Revert Categories Exclusion', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Instead of exclusion it will include.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'     =>'excludeProducts',
                'type' => 'select',
                // 'options' => $woocommerce_catalog_mode_options_products,
                'data' => 'posts',
                'args' => array('post_type' => array('product'), 'posts_per_page' => -1),

                'multi' => true,
                'ajax'  => true,
                'title' => __('Exclude Products', 'woocommerce-catalog-mode'), 
                'subtitle' => __('Which products should be excluded by the catalog mode.', 'woocommerce-catalog-mode'),
            ),
            array(
                'id'       => 'excludeProductsRevert',
                'type'     => 'checkbox',
                'title'    => __( 'Revert Products Exclusion', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Instead of exclusion it will include.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'excludeCountries',
                'type'     => 'checkbox',
                'title'    => __( 'Exclude Countries', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Exclude some countries from this plugin.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'countriesToExclude',
                'type'     => 'select',
                'title'    => __('Countries to exclude', 'woocommerce-catalog-mode'),
                'multi' => true,
                'options'  =>  array( "AF" => "Afghanistan", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua and Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia and Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "BQ" => "British Antarctic Territory", "IO" => "British Indian Ocean Territory", "VG" => "British Virgin Islands", "BN" => "Brunei", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CT" => "Canton and Enderbury Islands", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos [Keeling] Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo - Brazzaville", "CD" => "Congo - Kinshasa", "CK" => "Cook Islands", "CR" => "Costa Rica", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "CI" => "Côte d’Ivoire", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "NQ" => "Dronning Maud Land", "DD" => "East Germany", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "FQ" => "French Southern and Antarctic Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island and McDonald Islands", "HN" => "Honduras", "HK" => "Hong Kong SAR China", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JT" => "Johnston Island", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Laos", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macau SAR China", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "FX" => "Metropolitan France", "MX" => "Mexico", "FM" => "Micronesia", "MI" => "Midway Islands", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar [Burma]", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles", "NT" => "Neutral Zone", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "KP" => "North Korea", "VD" => "North Vietnam", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PC" => "Pacific Islands Trust Territory", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territories", "PA" => "Panama", "PZ" => "Panama Canal Zone", "PG" => "Papua New Guinea", "PY" => "Paraguay", "YD" => "People's Democratic Republic of Yemen", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn Islands", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RO" => "Romania", "RU" => "Russia", "RW" => "Rwanda", "RE" => "Réunion", "BL" => "Saint Barthélemy", "SH" => "Saint Helena", "KN" => "Saint Kitts and Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre and Miquelon", "VC" => "Saint Vincent and the Grenadines", "WS" => "Samoa", "SM" => "San Marino", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "CS" => "Serbia and Montenegro", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia and the South Sandwich Islands", "KR" => "South Korea", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard and Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syria", "ST" => "São Tomé and Príncipe", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad and Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks and Caicos Islands", "TV" => "Tuvalu", "UM" => "U.S. Minor Outlying Islands", "PU" => "U.S. Miscellaneous Pacific Islands", "VI" => "U.S. Virgin Islands", "UG" => "Uganda", "UA" => "Ukraine", "SU" => "Union of Soviet Socialist Republics", "AE" => "United Arab Emirates", "GB" => "United Kingdom", "US" => "United States", "ZZ" => "Unknown or Invalid Region", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VA" => "Vatican City", "VE" => "Venezuela", "VN" => "Vietnam", "WK" => "Wake Island", "WF" => "Wallis and Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe", "AX" => "Åland Islands" ),
                'required' => array('excludeCountries','equals','1'),
            ),
            array(
                'id'       => 'countriesToExcludeRevert',
                'type'     => 'checkbox',
                'title'    => __( 'Revert Exclusion', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Instead of exclusion it will include.', 'woocommerce-catalog-mode' ),
                'required' => array('excludeCountries','equals','1'),
            ),
         )
    ));   

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Limitations', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Apply Catalog Mode for specific users / roles.', 'woocommerce-catalog-mode' ),
        'id'         => 'limitations',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'applyForUserGroup',
                'type'     => 'select',
                'title'    => __('Apply for users', 'woocommerce-catalog-mode'), 
                'subtitle' => __('Which user group should be affected by the catalog mode.', 'woocommerce-catalog-mode'),
                'options'  => array(
                    '1' => __('All', 'woocommerce-catalog-mode' ),
                    '2' => __('Only NOT logged in', 'woocommerce-catalog-mode' ),
                    '3' => __('Only Logged in', 'woocommerce-catalog-mode' ),
                ),
                'default'  => '1',
            ),
            array(
                'id'     => 'applyForExcludeUserRoles',
                'type'   => 'select',
                'data'   => 'roles',
                'title'  => __('Exclude User Roles', 'woocommerce-catalog-mode'),
                'subtitle' => __('Select user roles, where the plugin should NOT apply.', 'woocommerce-catalog-mode'),
                'multi'    => true,
                'default'  => '',
            ),
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Advanced settings', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Custom stylesheet / javascript.', 'woocommerce-catalog-mode' ),
        'id'         => 'advanced',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'customCSS',
                'type'     => 'ace_editor',
                'mode'     => 'css',
                'title'    => __( 'Custom CSS', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Add some stylesheet if you want.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'customJS',
                'type'     => 'ace_editor',
                'mode'     => 'javascript',
                'title'    => __( 'Custom JS', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'Add some javascript if you want.', 'woocommerce-catalog-mode' ),
            ),
        )
    ));

    $framework::setSection( $opt_name, array(
        'title'      => __( 'Debug', 'woocommerce-catalog-mode' ),
        'desc'       => __( 'Debug for special themes.', 'woocommerce-catalog-mode' ),
        'id'         => 'debug',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'hardRemovePrices',
                'type'     => 'checkbox',
                'title'    => __( 'Hard Remove Price', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'This will add CSS to hide the price !important. Please only enable when your theme still shows prices.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'hardRemoveAddToCart',
                'type'     => 'checkbox',
                'title'    => __( 'Hard Remove Add to Cart', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'This will add CSS to hide the button using !important. Please only enable when your theme still shows the add to cart button.', 'woocommerce-catalog-mode' ),
            ),
            array(
                'id'       => 'doNotLoadBootstrap',
                'type'     => 'checkbox',
                'title'    => __( 'Don\'t load Bootstrap', 'woocommerce-catalog-mode' ),
                'subtitle' => __( 'This will deactivate the load of bootstrap.js. Used for some themes that are using it to avoid conflicts.', 'woocommerce-catalog-mode' ),
            ),
        )
    ));

    /*
     * <--- END SECTIONS
     */
