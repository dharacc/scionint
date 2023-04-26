<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {
	return array(
		'id'               => 'woocommerce_swatch_settings',
		'title'            => esc_html__( 'Swatch Settings', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'    => 'cs_swatches_attribute_style_info',
				'type'  => 'info',
				'title' => __( 'Notice', 'pgs-core' ),
				'style' => 'warning',
				'icon'  => 'el el-info-circle',
				'desc'  => esc_html__( 'Make sure you have enabled swatch settings in Products > Attributes > Enable Swatch?".', 'pgs-core' ),
			),
			array(
				'id'       => 'cs_display_variation_on_list',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show variation on shop page', 'pgs-core' ),
				'subtitle' => esc_html__( 'If enabled, it will display product variations on listing page.', 'pgs-core' ),
				'default'  => false,
			),
			array(
				'id'    => 'info_warning',
				'type'  => 'info',
				'title' => __( 'Notice', 'pgs-core' ),
				'style' => 'warning',
				'desc'  => __( 'This option will work only with "Standard Info Transparent" product hover style.', 'pgs-core' ),
				'icon'  => 'el el-info-circle',
			),
			array(
				'id'       => 'cs_grid_swatches_attribute',
				'type'     => 'select',
				'title'    => esc_html__( 'Grid swatch attribute to display.', 'pgs-core' ),
				'subtitle' => esc_html__( 'Choose attribute to display on the products grid listing.', 'pgs-core' ),
				'options'  => ciyashop_get_product_attr_array(),
			),
		),
	);
}
