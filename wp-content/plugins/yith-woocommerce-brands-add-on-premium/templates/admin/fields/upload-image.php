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
	<td class="forminp forminp-upload-image">
		<div id="<?php echo esc_attr( $id ) ?>_preview" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
		<div style="line-height:60px;">
			<input type="hidden" id="<?php echo esc_attr( $id ) ?>" class="yith_wcbr_upload_image_id" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $image_id ) ?>" />
			<button type="button" id="<?php echo esc_attr( $id ) ?>_upload" class="yith_wcbr_upload_image_button button"><?php _e( 'Upload/Add image', 'yith-woocommerce-brands-add-on' ); ?></button>
			<button type="button" id="<?php echo esc_attr( $id ) ?>_remove" class="yith_wcbr_remove_image_button button"><?php _e( 'Remove image', 'yith-woocommerce-brands-add-on' ); ?></button>
		</div>
	</td>
</tr>