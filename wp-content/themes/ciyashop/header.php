<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CiyaShop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php wp_head(); ?>
<?php if(!is_home() && !is_page( 'india' )  && !is_page( 'uae' )  && !is_page( 'usa' ) ){ ?><Style>.woocommerce-page .header-style-menu-center.header-above-content, .woocommerce-page .header-style-menu-right.header-above-content {
    background: #fff;
    position: relative;
}
	   
	.site-header .primary-nav .primary-menu > li > .sub-menu {
background:#e9f3f3 !important

}
.main-navigation-sticky .primary-menu > li .sub-menu
{ background:#e9f3f3 !important
}
.topbar-link li a {color:#222 !important;}
.inner-intro ul.page-breadcrumb li a {
 color:#222 !important;}
 .inner-intro ul.page-breadcrumb li.home::before {
    content: "\f015";
    font-weight: 900;
    line-height: 19px;
    color: #222;
}
.header-style-menu-center.header-above-content .topbar,.header-style-menu-center.header-above-content .header-main,.header_intro_bg-color{ background: #fff !important;}
.inner-intro ul.page-breadcrumb li::before{ color: #222;}
.inner-intro ul.page-breadcrumb li {
    line-height: 22px;
    color: #222;
    list-style: none;
}
.primary-nav-wrapper  li a {color:#222  !important;}
.site-header .pgs_megamenu-enable > li.menu-item-with-block.pgs-menu-item-color-scheme-dark > .pgs-menu-html-block, .site-header .pgs_megamenu-enable > li.pgs-menu-item-color-scheme-dark .sub-menu, .site-header .pgs_megamenu-enable > li.pgs-menu-item-color-scheme-dark.menu-item-with-block.pgs-mega-menu-full-width > .pgs-menu-html-block, .site-header .pgs_megamenu-enable > li.pgs-menu-item-color-scheme-dark.pgs-menu-item-mega-menu.pgs-mega-menu-full-width > .pgs_menu_nav-sublist-dropdown{background:#e9f3f3  !important;}
.header-style-menu-center.header-above-content .topbar, .header-style-menu-right.header-above-content .topbar {
    border-bottom: 1px solid #f2f2f2;
 
}
.site-header .search-button-wrap .search-button i {
    font-size: 20px;
    top: -1px; color:#222 !important;
    position: relative;
}
.site-header .pgs_megamenu-enable>li.pgs-menu-item-color-scheme-dark .sub-menu>li a{ color:#222 !important;}
#masthead{ border-bottom: 1px solid #f2f2f2;}
.intro-title-inner h1{color:#222;}
.header-style-menu-center.header-above-content .topbar-bg-color-default .topbar-link > ul > li i{color:#222 !important;}
.woo-tools-actions > li .glyph-icon {
   color:#000 !important;
}
.site-header .pgs_megamenu-enable>li.pgs-menu-item-mega-menu.pgs-menu-item-color-scheme-dark>.pgs_menu_nav-sublist-dropdown .container>.sub-menu>li>a{color:#222 !important;}
<?php 
$brandpagev=$_SERVER['REQUEST_URI'];
	
if(!empty($brandpagev)){ $brarr=explode("/",$brandpagev); 
   if($brarr[1]=='product-brands'){
   		?>
   		#content .container{max-width:100% !important;}
   		<?php 
   }
						if($brarr[1]=='jobs'){
							?>
   		.post-navigation{display:none !important;}
   		<?php
							
						}
}?>
</style>
<?php }
else{
?>
<style>
	.site-header .pgs_megamenu-enable > li.pgs-menu-item-color-scheme-dark.pgs-menu-item-mega-menu.pgs-mega-menu-full-width > .pgs_menu_nav-sublist-dropdown {
    background-color: #e9f3f3; 
}
	.site-header .pgs_megamenu-enable > li.pgs-menu-item-mega-menu.pgs-menu-item-color-scheme-dark > .pgs_menu_nav-sublist-dropdown .container > .sub-menu > li > a{color:#222;}
	.site-header .pgs_megamenu-enable > li.pgs-menu-item-color-scheme-dark .sub-menu > li a{color:#222;}
	.main-navigation-sticky .primary-menu > li .sub-menu {background-color: #e9f3f3; 
}
	.site-header .primary-nav .primary-menu > li > .sub-menu {background-color: #e9f3f3; 
}
	.primary-nav .primary-menu > li .sub-menu > li a{
    color: #222 !important;
}
	</style>
	<?php }
	
	//if(is_page(13907)){?>
	<Style>
		<?php if(is_page()){?>
  	.header-style-menu-center.header-above-content + .site-content .inner-intro, .header-style-menu-right.header-above-content + .site-content .inner-intro {
    padding-top: 100px;
    margin-top:  140px;
}
		<?php }?>
		.bottomcircle_sus{justify-content: center;}
		.sust-circle {margin-left:12px;}
	@media only screen and (max-width: 600px) {
  	.header-style-menu-center.header-above-content + .site-content .inner-intro, .header-style-menu-right.header-above-content + .site-content .inner-intro {
    padding-top: 100px;
    margin-top:  0px;
}.sust-circle {margin-left:0px;}
}
		<?php if(!is_shop()){ ?>
		#vc_row_1615229762801-c7dd2a1e-ee5f .woof_show_auto_form, .woof_hide_auto_form{display:none !important;}
		<?php }?>
		
	</Style>
	<?php //}?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-101918052-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-101918052-1');
</script>	
</head>

<body <?php body_class(); ?>>

<?php

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}

/**
 * Fires before page wrapper.
 *
 * @visible true
 */
do_action( 'ciyashop_before_page_wrapper' );
?>

<div id="page" class="<?php ciyashop_page_classes(); ?>">

	<?php
	/**
	 * Fires before header wrapper.
	 *
	 * @Functions hooked in to ciyashop_before_header_wrapper hook.
	 * @hooked ciyashop_preloader - 10
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_before_header_wrapper' );
	?>

	<!--header -->
	<header id="masthead" class="<?php ciyashop_header_classes(); ?>">
		<div id="masthead-inner">

			<?php
			/**
			 * Fires before header.
			 *
			 * @visible true
			 */
			do_action( 'ciyashop_before_header' );
			?>

			<?php get_template_part( 'template-parts/header/header_type/' . ciyashop_header_type() ); ?>

			<?php
			/**
			 * Fires after header.
			 *
			 * @visible true
			 */
			do_action( 'ciyashop_after_header' );
			?>

		</div><!-- #masthead-inner -->
	</header><!-- #masthead -->

	<?php
	/**
	 * Fires after header wrapper.
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_after_header_wrapper' );
	?>

	<?php
	/**
	 * Fires before site content.
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">

		<?php
		/**
		 * Hook: ciyashop_content_top.
		 *
		 * @Functions hooked in to ciyashop_content_top hook.
		 * @hooked ciyashop_page_header - 20
		 * @hooked ciyashop_shop_category_carousel - 30
		 *
		 * @visible true
		 */
		do_action( 'ciyashop_content_top' );
		?>

		<div class="<?php ciyashop_content_wrapper_classes( 'content-wrapper' ); ?>"><!-- .content-wrapper -->
		<div class="<?php ciyashop_content_container_classes( 'container' ); ?>"><!-- .container --> 
