<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
 

 $special='no';
    $special = get_post_meta( $product->id, 'special_product', true );
     if(empty($special))$special='no';
     $special=strtolower($special);
        
	  
	     if ( is_user_logged_in() ) 
         {
			 global $wpdb;
          $cid=get_current_user_id(); 
    
		  $mydicroles=$wpdb->get_results("select * from documentuser where userid='".$cid."'");
		  $brandarr='';$catarr='';$prodarr=''; $brand='';$cat='';$prod='';
		   
		  foreach($mydicroles as $rolval)
		  {
		 
		  	 
		  	$prod.=$rolval->productid.",";
		  }
		  
		 $prodarr=explode(",",$prod);

		 
		  $prodarr=array_filter($prodarr,'myFilter');
		 
		  if (in_array($id, $prodarr))
  		  {
  		  	
  		  }
  		  else{
			  
  		       if($special=='yes')
         	 {
   			     return;
			}
  		  }
  		  
  	 }else{
		 
         	 if($special=='yes')
         	 {
   			     return;
			}
   	  }
   	  
?>
<li <?php wc_product_class( '', $product );

 ?>> 
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
