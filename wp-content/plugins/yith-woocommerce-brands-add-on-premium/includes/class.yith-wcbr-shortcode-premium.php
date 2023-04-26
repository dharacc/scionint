<?php
/**
 * Shortcode class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Shortcode_Premium' ) ) {
	/**
	 * WooCommerce Brands Shortcode
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Shortcode_Premium extends YITH_WCBR_Shortcode {

		/**
		 * Performs all required add_shortcode
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public static function init() {
			add_shortcode( 'yith_wcbr_brand_filter', array( 'YITH_WCBR_Shortcode_Premium', 'brand_filter' ) );
			add_shortcode( 'yith_wcbr_brand_thumbnail', array( 'YITH_WCBR_Shortcode_Premium', 'brand_thumbnail' ) );
			add_shortcode( 'yith_wcbr_brand_thumbnail_carousel', array(
				'YITH_WCBR_Shortcode_Premium',
				'brand_thumbnail_carousel'
			) );
			add_shortcode( 'yith_wcbr_brand_product', array( 'YITH_WCBR_Shortcode_Premium', 'brand_product' ) );
			add_shortcode( 'yith_wcbr_brand_product_carousel', array(
				'YITH_WCBR_Shortcode_Premium',
				'brand_product_carousel'
			) );
			add_shortcode( 'yith_wcbr_brand_select', array( 'YITH_WCBR_Shortcode_Premium', 'brand_select' ) );
			add_shortcode( 'yith_wcbr_brand_list', array( 'YITH_WCBR_Shortcode_Premium', 'brand_list' ) );
			add_shortcode( 'yith_wcbr_brand_grid', array( 'YITH_WCBR_Shortcode_Premium', 'brand_grid' ) );

			// register shortcodes to WPBackery Visual Composer & Gutenberg & Elementor
			add_action( 'vc_before_init', array( 'YITH_WCBR_Shortcode_Premium', 'register_vc_shortcodes' ) );
			add_action( 'init', array( 'YITH_WCBR_Shortcode_Premium', 'register_gutenberg_blocks' ) );
			add_action( 'init', array( 'YITH_WCBR_Shortcode_Premium', 'init_elementor_widgets' ) );

			parent::init();
		}

		/**
		 * Register brands shortcode to visual composer
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public static function register_vc_shortcodes() {
			$vc_map_params = apply_filters( 'yith_wcbr_vc_shortcodes_params', array(

				'yith_wcbr_brand_filter' => array(
					'name'        => __( 'YITH Brand Filter', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_filter',
					'description' => __( 'Adds a list of brands with js filter for name', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to enter as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Paginate items', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Paginate brand elements or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Per page', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'per_page',
							'value'       => '5',
							'description' => __( 'Number of elements to show for each page', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated category slugs, if you want to filter brands by product cat', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							// @since 1.2.1
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only brands for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show filters', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_filter',
							'value'       => array(
								__( 'Show filters', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show filters', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show letters to filter brands or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show reset', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_reset',
							'value'       => array(
								__( 'Show reset', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show reset', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show "All" label to reset all filters or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show all letters', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_all_letters',
							'value'       => array(
								__( 'Show all letters', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show all letters', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show all letters or only available letters', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show count', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_count',
							'value'       => array(
								__( 'Show term count', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show term count', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'show term count or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide if empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide even if empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide if empty', 'yith-woocommerce-brands-add-on' )             => 'yes'
							),
							'description' => __( 'Choose to show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' )      => 'default',
								__( 'Big Header', 'yith-woocommerce-brands-add-on' )   => 'big-header',
								__( 'Small Header', 'yith-woocommerce-brands-add-on' ) => 'small-header',
								__( 'Shadow', 'yith-woocommerce-brands-add-on' )       => 'shadow',
								__( 'Boxed', 'yith-woocommerce-brands-add-on' )        => 'boxed',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )    => 'highlight'
							),
							'description' => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'colorpicker',
							'holder'      => '',
							'heading'     => __( 'Highlight color', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'highlight_color',
							'value'       => '#ffd900',
							'description' => __( 'Color to use as background in "Highlight" style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Menu sorting', 'yith-woocommerce-brands-add-on' )  => 'none',
								__( 'Name', 'yith-woocommerce-brands-add-on' )          => 'name',
								__( 'Slug', 'yith-woocommerce-brands-add-on' )          => 'slug',
								__( 'Term\'s Group', 'yith-woocommerce-brands-add-on' ) => 'term_group',
								__( 'Term\'s ID', 'yith-woocommerce-brands-add-on' )    => 'term_id',
								__( 'Description', 'yith-woocommerce-brands-add-on' )   => 'description',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )     => 'highlight'
							),
							'description' => __( 'Field to order terms by', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascendant', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descendant', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Whether to order terms in ascending or descending order', 'yith-woocommerce-brands-add-on' )
						)
					)
				),

				'yith_wcbr_brand_thumbnail' => array(
					'name'        => __( 'YITH Brand Thumbnail', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_thumbnail',
					'description' => __( 'Adds a list of brand thumbnails', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to enter as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Paginate items', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Paginate brand elements or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Per page', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'per_page',
							'value'       => '5',
							'description' => __( 'Number of elements to show for each page', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated category slugs, if you want to filter brands by product cat', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only brands for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide if empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide even if empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide if empty', 'yith-woocommerce-brands-add-on' )             => 'yes'
							),
							'description' => __( 'Choose to show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide terms without image', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_no_image',
							'value'       => array(
								__( 'Do not hide terms even if without image', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide terms without image', 'yith-woocommerce-brands-add-on' )                => 'yes'
							),
							'description' => __( 'Choose to show terms without image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show name', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_name',
							'value'       => array(
								__( 'Do not show name', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show name', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show brand name or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show rating', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_rating',
							'value'       => array(
								__( 'Do not show average brand rating', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show average brand rating', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show average brand rating or not (based on brand\'s product rating)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'cols',
							'value'       => '2',
							'description' => __( 'Number of elements per row', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' )         => 'default',
								__( 'Boxed', 'yith-woocommerce-brands-add-on' )           => 'boxed',
								__( 'Shadow', 'yith-woocommerce-brands-add-on' )          => 'shadow',
								__( 'Without borders', 'yith-woocommerce-brands-add-on' ) => 'borderless',
								__( 'Small Header', 'yith-woocommerce-brands-add-on' )    => 'top-border'
							),
							'description' => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Menu sorting', 'yith-woocommerce-brands-add-on' )  => 'none',
								__( 'Name', 'yith-woocommerce-brands-add-on' )          => 'name',
								__( 'Slug', 'yith-woocommerce-brands-add-on' )          => 'slug',
								__( 'Term\'s Group', 'yith-woocommerce-brands-add-on' ) => 'term_group',
								__( 'Term\'s ID', 'yith-woocommerce-brands-add-on' )    => 'term_id',
								__( 'Description', 'yith-woocommerce-brands-add-on' )   => 'description',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )     => 'highlight'
							),
							'description' => __( 'Field to order terms by', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascendant', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descendant', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Whether to order terms in ascending or descending order', 'yith-woocommerce-brands-add-on' )
						)
					)
				),

				'yith_wcbr_brand_thumbnail_carousel' => array(
					'name'        => __( 'YITH Brand Thumbnail Carousel', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_thumbnail_carousel',
					'description' => __( 'Adds a carousel of brand thumbnails', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to enter as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated category slugs, if you want to filter brands by product cat', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only brands for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide if empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide even if empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide if empty', 'yith-woocommerce-brands-add-on' )             => 'yes'
							),
							'description' => __( 'Choose to show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autoplay', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autoplay',
							'value'       => array(
								__( 'Yes', 'yith-woocommerce-brands-add-on' ) => 'yes',
								__( 'No', 'yith-woocommerce-brands-add-on' )  => 'no'
							),
							'description' => __( 'Start autoplay for carousel or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide terms without image', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_no_image',
							'value'       => array(
								__( 'Do not hide terms even if without image', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide terms without image', 'yith-woocommerce-brands-add-on' )                => 'yes'
							),
							'description' => __( 'Choose to show terms without image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Direction', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'direction',
							'value'       => array(
								__( 'Horizontal', 'yith-woocommerce-brands-add-on' ) => 'horizontal',
								__( 'Vertical', 'yith-woocommerce-brands-add-on' )   => 'vertical'
							),
							'description' => __( 'Show terms without image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'cols',
							'value'       => '2',
							'description' => __( 'Number of elements per row', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Carousel pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Do not show carousel pagination', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show carousel pagination or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination_style',
							'value'       => array(
								__( 'Round', 'yith-woocommerce-brands-add-on' )  => 'round',
								__( 'Square', 'yith-woocommerce-brands-add-on' ) => 'square'
							),
							'description' => __( 'Style for Carousel pagination', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Prev/Next button', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'prev_next',
							'value'       => array(
								__( 'Show prev/next button', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show prev/next button', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show prev/next button or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Prev/Next button style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'prev_next_style',
							'value'       => array(
								__( 'Round', 'yith-woocommerce-brands-add-on' )  => 'round',
								__( 'Square', 'yith-woocommerce-brands-add-on' ) => 'square'
							),
							'description' => __( 'Carousel prev/next button style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show name', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_name',
							'value'       => array(
								__( 'Show name', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show name', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show brand name or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show rating', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_rating',
							'value'       => array(
								__( 'Do not show average brand rating', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show average brand rating', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show average brand rating or not (based on brand\'s product rating)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' )        => 'default',
								__( 'Top border', 'yith-woocommerce-brands-add-on' )     => 'top-border',
								__( 'Shadow', 'yith-woocommerce-brands-add-on' )         => 'shadow',
								__( 'Centered title', 'yith-woocommerce-brands-add-on' ) => 'centered-title',
								__( 'Boxed', 'yith-woocommerce-brands-add-on' )          => 'boxed',
								__( 'Squared', 'yith-woocommerce-brands-add-on' )        => 'squared',
								__( 'Background', 'yith-woocommerce-brands-add-on' )     => 'background'
							),
							'description' => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Menu sorting', 'yith-woocommerce-brands-add-on' )  => 'none',
								__( 'Name', 'yith-woocommerce-brands-add-on' )          => 'name',
								__( 'Slug', 'yith-woocommerce-brands-add-on' )          => 'slug',
								__( 'Term\'s Group', 'yith-woocommerce-brands-add-on' ) => 'term_group',
								__( 'Term\'s ID', 'yith-woocommerce-brands-add-on' )    => 'term_id',
								__( 'Description', 'yith-woocommerce-brands-add-on' )   => 'description',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )     => 'highlight'
							),
							'description' => __( 'Field to order terms by', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascendant', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descendant', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Whether to order terms in ascending or descending order', 'yith-woocommerce-brands-add-on' )
						)
					)
				),

				'yith_wcbr_brand_product' => array(
					'name'        => __( 'YITH Brand Products', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_product',
					'description' => __( 'Adds a list of brand products', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to show as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Paginate items', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Paginate brand elements or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Per page', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'per_page',
							'value'       => '-1',
							'description' => __( 'Number of elements to show for each page', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'cols',
							'value'       => '4',
							'description' => __( 'Number of elements per row', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brand slugs, if you want to filter products by brand', 'yith-woocommerce-brands-add-on' )
						),
						// @since 1.2.1
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Brand', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_brand',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )              => 'no',
								__( 'Autosense current brand', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product brand page, ignores "brand" param, and shows only products for current brand', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated categories slugs, if you want to filter products by categories', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only products for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Product type', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'product_type',
							'value'       => array(
								__( 'All products', 'yith-woocommerce-brands-add-on' )      => 'all',
								__( 'Featured products', 'yith-woocommerce-brands-add-on' ) => 'featured',
								__( 'On sale products', 'yith-woocommerce-brands-add-on' )  => 'on_sale',
							),
							'description' => __( 'Type of products to show', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Random order', 'yith-woocommerce-brands-add-on' )      => 'rand',
								__( '"Created at" date', 'yith-woocommerce-brands-add-on' ) => 'date',
								__( 'Product title', 'yith-woocommerce-brands-add-on' )     => 'title',
								__( 'Product price', 'yith-woocommerce-brands-add-on' )     => 'price',
								__( 'Product sales', 'yith-woocommerce-brands-add-on' )     => 'sales',
							),
							'description' => __( 'Set order criteria for products', 'yith-woocommerce-brands-add-on' )
						),

						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascending', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descending', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Set order direction for products', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide free products', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_free',
							'value'       => array(
								__( 'Do not hide free products', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide free products', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Hide free products or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show hidden products', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_hidden',
							'value'       => array(
								__( 'Do not show products hidden in catalog', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show products hidden in catalog', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show products hidden in catalog or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show brand box before shortcode', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_brand_box',
							'value'       => array(
								__( 'Show brand box', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show brand box', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show brand box or not', 'yith-woocommerce-brands-add-on' )
						),
					)
				),

				'yith_wcbr_brand_product_carousel' => array(
					'name'        => __( 'YITH Brand Product Carousel', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_product_carousel',
					'description' => __( 'Adds a carousel of products', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to show as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'cols',
							'value'       => '2',
							'description' => __( 'Number of elements per row', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Total products to show', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'per_page',
							'value'       => '-1',
							'description' => __( 'Total number of products to show; -1 to show all products', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Direction', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'direction',
							'value'       => array(
								__( 'Horizontal', 'yith-woocommerce-brands-add-on' ) => 'horizontal',
								__( 'Vertical', 'yith-woocommerce-brands-add-on' )   => 'vertical'
							),
							'description' => __( 'Show terms without image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autoplay', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autoplay',
							'value'       => array(
								__( 'Yes', 'yith-woocommerce-brands-add-on' ) => 'yes',
								__( 'No', 'yith-woocommerce-brands-add-on' )  => 'no'
							),
							'description' => __( 'Start autoplay for carousel or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Carousel pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show carousel pagination', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show carousel pagination or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination_style',
							'value'       => array(
								__( 'Round', 'yith-woocommerce-brands-add-on' )  => 'round',
								__( 'Square', 'yith-woocommerce-brands-add-on' ) => 'square'
							),
							'description' => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Prev/Next button', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'prev_next',
							'value'       => array(
								__( 'Show prev/next button', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show prev/next button', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show prev/next button or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Prev/Next button style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'prev_next_style',
							'value'       => array(
								__( 'Round', 'yith-woocommerce-brands-add-on' )  => 'round',
								__( 'Square', 'yith-woocommerce-brands-add-on' ) => 'square'
							),
							'description' => __( 'Carousel prev/next button style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want to filter products by brand', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Brand', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_brand',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )              => 'no',
								__( 'Autosense current brand', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product brand page, ignores "brand" param, and shows only products for current brand', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated categories slugs, if you want to filter products by categories', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only products for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Product type', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'product_type',
							'value'       => array(
								__( 'All products', 'yith-woocommerce-brands-add-on' )      => 'all',
								__( 'Featured products', 'yith-woocommerce-brands-add-on' ) => 'featured',
								__( 'On sale products', 'yith-woocommerce-brands-add-on' )  => 'on_sale',
							),
							'description' => __( 'Type of products to show', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Random order', 'yith-woocommerce-brands-add-on' )      => 'rand',
								__( '"Created at" date', 'yith-woocommerce-brands-add-on' ) => 'date',
								__( 'Product title', 'yith-woocommerce-brands-add-on' )     => 'title',
								__( 'Product price', 'yith-woocommerce-brands-add-on' )     => 'price',
								__( 'Product sales', 'yith-woocommerce-brands-add-on' )     => 'sales',
							),
							'description' => __( 'Select sorting criteria for products', 'yith-woocommerce-brands-add-on' )
						),

						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascending', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descending', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Select sorting direction for products', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide free products', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_free',
							'value'       => array(
								__( 'Do not hide free products', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide free products', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Hide free products or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show hidden products', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_hidden',
							'value'       => array(
								__( 'Do not show products hidden in catalog', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Show products hidden in catalog', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show products hidden in catalog or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' ) => 'default',
								__( 'Square', 'yith-woocommerce-brands-add-on' )  => 'square',
								__( 'Round', 'yith-woocommerce-brands-add-on' )   => 'round'
							),
							'description' => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show brand box before shortcode', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_brand_box',
							'value'       => array(
								__( 'Show brand box', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show brand box', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show brand box or not', 'yith-woocommerce-brands-add-on' )
						),
					)
				),

				'yith_wcbr_brand_select' => array(
					'name'        => __( 'YITH Brand Select', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_select',
					'description' => __( 'Adds a select with all brands that redirects to archive page on change', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to show as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Autosense Category', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'autosense_category',
							'value'       => array(
								__( 'Do nothing', 'yith-woocommerce-brands-add-on' )                 => 'no',
								__( 'Autosense current category', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'If enabled, on product category page, ignores "category" param, and shows only brands for current category', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated category slugs, if you want to filter brands by product cat', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide empty', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show count', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_count',
							'value'       => array(
								__( 'Show term count', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show term count', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show term count or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Menu sorting', 'yith-woocommerce-brands-add-on' )  => 'none',
								__( 'Name', 'yith-woocommerce-brands-add-on' )          => 'name',
								__( 'Slug', 'yith-woocommerce-brands-add-on' )          => 'slug',
								__( 'Term\'s Group', 'yith-woocommerce-brands-add-on' ) => 'term_group',
								__( 'Term\'s ID', 'yith-woocommerce-brands-add-on' )    => 'term_id',
								__( 'Description', 'yith-woocommerce-brands-add-on' )   => 'description',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )     => 'highlight'
							),
							'description' => __( 'Field to order terms by', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascendant', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descendant', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Whether to order terms in ascending or descending order', 'yith-woocommerce-brands-add-on' )
						)
					)
				),

				'yith_wcbr_brand_list' => array(
					'name'        => __( 'YITH Brand List', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_list',
					'description' => __( 'Prints a list of all brands', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to show as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Categories', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category',
							'value'       => '',
							'description' => __( 'A list of valid comma separated category slugs, if you want to filter brands by product cat', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Pagination', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'pagination',
							'value'       => array(
								__( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Paginate items', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Paginate brand elements or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Per page', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'per_page',
							'value'       => '-1',
							'description' => __( 'Number of elements to show for each page', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show count', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_count',
							'value'       => array(
								__( 'Show term count', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show term count', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show term count or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide empty', 'yith-woocommerce-brands-add-on' )        => 'yes'
							),
							'description' => __( 'Show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' )      => 'default',
								__( 'Big Header', 'yith-woocommerce-brands-add-on' )   => 'big-header',
								__( 'Small Header', 'yith-woocommerce-brands-add-on' ) => 'small-header',
								__( 'Shadow', 'yith-woocommerce-brands-add-on' )       => 'shadow',
								__( 'Boxed', 'yith-woocommerce-brands-add-on' )        => 'boxed',
								__( 'HIghlight', 'yith-woocommerce-brands-add-on' )    => 'highlight'
							),
							'description' => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'colorpicker',
							'holder'      => '',
							'heading'     => __( 'Highlight color', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'highlight_color',
							'value'       => '#ffd900',
							'description' => __( 'Color to use as background in "Highlight" style', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'orderby',
							'value'       => array(
								__( 'Menu sorting', 'yith-woocommerce-brands-add-on' )  => 'none',
								__( 'Name', 'yith-woocommerce-brands-add-on' )          => 'name',
								__( 'Slug', 'yith-woocommerce-brands-add-on' )          => 'slug',
								__( 'Term\'s Group', 'yith-woocommerce-brands-add-on' ) => 'term_group',
								__( 'Term\'s ID', 'yith-woocommerce-brands-add-on' )    => 'term_id',
								__( 'Description', 'yith-woocommerce-brands-add-on' )   => 'description',
								__( 'Highlight', 'yith-woocommerce-brands-add-on' )     => 'highlight'
							),
							'description' => __( 'Field to order terms by', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'order',
							'value'       => array(
								__( 'Ascendant', 'yith-woocommerce-brands-add-on' )  => 'ASC',
								__( 'Descendant', 'yith-woocommerce-brands-add-on' ) => 'DESC'
							),
							'description' => __( 'Whether to order terms in ascending or descending order', 'yith-woocommerce-brands-add-on' )
						)
					)
				),

				'yith_wcbr_brand_grid' => array(
					'name'        => __( 'YITH Brand Grid', 'yith-woocommerce-brands-add-on' ),
					'base'        => 'yith_wcbr_brand_grid',
					'description' => __( 'Prints a grid of all brands with js filters', 'yith-woocommerce-brands-add-on' ),
					'category'    => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'title',
							'value'       => '',
							'description' => __( 'Text to show as shortcode title', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'cols',
							'value'       => '2',
							'description' => __( 'Number of elements per row', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show count', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_count',
							'value'       => array(
								__( 'Show term count', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show term count', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show term count or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show image', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_image',
							'value'       => array(
								__( 'Show term image', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show term image', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show term image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide if empty', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_empty',
							'value'       => array(
								__( 'Do not hide even if empty', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide if empty', 'yith-woocommerce-brands-add-on' )             => 'yes'
							),
							'description' => __( 'Show empty terms or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Hide terms without image', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'hide_no_image',
							'value'       => array(
								__( 'Do not hide terms even if without image', 'yith-woocommerce-brands-add-on' ) => 'no',
								__( 'Hide terms without image', 'yith-woocommerce-brands-add-on' )                => 'yes'
							),
							'description' => __( 'Show terms without image or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show name', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_name',
							'value'       => array(
								__( 'Show name', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show name', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show brand name or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show filtered', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_filtered_by',
							'value'       => array(
								__( 'Show brands grouped by heading letter', 'yith-woocommerce-brands-add-on' )   => 'name',
								__( 'Show brands grouped by product category', 'yith-woocommerce-brands-add-on' ) => 'category',
								__( 'Do not show brands filtered', 'yith-woocommerce-brands-add-on' )             => 'none'
							),
							'description' => __( 'Show brands grouped or not', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Use filtered url', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'use_filtered_urls',
							'value'       => array(
								__( 'Use plain brand urls', 'yith-woocommerce-brands-add-on' )                      => 'no',
								__( 'Use brand urls with category filter param', 'yith-woocommerce-brands-add-on' ) => 'yes'
							),
							'description' => __( 'Whether to use plain brands url, or append a parameter that will show only products of a specific brand/category pair (only when filtered by category)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show category filter', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_category_filter',
							'value'       => array(
								__( 'Show filters for product category', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show filters for product category', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Show filters for product category or not (only when filtered by name)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Category filter type', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category_filter_type',
							'value'       => array(
								__( 'Multiselect', 'yith-woocommerce-brands-add-on' ) => 'multiselect',
								__( 'Dropdown', 'yith-woocommerce-brands-add-on' )    => 'dropdown'
							),
							'description' => __( 'Show filters for product category as multiselect or as a dropdown (only when filtered by name)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Category filter style', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'category_filter_style',
							'value'       => array(
								__( 'Default', 'yith-woocommerce-brands-add-on' ) => 'default',
								__( 'Shadow', 'yith-woocommerce-brands-add-on' )  => 'shadow',
								__( 'Border', 'yith-woocommerce-brands-add-on' )  => 'border',
								__( 'Round', 'yith-woocommerce-brands-add-on' )   => 'round'
							),
							'description' => __( 'Category filter style (only when filtered by name)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show name filters', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_name_filter',
							'value'       => array(
								__( 'Show letters to filter brands', 'yith-woocommerce-brands-add-on' ) => 'yes',
								__( 'Do not show letters', 'yith-woocommerce-brands-add-on' )           => 'no'
							),
							'description' => __( 'Show letters to filter brands (only when filtered by name)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'dropdown',
							'holder'      => '',
							'heading'     => __( 'Show all letters', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'show_all_letters',
							'value'       => array(
								__( 'Show all letters', 'yith-woocommerce-brands-add-on' )        => 'yes',
								__( 'Do not show all letters', 'yith-woocommerce-brands-add-on' ) => 'no'
							),
							'description' => __( 'Whether to show all letters or only available letters (only when filtered by name)', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Brands', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'brand',
							'value'       => '',
							'description' => __( 'A list of valid comma separated brands slugs, if you want include only some specific brands', 'yith-woocommerce-brands-add-on' )
						),
						array(
							'type'        => 'textfield',
							'holder'      => '',
							'heading'     => __( 'Parent', 'yith-woocommerce-brands-add-on' ),
							'param_name'  => 'parent',
							'value'       => '',
							'description' => __( 'The ID of the common parent for all retrieved brands', 'yith-woocommerce-brands-add-on' )
						)
					)
				)
			) );

			if ( ! empty( $vc_map_params ) && function_exists( 'vc_map' ) ) {
				foreach ( $vc_map_params as $params ) {
					vc_map( $params );
				}
			}
		}

		/**
		 * Register Gutenberg blocks for this plugin
		 *
		 * @return void
		 */
		public static function register_gutenberg_blocks() {
			$blocks = array(
				'yith-wcbr-brand-filter'             => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Filter', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a list of brands with js filter for name', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_filter',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'per_page'           => array(
							'type'    => 'number',
							'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
							'default' => 5,
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'             => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'        => _x( 'None', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'        => _x( 'Name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'slug'        => _x( 'Slug', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_group'  => _x( 'Term Group', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_id'     => _x( 'Term ID', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'description' => _x( 'Description', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_filter'        => array(
							'type'    => 'select',
							'label'   => __( 'Show filters', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_reset'         => array(
							'type'    => 'select',
							'label'   => __( 'Show reset button', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show reset button', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show reset button', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_all_letters'   => array(
							'type'    => 'select',
							'label'   => __( 'Show all filters', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Show just not empty filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show all filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_count'         => array(
							'type'    => 'select',
							'label'   => __( 'Show items count for each brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'         => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'style'              => array(
							'type'    => 'select',
							'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default'      => __( 'Default', 'yith-woocommerce-brands-add-on' ),
								'big-header'   => __( 'Big header', 'yith-woocommerce-brands-add-on' ),
								'small-header' => __( 'Small header', 'yith-woocommerce-brands-add-on' ),
								'shadow'       => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
								'boxed'        => __( 'Boxed', 'yith-woocommerce-brands-add-on' ),
								'highlight'    => __( 'Highlight', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'highlight_color'    => array(
							'type'    => 'colorpicker',
							'default' => '#ffd900',
						),
					),
				),
				'yith-wcbr-brand-thumbnail'          => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Thumbnails', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a list of brand thumbnails', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_thumbnail',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'per_page'           => array(
							'type'    => 'number',
							'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
							'default' => 5,
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'             => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'        => _x( 'None', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'        => _x( 'Name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'slug'        => _x( 'Slug', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_group'  => _x( 'Term Group', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_id'     => _x( 'Term ID', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'description' => _x( 'Description', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'         => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_no_image'      => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no image', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide brands without image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide brands without image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_name'          => array(
							'type'    => 'select',
							'label'   => __( 'Show brand name', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'no'  => _x( 'Hide brand name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show brand name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_rating'        => array(
							'type'    => 'select',
							'label'   => __( 'Show average rating for products of the brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Hide rating', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show rating', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'cols'               => array(
							'type'    => 'number',
							'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'default' => 4,
							'min'     => 1,
							'max'     => 10
						),
						'style'              => array(
							'type'    => 'select',
							'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default'    => __( 'Default', 'yith-woocommerce-brands-add-on' ),
								'shadow'     => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
								'boxed'      => __( 'Boxed', 'yith-woocommerce-brands-add-on' ),
								'borderless' => __( 'Borderless', 'yith-woocommerce-brands-add-on' ),
								'top-border' => __( 'Top border', 'yith-woocommerce-brands-add-on' ),
							),
						),
					),
				),
				'yith-wcbr-brand-thumbnail-carousel' => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Thumbnails Carousel', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a carousel of brand thumbnails', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_thumbnail_carousel',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'             => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'        => _x( 'None', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'        => _x( 'Name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'slug'        => _x( 'Slug', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_group'  => _x( 'Term Group', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_id'     => _x( 'Term ID', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'description' => _x( 'Description', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'         => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_no_image'      => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no image', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide brands without image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide brands without image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'autoplay'           => array(
							'type'    => 'select',
							'label'   => __( 'Whether to autoplay carousel on page load', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'no'  => _x( 'Do not autoplay', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autoplay', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'loop'               => array(
							'type'    => 'select',
							'label'   => __( 'Whether to loop carousel or not', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'yes' => _x( 'Enable loop', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'no'  => _x( 'Do not enable loop', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'direction'          => array(
							'type'    => 'select',
							'label'   => __( 'Slider direction', 'yith-woocommerce-brands-add-on' ),
							'default' => 'horizontal',
							'options' => array(
								'horizontal' => _x( 'Horizontal', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'vertical'   => _x( 'Vertical', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show pagination', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show pagination', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'pagination_style'   => array(
							'type'    => 'select',
							'label'   => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'round',
							'options' => array(
								'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
								'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'prev_next'          => array(
							'type'    => 'select',
							'label'   => __( 'Show prev/next buttons', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show prev/next', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show prev/next', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'prev_next_style'    => array(
							'type'    => 'select',
							'label'   => __( 'Prev/Next buttons style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'round',
							'options' => array(
								'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
								'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_name'          => array(
							'type'    => 'select',
							'label'   => __( 'Show brand name', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'no'  => _x( 'Hide brand name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show brand name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_rating'        => array(
							'type'    => 'select',
							'label'   => __( 'Show average rating for products of the brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Hide rating', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show rating', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'cols'               => array(
							'type'    => 'number',
							'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'default' => 4,
							'min'     => 1,
							'max'     => 10
						),
						'style'              => array(
							'type'    => 'select',
							'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default'        => __( 'Default', 'yith-woocommerce-brands-add-on' ),
								'shadow'         => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
								'boxed'          => __( 'Boxed', 'yith-woocommerce-brands-add-on' ),
								'top-border'     => __( 'Top border', 'yith-woocommerce-brands-add-on' ),
								'centered-title' => __( 'Centered title', 'yith-woocommerce-brands-add-on' ),
								'squared'        => __( 'Squared', 'yith-woocommerce-brands-add-on' ),
								'background'     => __( 'Background', 'yith-woocommerce-brands-add-on' ),
							),
						),
					),
				),
				'yith-wcbr-brand-product'            => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Products', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a list of products for a specific brand (Preview not available)', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_product',
					'do_shortcode'   => false,
					// TODO: check how to correctly render products ul on backend (no woocommerce-layout css)
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'per_page'           => array(
							'type'    => 'number',
							'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
							'default' => - 1,
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_brand'    => array(
							'type'    => 'select',
							'label'   => __( 'Autosense brand (whether to show just items related to current brand)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense brand', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense brand', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'product_type'       => array(
							'type'    => 'select',
							'label'   => __( 'Type of products to retrieve', 'yith-woocommerce-brands-add-on' ),
							'default' => 'all',
							'options' => array(
								'all'      => _x( 'All products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'featured' => _x( 'Featured products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'on_sale'  => _x( 'On sale products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'rand',
							'options' => array(
								'rand'  => _x( 'Random', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'date'  => _x( 'Post date', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'title' => _x( 'Product title', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'price' => _x( 'Product price', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'sales' => _x( 'Sales count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_free'          => array(
							'type'    => 'select',
							'label'   => __( 'Hide free products', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide free products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide free products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_hidden'        => array(
							'type'    => 'select',
							'label'   => __( 'Show hidden products', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show hidden products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show hidden products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_brand_box'     => array(
							'type'    => 'select',
							'label'   => __( 'Show the box containing a list of all matching brands for current product selection', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show brand box', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show brand box', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'cols'               => array(
							'type'    => 'number',
							'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'default' => 4,
							'min'     => 1,
							'max'     => 10
						),
					),
				),
				'yith-wcbr-brand-product-carousel'   => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Products Carousel', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a carousel of brand products', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_product_carousel',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_brand'    => array(
							'type'    => 'select',
							'label'   => __( 'Autosense brand (whether to show just items related to current brand)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense brand', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense brand', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'product_type'       => array(
							'type'    => 'select',
							'label'   => __( 'Type of products to retrieve', 'yith-woocommerce-brands-add-on' ),
							'default' => 'all',
							'options' => array(
								'all'      => _x( 'All products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'featured' => _x( 'Featured products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'on_sale'  => _x( 'On sale products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'per_page'           => array(
							'type'    => 'number',
							'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
							'default' => - 1,
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'rand',
							'options' => array(
								'rand'  => _x( 'Random', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'date'  => _x( 'Post date', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'title' => _x( 'Product title', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'price' => _x( 'Product price', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'sales' => _x( 'Sales count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'autoplay'           => array(
							'type'    => 'select',
							'label'   => __( 'Whether to autoplay carousel on page load', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'no'  => _x( 'Do not autoplay', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autoplay', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'loop'               => array(
							'type'    => 'select',
							'label'   => __( 'Whether to loop carousel or not', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'yes' => _x( 'Enable loop', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'no'  => _x( 'Do not enable loop', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'direction'          => array(
							'type'    => 'select',
							'label'   => __( 'Slider direction', 'yith-woocommerce-brands-add-on' ),
							'default' => 'horizontal',
							'options' => array(
								'horizontal' => _x( 'Horizontal', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'vertical'   => _x( 'Vertical', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show pagination', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show pagination', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'pagination_style'   => array(
							'type'    => 'select',
							'label'   => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'round',
							'options' => array(
								'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
								'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'prev_next'          => array(
							'type'    => 'select',
							'label'   => __( 'Show prev/next buttons', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show prev/next', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show prev/next', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'prev_next_style'    => array(
							'type'    => 'select',
							'label'   => __( 'Prev/Next buttons style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'round',
							'options' => array(
								'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
								'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_free'          => array(
							'type'    => 'select',
							'label'   => __( 'Hide free products', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide free products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide free products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_hidden'        => array(
							'type'    => 'select',
							'label'   => __( 'Show hidden products', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show hidden products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show hidden products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_brand_box'     => array(
							'type'    => 'select',
							'label'   => __( 'Show the box containing a list of all matching brands for current product selection', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show brand box', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show brand box', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'cols'               => array(
							'type'    => 'number',
							'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'default' => 4,
							'min'     => 1,
							'max'     => 10
						),
						'style'              => array(
							'type'    => 'select',
							'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default' => __( 'Default', 'yith-woocommerce-brands-add-on' ),
								'square'  => __( 'Square', 'yith-woocommerce-brands-add-on' ),
								'round'   => __( 'Round', 'yith-woocommerce-brands-add-on' ),
							),
						),
					),
				),
				'yith-wcbr-brand-select'             => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Select', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a select containing all brands; click on one item will redirect to brand page', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_select',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'             => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'        => _x( 'None', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'        => _x( 'Name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'slug'        => _x( 'Slug', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_group'  => _x( 'Term Group', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_id'     => _x( 'Term ID', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'description' => _x( 'Description', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_count'         => array(
							'type'    => 'select',
							'label'   => __( 'Show items count for each brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'         => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
					),
				),
				'yith-wcbr-brand-list'               => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands List', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a list of all matching brands', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_list',
					'attributes'     => array(
						'title'              => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'pagination'         => array(
							'type'    => 'select',
							'label'   => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Paginate items', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'per_page'           => array(
							'type'    => 'number',
							'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
							'default' => 5,
						),
						'autosense_category' => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'           => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'              => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'             => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'orderby'            => array(
							'type'    => 'select',
							'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'        => _x( 'None', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'        => _x( 'Name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'slug'        => _x( 'Slug', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_group'  => _x( 'Term Group', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'term_id'     => _x( 'Term ID', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'description' => _x( 'Description', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'order'              => array(
							'type'    => 'select',
							'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
							'default' => 'ASC',
							'options' => array(
								'ASC'  => _x( 'Ascending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'DESC' => _x( 'Descending', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_count'         => array(
							'type'    => 'select',
							'label'   => __( 'Show items count for each brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'         => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'style'              => array(
							'type'    => 'select',
							'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default'      => __( 'Default', 'yith-woocommerce-brands-add-on' ),
								'big-header'   => __( 'Big header', 'yith-woocommerce-brands-add-on' ),
								'small-header' => __( 'Small header', 'yith-woocommerce-brands-add-on' ),
								'shadow'       => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
								'boxed'        => __( 'Boxed', 'yith-woocommerce-brands-add-on' ),
								'highlight'    => __( 'Highlight', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'highlight_color'    => array(
							'type'    => 'colorpicker',
							'default' => '#ffd900',
						),
					),
				),
				'yith-wcbr-brand-grid'               => array(
					'style'          => 'yith-wcbr-shortcode',
					'script'         => 'yith-wcbr',
					'title'          => _x( 'YITH Brands Grid', '[gutenberg]: block name', 'yith-woocommerce-brands-add-on' ),
					'description'    => __( 'Adds a grid of all matching brands', 'yith-woocommerce-brands-add-on' ),
					'shortcode_name' => 'yith_wcbr_brand_grid',
					'attributes'     => array(
						'title'                   => array(
							'type'    => 'text',
							'label'   => __( 'Title', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'autosense_category'      => array(
							'type'    => 'select',
							'label'   => __( 'Autosense category (whether to show just items related to current category)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Autosense category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category'                => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of categories slugs (override autosense category option)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'brand'                   => array(
							'type'    => 'text',
							'label'   => __( 'Comma separated list of brands slugs to show (leave empty to show all matching selection)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'parent'                  => array(
							'type'    => 'text',
							'label'   => __( 'Parent ID that terms must match (leave empty to show all terms)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'show_count'              => array(
							'type'    => 'select',
							'label'   => __( 'Show items count for each brand', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show items count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_image'              => array(
							'type'    => 'select',
							'label'   => __( 'Show brand thumbnail', 'yith-woocommerce-brands-add-on' ),
							'default' => 'yes',
							'options' => array(
								'no'  => _x( 'Do not show brand image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show brand image', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'hide_empty'              => array(
							'type'    => 'select',
							'label'   => __( 'Hide brands with no product', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Do not hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Hide empty brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'cols'                    => array(
							'type'    => 'number',
							'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
							'default' => 4,
							'min'     => 1,
							'max'     => 10
						),
						'show_filtered_by'        => array(
							'type'    => 'select',
							'label'   => __( 'What parameters should be used to group brands?', 'yith-woocommerce-brands-add-on' ),
							'default' => 'none',
							'options' => array(
								'none'     => _x( 'Do not group brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'category' => _x( 'Group brands by category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'name'     => _x( 'Group brands by initial letter of the name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_category_filter'    => array(
							'type'    => 'select',
							'label'   => __( 'Show categories filters? (Only when brands are grouped by name)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'yes' => _x( 'Show category filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'no'  => _x( 'Do not show category filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_name_filter'        => array(
							'type'    => 'select',
							'label'   => __( 'Show name filters? (Only when brands are grouped by name)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'yes' => _x( 'Show name filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'no'  => _x( 'Do not show name filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'show_all_letters'        => array(
							'type'    => 'select',
							'label'   => __( 'Show all letters in filter section (Only when brands are grouped by name)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Show just not empty filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Show all filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category_filter_type'    => array(
							'type'    => 'select',
							'label'   => __( 'Category filter type (Only when brands are grouped by name and category filter is enabled)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'multiselect',
							'options' => array(
								'multiselect' => _x( 'Multiselect', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'dropdown'    => _x( 'Dropdown', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category_filter_style'   => array(
							'type'    => 'select',
							'label'   => __( 'Category filter style (Only when brands are grouped by name and category filter is enabled)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'default',
							'options' => array(
								'default' => _x( 'Default', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'shadow'  => _x( 'Shadow', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'border'  => _x( 'Border', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'round'   => _x( 'Round', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
						'category_filter_default' => array(
							'type'    => 'text',
							'label'   => __( 'Initial selected category (leave empty to use "all" as default - only when brands are grouped by name and category filter is enabled)', 'yith-woocommerce-brands-add-on' ),
							'default' => '',
						),
						'use_filtered_urls'       => array(
							'type'    => 'select',
							'label'   => __( 'Links redirect customers to shop filtered by brand & category (Only when brands are grouped by name)', 'yith-woocommerce-brands-add-on' ),
							'default' => 'no',
							'options' => array(
								'no'  => _x( 'Use plain brand urls', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
								'yes' => _x( 'Use filtered urls', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
							),
						),
					),
				),
			);

			yith_plugin_fw_gutenberg_add_blocks( $blocks );
		}

		/**
		 * Register custom widgets for Elementor
		 *
		 * @return void
		 */
		public static function init_elementor_widgets() {
			// check if elementor is active.
			if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
				return;
			}

			// include widgets.
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-filter.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-thumbnail.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-thumbnail-carousel.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-product.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-product-carousel.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-select.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-list.php';
			include_once YITH_WCBR_INC . 'widget/elementor/class.yith-wcbr-elementor-brand-grid.php';

			// register widgets.
			add_action( 'elementor/widgets/widgets_registered', array( 'YITH_WCBR_Shortcode_Premium', 'register_elementor_widgets' ) );
		}

		/**
		 * Register Elementor Widgets
		 *
		 * @return void
		 */
		public static function register_elementor_widgets() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Thumbnail() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Thumbnail_Carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Product() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Product_Carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Select() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new YITH_WCBR_Elementor_Brand_List() );
		}

		/**
		 * Returns output for brand filter
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_filter( $atts ) {
			global $wp_query, $product;

			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $pagination
			 * @var $per_page
			 * @var $page
			 * @var $name_like
			 * @var $autosense_category
			 * @var $category
			 * @var $show_filter
			 * @var $show_reset
			 * @var $show_all_letters
			 * @var $show_count
			 * @var $hide_empty
			 * @var $style
			 * @var $highlight_color
			 * @var $brand
			 * @var $parent
			 * @var $orderby
			 * @var $order
			 * @var exclude
			 */

			$defaults = array(
				'title'              => '',
				'pagination'         => 'no',
				// yes - no
				'per_page'           => 5,
				// int
				'page'               => false,
				// int
				'name_like'          => '',
				// search for a specific name format (disables pagination)
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'show_filter'        => 'yes',
				// yes - no
				'show_reset'         => 'yes',
				// yes - no
				'show_all_letters'   => 'yes',
				// yes - no
				'show_count'         => 'yes',
				// yes - no
				'hide_empty'         => 'no',
				// yes - no
				'style'              => 'default',
				// default - big-header - small-header - shadow - boxed - highlight
				'highlight_color'    => '#ffd900',
				// hex color code (only for highlight style)
				'brand'              => 'all',
				// brands slug to include
				'parent'             => '',
				// parent to match for terms (term id)
				'orderby'            => 'none',
				// terms ordering name - slug - term_group - term_id - id - description
				'order'              => 'ASC',
				// order ascending or descending
				'exclude'            => ''
				// brand ids to exclude
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// let third party plugin perform actions before shortcode handling
			do_action( 'yith_wcbr_before_shortcode', 'brand_filter', $atts );

			// make attributes available
			extract( $atts );

			// sets pagination variable
			if ( $pagination == 'yes' && empty( $name_like ) ) {
				$count = wp_count_terms(
					YITH_WCBR::$brands_taxonomy,
					array_merge(
						array( 'hide_empty' => $hide_empty == 'yes' ),
						! empty( $brand ) && $brand != 'all' ? array( 'slug' => explode( ',', $brand ) ) : array(),
						! empty( $parent ) ? array( 'parent' => $parent ) : array()
					)
				);

				$pages        = ceil( $count / $per_page );
				$current_page = ! empty( $page ) ? $page : max( 1, get_query_var( 'paged' ) );

				if ( $current_page > $pages ) {
					$current_page = $pages;
				}

				$offset = ( $current_page - 1 ) * $per_page;

				if ( $pages > 1 ) {
					$page_links = paginate_links( array(
						'base'      => esc_url( add_query_arg( array( 'paged' => '%#%' ), '' ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $pages,
						'show_all'  => true,
						'prev_text' => '<',
						'next_text' => '>'
					) );

					$atts['page_links'] = $page_links;
				}

				$atts['count']        = $count;
				$atts['pages']        = $pages;
				$atts['current_page'] = $current_page;
				$atts['offset']       = $offset;
			}

			// sets category filter variables
			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {
				$include = array();

				if ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				if ( ! empty( $categories ) ) {
					$brand_category_relationship = YITH_WCBR_Premium()->get_category_brand_relationships();

					foreach ( $categories as $category_slug ) {
						$category = get_term_by( 'slug', $category_slug, 'product_cat' );

						if ( $category && isset( $brand_category_relationship[ $category->term_id ] ) ) {
							$include = array_merge( $include, $brand_category_relationship[ $category->term_id ] );
						}
					}
				}
			}

			if ( apply_filters( 'yith_wcbr_return_on_empty_include', false ) && isset( $include ) && empty( $include ) ) {
				return '';
			}

			// retrieve elements
			$terms = yith_wcbr_get_terms(
				YITH_WCBR::$brands_taxonomy,
				array_merge(
					array(
						'hide_empty' => $hide_empty == 'yes',
						'include'    => isset( $include ) ? $include : array(),
						'exclude'    => isset( $exclude ) ? $exclude : array(),
						'orderby'    => isset( $orderby ) && 'none' != $orderby ? $orderby : 'name',
						'order'      => isset( $order ) ? $order : 'ASC'
					),
					( $pagination != 'yes' || ! empty( $name_like ) ) ? array() : array(
						'offset' => $offset,
						'number' => $per_page
					),
					! empty( $name_like ) && ! in_array( $name_like, array( 'all', '123' ) ) ? array(
						'name__like' => $name_like
					) : array(),
					! empty( $brand ) && $brand != 'all' ? array( 'slug' => explode( ',', $brand ) ) : array(),
					! empty( $parent ) ? array( 'parent' => $parent ) : array()
				)
			);

			if ( is_wp_error( $terms ) ) {
				return '';
			}

			// refine search: make sure that terms name starts with search string
			if ( ! empty( $name_like ) && $name_like != 'all' ) {
				foreach ( $terms as $key => $term ) {
					if ( $name_like == '123' && ! preg_match( '/[0-9]+.*/', $term->name ) ) {
						unset( $terms[ $key ] );
					}

					if ( ! in_array( $name_like, array( 'all', '123' ) ) && 0 !== stripos( $term->name, $name_like ) ) {
						unset( $terms[ $key ] );
					}
				}
			}

			// let third party plugin customize term list
			$terms         = apply_filters( 'yith_wcbr_brand_filter_terms', $terms );
			$atts['terms'] = $terms;

			// if filters enabled, retrieve heading letter
			$available_filters = array();

			if ( $show_filter == 'yes' ) {
				$stack = explode( ' ', apply_filters( 'yith_wcbr_brand_filter_heading_letters', 'a b c d e f g h i j k l m n o p q r s t u v w x y z' ) );

				foreach ( $terms as & $term ) {
					$heading_letter = apply_filters( 'yith_wcbr_brand_filter_heading_letter', strtolower( mb_substr( $term->name, 0, 1 ) ), $term->name, $term );

					if ( apply_filters('yith_wcbr_brand_filter_available_filters', ! in_array( $heading_letter, $stack ), $available_filters ) ) {
						if ( ! in_array( '123', $available_filters ) ) {
							$available_filters[] = '123';
						}
						$term->heading = '123';
					} else {
						if ( ! in_array( $heading_letter, $available_filters ) && ! is_numeric( $heading_letter ) ) {
							$available_filters[] = $heading_letter;
						}

						$term->heading = $heading_letter;
					}
				}

				// sort and filter available filters
				asort( $available_filters );
				$available_filters = apply_filters( 'yith_wcbr_sort_heading_letters', $available_filters );

				// create letters stack, using all alphabet, or just available filters
				$stack = ( $show_all_letters == 'yes' ) ? array_unique( array_merge( $stack, $available_filters, array( '123' ) ) ) : $available_filters;

				// sort and filters letters stack
				asort( $stack );
				$stack = apply_filters( 'yith_wcbr_sort_letters_stack', $stack );

				$atts['stack']             = $stack;
				$atts['available_filters'] = $available_filters;
			}

			$template_name = 'brand-filter.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$template = ob_get_clean();

			// let third party plugin perform actions after shortcode handling
			do_action( 'yith_wcbr_after_shortcode', 'brand_filter', $atts );

			return $template;
		}

		/**
		 * Returns output for brand thumbnail
		 *
		 * @param mixed $atts Array of shortcodes attributes.
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_thumbnail( $atts ) {
			global $wp_query, $product;

			/**
			 * The following variables will be extracted from $atts
			 *
			 * @var $title
			 * @var $pagination
			 * @var $autosense_category
			 * @var $category
			 * @var $per_page
			 * @var $hide_empty
			 * @var $hide_no_image
			 * @var $show_name
			 * @var $show_rating
			 * @var $cols
			 * @var $style
			 * @var $brand
			 * @var $parent
			 * @var $orderby
			 * @var $order
			 * @var $exclude
			 */

			$defaults = array(
				'title'              => '',
				'pagination'         => 'no', // yes - no.
				'autosense_category' => 'no', // yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category).
				'category'           => 'all', // all - a list of comma separated valid category slug.
				'per_page'           => 0, // int.
				'hide_empty'         => 'no', // yes - no.
				'hide_no_image'      => 'no', // yes - no.
				'show_name'          => 'no', // yes - no.
				'show_rating'        => 'no', // yes - no.
				'cols'               => 2, // int.
				'style'              => 'default', // default - boxed - shadow - borderless - top-border.
				'brand'              => 'all', // brands slug to include.
				'parent'             => '', // parent to match for terms (term id).
				'orderby'            => 'none', // terms ordering name - slug - term_group - term_id - id - description.
				'order'              => 'ASC', // order ascending or descending.
				'exclude'            => '', // brand ids to exclude.
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// let third party plugin perform actions before shortcode handling.
			do_action( 'yith_wcbr_before_shortcode', 'brand_thumbnail', $atts );

			// make attributes available.
			extract( $atts );

			if ( 'yes' === $hide_no_image && version_compare( WC()->version, '2.6', '<' ) ) {
				add_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ), 10, 3 );
			}

			if ( ( ! empty( $category ) && 'all' !== $category ) || ( 'yes' === $autosense_category && is_tax( 'product_cat' ) ) || ( 'yes' === $autosense_category && is_product() ) ) {
				$include = array();

				if ( 'yes' === $autosense_category && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( 'yes' === $autosense_category && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				if ( ! empty( $categories ) ) {
					$brand_category_relationship = YITH_WCBR_Premium()->get_category_brand_relationships();

					foreach ( $categories as $category_slug ) {
						$category = get_term_by( 'slug', $category_slug, 'product_cat' );

						if ( $category && isset( $brand_category_relationship[ $category->term_id ] ) ) {
							$include = array_merge( $include, $brand_category_relationship[ $category->term_id ] );
						}
					}
				}
			}

			if ( 'yes' === $pagination ) {
				$count = wp_count_terms(
					YITH_WCBR::$brands_taxonomy,
					array_merge(
						array(
							'hide_empty' => 'yes' === $hide_empty,
							'include'    => isset( $include ) ? $include : array(),
							'exclude'    => isset( $exclude ) ? $exclude : array(),
						),
						( 'yes' !== $hide_no_image && ! version_compare( WC()->version, '2.6', '<' ) ) ? array() : array(
							'meta_query' => array(
								array(
									'key'     => 'thumbnail_id',
									'value'   => 0,
									'compare' => '!=',
								),
							),
						),
						! empty( $brand ) && 'all' !== $brand ? array( 'slug' => explode( ',', $brand ) ) : array(),
						! empty( $parent ) ? array( 'parent' => $parent ) : array()
					)
				);

				$pages        = ceil( $count / $per_page );
				$current_page = max( 1, get_query_var( 'paged' ) );

				if ( $current_page > $pages ) {
					$current_page = $pages;
				}

				$offset = ( $current_page - 1 ) * $per_page;

				if ( $pages > 1 ) {
					$page_links = paginate_links(
						array(
							'base'      => esc_url( add_query_arg( array( 'paged' => '%#%' ) ) ),
							'format'    => '?paged=%#%',
							'current'   => $current_page,
							'total'     => $pages,
							'show_all'  => true,
							'prev_text' => '<',
							'next_text' => '>',
						)
					);

					$atts['page_links'] = $page_links;
				}

				$atts['count']        = $count;
				$atts['pages']        = $pages;
				$atts['current_page'] = $current_page;
				$atts['offset']       = $offset;
			}

			if ( apply_filters( 'yith_wcbr_return_on_empty_include', false ) && isset( $include ) && empty( $include ) ) {
				return '';
			}

			// retrieve elements.
			$terms = yith_wcbr_get_terms(
				YITH_WCBR::$brands_taxonomy,
				array_merge(
					array(
						'hide_empty' => 'yes' === $hide_empty,
						'number'     => $per_page,
						'include'    => isset( $include ) ? $include : array(),
						'exclude'    => isset( $exclude ) ? $exclude : array(),
						'orderby'    => isset( $orderby ) ? $orderby : 'none',
						'order'      => isset( $order ) ? $order : 'ASC',
					),
					'yes' !== $pagination ? array() : array(
						'offset' => $offset,
					),
					( 'yes' !== $hide_no_image && ! version_compare( WC()->version, '2.6', '<' ) ) ? array() : array(
						'meta_query' => array(
							array(
								'key'     => 'thumbnail_id',
								'value'   => 0,
								'compare' => '!=',
							),
						),
					),
					! empty( $brand ) && 'all' !== $brand ? array( 'slug' => explode( ',', $brand ) ) : array(),
					! empty( $parent ) ? array( 'parent' => $parent ) : array()
				)
			);

			if ( 'yes' === $hide_no_image && version_compare( WC()->version, '2.6', '<' ) ) {
				remove_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ) );
			}

			if ( is_wp_error( $terms ) ) {
				return '';
			}

			$atts['terms']      = $terms;
			$atts['cols_width'] = apply_filters( 'yith_wcbr_thumbnail_cols_width', floor( 100 / intval( $cols ) ) );

			$template_name = 'brand-thumbnail.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$template = ob_get_clean();

			// let third party plugin perform actions after shortcode handling.
			do_action( 'yith_wcbr_after_shortcode', 'brand_thumbnail', $atts );

			return $template;
		}

		/**
		 * Returns output for brand thumbnail carousel
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_thumbnail_carousel( $atts ) {
			global $wp_query, $product;

			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $autosense_category
			 * @var $category
			 * @var $hide_empty
			 * @var $hide_no_image
			 * @var $direction
			 * @var $cols
			 * @var $autoplay
			 * @var $pagination
			 * @var $pagination_style
			 * @var $prev_next
			 * @var $prev_next_style
			 * @var $show_name
			 * @var $show_rating
			 * @var $style
			 * @var $brand
			 * @var $parent
			 * @var $orderby
			 * @var $order
			 */

			$defaults = array(
				'title'              => '',
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'hide_empty'         => 'no',
				// yes - no
				'hide_no_image'      => 'no',
				// yes - no
				'direction'          => 'horizontal',
				// horizontal - vertical
				'cols'               => 2,
				// int
				'autoplay'           => 'yes',
				// yes - no
				'pagination'         => 'no',
				// yes - no
				'pagination_style'   => 'round',
				// round - square
				'prev_next'          => 'yes',
				// yes - no
				'prev_next_style'    => 'round',
				// round - square
				'show_name'          => 'yes',
				// yes - no
				'show_rating'        => 'no',
				// yes - no
				'style'              => 'default',
				// default - top-border - shadow - centered-title - boxed - squared - background
				'brand'              => 'all',
				// brands slug to include
				'parent'             => '',
				// parent to match for terms (term id)
				'orderby'            => 'none',
				// terms ordering name - slug - term_group - term_id - id - description
				'order'              => 'ASC',
				// order ascending or descending
				'loop'               => 'no'
				// yes - no (whether carousel should be circular)
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// let third party plugin perform actions before shortcode handling
			do_action( 'yith_wcbr_before_shortcode', 'brand_thumbnail_carousel', $atts );

			// make attributes available
			extract( $atts );

			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {
				$include = array();

				if ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				if ( ! empty( $categories ) ) {
					$brand_category_relationship = YITH_WCBR_Premium()->get_category_brand_relationships();

					foreach ( $categories as $category_slug ) {
						$category = get_term_by( 'slug', $category_slug, 'product_cat' );

						if ( $category && isset( $brand_category_relationship[ $category->term_id ] ) ) {
							$include = array_merge( $include, $brand_category_relationship[ $category->term_id ] );
						}
					}
				}
			}

			if ( $hide_no_image == 'yes' && version_compare( WC()->version, '2.6', '<' ) ) {
				add_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ), 10, 3 );
			}

			if ( apply_filters( 'yith_wcbr_return_on_empty_include', false ) && isset( $include ) && empty( $include ) ) {
				return '';
			}

			// retrieve elements
			$terms = yith_wcbr_get_terms(
				YITH_WCBR::$brands_taxonomy,
				array_merge(
					array(
						'hide_empty' => $hide_empty == 'yes',
						'include'    => isset( $include ) ? $include : array(),
						'orderby'    => isset( $orderby ) ? $orderby : 'none',
						'order'      => isset( $order ) ? $order : 'ASC',
						'meta_query' => ( $hide_no_image == 'yes' && ! version_compare( WC()->version, '2.6', '<' ) ) ? array(
							array(
								'key'     => 'thumbnail_id',
								'value'   => 0,
								'compare' => '!='
							)
						) : array()
					),
					! empty( $brand ) && $brand != 'all' ? array( 'slug' => explode( ',', $brand ) ) : array(),
					! empty( $parent ) ? array( 'parent' => $parent ) : array()
				)
			);

			if ( $hide_no_image == 'yes' && version_compare( WC()->version, '2.6', '<' ) ) {
				remove_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ) );
			}

			if ( is_wp_error( $terms ) ) {
				return '';
			}

			$atts['terms'] = $terms;

			$template_name = 'brand-thumbnail-carousel.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$template = ob_get_clean();

			// let third party plugin perform actions after shortcode handling
			do_action( 'yith_wcbr_after_shortcode', 'brand_thumbnail_carousel', $atts );

			return $template;
		}

		/**
		 * Returns output for brand product
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_product( $atts ) {
			global $wp_query, $product;

			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $per_page
			 * @var $pagination
			 * @var $cols
			 * @var $autosense_brand
			 * @var $brand
			 * @var $category
			 * @var $autosense_category
			 * @var $product_type
			 * @var $orderby
			 * @var $order
			 * @var $hide_free
			 * @var $show_hidden
			 * @var $show_brand_box
			 */

			$defaults = array(
				'title'              => '',
				'per_page'           => - 1,
				// int (-1 for all available)
				'pagination'         => 'yes',
				// yes - no
				'cols'               => 4,
				// int
				'autosense_brand'    => 'no',
				// yes - no (if yes, on product brand page, ignores "category" options, and shows only products for current brand; same happens on single product page with current product brands)
				'brand'              => 'all',
				// string (comma separated list of valid brand slug)
				'category'           => 'all',
				// all - string (comma separated list of valid category slug)
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category; same happens on single product page with current product brands)
				'product_type'       => 'all',
				// featured - on_sale - all
				'orderby'            => 'rand',
				// rand - date - title - price - sales
				'order'              => 'asc',
				// asc - desc
				'hide_free'          => 'no',
				// yes - no
				'show_hidden'        => 'no',
				// yes - no
				'show_brand_box'     => 'yes',
				// yes - no
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// make attributes available
			extract( $atts );

			$current_page = max( 1, get_query_var( 'paged' ) );

			$query_args = array(
				'posts_per_page' => $per_page,
				'paged'          => $current_page,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'order'          => $order,
				'tax_query'      => array(
					'relation' => 'AND'
				)
			);

			if ( ( ! empty( $brand ) && $brand != 'all' ) || ( $autosense_brand == 'yes' && is_tax( YITH_WCBR::$brands_taxonomy ) ) || ( $autosense_brand == 'yes' && is_product() ) ) {

				if ( $autosense_brand == 'yes' && is_tax( YITH_WCBR::$brands_taxonomy ) ) {
					$brands = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_brand == 'yes' && is_product() ) {
					$brands = wp_get_post_terms( yit_get_product_id( $product ), YITH_WCBR::$brands_taxonomy, array( 'fields' => 'slugs' ) );
				} else {
					$brands = explode( ',', $brand );
				}

				$query_args['tax_query'][] = array(
					'taxonomy' => YITH_WCBR::$brands_taxonomy,
					'field'    => 'slug',
					'terms'    => $brands
				);
			}

			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {

				if ( $autosense_brand == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => ! is_array( $categories ) ? explode( ',', $categories ) : $categories
				);


			}
			if ( isset( $show_hidden ) && $show_hidden == 'no' ) {
				$query_args                = yit_product_visibility_meta( $query_args );
				$query_args['post_parent'] = 0;
			}

			if ( isset( $hide_free ) && $hide_free == 'yes' ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}

			switch ( $product_type ) {

				case 'featured':
					$query_args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes'
					);
					break;

				case 'on_sale' :
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;

				default:
					break;
			}

			switch ( $orderby ) {

				case 'rand':
					$query_args['orderby'] = 'rand';
					break;

				case 'date':
					$query_args['orderby'] = 'date';
					break;

				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;

				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;

				case 'title' :
					$query_args['orderby'] = 'title';
			}

			if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				if ( version_compare( WC()->version, '2.7.0', '<' ) ) {
					$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
				} elseif ( taxonomy_exists( 'product_visibility' ) ) {
					$query_args['tax_query'][] = array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'outofstock',
							'operator' => 'NOT IN',
						),
					);
				}
			}

			$query = new WP_Query( $query_args );

			if ( $pagination == 'yes' ) {
				$count = $query->found_posts;

				$pages = ceil( $count / $per_page );

				if ( $current_page > $pages ) {
					$current_page = $pages;
				}

				if ( $pages > 1 ) {
					$page_links = paginate_links( array(
						'base'      => esc_url( add_query_arg( array( 'paged' => '%#%' ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $pages,
						'show_all'  => true,
						'prev_text' => '<',
						'next_text' => '>'
					) );

					$atts['page_links'] = $page_links;
				}

				$atts['count']        = $count;
				$atts['pages']        = $pages;
				$atts['current_page'] = $current_page;
			}

			$atts['products'] = $query;

			$template_name = 'brand-product.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			return ob_get_clean();
		}

		/**
		 * Returns output for brand product carousel
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_product_carousel( $atts ) {
			global $wp_query, $product, $woocommerce_loop;

			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $per_page
			 * @var $cols
			 * @var $direction
			 * @var $autoplay
			 * @var $pagination
			 * @var $pagination_style
			 * @var $prev_next
			 * @var $prev_next_style
			 * @var $brand
			 * @var $autosense_brand
			 * @var $category
			 * @var $autosense_category
			 * @var $product_type
			 * @var $orderby
			 * @var $order
			 * @var $hide_free
			 * @var $show_hidden
			 * @var $show_brand_box
			 * @var $style
			 * @var $loop
			 */

			$defaults = array(
				'title'              => '',
				'per_page'           => - 1,
				// int (-1 for all available)
				'cols'               => 4,
				// int
				'direction'          => 'horizontal',
				// horizontal - vertical
				'autoplay'           => 'yes',
				// yes - no
				'pagination'         => 'yes',
				// yes - no
				'pagination_style'   => 'round',
				// round - square
				'prev_next'          => 'yes',
				// yes - no
				'prev_next_style'    => 'round',
				// round - square
				'brand'              => 'all',
				// string (comma separated list of valid brand slug)
				'autosense_brand'    => 'no',
				// yes - no (if yes, on product brand page, ignores "category" options, and shows only products for current brand; same happens on single product page with current product brands)
				'category'           => 'all',
				// all - string (comma separated list of valid category slug)
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category; same happens on single product page with current product brands)
				'product_type'       => 'all',
				// featured - on_sale - all
				'orderby'            => 'rand',
				// rand - date - title - price - sales
				'order'              => 'asc',
				// asc - desc
				'hide_free'          => 'no',
				// yes - no
				'show_hidden'        => 'no',
				// yes - no
				'show_brand_box'     => 'yes',
				// yes - no
				'style'              => 'default',
				// default - square - round
				'loop'               => 'no'
				// yes - no (whether carousel should be circular)
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// make attributes available
			extract( $atts );

			$query_args = array(
				'posts_per_page' => $per_page,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'no_found_rows'  => 1,
				'order'          => $order,
				'tax_query'      => array(
					'relation' => 'AND'
				)
			);

			if ( ( ! empty( $brand ) && $brand != 'all' ) || ( $autosense_brand == 'yes' && is_tax( YITH_WCBR::$brands_taxonomy ) ) || ( $autosense_brand == 'yes' && is_product() ) ) {

				if ( $autosense_brand == 'yes' && is_tax( YITH_WCBR::$brands_taxonomy ) ) {
					$brands = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_brand == 'yes' && is_product() ) {
					$brands = wp_get_post_terms( yit_get_product_id( $product ), YITH_WCBR::$brands_taxonomy, array( 'fields' => 'slugs' ) );
				} else {
					$brands = explode( ',', $brand );
				}
				$query_args['tax_query'][] = array(
					'taxonomy' => YITH_WCBR::$brands_taxonomy,
					'field'    => 'slug',
					'terms'    => $brands
				);

			} else { //get all brands

				$all_brands = yith_wcbr_get_terms( YITH_WCBR::$brands_taxonomy, array(
					'hide_empty' => true,
					'field'      => 'slug',
				) );

				$brands = array();
				foreach ( $all_brands as $brand ) {
					$brands[] = $brand->slug;
				}

				$query_args['tax_query'][] = array(
					'taxonomy' => YITH_WCBR::$brands_taxonomy,
					'field'    => 'slug',
					'terms'    => $brands
				);
			}

			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {

				if ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $categories
				);
			}

			if ( isset( $show_hidden ) && $show_hidden == 'no' ) {
				$query_args                = yit_product_visibility_meta( $query_args );
				$query_args['post_parent'] = 0;
			}

			if ( isset( $hide_free ) && $hide_free == 'yes' ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}

			switch ( $product_type ) {

				case 'featured':
					$query_args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes'
					);
					break;

				case 'on_sale' :
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;

				default:
					break;
			}

			switch ( $orderby ) {

				case 'rand':
					$query_args['orderby'] = 'rand';
					break;

				case 'date':
					$query_args['orderby'] = 'date';
					break;

				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;

				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;

				case 'title' :
					$query_args['orderby'] = 'title';
			}

			if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				if ( version_compare( WC()->version, '2.7.0', '<' ) ) {
					$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
				} elseif ( taxonomy_exists( 'product_visibility' ) ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'outofstock',
							'operator' => 'NOT IN',
						),
					);
				}
			}

			$atts['products'] = new WP_Query( $query_args );

			$template_name = 'brand-product-carousel.php';

			ob_start();

			$old_woocommerce_loop = $woocommerce_loop;
			/**
			 * Since 1.0.5
			 *
			 * @param $woocommerce_loop mixed Woocommerce loop global
			 * @param $plugin_slug      string Current plugin slug
			 */
			$woocommerce_loop = apply_filters( 'yith_customize_product_carousel_loop', $woocommerce_loop, YITH_WCBR_SLUG );

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$woocommerce_loop = $old_woocommerce_loop;

			return ob_get_clean();
		}

		/**
		 * Returns output for brand select
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_select( $atts ) {
			global $wp_query, $product;

			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $autosense_category
			 * @var $category
			 * @var $show_count
			 * @var $hide_empty
			 * @var $brand
			 * @var $parent
			 * @var $orderby
			 * @var $order
			 */

			$defaults = array(
				'title'              => '',
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'show_count'         => 'yes',
				// yes - no
				'hide_empty'         => 'no',
				// yes - no
				'brand'              => 'all',
				// brands slug to include
				'parent'             => '',
				// parent to match for terms (term id)
				'orderby'            => 'none',
				// terms ordering name - slug - term_group - term_id - id - description
				'order'              => 'ASC'
				// order ascending or descending
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// let third party plugin perform actions before shortcode handling
			do_action( 'yith_wcbr_before_shortcode', 'brand_select', $atts );

			// make attributes available
			extract( $atts );

			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {
				$include = array();

				if ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				if ( ! empty( $categories ) ) {
					$brand_category_relationship = YITH_WCBR_Premium()->get_category_brand_relationships();

					foreach ( $categories as $category_slug ) {
						$category = get_term_by( 'slug', $category_slug, 'product_cat' );

						if ( $category && isset( $brand_category_relationship[ $category->term_id ] ) ) {
							$include = array_merge( $include, $brand_category_relationship[ $category->term_id ] );
						}
					}
				}
			}

			if ( apply_filters( 'yith_wcbr_return_on_empty_include', false ) && isset( $include ) && empty( $include ) ) {
				return '';
			}

			// retrieve elements
			$terms = yith_wcbr_get_terms(
				YITH_WCBR::$brands_taxonomy,
				array_merge(
					array(
						'hide_empty' => $hide_empty == 'yes',
						'include'    => isset( $include ) ? $include : array(),
						'orderby'    => isset( $orderby ) ? $orderby : 'none',
						'order'      => isset( $order ) ? $order : 'ASC'
					),
					! empty( $brand ) && $brand != 'all' ? array( 'slug' => explode( ',', $brand ) ) : array(),
					! empty( $parent ) ? array( 'parent' => $parent ) : array()
				)
			);

			if ( is_wp_error( $terms ) ) {
				return '';
			}

			$atts['terms'] = $terms;

			$template_name = 'brand-select.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$template = ob_get_clean();

			// let third party plugin perform actions after shortcode handling
			do_action( 'yith_wcbr_after_shortcode', 'brand_select', $atts );

			return $template;
		}

		/**
		 * Returns output for brand list
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_list( $atts ) {
			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $autosense_category
			 * @var $category
			 * @var $per_page
			 * @var $pagination
			 * @var $show_count
			 * @var $hide_empty
			 * @var $style
			 * @var $highlight_color
			 * @var $brand
			 * @var $parent
			 * @var $orderby
			 * @var $order
			 */

			$defaults = array(
				'title'              => '',
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'per_page'           => - 1,
				// int
				'pagination'         => 'no',
				// yes - no
				'show_count'         => 'yes',
				// yes - no
				'hide_empty'         => 'no',
				// yes - no
				'style'              => 'default',
				// default - big-header - small-header - shadow - boxed - highlight
				'highlight_color'    => '#ffd900',
				// hex color code (only for highlight style)
				'brand'              => 'all',
				// brands slug to include
				'parent'             => '',
				// parent to match for terms (term id)
				'orderby'            => 'none',
				// terms ordering name - slug - term_group - term_id - id - description
				'order'              => 'ASC'
				// order ascending or descending
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			return YITH_WCBR_Shortcode_Premium::brand_filter( array_merge( $atts, array( 'show_filter' => 'no' ) ) );
		}

		/**
		 * Returns output for brand grid
		 *
		 * @param $atts mixed Array of shortcodes attributes
		 *
		 * @return string Shortcode content
		 * @since 1.0.0
		 */
		public static function brand_grid( $atts ) {
			global $wp_query, $product;
			/**
			 * The following variables will be extracted from $atts
			 * @var $title
			 * @var $cols
			 * @var $show_count
			 * @var $hide_empty
			 * @var $show_image
			 * @var $hide_no_image
			 * @var $show_name
			 * @var $brand
			 * @var $parent
			 * @var $autosense_category
			 * @var $category
			 * @var $show_filtered_by
			 * @var $show_category_filter
			 * @var $show_name_filter
			 * @var $show_all_letters
			 * @var $category_filter_type
			 * @var $category_filter_style
			 * @var $category_filter_default
			 * @var $use_filtered_urls
			 */
			$defaults = array(
				'title'         => '',
				'cols'          => 4,
				// int
				'show_count'    => 'yes',
				// yes - no
				'hide_empty'    => 'no',
				// yes - no
				'show_image'    => 'yes',
				// yes - no
				'hide_no_image' => 'no',
				// yes - no
				'show_name'     => 'yes',
				// yes - no
				'brand'         => 'all',
				// brands slug to include
				'parent'        => '',
				// parent to match for terms (term id)
				'category'           => 'all',
				// all - string (comma separated list of valid category slug)
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category; same happens on single product page with current product brands)
				'show_filtered_by'        => 'name',
				// none - name - category

				// when filtered by name
				'show_category_filter'    => 'yes',
				// yes - no
				'show_name_filter'        => 'yes',
				// yes - no
				'show_all_letters'        => 'yes',
				// yes - no

				// when filtered by category
				'category_filter_type'    => 'multiselect',
				// multiselect - dropdown
				'category_filter_style'   => 'default',
				// default - shadow - border - round
				'category_filter_default' => '',
				// any valid product category id; leave empty to use "all" as default
				'use_filtered_urls'       => 'no'
				// yes - no; whether to use plain brands' url or layared nav urls to see products for brand/category pair
			);

			$atts = shortcode_atts(
				$defaults,
				$atts
			);

			// let third party plugin perform actions before shortcode handling
			do_action( 'yith_wcbr_before_shortcode', 'brand_grid', $atts );

			// make attributes available
			extract( $atts );

			if ( $hide_no_image == 'yes' && version_compare( WC()->version, '2.6', '<' ) ) {
				add_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ), 10, 3 );
			}


			// sets category filter variables
			if ( ( ! empty( $category ) && $category != 'all' ) || ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) || ( $autosense_category == 'yes' && is_product() ) ) {
				$include = array();

				if ( $autosense_category == 'yes' && is_tax( 'product_cat' ) ) {
					$categories = array( get_query_var( $wp_query->query_vars['taxonomy'] ) );
				} elseif ( $autosense_category == 'yes' && is_product() ) {
					$categories = wp_get_post_terms( yit_get_product_id( $product ), 'product_cat', array( 'fields' => 'slugs' ) );
				} else {
					$categories = explode( ',', $category );
				}

				if ( ! empty( $categories ) ) {
					$brand_category_relationship = YITH_WCBR_Premium()->get_category_brand_relationships();

					foreach ( $categories as $category_slug ) {
						$category = get_term_by( 'slug', $category_slug, 'product_cat' );

						if ( $category && isset( $brand_category_relationship[ $category->term_id ] ) ) {
							$include = array_merge( $include, $brand_category_relationship[ $category->term_id ] );
						}
					}
				}
			}

			// retrieve elements
			$terms = yith_wcbr_get_terms(
				YITH_WCBR::$brands_taxonomy,
				apply_filters( 'yith_wcbr_brand_grid_get_terms_args', array_merge(
					array(
						'orderby'    => 'slug',
						'include'    => isset( $include ) ? $include : array(),
						'hide_empty' => $hide_empty == 'yes',
						'meta_query' => ( $hide_no_image == 'yes' && ! version_compare( WC()->version, '2.6', '<' ) ) ? array(
							array(
								'key'     => 'thumbnail_id',
								'value'   => 0,
								'compare' => '!='
							)
						) : array()
					),
					! empty( $brand ) && $brand != 'all' ? array( 'slug' => explode( ',', $brand ) ) : array(),
					! empty( $parent ) ? array( 'parent' => $parent ) : array()
				) )
			);

			if ( $hide_no_image == 'yes' && version_compare( WC()->version, '2.6', '<' ) ) {
				remove_filter( 'terms_clauses', array( YITH_WCBR_Premium(), 'filter_term_without_image' ) );
			}

			if ( is_wp_error( $terms ) ) {
				return '';
			}

			// sort terms
			uasort( $terms, array( 'YITH_WCBR_Shortcode_Premium', 'compare_terms_heading' ) );

			// let third party plugin customize term list
			$terms         = apply_filters( 'yith_wcbr_brand_filter_terms', $terms );
			$atts['terms'] = $terms;


			// if name filters enabled, retrieve heading letter
			$available_filters = array();
			$filtered_terms    = array();
			$stack             = explode( ' ', apply_filters( 'yith_wcbr_brand_filter_heading_letters', 'a b c d e f g h i j k l m n o p q r s t u v w x y z' ) );

			if ( $show_filtered_by == 'name' ) {
				foreach ( $terms as & $term ) {
					$heading_letter = apply_filters( 'yith_wcbr_brand_filter_heading_letter', strtolower( mb_substr( $term->name, 0, 1 ) ), $term->name );

					if ( ! in_array( $heading_letter, $stack ) && ! in_array( '123', $available_filters ) ) {
						$available_filters[] = '123';
						$term->heading       = '123';
					} else {
						if ( ! in_array( $heading_letter, $available_filters ) ) {
							$available_filters[] = $heading_letter;
						}

						$term->heading = $heading_letter;
					}

					if ( isset( $filtered_terms[ $term->heading ] ) ) {
						$filtered_terms[ $term->heading ][] = $term;
					} else {
						$filtered_terms[ $term->heading ] = array( $term );
					}
				}

				ksort( $filtered_terms );
				foreach ( $filtered_terms as $heading_letter => & $terms_array ) {
					uasort( $terms_array, array( 'YITH_WCBR_Shortcode_Premium', 'compare_terms_heading' ) );
					// let third party plugin customize term list
					$filtered_terms = apply_filters( 'yith_wcbr_brand_filter_filtered_terms', $filtered_terms );
				}
				asort( $stack );

				$atts['filtered_terms']    = $filtered_terms;
				$atts['available_filters'] = $available_filters;
			}

			if ( $show_name_filter == 'yes' ) {
				$atts['stack'] = ( $show_all_letters == 'yes' ) ? array_merge( $stack, array( '123' ) ) : $available_filters;
			}

			// if category filters enabled, retrieve category-brand relation
			$brand_category_relationship = YITH_WCBR_Premium()->get_brand_category_relationships();

			if ( $show_filtered_by == 'category' ) {
				foreach ( $terms as & $term ) {
					if ( isset( $brand_category_relationship[ $term->term_id ] ) ) {
						foreach ( $brand_category_relationship[ $term->term_id ] as $category_id ) {
							if ( ! in_array( $category_id, $available_filters ) ) {
								$available_filters[] = $category_id;
							}

							if ( isset( $filtered_terms[ $category_id ] ) ) {
								$filtered_terms[ $category_id ][] = $term;
							} else {
								$filtered_terms[ $category_id ] = array( $term );
							}
						}
					}
				}

				$category_ids   = array_keys( $filtered_terms );
				$sorted_filters = yith_wcbr_get_terms( 'product_cat', array(
					'include' => $category_ids,
					'orderby' => 'name',
					'fields'  => 'id=>name'
				) );

				asort( $sorted_filters );
				$sorted_filters = array_keys( $sorted_filters );

				$filtered_sorted_terms = array();
				foreach ( $sorted_filters as $category_id ) {
					if ( ! isset( $filtered_terms[ $category_id ] ) ) {
						continue;
					}

					$filtered_sorted_terms[ $category_id ] = $filtered_terms[ $category_id ];
				}

				$atts['filtered_terms']    = $filtered_sorted_terms;
				$atts['available_filters'] = $sorted_filters;
			}

			if ( $show_category_filter == 'yes' ) {
				$default_category          = new stdClass();
				$default_category->term_id = 0;
				$default_category->name    = apply_filters( 'yith_wcbr_default_category_name', __( 'All', 'yith-woocommerce-brands-add-on' ) );

				$atts['brand_category_relationship'] = $brand_category_relationship;
				$atts['categories']                  = array_merge(
					array( $default_category ),
					yith_wcbr_get_terms(
						'product_cat',
						array(
							'hide_empty' => 'yes'
						)
					)
				);
			}

			$atts['cols_width'] = floor( 100 / intval( $cols ) );

			$template_name = 'brand-grid.php';

			ob_start();

			yith_wcbr_get_template( $template_name, $atts, 'shortcodes' );

			$template = ob_get_clean();

			// let third party plugin perform actions after shortcode handling
			do_action( 'yith_wcbr_after_shortcode', 'brand_grid', $atts );

			return $template;
		}

		/* === HELPER METHODS === */

		/**
		 * Used to compare terms by heading, whenever terms need to be ordered by custom heading letter
		 *
		 * @param $term_1 \WP_Term First term of comparison
		 * @param $term_2 \WP_Term Second term of comparison
		 *
		 * @return int -1/0/1 whether first term is minor/equal/major of second term
		 *
		 * TODO: remove this function, if possible, replacing it with orderby prop in yit_get_terms function (this will work with custom sorting)
		 *
		 * @since 1.0.9
		 */
		public static function compare_terms_heading( $term_1, $term_2 ) {
			return strcmp( strtolower( $term_1->name ), strtolower( $term_2->name ) );
		}
	}
}