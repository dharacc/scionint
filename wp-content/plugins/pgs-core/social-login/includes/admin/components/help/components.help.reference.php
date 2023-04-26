<?php
/**
* Documentation and stuff
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

do_action( "pgssl_component_help_reference_start" );
?>
<div class="stuffbox" style="padding:20px">

	<h3 style="padding-left:0px"><?php _pgssl_e("Documentation", 'pgssl-text-domain') ?></h3>
	<p>
		<?php
		printf(
			wp_kses(
				/* translators: %1$s: social login documentation link */
				__( 'The complete <b>User Guide</b> can be found at <a href="%1$s" target="_blank">%1$s</a>.', 'pgssl-text-domain' ),
				array(
					'b' => array(),
					'a' => array(
						'href'   => true,
						'target' => true,
					),
				)
			),
			'http://docs.potenzaglobalsolutions.com/social-login/'
		);
		?>
	</p>

</div>
<?php

do_action( "pgssl_component_help_reference_end" );
