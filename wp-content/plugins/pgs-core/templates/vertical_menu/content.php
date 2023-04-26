<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_vertical_menu'] );
extract( $atts );

if ( ! has_nav_menu( 'shortcode_v_menu' ) ) {
	return;
}

if ( isset( $ciyashop_globals['shortcode_v_menu'] ) ) {
	$ciyashop_globals['shortcode_v_menu'] = $ciyashop_globals['shortcode_v_menu'] + 1;
} else {
	$ciyashop_globals['shortcode_v_menu'] = 1;
}
?>
<div class="pgscore_v_menu">
	<div class="pgscore_v_menu-inner">
		<?php
		if ( $menu_title ) {
			?>
			<div class="pgscore_v_menu-header">
				<i class="fas fa-bars"></i><?php echo esc_html( $menu_title ); ?>
			</div>
			<?php
		}
		?>
		<div class="pgscore_v_menu-main" data-menu_title="<?php echo esc_attr( ( $menu_title ) ? $menu_title : '' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'shortcode_v_menu',
					'container_id'    => 'pgscore_v_menu__menu-' . $ciyashop_globals['shortcode_v_menu'],
					'container_class' => 'pgscore_v_menu__menu_wrap',
					'menu_id'         => 'pgscore_v_menu__nav-' . $ciyashop_globals['shortcode_v_menu'],
					'menu_class'      => 'pgscore_v_menu__nav menu',
				)
			);
			?>
		</div>
	</div>
</div>
