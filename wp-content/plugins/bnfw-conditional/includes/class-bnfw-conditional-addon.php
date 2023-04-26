<?php

/**
 * Class BNFW_Conditional_Addon.
 *
 * @since 1.0
 */
class BNFW_Conditional_Addon {
	/**
	 * Load everything.
	 */
	public function load() {
		add_action( 'bnfw_after_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'bnfw_after_notification_dropdown', array( $this, 'add_conditional_selects' ) );
		add_action( 'bnfw_after_notification_dropdown', array( $this, 'add_user_role_selects' ) );
		add_action( 'bnfw_after_notification_dropdown', array( $this, 'add_user_role_select' ) );

		add_filter( 'bnfw_notification_setting_fields', array( $this, 'add_notification_setting_field' ) );
		add_filter( 'bnfw_notification_setting', array( $this, 'save_notification_setting' ) );

		add_action( 'wp_ajax_bnfw_get_notification_post_type', array( $this, 'ajax_get_notification_post_type' ) );
		add_action( 'wp_ajax_bnfw_get_taxonomies', array( $this, 'ajax_get_taxonomies' ) );
		add_action( 'wp_ajax_bnfw_get_terms', array( $this, 'ajax_get_terms' ) );

		add_filter( 'bnfw_notification_disabled', array( $this, 'disable_notification' ), 10, 3 );

		add_filter( 'bnfw_trigger_admin-role_notification', array( $this, 'disable_notification_based_on_two_roles' ), 10, 4 );
		add_filter( 'bnfw_trigger_user-role_notification', array( $this, 'disable_notification_based_on_two_roles' ), 10, 4 );

		add_filter( 'bnfw_trigger_welcome-email_notification', array( $this, 'disable_notification_based_on_role' ), 10, 3 );
		add_filter( 'bnfw_trigger_new-user_notification', array( $this, 'disable_notification_based_on_role' ), 10, 3 );
	}

	/**
	 * Enqueue additional scripts.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'bnfw-conditional-addon', plugins_url( 'assets/js/bnfw-conditional.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0', true );
	}

	/**
	 * Add user role conditional selects.
	 *
	 * @since 1.0.4
	 *
	 * @param array $setting Settings array.
	 */
	public function add_user_role_selects( $setting ) {
		$from_user_role = isset( $setting['from-user-role'] ) ? $setting['from-user-role'] : '';
		$to_user_role   = isset( $setting['to-user-role'] ) ? $setting['to-user-role'] : '';
		?>

		<tr valign="top" id="bnfw-user-role-selects" class="hidden">
			<th scope="row">
				<?php _e( 'Send Notification only if', 'bnfw' ); ?>
				<div class="bnfw-help-tip"><p><?php esc_html_e( 'Only send this notification if the user\'s role is changed between these two roles.', 'bnfw' ); ?></p></div>
			</th>

			<td>
				<?php esc_html_e( 'User Role changed from ', 'bnfw' ); ?>
				<select id="from-user-role" name="from-user-role" style="width:20%">
					<option value="0"><?php esc_html_e( 'Select User Role', 'bnfw' ); ?></option>
					<?php wp_dropdown_roles( $from_user_role ); ?>
				</select>

				<span><?php _e( 'to', 'bnfw' ); ?></span>

				<select id="to-user-role" name="to-user-role" style="width:20%">
					<option value="0"><?php esc_html_e( 'Select User Role', 'bnfw' ); ?></option>
					<?php wp_dropdown_roles( $to_user_role ); ?>
				</select>
			</td>
		</tr>
		<?php
	}

	/**
	 * Add user role conditional select.
	 *
	 * @since 1.0.4
	 *
	 * @param array $setting Settings array.
	 */
	public function add_user_role_select( $setting ) {
		$new_user_role   = isset( $setting['new-user-role'] ) ? $setting['new-user-role'] : '';
		?>

		<tr valign="top" id="bnfw-user-role-select" class="hidden">
			<th scope="row">
				<?php _e( 'Send Notification only if the user belongs to', 'bnfw' ); ?>
				<div class="bnfw-help-tip"><p><?php esc_html_e( 'Only send this notification if the user is assigned to this user role.', 'bnfw' ); ?></p></div>
			</th>

			<td>
				<select id="new-user-role" name="new-user-role" style="width:20%">
					<option value="0"><?php esc_html_e( 'All User Roles', 'bnfw' ); ?></option>
					<?php wp_dropdown_roles( $new_user_role ); ?>
				</select>
			</td>
		</tr>
		<?php
	}

	/**
	 * Add conditional selects.
	 *
	 * @since 1.0
	 *
	 * @param array $setting Settings array.
	 */
	public function add_conditional_selects( $setting ) {
		$post_type         = '';
		$select_taxonomies = isset( $setting['taxonomies'] ) ? $setting['taxonomies'] : '';
		$select_terms      = isset( $setting['terms'] ) ? $setting['terms'] : array();
		$css_class         = 'hidden';

		if ( ! empty( $select_taxonomies ) ) {
			$post_type = $this->get_notification_post_type( $setting['notification'] );
			$css_class = '';
		}
		?>
		<tr valign="top" id="bnfw-conditional-selects" class="<?php echo $css_class; ?>">
			<th scope="row">
				<?php _e( 'Send Notification only if', 'bnfw' ); ?>
				<div class="bnfw-help-tip"><p><?php esc_html_e( 'Only send this notification if the post/page is in a chosen category / tag / taxonomy. You can limit the notification by one or multiple categories / tags / terms. You can leave these fields blank if you don\'t want to use them for this notification.', 'bnfw' ); ?></p></div>
			</th>
			<td>
				<select id="bnfw-taxonomies" name="bnfw-taxonomies" style="width:20%" data-placeholder="<?php _e( 'Select Taxonomy', 'bnfw' ); ?>">
					<option value="-1" <?php selected( '-1', $select_taxonomies ); ?>>
						<?php _e( '- Choose Taxonomy -', 'bnfw' ); ?>
					</option>
					<?php if ( ! empty( $post_type ) ) {
						$taxonomies = get_object_taxonomies( $post_type, 'objects' );

						foreach ( $taxonomies as $taxonomy ) { ?>
							<option
								value="<?php echo $taxonomy->name; ?>" <?php selected( $taxonomy->name, $select_taxonomies ); ?>>
								<?php echo $taxonomy->label; ?>
							</option>
						<?php }
					} ?>
				</select>

				<span><?php _e( 'match', 'bnfw' ); ?></span>

				<select id="bnfw-terms" name="bnfw-terms[]" multiple="multiple" style="min-width: 48.1%;" size="1"
				        data-placeholder="<?php _e( 'Any', 'bnfw' ); ?>">
					<?php if ( ! empty( $post_type ) && ! empty( $select_taxonomies ) ) {
						$terms = get_terms( array( 'taxonomy' => $select_taxonomies, 'hide_empty' => false ) );

						if ( ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) { ?>
								<option
									value="<?php echo $term->term_id; ?>" <?php selected( in_array( $term->term_id, $select_terms ) ); ?>>
									<?php echo $term->name; ?>
								</option>
								<?php
							}
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get post type from Notification name.
	 *
	 * @param string $notification Notification name.
	 *
	 * @return string Post type.
	 */
	private function get_notification_post_type( $notification ) {
		$post_type          = '';
		$post_prefixes      = array( 'new', 'update', 'pending', 'private', 'future', 'comment', 'commentreply' );
		$post_notifications = array( 'new-comment', 'new-trackback', 'new-pingback', 'reply-comment' );
		$exclude            = array( 'new-user' );

		if ( ! in_array( $notification, $exclude ) ) {
			if ( in_array( $notification, $post_notifications ) ) {
				$post_type = 'post';
			} else {
				$splits = explode( '-', $notification );
				if ( count( $splits ) >= 2 ) {
					if ( in_array( $splits[0], $post_prefixes ) ) {
						$post_type = implode( '-', array_slice( $splits, 1 ) );
					}
				}
			}
		}

		return apply_filters( 'bnfw_notification_post_type', $post_type, $notification );
	}

	/**
	 * Is the notification a comment notification?
	 *
	 * @param string $notification Notification name.
	 *
	 * @return bool True if it is a comment notification, False otherwise.
	 */
	private function is_comment_notification( $notification ) {
		$is_comment_notification = false;
		$comment_notifications   = array( 'new-comment', 'new-trackback', 'new-pingback', 'reply-comment' );
		$comment_prefixes        = array( 'comment', 'commentreply' );

		if ( in_array( $notification, $comment_notifications ) ) {
			$is_comment_notification = true;
		} else {
			$splits = explode( '-', $notification );
			if ( count( $splits ) == 2 ) {
				if ( in_array( $splits[0], $comment_prefixes ) ) {
					$is_comment_notification = true;
				}
			}
		}

		return apply_filters( 'bnfw_comment_notification', $is_comment_notification, $notification );
	}

	/**
	 * Handle ajax request to get notification post type.
	 */
	public function ajax_get_notification_post_type() {
		$notification = sanitize_text_field( $_GET['notification'] );

		echo $this->get_notification_post_type( $notification );
		wp_die();
	}

	/**
	 * Get the list of taxonomies for a post type.
	 */
	public function ajax_get_taxonomies() {
		$data       = array();
		$post_type  = sanitize_text_field( $_GET['post_type'] );
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		foreach ( $taxonomies as $taxonomy ) {
			$data[] = array(
				'id'   => $taxonomy->name,
				'text' => $taxonomy->label,
			);
		}

		echo json_encode( $data );
		wp_die();
	}

	/**
	 * Get the list of terms for a taxonomy.
	 */
	public function ajax_get_terms() {
		$data     = array();
		$taxonomy = sanitize_text_field( $_GET['taxonomy'] );
		$terms    = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );

		foreach ( $terms as $term ) {
			$data[] = array(
				'id'   => $term->term_id,
				'text' => $term->name,
			);
		}

		echo json_encode( $data );
		wp_die();
	}

	/**
	 * Add new fields to notification settings.
	 *
	 * @since 1.0
	 *
	 * @param array $fields List of existing fields.
	 *
	 * @return array New list of fields.
	 */
	public function add_notification_setting_field( $fields ) {
		$fields['taxonomies'] = '';
		$fields['terms']      = array();

		$fields['from-user-role'] = '';
		$fields['to-user-role']   = '';

		$fields['new-user-role']  = '';

		return $fields;
	}

	/**
	 * Save Notification setting.
	 *
	 * @since 1.0
	 *
	 * @param array $setting Notification setting
	 *
	 * @return array Modified Notification setting
	 */
	public function save_notification_setting( $setting ) {
		if ( isset( $_POST['bnfw-taxonomies'] ) ) {
			$setting['taxonomies'] = sanitize_text_field( $_POST['bnfw-taxonomies'] );
		} else {
		    $setting['taxonomies'] = '-1';
        }

		if ( isset( $_POST['bnfw-terms'] ) ) {
			if ( ! is_array( $_POST['bnfw-terms'] ) ) {
			    $terms = array( $_POST['bnfw-terms'] );
            } else {
			    $terms = $_POST['bnfw-terms'];
            }

			$setting['terms'] = array_map( 'absint', $terms );
		} else {
		    $setting['terms'] = array();
        }

		if ( isset( $_POST['from-user-role'] ) ) {
			$setting['from-user-role'] = sanitize_text_field( $_POST['from-user-role'] );
		} else {
			$setting['from-user-role'] = '';
		}

		if ( isset( $_POST['to-user-role'] ) ) {
			$setting['to-user-role'] = sanitize_text_field( $_POST['to-user-role'] );
		} else {
			$setting['to-user-role'] = '';
		}

		if ( isset( $_POST['new-user-role'] ) ) {
			$setting['new-user-role'] = sanitize_text_field( $_POST['new-user-role'] );
		} else {
			$setting['new-user-role'] = '';
		}

		return $setting;
	}

	/**
	 * Should a notification be disabled.
	 *
	 * @param bool  $disabled Current disabled state.
	 * @param int   $id       Post id.
	 * @param array $setting  Notification settings.
	 *
	 * @return bool True if notification should be disabled, False otherwise
	 */
	public function disable_notification( $disabled, $id, $setting ) {
		$post_type = $this->get_notification_post_type( $setting['notification'] );
		$post_id   = $id;

		if ( ! empty( $post_type ) ) {
			if ( isset( $setting['taxonomies'] ) && '-1' != $setting['taxonomies'] &&
				 isset( $setting['terms'] ) && is_array( $setting['terms'] ) && ! empty( $setting['terms'] ) ) {

				if ( $this->is_comment_notification( $setting['notification'] ) ) {
					$the_comment = get_comment( $id );
					$post_id     = $the_comment->comment_post_ID;
				}

				$terms = get_the_terms( $post_id, $setting['taxonomies'] );
				foreach ( $terms as $term ) {
					if ( in_array( $term->term_id, $setting['terms'] ) ) {
						return false;
					}
				}

				return true;
			}
		}

		return $disabled;
	}

	/**
	 * Disable new user notification based on user role.
	 *
	 * @param bool     $enabled True, if enabled, false otherwise.
	 * @param array    $setting Notification settings.
	 * @param \WP_User $user    User object.
	 *
	 * @return bool True, if enabled, False otherwise.
	 */
	public function disable_new_user_notification( $enabled, $setting, $user ) {
		$user_role = $setting['new-user-role'];

		if ( empty( $user_role ) ) {
			return $enabled;
		}

		if ( empty( $user->roles ) or ! is_array( $user->roles ) ) {
			return $enabled;
		}

		return in_array( $user_role, $user->roles );
	}

	/**
	 * Disable user role notification if needed.
	 *
	 * @param bool     $enabled      True, if enabled, false otherwise.
	 * @param \WP_Post $notification Notification Post object.
	 * @param string   $new_role     New user role.
	 * @param array    $old_roles    Old user roles.
	 *
	 * @return bool True, if enabled, False otherwise.
	 */
	public function disable_notification_based_on_two_roles( $enabled, $notification, $new_role, $old_roles ) {
		$bnfw = BNFW::factory();
		$setting  = $bnfw->notifier->read_settings( $notification->ID );

		$from_user_role = $setting['from-user-role'];
		$to_user_role = $setting['to-user-role'];

		if ( empty( $from_user_role ) && empty( $to_user_role ) ) {
			return $enabled;
		}

		if ( empty( $from_user_role ) ) {
			return ( $new_role === $to_user_role );
		}

		if ( empty( $to_user_role ) ) {
			return in_array( $from_user_role, $old_roles );
		}

		return ( ( $new_role === $to_user_role ) ) && ( in_array( $from_user_role, $old_roles ) );
	}

	/**
	 * Should the welcome email notification be disabled?
	 *
	 * @param bool     $enabled Is the welcome email notification disabled? Default True.
	 * @param array    $setting Notification setting.
	 * @param \WP_User $user    User object.
	 *
	 * @return bool Whether the welcome email notification should be disabled.
	 */
	public function disable_notification_based_on_role( $enabled, $setting, $user ) {
		$new_user_role = $setting['new-user-role'];

		if ( empty( $new_user_role ) ) {
			return $enabled;
		}

		if ( empty( $user->roles ) or ! is_array( $user->roles ) ) {
			return $enabled;
		}

		if ( ! in_array( $new_user_role, $user->roles ) ) {
			return false;
		}

		return $enabled;
	}
}
