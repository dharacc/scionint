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

<tr valign="top">
	<th scope="row">
		<label for="<?php echo esc_attr( $id )?>"><?php echo esc_attr( $name )?></label>
	</th>
	<td class="forminp forminp-image-size">
		<div class="image-size-container">
			<input type="number" id="<?php echo esc_attr( $id ) ?>_width" class="yith_wcbr_image_size_width" name="<?php echo esc_attr( $id ) ?>[width]" value="<?php echo esc_attr( $image_size['width'] ) ?>"  style="max-width: 53px;"/><?php _e( 'x', 'yith-woocommerce-brands-add-on' ) ?>
			<input type="number" id="<?php echo esc_attr( $id ) ?>_height" class="yith_wcbr_image_size_height" name="<?php echo esc_attr( $id ) ?>[height]" value="<?php echo esc_attr( $image_size['height'] ) ?>" style="max-width: 53px;" /> <?php _e( 'px', 'yith-woocommerce-brands-add-on' ) ?>
			<input type="checkbox" id="<?php echo esc_attr( $id ) ?>_crop" class="yith_wcbr_image_size_crop" name="<?php echo esc_attr( $id ) ?>[crop]" value="1" <?php echo checked( isset( $image_size['crop'] ) && $image_size['crop'] ) ?> /> <?php _e( 'Hard Crop?', 'yith-woocommerce-brands-add-on' ) ?>
		</div>

		<?php if( ! empty( $desc ) ): ?>
			<span class="description"><?php echo $desc ?></span>
		<?php endif; ?>
	</td>
</tr>