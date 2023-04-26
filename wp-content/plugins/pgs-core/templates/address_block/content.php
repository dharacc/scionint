<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_address_block'] );
extract( $atts );

$address_block_classes   = array();
$address_block_classes[] = 'address-block';
$address_block_classes[] = 'address-block-' . ( ! empty( $icon_html ) ? 'with-icon' : 'without-icon' );
$address_block_classes[] = esc_attr( $shape );
$address_block_classes[] = esc_attr( $style );
$address_block_classes   = pgscore_class_builder( $address_block_classes );
?>
<div class="<?php echo esc_attr( $address_block_classes ); ?>">
	<?php
	if ( ! empty( $icon_html ) ) {
		?>
		<div class="address-block-icon">
			<?php
			echo wp_kses(
				$icon_html,
				array(
					'i'    => array(
						'class' => true,
					),
					'span' => array(
						'class' => true,
					),
				)
			);
			?>
		</div>
		<?php
	}
	?>
	<div class="address-block-data">
		<?php
		if ( ! empty( $title ) ) {
			?>
			<h3 class="title"><?php echo esc_html( $title ); ?></h3>
			<?php
		}
		foreach ( $sub_contents_data as $sub_content ) {
			if ( ! empty( $sub_content['subcontent_title'] ) ) {
				?>
				<span>
					<?php
					$link_attr = '';
					if ( ! empty( $sub_content['enable_link'] ) && ! empty( $sub_content['custom_link'] ) ) {
						$link_attr = pgscore_vc_link_attr( $sub_content['custom_link'] );
					}
					if ( $link_attr ) {
						echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $sub_content['subcontent_title'] ) . '</a>', pgscore_allowed_html( 'a' ) );
					} else {
						echo esc_html( $sub_content['subcontent_title'] );
					}
					?>
				</span>
				<?php
			}
		}
		?>
	</div>
</div>
