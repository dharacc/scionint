<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_recent_posts']['atts'] );
$loop = $pgscore_shortcodes['pgscore_recent_posts']['loop'];

$col_xs_perview = 1;
$col_sm_perview = 1;
$col_md_perview = 1;
$col_lg_perview = 2;
$col_xl_perview = ! empty( $grid_column_xl ) ? $grid_column_xl : 3;

$col_xs = 12 / $col_xs_perview;
$col_sm = 12 / $col_sm_perview;
$col_md = 12 / $col_md_perview;
$col_lg = 12 / $col_lg_perview;
$col_xl = 12 / $col_xl_perview;

$recent_post_classes [] = 'col-xs-' . $col_xs;
$recent_post_classes [] = 'col-sm-' . $col_sm;
$recent_post_classes [] = 'col-md-' . $col_md;
$recent_post_classes [] = 'col-lg-' . $col_lg;
$recent_post_classes [] = 'col-xl-' . $col_xl;

$recent_post_classes = implode( ' ', array_filter( array_unique( $recent_post_classes ) ) );
?>
<div class="row">
	<?php
	while ( $loop->have_posts() ) {
		$loop->the_post();
		global $post;
		?>
		<div class="<?php echo esc_attr( $recent_post_classes ); ?>">
			<?php pgscore_get_shortcode_templates( 'recent_posts/loop/content' ); ?>
		</div>
		<?php
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
