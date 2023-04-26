jQuery( document ).ready( function( $ ) {
	jQuery( document ).on( 'click', '.add-row', function( event ) {
		event.preventDefault();
		var parent_field_id = jQuery(this).parents( '.repeater' ).find('table').attr( 'data-repeater-id' );
		var repeater_data   = jQuery(this).parents( '.repeater' ).find('table').attr( 'data-repeater-fields' );
		var repeater_table  = parent_field_id + '_repeater';
		var post_id         = jQuery(this).parents( '.repeater' ).find('table').attr( 'data-post-id' );
		var order           = jQuery( '#' + parent_field_id + '_order' ).val();
		var count;

		if ( order ) {
			var count_array     = order.split(',');
			var count_result    = count_array.map(function (x) { 
				return parseInt(x, 10); 
			});
			count = Math.max.apply( Math,count_result ) + 1;
		} else {
			count = 0;
		}
		
		$.ajax( {
			type: "POST",
			url: pgs.ajaxurl,
			data: { action: 'add_new_meta_field', parent_field_id: parent_field_id, post_id : post_id, count : count, repeter_add_field_nonce : pgs.repeter_add_field_nonce, repeater_data : repeater_data },
			beforeSend : function() {
				jQuery( '#' + repeater_table ).addClass( 'repeater-loading' );
			},
			success: function( response ) {
				jQuery( '#' + repeater_table ).removeClass( 'repeater-loading' );
				if ( jQuery( response ).find( 'textarea' ).length > 0 ) {		

					jQuery( '#' + repeater_table + ' tbody' ).append( response );
					jQuery( response ).find( 'textarea' ).each( function() {
						var editor_id = jQuery( this ).attr( 'id' );
						if( typeof(tinyMCE) != 'undefined' ){
							setTimeout( function(){
								tinymce.execCommand( 'mceRemoveEditor', false, editor_id );
								tinymce.execCommand( 'mceAddEditor', false, editor_id );
								quicktags({id : editor_id});
							}, 300 );
						}
					});

				} else {
					jQuery( '#' + repeater_table + ' tbody' ).append( response );
				}

				meta_iconpicker();
				hide_oembed_cancel();
				meta_field_post_object_select();
				google_map_field();
				input_range_field();
				jQuery( '.repeater-table tbody' ).sortable('refresh');
				row_index( parent_field_id );
			}
		} );
	});

	hide_oembed_cancel();

	if ( jQuery( '.meta-field-post-object-select' ).length > 0 ) {
		jQuery( '.meta-field-post-object-select' ).each( function() {
			var post_type = jQuery( this ).parents( '.meta-input-field' ).attr( 'data-post-type' );
			var per_page  = jQuery( this ).parents( '.meta-input-field' ).attr( 'data-per-page' );
			
			jQuery( this ).select2({
				ajax: {
					url: pgs.ajaxurl,
					dataType: 'json',
						data: function (params) {
						var query = {
							post_type: post_type,
							per_page: per_page,
							meta_post_object_nonce : pgs.meta_post_object_nonce,
							action: 'post_object_ajax_results',
							search: params.term,
							page: params.page || 1
						};
						return query;
					},
				}
			});
		});
	}
	
	jQuery( document ).on( 'change', '.meta-input-oembed input.meta-oembed-input-field', function( event ) {
		event.preventDefault();

		var field_url     = jQuery( this ).val();
		var fields_parent = jQuery( this ).parents( '.meta-input-oembed' );
		
		if ( field_url ) {
			$.ajax( {
				type: "POST",
				url: pgs.ajaxurl,
				data: { action: 'meta_get_oembed', meta_get_oembed_nonce : pgs.meta_get_oembed_nonce, field_url : field_url },
				beforeSend : function() {
					jQuery( fields_parent ).find( '.meta-field-oembed' ).addClass( 'loading' );
				},
				success: function( response ) {
					jQuery( fields_parent ).find( '.meta-field-oembed' ).removeClass( 'loading' );
					if ( response ) {
						jQuery( fields_parent ).find( '.meta-field-oembed' ).html( response );
						jQuery( fields_parent ).find( '.meta-input-actions' ).show();
					} else {
						jQuery( fields_parent ).find( '.meta-input-actions' ).hide();
					}
				}
			} );
		}
	});
	
	jQuery( document ).on( 'click', '.meta-input-actions a', function( event ) {
		event.preventDefault();

		var fields_parent = jQuery( this ).parents( '.meta-input-oembed' );
		jQuery( fields_parent ).find( '.meta-field-oembed' ).html( '' );
		jQuery( fields_parent ).find( 'input.meta-oembed-input-field' ).val( '' );
		jQuery( this ).parents( '.meta-input-actions' ).hide();
	});
	
	jQuery( document ).on( 'click', '.meta-input-button-group input', function( event ) {
		jQuery( this ).parents( '.meta-input-button-group' ).find( 'label.selected' ).removeClass( 'selected' );
		jQuery( this ).parent( 'label' ).addClass( 'selected' );
	});

	jQuery( document ).on( 'change', '.google-map-search-field', function () {
		if( ! $(this).val() ){
			$( this ).parents( '.meta-input-field' ).find( '.google-map-field-data' ).val( '' );
		}
	});

	meta_iconpicker();
	meta_field_post_object_select();
	input_range_field();
	google_map_field();
	field_dependancy();
	meta_fields_tab_heights();
	
	jQuery( document ).on( 'click', '.meta-field-tabs > .meta-field-tab', function( event ) {
		event.preventDefault();
		jQuery( this ).parents( '.pgs-helper-custom-meta-fields' ).find( '.meta-field-tab.active' ).removeClass( 'active' );
		jQuery( this ).addClass( 'active' );
		field_dependancy();
		meta_fields_tab_heights();
	});

	jQuery( '.date-picker-field' ).each( function() {
		var altformat      = jQuery( this ).find( '.field-date-picker' ).attr( 'data-altformat' );
		var dateformat     = jQuery( this ).find( '.field-date-picker' ).attr( 'data-dateformat' );
		var date_alt_field = jQuery( this ).find( '.field-date-picker-alt' ).attr( 'id' );
		
		if ( ! dateformat ) {
			dateformat = 'yy/mm/dd';
		}

		if ( ! altformat ) {
			altformat = 'yymmdd';
		}
	
		jQuery( this ).find( '.field-date-picker' ).datepicker({
			changeMonth: true,
			changeYear: true,
			altField:   '#'+ date_alt_field,
			altFormat:   altformat,
			dateFormat:  dateformat
		});
	});

	jQuery( document ).on( 'click', '.remove-row', function( event ) {
		var field_id = jQuery(this).parents( '.repeater' ).find('table').attr( 'data-repeater-id' );
		event.preventDefault();

		jQuery( this ).parents( 'tr' ).fadeOut( 400, function() { jQuery(this).remove(); });
		row_index( field_id );
	});

	jQuery( '.repeater-table tbody' ).sortable({
		items: 'tr',
		update: function() {
			var field_id = jQuery(this).parent( 'table' ).attr( 'data-repeater-id' );
			row_index( field_id );
		},
	});

	var row_index = function( field_id ){
		var tr_order = '';
		var count    = '';

		var total    = jQuery( '#' + field_id + '_repeater tbody tr' ).length;
		jQuery( '#' + field_id + '_repeater tbody tr' ).each(function( index ) {
			tr_order += jQuery( this ).attr( 'data-fields-index' );
			if ( index !== total - 1 ) {
				tr_order += ',';
			}
		});

		if ( tr_order ) {
			var count_array = tr_order.split(',');
				count       = count_array.length;
		}

		jQuery( '#' + field_id ).val( count );
		jQuery( '#' + field_id + '_order' ).val( tr_order );
		
		jQuery( '.meta-color-field' ).wpColorPicker();
	};
	
	jQuery( '.meta-color-field' ).wpColorPicker();
	
	// Image Upload
	jQuery( document ).on( 'click', '.meta-image-upload', function( event ) {
		event.preventDefault();

		var frame;
		var $el         = $( this );
		var this_parent = $el.parents( 'div.meta-field-image' );

		if ( frame ) {
			 frame.close();
		}

		frame = wp.media({
			title: $el.data( pgs.choose ),
			button: {
				text: $el.data( pgs.update ),
				close: false,
			},
			multiple: false,
			library: {
				type: 'image'
			},
		});

		frame.on(
			'select',
			function () {
				var attachment = frame.state().get( 'selection' ).first();
				var image_url;

				frame.close( attachment );

				if ( attachment.attributes.sizes.thumbnail.url ) {
					image_url = attachment.attributes.sizes.thumbnail.url;
				} else {
					image_url = attachment.attributes.url;
				}

				this_parent.find( '.meta-image-holder' ).empty().hide().append( '<img src="' + image_url + '" >' ).slideDown( 'fast' );
				$el.parents( '.meta-field-image' ).find( '.image-field-id' ).val( attachment.attributes.id );
				$el.removeClass( 'meta-image-upload' );
				$el.addClass( 'meta-image-remove' );
				$el.val( pgs.remove );
			}
		);
		frame.open();
	});
	
	// Image Upload
	jQuery( document ).on( 'click', '.meta-bg-image-upload', function( event ) {
		event.preventDefault();

		var bg_frame;
		var $el         = $( this );
		var this_parent = $el.parents( 'div.meta-field-background' );

		if ( bg_frame ) {
			 bg_frame.close();
		}

		bg_frame = wp.media({
			title: $el.data( pgs.choose ),
			button: {
				text: $el.data( pgs.update ),
				close: false,
			},
			multiple: false,
			library: {
				type: 'image'
			},
		});

		bg_frame.on(
			'select',
			function () {
				var attachment = bg_frame.state().get( 'selection' ).first();
				var image_url,
					image_height,
					image_width,
					thumb_url;

				bg_frame.close( attachment );
				image_url = attachment.attributes.url;

				if ( attachment.attributes.sizes.thumbnail.url ) {
					image_url = attachment.attributes.sizes.thumbnail.url;
				}
				
				if ( attachment.attributes.sizes.full.height ) {
					image_height = attachment.attributes.sizes.full.height;
				}
				
				if ( attachment.attributes.sizes.full.width ) {
					image_width = attachment.attributes.sizes.full.width;
				}
				
				if ( attachment.attributes.sizes.thumbnail.url ) {
					image_url = attachment.attributes.sizes.thumbnail.url;
					thumb_url = attachment.attributes.sizes.thumbnail.url;
				}

				this_parent.find( '.meta-image-holder' ).empty().hide().append( '<img src="' + image_url + '" >' ).slideDown( 'fast' );
				$el.parents( '.meta-field-background' ).find( '.image-field-id' ).val( attachment.attributes.id );
				$el.parents( '.meta-field-background' ).find( '.image-field-url' ).val( attachment.attributes.url );
				$el.parents( '.meta-field-background' ).find( '.image-media-id' ).val( attachment.attributes.id );
				$el.parents( '.meta-field-background' ).find( '.image-media-height' ).val( image_height );
				$el.parents( '.meta-field-background' ).find( '.image-media-width' ).val( image_width );
				$el.parents( '.meta-field-background' ).find( '.image-media-thumbnail' ).val( thumb_url );
				
				$el.removeClass( 'meta-bg-image-upload' );
				$el.addClass( 'meta-bg-image-remove' );
				$el.val( pgs.remove );
				meta_bg_preview();
			}
		);
		bg_frame.open();
	});

	jQuery( document ).on( 'change', '.meta-field-background .select-background-repeat, .meta-field-background .select-background-size, .meta-field-background .select-background-attachment, .meta-field-background .select-background-position', function() {
		meta_bg_preview();
	});

	jQuery( document ).on(
		'click',
		'.meta-bg-image-remove',
		function( event ) {
			event.preventDefault();
			var $el = $( this );

			$el.parents( '.meta-field-background' ).find( '.meta-image-holder > img' ).slideUp().remove();
			$el.parents( '.meta-field-background' ).find( '.image-field-id' ).val( '' );
			$el.parents( '.meta-field-background' ).find( '.image-media-id' ).val( '' );
			$el.parents( '.meta-field-background' ).find( '.image-media-height' ).val( '' );
			$el.parents( '.meta-field-background' ).find( '.image-media-width' ).val( '' );
			$el.parents( '.meta-field-background' ).find( '.image-media-thumbnail' ).val( '' );
			$el.parents( '.meta-field-background' ).find( '.image-field-url' ).val( '' );
			$el.addClass( 'meta-bg-image-upload' );
			$el.removeClass( 'meta-bg-image-remove' );
			$el.val( pgs.upload_image );
			meta_bg_preview();
		}
	);

	jQuery( document ).on(
		'click',
		'.meta-image-remove',
		function( event ) {
			event.preventDefault();
			var $el = $( this );

			$el.parents( '.meta-field-image' ).find( '.meta-image-holder > img' ).slideUp().remove();
			$el.parents( '.meta-field-image' ).find( '.image-field-id' ).val( '' );
			$el.parents( '.meta-field-image' ).find( '.image-media-id' ).val( '' );
			$el.parents( '.meta-field-image' ).find( '.image-media-height' ).val( '' );
			$el.parents( '.meta-field-image' ).find( '.image-media-width' ).val( '' );
			$el.parents( '.meta-field-image' ).find( '.image-media-thumbnail' ).val( '' );
			$el.addClass( 'meta-image-upload' );
			$el.removeClass( 'meta-image-remove' );
			$el.val( pgs.upload_image );
		}
	);

	jQuery( 'input.meta-single-input:checkbox' ).on( 'click', function() {
		var $this_box = jQuery(this);
		if ( $this_box.is( ':checked' ) ) {
			var thischeckbox = "input:checkbox[name='" + $this_box.attr("name") + "']";
			jQuery( thischeckbox ).prop( 'checked', false);
			$this_box.prop( 'checked', true );
		} else {
			$this_box.prop( 'checked', false );
		}
	});
	
	// Meta Field Files
	var meta_file_frame;
	jQuery( document ).on(
		'click',
		'.meta-field-file-button',
		function(e) {
			e.preventDefault();
			var $parent       = jQuery( this ).parent( '.meta-field' );
			var allowed_types = $parent.attr( 'data-metafield-file-type' );
			
			if ( allowed_types ) {
				allowed_types = allowed_types.split( ',' );
			}
	
			if ( meta_file_frame ) {
				meta_file_frame.close();
			}

			meta_file_frame = wp.media.frames.meta_file_frame = wp.media({
				multiple: false,
				library: {
					type: allowed_types
				},
			});

			meta_file_frame.on(
				'open',
				function() {
					var selection = meta_file_frame.state().get( 'selection' );
					var id        = $parent.find( '.meta-file-id' ).val();
					if ( id ) {
						var attachment = wp.media.attachment( id );
							attachment.fetch();
							selection.add( attachment ? [ attachment ] : [] );
					}
				}
			);

			meta_file_frame.on(
				'select',
				function() {
					var audioHTML = '';
					var file     = meta_file_frame.state().get( 'selection' ).first().toJSON();

					if ( file ) {
					   $parent.find( '.meta-file-id' ).val( file.id );
					   audioHTML += '<div class="meta-file-content"><div class="meta-file-info"><a class="meta-file-remove" href="#" title="' + pgs.remove + '">x</a>';
					   audioHTML += '<strong>File name:</strong><a href="' + file.url + '" target="_blank">' + file.title + '</a>';
					   audioHTML += '</div></div>';
					}

					if ( audioHTML ) {
						if ( $parent.find( '.meta-file-content' ).length > 0 ) {
							$parent.find( '.meta-file-content' ).remove();
						}
						jQuery( audioHTML ).insertAfter( $parent.find( '.meta-file-id' ) );
					}
				}
			);
			
			meta_file_frame.open();
		}
	);
	
	jQuery( document ).on( 'click', '.meta-file-remove', function(event){
		event.preventDefault();
		var $parent = jQuery( this ).parents( '.meta-file-content' ).parent( '.meta-field' );
		
		if ( jQuery( this ).parents( '.meta-file-content' ).length > 0 ) {
			jQuery( this ).parents( '.meta-file-content' ).remove();
		}

		$parent.find( '.meta-file-id' ).val( '' );
	});

	// Image Gallery
	jQuery( document ).on( 'click', '.meta-fields-gallery-image-add', function( event ) {
		event.preventDefault();

		var frame;
		var $el         = $( this );
		var this_parent = $el.parents( '.meta-fields-gallery-image-container' );

		if ( frame ) {
			 frame.close();
		}

		frame = wp.media({
			title: $el.data( pgs.choose ),
			button: {
				text: $el.data( pgs.update ),
				close: false,
			},
			multiple: true,
			library: {
				type: 'image'
			},
		});

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first();
			var selections = frame.state().get('selection');
			this_parent.find( '.meta-fields-gallery-image-list' ).empty();
			selections.map( function ( attachment ) {
				attachment = attachment.toJSON();
				var field_name = this_parent.attr( 'data-field-title' );
				var img_url;

				if ( typeof attachment.sizes.thumbnail != 'undefined' ) {
					img_url = attachment.sizes.thumbnail.url;
				} else {
					img_url = attachment.url;
				}
				this_parent.find( '.meta-fields-gallery-image-list' ).append( '<div class="meta-fields-gallery-image"><input type="hidden" name="'+ field_name +'[]" value="' + attachment.id + '"><img class="image-preview" src="' + img_url + '"><a class="meta-field-remove-image" href="#"><i title="' + pgs.remove_image + '" class="fa fa-times-circle" aria-hidden="true"></i></a><div class="image-title">' + attachment.title + '</div></div>' );
			});
			frame.close( attachment );
		});

		frame.on( 'open', function() {
			var selection = frame.state().get( 'selection' );
			var field_name = this_parent.attr( 'data-field-title' );
			jQuery( 'input[name="'+field_name+'[]"]' ).each( function() {
				var id = jQuery( this ).val();
				if ( id ) {
					var atchmnt = wp.media.attachment( id );
						atchmnt.fetch();
						selection.add( atchmnt ? [ atchmnt ] : [] );
				}
			});
		});

		frame.open();
		jQuery( '.meta-fields-gallery-image-list' ).sortable({
			items: '.meta-fields-gallery-image',
		});
	});
	
	jQuery( document ).on( 'click', 'a.meta-field-remove-image', function (e) {
		e.preventDefault();

		jQuery(this).parents( '.meta-fields-gallery-image' ).animate({opacity: 0}, 200, function () {
			jQuery(this).remove();
		});
	});

	jQuery( '.meta-fields-gallery-image-list' ).sortable({
		items: '.meta-fields-gallery-image',
	});
	
	jQuery( document ).on( 'change', '#page_template, .editor-page-attributes__template select', function () {
		page_template_metabox();
	});

	jQuery( document ).on( 'change', '[name="post_format"], .editor-post-format select', function () {
		post_formate_metabox();
	});

	jQuery( '.meta-field-select.multiple-select' ).each(function(){
        select2_dropdown( this );
    });
	
	jQuery( '.meta-field' ).on( 'change', function(){
		field_dependancy();
	});
});

