<?php
/**
 * Sample data
 *
 * @package CiyaShop
 */

add_filter( 'pgscore_theme_sample_datas', 'ciyashop_sample_data_items' );
/**
 * Sample data items
 *
 * @param array $sample_data .
 */
function ciyashop_sample_data_items( $sample_data = array() ) {
	$sample_data_new = array(
		'default'         => array(
			'id'          => 'default',
			'name'        => 'Default',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'shortcode_v_menu' => 'Category Menu',
				'top_menu'         => 'Top Bar Menu',
				'footer_menu'      => 'Footer Menu',
			),
			'revsliders'  => array(
				'banner-video.zip',
				'ciyashop-2.zip',
				'ciyashop-4.zip',
				'ciya-shop-section1.zip',
				'ciya-shop-section2.zip',
				'ciya-shop1.zip',
				'ciya-shop5.zip',
				'ciyashop-6.zip',
				'ciyashop-7.zip',
			),
		),
		'antique'         => array(
			'id'          => 'antique',
			'name'        => 'Antique',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/antique/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/antique/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories Menu',
				'categories_menu'  => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-antique.zip',
			),
		),
		'art-gallery'     => array(
			'id'          => 'art-gallery',
			'name'        => 'Art Gallery',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/art-gallery/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/art-gallery/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'categories_menu'  => 'Categories Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-art-gallery.zip',
			),
		),
		'auto-parts'      => array(
			'id'          => 'auto-parts',
			'name'        => 'Auto Parts',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/auto-parts/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/auto-parts/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'top_menu'         => 'Topbar Menu',
				'footer_menu'      => 'Useful Link',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-autoparts.zip',
			),
		),
		'ayurveda'        => array(
			'id'          => 'ayurveda',
			'name'        => 'Ayurveda',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/ayurveda/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/ayurveda/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-ayurveda.zip',
			),
		),
		'bag'             => array(
			'id'          => 'bag',
			'name'        => 'Bag',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bag',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/bag',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar menu',
				'footer_menu'      => 'Information Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-bag.zip',
			),
		),
		'bakery'          => array(
			'id'          => 'bakery',
			'name'        => 'Bakery',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bakery/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/bakery/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Category Menu',
			),
			'revsliders'  => array(
				'ciyashop-bakery.zip',
			),
		),
		'barber-shop'     => array(
			'id'          => 'barber-shop',
			'name'        => 'Barber Shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/barber-shop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/barber-shop/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'categories_menu'  => 'Category Menu',
				'shortcode_v_menu' => 'Category Menu',
			),
			'revsliders'  => array(
				'barber-slider.zip',
			),
		),
		'beard-oil'       => array(
			'id'          => 'beard-oil',
			'name'        => 'Beard Oil',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/beard-oil/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/beard-oil/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'footer_menu' => 'My Account',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'beer-shop'       => array(
			'id'          => 'beer-shop',
			'name'        => 'Beer Shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/beer-shop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/beer-shop/',
			'menus'       => array(
				'primary'     => 'Menu Right',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'bicycle'         => array(
			'id'          => 'bicycle',
			'name'        => 'Bicycle',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bicycle/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/bicycle/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'categories_menu'  => 'Categories Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-bicycle.zip',
			),
		),
		'books'           => array(
			'id'          => 'books',
			'name'        => 'Books',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/books/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/books/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-books.zip',
			),
		),
		'boots-fashion'   => array(
			'id'          => 'boots-fashion',
			'name'        => 'Boots Fashion',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/boots-fashion/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/boots-fashion/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'bow-hunting'     => array(
			'id'          => 'bow-hunting',
			'name'        => 'Bow Hunting',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bow-hunting/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/bow-hunting/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'cake'            => array(
			'id'          => 'cake',
			'name'        => 'Cake',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cake/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/cake/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Your account',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-cake.zip',
			),
		),
		'camera'          => array(
			'id'          => 'camera',
			'name'        => 'Camera',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/camera/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/camera/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
				'top_menu'    => 'Topbar Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'car-parts'       => array(
			'id'          => 'car-parts',
			'name'        => 'Car Parts',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/car-parts/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/car-parts/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'car-parts-slider.zip',
			),
		),
		'ceramic'         => array(
			'id'          => 'ceramic',
			'name'        => 'Ceramic',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/ceramic/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/ceramic/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'categories_menu'  => 'Categories Menu',
				'footer_menu'      => 'Useful Links',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-ceramic.zip',
			),
		),
		'ceramica'        => array(
			'id'          => 'ceramica',
			'name'        => 'Ceramica',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/ceramica/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/ceramica/',
			'menus'       => array(
				'primary' => 'Primary Menu',
			),
			'revsliders'  => array(
				'ceramica-slider.zip',
			),
		),
		'cleaning'        => array(
			'id'          => 'cleaning',
			'name'        => 'Cleaning',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cleaning/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/cleaning/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'categories_menu'  => 'Categories Menu',
				'top_menu'         => 'Topbar-menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-cleaning.zip',
			),
		),
		'chocolate'       => array(
			'id'          => 'chocolate',
			'name'        => 'Chocolate',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/chocolate/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/chocolate/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-chocolate.zip',
			),
		),
		'cigar'           => array(
			'id'          => 'cigar',
			'name'        => 'Cigar',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cigar/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/cigar/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'cigar-01.zip',
			),
		),
		'coffee'          => array(
			'id'          => 'coffee',
			'name'        => 'Coffee',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/coffee/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/coffee/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Footer Menu',
			),
			'revsliders'  => array(
				'ciyashop-coffee.zip',
				'coffee-side-banner.zip',
			),
		),
		'comic-bookshop'  => array(
			'id'          => 'comic-bookshop',
			'name'        => 'Comic book shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/comic-bookshop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/comic-bookshop/',
			'menus'       => array(
				'primary' => 'Primary Menu',
			),
			'revsliders'  => array(
				'comic-bookshop.zip',
			),
		),
		'cookware'        => array(
			'id'          => 'cookware',
			'name'        => 'Cookware',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cookware/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/cookware/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'cookware-slider.zip',
			),
		),
		'decor'           => array(
			'id'          => 'decor',
			'name'        => 'Decor',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/decor/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/decor/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'denim'           => array(
			'id'          => 'denim',
			'name'        => 'Denim',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/denim/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/denim/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-denim.zip',
			),
		),
		'digital'         => array(
			'id'          => 'digital',
			'name'        => 'Digital',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/digital/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/digital/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Useful Links',
				'shortcode_v_menu' => 'Products',
			),
		),
		'drone'           => array(
			'id'          => 'drone',
			'name'        => 'Drone',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/drone/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/drone/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'footer_menu' => 'Footer menu',
			),
			'revsliders'  => array(
				'drone.zip',
			),
		),
		'electronics'     => array(
			'id'          => 'electronics',
			'name'        => 'Electronics',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/electronics/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/electronics/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Information Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-electronics.zip',
			),
		),
		'fashion-classic' => array(
			'id'          => 'fashion-classic',
			'name'        => 'Fashion Classic',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-classic/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/fashion-classic/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Category Menu',
			),
			'revsliders'  => array(
				'ciya-shop-fashion-classic.zip',
			),
		),
		'fashion-modern'  => array(
			'id'          => 'fashion-modern',
			'name'        => 'Fashion Modern',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-modern/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/fashion-modern/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-fashion-modern.zip',
			),
		),
		'fashion-vintage' => array(
			'id'          => 'fashion-vintage',
			'name'        => 'Fashion Vintage',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-vintage/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/fashion-vintage/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-fashion-vintage.zip',
			),
		),
		'fishing'         => array(
			'id'          => 'fishing',
			'name'        => 'Fishing',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fishing/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/fishing/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Category Menu',
				'shortcode_v_menu' => 'Vertical Menu',
			),
			'revsliders'  => array(
				'ciyashop-fishing.zip',
			),
		),
		'flowers'         => array(
			'id'          => 'flowers',
			'name'        => 'Flowers',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/flower/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/flower/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-flowers.zip',
			),
		),
		'furniture'       => array(
			'id'          => 'furniture',
			'name'        => 'Furniture',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/furniture/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/furniture/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Useful Links',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-furniture.zip',
			),
		),
		'game'            => array(
			'id'          => 'game',
			'name'        => 'Game',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/game/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/game/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'game-main-banner.zip',
			),
		),
		'garden'          => array(
			'id'          => 'garden',
			'name'        => 'Garden',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/garden/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/garden/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'garden-01.zip',
			),
		),
		'gift'            => array(
			'id'          => 'gift',
			'name'        => 'Gift',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/gift/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/gift/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-gift.zip',
			),
		),
		'goggles'         => array(
			'id'          => 'goggles',
			'name'        => 'Goggles',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/goggles/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/goggles/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-goggles.zip',
			),
		),
		'gym'             => array(
			'id'          => 'gym',
			'name'        => 'Gym',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/gym/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/gym/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Information Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-gym.zip',
			),
		),
		'halloween'       => array(
			'id'          => 'halloween',
			'name'        => 'Halloween',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/halloween/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/halloween/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Categories Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-halloween.zip',
			),
		),
		'handmade'        => array(
			'id'          => 'handmade',
			'name'        => 'Handmade',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/handmade/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/handmade/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-handmade.zip',
			),
		),
		'headphones'      => array(
			'id'          => 'headphones',
			'name'        => 'Headphones',
			'demo_url'    => 'http://ciyashop.potenzaglobalsolutions.com/headphones/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'http://ciyashop.potenzaglobalsolutions.com/headphones/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
				'footer_menu' => 'Footer Menu',
				'top_menu'    => 'Topbar Menu',
			),
			'revsliders'  => array(
				'headphones-slider.zip',
			),
		),
		'home-slider'     => array(
			'id'          => 'home-slider',
			'name'        => 'Home Slider',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-slider/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/home-slider/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'home-slider.zip',
			),
		),
		'honey'           => array(
			'id'          => 'honey',
			'name'        => 'Honey',
			'demo_url'    => 'http://ciyashop.potenzaglobalsolutions.com/honey/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'http://ciyashop.potenzaglobalsolutions.com/honey/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'honey-slider.zip',
			),
		),
		'ice-cream'       => array(
			'id'          => 'ice-cream',
			'name'        => 'Ice Cream',
			'demo_url'    => 'http://ciyashop.potenzaglobalsolutions.com/ice-cream/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'http://ciyashop.potenzaglobalsolutions.com/ice-cream/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
				'footer_menu' => 'Footer Menu',
			),
			'revsliders'  => array(
				'ice-cream-slider.zip',
			),
		),
		'jewellery'       => array(
			'id'          => 'jewellery',
			'name'        => 'Jewellery',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/jewellery/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/jewellery/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'top_menu'         => 'Topbar Menu',
				'footer_menu'      => 'Usefull Links',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-jewellery.zip',
			),
		),
		'kids'            => array(
			'id'          => 'kids',
			'name'        => 'Kids',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/kids/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/kids/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciya-shop-kids.zip',
			),
		),
		'kitchen'         => array(
			'id'          => 'kitchen',
			'name'        => 'Kitchen',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/kitchen/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/kitchen/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-kitchen.zip',
			),
		),
		'landing-shoes'   => array(
			'id'          => 'landing-shoes',
			'name'        => 'Landing Shoes',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/landing-shoes/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/landing-shoes/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'landing-shoes-banner.zip',
			),
		),
		'leather'         => array(
			'id'          => 'leather',
			'name'        => 'Leather',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/leather/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/leather/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-leather.zip',
			),
		),
		'lighting'        => array(
			'id'          => 'lighting',
			'name'        => 'Lighting',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/lighting/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/lighting/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Footer-Account',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-lighting.zip',
			),
		),
		'lingerie'        => array(
			'id'          => 'lingerie',
			'name'        => 'Lingerie',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/lingerie/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/lingerie/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer-Account',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-lingerie.zip',
			),
		),
		'marijuana'       => array(
			'id'          => 'marijuana',
			'name'        => 'Marijuana',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/marijuana/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/marijuana/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'footer_menu' => 'Footer Menu',
			),
			'revsliders'  => array(
				'ciyashop-marijuana.zip',
			),
		),
		'medical'         => array(
			'id'          => 'medical',
			'name'        => 'Medical',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/medical/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/medical/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Usefull Links',
				'shortcode_v_menu' => 'Categories Menu',
				'categories_menu'  => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-medical.zip',
			),
		),
		'medicart'        => array(
			'id'          => 'medicart',
			'name'        => 'Medicart',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/medicart/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/medicart/',
			'menus'       => array(
				'primary' => 'Primary Menu',
			),
			'revsliders'  => array(
				'medicart-slider.zip',
			),
		),
		'mega-store'      => array(
			'id'          => 'mega-store',
			'name'        => 'Mega Store',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/mega-store/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/mega-store/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories menu',
			),
			'revsliders'  => array(
				'ciyashop-mega-store.zip',
			),
		),
		'military'        => array(
			'id'          => 'military',
			'name'        => 'Military',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/military/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/military/',
			'menus'       => array(
				'primary'  => 'Primary Menu',
				'top_menu' => 'Topbar Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'music-store'     => array(
			'id'          => 'music-store',
			'name'        => 'Music Store',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/music-store/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/music-store/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-music-store.zip',
			),
		),
		'nails'           => array(
			'id'          => 'nails',
			'name'        => 'Nails',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/nails/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/nails/',
			'menus'       => array(
				'primary'     => 'primary-menu',
				'footer_menu' => 'footer-menu',
				'mobile_menu' => 'primary-menu',
			),
			'revsliders'  => array(
				'Nails-slider.zip',
			),
		),
		'onveggy'         => array(
			'id'          => 'onveggy',
			'name'        => 'Onveggy',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/onveggie/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/onveggie/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
				'categories_menu'  => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-on-veggie.zip',
			),
		),
		'organic-store'   => array(
			'id'          => 'organic-store',
			'name'        => 'Organic Store',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/organic-store/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/organic-store/',
			'menus'       => array(
				'primary'     => 'primary-menu',
				'footer_menu' => 'footer-menu',
				'mobile_menu' => 'primary-menu',
			),
			'revsliders'  => array(
				'slider-01.zip',
			),
		),
		'olive-oil'       => array(
			'id'          => 'olive-oil',
			'name'        => 'Olive Oil',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/olive-oil/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/olive-oil/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'footer_menu' => 'footer-menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'perfume'         => array(
			'id'          => 'perfume',
			'name'        => 'Perfume',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/perfume/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/perfume/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'footer_menu'      => 'Useful Links',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-perfume.zip',
			),
		),
		'petstore'        => array(
			'id'          => 'petstore',
			'name'        => 'Petstore',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/petstore/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/petstore/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-petstore.zip',
			),
		),
		'plumbing'        => array(
			'id'          => 'plumbing',
			'name'        => 'Plumbing',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/plumbing/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/plumbing/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
				'footer_menu'      => 'Useful Link',
			),
			'revsliders'  => array(
				'ciyashop-plumbing.zip',
			),
		),
		'shisha'          => array(
			'id'          => 'shisha',
			'name'        => 'Shisha',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/shisha/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/shisha/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'categories_menu'  => 'Category Menu',
				'shortcode_v_menu' => 'Category Menu',
			),
			'revsliders'  => array(
				'ciya-shop-shisha.zip',
			),
		),
		'shoes'           => array(
			'id'          => 'shoes',
			'name'        => 'Shoes',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/shoes/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/shoes/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer Menu',
				'top_menu'         => 'Top Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-shoes.zip',
			),
		),
		'spa'             => array(
			'id'          => 'spa',
			'name'        => 'Spa',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/spa/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/spa/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Categories Menu',
				'footer_menu'      => 'Support',
			),
			'revsliders'  => array(
				'ciyashop-spa.zip',
			),
		),
		'spice-store'     => array(
			'id'          => 'spice-store',
			'name'        => 'Spice Store',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/spice-store/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/spice-store/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Primary Menu',
				'footer_menu'      => 'Useful-links',
				'shortcode_v_menu' => 'Categories Menu',
				'categories_menu'  => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-spice.zip',
			),
		),
		'sport'           => array(
			'id'          => 'sport',
			'name'        => 'Sport',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/sport/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/sport/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'footer_menu'      => 'Footer menu',
				'shortcode_v_menu' => 'Footer Menu',
			),
			'revsliders'  => array(
				'ciyashop-sport.zip',
			),
		),
		'suit'            => array(
			'id'          => 'suit',
			'name'        => 'Suit',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/suit/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/suit/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'footer_menu'      => 'Footer menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-suit.zip',
			),
		),
		'stationery'      => array(
			'id'          => 'stationery',
			'name'        => 'Stationery',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/stationery/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/stationery/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'mobile_menu'      => 'Primary Menu',
				'footer_menu'      => 'Footer menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'stationery-slider.zip',
			),
		),
		'scuba-diving'    => array(
			'id'          => 'scuba-diving',
			'name'        => 'Scuba Diving',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/stationery/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/stationery/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'mobile_menu'      => 'Primary Menu',
				'footer_menu'      => 'Footer Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'surfing'         => array(
			'id'          => 'surfing',
			'name'        => 'surfing',
			'demo_url'    => 'http://ciyashop.potenzaglobalsolutions.com/surfing/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'http://ciyashop.potenzaglobalsolutions.com/surfing/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'surfing-slider.zip',
			),
		),
		'tea-store'       => array(
			'id'          => 'tea-store',
			'name'        => 'Tea Store',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/tea-store/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/tea-store/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
				'footer_menu' => 'Footer Menu',
			),
			'revsliders'  => array(
				'tea-main-banner.zip',
			),
		),
		'toolkito'        => array(
			'id'          => 'toolkito',
			'name'        => 'Toolkito',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/toolkito/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/toolkito/',
			'menus'       => array(
				'primary'     => 'primary menu',
				'mobile_menu' => 'primary menu',
			),
			'revsliders'  => array(
				'toolkito.zip',
			),
		),
		'tools'           => array(
			'id'          => 'tools',
			'name'        => 'Tools',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/tools/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/tools/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'tools-slider.zip',
			),
		),
		'toys'            => array(
			'id'          => 'toys',
			'name'        => 'Toys',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/toys/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/toys/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'categories_menu'  => 'Categories Menu',
				'footer_menu'      => 'Useful Links',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-toys.zip',
			),
		),
		'yoga-shop'       => array(
			'id'          => 'yoga-shop',
			'name'        => 'Yoga Shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/yoga-shop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/yoga-shop/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'slider-1.zip',
			),
		),
		'vape-shop'       => array(
			'id'          => 'vape-shop',
			'name'        => 'Vape Shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/vape-shop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/vape-shop/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'top_menu'    => 'Topbar Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'vapeshop-slider.zip',
			),
		),
		'watch'           => array(
			'id'          => 'watch',
			'name'        => 'Watch',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/watch/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/watch/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'shortcode_v_menu' => 'Categories Menu',
				'top_menu'         => 'Topbar Menu',
			),
			'revsliders'  => array(
				'ciya-shop-watch.zip',
			),
		),
		'weapon'          => array(
			'id'          => 'weapon',
			'name'        => 'Weapon',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/weapon/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/weapon/',
			'menus'       => array(
				'primary'          => 'Main Menu',
				'shortcode_v_menu' => 'Footer Menu',
				'footer_menu'      => 'Footer Menu',
			),
			'revsliders'  => array(
				'ciyashop-weapon.zip',
			),
		),
		'wedding'         => array(
			'id'          => 'wedding',
			'name'        => 'Wedding',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/wedding/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/wedding/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'top_menu'         => 'Topbar Menu',
				'shortcode_v_menu' => 'Categories Menu',
			),
			'revsliders'  => array(
				'ciyashop-wedding.zip',
			),
		),
		'wine'            => array(
			'id'          => 'wine',
			'name'        => 'Wine',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/wine/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/wine/',
			'menus'       => array(
				'primary'          => 'Primary Menu',
				'shortcode_v_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'wine-main-banner.zip',
				'wine-product-slider.zip',
			),
		),
		'water-shop'      => array(
			'id'          => 'water-shop',
			'name'        => 'Water Shop',
			'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/water-shop/',
			'home_page'   => 'Home',
			'blog_page'   => 'Blog',
			'message'     => '',
			'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/water-shop/',
			'menus'       => array(
				'primary'     => 'Primary Menu',
				'mobile_menu' => 'Primary Menu',
			),
			'revsliders'  => array(
				'water-slider.zip',
			),
		),
	);

	// $sample_data_new
	array_walk( $sample_data_new, 'ciyashop_old_sample_data_fix' );

	$sample_data = array_merge( $sample_data, $sample_data_new );

	return $sample_data;
}


