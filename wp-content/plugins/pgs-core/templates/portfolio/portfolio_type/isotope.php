<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_portfolio'] );
extract( $atts );

$filter_args = array(
	'taxonomy' => 'portfolio-category',
	'fields'   => 'id=>name',
);

if ( ! empty( $categories ) ) {
	$filter_args['include'] = $categories;
}

$filter_terms = get_terms( $filter_args );

if ( $the_query->have_posts() ) :

	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		$item_classes   = array();
		$item_groups    = array();
		$item_classes[] = 'portfolio-grid-item';

		if ( 'isotope' === $portfolio_type ) {
			$item_classes[] = 'grid-item';
			$post_terms     = get_the_terms( $post->ID, 'portfolio-category' );
			if ( $post_terms && ! is_wp_error( $post_terms ) && ! empty( $post_terms ) ) {
				foreach ( $post_terms as $post_term ) {
					$item_groups[] = $post_term->term_id;
				}
			}
		}

		$item_classes = join( ' ', $item_classes );
		?>
		<div class="<?php echo esc_attr( $item_classes ); ?>" data-groups="<?php echo esc_attr( json_encode( $item_groups ) ); ?>">
		<?php pgscore_get_shortcode_templates( 'portfolio/loop/content' ); ?>
		</div>
		<?php
	endwhile;

	/* Restore original Post Data */
	wp_reset_postdata();

endif;

wp_reset_postdata();
