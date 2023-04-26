/**
 * Backend JS for pgscore_radio_image - parameter
 */

(function ($) {

    vc.atts.pgscore_radio_image = {
        render: function ( param, value ) {
            return value;
        },
        init: function ( param, $field ) {
			$field.find( '.pgscore_radio_image' ).imagepicker({
				hide_select : $field.find( '.pgscore_radio_image' ).data('hide_select'),
				show_label  : $field.find( '.pgscore_radio_image' ).data('show_label'),
			});
        }
    };

})(window.jQuery);