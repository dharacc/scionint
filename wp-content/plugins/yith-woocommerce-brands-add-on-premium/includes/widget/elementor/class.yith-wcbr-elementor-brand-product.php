<?php
/**
 * Brand Product widget for Elementor
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Product' ) ) {
	class YITH_WCBR_Elementor_Brand_Product extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Product widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_product';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Product widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return _x( 'YITH Brand Products', 'Elementor widget name', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Product widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-products';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Product widget belongs to.
		 *
		 * @return array Widget categories.
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function get_categories() {
			return [ 'general', 'yith' ];
		}

		/**
		 * Register YITH_WCBR_Elementor_Brand_Product widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function _register_controls() {

			$this->start_controls_section(
				'general_section',
				[
					'label' => _x( 'General', 'Elementor section title', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'title',
				[
					'label'       => _x( 'Title', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'input_type'  => 'text',
					'placeholder' => '',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'appearance_section',
				[
					'label' => _x( 'Appearance', 'Elementor section title', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'product_type',
				[
					'label'   => _x( 'Type of products to retrieve', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'all'      => _x( 'All products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'featured' => _x( 'Featured products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'on_sale'  => _x( 'On sale products', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'all',
				]
			);

			$this->add_control(
				'hide_free',
				[
					'label'   => _x( 'Hide free products', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Hide free products', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not hide free products', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'show_hidden',
				[
					'label'   => _x( 'Show hidden products', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Show hidden products', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show hidden products', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'show_brand_box',
				[
					'label'   => _x( 'Show the box containing a list of all matching brands for current product selection', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Show brand box', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show brand box', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'cols',
				[
					'label'   => _x( 'Columns', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 4,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'query_section',
				[
					'label' => _x( 'Query', 'Elementor section title', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'pagination',
				[
					'label'   => _x( 'Paginate items', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'per_page',
				[
					'label'   => _x( 'Items per page', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 5,
				]
			);

			$this->add_control(
				'autosense_category',
				[
					'label'   => _x( 'Autosense category', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Autosense category', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not autosense category', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'category',
				[
					'label'   => _x( 'Comma separated list of categories slugs', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				]
			);

			$this->add_control(
				'autosense_brand',
				[
					'label'   => _x( 'Autosense brand', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Autosense brand', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not autosense brand', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'brand',
				[
					'label'   => _x( 'Comma separated list of brands slugs to sho', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				]
			);

			$this->add_control(
				'orderby',
				[
					'label'   => _x( 'Order by', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'rand'  => _x( 'Random', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'date'  => _x( 'Post date', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'title' => _x( 'Product title', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'price' => _x( 'Product price', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'sales' => _x( 'Sales count', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'rand',
				]
			);

			$this->add_control(
				'order',
				[
					'label'   => _x( 'Order', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'ASC'  => _x( 'Ascending', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'DESC' => _x( 'Descending', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'none',
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render YITH_WCBR_Elementor_Brand_Product widget output on the frontend.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function render() {

			$attribute_string = '';
			$settings         = $this->get_settings_for_display();

			foreach ( $settings as $key => $value ) {
				if ( empty( $value ) || ! is_scalar( $value ) ) {
					continue;
				}
				$attribute_string .= " {$key}=\"{$value}\"";
			}

			echo do_shortcode( "[yith_wcbr_brand_product {$attribute_string}]" );
		}

	}
}