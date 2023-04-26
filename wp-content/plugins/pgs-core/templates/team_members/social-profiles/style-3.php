<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
?>
<div class="team-social-icon pgssi-style-border pgscore-social-icons pgssi-shape-Round pgssi-effect-color-hover pgssi-size-small">
	<?php
	$social_profiles = get_post_meta( get_the_ID(), 'social_profiles', true );
	if ( $social_profiles ) {
		?>
		<ul>
			<?php
			for ( $i = 0; $i < $social_profiles; $i++ ) {

				$social_title = get_post_meta( get_the_ID(), 'social_profiles_' . $i . '_social_title', true );
				$social_icon  = get_post_meta( get_the_ID(), 'social_profiles_' . $i . '_social_icon', true );
				$social_url   = get_post_meta( get_the_ID(), 'social_profiles_' . $i . '_social_url', true );
				
				if ( $social_title && $social_icon && $social_url ) {
					$icon_classes   = array();
					$icon_classes[] = 'pgssi-item';
					$icon_classes[] = 'pgssi-color-' . sanitize_title( $social_title );
					$icon_classes   = pgscore_class_builder( $icon_classes );

					if ( ( strpos( $social_icon, 'fab' ) !== false ) || ( strpos( $social_icon, 'fas' ) !== false ) || ( strpos( $social_icon, 'far' ) !== false ) ) {
						$social_icon_value = $social_icon;
					} else {
						$social_icon_value = 'fa ' . $social_icon;
					}
					?>
					<li class="<?php echo esc_attr( $icon_classes ); ?>">
						<a href="<?php echo esc_url( $social_url ); ?>" title="<?php echo esc_attr( ( $social_title ) ? $social_title : '' ); ?>">
							<i class="<?php echo esc_attr( $social_icon_value ); ?>"></i>
						</a>
					</li>
					<?php
				}
			}
			?>
		</ul>
		<?php
	}
	?>
</div>
