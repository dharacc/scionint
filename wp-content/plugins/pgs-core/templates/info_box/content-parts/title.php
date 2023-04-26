<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

$style = '';

if ( isset( $title ) && ! empty( $title ) ) {
	if ( isset( $title_color ) && ! empty( $title_color ) ) {
		$style = "color:$title_color;";
	}
	if ( isset( $add_anchor ) && $add_anchor == true ) {
		$anchor_link  = vc_build_link( $anchor_link );
		$target       = empty( $anchor_link['target'] ) ? '_blank' : $anchor_link['target'];
		$anchor_title = empty( $anchor_link['title'] ) ? $title : $anchor_link['title'];
		?>
		<<?php echo esc_html( $title_el ); ?> class="pgscore_info_box-title">
			<a href="<?php echo esc_url( $anchor_link['url'] ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php echo esc_attr( $anchor_title ); ?>" style="<?php echo esc_attr( $style ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>
		</<?php echo esc_html( $title_el ); ?>>
		<?php
	} else {
		?>
		<<?php echo esc_html( $title_el ); ?> class="pgscore_info_box-title" style="<?php echo esc_attr( $style ); ?>">
			<?php echo esc_html( $title ); ?>
		</<?php echo esc_html( $title_el ); ?>>
		<?php
	}
}