jQuery( window ).load(function() {
	page_template_metabox();
	post_formate_metabox();
});

function field_dependancy(){

	jQuery( '.pgs-helper-custom-meta-fields' ).each( function() {
		var tab_id = jQuery( this ).find( '.meta-field-tab.active' ).attr( 'data-metafield-tab-id' );
		jQuery( jQuery( this ).find( '.meta-field.with-tabs' ) ).each( function() {
			var current_tab = jQuery( this ).attr( 'data-metafield-tab' );
			if ( current_tab === tab_id ) {
				jQuery( '*[data-metafield-tab="'+ tab_id +'"]').show();
			} else {
				jQuery( '*[data-metafield-tab="'+ current_tab +'"]').hide();
			}
		});
		
		jQuery( jQuery( this ).find( '.meta-field, .meta-field-tab' ) ).each(function(){
			var current_metafield         = this;
			var current_metafield_id      = jQuery( this ).attr( 'data-metafield-id' );
			var current_conditional_logic = jQuery( this ).attr( 'data-conditional-logic' );
			var current_tab = jQuery( this ).attr( 'data-metafield-tab' );
			
			if ( current_conditional_logic ) {
				var condition = [];
				var conditional_logic_arr = jQuery.parseJSON( current_conditional_logic );
				jQuery.each( conditional_logic_arr, function( key, value ){
					var field         = value.field;
					var operator      = value.operator;
					var val           = value.value;

					if ( jQuery( '*[data-metafield-id="'+ field +'"]').find( '*[name="'+ field +'"]' ).length > 0 ) {

						var field_type = jQuery( '*[data-metafield-id="'+ field +'"]').find( '*[name="'+ field +'"]' ).attr( 'type' );
						var current_value;

						if( field_type == 'radio' ){
							current_value = jQuery( '*[data-metafield-id="'+ field +'"]').find( '*[name="'+ field +'"]:checked' ).val();
						} else {
							current_value = jQuery( '*[data-metafield-id="'+ field +'"]').find( '*[name="'+ field +'"]' ).val();
						}

						if ( operator == '!=' ) {
							if ( current_value != val ) {
								condition[key] = true;
							} else {
								condition[key] = false;
							}
						} else if( operator == '==' ) {
							if ( current_value == val ) {
								condition[key] = true;
							} else {
								condition[key] = false;
							}
						}
					}
				});

				var and_all;
				if ( conditional_logic_arr.length == 1 ) {
					and_all =  condition[0];
				} else if( conditional_logic_arr.length > 1 ) {
					and_all =  condition.every( (val, i, arr) => val === arr[0] );
					if ( and_all && condition.indexOf( false ) > -1 ) {
						and_all = false;
					}
				}
				
				if ( and_all ) {
					jQuery( current_metafield ).find( '*[name="'+ current_metafield_id +'"]' ).attr( 'disabled', false );
					if ( ( current_tab === tab_id ) || jQuery( current_metafield ).hasClass( 'meta-field-tab' ) ) {
						jQuery( current_metafield ).show();
					} else if ( !current_tab || !tab_id ) {
						jQuery( current_metafield ).show();
					}
				} else {
					jQuery( current_metafield ).find( '*[name="'+ current_metafield_id +'"]' ).attr( 'disabled', true );
					if ( ( current_tab === tab_id ) || jQuery( current_metafield ).hasClass( 'meta-field-tab' ) ) {
						jQuery( current_metafield ).hide();
					} else if ( !current_tab || !tab_id ) {
						jQuery( current_metafield ).hide();
					}							
				}
			}
		});
	});
}

