<?php
global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_callout'] );
extract( $atts );

$callout_button_link = vc_build_link( $callout_button_link );
$button_target       = 0;
if ( ! empty( $callout_button_link['target'] ) ) {
	$button_target = 1;
}
$callout_button_title = $callout_button_link['title'];

if ( isset( $callout_button_link['url'] ) && $callout_button_link['url'] ) {
	$callout_button_link = $callout_button_link['url'];
} else {
	$callout_button_link = '#';
}

$text_styles = array();
if ( $callout_button_text_color ) {
	$text_styles[] = "color:{$callout_button_text_color}";
}

if ( 'default' === $callout_button_type && $callout_button_background_color ) {
	$text_styles[] = "background:{$callout_button_background_color}";
}

if ( 'border' === $callout_button_type && $callout_button_border_color ) {
	$text_styles[] = "border-color:{$callout_button_border_color}";
}
$text_styles = implode( ';', array_filter( array_unique( $text_styles ) ) );

$hover_styles = array();
if ( $callout_button_text_hover_color ) {
	$hover_styles['color'] = $callout_button_text_hover_color;
}

if ( 'default' === $callout_button_type && $callout_button_background_hover_color ) {
	$hover_styles['background'] = $callout_button_background_hover_color;
}

if ( 'border' === $callout_button_type && $callout_button_border_hover_color ) {
	$hover_styles['border-color'] = $callout_button_border_hover_color;
}

$prehover_style = array();
if ( $callout_button_text_color ) {
	$prehover_style['color'] = $callout_button_text_color;
}

if ( 'default' === $callout_button_type && $callout_button_background_color ) {
	$prehover_style['background'] = $callout_button_background_color;
}

if ( 'border' === $callout_button_type && $callout_button_border_color ) {
	$prehover_style['border-color'] = $callout_button_border_color;
}

$buttonclass = '';
if ( 'border' === $callout_button_type ) {
	$buttonclass = 'pgscore_button_border';
} elseif ( 'simple' === $callout_button_type ) {
	$buttonclass = 'pgscore_button_simple';
} else {
	$buttonclass = 'pgscore_button_default';
}
?>

<div class="callout">
	<?php
	if ( $callout_icon ) {
		?>
		<div class="callout-icon callout-icon-size-<?php echo esc_attr( $callout_icon_size ); ?>">
			<?php echo $icon_html; ?>
		</div>	
		<?php 
	}
	?>
	<div class="callout-info">
		<div class="callout-content">
			<<?php echo esc_html( $callout_title_element_tag ); ?> style="color:<?php echo esc_attr( $callout_title_color ); ?>" class="callout-title">
				<?php echo esc_html( $callout_title ); ?>
			</<?php echo esc_html( $callout_title_element_tag ); ?>> 
			<p><?php echo esc_html( $callout_description ); ?></p>
		</div>
		<?php
		if ( $callout_button_title ) {
			?>
			<div class="callout-btn <?php echo esc_attr( $buttonclass ); ?>">
				<a <?php echo ( $button_target ) ? 'target="_blank"' : ''; ?> style="<?php echo esc_attr( $text_styles ); ?>" class="inline_hover" data-hover_styles="<?php echo esc_attr( json_encode( $hover_styles ) ); ?>" data-prehover_style="<?php echo esc_attr( json_encode( $prehover_style ) ); ?>" href="<?php echo esc_attr( $callout_button_link ); ?>">
					<?php echo esc_html( $callout_button_title ); ?>
				</a>
			</div>
			<?php 
		}
		?>
	</div>
</div>
