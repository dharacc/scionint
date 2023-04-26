<?php
if (! defined('ABSPATH')) { // Or some other WordPress constant
    exit;
}

global $pgscore_shortcodes, $ciyashop_globals;

extract( $pgscore_shortcodes[ 'pgscore_smart_image_view' ] );
extract( $atts );

$smart_image_view_text_styles = array();
$prehover_style               = array();
$image_gallery                = explode( ',', $image_gallery );
?>
<div id="ciyashop-360-view" class="cloudimage-360" 
    data-image-list='[
        <?php 
		$i = 0; 
        foreach ( $image_gallery as $image_gallery_url ) {
            $image_full = wp_get_attachment_image_src( $image_gallery_url, 'full' );
            $image_url = $image_full[0];
            if( $i > 0 ) { echo ','; }
			?> "<?php echo esc_url($image_url); ?>"
			<?php
			$i++;
		}
		?>
        ]' data-bottom-circle-offset="5" data-keys <?php if ( $show_auto_play_smart_image_view == 'yes' ) { echo "data-autoplay"; } ?> data-ratio="0.365"> 
        <?php
        if ( $show_prev_next_buttons == 'yes' ) {
			?>
            <button class="cloudimage-360-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
            <button class="cloudimage-360-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
			<?php 
		}
        wp_enqueue_script( 'cloudimage-360-view' );
        ?>
</div>