function select2_dropdown( $this ){
	jQuery( $this ).select2();
	
	if( jQuery( $this ).hasClass( 'sortable-select' ) ){
		var ul_sortable = jQuery( $this ).next( '.select2-container' ).first( 'ul.select2-selection__rendered' );
		ul_sortable.sortable({
			items               : 'li:not(.select2-search__field)',
			stop: function() {
				jQuery( jQuery( ul_sortable ).find('.select2-selection__choice').get().reverse() ).each(function() {
					var id = jQuery(this).data( 'data' ).id;
					var current_option = jQuery($this).find('option[value="' + id + '"]')[0];
					jQuery( $this ).prepend( current_option );
				});
			}
		});
	}
}

function input_range_field(){
	jQuery( '.input-range-field' ).each( function() {
		jQuery(this).parent( '.meta-input-field' ).find( '.input-range-value' ).val( jQuery(this).val() );
		jQuery( this ).on( 'input change', () => {
			jQuery(this).parent( '.meta-input-field' ).find( '.input-range-value' ).val( jQuery(this).val() );
		});
	});
}

function page_template_metabox(){
	var page_template;
	if ( jQuery( '#page_template' ).length > 0 ) {
		page_template = jQuery( '#page_template' ).val();
	} else if ( jQuery( '.editor-page-attributes__template select' ).length > 0 ) {
		page_template = jQuery( '.editor-page-attributes__template select' ).val();
	}

	if ( ! page_template ) {
		page_template = 'default';
	}

	jQuery( '.pgs-helper-custom-meta-fields' ).each( function() {
		var excluded,
			attr,
			included;
			
		attr = jQuery( this ).attr( 'data-field-include-template' );
		if ( typeof attr !== typeof undefined && attr !== false ) {
			included = jQuery( this ).attr( 'data-field-include-template' ).split(',');
		}
		
		attr = jQuery( this ).attr( 'data-field-exclude-template' );
		if ( typeof attr !== typeof undefined && attr !== false ) {
			excluded = jQuery( this ).attr( 'data-field-exclude-template' ).split(',');
		}

		if( excluded && included ){			
			if( '' != included ) {
				if ( included && included.indexOf( page_template ) >= 0 ) {
					jQuery( this ).parents( '.postbox' ).show();
					jQuery( this ).find( 'input' ).attr( 'disabled', false );
				} else {
					jQuery( this ).parents( '.postbox' ).hide();
					jQuery( this ).find( 'input' ).attr( 'disabled', true );
				}
			}

			if ( '' != excluded ) {
				if ( excluded.indexOf( page_template ) >= 0 ) {
					jQuery( this ).parents( '.postbox' ).hide();
					jQuery( this ).find( 'input' ).attr( 'disabled', true );
				} else {
					jQuery( this ).parents( '.postbox' ).show();
					jQuery( this ).find( 'input' ).attr( 'disabled', false );
				}
			}
		}
	});
}

