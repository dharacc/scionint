<?php
add_action( 'add_meta_boxes', 'ciyashop_smartproduct_metabox' );
if ( ! function_exists( 'ciyashop_smartproduct_metabox' ) ) {
	function ciyashop_smartproduct_metabox() {
		global $ciyashop_options;

		if ( ! isset( $ciyashop_options['smart-product'] ) || ( isset( $ciyashop_options['smart-product'] ) && ! $ciyashop_options['smart-product'] ) ) {
			return false;
		}

		add_meta_box( 'smart-product-metabox', __( 'Smart Product View', 'pgs-core' ), 'smart_product_meta_callback', 'product', 'normal', 'high' );
	}
}

if ( ! function_exists( 'smart_product_meta_callback' ) ) {
	function smart_product_meta_callback( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'smart_product_meta_nonce' );
		$ciyashop_smart_product = get_post_meta( $post->ID, 'ciyashop_smart_product_id', true );
		?>
		<table class="form-table">
			<tr>
				<td>
					<div id="smart-product-metabox">
						<a class="smart-product-add button" href="#" data-uploader-title="<?php echo esc_attr__( 'Add images', 'pgs-core' ); ?>" data-uploader-button-text="<?php echo esc_attr__( 'Add images', 'pgs-core' ); ?>">
							<?php echo esc_html__( 'Add images', 'pgs-core' ); ?>
						</a>
						<ul id="smart-product-metabox-list">
							<?php
							if ( $ciyashop_smart_product ) :
								foreach ( $ciyashop_smart_product as $key => $ciyashop_smart_product_id ) :
									$image = wp_get_attachment_image_src( $ciyashop_smart_product_id );
									?>
									<li>
										<input type="hidden" name="ciyashop_smart_product_id[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $ciyashop_smart_product_id ); ?>">
										<img class="image-preview" src="<?php echo esc_url( $image[0] ); ?>">
										<small>
											<a class="remove-image button" href="#">
												<i title="<?php echo esc_attr__( 'Remove Image', 'pgs-core' ); ?>" class="fa fa-times-circle" aria-hidden="true"></i>
											</a>
										</small>
										<div class="product_title">
											<?php echo get_the_title( $ciyashop_smart_product_id ); ?>
										</div>
										<a class="change-image button button-small" href="#" data-uploader-title="<?php echo esc_attr__( 'Change image', 'pgs-core' ); ?>" data-uploader-button-text="<?php echo esc_attr__( 'Change image', 'pgs-core' ); ?>">
											<i title="<?php echo esc_attr__( 'Change image', 'pgs-core' ); ?>" class="fa fa-exchange" aria-hidden="true"></i>
										</a>
										</br>
									</li>
									<?php
								endforeach;
							endif;
							?>
						</ul>
					</div>
				</td>
			</tr>
		</table>
		<?php
	}
}

add_action( 'save_post', 'smart_product_meta_save' );
if ( ! function_exists( 'smart_product_meta_save' ) ) {
	function smart_product_meta_save( $post_id ) {
		if ( ! isset( $_POST['smart_product_meta_nonce'] ) || ! wp_verify_nonce( $_POST['smart_product_meta_nonce'], basename( __FILE__ ) ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( isset( $_POST['ciyashop_smart_product_id'] ) ) {
			update_post_meta( $post_id, 'ciyashop_smart_product_id', $_POST['ciyashop_smart_product_id'] );
		}
	}
}
