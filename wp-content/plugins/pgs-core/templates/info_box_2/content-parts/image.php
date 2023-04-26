<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

if ( 'image' === $icon_source ) {
    if ( $icon_image ) {
        $img_atts = wp_get_attachment_image_src( $icon_image );
        $img_src  = $img_atts[0];
		?>
        <div class="pgscore_info_box_2-icon-outer">
            <div class="pgscore_info_box_2-icon-inner">
                <img src="<?php echo esc_url( $img_src ); ?>" />
            </div>
        </div>
        <?php
    }
} else {
    if ( $image_link ) {
        ?>
        <div class="pgscore_info_box_2-icon-outer">
            <div class="pgscore_info_box_2-icon-inner">
                <img src="<?php echo esc_url( $image_link ); ?>" />
            </div>
        </div>
        <?php 
    }
}
?>