function meta_fields_tab_heights(){
	jQuery( '.meta-field-position-left' ).each( function() {
		jQuery( this ).parent( '.meta-filelds-with-tabs' ).css({ minHeight: jQuery( this ).outerHeight() + "px" });
	});
}

function post_formate_metabox(){
	var post_formate;

	if ( jQuery( '#post-formats-select' ).length > 0 ) {
		post_formate = jQuery( '[name="post_format"]:checked' ).val();
	} else if ( jQuery( '.editor-post-format select' ).length > 0 ) {
		post_formate = jQuery( '.editor-post-format select' ).val();
	}
	
	jQuery( '.pgs-helper-custom-meta-fields' ).each( function() {
		var excluded,
			attr,
			included;

		attr = jQuery( this ).attr( 'data-field-include-post_formate' );
		if ( typeof attr !== typeof undefined && attr !== false ) {
			included = jQuery( this ).attr( 'data-field-include-post_formate' ).split(',');
		}
		
		attr = jQuery( this ).attr( 'data-field-exclude-post_formate' );
		if ( typeof attr !== typeof undefined && attr !== false ) {
			excluded = jQuery( this ).attr( 'data-field-exclude-post_formate' ).split(',');
		}
				
		if( excluded && included ){			
			if( '' != included ) {
				if ( included && included.indexOf( post_formate ) >= 0 ) {
					jQuery( this ).parents( '.postbox' ).show();
					jQuery( this ).find( 'input' ).attr( 'disabled', false );
				} else {
					jQuery( this ).parents( '.postbox' ).hide();
					jQuery( this ).find( 'input' ).attr( 'disabled', true );
				}
			}

			if ( '' != excluded ) {
				if ( excluded.indexOf( post_formate ) >= 0 ) {
					jQuery( this ).parents( '.postbox' ).hide();
					jQuery( this ).find( 'input' ).attr( 'disabled', true );
				} else {
					jQuery( this ).parents( '.postbox' ).show();
					jQuery( this ).find( 'input' ).attr( 'disabled', false );
				}
			}
		}
	});
}

