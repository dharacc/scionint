<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_categorybox'] );
extract( $atts );

$category_box_styles = array();

// Background Image
$bg_image_url = '';
$bg_image     = ( 'link' === $image_source ) ? array( esc_url( $category_img_link ) ) : wp_get_attachment_image_src( $category_box_bg, 'full', false );
if ( ! empty( $bg_image[0] ) ) {
	$bg_image_url          = $bg_image[0];
	$category_box_styles[] = "background-image:url('$bg_image_url');";
}

// All Link
if ( ! empty( $enable_archive_link ) && ! empty( $archive_link ) ) {
	$btn_attr = pgscore_vc_link_attr( $archive_link, 'view-all' );
}

$category_box_styles = implode( ' ', array_filter( array_unique( $category_box_styles ) ) );
?>
<div class="category-box" style="<?php echo esc_attr( $category_box_styles ); ?>">
	<?php
	if ( $title ) {
		?>
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php
	}
	if ( $subtitle ) {
		?>
		<span class="subhead"><?php echo esc_html( $subtitle ); ?></span>
		<?php
	}
	?>
	<div class="category-box-link">
		<ul>
			<?php
			foreach ( $categorybox_categories as $cbox_category ) {
				?>
				<li>
					<a href="<?php echo esc_url( get_term_link( $cbox_category ) ); ?>">
						<i class="fa fa-angle-right" aria-hidden="true"></i><?php echo esc_html( $cbox_category->name ); ?>
					</a>
				</li>
				<?php
			}
			if ( ! empty( $enable_archive_link ) && ! empty( $archive_link ) ) {
				?>
				<li class="view-all">
					<?php echo wp_kses( '<a ' . $btn_attr . '>' . esc_html__( 'View All', 'pgs-core' ) . '</a>', pgscore_allowed_html( 'a' ) ); ?>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>
