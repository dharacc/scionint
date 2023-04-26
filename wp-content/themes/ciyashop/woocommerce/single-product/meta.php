<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper">
			<label><?php esc_html_e( 'SKU:', 'ciyashop' ); ?></label> 
			<span class="sku">
				<?php
				$sku = $product->get_sku();
				if ( $sku ) {
					echo esc_html( $sku );
				} else {
					echo esc_html__( 'N/A', 'ciyashop' );
				}
				?>
			</span>
		</span>

	<?php endif; ?>

	<?php
	$brandterms = get_the_terms($post->ID, 'yith_product_brand');
	$brand_display='';$sl='';
			if(!empty($brandterms))
			{
			
			foreach($brandterms as $termv) 
				{
 $sl= $termv->slug;
  						$taxname= $termv->name; break;

					}

				if(!empty($taxname))
				{
				   $brand_display  = '<div><b><span style="color:#000;">Brand: </span></b> <a href="'.site_url().'/product-brands/'.$sl.'/">' . $taxname . '</a></div> ';
				}
			}
			
	// Get post category info.
			$category = get_the_category();
			 
				$category = get_the_terms( get_the_ID(), 'product_cat' );
	 
			 
			$cat_display     = '';
				$mcat_display     = ' <B><span style="color:#000;">Category: </span></b> ';
				$mcat_display1     = ' <Br><B><span style="color:#000;">Sub Category: </span></b> ';
			if ( ! empty( $category ) ) {
				// Get last category post is in.
				$values_of_category = array_values( $category );
				$last_category      = end( $values_of_category );
				// Get parent any categories and create array.
				$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
				$cat_parents     = explode( ',', $get_cat_parents );
				
				 
					$cats_id = array_column( get_the_terms( get_the_ID(), 'product_cat' ), 'term_id' );
					// Show only onw category.
					$cats_id = reset( $cats_id );
					if ( ! empty( $cats_id ) ) {
						$get_cat_parents = ( ! empty( $cats_id ) ) ? get_ancestors( $cats_id, 'product_cat' ) : '';
						$cat_link        = get_term_link( $cats_id );
						$last_cat        = get_term_by( 'id', $cats_id, 'product_cat' );
						$mcat_display1     .= ' <a href="'.$cat_link.'">'.$last_cat->name.'</a> ';
						if ( ! empty( $get_cat_parents ) ) {
							// Show only one category.
							$get_cat_parents  = get_term_by( 'id', $get_cat_parents[0], 'product_cat' );
							$parents_cat_link = get_term_link( $get_cat_parents->term_id, 'product_cat' );
							$mcat_display     .= '  <a href="' . $parents_cat_link . '">' . $get_cat_parents->name . '</a>   ';
						}
						 
						
						 
					}
			 

				// Loop through parent categories and store in variable $cat_display.
				if ( ! empty( $cat_parents ) && is_array( $cat_parents ) ) {
					foreach ( $cat_parents as $parents ) {
						$cat_display .= ( empty( $parents ) ) ? '' : '<div><B><span style="color:#000;">Category: </span></b>' . $parents .'</div>' ;
					}
				}
			}
			echo $brand_display  ;
			echo $cat_display ;
			echo $mcat_display ;
			echo $mcat_display1;
			$gender=get_post_meta( get_the_ID(), 'scion_gender', true );
				$size=get_post_meta( get_the_ID(), 'scion_size', true );
				$variant=get_post_meta( get_the_ID(), 'scion_variant', true );
				if(!empty($gender))
				{
					echo '<div><B><span style="color:#000;">Gender: </span></b>' . $gender .'</div>' ;
				}
				if(!empty($size))
				{       echo '<div><B><span style="color:#000;">Size: </span></b>' . $size .'</div>' ;
					 
				}
				if(!empty($variant))
				{    echo '<div><B><span style="color:#000;">Variant: </span></b>' . $variant.'</div>' ;
					 
				}
				
	 //echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in"><label>' . _n( 'Category', 'Categories', count( $product->get_category_ids() ), 'ciyashop' ) . ':</label> ', '</span>' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as"><label>' . _n( 'Tag', 'Tags', count( $product->get_tag_ids() ), 'ciyashop' ) . ':</label> ', '</span>' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
<style>
.yith-wcbr-brands{display:none !important;}</style>
