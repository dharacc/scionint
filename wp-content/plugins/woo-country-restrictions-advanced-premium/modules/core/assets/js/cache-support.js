// Cache support
jQuery(document).ready(function () {
	var userAgent = navigator.userAgent;
	if (userAgent.toLowerCase().match(/(bot|spider|crawl)/)) {
		return true;
	}


	// The ajax checks are executed and applied on the single product pages, homepage, shop
	// category pages, attribute pages, tag pages
	if (!jQuery('body')[0].className.match(/(search|single-product|home|post-type-archive-product|tax-product)/)) {
		jQuery('#wcacr-cache-support-css').remove();
		return true;
	}

	var productId = getCurrentProductId();

	// If we viewed a variable product and the visitor is allowed, we reloaded the page with the ?wcacra parameter
	// and when this page reload happens, we show the price and add-to-cart elements directly
	if (productId && window.location.href.indexOf('wcacra=') > -1) {
		jQuery('form.cart').show();
		jQuery('.wcacr-add-to-cart-marker').parents('form').show();
		jQuery('.wcacr-price').show();

		// Exit, no need to check restrictions with ajax again
		return true;
	}

	function getRandomInt(min, max) {
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function getCurrentProductId() {
		var id = null;
		var classes = jQuery('body')[0].className;
		if (classes.indexOf('single-product') > -1 && classes.indexOf(' postid-') > -1) {
			id = parseInt(classes.replace(/.+ postid-(\d+) .+/, '$1'));
		}
		return id;
	}

	function enforceProductRestrictions(restrictions) {
		if (restrictions.product_type.indexOf('variable') > -1) {
			// We update the price ranges.
			// By default, WC shows the price ranges of all the variations
			// but we don't want to show prices of restricted variations
			if (jQuery('.wcacr-price').length && restrictions.new_price) {
				jQuery('.wcacr-price').replaceWith(restrictions.new_price);
			}

			if (restrictions.visible_variations_count > 0 && !restrictions.is_product_restricted) {
				// When viewing a variable product and the user is allowed, we need to refresh the page
				// because the cached add-to-cart form might not have all the variations when the page loaded
				// or it might have all the variations including disallowed ones
				//  so we can't just show the add-to-cart form with css
				if (wcacr_cache_support_data.wccr_allow_variations_redirection !== 'no') {
					window.location.href = window.location.href.split('?')[0] + '?wcacra=' + getRandomInt(1, 9999999);
				}
			} else {
				// When the user is not allowed to buy any variations,
				// we consider the entire product as restricted.
				// This is necessary to hide the add-to-cart, show the custom restriction 
				// message (otherwise WC shows the default "stock not available" message)
				// and show/hide the prices based on the settings
				restrictions.is_product_restricted = true;
			}
		}

		if (restrictions.is_product_restricted) {
			jQuery('body').addClass('wcacr-restriction-applied');
			// Remove "add to cart" form if the product is restricted
			jQuery('.wcacr-add-to-cart-marker').parents('form').remove();

			// Maybe show or hide the prices
			if (jQuery('body').hasClass('restriction-method-disable_add_to_cart_prices')) {
				jQuery('.wcacr-price').remove();
			} else {
				jQuery('.wcacr-price').show();
			}
		} else {
			jQuery('form.cart').show();
			jQuery('.wcacr-price').show();
			jQuery('.wcacr-add-to-cart-marker').parents('form').show();
		}
	}

	function enforceGlobalRestrictions(restrictions) {
		var $prices = jQuery('.product .price');
		if (restrictions.is_shop_available) {
			$prices.show();
		} else {
			jQuery('body').addClass('wcacr-restriction-applied');

			// Maybe show or hide the prices
			if (jQuery('body').hasClass('restriction-method-disable_add_to_cart_prices')) {
				$prices.remove();
			} else {
				$prices.show();
			}
		}
	}

	function enforceRestrictions(restrictions, fromCache) {
		console.log(restrictions);

		jQuery('body').addClass(restrictions.body_classes);

		if (productId) {
			enforceProductRestrictions(restrictions);
		}
		enforceGlobalRestrictions(restrictions);


		// Maybe show notices
		if (restrictions.notice_plain_message && jQuery('body').hasClass('wcacr-restriction-applied')) {
			var noticedShown = false;
			jQuery('.woocommerce-error').each(function () {
				if (jQuery(this).html().indexOf(restrictions.notice_plain_message) > -1) {
					noticedShown = true;
				}
			});
			if (!noticedShown) {
				jQuery('.wcacr-notices-marker').after(restrictions.notices);
			}
		}

		// Update the country selector in case the country changed during the ajax call
		if (!fromCache && restrictions['li.wccr-country-selector.menu-item']) {
			jQuery(restrictions['li.wccr-country-selector.menu-item']).replaceAll('li.wccr-country-selector.menu-item');
		}
	}

	function getCountry() {
		var country = '';
		if (window.location.href.indexOf('wccr_country=') > -1) {
			country = window.location.href.replace(/.+wccr_country=([A-Za-z]{2}).*/, '$1');
		} else if (wcacrGetCookie('wcacr_user_country')) {
			country = wcacrGetCookie('wcacr_user_country');
		}
		return country;
	}

	function getBaseCacheKey() {
		return 'wcacr_ajax_checks' + getCountry();
	}

	function setCacheItem(cacheKey, value) {

		var cache = jQuery.parseJSON(sessionStorage.getItem(getBaseCacheKey()));
		if (!cache) {
			cache = {};
		}

		cache[cacheKey] = value;
		try {
			sessionStorage.setItem(getBaseCacheKey(), JSON.stringify(cache));
		} catch (err) {
		}

	}
	function getCacheItem(cacheKey) {
		var out = null;
		try {
			var cache = jQuery.parseJSON(sessionStorage.getItem(getBaseCacheKey()));
			if (!cache) {
				cache = {};
			}

			if (typeof cache[cacheKey] !== 'undefined') {
				out = cache[cacheKey];
			}
		} catch (err) {
		}
		return out;
	}

	function applyRestrictions() {
		if (productId && getCacheItem('product' + productId)) {
			enforceRestrictions(getCacheItem('product' + productId), true);
			return true;
		} else if (!productId && getCacheItem('global')) {
			enforceRestrictions(getCacheItem('global'), true);
			return true;
		}

		var url = (window.location.href.indexOf('?') > -1) ? window.location.href + '&' : window.location.href + '?';
		url += '&wcacr_ajax=1&wcacr=';
		// We remove the country selector parameter from the URL to prevent the 
		// 302 redirection made by the country selector, which breaks our ajax request
//	url = url.replace(/wccr_country=[A-Za-z]{2}/, '');

		jQuery.post(url + getRandomInt(1, 9999999), {
			wcacr_cache_buster_product_id: productId
		}, function (response) {
			if (response.success) {
				if (productId) {
					cacheKey = 'product' + productId;
					setCacheItem(cacheKey, response.data);
				}

				setCacheItem('global', response.data);
				enforceRestrictions(response.data, false);
			}
		});
	}

	applyRestrictions();
});