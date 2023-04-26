(function( $ ) {
	'use strict';

	$(document).ready(function() {

		var enquiryButton = $('#enquiryButton');
		var enquiryLoopButton = $('.enquiryLoopButton');
		var enquiryModal = $('#enquiryModal');
		// var enquiryModalSKU = enquiryModal.find('input[name="' + woocommerce_catalog_mode_options.skuField + '"]');
	    
	    $('body').on('click', '#enquiryButton', function() {
		    insertProductIntoForm();
		    insertSKUIntoForm();
	    	enquiryModal.show();

		    if (typeof enquiryModal.model !== "undefined") { 
		    	enquiryModal.modal('show');
			}
	    });

	    enquiryLoopButton.on('click', function() {

	    	var data = $(this).data('products');

			var enquiryModalSKU = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.skuField + '"]');
		    if(typeof data.sku != "undefined"){
		    	enquiryModalSKU.val(data.sku);
		    	enquiryModalSKU.attr('value', data.sku);
		    }

			var enquiryModalProduct = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.productField + '"]');
			if(typeof data.name != "undefined" && data.name != ""){
		    	enquiryModalProduct.val(data.name);
		    	enquiryModalProduct.attr('value', data.name);
		    }

	    	enquiryModal.show();
	    	
		    if (typeof enquiryModal.model !== "undefined") { 
		    	enquiryModal.modal('show');
			}
	    });

	    var enquiryVariationButton = $('.enquiryVariationButton');
	    $('body').on('click', '.enquiryVariationButton', function() {

			var enquiryModalSKU = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.skuField + '"]');
			var enquiryModalProduct = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.productField + '"]');

		    enquiryModalSKU.val($(this).data('sku'));
			enquiryModalProduct.val($(this).data('name'));
	    	enquiryModal.show();
		    if (typeof enquiryModal.model !== "undefined") { 
		    	enquiryModal.modal('show');
			}
	    });

	    $('#enquiryClose').on('click', function() {
	    	enquiryModal.hide();
	    	$('.modal-backdrop').remove();
		    if (typeof enquiryModal.model !== "undefined") { 
		    	enquiryModal.modal('hide');
			}
	    });
	
	    var checkVariations = $('.variations_form');
	    if(checkVariations.length > 0 && enquiryButton.length > 0) {
	    	enquiryButton.hide();

	    	var availableVariations = $(checkVariations.data('product_variations'));
	    	var variationText = $('<div id="variationText"></div>');
	    	variationText.insertBefore(enquiryButton);

		    $(document).on('change', '.variations select', function(e) {
		    	var _this = $(this);
		    	var optionSelected = _this.find('option:selected');
		    	var sku = $('.sku').text();

		    	if(sku.length > 0 && sku !== "N/A") {
		    		availableVariations.each(function(i, val) {

		    			if(val.sku === sku) {
		    				var description = val.variation_description;
		    				var price = val.price_html;

		    				variationText.html(price + description);

		    				variationText.fadeIn();
		    				enquiryButton.fadeIn();
		    				return false;
		    			}
		    		});
		    		
		    	} else {
		    		variationText.hide();
		    		enquiryButton.hide();
		    	}

		    })
			setTimeout( function() {
				$('.variations select').trigger('change');
			}, 150 );
	    }

		var insertSKUIntoForm = function() {
			var sku = $(woocommerce_catalog_mode_options.SKUSelector).first().text().trim();
			var enquiryModalSKU = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.skuField + '"]');
			
		    if(typeof sku != "undefined"){
		    	enquiryModalSKU.val(sku);
		    	enquiryModalSKU.attr('value', sku);
		    }
	    };
	    
	    var insertProductIntoForm = function() {



	    	var product = $(woocommerce_catalog_mode_options.productSelector).first().text().trim();
	    	
			var enquiryModalProduct = enquiryModal.find('input[name*="' + woocommerce_catalog_mode_options.productField + '"]');

	    	if(typeof product != "undefined" && product != ""){
		    	enquiryModalProduct.val(product);
		    	enquiryModalProduct.attr('value', product);
		    } else {
		    	product = $(woocommerce_catalog_mode_options.productSelectorFallback).first().text().trim();
		    	enquiryModalProduct.val(product);
		    	enquiryModalProduct.attr('value', product);
		    }
	    };

	    insertProductIntoForm();
	    insertSKUIntoForm();

	    /** Enquiry Cart Modal */
		var enquiryCartModal = $('#enquiryCartModal');

	    $(document).on('click', '#enquiryCartButton', function() {
	    	enquiryCartModal.show();

		    if (typeof enquiryCartModal.model !== "undefined") { 
		    	enquiryCartModal.modal('show');
			}

		    insertCartProductsIntoForm(this);
	    });

	    var enquiryCartVariationButton = $('.enquiryCartVariationButton');
	    $('body').on('click', '.enquiryCartVariationButton', function() {
		    enquiryCartModalSKU.val($(this).data('sku'));
			enquiryCartModalProduct.val($(this).data('name'));
	    	enquiryCartModal.show();

		    if (typeof enquiryCartModal.model !== "undefined") { 
		    	enquiryCartModal.modal('show');
			}
	    });

	    $('#enquiryCartClose').on('click', function() {
	    	enquiryCartModal.hide();
	    	$('.modal-backdrop').remove();

		    if (typeof enquiryCartModal.model !== "undefined") { 
		    	enquiryCartModal.modal('hide');
			}
	    });

	    var insertCartProductsIntoForm = function(btn) {
	    	var products = $(btn).data('products');
	    	if(products == "") {
	    		return false;
	    	}
	    	
	    	var products_txt = "";
	    	$.each(products, function(i, index) {

				if(woocommerce_catalog_mode_options.enquiryCartShowQuantity == 1) {
					products_txt += index.quantity + ' x ' + index.name;
				} else {
					products_txt += index.name;
				}

				if(woocommerce_catalog_mode_options.enquiryCartShowPrice == 1 && woocommerce_catalog_mode_options.enquiryCartShowSKU == 1) {
					if(index.sku !== "") {
						products_txt += ' (' + index.price + ' / ' + index.sku + ')\n';
					} else {
						products_txt += ' (' + index.price + ')\n';	
					}
					
				} else if(woocommerce_catalog_mode_options.enquiryCartShowPrice == 1) {
					products_txt += ' (' + index.price + ')\n';
				} else if(woocommerce_catalog_mode_options.enquiryCartShowSKU == 1 && index.sku !== "") {
					products_txt += ' (' + index.sku + ')\n';
	    		} else {
	    			products_txt += '\n';
	    		}

	    		if(index.variationInformation) {
	    			products_txt += index.variationInformation + '\n';
	    		}

	    	});
	    	var enquiryCartModalProducts = enquiryCartModal.find('[name="' + woocommerce_catalog_mode_options.productsField + '"]');

	    	enquiryCartModalProducts.val(products_txt);
	    };

		document.addEventListener( 'wpcf7mailsent', function( event ) {
			if($('.woocommerce-cart').length > 0) {
				$.ajax({
			        url: woocommerce_catalog_mode_options.ajaxURL,
			        data: {
			            'action':'woocommerce_catalog_mode_clear_cart',
			        },
			        success:function(data) {
			            var delay = 1500; 
						setTimeout(function(){ location.reload(); }, delay);			            
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		    
		}, false );
	});

})( jQuery );