add_filter( 'pgscore_theme_sample_pages', 'ciyashop_sample_pages_items' );
if ( ! function_exists( 'ciyashop_sample_pages_items' ) ) {
	/**
	 * Ciyashop sample pages items
	 *
	 * @param array $sample_pages .
	 */
	function ciyashop_sample_pages_items( $sample_pages = array() ) {
		$sample_pages_new = array(
			'home-default'          => array(
				'id'          => 'home-default',
				'name'        => 'Home Default',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-default',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-default.jpg' ),
				'revsliders'  => array(
					'ciyashop-4.zip',
					'banner-video.zip',
				),
			),
			'home-2'                => array(
				'id'          => 'home-2',
				'name'        => 'Home 2',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-2',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-2.jpg' ),
				'revsliders'  => array(
					'ciya-shop-section2.zip',
				),
			),
			'home-3'                => array(
				'id'          => 'home-3',
				'name'        => 'Home 3',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-3',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-3.jpg' ),
				'revsliders'  => array(
					'ciya-shop5.zip',
				),
			),
			'home-4'                => array(
				'id'          => 'home-4',
				'name'        => 'Home 4',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-4',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-4.jpg' ),
				'revsliders'  => array(
					'ciya-shop1.zip',
				),
			),
			'home-5'                => array(
				'id'          => 'home-5',
				'name'        => 'Home 5',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-5',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-5.jpg' ),
				'revsliders'  => array(
					'ciyashop-2.zip',
				),
			),
			'home-6'                => array(
				'id'          => 'home-6',
				'name'        => 'Home 6',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-6',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-6.jpg' ),
				'revsliders'  => array(
					'ciyashop-6.zip',
				),
			),
			'home-7'                => array(
				'id'          => 'home-7',
				'name'        => 'Home 7',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-7',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/home-7.jpg' ),
				'revsliders'  => array(
					'ciyashop-7.zip',
				),
			),
			'about-us-1'            => array(
				'id'          => 'about-us-1',
				'name'        => 'About Us 1',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/about-us-1',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/about-us-1.jpg' ),
			),
			'about-us-2'            => array(
				'id'          => 'about-us-2',
				'name'        => 'About Us 2',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/about-us-2',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/about-us-2.jpg' ),
			),
			'contact-us-1'          => array(
				'id'          => 'contact-us-1',
				'name'        => 'Contact Us 1',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/contact-us-1',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/contact-us-1.jpg' ),
			),
			'contact-us-2'          => array(
				'id'          => 'contact-us-2',
				'name'        => 'Contact Us 2',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/contact-us-2',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/contact-us-2.jpg' ),
			),
			'look-book'             => array(
				'id'          => 'look-book',
				'name'        => 'Look Book',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/look-book',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/look-book.jpg' ),
			),
			'modern-process'        => array(
				'id'          => 'modern-process',
				'name'        => 'Modern Process',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/modern-process',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/modern-process.jpg' ),
			),
			'parallax-presentation' => array(
				'id'          => 'parallax-presentation',
				'name'        => 'Parallax Presentation',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/parallax-presentation',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/parallax-presentation.jpg' ),
			),
			'portfolio-data'        => array(
				'id'          => 'portfolio-data',
				'name'        => 'Portfolio',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/portfolio',
				'message'     => esc_html__( 'Importing this demo will import only sample data for "Portfolio" post type.', 'ciyashop' ),
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/additional-pages/portfolio-data.jpg' ),
			),
			'antique-home'          => array(
				'id'          => 'antique-home',
				'name'        => 'Antique - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/antique/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/antique.jpg' ),
				'revsliders'  => array(
					'ciyashop-antique.zip',
				),
			),
			'art-gallery-home'      => array(
				'id'          => 'art-gallery-home',
				'name'        => 'Art Gallery - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/art-gallery/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/art-gallery.jpg' ),
				'revsliders'  => array(
					'ciyashop-art-gallery.zip',
				),
			),
			'auto-parts-home'       => array(
				'id'          => 'auto-parts-home',
				'name'        => 'Auto Parts - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/auto-parts/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/auto-parts.jpg' ),
				'revsliders'  => array(
					'ciyashop-autoparts.zip',
				),
			),
			'ayurveda-home'         => array(
				'id'          => 'ayurveda-home',
				'name'        => 'Ayurveda - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/ayurveda/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/ayurveda.jpg' ),
				'revsliders'  => array(
					'ciyashop-ayurveda.zip',
				),
			),
			'bag-home'              => array(
				'id'          => 'bag-home',
				'name'        => 'Bag - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bag/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/bag.jpg' ),
				'revsliders'  => array(
					'ciya-shop-bag.zip',
				),
			),
			'bakery-home'           => array(
				'id'          => 'bakery-home',
				'name'        => 'Bakery - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bakery/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/bakery.jpg' ),
				'revsliders'  => array(
					'ciyashop-bakery.zip',
				),
			),
			'barber-shop-home'      => array(
				'id'          => 'barber-shop-home',
				'name'        => 'Barber Shop - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/barber-shop/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/barber-shop.jpg' ),
				'revsliders'  => array(
					'barber-slider.zip',
				),
			),
			'bicycle-home'          => array(
				'id'          => 'bicycle-home',
				'name'        => 'Bicycle - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/bicycle/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/bicycle.jpg' ),
				'revsliders'  => array(
					'ciya-shop-bicycle.zip',
				),
			),
			'books-home'            => array(
				'id'          => 'books-home',
				'name'        => 'Books - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/books/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/books.jpg' ),
				'revsliders'  => array(
					'ciyashop-books.zip',
				),
			),
			'cake-home'             => array(
				'id'          => 'cake-home',
				'name'        => 'Cake - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cake/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/cake.jpg' ),
				'revsliders'  => array(
					'ciyashop-cake.zip',
				),
			),
			'ceramic-home'          => array(
				'id'          => 'ceramic-home',
				'name'        => 'Ceramic - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/ceramic/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/ceramic.jpg' ),
				'revsliders'  => array(
					'ciyashop-ceramic.zip',
				),
			),
			'cleaning-home'         => array(
				'id'          => 'cleaning-home',
				'name'        => 'Cleaning - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cleaning/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/cleaning.jpg' ),
				'revsliders'  => array(
					'ciya-shop-cleaning.zip',
				),
			),
			'chocolate-home'        => array(
				'id'          => 'chocolate-home',
				'name'        => 'Chocolate - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/chocolate/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/chocolate.jpg' ),
				'revsliders'  => array(
					'ciyashop-chocolate.zip',
				),
			),
			'cigar-home'            => array(
				'id'          => 'cigar-home',
				'name'        => 'Cigar - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/cigar/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/cigar.jpg' ),
				'revsliders'  => array(
					'cigar-01.zip',
				),
			),
			'coffee-home'           => array(
				'id'          => 'coffee-home',
				'name'        => 'Coffee - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/coffee/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/coffee.jpg' ),
				'revsliders'  => array(
					'ciyashop-coffee.zip',
					'coffee-side-banner.zip',
				),
			),
			'denim-home'            => array(
				'id'          => 'denim-home',
				'name'        => 'Denim - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/denim/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/denim.jpg' ),
				'revsliders'  => array(
					'ciyashop-denim.zip',
				),
			),
			'digital-home'          => array(
				'id'          => 'digital-home',
				'name'        => 'Digital - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/digital/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/digital.jpg' ),
			),
			'electronics-home'      => array(
				'id'          => 'electronics-home',
				'name'        => 'Electronics - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/electronics/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/electronics.jpg' ),
				'revsliders'  => array(
					'ciya-shop-electronics.zip',
				),
			),
			'fashion-classic-home'  => array(
				'id'          => 'fashion-classic-home',
				'name'        => 'Fashion Classic - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-classic/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/fashion-classic.jpg' ),
				'revsliders'  => array(
					'ciya-shop-fashion-classic.zip',
				),
			),
			'fashion-modern-home'   => array(
				'id'          => 'fashion-modern-home',
				'name'        => 'Fashion Modern - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-modern/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/fashion-modern.jpg' ),
				'revsliders'  => array(
					'ciya-shop-fashion-modern.zip',
				),
			),
			'fashion-vintage-home'  => array(
				'id'          => 'fashion-vintage-home',
				'name'        => 'Fashion Vintage - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fashion-vintage/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/fashion-vintage.jpg' ),
				'revsliders'  => array(
					'ciyashop-fashion-vintage.zip',
				),
			),
			'fishing-home'          => array(
				'id'          => 'fishing-home',
				'name'        => 'Fishing - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/fishing/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/fishing.jpg' ),
				'revsliders'  => array(
					'ciyashop-fishing.zip',
				),
			),
			'flowers-home'          => array(
				'id'          => 'flowers-home',
				'name'        => 'Flowers - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/flowers/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/flowers.jpg' ),
				'revsliders'  => array(
					'ciya-shop-flowers.zip',
				),
			),
			'furniture-home'        => array(
				'id'          => 'furniture-home',
				'name'        => 'Furniture - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/furniture/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/furniture.jpg' ),
				'revsliders'  => array(
					'ciya-shop-furniture.zip',
				),
			),
			'game-home'             => array(
				'id'          => 'game-home',
				'name'        => 'Game - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/game/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/game.jpg' ),
				'revsliders'  => array(
					'game-main-banner.zip',
				),
			),
			'garden-home'           => array(
				'id'          => 'garden-home',
				'name'        => 'Garden - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/garden/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/garden.jpg' ),
				'revsliders'  => array(
					'garden-01.zip',
				),
			),
			'gift-home'             => array(
				'id'          => 'gift-home',
				'name'        => 'Gift - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/gift/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/gift.jpg' ),
				'revsliders'  => array(
					'ciyashop-gift.zip',
				),
			),
			'goggles-home'          => array(
				'id'          => 'goggles-home',
				'name'        => 'Goggles - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/goggles/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/goggles.jpg' ),
				'revsliders'  => array(
					'ciyashop-goggles.zip',
				),
			),
			'gym-home'              => array(
				'id'          => 'gym-home',
				'name'        => 'Gym - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/gym/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/gym.jpg' ),
				'revsliders'  => array(
					'ciyashop-gym.zip',
				),
			),
			'halloween-home'        => array(
				'id'          => 'halloween-home',
				'name'        => 'Halloween - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/halloween/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/halloween.jpg' ),
				'revsliders'  => array(
					'ciyashop-halloween.zip',
				),
			),
			'handmade-home'         => array(
				'id'          => 'handmade-home',
				'name'        => 'Handmade - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/handmade/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/handmade.jpg' ),
				'revsliders'  => array(
					'ciyashop-handmade.zip',
				),
			),
			'home-slider-home'      => array(
				'id'          => 'home-slider-home',
				'name'        => 'Home Slider - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/home-slider/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/home-slider.jpg' ),
				'revsliders'  => array(
					'home-slider.zip',
				),
			),
			'jewellery-home'        => array(
				'id'          => 'jewellery-home',
				'name'        => 'Jewellery - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/jewellery/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/jewellery.jpg' ),
				'revsliders'  => array(
					'ciyashop-jewellery.zip',
				),
			),
			'kids-home'             => array(
				'id'          => 'kids-home',
				'name'        => 'Kids - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/kids/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/kids.jpg' ),
				'revsliders'  => array(
					'ciya-shop-kids.zip',
				),
			),
			'kitchen-home'          => array(
				'id'          => 'kitchen-home',
				'name'        => 'Kitchen - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/kitchen/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/kitchen.jpg' ),
				'revsliders'  => array(
					'ciyashop-kitchen.zip',
				),
			),
			'landing-shoes-home'    => array(
				'id'          => 'landing-shoes-home',
				'name'        => 'Landing Shoes - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/landing-shoes/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/landing-shoes.jpg' ),
				'revsliders'  => array(
					'landing-shoes-banner.zip',
				),
			),
			'leather-home'          => array(
				'id'          => 'leather-home',
				'name'        => 'Leather - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/leather/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/leather.jpg' ),
				'revsliders'  => array(
					'ciyashop-leather.zip',
				),
			),
			'lingerie-home'         => array(
				'id'          => 'lingerie-home',
				'name'        => 'Lingerie - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/lingerie/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/lingerie.jpg' ),
				'revsliders'  => array(
					'ciyashop-lingerie.zip',
				),
			),
			'medical-home'          => array(
				'id'          => 'medical-home',
				'name'        => 'Medical - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/medical/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/medical.jpg' ),
				'revsliders'  => array(
					'ciyashop-medical.zip',
				),
			),
			'music-store-home'      => array(
				'id'          => 'music-store-home',
				'name'        => 'Music Store - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/music-store/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/music-store.jpg' ),
				'revsliders'  => array(
					'ciyashop-music-store.zip',
				),
			),
			'mega-store-home'       => array(
				'id'          => 'mega-store-home',
				'name'        => 'Mega Store - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/mega-store/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/mega-store.jpg' ),
				'revsliders'  => array(
					'ciyashop-mega-store.zip',
				),
			),
			'onveggie-home'         => array(
				'id'          => 'onveggie-home',
				'name'        => 'Onveggy - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/onveggie/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/onveggy.jpg' ),
				'revsliders'  => array(
					'ciyashop-on-veggie.zip',
				),
			),
			'perfume-home'          => array(
				'id'          => 'perfume-home',
				'name'        => 'Perfume - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/perfume/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/perfume/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/perfume.jpg' ),
				'revsliders'  => array(
					'ciyashop-perfume.zip',
				),
			),
			'petstore-home'         => array(
				'id'          => 'petstore-home',
				'name'        => 'Petstore - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/petstore/',

				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/petstore/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/petstore.jpg' ),
				'revsliders'  => array(
					'ciyashop-petstore.zip',
				),
			),
			'plumbing-home'         => array(
				'id'          => 'plumbing-home',
				'name'        => 'Plumbing - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/plumbing/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/plumbing/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/plumbing.jpg' ),
				'revsliders'  => array(
					'ciyashop-plumbing.zip',
				),
			),
			'shisha-home'           => array(
				'id'          => 'shisha-home',
				'name'        => 'Shisha - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/shisha/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/shisha/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/shisha.jpg' ),
				'revsliders'  => array(
					'ciya-shop-shisha.zip',
				),
			),
			'shoes-home'            => array(
				'id'          => 'shoes-home',
				'name'        => 'Shoes - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/shoes/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/shoes/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/shoes.jpg' ),
				'revsliders'  => array(
					'ciyashop-shoes.zip',
				),
			),
			'spa-home'              => array(
				'id'          => 'spa-home',
				'name'        => 'Spa - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/spa/',
				'message'     => '',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/spa.jpg' ),
				'revsliders'  => array(
					'ciyashop-spa.zip',
				),
			),
			'spice-store-home'      => array(
				'id'          => 'spice-store-home',
				'name'        => 'Spice Store - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/spice-store/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/spice-store/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/spice-store.jpg' ),
				'revsliders'  => array(
					'ciyashop-spice.zip',
				),
			),
			'sport-home'            => array(
				'id'          => 'sport-home',
				'name'        => 'Sport - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/sport/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/sport/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/sport.jpg' ),
				'revsliders'  => array(
					'ciyashop-sport.zip',
				),
			),
			'suit-home'             => array(
				'id'          => 'suit-home',
				'name'        => 'Suit - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/suit/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/suit/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/suit.jpg' ),
				'revsliders'  => array(
					'ciyashop-suit.zip',
				),
			),
			'toys-home'             => array(
				'id'          => 'toys-home',
				'name'        => 'Toys - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/toys/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/toys/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/toys.jpg' ),
				'revsliders'  => array(
					'ciyashop-toys.zip',
				),
			),
			'watch-home'            => array(
				'id'          => 'watch-home',
				'name'        => 'Watch - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/watch/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/watch/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/watch.jpg' ),
				'revsliders'  => array(
					'ciya-shop-watch.zip',
				),
			),
			'weapon-home'           => array(
				'id'          => 'weapon-home',
				'name'        => 'Weapon - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/weapon/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/weapon/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/weapon.jpg' ),
				'revsliders'  => array(
					'ciyashop-weapon.zip',
				),
			),
			'wedding-home'          => array(
				'id'          => 'wedding-home',
				'name'        => 'Wedding - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/wedding/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/wedding/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/wedding.jpg' ),
				'revsliders'  => array(
					'ciyashop-wedding.zip',
				),
			),
			'wine-home'             => array(
				'id'          => 'wine-home',
				'name'        => 'Wine - Home',
				'demo_url'    => 'https://ciyashop.potenzaglobalsolutions.com/wine/',
				'message'     => '',
				'preview_url' => 'https://ciyashop.potenzaglobalsolutions.com/wine/',
				'previwe_img' => esc_url( get_template_directory_uri() . '/images/sample_data/wine.jpg' ),
				'revsliders'  => array(
					'wine-main-banner.zip',
					'wine-product-slider.zip',
				),
			),
		);
		$sample_pages     = $sample_pages_new;
		return $sample_pages;
	}
}

/**
 * Ciyashop old sample data fix
 *
 * @param string $item1 .
 * @param string $key .
 */
function ciyashop_old_sample_data_fix( &$item1, $key ) {
	$sample_data_path = get_parent_theme_file_path( 'includes/sample_data' );
	$sample_data_url  = get_parent_theme_file_uri( 'includes/sample_data' );

	$item1['data_dir'] = trailingslashit( trailingslashit( $sample_data_path ) . $key );
	$item1['data_url'] = trailingslashit( trailingslashit( $sample_data_url ) . $key );
}
