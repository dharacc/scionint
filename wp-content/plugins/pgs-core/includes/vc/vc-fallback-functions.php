<?php
/**
 * @param $atts_string
 *
 * @since 4.4
 * @return array|mixed
 *
 * migrated from: vc_param_group_parse_atts
 */
function pgscore_vc_param_group_parse_atts( $atts_string ) {
	$array = json_decode( urldecode( $atts_string ), true );

	return $array;
}


/**
 * @param $value
 *
 * @since 4.2
 * @return array
 */
function pgscore_vc_build_link( $value ) {
	return pgscore_vc_parse_multi_attribute(
		$value,
		array(
			'url'    => '',
			'title'  => '',
			'target' => '',
			'rel'    => '',
		)
	);
}


/**
 * Parse string like "title:Hello world|weekday:Monday" to array('title' => 'Hello World', 'weekday' => 'Monday')
 *
 * @param $value
 * @param array $default
 *
 * @since 4.2
 * @return array
 */
function pgscore_vc_parse_multi_attribute( $value, $default = array() ) {
	$result       = $default;
	$params_pairs = explode( '|', $value );
	if ( ! empty( $params_pairs ) ) {
		foreach ( $params_pairs as $pair ) {
			$param = preg_split( '/\:/', $pair );
			if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
				$result[ $param[0] ] = rawurldecode( $param[1] );
			}
		}
	}

	return $result;
}
