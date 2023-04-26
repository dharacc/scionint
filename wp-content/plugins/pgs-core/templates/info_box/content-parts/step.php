<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

$step_wrapper_styles = array();
$step_styles         = array();

if ( 'style_4' === $layout && $style_4_step_color && trim( $style_4_step_color ) != false ) {
	$step_styles['color'] = "color:{$style_4_step_color};";
} elseif ( 'style_5' === $layout && $style_5_step_color && trim( $style_5_step_color ) != false ) {
	$step_styles['color'] = "color:{$style_5_step_color};";
}

$step_wrapper_styles = implode( ' ', array_filter( array_unique( $step_wrapper_styles ) ) );
$step_styles         = implode( ' ', array_filter( array_unique( $step_styles ) ) );

if ( $enable_step == 'true' || 'style_4' === $layout || 'style_5' === $layout ) {
	if ( ( 'style_4' === $layout || 'style_5' === $layout ) && isset( $step_4_5 ) ) {
		$step = $step_4_5;
	}
	?>
	<div class="pgscore_info_box-step-wrapper" style="<?php echo esc_attr( $step_wrapper_styles ); ?>">
		<?php
		if ( ( 'style_4' === $layout || 'style_5' === $layout ) && isset( $step_tag ) ) {
			?>
			<<?php echo esc_html( $step_tag ); ?> class="pgscore_info_box-step" style="<?php echo esc_attr( $step_styles ); ?>">
				<?php echo esc_html( $step ); ?>
			</<?php echo esc_html( $step_tag ); ?>>
			<?php
		} else {
			?>
			<span class="pgscore_info_box-step" style="<?php echo esc_attr( $step_styles ); ?>">
			<?php echo esc_html( $step ); ?>
			</span>
			<?php
		}
		?>
	</div>
	<?php
}
