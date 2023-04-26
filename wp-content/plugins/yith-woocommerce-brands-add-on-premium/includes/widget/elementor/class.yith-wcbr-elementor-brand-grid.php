<?php
/**
 * Brand Grid widget for Elementor
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Grid' ) ) {
	class YITH_WCBR_Elementor_Brand_Grid extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_grid';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return _x( 'YITH Brand Grid', 'Elementor widget name', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-gallery-grid';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Grid widget belongs to.
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
		 * Register YITH_WCBR_Elementor_Brand_Grid widget controls.
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
				'show_image',
				[
					'label'   => _x( 'Show brand thumbnail', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Show brand image', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show brand image', 'yith-woocommerce-brands-add-on' ),
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

			$this->add_control(
				'cols',
				[
					'label'   => _x( 'Columns', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 4,
				]
			);

			$this->add_control(
				'show_filtered_by',
				[
					'label'   => _x( 'Filter style', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'none'     => _x( 'Do not group brands', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'category' => _x( 'Group brands by category', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'name'     => _x( 'Group brands by initial letter of the name', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'none',
				]
			);

			$this->add_control(
				'show_category_filter',
				[
					'label'   => _x( 'Show categories filters?', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => _x( 'Show category filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'no'  => _x( 'Do not show category filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'show_name_filter',
				[
					'label'   => _x( 'Show name filters?', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => _x( 'Show name filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'no'  => _x( 'Do not show name filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'show_all_letters',
				[
					'label'   => _x( 'Show all letters in filter section', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'multiselect' => _x( 'Multiselect', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'dropdown'    => _x( 'Dropdown', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'category_filter_type',
				[
					'label'   => _x( 'Category filter type', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'yes' => _x( 'Show all filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'no'  => _x( 'Show just not empty filters', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'multiselect',
				]
			);

			$this->add_control(
				'category_filter_style',
				[
					'label'   => _x( 'Category filter style', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'default' => _x( 'Default', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'shadow'  => _x( 'Shadow', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'border'  => _x( 'Border', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'round'   => _x( 'Round', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'default',
				]
			);

			$this->add_control(
				'category_filter_default',
				[
					'label'   => _x( 'Initial selected category', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				]
			);

			$this->add_control(
				'use_filtered_urls',
				[
					'label'   => _x( 'Links redirect customers to shop filtered by brand & category', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'no'  => _x( 'Use plain brand urls', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
						'yes' => _x( 'Use filtered urls', '[gutenberg]: Help text', 'yith-woocommerce-brands-add-on' ),
					],
					'default' => 'default',
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

			$this->end_controls_section();
		}

		/**
		 * Render YITH_WCBR_Elementor_Brand_Grid widget output on the frontend.
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

			echo do_shortcode( "[yith_wcbr_brand_grid {$attribute_string}]" );
		}

	}
}