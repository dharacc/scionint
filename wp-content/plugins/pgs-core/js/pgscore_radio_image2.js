/**
 * Backend JS for pgscore_radio_image2 - parameter
 */

( function( $ ) {
	"use strict";

    vc.atts.pgscore_radio_image2 = {
        render: function ( param, value ) {
            return value;
        },
        init: function ( param, $field ) {
			$field.find( '.pgscore_radio_image2' ).imagepicker({
				hide_select : $field.find( '.pgscore_radio_image2' ).data('hide_select'),
				show_label  : $field.find( '.pgscore_radio_image2' ).data('show_label'),
			});
        }
    };

})(window.jQuery);