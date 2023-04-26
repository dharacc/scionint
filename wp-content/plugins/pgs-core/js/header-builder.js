jQuery( document ).ready(function() {
	
	var elementCoverDiv = '';
	
	// Add Header Layout
	jQuery('.add-header-layout').on('click', function(e) {
		e.preventDefault();
		
		if( jQuery('.chl-preset-header-container').hasClass('.chl-header-list-active') ){
			jQuery('.chl-preset-header-container').removeClass('chl-header-list-active');
		} else {
			jQuery('.chl-preset-header-container').addClass('chl-header-list-active');
		}
	});
	
	jQuery('.chl-preset-header-close').on('click', function(e) {
		e.preventDefault();
		jQuery('.chl-preset-header-container').removeClass('chl-header-list-active');
	});
	
	// Header Builder Sample Import
	jQuery(document).on('click', '.header-layout', function(e) {
		e.preventDefault();
		
		var $layout = jQuery(this).data('layout');
		var href = jQuery(this).find('a').attr('href');
		
		var chl_cntnr = jQuery(this).parents('.chl-preset-header-inner');
		chl_cntnr.append('<div class="chl-loading"></div>');
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: 'add_sample_header', layout : $layout },
			dataType: "json",
			success: function( response ) {
				href += '&header_id='+response.header_id;
				jQuery('.chl-loading').remove();
				jQuery(location).attr('href', href);
			}
		});	
	});
	
	device_related_elements();
	
	// Device Selection
	jQuery('.chl-toolbar-devices span').on('click', function() {
		
		if(jQuery(this).hasClass('active-devices'))
			return;
		
		jQuery('.chl-toolbar-devices span').removeClass('active-devices');
		jQuery(this).addClass('active-devices');
		
		if(jQuery(this).data('device') == 'desktop') {
			jQuery('.chl-structure').removeClass('chl-structure-mobile');
			jQuery('.chl-structure').addClass('chl-structure-desktop');
			device_related_elements();
		}
		if(jQuery(this).data('device') == 'mobile') {
			jQuery('.chl-structure').removeClass('chl-structure-desktop');
			jQuery('.chl-structure').addClass('chl-structure-mobile');
			device_related_elements();
		}
	});
	
	// Delete Element
	jQuery(document).on('click', '.chl-element-content .chl-remove-btn', function() {
		if (confirm('Are you sure to delete this element?')) {
			jQuery(this).parents('.chl-sortable-item').remove();
			elementActionHideShow();
        }
	});

	// Clone Element
	jQuery(document).on('click', '.chl-element-content .chl-clone-btn', function() {
		var $element = jQuery(this).parents('.chl-sortable-item').html();
		jQuery(this).parents('.chl-element-sortable').append('<li class="chl-sortable-item">'+ $element +'</li>');
	});

	// Edit Element popup
	jQuery(document).on('click', '.chl-element-sortable .chl-element-content-inner', function() {
		
		if(jQuery(this).parents('.chl-element-content').hasClass('chl-element-current')) {
			return;
		}
		
		jQuery('.chl-structure').append('<div class="chl-settings-loading"></div>');
		jQuery('.chl-device-elements-settings').html('');

		jQuery('.chl-device-elements-settings').removeClass('chl-elements-settings-show');

		jQuery('.chl-element-content').removeClass('chl-element-current');
		jQuery('.chl-elements-cover').removeClass('chl-current-row');
		jQuery(this).parents('.chl-element-content').addClass('chl-element-current');
		
		var $elementId = jQuery(this).parents('.chl-element-content').data('element_id'),
			$elementTitle = jQuery(this).parents('.chl-element-content').data('element_title'),
			$elements_data = jQuery(this).parents('.chl-element-content').attr('data-element_data'),
			elements_data = '';
		
		if ( $elements_data != undefined  && $elements_data != "" ) {
			elements_data_arr = JSON.parse($elements_data);
			
			elements_data = [];
			jQuery.each(elements_data_arr, function(key, value) {
				if(	!elements_data[value.name] ){
					elements_data[value.name] = value.value;
				}else{
					elements_data[value.name] = elements_data[value.name]+', '+value.value;
				}
			});
		}
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: 'edit_element', elementId: $elementId },
			dataType: "json",
			success: function( response ) {
				var $output = '',
					$fiels = '';
					$tabs = [],
					$active_tab = true;
				
				jQuery.each( response, function( key, value ) {
					if(jQuery.inArray( value.group, $tabs ) == -1) {
						$tabs.push(value.group);
					}
					
					$fiels += get_element_field(value, elements_data);
				});
				
				$output += '<div class="chl-element-settings"><div class="chl-element-settings-inner">';
				$output += '<div class="chl-element-settings-header">';
				$output += '<div class="chl-element-settings-close"><span class="dashicons dashicons-no"></span></div><div class="chl-element-settings-title">'+$elementTitle+' '+chl.settings+'</div>';
				
				// Tabs
				$output += '<div class="chl-edit-tabs">';
				jQuery.each( $tabs, function( key, value ) {
					if($active_tab) {
						$output += '<div class="chl-tabs-title chl-tab-active" data-tab="'+ value +'">'+ value +'</div>';
						$active_tab = false;
					} else {
						$output += '<div class="chl-tabs-title" data-tab="'+ value +'">'+ value +'</div>';
					}
				});
				$output += '</div>';
				$output += '</div>';
				
				$output += '<div class="chl-element-settings-content chl-element-settings-edit-content"><div class="chl-element-edit"><form id="header_builder_elements_form" method="get">';

				// Tabs Contents
				$output += '<div class="chl-editor-fields">';
				$output += $fiels;
				$output += '</div>';
				
				// Tabs Footer
				$output += '<div class="chl-edit-action-tabs">';				
				$output += '<a class="button button-primary button-large chl-save-element">'+chl.save+'</a>';
				$output += '<a class="button button-secondary button-large chl-close-element">'+chl.cancel+'</a>';
				$output += '</div>';

				$output += '</from></div></div></div></div>';
				
				jQuery('.chl-settings-loading').remove();
				jQuery($output).appendTo(".chl-device-elements-settings");
				jQuery('.chl-device-elements-settings').addClass('chl-elements-settings-show');
				
				fieldsEditorRemove();
				fieldsEditor();
				getRangeSlider();
				fieldsActionHideShow();
				formDataDependency();
				setColorPicker();
				enableSelect2();
			}
		});
	});

	jQuery(document).on('click', '.chl-edit-tabs .chl-tabs-title', function() {
		
		if(jQuery(this).hasClass('chl-tab-active')) 
			return;
		
		var $data = jQuery(this).data('tab');
		
		jQuery('.chl-edit-tabs .chl-tabs-title').removeClass('chl-tab-active');
		jQuery(this).addClass('chl-tab-active');
		
		fieldsActionHideShow();
		
	});


	//Popup Close
	jQuery(document).on('click', '.chl-popup-close, .chl-element-settings-close, .chl-popup-overlay, .chl-close-element, .chl-toolbar-devices', function(e) {
		e.preventDefault();
		
		jQuery('.chl-element-settings').remove();
		jQuery('.chl-device-elements-settings').removeClass('chl-elements-settings-show');
		jQuery('.chl-element-content').removeClass('chl-element-current');
		jQuery('.chl-elements-cover').removeClass('chl-current-row');
	});
	
	// Save Element
	jQuery(document).on('click', '.chl-save-element', function(e) {
		e.preventDefault();
		
		var $element_data = jQuery('#header_builder_elements_form').serializeArray(),
			$element_id = jQuery('.chl-element-content.chl-element-current').data('element_id'),
			$element_title = jQuery('.chl-element-content.chl-element-current').data('element_title');
			
			$element_data.forEach(function (item) {
				if (item.name === 'textarea_html') {
					var textarea_html_data = '';
					
					if( jQuery('#wp-textarea_html-wrap').hasClass('tmce-active') ){
						textarea_html_data = tinymce.get('textarea_html').getContent();
					} else {
						textarea_html_data = jQuery('textarea#textarea_html').val();
					}
					
					item.value = encodeURIComponent(textarea_html_data);
				}
			});
			
			$element_data.unshift({element_id: $element_id, element_title: $element_title});
			$element_json = JSON.stringify($element_data);
			
			jQuery('.chl-element-current').attr('data-element_data', $element_json);
			jQuery('.chl-element-settings').remove();
			jQuery('.chl-device-elements-settings').removeClass('chl-elements-settings-show');
			jQuery('.chl-element-content').removeClass('chl-element-current');
			jQuery('.chl-elements-cover').removeClass('chl-current-row');
	});
	
	//Save
	jQuery(document).on('click', '.chl-save', function() {
		var $header_title =  jQuery('.layout-title').val();
		
		if($header_title == '') {
			jQuery('.layout-title').addClass('chl-required');
			jQuery('html, body').animate({
			  scrollTop: jQuery('.layout-title').offset().top - 100
			}, 1000);
			
			return;
		} else {
			jQuery('.layout-title').removeClass('chl-required');
		}
		
		var $data_arr = {};		
		$data_arr['title'] = jQuery('.layout-title').val();
		$data_arr['header_id'] = jQuery(this).data('header_id');
		
		jQuery('.chl-elements-cover').each(function() {
			var header_possition = jQuery(this).data('possition'),
				header_configure = jQuery(this).data('element_data');
				
			$data_arr[header_possition] = {};
			$data_arr[header_possition]['configuration'] = [];
			
			$data_arr[header_possition]['configuration'] = header_configure;
			
			jQuery(this).find('.chl-element-contents').each(function() {
				var data_possition = jQuery(this).data('possition');
				$data_arr[header_possition][data_possition] = [];
				
				 $i = 0;
				 jQuery(this).find('.chl-has-elements .chl-sortable-item').each(function() {
					 
					var element_id = jQuery(this).find('.chl-element-content').data('element_id'),
						element_data = jQuery(this).find('.chl-element-content').data('element_data');
					
					$data_arr[header_possition][data_possition][$i] = {};
					$data_arr[header_possition][data_possition][$i][element_id] = element_data;					
					$i++;
				 });
			});			
		});
		
		jQuery('#wpwrap').append('<div class="chl-overlay"></div>');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			dataType: "json",
			data: { action: 'save_header_builder', objects: $data_arr },
			success: function( response ) {
				jQuery('.chl-overlay').remove();				
				if(response.redirect) {
					var url = jQuery(location).attr('href');
					url += '&header_id='+response.header_id;
					jQuery(location).attr('href',url);
				}
			}
		});
	});
	
	// Clone Header
	jQuery(document).on('click', '.header-layout-clone', function(e){
		e.preventDefault();
		
		var $header_id = jQuery(this).data('header_id'),
			$this = jQuery(this);
		
		if($header_id == '')
			return;
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: 'clone_header', headerId: $header_id },
			dataType: "json",
			success: function( response ) {
				
				var headerLocation = jQuery(location);
				href = headerLocation.attr('protocol') +'//'+ headerLocation.attr('host') + headerLocation.attr('pathname');
				
				jQuery("ul.header-layout-lists").append('<li class="header-layout-list-item"><div class="header-layout-list-item-inner"><a href="'+ href +'?page=header-layout&header_id='+response.header_id+'">'+response.header_title+'</a><div class="header-layout-list-actions"><a href="'+ href +'?page=header-layout&header_id='+response.header_id+'" class="header-layout-action header-layout-edit"><span class="dashicons dashicons-edit"></span></a><a href="'+ href +'?page=header-layout&header_id='+response.header_id+'" class="header-layout-action header-layout-clone" data-header_id="'+response.header_id+'"><span class="dashicons dashicons-admin-page"></span></a><a href="'+ href +'?page=header-layout&header_id='+response.header_id+'" class="header-layout-action header-layout-delete" data-header_id="'+response.header_id+'"><span class="dashicons dashicons-trash"></span></a></div></li>');
			}
		});
	});
	
	
    // Export Header 
    jQuery(document).on('click', '.header-layout-export', function(e){
		e.preventDefault();
		
        var $header_id = jQuery(this).data('header_id'),
			$this = jQuery(this);
		if($header_id == '')
			return;

		jQuery.ajax(
			{
				type: "POST",
				url: ajaxurl,
				data: { action: 'export_header', headerId: $header_id },
				dataType: "json",
				success: function( response ) {
					if ( response ) {
						var element = document.createElement( 'a' );

						element.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent( response.file_content ) );
						element.setAttribute( 'download', response.file_name );

						element.style.display = 'none';
						document.body.appendChild( element );
						element.click();
						document.body.removeChild( element );
					}
				}
			}
		);
	});

	// Import Header
	var importerHolder  = document.querySelector( '.chl-importer-holder' );
	var importFileInput = document.getElementById( 'chl-importer-file' );

	jQuery( document ).on( 'click', '.import-header-layout', function(e) {
		e.preventDefault();
		jQuery( '.chl-importer-container' ).addClass( 'active-container' );
		jQuery( '.chl-importer-file-name' ).remove();
		importFileInput.files = null;
	});

	jQuery( document ).on( 'click', '.chl-importer-close, .chl-import-cancel', function(e){
		e.preventDefault();
		jQuery( '.chl-importer-container' ).removeClass( 'active-container' );
		jQuery( '.chl-importer-file-name' ).remove();
		importFileInput.files = null;
	});

	if ( null != importerHolder ) {
		importerHolder.addEventListener('dragover',function (e) {
			e.preventDefault();
		});
		importerHolder.addEventListener( 'drop', function (e) {
			e.preventDefault();

			jQuery( '.chl-importer-file-name' ).remove();
			var droppedFile = e.dataTransfer.files;
			if ( 'text/plain' == droppedFile[0].type ) {
				jQuery( '.chl-importer-holder' ).find( '.chl-importer-file' ).append( '<label class="chl-importer-file-name">' + droppedFile[0].name + '</label>' );
				importFileInput.files = droppedFile;
			}
		});
	}

	jQuery( document ).on( 'change', '#chl-importer-file', function() {
		jQuery( '.chl-importer-file-name' ).remove();
		var file_data = jQuery( this ).prop( 'files' )[0];
		if ( 'text/plain' == file_data.type ) {
			jQuery( '.chl-importer-holder' ).find( '.chl-importer-file' ).append( '<label class="chl-importer-file-name">' + file_data.name + '</label>' );
		}
	});

	jQuery( document ).on('click','.chl-import-button',function(e) {
		e.preventDefault();
		
		var file_data = jQuery( '#chl-importer-file' ).prop( 'files' )[0];

		var form_data = new FormData();
		form_data.append( 'file', file_data );
		form_data.append( 'action', 'import_header' );

		console.log({form_data:form_data});

		jQuery.ajax(
			{
				type: "POST",
				url: ajaxurl,
				contentType: false,
				processData: false,
				data: form_data,
				dataType: "json",
				beforeSend: function() {
					jQuery( ".chl-importer-loader" ).show();
				},
				success: function( response ) {
					jQuery( ".chl-importer-loader" ).hide();
					if ( response ) {
						var length = jQuery( "ul.header-layout-lists li" ).length;
						length     = length - 2;

						var headerLocation = jQuery( location );
						var href           = headerLocation.attr( 'protocol' ) + '//' + headerLocation.attr( 'host' ) + headerLocation.attr( 'pathname' );

						jQuery( 'ul.header-layout-lists > li:eq(' + length + ')' ).after( '<li class="header-layout-list-item"><div class="header-layout-list-item-inner"><a href="' + href + '?page=header-layout&header_id=' + response.header_id + '">' + response.header_title + '</a><div class="header-layout-list-actions"><a href="' + href + '?page=header-layout&header_id=' + response.header_id + '" class="header-layout-action header-layout-edit"><span class="dashicons dashicons-edit"></span></a><a href="' + href + '?page=header-layout&header_id=' + response.header_id + '" class="header-layout-action header-layout-clone" data-header_id="' + response.header_id + '"><span class="dashicons dashicons-admin-page"></span></a><a href="' + href + '?page=header-layout&header_id=' + response.header_id + '" class="header-layout-action header-layout-export" data-header_id="' + response.header_id + '"><span class="dashicons dashicons-upload"></span></a><a href="' + href + '?page=header-layout&header_id=' + response.header_id + '" class="header-layout-action header-layout-delete" data-header_id="' + response.header_id + '"><span class="dashicons dashicons-trash"></span></a></div></li>' );
					}

					jQuery( '#chl-importer-file' ).val( null );
					jQuery( '.chl-importer-close .dashicons' ).click();

					jQuery( '.chl-importer-file-name' ).remove();
					importFileInput.files = null;
				},
			}
		);
	});
	

	// Delete Header
	jQuery(document).on('click', '.header-layout-delete', function(e){
		e.preventDefault();
		
		var $header_id = jQuery(this).data('header_id'),
			$this = jQuery(this);
		if($header_id == '')
			return;
		
		if (confirm('Are you sure to delete this header layout?')) {
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: { action: 'delete_header', headerId: $header_id },
				dataType: "json",
				success: function( response ) {
					$this.parents('li').remove();
				}
			});
        }
		
	});
	
	// Configure Header
	jQuery(document).on('click', '.chl-row-configure', function() {
		
		if(jQuery(this).parents('.chl-elements-cover').hasClass('chl-current-row')) {
			return;
		}
		
		jQuery('.chl-structure').append('<div class="chl-settings-loading"></div>');

		jQuery('.chl-device-elements-settings').html('');
		jQuery('.chl-device-elements-settings').removeClass('chl-elements-settings-show');
		jQuery('.chl-elements-cover').removeClass('chl-current-row');
		
		jQuery('.chl-element-content').removeClass('chl-element-current');
		jQuery(this).parents('.chl-elements-cover').addClass('chl-current-row');
		
		var $elementTitle = jQuery('.chl-current-row').data('element_title'),
			$elements_data = jQuery('.chl-current-row').attr('data-element_data'),
			elements_data = '';
		if($elements_data != '') {
			elements_data_arr = JSON.parse($elements_data);
			
			elements_data = [];
			jQuery.each(elements_data_arr, function(key, value) {
				elements_data[value.name] = value.value;								
			});
		}
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: 'header_configure' },
			dataType: "json",
			success: function( response ) {
				
				var $output = '',
					$fiels = '';
					$tabs = [],
					$active_tab = true;

				jQuery.each( response, function( key, value ) {
					if(jQuery.inArray( value.group, $tabs ) == -1) {
						$tabs.push(value.group);
					}
					$fiels += get_element_field(value, elements_data);
				});

				$output += '<div class="chl-element-settings"><div class="chl-element-settings-inner">';
				$output += '<div class="chl-element-settings-header">';
				$output += '<div class="chl-element-settings-close"><span class="dashicons dashicons-no"></span></div><div class="chl-element-settings-title">'+chl.configure+' '+$elementTitle+' '+chl.settings+'</div>';
				
				// Tabs
				$output += '<div class="chl-edit-tabs">';
				jQuery.each( $tabs, function( key, value ) {
					if($active_tab) {
						$output += '<div class="chl-tabs-title chl-tab-active" data-tab="'+ value +'">'+ value +'</div>';
						$active_tab = false;
					} else {
						$output += '<div class="chl-tabs-title" data-tab="'+ value +'">'+ value +'</div>';
					}
				});
				$output += '</div>';
				$output += '</div>';
				
				$output +='<div class="chl-element-settings-content chl-element-settings-edit-content"><div class="chl-element-edit"><form id="header_builder_elements_form" method="get">';
				
				// Tabs Contents
				$output += '<div class="chl-editor-fields">';
				$output += $fiels;
				$output += '</div>';
				
				// Tabs Footer
				$output += '<div class="chl-edit-action-tabs">';
				$output += '<a class="button button-primary button-large chl-save-configuration">'+chl.save+'</a>';
				$output += '<a class="button button-secondary button-large chl-close-element">'+chl.cancel+'</a>';
				$output += '</div>';

				$output += '</from></div></div></div></div>';
				
				jQuery('.chl-settings-loading').remove();
				jQuery('.chl-device-elements-settings').append($output);
				jQuery('.chl-device-elements-settings').addClass('chl-elements-settings-show');
				
				getRangeSlider();
				fieldsActionHideShow();
				formDataDependency();
				setColorPicker();
				enableSelect2();
			}
		});
	});
	
	// Save Header Configuration
	jQuery(document).on('click', '.chl-save-configuration', function() {
		
		var $element_data = jQuery('#header_builder_elements_form').serializeArray();		
		$element_json = JSON.stringify($element_data);
		jQuery('.chl-current-row').attr('data-element_data', $element_json);
		
		jQuery('.chl-element-settings').remove();
		jQuery('.chl-device-elements-settings').removeClass('chl-elements-settings-show');
		jQuery('.chl-element-content').removeClass('chl-element-current');
		jQuery('.chl-elements-cover').removeClass('chl-current-row');
	});
	
	elementDraggable();
	elementActionHideShow();
	fieldsActionHideShow();
	
	
	jQuery('.chl-field-colorpicker').wpColorPicker();
	
	// Media uploader
	var mediaUploader;
	
	jQuery(document).on( 'click', '.media-upload', function ( event ) {
		event.preventDefault();
		
		var $this = jQuery(this).parents('.chl-background-setting-field');
		
		// If the uploader object has already been created, reopen the dialog
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image',
				close: true
			},
			multiple: false 
		});

		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
			var attachment = mediaUploader.state().get('selection').first().toJSON();			
			$this.find('.chl-field-media-id').val(attachment.id);
			$this.find('.chl-field-media-src').val(attachment.url);

			if ( $this.find('.chl-field-media-cover img').length > 0 ) {
				$this.find('.chl-field-media-cover img').attr('src' , attachment.url);
			} else {
				$this.find('.chl-field-media-cover').append('<img src="'+attachment.url+'"/>');
			}

			$this.find('.chl-field-media-cover').removeClass('hidden');
			$this.find('.chl-remove-media-button').removeClass('hidden');
		});
		// Open the uploader dialog
		mediaUploader.open();
	});
	
	jQuery(document).on('click', '.chl-remove-media-button', function() {
		var $this = jQuery(this).parents('.chl-background-setting-field');
		$this.find('.chl-field-media-id').val('');
		$this.find('.chl-field-media-src').val('');
		$this.find('.chl-field-media-cover img').attr('src' , '');
		$this.find('.chl-field-media-cover').addClass('hidden');
		jQuery(this).addClass('hidden');
	});

});

