<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_tools_sections() {
	$sections = array(
		'auth_playground'    => 'pgssl_component_tools_auth_playground'    ,
		'diagnostics'        => 'pgssl_component_tools_diagnostics'        ,
		'system_information' => 'pgssl_component_tools_system_information' ,
		'repair_pgssl_tables'  => 'pgssl_component_tools_repair_pgssl_tables'  ,
		'debug_mode'         => 'pgssl_component_tools_debug_mode'         ,
		'development_mode'   => 'pgssl_component_tools_development_mode'   ,
		'uninstall'          => 'pgssl_component_tools_uninstall'          ,
	);

	$sections = apply_filters( 'pgssl_component_tools_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_tools_sections', $action );
	}

	// HOOKABLE:
	do_action( 'pgssl_component_tools_sections' );
}

function pgssl_component_tools_auth_playground() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Authentication Playground", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('Authentication Playground will let you authenticate with the enabled social networks without creating any new user account. This tool will also give you a direct access to social networks apis via a lightweight console', 'pgssl-text-domain') ?>. 
		</p>

		<a class="button-primary"  href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=auth-paly'); ?>"><?php _pgssl_e("Go to the authentication playground", 'pgssl-text-domain') ?></a>  
	</div>
</div>
<?php
}

function pgssl_component_tools_diagnostics() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("PGS Social Login Diagnostics", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('This tool will check for the common issues and for the minimum system requirements', 'pgssl-text-domain') ?>.
		</p>

		<a class="button-primary" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=diagnostics'); ?>"><?php _pgssl_e("Run PGS Social Login Diagnostics", 'pgssl-text-domain') ?></a>  
	</div>
</div>
<?php
}

function pgssl_component_tools_system_information() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("System information", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('This tool will gather and display your website and server info. Please include these information when posting support requests, it will help me immensely to better understand any issues', 'pgssl-text-domain') ?>. 
		</p>

		<a class="button-primary"  href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=sysinfo'); ?>"><?php _pgssl_e("Display your system information", 'pgssl-text-domain') ?></a>  
	</div>
</div>
<?php
}

function pgssl_component_tools_repair_pgssl_tables() {
?>
<a name="repair-tables"></a>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Repair PGS Social Login tables", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('This will attempt recreate PGS Social Login databases tables if they do not exist and will also add any missing field', 'pgssl-text-domain') ?>. 
		</p>

		<a class="button-primary" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=repair'); ?>"><?php _pgssl_e("Repair PGS Social Login databases tables", 'pgssl-text-domain') ?></a>
	</div>
</div>
<?php
}

function pgssl_component_tools_debug_mode() {
	$pgssl_settings_debug_mode_enabled = get_option( 'pgssl_settings_debug_mode_enabled' ); 
?>
<a name="debug-mode"></a>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Debug mode", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php _pgssl_e('The <b>Debug mode</b> is an internal development tool built to track every action made by PGS Social Login during the authentication proces, which can be useful when debugging this plugin but note that it is highly technical and not documented', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('When Debug mode is enabled and set to <code>Log actions in a file</code>, PGS Social Login will attempt to generate its log files under <em>/wp-content/uploads/pgssl-logs</em>', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('When Debug mode is enabled and set to <code>Log actions to database</code>, will create a new database table <code>pgssl_watchdog</code> and insert all actions names and arguments', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('For more information, refer to PGS Social Login documentation under Advanced Troubleshooting &gt; <a href="http://miled.github.io/wordpress-social-login/troubleshooting-advanced.html" target="_blank">Debug Mode</a>', 'pgssl-text-domain') ?>.
		</p>

		<form method="post" id="pgssl_setup_form" action="options.php">  
			<?php settings_fields( 'pgssl_settings-group-debug' ); ?>

			<select name="pgssl_settings_debug_mode_enabled">
				<option <?php if(    ! $pgssl_settings_debug_mode_enabled ) echo "selected"; ?> value="0"><?php _pgssl_e("Disabled", 'pgssl-text-domain') ?></option> 
				<option <?php if( $pgssl_settings_debug_mode_enabled == 1 ) echo "selected"; ?> value="1"><?php _pgssl_e("Enabled &mdash; Log actions in a file", 'pgssl-text-domain') ?></option>
				<option <?php if( $pgssl_settings_debug_mode_enabled == 2 ) echo "selected"; ?> value="2"><?php _pgssl_e("Enabled &mdash; Log actions to database", 'pgssl-text-domain') ?></option>
			</select>

			<input type="submit" class="button-primary" value="<?php _pgssl_e("Save Settings", 'pgssl-text-domain') ?>" />

			<?php if( $pgssl_settings_debug_mode_enabled ): ?>
				<a class="button-secondary" href="admin.php?page=pgssl_settings&pgssl_page=watchdog"><?php _pgssl_e('View PGS Social Login logs', 'pgssl-text-domain') ?></a>
			<?php endif; ?>
		</form>
	</div>
</div>	
<?php
}