function google_map_field(){
	setTimeout( function(){
		jQuery( '.google-map-search-field' ).each( function() {
			
			var $this            = jQuery( this );
			var $lat             = jQuery( this ).parent( '.meta-input-field' ).find( '.map-canvas' ).attr( 'data-field-lat' );
			var $lng             = jQuery( this ).parent( '.meta-input-field' ).find( '.map-canvas' ).attr( 'data-field-lng' );
			var $zoom            = jQuery( this ).parent( '.meta-input-field' ).find( '.map-canvas' ).attr( 'data-field-zoom' );
			var myLatLng         = '';
			var zoom             = '';
			
			if ( $lat && $lng ) {
				myLatLng = { lat: parseInt( $lat ), lng: parseInt( $lng ) };	
			}

			if ( $zoom ) {
				zoom = parseInt( $zoom );
			}

			var map = new google.maps.Map( jQuery( this ).parent( '.meta-input-field' ).find( '.map-canvas' )[0], {
				center: myLatLng,
				zoom: zoom
			});

			new google.maps.Marker({
				position: myLatLng,
				map: map,
			});

			var autocomplete = new google.maps.places.Autocomplete( jQuery( '#' + jQuery( this ).attr( 'id' ) )[0] );

			map.addListener( 'bounds_changed', function() {
				autocomplete.setBounds( map.getBounds() );
			});

			autocomplete.addListener( 'place_changed', function(){
				var place = autocomplete.getPlace();
				if ( place.length === 0 ) {
					return;
				}
		
				var bounds = new google.maps.LatLngBounds();
				
				if ( ! place.geometry ) {
					return;
				}

				new google.maps.Marker({
					map: map,
					title: place.name,
					position: {lat: place.geometry.location.lat(), lng: place.geometry.location.lng() },
				});

				if ( place.geometry.viewport ) {
					bounds.union( place.geometry.viewport );
				} else {
					bounds.extend( place.geometry.location );
				}
				
				var location_data = {
						address: place.formatted_address,
						lat: place.geometry.location.lat(),
						lng: place.geometry.location.lng(),
					};

					if( place.place_id ) {
						location_data.place_id = place.place_id;
					}
					
					var map_data = {
						street_number: [ 'street_number' ],
						street_name: [ 'street_address', 'route' ],
						city: [ 'locality' ],
						state: [
							'administrative_area_level_1',
							'administrative_area_level_2',
							'administrative_area_level_3',
							'administrative_area_level_4',
							'administrative_area_level_5'
						],
						post_code: [ 'postal_code' ],
						country: [ 'country' ]
					};
					
					for( var k in map_data ) {
						var keywords = map_data[ k ];										
						if ( place.address_components !== undefined ) {
							for( var i = 0; i < place.address_components.length; i++ ) {
								var add_component = place.address_components[ i ];
								var component_type = add_component.types[0];
								if( keywords.indexOf(component_type) !== -1 ) {
									location_data[ k ] = add_component.long_name;
									if( add_component.long_name !== add_component.short_name ) {
										location_data[ k + '_short' ] = add_component.short_name;
									}
								}
							}
						}
					}

					jQuery( $this ).parents( '.meta-input-field' ).find( '.google-map-field-data' ).val( JSON.stringify( location_data ) );

				map.fitBounds(bounds);
			});
		});
	}, 3000 );
}

