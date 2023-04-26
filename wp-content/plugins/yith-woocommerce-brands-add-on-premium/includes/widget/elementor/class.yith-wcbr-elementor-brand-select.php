<?php
/**
 * Brand Select widget for Elementor
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Select' ) ) {
	class YITH_WCBR_Elementor_Brand_Select extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Select widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_select';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Select widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return _x( 'YITH Brand Select', 'Elementor widget name', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Select widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-nav-menu';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Select widget belongs to.
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
		 * Register YITH_WCBR_Elementor_Brand_Select widget controls.
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
				'show_count',
				[
					'label'   => _x( 'Show items count for each brand', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Show items count', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show items count', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'hide_empty',
				[
					'label'   => _x( 'Hide brands with no product', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Hide empty brands', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not hide empty brands', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
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
				'brand',
				[
					'label'   => _x( 'Comma separated list of brands slugs to sho', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				]
			);

			$this->add_control(
				'parent',
				[
					'label'   => _x( 'Parent ID that terms must match', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
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
						'none'        => _x( 'None', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'name'        => _x( 'Name', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'slug'        => _x( 'Slug', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'term_group'  => _x( 'Term Group', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'term_id'     => _x( 'Term ID', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
						'description' => _x( 'Description', '[Elementor]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'none',
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
		 * Render YITH_WCBR_Elementor_Brand_Select widget output on the frontend.
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

			echo do_shortcode( "[yith_wcbr_brand_select {$attribute_string}]" );
		}

	}
}