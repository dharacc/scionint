<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_multi_tab_products_listing'] );
extract( $atts );

$tab_items = '';
if ( 'categories' === $tabs_source ) {
	$tab_items = $tabs_source_categories;
} elseif ( 'product_types' === $tabs_source ) {
	$tab_items = $tabs_source_product_types;
}
$tab_items = explode( ',', $tab_items );

$tabs_classes = array(
	'nav',
	'mtpl-tabs',
);

if ( 'intro' === $tabs_position ) {
	$tabs_classes[] = 'flex-column';
} else {
	$tabs_classes[] = 'mtpl-tabs--tabs_position-' . $tabs_position;
	$tabs_classes[] = 'mtpl-tabs--tabs_alignment-' . $tabs_alignment;
	$tabs_classes[] = 'mtpl-tabs--tabs_style-' . $top_tabs_style;
	if ( 'center' === $tabs_alignment ) {
		$tabs_classes[] = 'justify-content-center';
	} elseif ( 'right'=== $tabs_alignment ) {
		$tabs_classes[] = 'justify-content-end';
	}
}
$tabs_classes = implode( ' ', array_filter( array_unique( $tabs_classes ) ) );
?>
<ul class="<?php echo esc_attr( $tabs_classes ); ?>">
	<?php
	$tab_nav_sr = 1;
	foreach ( $tabs_data as $tab_item ) {

		$tab_link = '#mtpl-' . $index . '-tab-' . $tab_item['tab_slug'];
		$arrow_id = 'mtpl-' . $index . '-arrow-' . $tab_item['tab_slug'];

		$mtpl_tab_link_classes = array(
			'nav-link',
			'mtpl-tab-link',
		);

		$color = '';
		if ( $enable_intro == 'true' && 'intro' === $tabs_position ) {
			$mtpl_tab_link_classes[] = 'mtpl-intro-tab-link';
			$color                   = 'color:' . ( ( $tab_nav_sr == 1 ) ? $tab_link_active_color : $tab_link_color ) . ';';
		}

		$tab_item_active = '';
		if ( $tab_nav_sr == 1 ) {
			$mtpl_tab_link_classes[] = 'active';
		}

		$mtpl_tab_link_classes = implode( ' ', array_filter( array_unique( $mtpl_tab_link_classes ) ) );
		?>
		<li class="nav-item mtpl-tab">
			<a class="<?php echo esc_attr( $mtpl_tab_link_classes ); ?>" href="<?php echo esc_url( $tab_link ); ?>" data-toggle="tab" data-arrow_target="<?php echo esc_attr( $arrow_id ); ?>" data-link_color="<?php echo esc_attr( $tab_link_color ); ?>" data-active_link_color="<?php echo esc_attr( $tab_link_active_color ); ?>" style="<?php echo esc_attr( $color ); ?>">
				<?php echo esc_html( $tab_item['tab_name'] ); ?>
			</a>
		</li>
		<?php
		$tab_nav_sr++;
	}
	?>
</ul>