function pgssl_component_tools_development_mode() {
	$pgssl_settings_development_mode_enabled = get_option( 'pgssl_settings_development_mode_enabled' ); 
?>
<a name="dev-mode"></a>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Development mode", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('When <b>Development Mode</b> is enabled, this plugin will display a debugging area on the footer of admin interfaces. <b>Development Mode</b> will also try generate and display a technical reports when something goes wrong. This report can help you figure out the root of the issues you may runs into', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('Please, do not enable <b>Development Mode</b>, unless you are a developer or you have basic PHP knowledge', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('For security reasons, <b>Development Mode</b> will auto switch to <b>Disabled</b> each time the plugin is <b>reactivated</b>', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('It\'s highly recommended to keep the <b>Development Mode</b> <b style="color:#da4f49">Disabled</b> on production as it would be a security risk otherwise', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e('For more information, refer to PGS Social Login documentation under Advanced Troubleshooting &gt; <a href="http://miled.github.io/wordpress-social-login/troubleshooting-advanced.html" target="_blank">Development Mode</a>', 'pgssl-text-domain') ?>.
		</p>

		<form method="post" id="pgssl_setup_form" action="options.php" <?php if( ! $pgssl_settings_development_mode_enabled ) { ?>onsubmit="return confirm('Do you really want to enable Development Mode?\n\nPlease confirm that you have read and understood the abovementioned by clicking OK.');"<?php } ?>>  
			<?php settings_fields( 'pgssl_settings-group-development' ); ?>

			<select name="pgssl_settings_development_mode_enabled">
				<option <?php if( ! $pgssl_settings_development_mode_enabled ) echo "selected"; ?> value="0"><?php _pgssl_e("Disabled", 'pgssl-text-domain') ?></option> 
				<option <?php if(   $pgssl_settings_development_mode_enabled ) echo "selected"; ?> value="1"><?php _pgssl_e("Enabled", 'pgssl-text-domain') ?></option>
			</select>

			<input type="submit" class="button-danger" value="<?php _pgssl_e("Save Settings", 'pgssl-text-domain') ?>" />
		</form>
	</div>
</div>
<?php
}

function pgssl_component_tools_uninstall() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Uninstall", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside"> 
		<p>
			<?php _pgssl_e('This will permanently delete all Wordpress Social Login tables and stored options from your WordPress database', 'pgssl-text-domain') ?>. 
			<?php _pgssl_e('Once you delete PGS Social Login database tables and stored options, there is NO going back. Please be certain', 'pgssl-text-domain') ?>. 
		</p>

		<a class="button-danger" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=uninstall'); ?>" onClick="return confirm('Do you really want to Delete all Wordpress Social Login tables and options?\n\nPlease confirm that you have read and understood the abovementioned by clicking OK.');"><?php _pgssl_e("Delete all Wordpress Social Login tables and options", 'pgssl-text-domain') ?></a>
	</div>
</div>
<?php
}
