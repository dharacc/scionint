jQuery(function ($) {

    'use strict';

    // WQV plugin notice
    jQuery(document).on('click', '.wqv-notice .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'dismiss_wqv_notice'
            }
        })
    });

    // Gallery Slider plugin notice
    jQuery(document).on('click', '.woogs-notice .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'dismiss_woo_gallery_slider_notice'
            }
        })
    });

});