function elementDraggable() {
	jQuery('.chl-element-sortable').sortable({
		scroll: false,
		cursor: "move",
		connectWith: ".chl-element-sortable",
		opacity: 0.7,
		helper: "original",
		placeholder: "chl-element-sortable-placeholder",
		start: function(event, ui){
			var cloneItem = ui.item.html();
			ui.placeholder.html(cloneItem);
		},
		sort: function(event, ui) {
			elementActionHideShow();
		},
		stop: function(event, ui) {
			elementActionHideShow();
		},
	}).disableSelection();
	
	jQuery('.chl-elements-list .chl-sortable-item').draggable({
		scroll: false,
		cursor: "move",
		opacity: 0.7,
		stack: ".chl-sortable-item",
		helper: 'clone',
	});
	
	jQuery('.chl-element-sortable').droppable({
		accept: ".chl-elements-list .chl-sortable-item",
		drop: function(event, ui) {
			var droppable = jQuery(this);
			var draggable = ui.draggable;
			
			var elementTitle = ui.draggable.find('.chl-element-content').data('element_title'),
				elementId = ui.draggable.find('.chl-element-content').data('element_id'),
				$element_data = [];
				
			$element_data.unshift({element_id: elementId, element_title: elementTitle});				
			var $element_json = JSON.stringify($element_data);
			
			draggable.clone().appendTo(droppable).find('.chl-element-content').attr('data-element_data', $element_json );
			elementActionHideShow();
		}
	});
}

