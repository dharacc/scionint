( function( $ ){
	$( document ).ready( function() {
		/* Size Guide Table */
		if ( jQuery( '.ciyashop-sguide-table-edit' ).length ) {
			jQuery( '.ciyashop-sguide-table-edit' ).each( function() {
				jQuery( this ).editTable(); 
			});
		}

		var smart_product;

		$(document).on('click', '#smart-product-metabox a.smart-product-add', function (e) {

			e.preventDefault();

			if (smart_product)
				smart_product.close();

			smart_product = wp.media.frames.smart_product = wp.media({
				title: $(this).data('uploader-title'),
				button: {
					text: $(this).data('uploader-button-text'),
				},
				multiple: true
			});

			smart_product.on('select', function () {
				var listIndex = $('#smart-product-metabox-list li').index($('#smart-product-metabox-list li:last')),
						selection = smart_product.state().get('selection');

				selection.map(function (attachment, i) {
					attachment = attachment.toJSON(),
					index = listIndex + (i + 1);
					var img_title = $(attachment,'img').attr('title');

					$('#smart-product-metabox-list').append('<li><input type="hidden" name="ciyashop_smart_product_id[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.thumbnail.url + '"><small><a class="remove-image button" href="#"><i title="Remove Image" class="fa fa-times-circle" aria-hidden="true"></i></a></small><div class="product_title">'+ img_title +'</div><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><i title="Change image" class="fa fa-exchange" aria-hidden="true"></i></a><br></li>');
				});
			});

			makeSortable();
			smart_product.open();
		});

		$(document).on('click', '#smart-product-metabox a.change-image', function (e) {
			
			e.preventDefault();
			
			var that = $(this);
			
			if (smart_product)
			smart_product.close();
			
			smart_product = wp.media.frames.smart_product = wp.media({
				title: $(this).data('uploader-title'),
				button: {
					text: $(this).data('uploader-button-text'),
				},
				multiple: false
			});
			
			smart_product.on('select', function () {
				
				attachment = smart_product.state().get('selection').first().toJSON();
				var img_title = $(attachment,'img').attr('title');

				that.parent().find('input:hidden').attr('value', attachment.id);
				that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
				that.parent().find('.change-image.button.button-small').prev().text(img_title);
			
			});

			smart_product.open();

		});

		function resetIndex() {
			$('#smart-product-metabox-list li').each(function (i) {
				$(this).find('input:hidden').attr('name', 'ciyashop_smart_product_id[' + i + ']');
			});
		}

		function makeSortable() {
			$('#smart-product-metabox-list').sortable({
				opacity: 0.6,
				stop: function () {
					resetIndex();
				}
			});
		}

		$(document).on('click', '#smart-product-metabox a.remove-image', function (e) {
			e.preventDefault();

			$(this).parents('li').animate({opacity: 0}, 200, function () {
				$(this).remove();
				resetIndex();
			});
		});

		makeSortable();

	});
})( jQuery );

/* Visual Composer CallBack Functions */
/*InfoBox 2*/
var vcCiyaShopCustomIconDependencyCallback;
vcCiyaShopCustomIconDependencyCallback = function () {
	(function ( $, that ) {
		var $layout_select, $empty;
		$layout_select = $( '[data-vc-shortcode-param-name="layout"]', that.$content );
		var element = $('ul.image_picker_selector li');
		$(element).each(function($this){
			$(document).on('click', $this, function(){
				var $style = $(this).find('.thumbnail.selected').find('p').html();
				if( $style == 'Style 3'){
					$('ul.vc_ui-tabs-line').find('[data-tab-index=3]').hide();
				} else if( $('ul.vc_ui-tabs-line').find('[data-tab-index=3]').is(':hidden') ){
					$('ul.vc_ui-tabs-line').find('[data-tab-index=3]').show();
				}
			});
		});
	}( window.jQuery, this ));
};

/* InfoBox */
var vcCiyaShopInfoBoxDependencyCallback;
vcCiyaShopInfoBoxDependencyCallback = function () {
	(function ( $, that ) {
		var element = $('ul.image_picker_selector li');
		$(element).each(function($this){
			$(document).on('click', $this, function(){
				var $style = $(this).find('.thumbnail.selected').find('p').html();
				if( $style == 'Style 1' ){
					$('ul.vc_ui-tabs-line').find('[data-tab-index=2]').hide();
				} else if( $('ul.vc_ui-tabs-line').find('[data-tab-index=2]').is(':hidden') ){
					$('ul.vc_ui-tabs-line').find('[data-tab-index=2]').show();
				}
			});
		});
	}( window.jQuery, this ));
};
// Enable step selection for infobox
var vcCiyaShopInfoBoxStepDependencyCallback;
vcCiyaShopInfoBoxStepDependencyCallback = function () {
	(function ( $, that ) {
		var $layout_select = $( '[data-vc-shortcode-param-name="enable_step"]', that.$content );
		var $selector = $layout_select.find('#enable_step-true');
		$($selector).on('change', function(){
			if($(this).is(':checked')){
				$( '[data-vc-shortcode-param-name="style_2_step_position"]' ).show();
			} else {
				$( '[data-vc-shortcode-param-name="style_2_step_position"]' ).hide();
			}
		});		
	}( window.jQuery, this ));
};

/*
----------- Product Category Items Shortcode ------------
*/
// Enable category count color selection on Hide Product Categories Count selection
var vcCiyaShopCatItemsCountDependencyCallback;
vcCiyaShopCatItemsCountDependencyCallback = function () {
	(function ( $, that ) {
		var $layout_select = $( '[data-vc-shortcode-param-name="hide_categories_count"]', that.$content );
		var $selector = $layout_select.find('#hide_categories_count-true');
		$($selector).on('change', function(){
			if($(this).is(':checked')){
				$( '[data-vc-shortcode-param-name="product_title_color"]' ).hide();
			} else {
				$( '[data-vc-shortcode-param-name="product_title_color"]' ).show();
			}
		});		
	}( window.jQuery, this ));
};

( function( $ ){
    jQuery(document).on('click', '.set-position-button', function(e) {
        e.preventDefault();

        if( jQuery(this).hasClass('already-set') ) {
			return;
		}
        var $image_source=$('.image_source').find(":selected").text();

        var $image_src = ($image_source=="Image") ? $('.pgscore-hotspot-img .gallery_widget_attached_images img').attr('src') : $('.hotspot_box_img_link').val(),
            $position = $(this).parents('.pgscore-position').find('.list_items_position').val();	
            
        $image_src = $image_src.replace('-150x150', '', $image_src);
        $(this).parents('.pgscore-position').append('<div class="hotspot-image-wrapper"><div class="pgscore-hotspot-cover"><img src="'+ $image_src +'" /><div class="pgscore-hotspot-overlay"></div><div class="pgscore-hotspot-pointer"></div></div></div>');

        $position = $position.split('||');
        $(this).parents('.pgscore-position').find('.pgscore-hotspot-pointer').css({"top":$position[1]+"%", "left":$position[0]+"%" });
        $(this).addClass('already-set');

        var $containment = $(this).parents('.pgscore-position');

        jQuery('.pgscore-hotspot-pointer').draggable({
            containment: $containment.find('.pgscore-hotspot-cover'),
            scroll: false,
            drag: function( event, ui ) {
                var relativeX = (ui.position.left + 3) / $containment.find('.pgscore-hotspot-cover').width() * 100,
                    relativeY = (ui.position.top + 3) / $containment.find('.pgscore-hotspot-cover').height() * 100;
                relativeX = relativeX.toFixed(2);
                relativeY = relativeY.toFixed(2);

                $containment.find('.list_items_position').val(relativeX +'||'+ relativeY);
                $containment.find('.pgscore-hotspot-pointer').css({"top":relativeY+"%", "left":relativeX+"%"});
            }
        });
    });
})( jQuery );

jQuery(document).on('click', '.pgscore-position .pgscore-hotspot-cover .pgscore-hotspot-overlay', function(e) {
	var offset = jQuery(this).offset(),
		relativeX = (e.pageX - offset.left) / jQuery(this).width() * 100,
		relativeY = (e.pageY - offset.top) / jQuery(this).height() * 100;

	relativeX = relativeX.toFixed(2);
	relativeY = relativeY.toFixed(2);

	jQuery(this).parents('.pgscore-position').find('.list_items_position').val(relativeX +'||'+ relativeY);
	jQuery(this).parents('.pgscore-position').find('.pgscore-hotspot-pointer').css({"top":relativeY+"%", "left":relativeX+"%" });
});

jQuery(document).on('click', '.vc_param_group-add_content, .column_toggle', function(){
	jQuery('.pgscore-position').each(function() {
		if( ! jQuery(this).find( '.set-position-button' ).length ) {
			jQuery(this).find('.edit_form_line').append('<button class="vc_ui-button vc_ui-button-action button set-position-button">'+ object.set_possition +'</button>');
		}
	});
});
