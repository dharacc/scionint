<?php
/**
* Wannabe Users Manager module
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_users() {
	// HOOKABLE: 
	do_action( "pgssl_component_users_start" );

	include "components.users.list.php";
	include "components.users.profiles.php";

	if( isset( $_REQUEST["uid"] ) && $_REQUEST["uid"] ){
		$user_id = (int) $_REQUEST["uid"];

		pgssl_component_users_profiles( $user_id );
	} else {
		pgssl_component_users_list();
	}

	// HOOKABLE: 
	do_action( "pgssl_component_users_end" );
}

pgssl_component_users();
