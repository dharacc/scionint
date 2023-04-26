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

<table class="wc_status_table wc_status_table--tools widefat">
	<tbody class="tools">
	<tr>
		<th>
            <strong><?php _e( 'Brands-Categories Transient', 'yith-woocommerce-brands-add-on' ); ?></strong>
            <p class="description"><?php _e( 'This tool will clear Brands-Categories relationship transient', 'yith-woocommerce-brands-add-on' ); ?></p>
        </th>
		<td class="run-tool">
            <a class="button clear_transients" href="<?php echo wp_nonce_url( add_query_arg( array( 'page' => 'yith_wcbr_panel', 'tab' => 'tools', 'action' => 'clear_transient_brand_category' ), admin_url( 'admin.php' ) ), 'yith_wcbr_tools' ) ?>"><?php _e( 'Clear Transient', 'yith-woocommerce-brands-add-on' ); ?></a>
		</td>
	</tr>
	<tr>
		<th>
            <strong><?php _e( 'Categories-Brands Transient', 'yith-woocommerce-brands-add-on' ); ?></strong>
            <p class="description"><?php _e( 'This tool will clear Categories-Brands relationship transient', 'yith-woocommerce-brands-add-on' ); ?></p>
        </th>
		<td class="run-tool">
            <a class="button clear_transients" href="<?php echo wp_nonce_url( add_query_arg( array( 'page' => 'yith_wcbr_panel', 'tab' => 'tools', 'action' => 'clear_transient_category_brand' ), admin_url( 'admin.php' ) ), 'yith_wcbr_tools' ) ?>"><?php _e( 'Clear Transient', 'yith-woocommerce-brands-add-on' ); ?></a>
		</td>
	</tr>
	<tr>
		<th>
            <strong><?php _e( 'YITH WCBR Transient', 'yith-woocommerce-brands-add-on' ); ?></strong>
            <p class="description"><?php _e( 'This tool will clear the brands transients cache.', 'yith-woocommerce-brands-add-on' ); ?></p>
        </th>
		<td class="run-tool">
            <a class="button clear_transients" href="<?php echo wp_nonce_url( add_query_arg( array( 'page' => 'yith_wcbr_panel', 'tab' => 'tools', 'action' => 'clear_transients' ), admin_url( 'admin.php' ) ), 'yith_wcbr_tools' ) ?>"><?php _e( 'Clear Transients', 'yith-woocommerce-brands-add-on' ); ?></a>
		</td>
	</tr>
	<tr>
		<th>
            <strong><?php _e( 'Term counts', 'yith-woocommerce-brands-add-on' ); ?></strong>
            <p class="description"><?php _e( 'This tool will recount product terms', 'yith-woocommerce-brands-add-on' ); ?></p>
        </th>
		<td class="run-tool">
            <a class="button clear_transients" href="<?php echo wp_nonce_url( add_query_arg( array( 'page' => 'yith_wcbr_panel', 'tab' => 'tools', 'action' => 'recount_terms' ), admin_url( 'admin.php' ) ), 'yith_wcbr_tools' ) ?>"><?php _e( 'Recount terms', 'yith-woocommerce-brands-add-on' ); ?></a>
		</td>
	</tr>
	</tbody>
</table>
