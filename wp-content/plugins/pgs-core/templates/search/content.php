<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}

global $pgscore_shortcodes, $ciyashop_globals, $header_el_search_form_index;
extract( $pgscore_shortcodes['pgscore_search'] );
extract( $atts );

if ( empty( $header_el_search_form_index ) ) {
	$header_el_search_form_index = 0;
}

$search_form_id       = 'header-el-search-' . $header_el_search_form_index++;
$search_form_classes  = 'search_form-inner';
$search_form_classes .= ' search-shape-' . $search_box_shape;
$search_form_classes .= ' search-bg-' . $search_box_background;

?>
<div class="<?php echo esc_attr( $search_form_classes ); ?>">
	<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">	
		<?php
		if ( ( 'post' === $search_content_type || 'product' === $search_content_type ) && ( $show_categories ) ) {
			$taxonomy = ( 'product' === $search_content_type ) ? 'product_cat' : 'category';
			?>
			<div class="search_form-category-wrap">
				<?php
				$search_category = '';
				if ( isset( $_GET['search_category'] ) && $_GET['search_category'] != '' ) {
					$search_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
				}

				$args = array(
					'type'         => 'post',
					'child_of'     => 0,
					'parent'       => '',
					'orderby'      => 'id',
					'order'        => 'ASC',
					'hide_empty'   => false,
					'hierarchical' => 1,
					'exclude'      => '',
					'include'      => '',
					'number'       => '',
					'taxonomy'     => $taxonomy,
					'pad_counts'   => false,
				);

				$product_categories = get_categories( $args );

				if ( count( $product_categories ) > 0 ) {
					?>
					<select name="search_category" class="search_form-category">
						<option value="" selected><?php esc_html_e( 'All Categories', 'pgs-core' ); ?></option>
						<?php
						foreach ( $product_categories as $cat ) {
							?>
							<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php echo selected( esc_attr( $cat->term_id ), $search_category ); ?>>
								<?php echo esc_html( $cat->name ); ?>
							</option>
							<?php
						}
						?>
					</select>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
		<div class="search_form-input-wrap">
			<?php
			if ( 'all' !== $search_content_type ) {
				?>
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_content_type ); ?>"/>
				<?php
			}
			?>
			<label class="screen-reader-text" for="<?php echo esc_attr( $search_form_id ); ?>">
				<?php esc_html_e( 'Search for:', 'pgs-core' ); ?>
			</label>
			<div class="search_form-search-field">
				<input type="text" id="<?php echo esc_attr( $search_form_id ); ?>" class="form-control search-form" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="<?php echo esc_attr( $search_placeholder_text ); ?>" />
			</div>
			<div class="search_form-search-button">
				<input value="" type="submit">
			</div>				
		</div>			
		<div class="ciyashop-auto-compalte-default ciyashop-empty">
			<ul class="ui-front ui-menu ui-widget ui-widget-content search_form-autocomplete"></ul>
		</div>
	</form>		
</div>
