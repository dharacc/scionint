<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

?>
<?php
global $ciyashop_options;

$column = isset( $ciyashop_options['pro-col-sel'] ) && ! empty( $ciyashop_options['pro-col-sel'] ) ? $ciyashop_options['pro-col-sel'] : 0;
?>
<ul class="<?php echo esc_attr( ciyashop_products_loop_classes( 'products' ) ); ?>" data-column="<?php echo esc_attr( $column ); ?>">
