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
?>

<li style="width: <?php echo esc_attr( $cols_width ); ?>%" class="<?php echo esc_attr( $classes ); ?>" data-categories="<?php echo esc_attr( wp_json_encode( isset( $brand_category ) ? $brand_category : array() ) ); ?>" >
	<?php
	$term_link = get_term_link( $term );

	if ( 'category' === $show_filtered_by && 'yes' === $use_filtered_urls && $filter ) {
		$category  = get_term( $filter, 'product_cat' );
		$term_link = add_query_arg( 'product_cat', $category->slug, $term_link );
	}

	if ( 'yes' === $show_image ) {
		$thumbnail_id = absint( yith_wcbr_get_term_meta( $term->term_id, 'thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, 'yith_wcbr_grid_logo_size' );

			if ( $image ) {
				echo sprintf( '<a href="%s" title="%s"><img src="%s" width="%d" height="%d" alt="%s"/></a>', esc_url( $term_link ), esc_attr( $term->name ), esc_attr( $image[0] ), esc_attr( $image[1] ), esc_attr( $image[2] ), esc_attr( $term->name ) );
			}
		} elseif ( 'yes' === get_option( 'yith_wcbr_use_logo_default' ) ) {
			do_action( 'yith_wcbr_no_brand_logo', $term->term_id, $term, 'yith_wcbr_grid_logo_size', false, false );
		} else {
			echo sprintf( '<a href="%s">%s</a>', esc_url( $term_link ), esc_html( $term->name ) );
		}
	}

	if ( 'yes' === $show_name ) {
		$name = sprintf( '<a href="%s">%s', esc_url( $term_link ), $term->name );

		if ( 'yes' === $show_count ) {
			$name .= sprintf( ' (%d)', $term->count );
		}

		$name .= '</a>';

		echo $name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</li>
