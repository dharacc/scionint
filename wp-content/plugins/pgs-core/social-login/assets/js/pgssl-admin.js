(function($){
	"use strict";

	jQuery( window ).load(function() {
	});

	jQuery( document ).ready(function() {
		if ( $( '.pgssl_provider_settings_showhide' ).length > 0 ){
			$( '.pgssl_provider_settings_showhide' ).click(function(){
				var curren_meta_box = $( this ).closest( '.postbox.pgssl-postbox' ),
					show_hide_el    = $( curren_meta_box ).find( '.pgssl_tr_setting th, .pgssl_tr_setting td' );

				console.log( $(this).val() );
				console.log( curren_meta_box );

				if ( $(this).val() == 1 ) {
					$( show_hide_el).slideDown('fast');
				} else {
					$( show_hide_el).slideUp('fast');
					// jQuery( '.pgssl_div_settings_help_' + idp ).hide();
				}
			});
		}
	});

})(jQuery);
