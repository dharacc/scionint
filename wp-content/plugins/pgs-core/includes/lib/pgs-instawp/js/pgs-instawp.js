(function($){
	"use strict";

	jQuery( document ).ready( function( $ ) {

		//Initiate Color Picker.
		$('.wp-color-picker-field').wpColorPicker();

		var tab_contents     = $( '.pgs-instawp-wrap .tab-content-wrapper .tab-content' ),
			activetab_cookie = Cookies.get( 'pgs_instawp_activetab' ),
			activetab        = ( 'undefined' == typeof activetab_cookie ) ? '' : activetab_cookie;

		// Switches option sections
		if ( '' !== activetab && $( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab#tab-' + activetab ).length ) {
			$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab#tab-' + activetab ).addClass( 'nav-tab-active' );
			$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab:not(#tab-' + activetab + ')' ).removeClass( 'nav-tab-active' );
		} else {
			$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab:first-child' ).addClass( 'nav-tab-active' );
			$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab:not(:first-child)' ).removeClass( 'nav-tab-active' );
		}

		if ( '' !== activetab && $( '.pgs-instawp-wrap .tab-content-wrapper .tab-content#content-' + activetab ).length ) {
			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content#content-' + activetab ).fadeIn();
			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content:not(#content-' + activetab + ')' ).hide();
		} else {
			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content:first-child' ).addClass( 'nav-tab-active' );
			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content:not(:first-child)' ).hide();
		}

		$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab' ).click( function( event ) {
			var selected_tab    = $(this).data('tab');

			Cookies.set( 'pgs_instawp_activetab', selected_tab, { expires: 7 });

			$( '.pgs-instawp-wrap .nav-tab-wrapper .nav-tab' ).removeClass( 'nav-tab-active' );
			$( this ).addClass( 'nav-tab-active' ).blur();

			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content' ).hide();
			$( '.pgs-instawp-wrap .tab-content-wrapper .tab-content#content-' + selected_tab ).fadeIn();

			event.preventDefault();
		});

	});

})(jQuery);
