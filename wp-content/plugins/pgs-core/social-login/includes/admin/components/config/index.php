<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;  

do_action( "pgssl_component_config_start" );

include "components.config.setup.php";
include "components.config.sidebar.php";
?>
<form method="post" id="pgssl_setup_form" action="options.php"> 
	<?php settings_fields( 'pgssl_settings-group-config' ); ?>

	<div class="metabox-holder columns-2" id="post-body">
		<table width="100%">
			<tr valign="top">
				<td>
					<?php pgssl_component_config_setup();?>
				</td>
				<td width="10"></td>
				<td width="400">
					<?php pgssl_component_config_sidebar();?>
				</td>
			</tr>
		</table>
	</div>
</form>
<?php
do_action( "pgssl_component_config_end" );