<?php
/**
 * Documentation and stuff
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

do_action( 'pgssl_component_help_start' );

?>
<div class="metabox-holder columns-2" id="post-body">
	<?php
	include 'components.help.reference.php';
	include 'components.help.sidebar.php';
	?>
</div>
<?php

do_action( 'pgssl_component_help_end' );
