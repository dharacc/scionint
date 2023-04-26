<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_clients'] );
extract( $atts );

$clients_classes = array();

// Banner Classes
$clients_classes[] = 'pgscore_clients';
$clients_classes[] = 'pgscore_clients-list-type-' . $style;
if ( 'grid' === $style ) {
	$clients_classes[] = 'pgscore_clients-grid-column-' . $grid_elements;
}
$clients_classes = implode( ' ', array_filter( array_unique( $clients_classes ) ) );
?>
<div class="<?php echo esc_attr( $clients_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'clients/style/' . $style ); ?>
</div>
