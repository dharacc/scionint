<?php
function pgssl_load_social_login_gutenblock() {
	wp_enqueue_script(
		'my-new-block',
		PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/js/pgssl-block.js',
		array('wp-blocks','wp-editor'),
		true
	);
}
add_action('enqueue_block_editor_assets', 'pgssl_load_social_login_gutenblock');