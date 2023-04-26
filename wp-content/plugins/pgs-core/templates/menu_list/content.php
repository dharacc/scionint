<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_menu_list'] );
extract( $atts );

$menu_list_items = $pgscore_shortcodes['pgscore_menu_list']['menu_list_items'];

if ( ! empty( $menu_list_title ) ) {
	?>
	<div class="pgscore_menu_list-title">
		<?php echo esc_html( $menu_list_title ); ?>
	</div>
	<?php
}
?>

<ul class="pgscore_menu_list menu_list">
	<?php
	$icon_used = array();

	foreach ( $menu_list_items as $list_item ) {
		$li_class = '';
		if ( isset( $list_item['menu_title'] ) && ! empty( $list_item['menu_title'] ) ) {
			$icon_html        = '';
			$icon_class       = '';
			$link_attr        = '';
			$icon_label_class = '';

			if ( ! empty( $list_item['menu_item_link'] ) ) {
				$link_attr = pgscore_vc_link_attr( $list_item['menu_item_link'] );
			}

			if ( ! empty( $list_item['add_icon'] ) && 'true' == $list_item['add_icon'] ) {

				$icon_wrapper                         = false;
				$icon_used[ $list_item['icon_type'] ] = $list_item['icon_type'];

				if ( isset( ${'icon_' . $list_item['icon_type']} ) && ! empty( ${'icon_' . $list_item['icon_type']} ) ) {
					if ( 'pixelicons' === $list_item['icon_type'] ) {
						$icon_wrapper = true;
					}
					$icon_class = $list_item[ 'icon_' . $list_item['icon_type'] ];
				}

				if ( $icon_class ) {
					if ( $icon_wrapper ) {
						$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
					} else {
						$icon_html = '<i class="' . esc_attr( $icon_class ) . '"></i>';
					}
				}
			}

			if ( ! $link_attr ) {
				$li_class = " class='empty-link'";
			}

			?>
			<li<?php echo $li_class; ?>>
				<?php echo ( 'true' == $list_item['add_icon'] && ! empty( $icon_html ) ) ? wp_kses( $icon_html, pgscore_allowed_html( array( 'i', 'span' ) ) ) . ' ' : ''; ?>

				<?php
				if ( $link_attr && isset( $list_item['menu_title'] ) && $list_item['menu_title'] ) {
					?>
					<a class="menu_item_link" <?php echo $link_attr; ?>>
					<?php
				} else {
					?>
					<span class="menu-title">
					<?php
				}

				if ( isset( $list_item['menu_title'] ) && $list_item['menu_title'] ) {
					echo esc_html( $list_item['menu_title'] );
				}

				if ( isset( $list_item['menu_item_label'] ) && $list_item['menu_item_label'] ) {
					$icon_label_class  = 'menu_item_label';
					$icon_label_class .= ' menu_item_label-' . $list_item['menu_item_label_color'];
					?>
					<span class="<?php echo esc_attr( $icon_label_class ); ?>">
						<?php echo esc_html( $list_item['menu_item_label'] ); ?>
					</span>
					<?php
				}

				if ( $link_attr && isset( $list_item['menu_title'] ) && $list_item['menu_title'] ) {
					?>
					</a>
					<?php
				} else {
					?>
					</span>
					<?php
				}
				?>
			</li>
			<?php
		}
	}

	if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && $icon_used ) {
		foreach ( $icon_used as $icon ) {
			if ( $icon !== 'fontawesome' ) {
				vc_icon_element_fonts_enqueue( $icon );
			}
		}
	}

	?>
</ul>
