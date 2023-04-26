<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.welaunch.io
 * @since      1.0.0
 *
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/public
 * @author     Daniel Barenkamp <support@db-dzine.com>
 */
class WooCommerce_Catalog_Mode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options
	 */
	private $options;

	/**
	 * if true this product will be excluded
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options
	 */
	private $exclude;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) 
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Enqueu Styles
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	public function enqueue_styles() 
	{
		global $woocommerce_catalog_mode_options;

		$this->options = $woocommerce_catalog_mode_options;

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-catalog-mode-public.css', array(), $this->version, 'all' );

		$customCSS = $this->get_option('customCSS');

		if($this->get_option('removePrice')) {
			$customCSS .= '.woocommerce-cart-form .product-price, .woocommerce-cart-form .product-subtotal{ display: none; }';

			if($this->get_option('applyForUserGroup') == 2) {
				if(is_user_logged_in() ) {
					$customCSS .= '.logged-in .woocommerce-cart-form .product-price, .logged-in .woocommerce-cart-form .product-subtotal{ display: block; }';					
				}
			}

		}

		if($this->get_option('enquiryCartEnable')) {
			$customCSS .= 
			'.woocommerce-cart-form .coupon, 
			.woocommerce-cart-form .cart-collaterals { display: none; }';
		}

		if(empty($customCSS)) {
			return false;
		}

		file_put_contents( dirname(__FILE__)  . '/css/woocommerce-catalog-mode-custom.css', $customCSS);

		wp_enqueue_style( $this->plugin_name.'-custom', plugin_dir_url( __FILE__ ) . 'css/woocommerce-catalog-mode-custom.css', array(), $this->version, 'all');

	}

	/**
	 * Enque JS SCripts
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	public function enqueue_scripts() 
	{
		global $woocommerce_catalog_mode_options;

		$this->options = $woocommerce_catalog_mode_options;

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-catalog-mode-public.js', array( 'jquery' ), $this->version, true );

		$forJS = array(
			'skuField' => $this->get_option('singleProductButtonContactformSKUField') ? $this->get_option('singleProductButtonContactformSKUField') : 'sku',
			'productField' => $this->get_option('singleProductButtonContactformProductField') ? $this->get_option('singleProductButtonContactformProductField') : 'product',
			'productsField' => $this->get_option('enquiryCartContactformProductsField') ? $this->get_option('enquiryCartContactformProductsField') : 'products',
			'SKUSelector' => $this->get_option('singleProductButtonContactformSKUSelector') ? $this->get_option('singleProductButtonContactformSKUSelector') : '.sku',
			'productSelector' => $this->get_option('singleProductButtonContactformProductSelector') ? $this->get_option('singleProductButtonContactformProductSelector') : '[itemprop="name"]',
			'productSelectorFallback' => $this->get_option('singleProductButtonContactformProductSelectorFallback') ? $this->get_option('singleProductButtonContactformProductSelectorFallback') : '.single-product h1',
			
			'enquiryCartShowPrice' => $this->get_option('enquiryCartShowPrice'),
			'enquiryCartShowSKU' => $this->get_option('enquiryCartShowSKU'),
			'enquiryCartShowQuantity' => $this->get_option('enquiryCartShowQuantity'),
			'ajaxURL' => admin_url('admin-ajax.php'),
		);
		wp_localize_script($this->plugin_name, 'woocommerce_catalog_mode_options', $forJS);

		$doNotLoadBootstrap = $this->get_option('doNotLoadBootstrap');
		if(!$doNotLoadBootstrap) {
			wp_enqueue_script( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		}	

		$customJS = $this->get_option('customJS');
		if(empty($customJS)) {
			return false;
		}

		file_put_contents( dirname(__FILE__)  . '/js/woocommerce-catalog-mode-custom.js', $customJS);

		wp_enqueue_script( $this->plugin_name.'-custom', plugin_dir_url( __FILE__ ) . 'js/woocommerce-catalog-mode-custom.js', array( 'jquery' ), $this->version, true );
		
	}

	/**
	 * Get Options
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @param   [type]                       $option [description]
	 * @return  [type]                               [description]
	 */
    private function get_option($option)
    {
    	if(!is_array($this->options)) {
    		return false;
    	}
    	
    	if(!array_key_exists($option, $this->options))
    	{
    		return false;
    	}
    	return $this->options[$option];
    }
	
    /**
     * Inits the Catalog Mode
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function init()
    {

		global $woocommerce_catalog_mode_options;
		$this->options = $woocommerce_catalog_mode_options;
		if (!$this->get_option('enable'))
		{
			return false;
		}

		$excludeUserRoles = $this->get_option('applyForExcludeUserRoles');
		if(is_array($excludeUserRoles) && !empty($excludeUserRoles)) {

			$currentUserRole = $this->get_user_role();
			if(in_array($currentUserRole, $excludeUserRoles))
			{
				return false;
			}
		}

		// Only not logged in
		if($this->get_option('applyForUserGroup') == 2) {
			if(is_user_logged_in()) {
				return false;
			}
		}

		// Only logged in
		if($this->get_option('applyForUserGroup') == 3) {
			if(!is_user_logged_in()) {
				return false;
			}
		}

		// Exclude countries
		if($this->get_option('excludeCountries') && class_exists('WC_Geolocation'))
		{
			$WC_Geolocation = new WC_Geolocation();
			$country = $WC_Geolocation->geolocate_ip();
			$usersCountry = $country['country'];

			$countriesToExclude = $this->get_option('countriesToExclude');
			$countriesToExcludeRevert = $this->get_option('countriesToExcludeRevert');
			
			if(!empty($countriesToExclude)){
				if($countriesToExcludeRevert) {
					if(!in_array($usersCountry, $countriesToExclude))
					{
						return false;
					}
				} else {
					if(in_array($usersCountry, $countriesToExclude))
					{
						return false;
					}
				}
			}
		}

		if($this->get_option('hardRemovePrices') or $this->get_option('hardRemoveAddToCart')) {
			add_action('wp_head', array($this, 'hardRemove'), 100);
		}

		if($this->get_option('redirectCartAndCheckoutPages')) {
			add_action( 'wp', array($this, 'redirect_cart_and_checkout_pages'));
		}

		// Custom Free Price
		if($this->get_option('customFreePrice')){
			add_filter('woocommerce_get_price_html', array($this, 'customFreePriceText')); 
			// add_filter('woocommerce_free_sale_price_html', array($this, 'customFreePriceText'));
			// add_filter('woocommerce_free_price_html', array($this, 'customFreePriceText'));
			// add_filter('woocommerce_variation_free_price_html', array($this, 'customFreePriceText'));
			// add_filter('woocommerce_variable_free_sale_price_html', array($this, 'customFreePriceText'));
			// add_filter('woocommerce_variable_free_price_html', array($this, 'customFreePriceText'));
			// add_filter('woocommerce_order_shipping_to_display', array($this, 'customFreePriceText'));
		}

		if($this->get_option('enquiryCartEnable')) {
			add_filter( 'woocommerce_product_add_to_cart_text' , array($this, 'enquiry_cart_button_text'));
			add_filter( 'woocommerce_product_single_add_to_cart_text' , array($this, 'enquiry_cart_button_text'));

			if($this->get_option('enquiryCartRemoveCoupons')) {
				add_filter( 'woocommerce_coupons_enabled' , array($this, 'remove_coupon_from_cart'));
			}

			if($this->get_option('enquiryCartRemoveCrossSells')) {
				remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
			}

			if($this->get_option('enquiryCartRemoveCheckout')) {
				remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals');
			}

			$enquiryCartBtnActionHook = $this->get_option('enquiryCartBtnActionHook') ? $this->get_option('enquiryCartBtnActionHook') : 'woocommerce_cart_actions';

			// Go to product page
			if($this->get_option('enquiryCartBtnAction') == 1) {
				add_action($enquiryCartBtnActionHook, array($this, 'add_enquiry_cart_button'));
				add_action('wp_footer', array($this, 'enquiryCartModal'), 10 );
			}

			// Go to custom URL
			if($this->get_option('enquiryCartBtnAction') == 2) {
				add_action($enquiryCartBtnActionHook, array($this, 'add_enquiry_url_button'));
			}
		}

		add_action( 'woocommerce_before_shop_loop_item', array($this,  'check_loop' ) );
		add_action( 'woocommerce_before_single_product', array($this,  'check_single' ) );

    }

    /**
     * Check if catalog mode should apply in loop
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function check_loop() 
    {
    	$apply = true;

		$excludeProductCategories = $this->get_option('excludeProductCategories');
		if(!empty($excludeProductCategories)) 
		{
			if($this->excludeProductCategories()) {
				$apply = FALSE;
			}
		}

		$excludeProducts = $this->get_option('excludeProducts');
		if(!empty($excludeProducts)) 
		{
			if($this->excludeProducts()) {
				$apply = FALSE;
			}
		}

		if($apply) {

			$this->remove_add_to_cart();
			$this->remove_price();
			$this->showLoopButton();

		} else {
			$this->add_add_to_cart();
			$this->add_remove_price();

			$loopButtonAlwaysShow = $this->get_option('loopButtonAlwaysShow');
			if(!$loopButtonAlwaysShow) {
				$this->hideLoopButton();
			} else {
				$this->showLoopButton();
			}
		}
		
    }

    /**
     * Check if apply on single Product
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function check_single()
    {
    	$apply = true;

		$excludeProductCategories = $this->get_option('excludeProductCategories');
		if(!empty($excludeProductCategories)) 
		{
			if($this->excludeProductCategories()) {
				$apply = false;
			}
		}

		$excludeProducts = $this->get_option('excludeProducts');
		if(!empty($excludeProducts)) 
		{
			if($this->excludeProducts()) {
				$apply = false;
			}
		}
		// Not in exclusion list
		if($apply) {

			$this->remove_add_to_cart();
			$this->remove_price();
			$this->showSingleProductButton();
		} else {

			$singleProductButtonAlwaysShow = $this->get_option('singleProductButtonAlwaysShow');
			if($singleProductButtonAlwaysShow)
			{
				$this->showSingleProductButton();
			}
		}
    }

    /**
     * Show Loop Button
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
	public function showLoopButton()    
	{
		if(!$this->get_option('loopButtonEnabled')) {
			return FALSE;
		}

		// Go to product page
		if($this->get_option('loopButtonAction') == 1)
		{
			add_action('woocommerce_after_shop_loop_item', array($this,'loopProductPageButton'),10);
		}

		// Go to custom URL
		if($this->get_option('loopButtonAction') == 2)
		{
			add_action('woocommerce_after_shop_loop_item', array($this,'loopCustomURLButton'),10);
		}

		// Enquiry Form
		if($this->get_option('loopButtonAction') == 3)
		{
			add_action( 'wp_footer', array($this,'enquiryModal'), 10 );
			add_action('woocommerce_after_shop_loop_item', array($this,'loopEnquiryForm'),10);
		}
	}

	/**
	 * Hide Loop Button
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	public function hideLoopButton()    
	{
		remove_action('woocommerce_after_shop_loop_item', array($this,'loopProductPageButton'),10);
		remove_action('woocommerce_after_shop_loop_item', array($this,'loopProductPageButton'),10);
	}

	/**
	 * Show Single Product Button
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
    public function showSingleProductButton()
    {
    	global $product;

		// Custom Button
		if($this->get_option('singleProductButtonEnabled'))
		{
			if($this->get_option('singleProductOnlyOutOfStock') && $product != "outofstock")  {
				return false;
			}
            $buttonPosition = $this->get_option('singleProductButtonPosition');
            !empty($buttonPosition) ? $buttonPosition = $buttonPosition : $buttonPosition = 'woocommerce_single_product_summary';

            $buttonPriority = $this->get_option('singleProductButtonPriority');
            !empty($buttonPriority) ? $buttonPriority = $buttonPriority : $buttonPriority = 30;

			// Go to product page
			if($this->get_option('singleProductButtonAction') == 1 )
			{
                $modalPosition = $this->get_option('singleProductButtonModalPosition');
                !empty($modalPosition) ? $modalPosition = $modalPosition : $modalPosition = 'wp_footer';


				add_action( $buttonPosition, array($this,'enquiryButton'), $buttonPriority );
				add_action( $modalPosition, array($this,'enquiryModal'), 10 );
			}

			// Go to custom URL
			if($this->get_option('singleProductButtonAction') == 2)
			{
				add_action( $buttonPosition, array($this,'singleProductCustomURLButton'), $buttonPriority );
			}
		}
    }

    /**
     * Exclude Product Categories
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function excludeProductCategories()
    {
    	global $post;

		$excludeProductCategories = $this->get_option('excludeProductCategories');
		$excludeProductCategoriesRevert = $this->get_option('excludeProductCategoriesRevert');
		$terms = get_the_terms( $post->ID, 'product_cat' );
		if($terms)
		{
			foreach ($terms as $term)
			{
				if($excludeProductCategoriesRevert) {
					if(!in_array($term->term_id, $excludeProductCategories))
					{
						return TRUE;

					}
				} else {
					if(in_array($term->term_id, $excludeProductCategories))
					{
						return TRUE;

					}
				}
			}
		}
    }

    /**
     * Exclude Products
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function excludeProducts()
    {
    	global $post;

		$excludeProducts = $this->get_option('excludeProducts');
		$excludeProductsRevert = $this->get_option('excludeProductsRevert');
		if($excludeProductsRevert) {
			if(!in_array($post->ID, $excludeProducts))
			{
				return TRUE;
			}
		} else {
			if(in_array($post->ID, $excludeProducts))
			{
				return TRUE;
			}
		}
    }

    /**
     * Removes the add to cart button
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
	public function remove_add_to_cart()
	{
		if(!$this->get_option('removeAddToCart')) {
			return FALSE;
		}

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		// add_filter('woocommerce_grouped_product_columns', array($this, 'grouped_remove_quantity_field'), 10, 2);
	}

	/**
	 * [grouped_remove_quantity_field description]
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @param   [type]                       $grouped_product_columns [description]
	 * @param   [type]                       $product                 [description]
	 * @return  [type]                                                [description]
	 */
	public function grouped_remove_quantity_field($grouped_product_columns, $product)
	{
		if (($key = array_search('quantity', $grouped_product_columns)) !== false) {
		    unset($grouped_product_columns[$key]);
		}
		return $grouped_product_columns;
	}

	/**
	 * Add the add to cart button
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 */
	public function add_add_to_cart()
	{
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}

	/**
	 * Removes the price
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	public function remove_price()
	{
		if(!$this->get_option('removePrice')) {
			return FALSE;
		}

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		// add_filter('woocommerce_grouped_product_columns', array($this, 'grouped_remove_price_field'), 10, 2);
	}

	/**
	 * [grouped_remove_quantity_field description]
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @param   [type]                       $grouped_product_columns [description]
	 * @param   [type]                       $product                 [description]
	 * @return  [type]                                                [description]
	 */
	public function grouped_remove_price_field($grouped_product_columns, $product)
	{
		if (($key = array_search('price', $grouped_product_columns)) !== false) {
		    unset($grouped_product_columns[$key]);
		}
		return $grouped_product_columns;
	}

	/**
	 * Add the price
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 */
	public function add_remove_price()
	{
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	}

	/**
	 * Hard Remove via CSS !important
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	public function hardRemove()
	{
		echo '<style type="text/css">';

		// Prices
		if($this->get_option('hardRemovePrices'))
		{
			echo '.product .price, .price, .woocommerce-mini-cart__total, .woocommerce-Price-amount {
						display:none !important;
					}';

			$excludeProductCategories = $this->get_option('excludeProductCategories');
			$excludeProducts = $this->get_option('excludeProducts');

			if(!empty($excludeProducts) || !empty($excludeProductCategories)) {

				if(!empty($excludeProductCategories)) 
				{
					$excludeProductCategoriesRevert = $this->get_option('excludeProductCategoriesRevert');
					if($excludeProductCategoriesRevert) {
						$style = 'none';
						echo '.product .price, .price, .prices, .woocommerce-Price-amount {
									display:block !important;
								}';
					} else {
						$style = 'block';
					}

					foreach ($excludeProductCategories as $excludeProductCategory) {
						$cat = get_term( $excludeProductCategory, 'product_cat' );
						echo '.term-' . $excludeProductCategory . ' .product .price, .term-' . $excludeProductCategory . ' .summary .prices, .term-' . $excludeProductCategory . ' .price, .product_cat-' . $cat->slug . '.product .summary .price, .product_cat-' . $cat->slug . '.product .summary .prices, .term-' . $excludeProductCategory . ' .woocommerce-Price-amount {
							display: ' . $style . ' !important;
						}';
					}
				}
				
				if(!empty($excludeProducts)) 
				{
					$excludeProductsRevert = $this->get_option('excludeProductsRevert');
					if($excludeProductsRevert) {
						$style = 'none';
						echo '.product .price, .price, .prices, .woocommerce-Price-amount {
									display:block !important;
								}';
					} else {
						$style = 'block';
					}
					foreach ($excludeProducts as $excludeProduct) {
						echo '.post-' . $excludeProduct . ' .summary .price, .post-' . $excludeProduct . ' .summary .prices, #product-' . $excludeProduct . ' .summary .price, li.post-' . $excludeProduct . ' .price, .post-' . $excludeProduct . ' .woocommerce-Price-amount {
							display: ' . $style . ' !important;
						}';
					}
				}
			}
		}

		// Add to Cart
		if($this->get_option('hardRemoveAddToCart'))
		{
			echo '.product .single_add_to_cart_button, .product .add_to_cart_button {
				display:none !important;
			}';

			$excludeProductCategories = $this->get_option('excludeProductCategories');
			$excludeProducts = $this->get_option('excludeProducts');

			if(!empty($excludeProducts) || !empty($excludeProductCategories)) {

				if(!empty($excludeProductCategories)) 
				{
					$excludeProductCategoriesRevert = $this->get_option('excludeProductCategoriesRevert');
					if($excludeProductCategoriesRevert) {
						$style = 'none';
						echo '.product .single_add_to_cart_button, .product .add_to_cart_button, .product .quantity {
									display:block !important;
								}';
					} else {
						$style = 'block';
					}

					foreach ($excludeProductCategories as $excludeProductCategory) {
						$cat = get_term( $excludeProductCategory, 'product_cat' );
						echo '.term-' . $excludeProductCategory . ' .product .single_add_to_cart_button, 
							.term-' . $excludeProductCategory . ' .add_to_cart_button, 
							.product_cat-' . $cat->slug . '.product .add_to_cart_button, 
							.product_cat-' . $cat->slug . '.product .single_add_to_cart_button,
							.product_cat-' . $cat->slug . '.product .quantity {
							display: ' . $style . ' !important;
						}';
					}
				}
				
				if(!empty($excludeProducts)) 
				{
					$excludeProductsRevert = $this->get_option('excludeProductsRevert');
					if($excludeProductsRevert) {
						$style = 'none';
						echo '.product .single_add_to_cart_button, 
							  .product .add_to_cart_button,
							  .product .quantity {
									display:block !important;
								}';
					} else {
						$style = 'block';
					}
					foreach ($excludeProducts as $excludeProduct) {
						echo '.post-' . $excludeProduct . ' .summary .single_add_to_cart_button, 
						#product-' . $excludeProduct . ' .summary  .add_to_cart_button, 
						li.post-' . $excludeProduct . ' .add_to_cart_button,
						#product-' . $excludeProduct . ' .summary  .quantity {
							display: ' . $style . ' !important;
						}';
					}
				}
			}
		}

		echo '</style>';
	}

	/**
	 * Redirects Cart & Checkout
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
    public function redirect_cart_and_checkout_pages()
    {
    	if(is_cart() || is_checkout())
    	{
            wp_redirect( home_url() );
            exit;
    	}
    }

    /**
     * Category pages - Go to product page button
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function loopProductPageButton()
    {
    	global $product;
    	$buttonText = apply_filters('woocommerce_catalog_mode_loop_button_text', $this->get_option('loopButtonText') );

		echo ' <a href="' . 
					esc_url( $product->get_permalink( $product->get_id() ) ) . 
					'" class="woocommerce_catalog_product_button button alt">'. 
					$buttonText. 
					'</a>
				  </a>';
    }

    /**
     * Category pages - go to custom URL
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function loopCustomURLButton()
    {
    	$buttonText = apply_filters('woocommerce_catalog_mode_loop_custom_url_button_text', $this->get_option('loopButtonText') );
    	$buttonURL = apply_filters('woocommerce_catalog_mode_loop_custom_url_button_url', $this->get_option('loopButtonActionURL') );
    	$buttonTarget = apply_filters('woocommerce_catalog_mode_loop_custom_url_button_target', $this->get_option('loopButtonActionURLTarget') );

		echo ' <a target="' . $buttonTarget . '" href="' . $buttonURL . '" class="woocommerce_catalog_custom_button button btn alt">'.$buttonText.'</a>';
    }

    /**
     * Category pages - enquiry form
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function loopEnquiryForm()
    {

    	global $product;

    	if(!$product) {
    		return;
    	}

    	$buttonText = apply_filters('woocommerce_catalog_mode_loop_custom_url_button_text', $this->get_option('loopButtonText') );
    	$product_data = array(
    		'name' => $product->get_name(),
    		'sku' => $product->get_sku(),
    	);
    	$btnExtra = "data-products='" . json_encode($product_data). "'";

		echo '<a href="#" ' . $btnExtra . ' class="enquiryLoopButton button btn alt">' . $buttonText . '</a>';
    }
    

    /**
     * Creates the enquiry button
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function enquiryButton()
    {
    	global $product, $woocommerce;
  		$buttonText = apply_filters('woocommerce_catalog_mode_enquiry_button_text', $this->get_option('singleProductButtonText') );

		if($product->is_type( 'variable' ) && $this->get_option('variationsEnabled'))
		{

			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// Get Available variations?
			$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

			$available_variations = $get_variations ? $product->get_available_variations() : false;
			$attributes           = $product->get_variation_attributes();
			$selected_attributes  = $product->get_default_attributes();

			$attribute_keys  = array_keys( $attributes );
			$variations_json = wp_json_encode( $available_variations );
			$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );


			do_action( 'woocommerce_before_add_to_cart_form' );
						
						
			$variationsDisplay = $this->get_option('variationsDisplay');
			if($variationsDisplay === "dropdown") {

				wp_enqueue_script( 'wc-add-to-cart-variation' );
				?>
				<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
					<?php do_action( 'woocommerce_before_variations_form' ); ?>

					<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
						<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
					<?php else : ?>
						<table class="variations" cellspacing="0">
							<tbody>
								<?php foreach ( $attributes as $attribute_name => $options ) : ?>
									<tr>
										<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
										<td class="value">
											<?php
												wc_dropdown_variation_attribute_options(
													array(
														'options'   => $options,
														'attribute' => $attribute_name,
														'product'   => $product,
													)
												);
												echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
											?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<div class="single_variation_wrap">

							<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
							<input type="hidden" name="variation_id" class="variation_id" value="0" />
							<?php
								/**
								 * Hook: woocommerce_before_single_variation.
								 */
								do_action( 'woocommerce_before_single_variation' );

								/**
								 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
								 *
								 * @since 2.4.0
								 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
								 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
								 */
								// do_action( 'woocommerce_single_variation' );

								/**
								 * Hook: woocommerce_after_single_variation.
								 */
								do_action( 'woocommerce_after_single_variation' );
							?>
						</div>
					<?php endif; ?>

					<?php do_action( 'woocommerce_after_variations_form' ); ?>
				</form>

				<?php
				do_action( 'woocommerce_after_add_to_cart_form' );
				
				
			} else {
			?>
			<h2><?php _e( 'Variations', 'woocommerce-catalog-mode' ); ?></h2>
			<table class="woocommerce-catalog-mode-variations variations-table">
		 		<thead>
		            <tr>
		            	<?php if($this->get_option('variationsShowImage')){ ?>
		                <th><?php _e( '', 'woocommerce-catalog-mode' ); ?></th>
		                <?php } ?>

		            	<?php if($this->get_option('variationsShowSKU')){ ?>
		                <th><?php _e( 'SKU', 'woocommerce-catalog-mode' ); ?></th>
		                <?php } ?>

			            <?php if($this->get_option('variationsShowPrice')){ ?>
			            <th><?php _e('Price', 'woocommerce-catalog-mode') ?></th>
			            <?php } ?>

		                <?php if($this->get_option('variationsShowDescription')){ ?>
		                <th><?php _e('Description', 'woocommerce-catalog-mode') ?></th>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowAttributes')){
		                	$variation_attributes = $product->get_variation_attributes();
		                	foreach ($variation_attributes as $key => $value) {
		                		echo '<th class="variation-attribute-head-' . $key . '">' . wc_attribute_label($key) . '</th>';
		                	}
			            } ?>
						
		            </tr>
		        </thead>
				<tbody>
		        <?php foreach ($available_variations as $variation) : ?>
		            <?php
		               	$variation_product = new WC_Product_Variation( $variation['variation_id'] );
		               	$variation_product->attributes = $variation['attributes'];
		               	$description = get_post_meta( $variation_product->get_id(), '_variation_description', TRUE);
		            ?>
		            <tr>
		            <?php
					if (isset($variation['image_src'])) :
						$image = $variation['image_src'];
					else :
						$image = 0;
					endif;

					if (!$image) $image = woocommerce_placeholder_img_src();
					?>
						<?php if($this->get_option('variationsShowImage')){ ?>
						<td class="variations-image"><?php echo '<img src="'.$image.'">' ?></td>
						<?php } ?>
		            	<?php if($this->get_option('variationsShowSKU')){ ?>
		                <td class="variations-sku"><?php echo $variation_product->get_sku(); ?></td>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowPrice')){ ?>
		                <td class="variations-price"><?php echo $variation_product->get_price_html() ?></td>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowDescription')){ ?>
		                <td class="variations-description"><?php echo $description; ?></td>
		            	<?php } ?>

		                <?php if($this->get_option('variationsShowAttributes')){ ?>
			           		<?php foreach ($variation_product->get_variation_attributes() as $attr_name => $attr_value) : ?>
			                <td class="variations-attributes variation-attribute-value-<?php echo $attr_name ?>">
			                <?php
			                    // Get the correct variation values
			                    if (strpos($attr_name, '_pa_')){ // variation is a pre-definted attribute
			                        $attr_name = substr($attr_name, 10);
			                        $attr = get_term_by('slug', $attr_value, $attr_name);
			                        $attr_value = $attr->name;

			                        $attr_name = wc_attribute_label($attr_name);
			                    } else {
			                        $attr = maybe_unserialize( get_post_meta( $this->product->id, '_product_attributes' ) );
			                        $attr_name = substr($attr_name, 10);
			                        $attr_name = $attr[0][$attr_name]['name'];
			                    }
			                    if(empty($attr_value)) {
			                    	echo sprintf( __('Any %s', 'woocommerce-pdf-catalog'), $attr_name);
		                    	} else {
		                    		echo $attr_value;
	                    		}
			                ?>
			                </td>
				            <?php endforeach; ?>
			             <?php } ?>
		            </tr>
		        <?php endforeach;?>
		        </tbody>
		    </table>
        <?php
        	}
	    }
	    ?>


		<button id="enquiryButton" type="button" class="btn button btn-primary btn-lg">
			<?php echo $buttonText ?>
		</button>

		
	<?php
	}

	/**
	 * Creates the enquiry button
	 *
	 * @since    1.0.0
	 */
    public function enquiryModal()
    {
    	global $product;
  		$contactForm =  apply_filters('woocommerce_catalog_mode_single_product_modal_contact_form', $this->get_option('singleProductButtonContactform') );
  		$modalSize = $this->get_option('singleProductButtonModalSize');
  		$modalTitle = apply_filters('woocommerce_catalog_mode_single_product_modal_title', $this->get_option('singleProductButtonModalTitle'));
  		?>

		<!-- Modal -->
		<div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="sendEnquiry">
			<div class="modal-dialog <?php echo $modalSize ?>" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button id="enquiryClose" type="button" class="button close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="sendEnquiry"><?php echo $modalTitle ?></h4>
					</div>
					<div class="modal-body">
						<?php echo do_shortcode($contactForm) ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * Custom Button on single product pages
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
    public function singleProductCustomURLButton()
    {
    	global $product, $woocommerce;

    	$buttonText = apply_filters('woocommerce_catalog_mode_single_product_button_text', $this->get_option('singleProductButtonText') );
    	$buttonURL = apply_filters('woocommerce_catalog_mode_single_product_button_url', $this->get_option('singleProductButtonActionURL') );
    	$buttonTarget = apply_filters('woocommerce_catalog_mode_single_product_button_target', $this->get_option('singleProductButtonActionURLTarget') );

		if($product->is_type( 'variable' ) && $this->get_option('variationsEnabled') && ($this->get_option('variationsDisplay') == "table"))
		{
			$attributes = $product->get_variation_attributes();
			$attribute_keys = array_keys( $attributes );
			$available_variations = $product->get_available_variations();

			if( version_compare( $woocommerce->version, '3.0.0', ">=" ) ) {
				$selected_attributes = $product->get_default_attributes();
			} else {
				$selected_attributes = $product->get_variation_default_attributes();
			}
			
			?>
			<h2><?php _e( 'Variations', 'woocommerce-catalog-mode' ); ?></h2>
			<table class="woocommerce-catalog-mode-variations variations-table">
		 		<thead>
		            <tr>
		            	<?php if($this->get_option('variationsShowImage')){ ?>
		                <th><?php _e( '', 'woocommerce-catalog-mode' ); ?></th>
		                <?php } ?>

		            	<?php if($this->get_option('variationsShowSKU')){ ?>
		                <th><?php _e( 'SKU', 'woocommerce-catalog-mode' ); ?></th>
		                <?php } ?>

			            <?php if($this->get_option('variationsShowPrice')){ ?>
			            <th><?php _e('Price', 'woocommerce-catalog-mode') ?></th>
			            <?php } ?>

		                <?php if($this->get_option('variationsShowDescription')){ ?>
		                <th><?php _e('Description', 'woocommerce-catalog-mode') ?></th>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowAttributes')){
		                	$variation_attributes = $product->get_variation_attributes();
		                	foreach ($variation_attributes as $key => $value) {
		                		echo '<th class="variation-attribute-head-' . $key . '">' . wc_attribute_label($key) . '</th>';
		                	}
			            } ?>
						
		            </tr>
		        </thead>
				<tbody>
		        <?php foreach ($available_variations as $variation) : ?>
		            <?php
		               	$variation_product = new WC_Product_Variation( $variation['variation_id'] );
		               	$variation_product->attributes = $variation['attributes'];
		               	$description = get_post_meta( $variation_product->get_id(), '_variation_description', TRUE);
		            ?>
		            <tr>
		            <?php
					if (isset($variation['image_src'])) :
						$image = $variation['image_src'];
					else :
						$image = 0;
					endif;

					if (!$image) $image = woocommerce_placeholder_img_src();
					?>
						<?php if($this->get_option('variationsShowImage')){ ?>
						<td class="variations-image"><?php echo '<img src="'.$image.'">' ?></td>
						<?php } ?>
		            	<?php if($this->get_option('variationsShowSKU')){ ?>
		                <td class="variations-sku"><?php echo $variation_product->get_sku(); ?></td>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowPrice')){ ?>
		                <td class="variations-price"><?php echo $variation_product->get_price_html() ?></td>
		                <?php } ?>

		                <?php if($this->get_option('variationsShowDescription')){ ?>
		                <td class="variations-description"><?php echo $description; ?></td>
		            	<?php } ?>

		                <?php if($this->get_option('variationsShowAttributes')){ ?>
			           		<?php foreach ($variation_product->get_variation_attributes() as $attr_name => $attr_value) : ?>
			                <td class="variations-attributes variation-attribute-value-<?php echo $attr_name ?>">
			                <?php
			                    // Get the correct variation values
			                    if (strpos($attr_name, '_pa_')){ // variation is a pre-definted attribute
			                        $attr_name = substr($attr_name, 10);
			                        $attr = get_term_by('slug', $attr_value, $attr_name);
			                        $attr_value = $attr->name;

			                        $attr_name = wc_attribute_label($attr_name);
			                    } else {
			                        $attr = maybe_unserialize( get_post_meta( $this->product->id, '_product_attributes' ) );
			                        $attr_name = substr($attr_name, 10);
			                        $attr_name = $attr[0][$attr_name]['name'];
			                    }
			                    if(empty($attr_value)) {
			                    	echo sprintf( __('Any %s', 'woocommerce-pdf-catalog'), $attr_name);
		                    	} else {
		                    		echo $attr_value;
	                    		}
			                ?>
			                </td>
				            <?php endforeach; ?>
			             <?php } ?>
		            </tr>
		        <?php endforeach;?>
		        </tbody>
		    </table>
        <?php
	    }

		echo ' <a id="woocommerce-catalog_custom_button" target="' . $buttonTarget . '" href="' . $buttonURL . '" class="woocommerce_catalog_single_custom_button button alt">'.$buttonText.'</a>
				  </a>';
    }  

    /**
     * Custom Free Text
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
	public function customFreePriceText($priceText) {

		$customFreePriceText = apply_filters('woocommerce_catalog_mode_custom_free_price_text', $this->get_option('customFreePriceText') );

		global $product;

		if(!$product) {
			return;
		}

		$price = $product->get_price();

		if($price != '0.00' && $price != "") {
		    return $priceText;
		}

		if(!empty($customFreePriceText)) {
			return $customFreePriceText;
		}

		return "Available in store";
	}

	/**
	 * Return the current user role
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
	private function get_user_role()
	{
		global $current_user;

		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		return $user_role;
	}

	public function enquiry_cart_button_text()
	{
		global $product;
		
		if(!$product) {
			return;
		}

		$product_type = $product->get_type();
		
		$btnText = $this->get_option('enquiryCartBasketBtnText');

		switch ( $product_type ) {
			case 'external':
				return $btnText;
			break;
			case 'grouped':
				return $btnText;
			break;
			case 'simple':
				return $btnText;
			break;
			case 'variable':
				return $btnText;
			break;
			default:
				return $btnText;
		}
	}

	public function remove_coupon_from_cart()
	{
		return false;
	}

	public function add_enquiry_cart_button()
	{
		$btnText = $this->get_option('enquiryCartBtnText');
    	$cart = WC()->cart->get_cart();
    	$btnExtra = '';
    	if(empty($cart)) {
    		$btnExtra = 'disabled="disabled"';
    	} else {
    		$product_data = array();
    		$currency_symbol = get_woocommerce_currency_symbol();

    		foreach ($cart as $cart_key => $cart_item) {
    			if(!empty($cart_item['data'])) {
    				$product = $cart_item['data'];

    				$variationInformation = wc_get_formatted_cart_item_data( $cart_item );
    				// $variationInformation = preg_replace('/\s+/', '', $variationInformation);
    				$variationInformation = str_replace( array('	', "\n", '</p>', ':'), array('', '', "\n", ': '), $variationInformation);
    				
    				$variationInformation = strip_tags( $variationInformation);

    				if( class_exists( 'PWC_Woo_Actions_Filters' ) ) {
    					$PWC_Woo_Config = $this->PWC_Woo_add_configs_after_cart_item_name($cart_item, $cart_key);
						if(!empty($PWC_Woo_Config)) {
							$PWC_Woo_Config = str_replace( array('	', "\n", '</p>', ':'), array('', '', "\n", ': '), $PWC_Woo_Config);
							$PWC_Woo_Config = strip_tags( html_entity_decode( $PWC_Woo_Config) );
							$variationInformation .= $PWC_Woo_Config;
						}
					}

    				$product_data[] = array(
    					'name' => str_replace(array("'", "’", "`", "‘"), "", $product->get_name()  ),
    					'price' => $currency_symbol . $product->get_price(),
    					'sku' => $product->get_sku(),
    					'quantity' => $cart_item['quantity'],
    					'variationInformation' => str_replace(array("'", "’", "`", "‘"), "", $variationInformation),
    				);
    			}
    		}
    		$btnExtra = "data-products='" . json_encode( $product_data). "'";
    	}


		?>
		<button id="enquiryCartButton" type="button" <?php echo $btnExtra ?> class="btn button btn-primary btn-lg">
			<?php echo $btnText ?>
		</button>
		<?php
	}

	public function PWC_Woo_add_configs_after_cart_item_name( $cart_item, $cart_item_key ) {
		$output = '';

		// base price
		$base_price = isset( $cart_item['pwc_base_price'] ) ? $cart_item['pwc_base_price'] : '';

		$output .= '<p class="pwc-inner pwc-child"><strong>'. esc_html__( 'Base Price', 'product-woo-configurator' ) . '</strong> <span>- (' . pwc_apply_currency_postion( $base_price )  . ')</span></p>';

		// user configuration
		$active_array = isset( $cart_item['user_config'] ) && !empty( $cart_item['user_config'] ) ? $cart_item['user_config'] : '';

		if ( $active_array && ! empty( $active_array ) ) {

			foreach ( $active_array as $key => $value ) {				
				
				$value['price'] = ( $value['price'] == '' ) ? '0' : $value['price'];

				if( isset( $value['parent'] ) && $value['parent'] ) {
					$output .= '<p class="pwc-inner pwc-child">'. sprintf( '<strong>%s</strong> - %s <span>(%s)</span>', $value['parent']['parent_name'], $value['name'], pwc_apply_currency_postion( $value['price'] ) ).'</p>';
				} else {							
					$output .= '<h4 class="pwc-title pwc-parent">'. sprintf( '%s <span>(%s)</span>', $value['name'], pwc_apply_currency_postion( $value['price'] ) ) .'</h4>';
				}				

			}

		}

		return $output;
	}

    /**
     * Category pages - go to custom URL
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  [type]                       [description]
     */
    public function add_enquiry_url_button()
    {
    	$btnText = $this->get_option('enquiryCartBtnText');
    	$buttonURL = $this->get_option('enquiryCartBtnActionURL');
    	$buttonTarget = $this->get_option('enquiryCartBtnActionURLTarget');

		echo ' <a target="' . $buttonTarget . '" href="' . $buttonURL . '" class="woocommerce-catalog-mode-cart-enquiry-button button alt">' . $btnText . '</a>';
    }

	/**
	 * Enquiry Cart Modal
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    https://www.welaunch.io
	 * @return  [type]                       [description]
	 */
    public function enquiryCartModal()
    {
    	global $product;

  		$contactForm =  $this->get_option('enquiryCartContactform');
  		$modalSize = $this->get_option('enquiryCartModalSize');
  		$modalTitle = $this->get_option('enquiryCartModalTitle');
  		?>

		<!-- Modal -->
		<div class="modal fade" id="enquiryCartModal" tabindex="-1" role="dialog" aria-labelledby="sendEnquiryCart">
			<div class="modal-dialog <?php echo $modalSize ?>" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button id="enquiryCartClose" type="button" class="button close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="sendEnquiryCart"><?php echo $modalTitle ?></h4>
					</div>
					<div class="modal-body">
						<?php echo do_shortcode($contactForm) ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	public function clear_cart()
	{
	    global $woocommerce;
	    $woocommerce->cart->empty_cart();

	    return true;
	}
}