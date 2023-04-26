/**
 * Backend JS for pgscore_dropdown - parameter
 */
 
( function( $ ) {
	"use strict";

	vc.atts.pgscore_dropdown = {
        render: function ( param, value ) {
            return value;
        },
        init: function ( param, $field ) {
			var pgscore_dropdown = $field.find( '.pgscore_dropdown.pgscore_dropdown-select2' ),
				select2_options = pgscore_dropdown.data('select2_options');
				
			pgscore_dropdown.select2(select2_options);
        }
    };

} )( jQuery );