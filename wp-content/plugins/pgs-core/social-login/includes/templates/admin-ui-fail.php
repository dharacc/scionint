<?php do_action( "pgssl_admin_ui_fail_start" ); ?>
<div class="pgssl-settings-meta-box-wrap">
	<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #e5e5e5;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);padding:20px;">
		<h1><?php _e("PGS Social Login - FAIL!", 'pgssl-text-domain') ?></h1>

		<hr />

		<p>
			<?php _e('Despite the efforts, put into <b>PGS Social Login</b> in terms of reliability, portability, and maintenance by the plugin <a href="http://profiles.wordpress.org/miled/" target="_blank">author</a> and <a href="https://github.com/hybridauth/WordPress-Social-Login/graphs/contributors" target="_blank">contributors</a>', 'pgssl-text-domain') ?>.
			<b style="color:red;"><?php _e('Your server failed the requirements check for this plugin', 'pgssl-text-domain') ?>:</b>
		</p>

		<p>
			<?php _e('These requirements are usually met by default by most "modern" web hosting providers, however some complications may occur with <b>shared hosting</b> and, or <b>custom wordpress installations</b>', 'pgssl-text-domain') ?>.
		</p>

		<p>
			<?php _pgssl_e("The minimum server requirements are", 'pgssl-text-domain') ?>:
		</p>

		<ul style="margin-left:60px;">
			<li><?php _pgssl_e("PHP >= 7.2.0 installed", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("PGSSL Endpoint URLs reachable", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("PHP's default SESSION handling", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("PHP/CURL/SSL Extension enabled", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("PHP/JSON Extension enabled", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("PHP/REGISTER_GLOBALS Off", 'pgssl-text-domain') ?></li>
			<li><?php _pgssl_e("jQuery installed on WordPress backoffice", 'pgssl-text-domain') ?></li>
		</ul>
	</div>
	<?php
	include_once( trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'includes/admin/components/tools/components.tools.actions.job.php' );

	pgssl_component_tools_do_diagnostics();
	?>
</div>
<style>.pgssl-settings-meta-box-wrap .button-secondary { display:none; }</style>
<?php
do_action( "pgssl_admin_ui_fail_end" );