<?php
global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_video'] );
extract( $atts );

$video_shortcode_classes = 'pgs-video-info';
if ( 'icon' === $button_style ) {
	$video_shortcode_classes .= ' pgs-video-icon';
} else {
	$video_shortcode_classes .= ' pgs-video-btn';
}

if ( 'center' === $button_position ) {
	$video_shortcode_classes .= ' pgs-video-icon-position-center';
} else {
	$video_shortcode_classes .= ' pgs-video-icon-position-left_bottom';
}
?>
<div class="<?php echo esc_attr( $video_shortcode_classes ); ?>">
	<div class="pgs-video"> 	
		<?php
		if ( ! empty( $opacity_color ) && ( 'true' == $enable_opacity ) ) {
			?>
			<div class="pgs-video-opacity" style='background:<?php echo $opacity_color; ?>'></div>
			<?php
		}
		if ( 'link' === $image_source ) {
			if ( ! empty( $video_img_link ) ) {
				?>
				<img class="img-responsive" src="<?php echo esc_url( $video_img_link ); ?>" />
				<?php
			}
		} else {
			if ( ! empty( $video_img ) ) {
				echo wp_get_attachment_image( $video_img, 'full', '', array( 'class' => 'img-responsive' ) );
			}
		}
		?>
		<div class="pgs-video-content video_popup-gallery">
			<?php
			if ( ! empty( $video_link ) ) {
				if ( ! empty( $icon_style ) ) {
					?>
					<a class="popup-youtube" href="<?php echo esc_url( $video_link ); ?>" > 
						<img class="img-responsive" src="<?php echo esc_url( $icon_style ); ?>" alt="Video Img"> 
					</a>
					<?php
				}
				if ( ! empty( $btn_text ) ) {
					?>
					<a class="popup-youtube btn-style-type-<?php echo esc_attr( $button_style_type ); ?> video-popup-btn" href="<?php echo esc_url( $video_link ); ?>" > 
						<?php echo $btn_text; ?>
					</a>
					<?php 
				}
			}
			if ( ! empty( $title ) ) {
				?>
				<div class="pgs-title-des">
					<?php
					if ( true == $show_content ) {
						?>
						<<?php echo esc_html( $title_element ); ?> class="pgs-video-title">
							<?php echo $title; ?>
						</<?php echo esc_html( $title_element ); ?>>
						<?php 
					}
					if ( ! empty( $content ) ) {
						?>
						<p><?php echo $content; ?></p>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
