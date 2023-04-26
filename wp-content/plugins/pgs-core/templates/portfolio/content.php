<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_portfolio'] );
extract( $atts );

$portfolio_style = ( ! empty( $style ) ) ? $style : 'style-1';

$portfolio_classes[] = 'portfolio-' . $portfolio_style;
$portfolio_classes[] = 'portfolio-content-area';
$portfolio_classes[] = 'portfolio-space-' . $portfolio_space;
$portfolio_classes[] = 'popup-gallery';

if ( ! empty( $portfolio_type ) && 'isotope' === $portfolio_type ) {
	$portfolio_classes[]         = 'isotope';
	$portfolio_section_classes[] = 'isotope-wrapper';
}

if ( ! empty( $portfolio_type ) && ( 'isotope' === $portfolio_type || 'grid' === $portfolio_type ) ) {
	$portfolio_classes[] = 'column-' . $portfolio_column;
}

$portfolio_section_classes[] = 'portfolio-section';

$filter_args = array(
	'taxonomy' => 'portfolio-category',
	'fields'   => 'id=>name',
);

if ( ! empty( $categories ) ) {
	$filter_args['include'] = $categories;
}

$filter_terms = get_terms( $filter_args );

$portfolio_section_classes = implode( ' ', array_filter( array_unique( $portfolio_section_classes ) ) );
$portfolio_classes         = implode( ' ', array_filter( array_unique( $portfolio_classes ) ) );
?>

<div class="<?php echo esc_attr( $portfolio_section_classes ); ?>">
	<?php
	if ( 'isotope' === $portfolio_type && ! is_wp_error( $filter_terms ) && is_array( $filter_terms ) && ! empty( $filter_terms ) ) {
		?>
		<div class="row no-gutter">
			<div class="col-sm-12">
				<div class="isotope-filters">
					<button data-filter="" class="all active"><?php echo esc_html__( 'All', 'pgs-core' ); ?></button>
					<?php
					foreach ( $filter_terms as $filter_key => $filter_name ) {
						?>
						<button data-filter="<?php echo esc_attr( $filter_key ); ?>"><?php echo esc_html( $filter_name ); ?></button>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<div class="<?php echo esc_attr( $portfolio_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'portfolio/portfolio_type/' . $portfolio_type ); ?>
	</div>
</div>
