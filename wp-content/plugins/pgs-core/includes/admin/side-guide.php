<?php

add_action( 'add_meta_boxes', 'ciyashop_sguide_add_metaboxes', 10 );
add_action( 'save_post_size_guides', 'ciyashop_sguide_table_save', 10 );
add_action( 'edit_post_size_guides', 'ciyashop_sguide_table_save', 10 );

if ( ! function_exists( 'ciyashop_sguide_add_metaboxes' ) ) {
	function ciyashop_sguide_add_metaboxes() {
		// Add table metaboxes to size guide
		add_meta_box( 'size_guides_metaboxes', esc_html__( 'Create/modify size guide table', 'pgs-core' ), 'size_guides_metaboxes', 'size_guides', 'normal', 'default' );

	}
}

if ( ! function_exists( 'size_guides_metaboxes' ) ) {
	function size_guides_metaboxes( $post ) {

		if ( get_current_screen()->action == 'add' ) {
			$tables = array(
				array( 'Size', 'US', 'UK', 'EU' ),
				array( 'XS', '14', '14', '36' ),
				array( 'S', '15', '15', '38' ),
				array( 'M', '16', '16', '40' ),
				array( 'L', '17', '17', '42' ),
				array( 'XL', '18', '18', '44' ),
				array( 'XXL', '19', '19', '46' ),
			);
		} else {
			$tables = get_post_meta( $post->ID, 'ciyashop_sguide' );
			$tables = $tables[0];
		}

		ciyashop_sguide_table_template( $tables );
	}
}

if ( ! function_exists( 'ciyashop_sguide_table_template' ) ) {
	function ciyashop_sguide_table_template( $tables ) {
		?>
		<textarea class="ciyashop-sguide-table-edit" name="ciyashop-sguide-table" style="display:none;">
			<?php echo json_encode( $tables ); ?>
		</textarea>
		<?php

	}
}

//Save table action
if ( ! function_exists( 'ciyashop_sguide_table_save' ) ) {
	function ciyashop_sguide_table_save( $post_id ) {
		if ( ! isset( $_POST['ciyashop-sguide-table'] ) ) {
			return;
		}

		$size_guide = json_decode( stripslashes( $_POST['ciyashop-sguide-table'] ) );
		update_post_meta( $post_id, 'ciyashop_sguide', $size_guide );
	}
}
