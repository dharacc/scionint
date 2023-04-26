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
<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e( 'Banner', 'yith-woocommerce-brands-add-on' ); ?></label></th>
	<td>
		<div id="product_brand_banner" style="float:left;margin-right:10px;"><img alt="<?php _e( 'Product brand banner', 'yith-woocommerce-brands-add-on-premium' ) ?>" src="<?php echo $banner; ?>" width="60px" height="60px" /></div>
		<div style="line-height:60px;">
			<input type="hidden" id="product_brand_banner_id" class="yith_wcbr_upload_image_id" name="product_brand_banner_id" value="<?php echo $banner_id; ?>" />
			<button id="product_brand_banner_upload" type="submit" class="yith_wcbr_upload_image_button button"><?php _e( 'Upload/Add image', 'yith-woocommerce-brands-add-on' ); ?></button>
			<button id="product_brand_banner_remove" type="submit" class="yith_wcbr_remove_image_button button"><?php _e( 'Remove image', 'yith-woocommerce-brands-add-on' ); ?></button>
		</div>
		<div class="clear"></div>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e( 'Custom URL', 'yith-woocommerce-brands-add-on' ); ?></label></th>
	<td>
		<input type="text" id="product_brand_custom_url" name="product_brand_custom_url" value="<?php echo $custom_url?>" />
		<p class="description"><?php _e( 'Set a custom URL for redirect. Default redirect is to archive page', 'yith-woocommerce-brands-add-on' ) ?></p>
		<div class="clear"></div>
	</td>
</tr>