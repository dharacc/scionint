/*global jQuery, document, redux*/
(function( $ ) {
	"use strict";

	redux.field_objects = redux.field_objects || {};
	redux.field_objects.tc_sample_import = redux.field_objects.tc_sample_import || {};
	

	redux.field_objects.tc_sample_import.init = function( selector ) {
		
		if ( !selector ) {
			selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-tc_sample_import:visible' );
		}

		$( selector ).each(
			function() {
				var el = $( this );
				var parent = el;
				if ( !el.hasClass( 'redux-field-container' ) ) {
					parent = el.parents( '.redux-field-container:first' );
				}
				if ( parent.is( ":hidden" ) ) { // Skip hidden fields
					return;
				}
				if ( parent.hasClass( 'redux-field-init' ) ) {
					parent.removeClass( 'redux-field-init' );
				} else {
					return;
				}
				
				el.each( function() {
					
					$( '.import-this-sample' ).click( function( e ) {
						e.preventDefault();
						
						if( $(this).hasClass('disabled') ){
							return false;
						}
						
						var current_element = $(e.target);
						
						if( current_element.data('message') ){
							var import_message = unescape(current_element.data('message'));
						}else{
							var import_message = sample_data_import_object.alert_default_message;
						}
						
						var install_required_plugins = false;
						if( current_element.data('required-plugins') ){
							install_required_plugins = true;
						}
						
						var template = wp.template( 'pgscore-sample-import-alert' );
						var template_content = template( {
							title: current_element.data('title'),
							message: import_message,
							import_requirements_list: sample_data_import_object.sample_data_requirements,
							required_plugins_list: sample_data_import_object.sample_data_required_plugins_list
						});
						
						$.confirm({
							title: sample_data_import_object.alert_title,
							content: template_content,
							type: 'red',
							icon: 'fa fa-warning',
							animation: 'scale',
							closeAnimation: 'scale',
							bgOpacity: 0.8,
							columnClass: 'col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 sample-data-confirm',
							buttons: {
								'confirm': {
									text: sample_data_import_object.alert_proceed,
									btnClass: 'btn-green',
									action: function () {
										if( install_required_plugins ){
											window.location = sample_data_import_object.tgmpa_url;
										}else{
											
											// ********************************** Ajax Start **********************************
											var overlay = $('#redux_ajax_overlay');
											var loader = $('#redux-sticky #info_bar .spinner');
											
											var sample_import_nonce = $('#sample_import_nonce').val();
											var data = {
												action: 'theme_import_sample', //calls wp_ajax_nopriv_ajaxlogin
												sample_id: current_element.data('id'),
												sample_import_nonce: sample_data_import_object.sample_import_nonce,
												action_source: 'theme-options',
											};
											
											$.ajax({
												type: 'POST',
												dataType: 'json',
												url: sample_data_import_object.ajaxurl,
												data: data,
												beforeSend: function( xhr ) {
													$(loader).addClass('is-active'); // Display Loader
													overlay.fadeIn(); // Display Overlay
													
													$('#redux_notification_bar .admin-demo-data-notice').hide();
													$('#redux_notification_bar .admin-demo-data-reload').hide();
													$('#redux_notification_bar .admin-demo-data-error').hide().html('');
												},
												success: function(data){
													// Hide Loader
													$(loader).removeClass('is-active');
													
													// Hide Overlay
													overlay.fadeOut( 'fast' );
													
													if( data.success ){
														$('#redux_notification_bar .admin-demo-data-notice').hide().slideDown('slow').delay(5000).slideUp('slow');
														$('#redux_notification_bar .admin-demo-data-reload').hide().delay(500).slideDown('slow').delay(15000).slideUp('slow');
														
														// Reload Page
														window.setTimeout(function(){
															document.location.href = document.location.href;
														}, 5000);
													}else{
														$('#redux_notification_bar .admin-demo-data-error').html(data.message).hide().slideDown('slow').delay(5000).slideUp('slow');
													}
													
													return data;
												}
											});
											//**********************************  Ajax End  **********************************
											
										}
									}
								},
								'cancel': {
									text: sample_data_import_object.alert_cancel,
									btnClass: 'btn-red',
								},
							},
							onContentReady: function () {
								if( install_required_plugins ){
									this.buttons.confirm.setText(sample_data_import_object.alert_install_plugins);
								}
							},
							onOpen: function () {
								// $.alert('onOpen');
							},
						});
						
						window.onbeforeunload = null;
						redux.args.ajax_save = false;
					} );
					
				});
			}
		);
	};

	$( document ).ready(	
		function() {
			var pgsPagesSelect = $('#pgscore-sample-page');
			$('#pgscore-sample-page option:first').attr("selected", "selected");

			var previewUrl 	= pgsPagesSelect.find(":selected").data('preview'),
				demoUrl		= pgsPagesSelect.find(":selected").data('demo');
			$('.pgacore-page-preview img').attr('src', previewUrl);
			$('.pgacore-page-preview a').attr('href', demoUrl);
			$('.import-this-sample-page').attr('data-id', pgsPagesSelect.val());

			pgsPagesSelect.change( function() {
				var previewUrl 		= $(this).find(":selected").data('preview'),
					demoUrl			= pgsPagesSelect.find(":selected").data('demo');
					
				$('.pgacore-page-preview img').attr('src', previewUrl);
				if(demoUrl != '') {
					$('.pgacore-page-preview a').show();
					$('.pgacore-page-preview a').attr('href', demoUrl);
				} else {
					$('.pgacore-page-preview a').hide();
				}
				
				$('.import-this-sample-page').attr('data-id', $(this).val());

				setTimeout(function(){ 
					$('#redux_notification_bar .redux-save-warn').hide();
				}, 100);
				
			});

			$('.import-this-sample-page').click( function( e ) {
				e.preventDefault();	

				var install_required_plugins = false;

				var template = wp.template( 'pgscore-sample-import-alert' );
				
				var alert_message = pgsPagesSelect.find(":selected").data('message');
				var additional_message = pgsPagesSelect.find(":selected").data('additional_message');;
				alert_message = (alert_message != '') ? alert_message : sample_data_import_object.page_import_massage;
				
				var template_content = template( {
					title: pgsPagesSelect.find(":selected").text(),
					message: alert_message,
					additional_message:additional_message,
				});

				$.confirm({
					title: sample_data_import_object.alert_title,
					content: template_content,
					type: 'red',
					icon: 'fa fa-warning',
					animation: 'scale',
					closeAnimation: 'scale',
					bgOpacity: 0.8,
					columnClass: 'col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 sample-data-confirm',
					buttons: {
						'confirm': {
							text: sample_data_import_object.alert_proceed,
							btnClass: 'btn-green',
							action: function () {
								if( install_required_plugins ){
									window.location = sample_data_import_object.tgmpa_url;
								} else {
									var overlay = $('#redux_ajax_overlay');
									var loader = $('#redux-sticky #info_bar .spinner');
									var sample_import_nonce = $('#sample_import_nonce').val();
									var data = {
										action: 'theme_import_sample_page', //calls wp_ajax_nopriv_ajaxlogin
										sample_id: pgsPagesSelect.val(),
										sample_import_nonce: sample_data_import_object.sample_import_nonce,
										action_source: 'theme-options',
									};

									$.ajax({
										type: 'POST',
										dataType: 'json',
										url: sample_data_import_object.ajaxurl,
										data: data,
										beforeSend: function( xhr ) {
											$(loader).addClass('is-active'); // Display Loader
											overlay.fadeIn(); // Display Overlay
											
											$('#redux_notification_bar .admin-demo-data-notice').hide();
											$('#redux_notification_bar .admin-demo-data-reload').hide();
											$('#redux_notification_bar .admin-demo-data-error').hide().html('');
										},
										success: function(data){
											// Hide Loader
											$(loader).removeClass('is-active');

											// Hide Overlay
											overlay.fadeOut( 'fast' );

											if( data.success ){
												$('#redux_notification_bar .admin-demo-data-notice').hide().slideDown('slow').delay(5000).slideUp('slow');
												$('#redux_notification_bar .admin-demo-data-reload').hide().delay(500).slideDown('slow').delay(15000).slideUp('slow');
											} else {
												$('#redux_notification_bar .admin-demo-data-error').html(data.message).hide().slideDown('slow').delay(5000).slideUp('slow');
											}

											// Reload Page
											window.setTimeout(function(){
												document.location.href = document.location.href;
											}, 2000);

											return data;
										}
									});
								}
							}
						},
						'cancel': {
							text: sample_data_import_object.alert_cancel,
							btnClass: 'btn-red',
						},
					},
				});
				
				window.onbeforeunload = null;
				redux.args.ajax_save = false;
			});
		}
	);

})( jQuery );