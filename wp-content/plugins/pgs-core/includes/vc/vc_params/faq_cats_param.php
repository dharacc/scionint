<?php
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'faq_cats', 'pgscore_faq_cats_settings_field' );
}
function pgscore_faq_cats_settings_field( $settings, $value ) {
	$cats_output = '<div class="faq_categories">'
				. '<select name="' . $settings['param_name']
				. '" class="wpb_vc_param_value wpb-select dropdown '
				. $settings['param_name'] . ' ' . $settings['type'] . '_field">'
				. '<option value="">All Categories</option>';

	/* Get categories */
	$terms = get_terms(
		'faq-category',
		array(
			'orderby'    => 'name',
			'hide_empty' => true,
		)
	);
	foreach ( $terms as $term ) {
		$cats_output .= '<option value="' . $term->term_id . '"';
		if ( $term->term_id == $value ) {
			$cats_output .= 'selected="selected"';
		}
		$cats_output .= '>' . $term->name . '</option>';
	}
	$cats_output .= '</select>'
					. '</div>';

	return $cats_output;
}
