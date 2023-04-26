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

	<div class="yith-wcbr-brand-select">

		<?php if ( ! empty( $title ) ) : ?>
			<h3><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<div class="yith-wcbr-brands-list">
			<?php if ( ! empty( $terms ) ) : ?>
				<select class="yith-wcbr-select">
					<option value=""><?php esc_html_e( 'All', 'yith-woocommerce-brands-add-on' ); ?></option>
					<?php foreach ( $terms as $term ) : ?>
						<option data-href="<?php echo esc_url( get_term_link( $term ) ); ?>" value="<?php echo esc_attr( $term->term_id ); ?>">
							<?php echo esc_html( $term->name ); ?>
							<?php
							if ( 'yes' === $show_count ) :
								echo '(' . esc_attr( $term->count ) . ')';
							endif;
							?>
						</option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
		</div>

	</div>

<?php wp_enqueue_script( 'yith-wcbr' ); ?>
