/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function ($) {

	if (!jQuery('#vcwccr_settings_variations_section_title-description').length) {
		return true;
	}

	/*if (wcacr_data.home_url) {
	 var firstTimestamp = null;
	 jQuery.get(wcacr_data.home_url, function (response) {
	 var renderTime = response.match(/wcacr-page-rendered-timestamp\d{10}/);
	 if (renderTime) {
	 firstTimestamp = parseInt(renderTime.replace('wcacr-page-rendered-timestamp', ''));
	 
	 setTimeout(function () {
	 jQuery.get(wcacr_data.home_url, function (response) {
	 var renderTime2 = response.match(/wcacr-page-rendered-timestamp\d{10}/);
	 if (renderTime2 <= renderTime) {
	 // page cache detected
	 }
	 });
	 }, 1500);
	 }
	 });
	 }*/

	var $countrySelectorFieldsRows = jQuery('[name="wccr_default_country"], [name="wccr_country_selector_options[]"], .wcaccr-country-selector-enabled').parents('tr');
	$countrySelectorFieldsRows.hide();
	jQuery('.tabs a[href="#header_selector"]').hide();

	$('.wcacr-show-select-all').each(function () {
		var $parent = jQuery(this).parent();
		$parent.append('<br /><a class="vg-select_all button" href="#">Select all</a> <a class="vg-select_none button" href="#">Select none</a>');
	});

	jQuery('body').on('click', '.vg-select_all', function (e) {
		e.preventDefault();
		var $select = jQuery(this).parent().find('select');
		$select.find('option').each(function () {
			if (jQuery(this).val().length === 2) {
				jQuery(this).prop('selected', true);
			}
		});
		$select.trigger('change');
	});
	jQuery('body').on('click', '.vg-select_none', function (e) {
		e.preventDefault();
		jQuery(this).parent().find('select').val('').trigger('change');
	});

	$('#wccr_geolocation_method').change(function () {
		if (jQuery(this).val() === 'country_selector') {
			$countrySelectorFieldsRows.show();
			jQuery('.tabs a[href="#header_selector"]').show();
		} else {
			$countrySelectorFieldsRows.hide();
			jQuery('.tabs a[href="#header_selector"]').hide();
		}
	});
	$('#wccr_geolocation_method').trigger('change');

	var $customCategoryMessageFields = jQuery('.wcacr-archive-custom-message').parents('tr');
	$('#wccr_archive_restriction_type').change(function () {
		if (jQuery(this).val() === '') {
			$customCategoryMessageFields.show();
		} else {
			$customCategoryMessageFields.hide();
		}
	});
	$('#wccr_archive_restriction_type').trigger('change');

	jQuery('body').on('click', '.vg-remove-parent', function (e) {
		e.preventDefault();
		jQuery(this).parent().remove();
	});
	jQuery('body').on('click', '.vg-clone-prev-template', function (e) {
		e.preventDefault();
		var $button = jQuery(this);
		var $clone = jQuery(this).siblings('.template-group.hidden').clone(true).removeClass('hidden');
		$button.before($clone);
		updateGroupIndexes(jQuery(this).parent().find('.template-group'));
	});

	function updateGroupIndexes($group) {
		$group.each(function (index, element) {
			var $element = jQuery(this);
			if ($element.is(':visible')) {
				$element.find('input,select').each(function () {
					var name = jQuery(this).attr('name');
					if (name) {
						jQuery(this).attr('name', name.replace(/\[(\d+|index)\]/, '[' + index + ']'));
					}
				});

				$element.find('.wc-enhanced-select-late').addClass('wc-enhanced-select').removeClass('wc-enhanced-select-late');
				$(document.body).trigger('wc-enhanced-select-init');
			}
		});
	}

	jQuery('body .vg-clone-prev-template').each(function () {
		updateGroupIndexes(jQuery(this).parent().find('.template-group'));
	});

	jQuery('[name="wccr_enable_cache_support"]').change(function () {
		var $restrictionMethod = jQuery('[name="wccr_restriction_method"]');
		if (jQuery(this).val() === 'yes') {
			if ($restrictionMethod.val() === 'hide') {
				$restrictionMethod.val('disable_add_to_cart_prices');
			}
			$restrictionMethod.find('option[value="hide"]').prop('disabled', true);
			$restrictionMethod.find('option[value="hide"]').text($restrictionMethod.find('option[value="hide"]').text() + ' (Not compatible with the Cache Support)');
		}
	});
	jQuery('[name="wccr_enable_cache_support"]').trigger('change');

	jQuery('.tab-content').hide();
	jQuery('.tabs a').click(function (e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');

		jQuery('.tab-content').hide();
		jQuery(id).show();
		jQuery('.tabs a').removeClass('active');
		jQuery(this).addClass('active');
	});

	if (window.location.hash && jQuery(window.location.hash).length) {
		jQuery('.tabs a[href="' + window.location.hash + '"]').click();
	} else {
		jQuery('.tabs a').first().click();
	}
});
