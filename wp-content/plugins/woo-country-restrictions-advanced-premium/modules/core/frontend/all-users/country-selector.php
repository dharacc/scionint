<?php
if (!class_exists('WCACR_Country_Selector')) {

	class WCACR_Country_Selector {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {
			add_action('wp_enqueue_scripts', array($this, 'enqueue_country_selector'), 1);
			add_filter('vcwccr_set_user_country', array($this, 'set_user_country_from_selector'), 10, 2);
			add_shortcode('vcwccr_country_selector', array($this, 'render_country_selector_shortcode'));
			add_action('vcwccr_after_set_user_country', array($this, 'after_set_user_country'), 10, 2);
			add_action('init', array($this, 'calculate_shipping'));

			// We can't add the fragments on normal page requests because
			// WC saves them in the session storage and overwrites our selected country
			// so we only update through the fragments during ajax calls
			if (wp_doing_ajax() || !empty($_GET['wc-ajax'])) {
				add_filter('woocommerce_add_to_cart_fragments', array($this, 'update_country_selector_after_ajax_call'));
				add_filter('woocommerce_update_order_review_fragments', array($this, 'update_country_selector_after_ajax_call'));
			}
			add_filter('wcacr_cache_check_output', array($this, 'update_country_selector_after_ajax_call'));

			add_action('wp_footer', array($this, 'render_popup'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
		}

		function enqueue_assets() {
			wp_enqueue_script('wcacr-country-selector', VCWCCR_URL . '/assets/js/country-selector.js', array('jquery'), filemtime(VCWCCR_PATH . '/assets/js/country-selector.js'));
			wp_localize_script('wcacr-country-selector', 'wcacr_country_selector_data', array(
				'cookie_name' => WCACR_USER_COUNTRY_COOKIE
			));
		}

		function render_popup() {
			if (!get_option('wccr_country_selector_show_popup')) {
				return;
			}
			$message = get_option('wccr_country_selector_popup_intro');
			if (empty($message)) {
				$message = '<h3>' . __('Select your country', VCWCCR_TEXT_DOMAIN) . '</h3>';
			}

			$full_selector = $this->get_menu_item_html();
			?>
			<style>
				.wcacr-country-selector-popup-shadow,
				.wcacr-country-selector-popup {
					display: none;
				}
				.wcacr-country-selector-popup-shadow.wcacr-visible {
					display: block;
					position: fixed;
					width: 100%;
					height: 100%;
					z-index: 10000000;
					background: rgba(0, 0, 0, 0.34);
					top: 0;
					left: 0;
				}
				.wcacr-country-selector-popup.wcacr-visible {
					display: block;
					position: fixed;
					width: 100%;
					max-width: 500px;
					height: auto;
					background: white;
					padding: 20px;
					text-align: center;
					z-index: 10000000;
				}
				.wcacr-country-selector-popup.wcacr-visible .wcacr-close {
					position: absolute;
					top: 10px;
					right: 10px;
					text-align: right;		
				}
				.wcacr-country-selector-popup.wcacr-visible .wcacr-current-country-link {
					border: 1px solid #444;
				}
				.wcacr-country-selector-popup.wcacr-visible li {
					list-style: none;
				}
				.wcacr-country-selector-popup.wcacr-visible a {
					display: block;
					text-align: left;
					padding: 10px;
				}
				.wcacr-country-selector-popup.wcacr-visible ul {
					margin: 0;
					overflow: auto;
				}
				.wcacr-country-selector-popup.wcacr-visible ul ul li {
					width: 50%;
					display: inline-block;
					float: left;
				}
				.wcacr-country-selector-popup.wcacr-visible ul ul {
					max-height: 225px;    
				}
				.wccr-country-selector li.menu-item {
					padding: 0 !important;
					display: block !important;
				}

				.wccr-country-selector .dropdown-menu li a {
					padding: 5px !important;
					width: auto !important;
				}

				li.wccr-country-selector .dropdown-menu a,
				li.wccr-country-selector {
					color: black !important;
				}

				.wccr-country-selector .dropdown-menu {
					z-index: 9999999;
					height: auto;
				}
			</style>
			<div class="wcacr-country-selector-popup-shadow"></div>
			<div class="wcacr-country-selector-popup">
				<a href="#wcacr-close" class="wcacr-close">Close</a>

				<?php echo wp_kses_post($message); ?>
				<ul class="wccr-country-selector-independent"><?php echo $full_selector; ?></ul>
			</div>
			<?php
		}

		function update_country_selector_after_ajax_call($fragments) {

			$full_selector = $this->get_menu_item_html();
			if ($full_selector) {
				$fragments['li.wccr-country-selector.menu-item'] = $full_selector;
			}
			return $fragments;
		}

		function calculate_shipping() {
			if (!empty($_POST['calc_shipping_country']) && is_object(WC()->customer) && get_option('wccr_country_selector_linked_shipping_country') === 'yes') {
				$_GET['wccr_country'] = $_POST['calc_shipping_country'];
				wcacr_set_user_country($_POST['calc_shipping_country']);
			}
		}

		function after_set_user_country($my_country, $geolocation_method) {

			$option_key = ( $geolocation_method === 'primary') ? 'wccr_geolocation_method' : 'wccr_secondary_geolocation_method';
			if (get_option($option_key) === 'country_selector' && !empty($_GET['wccr_country']) && !headers_sent() && !wp_doing_ajax() && empty($_GET['wcacr_ajax'])) {
				wp_redirect(remove_query_arg('wccr_country'));
				exit();
			}
		}

		function render_country_selector_shortcode($atts = array(), $content = '') {
			return '<ul class="wccr-country-selector-independent"></ul>';
		}

		function set_user_country_from_selector($my_country, $geolocation_method) {
			$option_key = ( $geolocation_method === 'primary') ? 'wccr_geolocation_method' : 'wccr_secondary_geolocation_method';
			if (get_option($option_key, 'ip') === 'country_selector') {
				if (!empty($_GET['wccr_country'])) {
					$my_country = sanitize_text_field($_GET['wccr_country']);
				} elseif (get_option('wccr_default_country') && empty($_COOKIE[WCACR_USER_COUNTRY_COOKIE])) {
					$my_country = get_option('wccr_default_country');

					// If default country from settings page is empty , use the IP geolocation
					if (empty($my_country) && class_exists('WC_Geolocation')) {
						$location = WC_Geolocation::geolocate_ip('', true);
						$my_country = $location['country'];
					}
				} elseif (!empty($_COOKIE[WCACR_USER_COUNTRY_COOKIE])) {
					$my_country = $_COOKIE[WCACR_USER_COUNTRY_COOKIE];
				}

				if (is_object(WC()->customer) && $my_country && get_option('wccr_country_selector_linked_shipping_country') === 'yes') {
					WC()->customer->set_billing_country($my_country);
					WC()->customer->set_shipping_country($my_country);
				}
			}

			return $my_country;
		}

		function get_countries_list() {
			$default_country = wcacr_get_user_country();
			$allowed_countries = get_option('wccr_country_selector_options');
			$list = array();
			if (empty($allowed_countries)) {
				$allowed_countries = array_keys(WC()->countries->get_shipping_countries());
			}

			if (!$default_country || !$allowed_countries) {
				return $list;
			}
			$allowed_countries = vcwccr_replace_continent($allowed_countries);
			$show_icon = apply_filters('vcwccr_country_selector/show_icon', true, $default_country, $allowed_countries);
			$countries_with_abbreviation = vcwccr_get_countries();
			foreach ($countries_with_abbreviation as $abbreviation => $country_name) {

				if (!in_array($abbreviation, $allowed_countries) && $abbreviation !== $default_country) {
					continue;
				}

				if ($show_icon) {
					$icon_url = VCWCCR_URL . 'assets/imgs/flags/' . strtolower($abbreviation) . '.png';
					$icon_path = str_replace(VCWCCR_URL, VCWCCR_PATH, $icon_url);
					if (!file_exists($icon_path)) {
						continue;
					}
				} else {
					$icon_path = '';
					$icon_url = '';
				}

				$list[$abbreviation] = array(
					'flag_url' => $icon_url,
					'flag_path' => $icon_path,
					'name' => $country_name,
					'abbreviation' => $abbreviation,
					'is_current_country' => $abbreviation === $default_country,
				);
			}

			return $list;
		}

		function get_menu_item_html() {

			$list = $this->get_countries_list();
			if (empty($list)) {
				return;
			}

			$current_country_name_enabled = !empty(get_option('wccr_country_selector_full_name'));
			$dropdown = array();

			$current_menu_item = '';
			foreach ($list as $abbreviation => $country_data) {

				$display_name = ( $country_data['is_current_country'] && !$current_country_name_enabled) ? '' : $country_data['name'];
				$url = (!empty($_GET['wc-ajax']) && wp_doing_ajax() ) ? add_query_arg('wccr_country', $abbreviation, wp_get_referer()) : add_query_arg('wccr_country', $abbreviation);
				$url = apply_filters('wcacr_country_selector/link_url', remove_query_arg(array('wcacr_ajax', 'wcacr', 'wcacra', 'wc-ajax'), $url), $country_data);
				$icon = (!empty($country_data['flag_url'])) ? '<img src="' . $country_data['flag_url'] . '" alt="Country ' . esc_attr($country_data['name']) . '" /> ' : '';

				$out = '<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="' . esc_url($url) . '" data-country-name="' . esc_attr($country_data['name']) . '">' . $icon . $display_name . '</a>';

				if ($country_data['is_current_country']) {
					$current_menu_item = str_replace('class="', 'class=" wcacr-current-country-link ', $out);
				} else {
					$dropdown[$abbreviation] = $out;
				}
			}

			if (!$current_menu_item) {
				return;
			}
			$dropdown = apply_filters('wcacr_country_selector/dropdown', $dropdown, $list, $current_country_name_enabled);

			$full_selector = '<li class="wccr-country-selector menu-item menu-item-has-children dropdown ubermenu-item ubermenu-item-has-children ubermenu-item-level-0 ubermenu-column ubermenu-has-submenu-drop">' . $current_menu_item . '<ul class="dropdown-menu sub-menu"><li class="menu-item">' . implode('</li><li class="menu-item">', $dropdown) . '</li></ul></li>';
			return $full_selector;
		}

		function enqueue_country_selector() {
			if (get_option('wccr_geolocation_method', 'ip') !== 'country_selector') {
				return;
			}

			$full_selector = $this->get_menu_item_html();
			if (!$full_selector) {
				return;
			}

			$menus = get_option('wccr_country_selector_menu_targets');
			$menu_targets = array();

			if (is_array($menus) && !empty($menus)) {
				$menu_targets_raw = get_terms(array(
					'taxonomy' => 'nav_menu',
					'hide_empty' => false,
					'include' => $menus
				));
				if (is_array($menu_targets_raw)) {
					$menu_targets = wp_list_pluck($menu_targets_raw, 'slug');
				}
			}

			if (in_array('none', $menus, true)) {
				$menu_targets = array('none');
			}
			?>

			<style>
				li.wccr-country-selector.menu-item {
					position: relative;
					list-style: none;
				}

				.wccr-country-selector img {
					display: inline-block
				}

				#wprmenu_menu .wccr-country-selector .dropdown-menu {
					background-color: transparent;
					width: 100%!important;
					min-width: 185px;
					display: block
				}

				#wprmenu_menu.wprmenu_levels .wccr-country-selector .dropdown-menu li {
					padding-left: 0!important
				}

				#wprmenu_menu.wprmenu_levels .wccr-country-selector .dropdown-menu a {
					color: #fff!important
				}

				#wprmenu_menu.wprmenu_levels .wccr-country-selector .dropdown-menu li:hover {
					background-color: transparent
				}

				.wccr-country-selector .dropdown-menu {
					display: none;
					position: absolute;
					padding: 10px 5px;
					text-align: left;
					font-size: 14px;
					font-family: arial
				}
				.wccr-country-selector:hover .dropdown-menu {
					display: block
				}

				ul.wcacr-floating-flags {
					position: fixed;
					top: 0;
					right: 0;
					list-style: none;
					text-align: right;
					z-index: 99999;
					margin: 0
				}

				ul.wcacr-floating-flags>li {
					padding: 5px 20px
				}

				ul.wcacr-floating-flags .wccr-country-selector .dropdown-menu {
					right: 0;
				}
				.wccr-country-selector .dropdown-menu li a {
					width: auto;
				}
				.wccr-country-selector .dropdown-menu {
					background: #fff;
					z-index: 99;
					width: 100%;
					min-width: 185px;
					margin: 0;
					list-style: none;
					max-height: 240px;
					overflow-y: scroll
				}
			</style>
			<?php
			// We save the script in a string to enqueue it inline
			ob_start();
			?> 
			<script>
				function wcacrInitCountrySelector() {
					var menuTargets = <?php echo json_encode($menu_targets); ?>;
					var fullHtml = <?php echo json_encode($full_selector); ?>;
					var $menuContainers = [];

					if (menuTargets.indexOf('none') < 0) {
						if (menuTargets.length) {
							var regex = new RegExp("^menu-(" + menuTargets.join('|') + ")(-\d+)?");
							$menuContainers.push(jQuery('li.menu-item').parent().filter(function () {
								return regex.test(jQuery(this).attr('id'));
							}));
						} else {
							$menuContainers.push(jQuery('li.menu-item:first, li.page_item:first').parent(), jQuery('#wprmenu_menu_ul'), jQuery('#responsive-menu-pro-container li.menu-item:first').parent(), jQuery('.ubermenu-nav'));
						}
					}

					$menuContainers.push(jQuery('.wccr-country-selector-independent'));

					console.log('$menuContainers: ', $menuContainers, ' fullHtml: ', fullHtml);
					$menuContainers.forEach(function (container) {
						console.log('container: ', container, 'exists? ', container.find('.wccr-country-selector'));
						if (container.length) {
							container.each(function () {
								var $location = jQuery(this);
								if (!$location.find('.wccr-country-selector').length) {
									$location.append(fullHtml);

									if (($location.find('.wccr-country-selector').offset().left + 240) > jQuery(window).width()) {
										$location.find('.wccr-country-selector .dropdown-menu').css('right', '0px');
									}
								}
							});
						}
					});

					setTimeout(function () {
						var hasHeaderContainers = false;

						$menuContainers.forEach(function (container) {
							var headerContainers = container.filter(function () {
								return jQuery(this).offset() && jQuery(this).offset().top < 700;
							});
							if (headerContainers.length) {
								hasHeaderContainers = true;
								return true;
							}
						});
						if (!hasHeaderContainers && !jQuery('.wcacr-floating-flags').length) {
							jQuery('body').append('<ul class="wcacr-floating-flags">' + fullHtml + '</ul>');
						}
					}, 1000);
				}
				jQuery(document).ready(function () {
					// Init early to add selector to the early menus before the plugins JS initializes
					// this helps with mobile menus or fancy menus that modify the DOM on initialization
					wcacrInitCountrySelector();

					// Late init to make it work on menus found near the footer
					setTimeout(function () {
						wcacrInitCountrySelector();
					}, 1000);

					jQuery('body').on('click', 'a.wcacr-current-country-link', function (e) {
						e.preventDefault();
					});
				});
			</script>
			<?php
			$script = ob_get_clean();
			global $wp_version;
			$after = (version_compare($wp_version, '5.5') < 0 ) ? 'jquery-migrate' : 'jquery';
			wp_add_inline_script($after, str_replace(array('<script>', '</script>'), '', $script));
			if (!wp_script_is('jquery', 'done')) {
				wp_enqueue_script('jquery');
			}
		}

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @return  Foo A single instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_Country_Selector::$instance) {
				WCACR_Country_Selector::$instance = new WCACR_Country_Selector();
				WCACR_Country_Selector::$instance->init();
			}
			return WCACR_Country_Selector::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_Country_Selector_Obj')) {

	function WCACR_Country_Selector_Obj() {
		return WCACR_Country_Selector::get_instance();
	}

}

WCACR_Country_Selector_Obj();
