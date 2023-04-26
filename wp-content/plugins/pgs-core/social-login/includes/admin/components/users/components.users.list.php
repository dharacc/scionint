<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_users_list() {
	// HOOKABLE:
	do_action( "pgssl_component_users_list_start" );

	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';

	add_thickbox();

	pgssl_component_users_delete_social_profiles();

	$actions = array(
		'edit_details' => '<a class="button button-secondary thickbox" href="' . admin_url( 'users.php?TB_iframe=true&width=1050&height=550' ) . '">' . _pgssl__( 'View all your website users', 'pgssl-text-domain' ) . '</a>',
	);

	// HOOKABLE:
	$actions = apply_filters( 'pgssl_component_users_list_alter_actions_list', $actions );
	?>
	<div style="padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
		<p style="float: <?php if( is_rtl() ) echo 'left'; else echo 'right'; ?>; margin: -5px;">
			<?php echo implode( ' ', $actions );?>
		</p>

		<?php _pgssl_e( "This screen only list the users who have connected through PGS Social Login", 'pgssl-text-domain' ) ?>.
	</div>
	<?php

		$pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit        = 25; // number of rows in page
		$offset       = ( $pagenum - 1 ) * $limit;
		$total        = pgssl_get_stored_hybridauth_user_profiles_count();
		$num_of_pages = ceil( $total / $limit );
		$users_list   = pgssl_get_stored_hybridauth_user_profiles_grouped_by_user_id( $offset, $limit );
	?>
	<table cellspacing="0" class="wp-list-table widefat fixed users">
		<thead>
			<tr>
				<th width="100"><span><?php _pgssl_e("Providers", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Username", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Full Name", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("E-mail", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Profile URL", 'pgssl-text-domain') ?></span></th>
				<th width="80"><span><?php _pgssl_e("Contacts", 'pgssl-text-domain') ?></span></th>
				<th width="55"><span><?php _pgssl_e("User ID", 'pgssl-text-domain') ?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th width="100"><span><?php _pgssl_e("Providers", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Username", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Full Name", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("E-mail", 'pgssl-text-domain') ?></span></th>
				<th><span><?php _pgssl_e("Profile URL", 'pgssl-text-domain') ?></span></th>
				<th width="80"><span><?php _pgssl_e("Contacts", 'pgssl-text-domain') ?></span></th>
				<th width="55"><span><?php _pgssl_e("User ID", 'pgssl-text-domain') ?></span></th>
			</tr>
		</tfoot>
		<tbody data-wp-lists="list:user" id="the-list">
			<?php
			$i = 0;

			// have users?
			if( ! $users_list ) {
				?>
					<tr class="no-items"><td colspan="5" class="colspanchange"><?php _pgssl_e("No users found", 'pgssl-text-domain') ?>.</td></tr>
				<?php
			} else {
				foreach( $users_list as $items ) {
					$user_id = $items->user_id;
					$pgssl_user_image = $items->photourl;

					$user_data = get_userdata( $user_id );

					if( ! $user_data ) {
						continue;
					}

					$linked_accounts = pgssl_get_stored_hybridauth_user_profiles_by_user_id( $user_id );
				?>
					<tr class="<?php if( ++$i % 2 ) echo "alternate" ?> tr-contacts">
						<td nowrap>
							<?php
								foreach( $linked_accounts AS $link ) {
									?>
										<img src="<?php echo $assets_base_url . strtolower( $link->provider ) . '.png' ?>" style="vertical-align:top;width:16px;height:16px;" /> <?php _pgssl_e($link->provider, 'pgssl-text-domain') ?><br />
									<?php

									if( $link->photourl ) {
										$pgssl_user_image = $link->photourl;
									}
								}
							?>
						</td>
						<td class="column-author">
							<?php if( $pgssl_user_image ) { ?>
								<img width="32" height="32" class="avatar avatar-32 photo" src="<?php echo $pgssl_user_image ?>" >
							<?php } else { ?>
								<img width="32" height="32" class="avatar avatar-32 photo" src="http://www.gravatar.com/avatar/<?php echo md5( strtolower( trim( $user_data->user_email ) ) ); ?>" >
							<?php } ?>

							<strong><a href="admin.php?page=pgssl_settings&pgssl_page=users&uid=<?php echo $user_id ?>"><?php echo $user_data->user_login; ?></a></strong>

							<div class="row-actions">
								<span class="view">
									<a href="admin.php?page=pgssl_settings&pgssl_page=users&uid=<?php echo $user_id ?>"><?php _pgssl_e("Profiles", 'pgssl-text-domain') ?></a>
									|
								</span>

								<span class="view">
									<a href="admin.php?page=pgssl_settings&pgssl_page=contacts&uid=<?php echo $user_id ?>"><?php _pgssl_e("Contacts", 'pgssl-text-domain') ?></a>
									|
								</span>

								<span class="delete">
									<?php
										$delete_url = wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=users&delete=' . $user_id );
									?>
									<a style="color: #a00;" href="<?php echo $delete_url ?>" onClick="return confirmDeletePGSSLUser();"><?php _pgssl_e("Delete", 'pgssl-text-domain') ?></a>
								</span>
							</div>
						</td>
						<td><?php echo $user_data->display_name; ?></td>
						<td>
							<?php if( ! strstr( $user_data->user_email, "@example.com" ) ) { ?>
								<a href="mailto:<?php echo $user_data->user_email; ?>"><?php echo $user_data->user_email; ?></a>
							<?php } else { ?>
								-
							<?php } ?>
						</td>
						<td>
							<?php if( $user_data->user_url ) { ?>
								<a href="<?php echo $user_data->user_url; ?>" target="_blank"><?php echo str_ireplace( array("http://www.", "https://www.", "http://","https://"), array('','','','',''), $user_data->user_url ) ?></a>
							<?php } else { ?>
								-
							<?php } ?>
						</td>
						<td align="center">
							<?php
								$counts = pgssl_get_stored_hybridauth_user_contacts_count_by_user_id( $user_id );

								if( $counts ) {
									?>
										<a href="admin.php?page=pgssl_settings&pgssl_page=contacts&uid=<?php echo $user_id ?>"><?php echo $counts; ?></a>
									<?php
								} else {
									echo "0";
								}
							?>
						<td align="center"><a class="thickbox" href="<?php echo admin_url( 'user-edit.php?user_id=' . $user_data->ID . '&TB_iframe=true&width=1150&height=550' ); ?>"><?php echo $user_data->ID; ?></a></td>
					</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
	<?php
	$page_links = paginate_links( array(
		'base' => add_query_arg( 'pagenum', '%#%' ),
		'format' => '',
		'prev_text' => __( '&laquo;', 'text-domain' ),
		'next_text' => __( '&raquo;', 'text-domain' ),
		'total' => $num_of_pages,
		'current' => $pagenum
	));

	if( $page_links ) {
		echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
	}
	?>
	<script>
	function confirmDeletePGSSLUser() {
		return confirm( <?php echo json_encode( _pgssl__("Are you sure you want to delete the user's social profiles and contacts?\n\nNote: The associated WordPress user won't be deleted.", 'pgssl-text-domain') ) ?> );
	}
	</script>
	<?php
	do_action( "pgssl_component_users_list_end" );
}

function pgssl_component_users_delete_social_profiles() {
	// If action eq delete user profiles
	if( isset( $_REQUEST['delete'] ) && isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'] ) ) {
		$uid = (int) $_REQUEST['delete'];

		$user_data = get_userdata( $uid );

		if( $user_data ) {
			pgssl_delete_stored_hybridauth_user_data( $uid  );

			?>
				<div class="fade updated" style="margin: 0px 0px 10px;">
					<p>
						<?php echo sprintf( _pgssl__( "PGSSL user ID #%d: <b>%s</b>  profiles and contacts has been deleted. Note that the associated WordPress user wasn't deleted", 'pgssl-text-domain'), $uid, $user_data->user_login ) ?>.
					</p>
				</div>
			<?php
		}
	}

}
