<?php
$description = '<p>' . wp_kses(
	__( 'You can import pre-defined sample data, as shown on our demo site, from here.', 'pgs-core' ),
	array(
		'br'     => array(),
		'strong' => array(
			'style' => array(),
		),
	)
);

$description_mandetory = '<p><span style="color:#FF0000;">' . wp_kses(
	__( 'Please take a backup before importing any sample data to prevent any data loss during installation.', 'pgs-core' ),
	array(
		'br'     => array(),
		'strong' => array(
			'style' => array(),
		),
	)
) . '</span></p>';

$sample_data_description = $description . $description_mandetory;

if ( ! function_exists( 'ciyashop_is_activated' ) || ! ciyashop_is_activated() ) {
	$fields[] = array(
		'id'    => 'sample_data_license_notice',
		'type'  => 'info',
		'style' => 'critical',
		'desc'  => esc_html__( 'To access sample data, please validate and activate the purchase code, received from ThemeForest while purchased the theme.', 'pgs-core' ),
		'icon'  => 'fa fa-exclamation-triangle',
	);
} else {
	$fields[] = array(
		'id'         => 'pgscore_sample_data_import',
		'type'       => 'tc_sample_import',
		'full_width' => true,
	);
}

return array(
	'title'  => esc_html__( 'Sample Data', 'pgs-core' ),
	'desc'   => $sample_data_description,
	'id'     => 'sample_data',
	'icon'   => 'fa fa-database',
	'fields' => $fields,
);
