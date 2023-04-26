/**
 * Backend JS for pgscore_datepicker - parameter
 */
(function ($) {

    vc.atts.pgscore_datepicker = {
        render: function ( param, value ) {
            return value;
        },
        init: function ( param, $field ) {
			var pickerOpts = {
				dateFormat: 'yy-mm-dd',							
				buttonText: '<i class="fa fa-calendar"></i>',					
			};
            $field.find( '.wpb_vc_param_value' ).datepicker(pickerOpts);
        }
    };

})(window.jQuery);