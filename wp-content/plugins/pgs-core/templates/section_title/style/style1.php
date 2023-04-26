<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_section_title'] );
extract( $atts );
$classes = array(
	'pgscore_divider_wrapper',
	'pgscore_divider_' . $section_title_style,
);
if ( isset( $section_alighnment ) && ! empty( $section_alighnment ) ) {
	$classes[] = 'pgscore_divider_alignment_' . $section_alighnment;
}
$classes = implode( ' ', array_filter( array_unique( $classes ) ) );
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<span class="divider-sub-title" style="color:<?php echo esc_attr( $sub_title_color ); ?> ">
		<?php echo esc_html( $sub_title ); ?>
	</span>		
	
	<<?php echo esc_html( $main_title_el ); ?> class="divider-title" style="color:<?php echo esc_attr( $main_title_el_color ); ?>">
		<span>
			<?php echo esc_html( $main_title ); ?>
		</span>
	</<?php echo esc_html( $main_title_el ); ?>>
	<?php
	if ( isset( $section_description ) && ! empty( $section_description ) ) {
		?>
		<p><?php echo esc_html( $section_description ); ?> </p>
		<?php
		}
	?>
</div>