/****************************
	:: Icon Picker
****************************/

function meta_iconpicker() {
	if ( jQuery( '.meta-field-iconpicker' ).length > 0 ) {
		jQuery( '.meta-field-iconpicker' ).each( function() {
			if ( jQuery( this ).find( '.meta-input-field' ).attr( 'data-icons' ) ) {

				var field_icons              = jQuery.parseJSON( jQuery( this ).find( '.meta-input-field' ).attr( 'data-icons' ) );
				var icons_per_page           = jQuery.parseJSON( jQuery( this ).find( '.meta-input-field' ).attr( 'data-icons_per_page' ) );
				var icon_field               = jQuery( this ).find( '.pgs-meta-iconpicker' );
				var fontawesome_icons        = [];
				var fontawesome_icons_search = [];

				jQuery.each( field_icons, function( icons_key, icons_val ) {
					fontawesome_icons.push( icons_key );
					fontawesome_icons_search.push( icons_val );
				});

				var icon_attr = { source: fontawesome_icons, searchSource: fontawesome_icons_search };
				
				if ( icons_per_page ) {
					icon_attr.iconsPerPage = icons_per_page;
				}

				jQuery( icon_field ).fontIconPicker( icon_attr );
			}	
		});
	}
}

/************************************
	:: Post Object Select field
************************************/

