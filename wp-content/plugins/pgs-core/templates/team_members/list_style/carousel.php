<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}

global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_team_members']['atts'] );
$the_query = $pgscore_shortcodes['pgscore_team_members']['the_query'];

$owl_options_args = array();

// Arrow
if ( ! empty( $show_prev_next_buttons ) && $show_prev_next_buttons == 'yes' ) {
	$owl_options_args['nav'] = true;
} else {
	$owl_options_args['nav'] = false;
}

// Pagination
if ( ! empty( $show_pagination_control ) && $show_pagination_control == 'yes' ) {
	$owl_options_args['dots'] = true;
} else {
	$owl_options_args['dots'] = false;
}

$owl_options_args['items']                     = 4;
$owl_options_args['responsive'][0]['items']    = 1;
$owl_options_args['responsive'][480]['items']  = 2;
$owl_options_args['responsive'][768]['items']  = 2;
$owl_options_args['responsive'][980]['items']  = 3;
$owl_options_args['responsive'][1200]['items'] = 4;
$owl_options_args['margin']                    = 15;
$owl_options_args['loop']                      = true;
$owl_options_args['autoplay']                  = true;
$owl_options_args['autoplayHoverPause']        = true;
$owl_options_args['autoplayTimeout']           = 3100;
$owl_options_args['smartSpeed']                = 1000;
$owl_options_args['lazyLoad']                  = ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false;


$owl_options_args['navText'] = array(
	'<i class="fas fa-angle-left fa-2x"></i>',
	'<i class="fas fa-angle-right fa-2x"></i>',
);

$owl_options = json_encode( $owl_options_args );
?>
<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		global $post;
		?>
		<div class="item">
			<?php pgscore_get_shortcode_templates( 'team_members/loop/' . $style ); ?>
		</div>
		<?php
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
