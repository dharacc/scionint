<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_portfolio'] );
extract( $atts );
$the_query = $pgscore_shortcodes['pgscore_portfolio']['the_query'];

$owl_options_args = array(
	'items'              => 3,
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		576  => array(
			'items' => ( $carousel_items_sm ) ? (int) $carousel_items_sm : 1,
		),
		768  => array(
			'items' => ( $carousel_items_md ) ? (int) $carousel_items_md : 1,
		),
		992  => array(
			'items' => ( $carousel_items_lg ) ? (int) $carousel_items_lg : 2,
		),
		1200 => array(
			'items' => ( $carousel_items_xl ) ? (int) $carousel_items_xl : 2,
		),
	),
	'margin'             => ( $portfolio_space ) ? (int) $portfolio_space : 0,
	'dots'               => false,
	'nav'                => true,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'autoplayTimeout'    => 3100,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => true,
);

$owl_options = json_encode( $owl_options_args );
?>
<div class="carousel-wrapper">
	<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	if ( $the_query->have_posts() ) :

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>
			<div class="item">
				<?php pgscore_get_shortcode_templates( 'portfolio/loop/content' ); ?>
			</div>
			<?php
		endwhile;

		/* Restore original Post Data */
		wp_reset_postdata();

	endif;
	?>
	</div>
</div>