function meta_field_post_object_select() {
	if ( jQuery( '.meta-field-post-object-select' ).length > 0 ) {
		jQuery( '.meta-field-post-object-select' ).each( function() {
			var post_type = jQuery( this ).parents( '.meta-input-field' ).attr( 'data-post-type' );
			var per_page  = jQuery( this ).parents( '.meta-input-field' ).attr( 'data-per-page' );
			
			jQuery( this ).select2({
				ajax: {
					url: pgs.ajaxurl,
					dataType: 'json',
						data: function (params) {
						var query = {
							post_type: post_type,
							per_page: per_page,
							meta_post_object_nonce : pgs.meta_post_object_nonce,
							action: 'post_object_ajax_results',
							search: params.term,
							page: params.page || 1
						};
						return query;
					},
				}
			});
		});
	}
}

/*****************************
	:: Meta Bg preview
******************************/

function meta_bg_preview() {
	if ( jQuery( '.meta-field-background' ).length > 0 ) {
		jQuery( '.meta-field-background' ).each( function() {
			var background_repeat     = jQuery( this ).find( '.select-background-repeat' ).val();
			var background_size       = jQuery( this ).find( '.select-background-size' ).val();
			var background_attachment = jQuery( this ).find( '.select-background-attachment' ).val();
			var background_position   = jQuery( this ).find( '.select-background-position' ).val();
			var preview_height        = jQuery( this ).find( '.meta-background-preview-live' ).attr( 'data-preview-height' );
			var background_image      = jQuery( this ).find( '.image-field-url' ).val();
			var preview_css           = '';

			if ( background_repeat ) {
				preview_css += 'background-repeat:' + background_repeat + ';';
			}

			if ( background_attachment ) {
				preview_css += 'background-attachment:' + background_attachment + ';';
			}
			
			if ( background_size ) {
				preview_css += 'background-size:' + background_size + ';';
			}
			
			if ( background_position ) {
				preview_css += 'background-position:' + background_position + ';';
			}

			if ( background_image ) {
				preview_css += 'background-image:url(' + background_image + ');';
				if ( preview_height ) {
					preview_css += 'height: ' + preview_height + 'px;';
				} else {
					preview_css += 'height: 200px;';
				}
			}

			if ( preview_css ) {
				jQuery( this ).find( '.meta-background-preview-live' ).attr( 'style', preview_css );
			} else {
				jQuery( this ).find( '.meta-background-preview-live' ).attr( 'style', '' );
			}
		});
	}
}

/*****************************
	:: Hide Oembed cancel Icon
******************************/

function hide_oembed_cancel(){
	jQuery( '.meta-input-oembed' ).each( function() {
		if ( ! jQuery( this ).find( '.meta-oembed-input-field' ).val() ) {
			jQuery( this ).find( '.meta-input-actions' ).hide();
		}
	});
}