function elementActionHideShow() {
	// Hide & Show element add action
	jQuery('.chl-element-sortable').each(function() {
		var sortableItemLength = jQuery(this).find('.chl-sortable-item').length + jQuery(this).find('.chl-element-sortable-placeholder').length;
		if(sortableItemLength <= 0) {
			jQuery(this).removeClass('chl-has-elements');
		} else {
			jQuery(this).addClass('chl-has-elements');
		}
	});
}

// Get element field
function get_element_field(fields, elements_data) {
	
	if(!fields)
		return;
	
	var $fields = classes = value = element_value = $data_attr = '';
	
	if(elements_data && elements_data[fields.param_name] != undefined) {
		value = elements_data[fields.param_name];
	}
	
	if( fields.default ){
		if(!value){
			value = fields.default;
		}
	}
	
	if( fields.classes != undefined) {
		classes = fields.classes;
	}
	
	if( fields.dependency ){
		
		jQuery.each( fields.dependency, function( key, value ) {
			if( key == 'element'){
				element_name = value;
			} else if( key == 'value'){
				element_value = JSON.stringify(value);
			}
		});
		
		dependency = JSON.stringify(fields.dependency);
	    $data_attr = "data-dependency-element='"+element_name+"' data-dependency-value='"+element_value+"'";
	}
	
	$fields += "<div class='chl-field-option' data-content='"+ fields.group +"' "+$data_attr+">";
	$fields += '<div class="chl-field-label">'+ fields.heading +'</div>';
	$fields += '<div class="chl-field-input-cover '+ fields.type +'">';
	switch(fields.type) {
		case 'pgscore_range_slider':
			
			min  = fields.min != "" ?  fields.min : 0;
			max  = fields.max != "" ?  fields.max : 100;
		    unit = fields.unit != "" ?  fields.unit : "";
			
			if(fields.label){
				$fields += '<label class="chl-radio-label pgs-range-slider" for="'+ fields.param_name +'">';
				$fields += fields.label;
				$fields += '</label>';
			}
			
			$fields += '<input type="hidden" class="pgscore_range_slider chl-field-input" name="'+fields.param_name+'" value="'+ value +'">';
			$fields += '<div class="pgscore-range-slider" data-min_value="'+min+'" data-max_value="'+max+'" data-unit="'+unit+'"></div>';
			
			break;
		case 'textarea_html':
			
			data = decodeURIComponent(value);
			// data2 = decodeURIComponent(data);
			data2 = data;
			
			$fields += '<textarea id="textarea_html" name="'+fields.param_name+'">'+data2+'</textarea>';
			break;
			
		case 'textfield':
			
			var placeholder =  '';
			
			if( fields.placeholder ){
				placeholder = fields.placeholder;
			}
			
			$fields += '<input class="chl-field-input chl-field-textfield textfield" type="text" placeholder="'+placeholder +'" name="'+fields.param_name+'" value="'+ value +'"/>';
			
			break;
		case 'dropdown':
		
			multiple = '';
			value = value.split(', ');
			
			dropdownClass = 'chl-field-input chl-field-dropdown dropdown';
			if( fields.multiple){
				multiple = ' multiple="multiple"';
			}
			
			if( fields.enable_select2){
				dropdownClass = dropdownClass+' select2-enabled';
			}
			
			$fields += '<select class="'+dropdownClass+'" name="'+fields.param_name+'"'+multiple+'>';
			jQuery.each( fields.options, function( key, val ) {			
				var selected = '';
				
				if( jQuery.inArray( key, value ) !== -1 ) {
					selected = 'selected';
				}
				$fields += '<option value="'+ key +'" '+selected+'>'+ val +'</option>';
			});
			$fields += '</select>';
			
			break;
		case 'checkbox':
		
			var checked = '';
			
			if(value) {
				checked = 'checked';
			}
			
			$fields += '<label class="chl-label chl-checkout-label" for="'+ fields.param_name +'">';
			$fields += '<input type="checkbox" id="'+ fields.param_name +'" value="true" class="chl-field-input chl-checkbox '+ classes +'" name="'+ fields.param_name +'" '+ checked +'>';
			$fields += '<span class="chl-checkout-title">'+ fields.options +'</span>';
			$fields += '</label>';
			
			break;
		case 'checkbox_multi': 
			
			
			jQuery.each( fields.options, function( key, val ) {
				
				var checked = '';
				
				if(elements_data[key]) {
					checked = 'checked';
				} else if(val.default) {
					checked = 'checked';
				}
					
				$fields += '<label class="chl-label chl-checkout-label" for="'+ key +'">';
				$fields += '<input type="checkbox" id="'+ key +'" value="true" class="chl-field-input chl-checkbox '+ classes +'" name="'+ key +'" '+ checked +'>';
				$fields += '<span class="chl-checkout-title">'+ val.heading +'</span>';
				$fields += '</label>';
				
			});
			
			break;
		case 'radio_buttonset' :
		
			jQuery.each( fields.options, function( key, val ) {
				var checked = '';
				
				if(key == value) {
					checked = 'checked';
				}
				
				$fields += '<label class="chl-label chl-radio-label" for="'+ fields.param_name +'-'+ key +'">';
				$fields += '<input type="radio" id="'+ fields.param_name +'-'+ key +'" value="'+ key +'" class="chl-field-input chl-radio '+ classes +'" name="'+ fields.param_name +'" '+ checked +'>';
				$fields += '<span class="chl-radio-title">'+ val +'</span>';
				$fields += '</label>';
				
			});
			break;
		case 'radio_image':
		
			jQuery.each( fields.options, function( key, val ) {		
				var checked = '';
				
				if(key == value) {
					checked = 'checked';
				}
				
				$fields += '<label class="chl-label chl-radio-label" for="'+ fields.param_name +'-'+ key +'">';
				$fields += '<input type="radio" id="'+ fields.param_name +'-'+ key +'" value="'+ key +'" class="chl-field-input chl-radio '+ classes +'" name="'+ fields.param_name +'" '+ checked +'>';
				$fields += '<span class="chl-radio-title"><img class="radio_image_picker" src="'+ val +'"></span>';
				$fields += '</label>';
				
			});
			break;
		case 'radio':
		
			jQuery.each( fields.options, function( key, val ) {		
				var checked = '';
				
				if(key == value) {
					checked = 'checked';
				}
				
				$fields += '<label class="chl-label chl-radio-label" for="'+ fields.param_name +'-'+ key +'">';
				$fields += '<input type="radio" id="'+ fields.param_name +'-'+ key +'" value="'+ key +'" class="chl-field-input chl-radio-button '+ classes +'" name="'+ fields.param_name +'" '+ checked +'>';
				$fields += '<span class="chl-radio-title">'+ val +'</span>';
				$fields += '</label>';
			});
			break;
		case 'radio_icon':
		
			jQuery.each( fields.options, function( key, val ) {			
				var checked = '';
				
				if(key == value) {
					checked = 'checked';
				}
				
				$fields += '<label class="chl-label chl-radio-label" for="'+ fields.param_name +'-'+ key +'">';
				$fields += '<input type="radio" id="'+ fields.param_name +'-'+ key +'" value="'+ key +'" class="chl-field-input chl-radio '+ classes +'" name="'+ fields.param_name +'" '+ checked +'>';
				$fields += '<span class="chl-radio-title">'+ val +'</span>';
				$fields += '</label>';
				
			});
			break;
		case 'colorpicker':
		
			$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" data-alpha="true" type="text" placeholder="" name="'+fields.param_name+'" value="'+ value +'"/>';
			break;
		case 'background_settings':
		
			var selectOptions = {},
				hiddenClass = (elements_data[fields.param_name +'_bg_src'] == undefined) ? 'hidden' : '',
				bg_image = (elements_data[fields.param_name +'_bg_image'] != undefined) ? elements_data[fields.param_name +'_bg_image'] : '',
				bg_src = (elements_data[fields.param_name +'_bg_src'] != undefined) ? elements_data[fields.param_name +'_bg_src'] : '',				
				bg_color = (elements_data[fields.param_name +'_bg_color'] != undefined) ? elements_data[fields.param_name +'_bg_color'] : '',
				bg_repeat = (elements_data[fields.param_name +'_bg_repeat'] != undefined) ? elements_data[fields.param_name +'_bg_repeat'] : 'inherit',
				bg_size = (elements_data[fields.param_name +'_bg_size'] != undefined) ? elements_data[fields.param_name +'_bg_size'] : 'inherit',
				bg_attachment = (elements_data[fields.param_name +'_bg_attachment'] != undefined) ? elements_data[fields.param_name +'_bg_attachment'] : 'inherit',
				bg_position = (elements_data[fields.param_name +'_bg_position'] != undefined) ? elements_data[fields.param_name +'_bg_position'] : 'inherit';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_image"> <span class="chl-label-title">'+chl.upload_image+'</span> </label>';
			$fields += '<div class="chl-field-media-cover '+ hiddenClass +'">';

			if ( bg_src ) {
				$fields += '<img src="'+ bg_src +'">';
			}

			$fields += '</div>';
			$fields += '<input class="chl-field-input button chl-button button-large chl-field-media media-upload" id="'+ fields.param_name +'_bg_image" type="button" value="Upload"/>';
			$fields += '<input class="chl-field-input button chl-button button-large chl-remove-media-button '+ hiddenClass +'" type="button" value="Remove"/>';
			$fields += '<input class="chl-field-input chl-field-media-id hidden" type="text" name="'+ fields.param_name +'_bg_image" value="'+ bg_image +'"/>';
			$fields += '<input class="chl-field-input chl-field-media-src hidden" type="text" name="'+ fields.param_name +'_bg_src" value="'+ bg_src +'"/>';
			$fields += '</div>';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_color"> <span class="chl-label-title">'+chl.color+'</span> </label>';
			$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" data-alpha="true" id="'+ fields.param_name +'_bg_color" type="text" name="'+ fields.param_name +'_bg_color" value="'+ bg_color +'"/>';
			$fields += '</div>';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_repeat"> <span class="chl-label-title">'+chl.image_repeat+'</span> </label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_bg_repeat" name="'+ fields.param_name +'_bg_repeat">';
			selectOptions = {'inherit': 'Inherit', 'no-repeat': 'No repeat', 'repeat': 'Repeat All', 'repeat-x': 'Repeat Horizontally', 'repeat-y': 'Repeat Vertically'};
			jQuery.each( selectOptions, function( key, val ) {				
				if(bg_repeat == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_size"> <span class="chl-label-title">'+chl.image_size+'</span> </label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_bg_size" name="'+fields.param_name+'_bg_size">';			
			selectOptions = {'inherit': 'Inherit', 'cover': 'Cover', 'contain': 'Contain'};
			jQuery.each( selectOptions, function( key, val ) {				
				if(bg_size == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_attachment"> <span class="chl-label-title">'+chl.image_attachment+'</span> </label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_bg_attachment" name="'+fields.param_name+'_bg_attachment">';			
			selectOptions = {'inherit': 'Inherit', 'fixed': 'Fixed', 'scroll': 'Scroll'};
			jQuery.each( selectOptions, function( key, val ) {				
				if(bg_attachment == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			
			$fields += '<div class="chl-background-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_bg_position"> <span class="chl-label-title">'+chl.image_position+'</span> </label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_bg_position" name="'+fields.param_name+'_bg_position">';
			selectOptions = {'inherit': 'Inherit', 'left top': 'Left Top','left center': 'Left Center','left bottom': 'Left Bottom','center top': 'Center Top','center center': 'Center Center','center bottom': 'Center Bottom','right top': 'Right Top','right center': 'Right Center','right bottom': 'Right Bottom' };
			jQuery.each( selectOptions, function( key, val ) {				
				if(bg_position == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			break;				
		case 'color_settings':
		
			var color = (elements_data[fields.param_name +'_color'] != undefined) ? elements_data[fields.param_name +'_color'] : '',
				link_color =  (elements_data[fields.param_name +'_link_color'] != undefined) ? elements_data[fields.param_name +'_link_color'] : '',
				hover_color = (elements_data[fields.param_name +'_hover_color'] != undefined) ? elements_data[fields.param_name +'_hover_color'] : '';
			
			if( fields.text_color != false ){
				$fields += '<div class="chl-color-setting-field">';
				$fields += '<label class="chl-label" for="'+ fields.param_name +'_color"> <span class="chl-label-title">'+chl.text_color+'</span> </label>';
				$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" type="text" placeholder="" name="'+fields.param_name+'_color" value="'+ color +'"/>';
				$fields += '</div>';
			}
			
			if( fields.link_color != false ){
				$fields += '<div class="chl-color-setting-field">';
				$fields += '<label class="chl-label" for="'+ fields.param_name +'_link_color"> <span class="chl-label-title">'+chl.link_color+'</span> </label>';
				$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" type="text" placeholder="" name="'+fields.param_name+'_link_color" value="'+ link_color +'"/>';
				$fields += '</div>';
			}
			
			if( fields.hover_color != false ){
				$fields += '<div class="chl-color-setting-field">';
				$fields += '<label class="chl-label" for="'+ fields.param_name +'_hover_color"> <span class="chl-label-title">'+chl.link_hover_color+'</span> </label>';
				$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" type="text" placeholder="" name="'+fields.param_name+'_hover_color" value="'+ hover_color +'"/>';
				$fields += '</div>';
			}
			
			break;
		case 'border_settings':
		
			var width = (elements_data[fields.param_name +'_width'] != undefined) ? elements_data[fields.param_name +'_width'] : 0,
				color = (elements_data[fields.param_name +'_color'] != undefined) ? elements_data[fields.param_name +'_color'] : '',
				style = (elements_data[fields.param_name +'_style'] != undefined) ? elements_data[fields.param_name +'_style'] : 'solid';
				boder_width = (elements_data[fields.param_name +'_border_width'] != undefined) ? elements_data[fields.param_name +'_border_width'] : 'full_width';
				
			
			$fields += '<div class="chl-border-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_width"> <span class="chl-label-title">'+chl.width+'</span> </label>';
			$fields += '<input class="chl-field-input chl-field-number" type="number" placeholder="" min="0" max="10" name="'+fields.param_name+'_width" value="'+ width +'"/>';
			$fields += '</div>';
			
			$fields += '<div class="chl-border-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_style"> <span class="chl-label-title">'+chl.style+'</span> </label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_style" name="'+fields.param_name+'_style">';			
			selectOptions = {'dotted': 'Dotted', 'dashed': 'Dashed', 'solid': 'Solid', 'double': 'Double', 'groove': 'Groove', 'ridge': 'Ridge', 'inset': 'Inset', 'outset': 'Outset', 'initial': 'Initial', 'inherit': 'Inherit'};
			jQuery.each( selectOptions, function( key, val ) {				
				if(style == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			
			$fields += '<div class="chl-border-setting-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_border_width"><span class="chl-label-title">'+chl.border_width+'</span></label>';
			$fields += '<select class="chl-field-input chl-field-dropdown dropdown" id="'+ fields.param_name +'_border_width" name="'+fields.param_name+'_border_width">';			
			selectOptions = {'full_width': chl.full_width, 'container': chl.container};
			jQuery.each( selectOptions, function( key, val ) {				
				if(boder_width == key) {
					$fields += '<option value="'+ key +'" selected="selected">'+ val +'</option>';
				} else {
					$fields += '<option value="'+ key +'">'+ val +'</option>';
				}
			});
			$fields += '</select>';
			$fields += '</div>';
			
			$fields += '<div class="chl-border-setting-field last-field">';
			$fields += '<label class="chl-label" for="'+ fields.param_name +'_color"> <span class="chl-label-title">'+chl.color+'</span> </label>';
			$fields += '<input class="chl-field-input chl-field-colorpicker colorpicker color-picker" type="text" placeholder="" name="'+fields.param_name+'_color" value="'+ color +'"/>';
			$fields += '</div>';
			
			break;
			
		default:
	}
	
	$fields += '</div>';	
	
	if(fields.description != undefined) {
		$fields += '<span class="chl-description">'+ fields.description +'</span>';
	}	
	$fields += '</div>';
	return $fields;	
}

// Element fields Hide & Show
function fieldsActionHideShow() {
	jQuery('.chl-field-option').each(function(){
		
		var $data_tab = jQuery('.chl-edit-tabs .chl-tabs-title.chl-tab-active').data('tab');
		
		if (jQuery(this).data('content') == $data_tab) {
			jQuery(this).show();
		} else {
			jQuery(this).hide();
		}
	});
	formDataDependency();
}

// Add editor field
function fieldsEditor(){
	wp.editor.initialize( 'textarea_html', {
		tinymce: {
			wpautop: true
		},
		quicktags: true,
		mediaButtons: false
	});
}

// Remove editor field
function fieldsEditorRemove(){
	if ( tinymce.get( 'textarea_html' ) ) {
		wp.editor.remove( 'textarea_html' );
	}
}

// Add range slider field
function getRangeSlider(){
	jQuery(".pgscore-range-slider").each( function() {
		var range_val = jQuery( this ).parent().find( ".pgscore_range_slider" ).val(),
			min_range_val = jQuery(this).data('min_value'),
			max_range_val = jQuery(this).data('max_value'),
			unit_range_val = jQuery(this).data('unit'),
			slider_label  = jQuery( this ).parent().find("label.pgs-range-slider").text();
		
		jQuery( this ).slider({
			range: "min",
			value: range_val != "" ?  range_val : 10,
			min: min_range_val,
			max: max_range_val,
			slide: function( event, ui ) {
				jQuery( this ).parent().find( ".pgscore_range_slider" ).val( ui.value );
				jQuery( this ).parent().find("label.pgs-range-slider").text( slider_label + ': ' + ui.value + unit_range_val );
			}
		});
		jQuery( this ).parent().find("label.pgs-range-slider").text( slider_label + ': ' + jQuery( this ).slider( "value" ) + unit_range_val);
	});
}

jQuery(document).on('click', '.chl-field-input', function() {
	var value = jQuery(this).val();
	var param_name = jQuery(this).attr('name');
	var $data_tab = jQuery('.chl-edit-tabs .chl-tabs-title.chl-tab-active').data('tab');
	
	jQuery('[data-dependency-element="'+param_name+'"]').each(function(){
		dependency = jQuery(this).data('dependency-value');
		dependency_tab = jQuery(this).data('content');
		
		if(jQuery.inArray(value, dependency) == -1){
			jQuery(this).hide();
		}else{
			if( dependency_tab == $data_tab ){
				jQuery(this).show();
			}
		}
	});
});

function formDataDependency(){

	jQuery("form#header_builder_elements_form :input").each(function(){
		if( this.checked ){
			var value = jQuery(this).val();
			var param_name = jQuery(this).attr('name');
			var $data_tab = jQuery('.chl-edit-tabs .chl-tabs-title.chl-tab-active').data('tab');
			
			jQuery('[data-dependency-element="'+param_name+'"]').each(function(){
				dependency = jQuery(this).data('dependency-value');
				dependency_tab = jQuery(this).data('content');
				
				if(jQuery.inArray(value, dependency) == -1){
					jQuery(this).hide();
				}else{
					if( dependency_tab == $data_tab ){
						jQuery(this).show();
					}
				}
			});
		}
	});
}

function setColorPicker() {
	jQuery('.color-picker').wpColorPicker();
}

function enableSelect2() {
	jQuery('.select2-enabled').select2({
		containerCssClass: 'chl-gropdown-container',
	});
}

function device_related_elements(){
	var $active_device = jQuery('.chl-toolbar-devices span.active-devices').data('device');
	
	if( !$active_device ) return;
	
	if( $active_device == 'desktop' ) {
		jQuery('.chl-element-for-mobile').hide();
		jQuery('.chl-element-for-desktop').show();	
	}
	
	if( $active_device == 'mobile' ) {
		jQuery('.chl-element-for-desktop').hide();
		jQuery('.chl-element-for-mobile').show();	
	}
}