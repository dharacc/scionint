<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

$attributes = array();

if ( isset( $title ) && ! empty( $title ) ) {
	$style = '';
	if ( isset( $title_color ) && ! empty( $title_color ) ) {
		$style = "color:$title_color;";
	}
	if ( isset( $add_anchor ) && $add_anchor == true ) {
		?>
		<<?php echo esc_html( $title_el ); ?>>
			<?php
			$anchor_link  = vc_build_link( $anchor_link );
			
			if( $anchor_link['url'] ) $attributes[] = 'href="' . esc_url( trim( $anchor_link['url'] ) ) . '"';
			if( $anchor_link['target'] ) $attributes[] = 'target="' . esc_attr( trim( $anchor_link['target'] ) ) . '"';
			if( $anchor_link['title'] ) $attributes[] = 'title="' . esc_attr( trim( $anchor_link['title'] ) ) . '"';
			if( $anchor_link['rel'] ) $attributes[] = 'rel="' . esc_attr( trim( $anchor_link['rel'] ) ) . '"';
			if( $style ) $attributes[] = 'style="' . $style . '"';
			
			$attributes = implode( ' ', $attributes );
			echo '<a class="pgscore_info_box_2-title inline_hover" ' . $attributes . '>' . esc_html( $title ) . '</a>';
			?>
		</<?php echo esc_html( $title_el ); ?>>
		<?php
	} else {
		?>
		<<?php echo esc_html( $title_el ); ?> class="pgscore_info_box_2-title inline_hover" style="<?php echo esc_attr( $style ); ?>">
			<?php echo esc_html( $title ); ?>
		</<?php echo esc_html( $title_el ); ?>>
		<?php
	}
}
