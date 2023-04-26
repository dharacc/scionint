<?php
/**
 * Testimonials
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper
 */

$fields = apply_filters(
	'testimonials_custom_meta_page_settings',
	array(
		'id'       => 'testimonials_custom_meta_page_settings',
		'title'    => esc_html__( 'Testimonial Details', 'pgs-core' ),
		'screen'   => array( 'testimonials' ),
		'priority' => 'high',
		'context'  => 'normal',
		'fields'   => array(
			array(
				'heading'   => esc_html__( 'Content', 'pgs-core' ),
				'field_id'  => 'content',
				'type'      => 'textarea',
			),
			array(
				'heading'   => esc_html__( 'Author', 'pgs-core' ),
				'field_id'  => 'author',
				'type'      => 'text',
			),
			array(
				'heading'   => esc_html__( 'Designation', 'pgs-core' ),
				'field_id'  => 'designation',
				'type'      => 'text',
			),
		),
	)
);

pgscf_add_field_group( $fields );
