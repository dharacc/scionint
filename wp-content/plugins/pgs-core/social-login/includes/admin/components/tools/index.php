<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_tools() {
	// HOOKABLE:
	do_action( "pgssl_component_tools_start" );

	include "components.tools.actions.php"; 
	include "components.tools.sidebar.php";

	$action = isset( $_REQUEST['do'] ) ? $_REQUEST['do'] : null ;

	if( in_array( $action, array( 'diagnostics', 'sysinfo', 'uninstall' , 'repair' ) ) ) {
		if( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'] ) ) {
			include "components.tools.actions.job.php";

			do_action( 'pgssl_component_tools_do_' . $action );
		} else {
			?>
			<div style="margin: 4px 0 20px;" class="fade error pgssl-error-db-tables">
				<p>
					<?php _pgssl_e('The URL nonce is not valid', 'pgssl-text-domain') ?>! 
				</p>
			</div>
			<?php
		}
	} else {
		?> 
			<div class="metabox-holder columns-2" id="post-body">
				<table width="100%"> 
					<tr valign="top">
						<td> 
							<?php
								pgssl_component_tools_sections();
							?>
						</td>
						<td width="10"></td>
						<td width="400">
							<?php 
								pgssl_component_tools_sidebar();
							?>
						</td>
					</tr>
				</table>
			</div>
		<?php
	}

	// HOOKABLE: 
	do_action( "pgssl_component_tools_end" );
}

pgssl_component_tools();
