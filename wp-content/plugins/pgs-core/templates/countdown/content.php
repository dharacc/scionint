<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_countdown'] );
extract( $atts );

$counter_data = array(
	'expiremsg' => $expire_message,
	'weeks'     => esc_html__( 'Week', 'pgs-core' ),
	'days'      => esc_html__( 'Day', 'pgs-core' ),
	'hours'     => esc_html__( 'Hrs', 'pgs-core' ),
	'minutes'   => esc_html__( 'Min', 'pgs-core' ),
	'seconds'   => esc_html__( 'Sec', 'pgs-core' ),
);

$counter_data = json_encode( $counter_data );

$counter_wrapper_classes = array(
	'deal-counter-wrapper',
	'counter-wrapper',
	"counter-style-{$counter_style}",
);

$counter_wrapper_classes = implode( ' ', array_filter( array_unique( $counter_wrapper_classes ) ) );
?>
<div class="<?php echo esc_attr( $counter_wrapper_classes ); ?>">
	<div class="deal-counter" data-countdown-date="<?php echo esc_attr( $countdown_date ); ?>" data-counter_data="<?php echo esc_attr( $counter_data ); ?>"></div>
</div>
