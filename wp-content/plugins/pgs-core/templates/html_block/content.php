<?php
global $pgscore_shortcodes;

extract( $pgscore_shortcodes['pgscore_html_block'] );
extract( $atts );

?>
<div class="pgs-html-block">
	<?php echo pgs_get_html_block( $html_block_id ); ?>
</div>
