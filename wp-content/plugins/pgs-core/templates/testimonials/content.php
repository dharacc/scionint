<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_testimonials'] );
extract( $atts );
$post_count = $the_query->found_posts;

$pgs_testimonials_classes[] = 'testimonial';
$pgs_testimonials_classes[] = 'testimonial-' . $style;

if ( $posts_per_page > 50 ) {
	$posts_per_page = 50;
} elseif ( $posts_per_page <= 0 ) {
	return;
}

if ( $posts_per_page <= 3 ) {
	$pgs_testimonials_classes[] = 'testimonial-single';
} elseif ( $post_count <= 3 ) {
	$pgs_testimonials_classes[] = 'testimonial-single';
}

$pgs_testimonials_classes = implode( ' ', array_filter( array_unique( $pgs_testimonials_classes ) ) );
?>
<div class="<?php echo esc_attr( $pgs_testimonials_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'testimonials/list_style/' . $style ); ?>
</div>
