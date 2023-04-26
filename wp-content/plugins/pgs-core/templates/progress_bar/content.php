<?php
global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_progress_bar'] );
extract( $atts );

$progress_bar_lists = $pgscore_shortcodes['pgscore_progress_bar']['progress_bar_list'];

foreach ( $progress_bar_lists as $progress_bar_list ) {
	$pgscore_progress_bar_wrapper   = array();
	$styles                         = array();
	$inner_styles                   = array();
	$pgscore_progress_bar_wrapper[] = 'pgscore_progress_bar_wrapper_inner';

	if ( isset( $progress_bar_border ) && ! empty( $progress_bar_border ) ) {
		$pgscore_progress_bar_wrapper[] = 'progress_bar_' . $progress_bar_border;
	}

	if ( isset( $progress_bar_title_position ) && ! empty( $progress_bar_title_position ) ) {
		$pgscore_progress_bar_wrapper[] = 'progress_bar_title_position_' . $progress_bar_title_position;
	}

	$pgscore_progress_bar_wrapper = implode( ' ', array_filter( array_unique( $pgscore_progress_bar_wrapper ) ) );

	if ( isset( $progress_bar_height ) && ! empty( $progress_bar_height ) ) {
		if ( $progress_bar_height >= 20 ) {
			$progress_bar_height = 20;
		}
		$styles[]       = 'height:' . $progress_bar_height . 'px;';
		$inner_styles[] = 'height:' . $progress_bar_height . 'px;';
	}
	if ( isset( $progress_bar_list['progress_bar_color'] ) && ! empty( $progress_bar_list['progress_bar_color'] ) ) {
		$inner_styles[] = 'background:' . $progress_bar_list['progress_bar_color'] . ';';
	}
	$styles       = implode( ' ', array_filter( array_unique( $styles ) ) );
	$inner_styles = implode( ' ', array_filter( array_unique( $inner_styles ) ) );

	if ( isset( $progress_bar_list['progress_bar_value'] ) && $progress_bar_list['progress_bar_value'] > 100 ) {
		$progress_bar_list['progress_bar_value'] = 100;
	}
	if ( isset( $progress_bar_list['progress_bar_value'] ) && $progress_bar_list['progress_bar_value'] <= 0 ) {
		$progress_bar_list['progress_bar_value'] = 1;
	}

	if ( isset( $progress_bar_list['progress_bar_title'] ) && isset( $progress_bar_list['progress_bar_value'] ) ) {
		?>
		<div style="<?php echo esc_attr( $styles ); ?>" class="<?php echo esc_attr( $pgscore_progress_bar_wrapper ); ?>">
			<div  class="progress-bar pgscore_progress_bar_box" data-percent="<?php echo esc_attr( $progress_bar_list['progress_bar_value'] ); ?>" data-delay="0" data-type="%" style="<?php echo esc_attr( $inner_styles ); ?>">
				<div class="progress-title"><?php echo esc_html( $progress_bar_list['progress_bar_title'] ); ?></div>
				<div class="progress_bar_type_value">
					<span class="pgscore_progress_bar_value"><?php echo esc_html( $progress_bar_list['progress_bar_value'] ); ?></span>
					<span class="progress-type">%</span>
				</div>
			</div>
		</div>
		<?php
	}
}

