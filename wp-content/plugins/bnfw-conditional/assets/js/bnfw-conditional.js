jQuery( document ).ready( function ( $ ) {
	var $notification = $( '#notification' ),
		$conditionalSelects = $( '#bnfw-conditional-selects' ),
		$taxonomy = $( '#bnfw-taxonomies' ),
		$terms = $( '#bnfw-terms' );

	if ( !$notification.length ) {
		return;
	}

	/**
	 * Show/Hide Selects based on notification selected.
	 */
	function handleSelects() {
		var notification = $notification.val();

		if ( 'user-role' === notification || 'admin-role' === notification ) {
			$( '#bnfw-user-role-selects' ).show();
		} else {
			$( '#bnfw-user-role-selects' ).hide();
		}

		if ( 'welcome-email' === notification || 'new-user' === notification ) {
			$( '#bnfw-user-role-select' ).show();
		} else {
			$( '#bnfw-user-role-select' ).hide();
		}

		$.ajax( {
			url: ajaxurl,
			data: {
				'action': 'bnfw_get_notification_post_type',
				'notification': notification
			}
		} )
			.done(
				function ( postType ) {
					if ( '' != postType ) {
						$conditionalSelects.show();
						loadTaxonomy( postType );
						$terms.select2();
					} else {
						$conditionalSelects.hide();
					}
				}
			);
	}

	/**
	 * Load Taxonomy.
	 *
	 * @param postType
	 */
	function loadTaxonomy( postType ) {
		$taxonomy.select2( {
			allowClear: true,
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				data: function ( params ) {
					return {
						action: 'bnfw_get_taxonomies',
						post_type: postType
					};
				},
				processResults: function ( data ) {
					return {
						results: data
					};
				}
			}
		} );
	}

	/**
	 * Load Terms.
	 *
	 * @param taxonomy
	 */
	function loadTerms( taxonomy ) {
		$terms.select2( {
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				data: function ( params ) {
					return {
						action: 'bnfw_get_terms',
						taxonomy: taxonomy
					};
				},
				processResults: function ( data ) {
					return {
						results: data
					};
				}
			}
		} );
	}

	handleSelects();
	$notification.on( 'change', handleSelects );
	$taxonomy.on( 'change', function () {
		var taxonomy = $taxonomy.val();
		loadTerms( taxonomy );
	} );
} );