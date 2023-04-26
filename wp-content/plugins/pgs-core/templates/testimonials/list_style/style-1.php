<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_testimonials'] );
extract( $atts );
$post_count = $the_query->found_posts;

if ( $posts_per_page <= 3 ) {
	$post_to_show = 1;
} elseif ( $post_count <= 3 ) {
	$post_to_show = 1;
} else {
	$post_to_show = 3;
}
?>
<div class="testimonials slick-carousel">
	<div class="slick-carousel-main testimonial-caption" data-show ="<?php echo esc_attr( $post_to_show ); ?>">
		<?php
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$content     = '';
			$author      = '';
			$designation = '';

			$content     = get_post_meta( get_the_ID(), 'content', true );
			$author      = get_post_meta( get_the_ID(), 'author', true );
			$designation = get_post_meta( get_the_ID(), 'designation', true );

			if ( ! $author ) {
				$author = get_the_title();
			}

			if ( $content ) {
				?>
				<div>
					<div class="slick-caption">
						<i class="fas fa-quote-left" aria-hidden="true"></i>
						<p><?php echo esc_html( $content ); ?></p>
						<div class="client-info">
							<?php
							if ( $author ) {
								?>
								<h5 class="author-name">- <?php echo esc_html( $author ); ?></h5>
								<?php
							}
							if ( $designation ) {
								?>
								<span><?php echo esc_html( $designation ); ?></span>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		?>
	</div>
	<div class="slick-carousel-nav testimonial-nav">
		<?php
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$testimonials_img_src = '';
			$author               = '';
			$content              = '';

			$content = get_post_meta( get_the_ID(), 'content', true );
			$author  = get_post_meta( get_the_ID(), 'author', true );

			$testimonials_img_alt = ( $author ) ? $author : esc_html__( 'Author', 'pgs-core' );

			if ( has_post_thumbnail() ) {
				$testimonials_thumbnail_id = get_post_thumbnail_id();
				$testimonials_img_data     = wp_get_attachment_image_src( $testimonials_thumbnail_id, 'thumbnail' );

				if ( isset( $testimonials_img_data[0] ) ) {
					$testimonials_img_src = $testimonials_img_data[0];
				}
			}

			if ( ! empty( $content ) ) {
				if ( empty( $testimonials_img_src ) ) {
					$testimonials_img_src = get_parent_theme_file_uri( '/images/placeholder/testimonials/150x150.png' );
				}
				?>
				<div>
					<div class="author-photo">
						<img class="img-responsive img-circle" src="<?php echo esc_url( $testimonials_img_src ); ?>" alt="<?php echo esc_attr( $testimonials_img_alt ); ?>" />
					</div>
				</div>
				<?php
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		?>
	</div>
</div>
