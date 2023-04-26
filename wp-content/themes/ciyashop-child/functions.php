<?php
remove_filter( 'the_title', 'wpautop' );
/**
 * Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package CiyaShop
 */

/**
 * If your child theme has more than one .css file (eg. ie.css, style.css, main.css) then
 * you will have to make sure to maintain all of the parent theme dependencies.
 *
 * Make sure you're using the correct handle for loading the parent theme's styles.
 * Failure to use the proper tag will result in a CSS file needlessly being loaded twice.
 * This will usually not affect the site appearance, but it's inefficient and extends your page's loading time.
 *
 * @link https://codex.wordpress.org/Child_Themes
 */
function ciyashop_child_enqueue_styles() { // phpcs:ignore WordPress.WhiteSpace.ControlStructureSpacing.NoSpaceAfterOpenParenthesis

	wp_enqueue_style( 'ciyashop-style', get_parent_theme_file_uri( '/css/style.css' ), array(), '3.5.2' );

	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl-style', get_parent_theme_file_uri( '/rtl.css' ), array(), '3.5.2' );
	}

	wp_enqueue_style ( 'ciyashop-child-child-style',get_stylesheet_directory_uri() . '/style.css', array( 'ciyashop-style' ), wp_get_theme()->get( 'Version' ));
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/custom.js',array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'ciyashop_child_enqueue_styles', 11 );

function myFilter($var){
    return ($var !== NULL && $var !== FALSE && $var !== "");
}
 

add_action( 'woocommerce_before_main_content', 'mycategorycheck' );
function mycategorycheck()
{
  global $wpdb;
  
   if(is_product_category())
   {

		    $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
		    $single_cat = array_shift( $product_cats ); 
		    $currentcatid=$single_cat->term_id;
			   
		  
		  $cid=get_current_user_id(); 
		  $mydicroles=$wpdb->get_results("select * from documentuser where userid='".$cid."'");
		  $brandarr='';$catarr='';$prodarr=''; $brand='';$cat='';$prod='';
		   
		  foreach($mydicroles as $rolval)
		  {
		 
		  	 $brand.=$rolval->brandid.",";
		  	$cat.=$rolval->catid.",";
		  	$prod.=$rolval->productid.",";
		  }
		  
		  $brandarr=explode(",",$brand);$catarr=explode(",",$cat);$prodarr=explode(",",$prod);

		  $brandarr=array_filter($brandarr,'myFilter');
		  $catarr=array_filter($catarr,'myFilter');
		  $prodarr=array_filter($prodarr,'myFilter');
		  echo $currentcatid;
		  print_r($catarr); 
		  if (in_array($currentcatid, $catarr))
  		  {
  		  	
  		  }
  		  else{
  		  	//header("Location:".home_url());
  		  }
		  
		   
   }
  
}

function checksingleproduct()
{
global $wpdb;
    global $product;
    $id = $product->get_id();
    $cid=get_current_user_id(); 
    
    $special='no';
     $special = get_post_meta( $product->id, 'special_product', true );
     if(empty($special))$special='no';
     $special=strtolower($special);
         if ( is_user_logged_in() ) 
         {
         
    
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
  		        if($special=='yes') 	 header("Location:".home_url());
  		  }
  		  
  	 }else{
         	 if($special=='yes')
         	 {
   			 header("Location:".home_url());
   		 }
   	  }
}
add_action( 'woocommerce_before_single_product', 'checksingleproduct' );

//disable zxcvbn.min.js in wordpress
// add_action('wp_print_scripts', 'remove_password_strength_meter');
// function remove_password_strength_meter() {
//     // Deregister script about password strenght meter
//     wp_dequeue_script('zxcvbn-async');
//     wp_deregister_script('zxcvbn-async');
// }



/***************************** widgets *********************************** */

function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'example_theme_support' );



/***************************** demo menu *********************************** */

function wpb_custom_new_menu() {
	register_nav_menu('Max-Mega-Menu',__( 'Max Mega Menu '));
  }
  add_action( 'init', 'wpb_custom_new_menu' );


/******************** Custom widgets For Product  ********************/

add_action( 'widgets_init', 'blankslate_fragrances_widgets_init' );
function blankslate_fragrances_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'fragrances', 'blankslate' ),
		'id' => 'fragrances',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
	) );
}  


/******************** menuproduct ********************/

function featured_product($category_id=0,$item=1){
	$merged = array_merge($category_id);
	$merged_values = array_values($merged);
	// print_r($merged);
	$cat_id =  $merged_values[0];
	$column =  $merged_values[1];
	
	//echo "<h2>".$column."</h2>";
	//echo "<h2>".$cat_id."</h2>";

	$query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $column,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy'   => 'product_cat',
				'field'      => 'term_id',
				'terms'      => $cat_id,
			),
			array(
			'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
			'operator' => 'IN',
			'order'    => 'DESC',
			),
		),
	) );

	if( $query->have_posts() ){

		$string .= '<ol>'; 
			while ( $query->have_posts() ) : $query->the_post();
				$string .=  '<li>
					<a href="'. get_permalink() .'">
					<div class="product__preview"><img src="' . get_the_post_thumbnail_url() . '"></div>
					<span>' . get_the_title() . '</span>
					</a>
				</li>';
			endwhile;
		$string .= '</ol>'; 
	
	}else{
		
		// $string .= '<div>';
		// $string .= 'No product found';
		// $string .= '</div>';
		//echo __( '<div class="page-not-found">No products found sdsds</div>' );
		echo __( '<div class="product-widget-custom">' );
		dynamic_sidebar( 'product-dropdown-image' ); 
		echo __( '</div>' );
	}


	wp_reset_postdata();
	
	return $string;
}	
add_shortcode( 'menuproduct', 'featured_product' );

// [menuproduct category_id="2273" item="5"]




/******************** brandmenuproduct ********************/

function brand_featured_product($brand_id=0,$item=1){
	$merged = array_merge($brand_id);
	$merged_values = array_values($merged);
	// print_r($merged);
	$brand_id =  $merged_values[0];
	$column =  $merged_values[1];
	
	//echo "<h2>".$column."</h2>";
	//echo "<h2>".$cat_id."</h2>";

	$query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $column,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy'   => 'yith_product_brand',
				'field'      => 'term_id',
				'terms'      => $brand_id,
			),
			array(
			'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
			'operator' => 'IN',
			'order'    => 'DESC',
			),
		),
	) );

	if( $query->have_posts() ){

		$string .= '<ol>'; 
			while ( $query->have_posts() ) : $query->the_post();
				$string .=  '<li>
					<a href="'. get_permalink() .'">
					<div class="product__preview"><img src="' . get_the_post_thumbnail_url() . '"></div>
					<span>' . get_the_title() . '</span>
					</a>
				</li>';
			endwhile;
		$string .= '</ol>'; 
	
	}else{
		
		// $string .= '<div>';
		// $string .= 'No product found';
		// $string .= '</div>';
		//echo __( '<div class="page-not-found">No products found sdsds</div>' );
		echo __( '<div class="product-widget-custom">' );
		dynamic_sidebar( 'product-dropdown-image' ); 
		echo __( '</div>' );
	}


	wp_reset_postdata();
	
	return $string;
}	
add_shortcode( 'brandmenuproduct', 'brand_featured_product' );