<?php
/*
 * Return Redux typography backup font family
 */
function pgscore_redux_typography_font_backup() {
	$fonts = array(
		'sans-serif'                            => 'sans-serif',
		'Arial, Helvetica'                      => 'Arial, Helvetica, sans-serif',
		"'Arial Black', Gadget, sans-serif"     => "'Arial Black', Gadget, sans-serif",
		"'Bookman Old Style', serif"            => "'Bookman Old Style', serif",
		"'Comic Sans MS', cursive"              => "'Comic Sans MS', cursive",
		'Courier, monospace'                    => 'Courier, monospace',
		'Garamond, serif'                       => 'Garamond, serif',
		'Georgia, serif'                        => 'Georgia, serif',
		'Impact, Charcoal, sans-serif'          => 'Impact, Charcoal, sans-serif',
		"'Lucida Console', Monaco, monospace"   => "'Lucida Console', Monaco, monospace",
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
		"'MS Sans Serif', Geneva, sans-serif"   => "'MS Sans Serif', Geneva, sans-serif",
		"'MS Serif', 'New York', sans-serif"    => "'MS Serif', 'New York', sans-serif",
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
		'Tahoma,Geneva, sans-serif'             => 'Tahoma, Geneva, sans-serif',
		"'Times New Roman', Times,serif"        => "'Times New Roman', Times, serif",
		"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
		'Verdana, Geneva, sans-serif'           => 'Verdana, Geneva, sans-serif',
	);

	// Deprecated.
	return apply_filters_deprecated( 'ciyashop_redux_typography_font_backup', array( $fonts ), '3.0', 'pgscore_redux_typography_font_backup' ); // TODO: CiyaShop Upcoming Release

	$fonts = apply_filters( 'pgscore_redux_typography_font_backup', $fonts );
	return $fonts;
}
