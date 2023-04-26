<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

$count       = 0;
$current_row = 1;
$total       = count( $terms );
$rows        = ceil( $total / $cols );
?>

<div class="yith-wcbr-brand-thumbnail <?php echo esc_attr( $style ); ?>">

	<?php if ( ! empty( $title ) ) : ?>
		<h3><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<div class="yith-wcbr-thumbnail-list">
		<?php if ( ! empty( $terms ) ) : ?>
			<ul>
				<?php
				foreach ( $terms as $term ) :
					$classes  = '';
					$classes .= ( 0 === $count % $cols ) ? 'first' : '';
					$classes .= ( $current_row === $rows ) ? ' last-row' : '';
					$count++;

					if( 0 === $count % $cols ){
						$current_row++;
					}
					?>
					<li style="width: <?php echo esc_attr( $cols_width ); ?>%" class="<?php echo esc_attr( $classes ); ?>" >
						<?php
						$thumbnail_id = absint( yith_wcbr_get_term_meta( $term->term_id, 'thumbnail_id', true ) );

						if ( $thumbnail_id ) {
							$image = apply_filters( 'yith_wcbr_thumbnail_image', wp_get_attachment_image_src( $thumbnail_id, 'yith_wcbr_grid_logo_size' ), $thumbnail_id );

							if ( $image ) {
								$output = sprintf( '<a href="%s" title="%s"><img src="%s" width="%d" height="%d" alt="%s"/>', get_term_link( $term ), $term->name, $image[0], $image[1], $image[2], $term->name );

								if ( 'yes' === $show_name || 'yes' === $show_rating ) {

									$output .= '<div class="brand-info">';

									if ( 'yes' === $show_name ) {
										$output .= $term->name;
									}

									if ( 'yes' === $show_rating ) {
										$output .= YITH_WCBR_Premium()->get_average_term_rating_html( $term->term_id );
									}

									$output .= '</div>';
								}

								$output .= '</a>';

								echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
						} elseif ( 'yes' === get_option( 'yith_wcbr_use_logo_default' ) ) {
							do_action( 'yith_wcbr_no_brand_logo', $term->term_id, $term, 'yith_wcbr_grid_logo_size', 'yes' === $show_name, 'yes' === $show_rating );
						} else {
							?>
							<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
								<?php echo esc_html( $term->name ); ?>

								<?php if ( 'yes' === $show_name || 'yes' === $show_rating ) : ?>
									<div class="brand-info">
										<?php if ( 'yes' === $show_name ) : ?>
											<?php echo esc_html( $term->name ); ?>
										<?php endif; ?>

										<?php if ( 'yes' === $show_rating ) : ?>
											<?php echo YITH_WCBR_Premium()->get_average_term_rating_html( $term->term_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</a>
							<?php
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<div class="yith-wcbr-brands-pagination">
		<?php
		if ( isset( $page_links ) ) {
			echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>

</div>
