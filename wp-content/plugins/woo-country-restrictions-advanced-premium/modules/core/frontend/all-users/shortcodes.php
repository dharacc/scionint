<?php

if (!function_exists('vcwccr_country_shortcode')) {
	add_shortcode('wccr_country', 'vcwccr_country_shortcode');

	function vcwccr_country_shortcode($atts = array(), $content = '') {
		extract(shortcode_atts(array(
			'countries' => '',
			'disallowed' => false,
			'show_if_unknown_country' => true
						), $atts));

		// Exclude common bots from geolocation by user agent.
		$ua = strtolower(wc_get_user_agent());
		if (strstr($ua, 'bot') || strstr($ua, 'spider') || strstr($ua, 'crawl')) {
			return $content;
		}

		$user_country = wcacr_get_user_country();
		if (empty($user_country) && !$show_if_unknown_country) {
			return;
		}

		$countries = array_map('strtoupper', vcwccr_replace_continent(array_map('trim', explode(',', $countries))));
		if (( $disallowed && in_array($user_country, $countries)) || (!$disallowed && !in_array($user_country, $countries))) {
			return;
		}
		return $content;
	}

}