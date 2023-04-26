<?php
/**
 * PGS_Meataboxs
 *
 * @package Pgs Core
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! class_exists( 'PGS_Meataboxs' ) ) {
	/**
	 * Custom Metaboxes.
	 */
	class PGS_Meataboxs {

		/**
		 * Meta field callback.
		 *
		 * @var string
		 */
		public $callback = 'meta_callback';

		/**
		 * Taxonomy meta field callback.
		 *
		 * @var string
		 */
		public $taxonomy_add_meta_callback = 'taxonomy_add_meta_callback';

		/**
		 * Taxonomy meta field callback.
		 *
		 * @var string
		 */
		public $taxonomy_edit_meta_callback = 'taxonomy_edit_meta_callback';

		/**
		 * Meta save callback.
		 *
		 * @var string
		 */
		public $meta_save = 'meta_save';

		/**
		 * Meta register callback.
		 *
		 * @var string
		 */
		public $meta_register = 'meta_register';

		/**
		 * Option page save callback.
		 *
		 * @var string
		 */
		public $option_page_save_changes = 'option_page_save_changes';

		/**
		 * Option page save callback.
		 *
		 * @var string
		 */
		public $add_new_meta_field = 'add_new_meta_field';
		
		/**
		 * Option page save callback.
		 *
		 * @var string
		 */
		public $meta_get_oembed = 'meta_get_oembed';

		/**
		 * Option page html callback.
		 *
		 * @var string
		 */
		public $option_page_html_callback = 'option_page_html_callback';
		
		/**
		 * Option page html callback.
		 *
		 * @var string
		 */
		public $post_object_ajax_results = 'post_object_ajax_results';

		/**
		 * Admin menu page html callback.
		 *
		 * @var string
		 */
		public $admin_menu = 'admin_menu';

		/**
		 * Meta fields.
		 *
		 * @var array
		 */
		public $fields = array();

		/**
		 * A dummy constructor to prevent this class from being loaded more than once.
		 *
		 * @param array $fields_arg fild arguments.
		 */
		public function __construct( $fields_arg ) {

			$this->fields = $fields_arg;

			if ( isset( $fields_arg['screen'] ) && $fields_arg['screen'] ) {
				if ( 'taxonomy' === $fields_arg['screen'] ) {
					if ( isset( $fields_arg['taxonomy'] ) && $fields_arg['taxonomy'] ) {						
						if ( is_array( $fields_arg['taxonomy'] ) ) {
							foreach ( $fields_arg['taxonomy'] as $tax ) {
								add_action( $tax . '_add_form_fields', array( $this, $this->taxonomy_add_meta_callback ), 10, 1 );
								add_action( $tax . '_edit_form_fields', array( $this, $this->taxonomy_edit_meta_callback ), 10, 2 );
								add_action( 'edited_' . $tax, array( $this, $this->meta_save ), 10, 2 );
								add_action( 'create_' . $tax, array( $this, $this->meta_save ), 10, 2 );
							}
						} else {
							add_action( $fields_arg['taxonomy'] . '_add_form_fields', array( $this, $this->taxonomy_add_meta_callback ), 10, 1 );
							add_action( $fields_arg['taxonomy'] . '_edit_form_fields', array( $this, $this->taxonomy_edit_meta_callback ), 10, 2 );
							add_action( 'edited_' . $fields_arg['taxonomy'], array( $this, $this->meta_save ), 10, 2 );
							add_action( 'create_' . $fields_arg['taxonomy'], array( $this, $this->meta_save ), 10, 2 );
						}
					}
				} elseif ( 'options_fields' === $fields_arg['screen'] ) {

					add_action( 'admin_menu', array( $this, $this->admin_menu ), 10, 0 );
					add_action( 'admin_post_save_options_fields', array( $this, $this->option_page_save_changes ) );

				} else {

					add_action( 'add_meta_boxes', array( $this, $this->meta_register ) );
					add_action( 'save_post', array( $this, $this->meta_save ) );
				}

				add_action( 'wp_ajax_add_new_meta_field', array( $this, $this->add_new_meta_field ) );
				add_action( 'wp_ajax_nopriv_add_new_meta_field', array( $this, $this->add_new_meta_field ) );
				
				add_action( 'wp_ajax_meta_get_oembed', array( $this, $this->meta_get_oembed ) );
				add_action( 'wp_ajax_nopriv_meta_get_oembed', array( $this, $this->meta_get_oembed ) );
				
				add_action( 'wp_ajax_post_object_ajax_results', array( $this, $this->post_object_ajax_results ) );
				add_action( 'wp_ajax_nopriv_post_object_ajax_results', array( $this, $this->post_object_ajax_results ) );
			}

			// Add scripts for the metbox fields
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_metabox_scripts' ) );
		}

		/**
		 * Add script for metabox fields
		 */
		public function enqueue_metabox_scripts() {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_register_script( 'pgs-metabox', trailingslashit( PGSCORE_URL ) . '/includes/meta-boxes/assets/js/pgs-meta-boxes.js', array( 'jquery', 'wp-color-picker', 'select2', 'jquery-ui-draggable' ) );
			wp_enqueue_style( 'pgs-metabox', trailingslashit( PGSCORE_URL ) . '/includes/meta-boxes/assets/css/pgs-meta-boxes.css' );

			$pgs_localize = array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'pgs_url'                 => PGSCORE_URL,
				'meta_post_object_nonce'  => wp_create_nonce( 'meta_post_object_nonce' ),
				'repeter_add_field_nonce' => wp_create_nonce( 'repeter_add_field_nonce' ),
				'meta_get_oembed_nonce'   => wp_create_nonce( 'meta_get_oembed_nonce' ),
				'choose'                  => esc_html__( 'choose', 'pgs-core' ),
				'update'                  => esc_html__( 'update', 'pgs-core' ),
				'remove_image'            => esc_html__( 'Remove Image', 'pgs-core' ),
				'file_name'               => esc_html__( 'File name:', 'pgs-core' ),
				'remove'                  => esc_html__( 'Remove', 'pgs-core' ),
				'upload_image'            => esc_html__( 'Upload Image', 'pgs-core' ),
			);

			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'select2' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'pgs-select2', get_parent_theme_file_uri( '/css/select2.min.css' ), array(), '3.5.2' );
			wp_localize_script( 'pgs-metabox', 'pgs', $pgs_localize );
			wp_enqueue_script( 'pgs-metabox', 'pgs', $pgs_localize );
		}

		/**
		 * Add admin menu for option page.
		 */
		public function admin_menu() {

			$fields_arg  = $this->fields;
			$parent_slug = isset( $fields_arg['parent_slug'] ) ? $fields_arg['parent_slug'] : '';
			$page_title  = isset( $fields_arg['page_title'] ) ? $fields_arg['page_title'] : '';
			$menu_title  = isset( $fields_arg['menu_title'] ) ? $fields_arg['menu_title'] : '';
			$capability  = isset( $fields_arg['capability'] ) ? $fields_arg['capability'] : '';
			$menu_slug   = isset( $fields_arg['menu_slug'] ) ? $fields_arg['menu_slug'] : '';
			$icon_url    = isset( $fields_arg['icon_url'] ) ? $fields_arg['icon_url'] : null;
			$position    = isset( $fields_arg['position'] ) ? $fields_arg['position'] : null;
			if ( $fields_arg && $page_title && $menu_title && $capability && $menu_slug && 'options_fields' === $fields_arg['screen'] ) {
				if ( ! empty( $parent_slug ) ) {
					add_submenu_page(
						$parent_slug,
						$page_title,
						$menu_title,
						$capability,
						$menu_slug,
						array(
							$this,
							$this->option_page_html_callback,
						),
						$position
					);
				} else {
					add_menu_page(
						$page_title,
						$menu_title,
						$capability,
						$menu_slug,
						array(
							$this,
							$this->option_page_html_callback,
						),
						$icon_url,
						$position
					);
				}
			}
		}

		/**
		 * Html callback for option page.
		 */
		public function option_page_html_callback() {

			if ( ! isset( $this->fields['fields'] ) && ! $this->fields['fields'] ) {
				return;
			}

			if ( ! isset( $this->fields['menu_slug'] ) && ! $this->fields['menu_slug'] ) {
				return;
			}
			?>
			<div id="pgs-options-metaboxes-general" class="wrap">
				<?php
				if ( isset( $this->fields['title'] ) ) {
					?>
					<h2><?php echo esc_html( $this->fields['title'] ); ?></h2>
					<?php
				}
				?>
				<form action="admin-post.php" method="post">
					<input type="hidden" name="action" value="save_options_fields" />
					<input type="hidden" name="_wp_http_referer" value="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->fields['menu_slug'] ) ); ?>" />
					<div id="poststuff" class="metabox-holder">
						<div class="pgs-helper-options-meta-fields-container pgs-option-page-settings">
							<?php
							$field_tabs        = array();
							$tab_count         = 0;
							$conditional_logic = '';

							if ( ! isset( $this->fields['fields'] ) && ! $this->fields['fields'] ) {
								return;
							}

							wp_nonce_field( basename( __FILE__ ), 'pgs-optionfield-nonce' );

							foreach ( $this->fields['fields']  as $field ) {
								if ( is_array( $field ) ) {
									if ( isset( $field['type'] ) && 'tab' === $field['type'] ) {
										$placement = isset( $field['placement'] ) ? $field['placement'] : 'top';
										if ( isset( $field['heading'] ) && $field['heading'] ) {
											$field_tabs[ $placement ][ $tab_count ]['tab_name'] = $field['heading'];
										}
										if ( isset( $field['field_id'] ) && $field['field_id'] ) {
											$field_tabs[ $placement ][ $tab_count ]['tab_id'] = $field['field_id'];
										}
										if ( isset( $field['conditional_logic'] ) && $field['conditional_logic'] ) {
											$field_tabs[ $placement ][ $tab_count ]['conditional_logic'] = $field['conditional_logic'];
										}
										$tab_count++;
									}
								}
							}
							$outer_class = 'pgs-helper-custom-meta-fields';
							if ( $tab_count > 0 ) {
								$outer_class .= ' meta-filelds-with-tabs';
								$outer_class .= ' field-position-' . key( $field_tabs );
							}
							?>
							<div class="<?php echo esc_attr( $outer_class ); ?>">
								<?php
								if ( $field_tabs ) {
									foreach ( $field_tabs as $field_key => $field_value ) {
										?>
										<ul class="meta-field-tabs meta-field-position-<?php echo esc_attr( $field_key ); ?>">
											<?php
											$field_count = 0;
											foreach ( $field_value as $value ) {
												$field_count++;
												$meta_field_class = ( 1 === $field_count ) ? 'meta-field-tab active' : 'meta-field-tab';
												if ( isset( $value['conditional_logic'] ) && $value['conditional_logic'] ) {
													if ( is_array( $value['conditional_logic'] ) ) {
														$conditional_logic = wp_json_encode( $value['conditional_logic'] );
													}
												}
												?>
												<li class="<?php echo esc_attr( $meta_field_class ); ?>" data-metafield-tab-id="<?php echo esc_attr( $value['tab_id'] ); ?>" data-metafield-id="<?php echo esc_attr( $value['tab_id'] ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
													<?php echo esc_html( $value['tab_name'] ); ?>
												</li>
												<?php
											}
											?>
										</ul>
										<?php
									}
								}
								?>
								<div class="pgs-meta-fields-container">
									<?php
									foreach ( $this->fields['fields']  as $field ) {
										if ( is_array( $field ) ) {
											if ( 'tab' !== $field['type'] ) {
												if ( isset( $field['type'] ) && 'tab' !== $field['type'] ) {
													$field['is_option'] = true;
													$get_fields_html    = 'meta_field_' . $field['type'];
													if ( method_exists( $this, $get_fields_html ) ) {
														$this->$get_fields_html( $field, $field['field_id'] );
													}
												}
											}
										}
									}

									$all_fields['id'] = $this->fields['id'];
									foreach ( $this->fields['fields'] as $all_field ) {
										$field_array             = array();
										$temp_field              = $all_field;
										$field_array['field_id'] = $temp_field['field_id'];
										$field_array['type']     = $temp_field['type'];
										if ( 'repeater' === $temp_field['type'] ) {
											foreach ( $temp_field['inner_fields'] as $inner_fields ) {
												$inner_field_array = array();
												$inner_temp_field  = $inner_fields;

												$inner_field_array['field_id'] = $inner_temp_field['field_id'];
												$inner_field_array['type']     = $inner_temp_field['type'];

												$field_array['inner_fields'][] = $inner_field_array;
											}
										}

										$all_fields['fields'][] = $field_array;
									}
									?>
									<input type="hidden" name="pgs-options-custom-fields[<?php echo esc_attr( $this->fields['id'] ); ?>]" value="<?php echo esc_attr( wp_strip_all_tags( wp_json_encode( $all_fields ) ) ); ?>" />
									<input type="hidden" name="pgs-options-custom-fields-id[]" value="<?php echo esc_attr( $this->fields['id'] ); ?>" />
								</div>
							</div>
						</div>
						<div id="post-body" class="has-sidebar">
							<div id="post-body-content" class="has-sidebar-content">
								<p><input type="submit" value="<?php echo esc_html__( 'Save Changes', 'pgs-core' ); ?>" class="button-primary" name="Submit"/></p>
							</div>
						</div>
						<br class="clear"/>
					</div>
				</form>
			</div>
			<?php
		}

		/**
		 * Function to save changes for option page.
		 */
		public function option_page_save_changes() {

			if ( isset( $_POST['_wp_http_referer'] ) ) {
				$wp_http_referer = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );
			} else {
				$wp_http_referer = get_admin_url();
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_safe_redirect( $wp_http_referer );
			}

			if ( ! isset( $_POST['pgs-optionfield-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pgs-optionfield-nonce'] ) ), basename( __FILE__ ) ) ) {
				wp_safe_redirect( $wp_http_referer );
			}

			if ( ! isset( $_POST['pgs-options-custom-fields'] ) || ! isset( $_POST['pgs-options-custom-fields-id'] ) ) {
				wp_safe_redirect( $wp_http_referer );
			}

			$fields_json = wp_unslash( $_POST['pgs-options-custom-fields'] );
			$fields_ids  = wp_unslash( $_POST['pgs-options-custom-fields-id'] );

			foreach ( $fields_ids as $fields_id ) {
				if ( isset( $fields_json[ $fields_id ] ) ) {
					$fields_data = json_decode( $fields_json[ $fields_id ], true );
					foreach ( $fields_data['fields'] as $field ) {
						$meta_value = '';
						if ( isset( $_POST[ $field['field_id'] ] ) ) {
							if ( is_array( $_POST[ $field['field_id'] ] ) || 'editor' === $field['type'] ) {
								$meta_value = wp_unslash( $_POST[ $field['field_id'] ] );
							} else {
								$meta_value = sanitize_text_field( wp_unslash( $_POST[ $field['field_id'] ] ) );
							}

							if ( 'google_map' === $field['type'] ) {
								$meta_value = json_decode( $meta_value, true );
							}
						}

						update_option( 'options_' . $field['field_id'], $meta_value );

						if ( 'repeater' === $field['type'] ) {
							$count = 0;
							if ( isset( $_POST[ $field['field_id'] . '_order' ] ) ) {
								$order_value = (string) sanitize_text_field( wp_unslash( $_POST[ $field['field_id'] . '_order' ] ) );
								update_option( 'options_' . $field['field_id'] . '_order', $order_value );

								$order_value = explode( ',', $order_value );
								foreach ( $order_value as $order ) {
									foreach ( $field['inner_fields']  as $inner_field ) {
										$inner_meta_value = '';
										$order_field      = $field['field_id'] . '_' . $order . '_' . $inner_field['field_id'];
										$field_id         = $field['field_id'] . '_' . $count . '_' . $inner_field['field_id'];
										if ( isset( $_POST[ $order_field ] ) ) {
											if ( 'google_map' === $inner_field['type'] ) {
												$inner_meta_value = sanitize_text_field( wp_unslash( $_POST[ $order_field ] ) );
												$inner_meta_value = json_decode( $inner_meta_value, true );
											} else {
												if ( is_array( $_POST[ $order_field ] ) || 'editor' === $inner_field['type'] ) {
													$inner_meta_value = wp_unslash( $_POST[ $order_field ] );
												} else {
													$inner_meta_value = sanitize_text_field( wp_unslash( $_POST[ $order_field ] ) );
												}
											}
										}

										update_option( 'options_' . $field_id, $inner_meta_value );
									}

									$count++;
								}
							}
						}
					}
				}
			}

			wp_safe_redirect( $wp_http_referer );
		}

		/**
		 * Function for register post metabox.
		 */
		public function meta_register() {
			global $post;
			
			$allowed       = true;
			$id            = isset( $this->fields['id'] ) ? $this->fields['id'] : '';
			$title         = isset( $this->fields['title'] ) ? $this->fields['title'] : '';
			$screen        = isset( $this->fields['screen'] ) ? $this->fields['screen'] : '';
			$context       = isset( $this->fields['context'] ) ? $this->fields['context'] : '';
			$priority      = isset( $this->fields['priority'] ) ? $this->fields['priority'] : '';
			$callback_args = isset( $this->fields['callback_args'] ) ? $this->fields['callback_args'] : '';
			$exclude       = isset( $this->fields['exclude'] ) ? $this->fields['exclude'] : '';

			if ( $exclude ) {
				if ( in_array( $post->ID, $exclude ) ) {
					$allowed = false;
				}
			}

			if ( $allowed ) {
				add_meta_box(
					$id,
					$title,
					array( $this, $this->callback ),
					$screen,
					$context,
					$priority,
					$callback_args
				);
			}
		}

		/**
		 * Function for save post meta fields.
		 *
		 * @param int $post_id post id.
		 */
		public function meta_save( $post_id ) {

			if ( ! current_user_can( 'edit_posts' ) ) {
				return;
			}

			if ( ! isset( $_POST['pgs-metafield-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pgs-metafield-nonce'] ) ), basename( __FILE__ ) ) ) {
				return $post_id;
			}

			if ( ! isset( $_POST['pgs-custom-meta-fields'] ) || ! isset( $_POST['pgs-custom-meta-fields-id'] ) ) {
				return;
			}

			$fields_json = wp_unslash( $_POST['pgs-custom-meta-fields'] );
			$fields_ids  = wp_unslash( $_POST['pgs-custom-meta-fields-id'] );

			foreach ( $fields_ids as $fields_id ) {
				if ( isset( $fields_json[ $fields_id ] ) ) {
					$fields_data = json_decode( $fields_json[ $fields_id ], true );
					foreach ( $fields_data['fields'] as $field ) {
						$meta_value = '';
						if ( isset( $_POST[ $field['field_id'] ] ) ) {
							if ( is_array( $_POST[ $field['field_id'] ] ) || 'editor' === $field['type'] ) {
								$meta_value = wp_unslash( $_POST[ $field['field_id'] ] );
							} else {
								$meta_value = sanitize_text_field( wp_unslash( $_POST[ $field['field_id'] ] ) );
							}

							if ( 'taxonomy' === $field['type'] ) {
								if ( is_array( $meta_value ) ) {
									$meta_int_ids = array();
									foreach ( $meta_value as $meta_val ) {
										$meta_int_ids[] = (int) $meta_val;
									}
									$meta_value = $meta_int_ids;
								} else {
									$meta_value = (int) $meta_value;
								}
							} elseif ( 'google_map' === $field['type'] ) {
								$meta_value = json_decode( $meta_value, true );
							}
						}

						if ( 'taxonomy' === $field['type'] ) {
							if ( isset( $field['taxonomy_arg']['taxonomy'] ) ) {
								wp_set_object_terms( $post_id, $meta_value, $field['taxonomy_arg']['taxonomy'], false );
							}
						} else {
							if ( isset( $fields_data['taxonomy'] ) && $fields_data['taxonomy'] ) {
								update_term_meta( $post_id, $field['field_id'], $meta_value );
							} else {
								update_post_meta( $post_id, $field['field_id'], $meta_value );
							}
						}

						if ( 'repeater' === $field['type'] ) {
							$count = 0;
							if ( isset( $_POST[ $field['field_id'] . '_order' ] ) ) {
								$order_value = (string) sanitize_text_field( wp_unslash( $_POST[ $field['field_id'] . '_order' ] ) );
								update_post_meta( $post_id, $field['field_id'] . '_order', $order_value );

								$order_value = explode( ',', $order_value );
								foreach ( $order_value as $order ) {
									foreach ( $field['inner_fields']  as $inner_field ) {
										$inner_meta_value = '';
										$order_field      = $field['field_id'] . '_' . $order . '_' . $inner_field['field_id'];
										$field_id         = $field['field_id'] . '_' . $count . '_' . $inner_field['field_id'];
										if ( isset( $_POST[ $order_field ] ) ) {
											if ( 'google_map' === $inner_field['type'] ) {
												$inner_meta_value = sanitize_text_field( wp_unslash( $_POST[ $order_field ] ) );
												$inner_meta_value = json_decode( $inner_meta_value, true );
											} else {
												if ( is_array( $_POST[ $order_field ] ) || 'editor' === $inner_field['type'] ) {
													$inner_meta_value = wp_unslash( $_POST[ $order_field ] );
												} else {
													$inner_meta_value = sanitize_text_field( wp_unslash( $_POST[ $order_field ] ) );
												}
											}
										}

										update_post_meta( $post_id, $field_id, $inner_meta_value );
									}
									$count++;
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Function for save post meta callback.
		 *
		 * @param object $post post object.
		 */
		public function meta_callback( $post ) {

			$field_tabs             = array();
			$tab_count              = 0;
			$conditional_logic      = '';
			$post_formate_included  = array();
			$post_formate_excluded  = array();
			$page_template_included = array();
			$page_template_excluded = array();

			if ( ! isset( $this->fields['fields'] ) && ! $this->fields['fields'] ) {
				return;
			}

			foreach ( $this->fields['fields']  as $field ) {
				if ( is_array( $field ) ) {
					if ( isset( $field['type'] ) && 'tab' === $field['type'] ) {
						$placement = isset( $field['placement'] ) ? $field['placement'] : 'top';
						if ( isset( $field['heading'] ) && $field['heading'] ) {
							$field_tabs[ $placement ][ $tab_count ]['tab_name'] = $field['heading'];
						}
						if ( isset( $field['field_id'] ) && $field['field_id'] ) {
							$field_tabs[ $placement ][ $tab_count ]['tab_id'] = $field['field_id'];
						}
						if ( isset( $field['conditional_logic'] ) && $field['conditional_logic'] ) {
							$field_tabs[ $placement ][ $tab_count ]['conditional_logic'] = $field['conditional_logic'];
						}
						$tab_count++;
					}
				}
			}

			if ( isset( $this->fields['page_template'] ) && $this->fields['page_template'] ) {
				foreach ( $this->fields['page_template'] as $page_template ) {
					if ( 'page_template' === $page_template['param'] ) {
						if ( '!=' === $page_template['operator'] ) {
							$page_template_excluded[] = $page_template['value'];
						} else {
							$page_template_included[] = $page_template['value'];
						}
					}
				}
			}

			if ( isset( $this->fields['post_formate'] ) && $this->fields['post_formate'] ) {
				foreach ( $this->fields['post_formate'] as $page_template ) {
					if ( 'post_formate' === $page_template['param'] ) {
						if ( '!=' === $page_template['operator'] ) {
							$page_formate_excluded[] = $page_template['value'];
						} else {
							$post_formate_included[] = $page_template['value'];
						}
					}
				}
			}

			$outer_class = 'pgs-helper-custom-meta-fields';
			if ( $tab_count > 0 ) {
				$outer_class .= ' meta-filelds-with-tabs';
				$outer_class .= ' field-position-' . key( $field_tabs );
			}
			?>
			<div class="<?php echo esc_attr( $outer_class ); ?>" data-field-include-template="<?php echo esc_attr( implode( ',', $page_template_included ) ); ?>" data-field-exclude-template="<?php echo esc_attr( implode( ',', $page_template_excluded ) ); ?>" data-field-include-post_formate="<?php echo esc_attr( implode( ',', $post_formate_included ) ); ?>" data-field-exclude-post_formate="<?php echo esc_attr( implode( ',', $post_formate_excluded ) ); ?>">
				<?php

				wp_nonce_field( basename( __FILE__ ), 'pgs-metafield-nonce' );

				if ( $field_tabs ) {
					foreach ( $field_tabs as $field_key => $field_value ) {
						?>
						<ul class="meta-field-tabs meta-field-position-<?php echo esc_attr( $field_key ); ?>">
							<?php
							$field_count = 0;
							foreach ( $field_value as $value ) {
								$field_count++;
								$meta_field_class = ( 1 === $field_count ) ? 'meta-field-tab active' : 'meta-field-tab';
								if ( isset( $value['conditional_logic'] ) && $value['conditional_logic'] ) {
									if ( is_array( $value['conditional_logic'] ) ) {
										$conditional_logic = wp_json_encode( $value['conditional_logic'] );
									}
								}
								?>
								<li class="<?php echo esc_attr( $meta_field_class ); ?>" data-metafield-tab-id="<?php echo esc_attr( $value['tab_id'] ); ?>" data-metafield-id="<?php echo esc_attr( $value['tab_id'] ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
									<?php echo esc_html( $value['tab_name'] ); ?>
								</li>
								<?php
							}
							?>
						</ul>
						<?php
					}
				}
				?>
				<div class="pgs-meta-fields-container">
					<?php
					foreach ( $this->fields['fields']  as $field ) {
						if ( is_array( $field ) ) {
							if ( 'tab' !== $field['type'] && isset( $post->ID ) ) {
								if ( isset( $field['type'] ) && 'tab' !== $field['type'] ) {
									$get_fields_html = 'meta_field_' . $field['type'];
									if ( method_exists( $this, $get_fields_html ) ) {
										$this->$get_fields_html( $field, $post->ID );
									}
								}
							}
						}
					}
					
					$all_fields['id'] = $this->fields['id'];
					foreach ( $this->fields['fields'] as $all_field ) {
						$field_array             = array();
						$temp_field              = $all_field;
						$field_array['field_id'] = $temp_field['field_id'];
						$field_array['type']     = $temp_field['type'];

						if ( isset( $temp_field['taxonomy_arg'] ) ) {
							$field_array['taxonomy_arg'] = $temp_field['taxonomy_arg'];
						}

						if ( 'repeater' === $temp_field['type'] ) {
							foreach ( $temp_field['inner_fields'] as $inner_fields ) {
								$inner_field_array = array();
								$inner_temp_field  = $inner_fields;

								$inner_field_array['field_id'] = $inner_temp_field['field_id'];
								$inner_field_array['type']     = $inner_temp_field['type'];

								$field_array['inner_fields'][] = $inner_field_array;
							}
						}

						$all_fields['fields'][] = $field_array;
					}
					?>
					<input type="hidden" name="pgs-custom-meta-fields[<?php echo esc_attr( $this->fields['id'] ); ?>]" value="<?php echo esc_attr( wp_strip_all_tags( wp_json_encode( $all_fields ) ) ); ?>" />
					<input type="hidden" name="pgs-custom-meta-fields-id[]" value="<?php echo esc_attr( $this->fields['id'] ); ?>" />
				</div>
			</div>
			<?php
		}
		/**
		 * Function for meta callback for taxonomy.
		 *
		 * @param object $taxonomy taxonomy object.
		 */
		public function taxonomy_add_meta_callback( $taxonomy ) {

			if ( ! isset( $this->fields['fields'] ) && ! $this->fields['fields'] ) {
				return;
			}

			wp_nonce_field( basename( __FILE__ ), 'pgs-metafield-nonce' );

			foreach ( $this->fields['fields']  as $field ) {
				if ( 'tab' !== $field['type'] ) {
					$field['taxonomy'] = true;
					$get_fields_html   = 'meta_field_' . $field['type'];
					if ( method_exists( $this, $get_fields_html ) ) {
						$this->$get_fields_html( $field, '' );
					}
				}
			}
			?>
			<input type="hidden" name="pgs-custom-meta-fields[<?php echo esc_attr( $this->fields['id'] ); ?>]" value="<?php echo esc_attr( wp_strip_all_tags( wp_json_encode( $this->fields ) ) ); ?>" />
			<input type="hidden" name="pgs-custom-meta-fields-id[]" value="<?php echo esc_attr( $this->fields['id'] ); ?>" />
			<?php
		}

		/**
		 * Function for meta callback for taxonomy.
		 *
		 * @param object $tag taxonomy object.
		 * @param int    $taxonomy taxonomy id.
		 */
		public function taxonomy_edit_meta_callback( $tag, $taxonomy ) {

			if ( ! isset( $this->fields['fields'] ) && ! $this->fields['fields'] ) {
				return;
			}

			wp_nonce_field( basename( __FILE__ ), 'pgs-metafield-nonce' );

			foreach ( $this->fields['fields']  as $field ) {
				if ( 'tab' !== $field['type'] ) {
					$field['taxonomy'] = true;
					?>
					<tr class="form-field">
						<th scope="row" valign="top"><label for="<?php echo esc_attr( $field['field_id'] ); ?>"><?php echo esc_attr( $field['heading'] ); ?></label></th>
						<td>
							<?php
							$get_fields_html = 'meta_field_' . $field['type'];
							if ( method_exists( $this, $get_fields_html ) ) {
								$this->$get_fields_html( $field, $tag->term_id );
							}
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>
			<input type="hidden" name="pgs-custom-meta-fields[<?php echo esc_attr( $this->fields['id'] ); ?>]" value="<?php echo esc_attr( wp_strip_all_tags( wp_json_encode( $this->fields ) ) ); ?>" />
			<input type="hidden" name="pgs-custom-meta-fields-id[]" value="<?php echo esc_attr( $this->fields['id'] ); ?>" />
			<?php
		}

		/**
		 * Function for add new field for repeater.
		 */
		public function add_new_meta_field() {

			$nonce = isset( $_POST['repeter_add_field_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['repeter_add_field_nonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'repeter_add_field_nonce' ) ) {
				return false;
			}

			$fields_data     = isset( $_POST['repeater_data'] ) ? sanitize_text_field( wp_unslash( $_POST['repeater_data'] ) ) : '';
			$fields          = json_decode( $fields_data, true );
			$parent_field_id = isset( $_POST['parent_field_id'] ) ? sanitize_text_field( wp_unslash( $_POST['parent_field_id'] ) ) : '';
			$count           = isset( $_POST['count'] ) ? sanitize_text_field( wp_unslash( $_POST['count'] ) ) : '';
			$post_id         = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : '';

			if ( $parent_field_id === $fields['field_id'] ) {
				?>
				<tr class="repeater-outer-field" data-fields-index="<?php echo esc_attr( $count ); ?>">
					<?php
					if ( isset( $fields['layout'] ) && 'horizontal' === $fields['layout'] ) {
						foreach ( $fields['inner_fields'] as $inner_field ) {
							$inner_field['new_field'] = true;
							?>
							<th class="repeater-inner-field" data-fields-id="<?php echo esc_attr( $inner_field['field_id'] ); ?>">
								<?php
								if ( isset( $fields['is_option'] ) && $fields['is_option'] ) {
									$inner_field['is_option'] = true;
								}
								$get_fields_html = 'meta_field_' . $inner_field['type'];
								if ( method_exists( $this, $get_fields_html ) ) {
									$this->$get_fields_html( $inner_field, $post_id, $fields['field_id'], $count );
								}
								?>
							</th>
							<?php
						}
					} else {
						?>
						<th class="repeater-inner-field">
						<?php
						foreach ( $fields['inner_fields'] as $inner_field ) {

							if ( isset( $fields['is_option'] ) && $fields['is_option'] ) {
								$inner_field['is_option'] = true;
							}

							$inner_field['new_field'] = true;
							$get_fields_html          = 'meta_field_' . $inner_field['type'];
							if ( method_exists( $this, $get_fields_html ) ) {
								$this->$get_fields_html( $inner_field, $post_id, $fields['field_id'], $count );
							}
						}
						?>
						</th>
						<?php
					}
					?>
					<th class="remove-field"><a class="button remove-row" href="#">-</a></th>
				</tr>
				<?php
			}
			wp_die();
		}

		/**
		 * Function for add new field for repeater.
		 */
		public function meta_get_oembed() {

			global $wp_embed;

			$nonce      = isset( $_POST['meta_get_oembed_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_get_oembed_nonce'] ) ) : '';
			$oembed_url = isset( $_POST['field_url'] ) ? sanitize_text_field( wp_unslash( $_POST['field_url'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'meta_get_oembed_nonce' ) ) {
				return false;
			}

			echo $wp_embed->shortcode( array(), $oembed_url );

			wp_die();
		}
		
		/**
		 * Function for add new field for repeater.
		 */
		public function post_object_ajax_results() {
			global $wpdb;

			$nonce      = isset( $_GET['meta_post_object_nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['meta_post_object_nonce'] ) ) : '';
			if ( ! wp_verify_nonce( $nonce, 'meta_post_object_nonce' ) ) {
				return false;
			}

			$post_type     = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
			$search        = isset( $_GET['search'] ) ? sanitize_text_field( wp_unslash( $_GET['search'] ) ) : '';
			$page          = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
			$per_page      = isset( $_GET['per_page'] ) ? sanitize_text_field( wp_unslash( $_GET['per_page'] ) ) : 10;
			$start         = ( $page - 1 ) * $per_page;
			$sql           = "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = '{$post_type}' AND post_status = 'publish' AND post_title LIKE '%s' LIMIT {$start}, {$per_page}";
			$sql2          = "SELECT count(*) AS full_count FROM $wpdb->posts WHERE post_type = '{$post_type}' AND post_status = 'publish' AND post_title LIKE '%s'";
			$get_requests  = $wpdb->get_results( $wpdb->prepare( $sql, '%'. $wpdb->esc_like( $search ) .'%' ) );
			$get_total_req = $wpdb->get_results( $wpdb->prepare( $sql2, '%'. $wpdb->esc_like( $search ) .'%' ) );

			$results = array();
			foreach ( $get_requests as $request ) {
				$result         = array();
				$result['id']   = $request->ID;
				$result['text'] = $request->post_title;
				$results[]      = $result;
			}

			$total      = $get_total_req[0]->full_count;
			$more_pages = $total > ( $start + $per_page );
			$results    = array(
				'results'    => $results,
				'pagination' => array(
					'more' => $more_pages
				)
			);

			echo json_encode( $results );
			wp_die();
		}

		/**
		 * Function for text meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_google_map( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			global $car_dealer_options;

			$map_meta_field    = array();
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$center_lat        = '';
			$center_lng        = '';
			$mapzoom           = '';
			$uniqid            = uniqid();
			$lat               = ( isset( $car_dealer_options['default_value_lat'] ) && $car_dealer_options['default_value_lat'] ) ? $car_dealer_options['default_value_lat'] : -37.81411;
			$lng               = ( isset( $car_dealer_options['default_value_long'] ) && $car_dealer_options['default_value_long'] ) ? $car_dealer_options['default_value_long'] : 144.96328;
			$zoom              = isset( $car_dealer_options['default_value_zoom'] ) ? $car_dealer_options['default_value_zoom'] : 11;

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-google-map' : 'meta-field meta-field-google-map';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$map_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$map_meta_field = get_option( 'options_' . $field_id );
			} else {
				$map_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( ! $map_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$map_meta_field = $field_data['default_value'];
				}
			}

			$map_meta_field_value = wp_json_encode( $map_meta_field, true );
			$address              = isset( $map_meta_field['address'] ) ? $map_meta_field['address'] : '';
			$lat                  = isset( $map_meta_field['lat'] ) ? $map_meta_field['lat'] : $lat;
			$lng                  = isset( $map_meta_field['lng'] ) ? $map_meta_field['lng'] : $lng;
			$place_id             = isset( $map_meta_field['place_id'] ) ? $map_meta_field['place_id'] : '';
			$street_number        = isset( $map_meta_field['street_number'] ) ? $map_meta_field['street_number'] : '';
			$street_name          = isset( $map_meta_field['street_name'] ) ? $map_meta_field['street_name'] : '';
			$street_name_short    = isset( $map_meta_field['street_name_short'] ) ? $map_meta_field['street_name_short'] : '';
			$city                 = isset( $map_meta_field['city'] ) ? $map_meta_field['city'] : '';
			$state                = isset( $map_meta_field['state'] ) ? $map_meta_field['state'] : '';
			$state_short          = isset( $map_meta_field['state_short'] ) ? $map_meta_field['state_short'] : '';
			$post_code            = isset( $map_meta_field['post_code'] ) ? $map_meta_field['post_code'] : '';
			$country              = isset( $map_meta_field['country'] ) ? $map_meta_field['country'] : '';
			$country_short        = isset( $map_meta_field['country_short'] ) ? $map_meta_field['country_short'] : '';

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}

			if ( isset( $field_data['center_lat'] ) && $field_data['center_lat'] ) {
				$center_lat = $field_data['center_lat'];
			} else {
				$center_lat = $lat;
			}

			if ( isset( $field_data['center_lng'] ) && $field_data['center_lng'] ) {
				$center_lng = $field_data['center_lng'];
			} else {
				$center_lng = $lng;
			}

			if ( isset( $field_data['zoom'] ) && $field_data['zoom'] ) {
				$mapzoom = $field_data['zoom'];
			} else {
				$mapzoom = $zoom;
			}

			if ( isset( $field_data['height'] ) && $field_data['height'] ) {
				$height = $field_data['height'];
			} else {
				$height = 400;
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" class="google-map-search-field" type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $address ); ?>" <?php echo esc_attr( $required ); ?> />
					<input class="google-map-field-data" name="<?php echo esc_attr( $field_id ); ?>" type="hidden" value="<?php echo esc_attr( $map_meta_field_value ); ?>" />
					<div class="map-canvas" style="height:<?php echo esc_attr( $height . 'px' ); ?>" data-field-lat="<?php echo esc_attr( $center_lat ); ?>" data-field-lng="<?php echo esc_attr( $center_lng ); ?>" data-field-zoom="<?php echo esc_attr( $mapzoom ); ?>"></div>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for text meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_text( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$maxlength         = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-text' : 'meta-field meta-field-text';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$text_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$text_meta_field = get_option( 'options_' . $field_id );
			} else {
				$text_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$text_meta_field = '';
			}

			if ( ! $text_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$text_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['maxlength'] ) && $field_data['maxlength'] ) {
				$maxlength = $field_data['maxlength'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $text_meta_field ); ?>" maxlength="<?php echo esc_attr( $maxlength ); ?>" <?php echo esc_attr( $readonly ); ?> <?php echo esc_attr( $required ); ?>/>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}
		
		/**
		 * Function for text meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_oembed( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$required          = '';
			$conditional_logic = '';
			$maxlength         = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-oembed' : 'meta-field meta-field-oembed';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$oembed_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$oembed_meta_field = get_option( 'options_' . $field_id );
			} else {
				$oembed_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$oembed_meta_field = '';
			}

			if ( ! $oembed_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$oembed_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field meta-input-oembed">
					<input class="meta-oembed-input-field" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="text" value="<?php echo esc_attr( $oembed_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
					<div class="meta-input-actions">
						<a href="#" class="meta-cancel-icon"></a>
					</div>
					<div class="meta-field-oembed">
						<?php
						if ( $oembed_meta_field ) {
							echo wp_oembed_get( $oembed_meta_field ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</div>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for text meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_iconpicker( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$required          = '';
			$icons_per_page    = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( ! isset( $field_data['icons'] ) || ( isset( $field_data['icons'] ) && ! $field_data['icons'] ) ) {
				return;
			} else {
				$icons = $field_data['icons'];
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-iconpicker' : 'meta-field meta-field-iconpicker';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$icon_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$icon_meta_field = get_option( 'options_' . $field_id );
			} else {
				$icon_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$icon_meta_field = '';
			}
			
			if ( isset( $field_data['icons_per_page'] ) && $field_data['icons_per_page'] ) {
				$icons_per_page = (int) $field_data['icons_per_page'];
			}

			if ( ! $icon_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$icon_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field" data-icons="<?php echo esc_attr( wp_json_encode( $icons ) ); ?>" data-icons_per_page="<?php echo esc_attr( $icons_per_page ); ?>">
					<input class="pgs-meta-iconpicker" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="text" value="<?php echo esc_attr( $icon_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for date picker meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_date_picker( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-icon-picker' : 'meta-field meta-field-icon-picker';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$date_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$date_meta_field = get_option( 'options_' . $field_id );
			} else {
				$date_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$date_meta_field = '';
			}

			if ( ! $date_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$date_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['dateformat'] ) && $field_data['dateformat'] ) {
				$dateformat = $field_data['dateformat'];
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}

			if ( $date_meta_field ) {
				$dateformated_meta_field = date_format( date_create( $date_meta_field ), 'yy/m/d' );
			} else {
				$dateformated_meta_field = '';
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field date-picker-field">
					<input class="field-date-picker" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php echo esc_attr( $readonly ); ?> <?php echo esc_attr( $required ); ?> value="<?php echo esc_attr( $dateformated_meta_field ); ?>" />
					<input class="field-date-picker-alt" id="<?php echo esc_attr( $field_id . $uniqid . '-alt' ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="hidden" value="<?php echo esc_attr( $date_meta_field ); ?>"/>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for email meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_email( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-email' : 'meta-field meta-field-email';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$email_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$email_meta_field = get_option( 'options_' . $field_id );
			} else {
				$email_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$email_meta_field = '';
			}

			if ( ! $email_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$email_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="email" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $email_meta_field ); ?>" <?php echo esc_attr( $readonly ); ?> <?php echo esc_attr( $required ); ?> />
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for url meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_url( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-url' : 'meta-field meta-field-url';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$url_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$url_meta_field = get_option( 'options_' . $field_id );
			} else {
				$url_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$url_meta_field = '';
			}

			if ( ! $url_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$url_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="url" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_url( $url_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for radio meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_radio( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			$field_class  = ( $tab_id ) ? 'meta-field with-tabs meta-field-radio' : 'meta-field meta-field-radio';
			$field_class .= ( isset( $field_data['layout'] ) && $field_data['layout'] ) ? ' layout-' . $field_data['layout'] : ' layout-horizontal';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$radio_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$radio_meta_field = get_option( 'options_' . $field_id );
			} else {
				$radio_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$radio_meta_field = '';
			}

			if ( ! $radio_meta_field ) {
				if ( isset( $field_data['default_value'] ) ) {
					$radio_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				if ( isset( $field_data['options'] ) ) {
					?>
					<div class="meta-input-field">
					<?php
					foreach ( $field_data['options'] as $key => $field ) {
						?>
						<div class="radio-input-container">
							<input type="radio" id="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $radio_meta_field, $key ); ?> >
							<label for="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>">
							<?php
							echo wp_kses(
								$field,
								array(
									'i'      => array(
										'class' => true,
									),
									'strong' => array(),
								)
							);
							?>
							</label>
						</div>
						<?php
					}
					if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
						?>
						<p class="description">
							<?php
							echo wp_kses(
								$field_data['instructions'],
								array(
									'a'      => array(
										'href'   => true,
										'target' => true,
										'title'  => true,
										'rel'    => true,
									),
									'strong' => array(),
								)
							);
							?>
						</p>
						<?php
					}
					?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for button group meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_button_group( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-button_group' : 'meta-field meta-field-button_group';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$radio_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$radio_meta_field = get_option( 'options_' . $field_id );
			} else {
				$radio_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$radio_meta_field = '';
			}

			if ( ! $radio_meta_field ) {
				if ( isset( $field_data['default_value'] ) ) {
					$radio_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				if ( isset( $field_data['options'] ) ) {
					?>
					<div class="meta-input-field">
						<div class="meta-input-button-group">
						<?php
						foreach ( $field_data['options'] as $key => $field ) {
							$active_class = '';
							if ( (string)$key === (string) $radio_meta_field ) {
								$active_class = 'selected';
							}
							?>
							<label for="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" class="<?php echo esc_attr( $active_class ); ?>">
							<input type="radio" id="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $radio_meta_field, $key ); ?> >
							<?php
							echo wp_kses(
								$field,
								array(
									'i'      => array(
										'class' => true,
									),
									'strong' => array(),
								)
							);
							?>
							</label>
							<?php
						}
						?>
						</div>
						<?php
						if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
							?>
							<p class="description">
								<?php
								echo wp_kses(
									$field_data['instructions'],
									array(
										'a'      => array(
											'href'   => true,
											'target' => true,
											'title'  => true,
											'rel'    => true,
										),
										'strong' => array(),
									)
								);
								?>
							</p>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for radio image meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_radio_image( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-radio-image' : 'meta-field meta-field-radio-image';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$radio_image_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$radio_image_meta_field = get_option( 'options_' . $field_id );
			} else {
				$radio_image_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$radio_image_meta_field = '';
			}

			if ( ! $radio_image_meta_field ) {
				if ( isset( $field_data['default_value'] ) ) {
					$radio_image_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}

				if ( isset( $field_data['options'] ) ) {
					?>
					<div class="meta-input-field">
						<ul class="meta-image-select">
						<?php
						foreach ( $field_data['options'] as $key => $field ) {
							?>
							<li class="meta-image-radio-select">
								<label for="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>">
									<input type="radio" id="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $radio_image_meta_field, $key ); ?>>
									<img src="<?php echo esc_attr( $field['img'] ); ?>" alt="<?php echo esc_attr( $field['alt'] ); ?>">
									<span><?php echo esc_html( $field['alt'] ); ?></span>
								</label>
							</li>
							<?php
						}
						?>
						</ul>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for editor meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_editor( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$settings          = array();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			if (  isset( $field_data['settings'] ) && $field_data['settings'] ) {
				$settings = $field_data['settings'];
			}

			$field_class = ( $tab_id ) ? 'meta-field field-editor with-tabs meta-field-editor' : 'meta-field field-editor meta-field-editor';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$editor_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$editor_meta_field = get_option( 'options_' . $field_id );
			} else {
				$editor_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$editor_meta_field = '';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field meta-input-editor-field">
				<?php wp_editor( $editor_meta_field, $field_id, $settings ); ?>
				</div>
			</div>
			<?php
			wp_enqueue_editor();
		}

		/**
		 * Function for number meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_number( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$placeholder       = '';
			$required          = '';
			$conditional_logic = '';
			$min               = '';
			$max               = '';
			$step              = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-number' : 'meta-field meta-field-number';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$number_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$number_meta_field = get_option( 'options_' . $field_id );
			} else {
				$number_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$number_meta_field = '';
			}

			if ( isset( $field_data['min'] ) && $field_data['min'] ) {
				$min = $field_data['min'];
			}

			if ( isset( $field_data['max'] ) && $field_data['max'] ) {
				$max = $field_data['max'];
			}

			if ( isset( $field_data['step'] ) && $field_data['step'] ) {
				$step = $field_data['step'];
			}

			if ( ! $number_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$number_meta_field = $field_data['default_value'];
				} else {
					$number_meta_field = 0;
				}
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$placeholder = $field_data['placeholder'];
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['range'] ) && $field_data['range'] ) {
				$field_class .= ' number-with-range';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<?php
					if ( isset( $field_data['range'] ) && $field_data['range'] ) {
						?>
						<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" class="input-range-field" name="<?php echo esc_attr( $field_id ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" type="range" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $number_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
						<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" class="input-range-value" name="<?php echo esc_attr( $field_id ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" type="number" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $number_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
						<?php
					} else {
						?>
						<input id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" type="number" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $number_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
						<?php
					}
					?>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for color picker meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_color_picker( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$required          = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-color-picker' : 'meta-field meta-field-color-picker';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$colorpicker_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$colorpicker_meta_field = get_option( 'options_' . $field_id );
			} else {
				$colorpicker_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$colorpicker_meta_field = '';
			}

			if ( ! $colorpicker_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$colorpicker_meta_field = $field_data['default_value'];
				}
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<input class="meta-field-input meta-color-field" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="text" value="<?php echo esc_attr( $colorpicker_meta_field ); ?>" <?php echo esc_attr( $required ); ?>/>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
					<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
					?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for select meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_taxonomy( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$required          = '';
			$multiple          = '';
			$conditional_logic = '';
			$option_data       = array();
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( ! isset( $field_data['taxonomy_arg'] ) || ( isset( $field_data['taxonomy_arg'] ) && ! $field_data['taxonomy_arg'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-taxonomy' : 'meta-field meta-field-taxonomy';
			if ( 'checkbox' === $field_data['field_type'] ) {
				$field_class .= ' meta-checkbox';
			}

			$meta_field_value = wp_get_object_terms(
				$post_id,
				$field_data['taxonomy_arg']['taxonomy'],
				array(
					'fields'  => 'ids',
					'orderby' => 'none',
				)
			);

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}

			$allterms = get_terms( $field_data['taxonomy_arg'] );
			if ( $allterms ) {
				foreach ( $allterms as $term_data ) {
					if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
						$option_data[ $term_data->term_id ] = $term_data->name;
					}
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				if ( $option_data ) {
					if ( 'select' === $field_data['field_type'] ) {
						$select_class = 'meta-field-select';

						if ( isset( $field_data['mutiselect'] ) && $field_data['mutiselect'] ) {
							$multiple      = 'multiple';
							$select_class .= ' multiple-select';
							$field_id      = $field_id . '[]';
						} else {
							$select_class .= ' single-select';
						}

						if ( isset( $field_data['select2'] ) && $field_data['select2'] ) {
							$select_class .= ' select2-enabled';
						}

						if ( isset( $field_data['sortable'] ) && $field_data['sortable'] ) {
							$select_class .= ' sortable-select';
						}
						?>
						<div class="meta-input-field">
							<?php
							if ( $multiple ) {
								?>
								<select class="<?php echo esc_attr( $select_class ); ?>" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" <?php echo esc_attr( $required ); ?> <?php echo esc_attr( $multiple ); ?>>
									<?php
									if ( is_string( $meta_field_value ) ) {
										$meta_field_value = array();
									}
									?>
									<option value=""><?php esc_html_e( 'Select', 'pgs-core' ); ?></option>
									<?php
									if ( $meta_field_value && ( isset( $field_data['sortable'] ) && $field_data['sortable'] ) ) {
										foreach ( $meta_field_value as $select_meta_key ) {
											if ( array_key_exists( $select_meta_key, $option_data ) ) {
												?>
												<option value="<?php echo esc_attr( $select_meta_key ); ?>" <?php selected( 1, 1 ); ?>><?php echo esc_html( $option_data[ $select_meta_key ] ); ?></option>
												<?php
											}
										}

										foreach ( $option_data as $option_key => $option_value ) {
											if ( ! in_array( $option_key, $meta_field_value ) ) {
												?>
												<option value="<?php echo esc_attr( $option_key ); ?>"><?php echo esc_html( $option_value ); ?></option>
												<?php
											}
										}
									} else {
										foreach ( $option_data as $option_key => $option_value ) {
											?>
											<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( in_array( $option_key, $meta_field_value ) ); ?>><?php echo esc_html( $option_value ); ?></option>
											<?php
										}
									}
									?>
								</select>
								<?php
							} else {
								?>
								<select class="<?php echo esc_attr( $select_class ); ?>" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" <?php echo esc_attr( $required ); ?> <?php echo esc_attr( $multiple ); ?>>
									<option value=""><?php esc_html_e( 'Select', 'pgs-core' ); ?></option>
									<?php
									foreach ( $option_data as $option_key => $option_value ) {
										?>
										<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( in_array( $option_key, $meta_field_value ) ); ?>><?php echo esc_html( $option_value ); ?></option>
										<?php
									}
									?>
								</select>
								<?php
							}
							?>
						</div>
						<?php

					} elseif ( 'checkbox' === $field_data['field_type'] ) {

						$checkbox_class = 'checkbox-wrapper';
						$checkbox_class .= ( isset( $field_data['layout'] ) && $field_data['layout'] ) ? ' layout-' . $field_data['layout'] : ' layout-horizontal';

						if ( isset( $field_data['mutiselect'] ) && $field_data['mutiselect'] ) {
							$input_class = 'meta-mutiselect-input';
						} else {
							$input_class = 'meta-single-input';
						}

						if ( ! $meta_field_value ) {
							$meta_field_value = array();
						}
						?>
						<div class="meta-input-field">
							<div class="<?php echo esc_attr( $checkbox_class ); ?>">
							<?php
							foreach ( $option_data as $key => $field ) {
								?>
								<div class="input-checkbox-outer">
									<label for="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>">
									<input type="checkbox" class="<?php echo esc_attr( $input_class ); ?>" id="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" name="<?php echo esc_attr( $field_id . '[]' ); ?>" value="<?php echo esc_attr( $key ); ?>"<?php checked( in_array( $key, $meta_field_value ) ); ?> /><?php echo esc_attr( $field ); ?>
									</label>
								</div>
								<?php
							}
							?>
							</div>
						</div>
						<?php
					}
				}
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
					<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
					?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for select meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_select( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$required          = '';
			$multiple          = '';
			$select_class      = 'meta-field-select';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-select' : 'meta-field meta-field-select';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$select_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$select_meta_field = get_option( 'options_' . $field_id );
			} else {
				$select_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$select_meta_field = array();
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['mutiselect'] ) && $field_data['mutiselect'] ) {
				$multiple      = 'multiple';
				$select_class .= ' multiple-select';
				$field_id      = $field_id . '[]';
			} else {
				$select_class .= ' single-select';
			}

			if ( isset( $field_data['sortable'] ) && $field_data['sortable'] ) {
				$select_class .= ' sortable-select';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			if ( isset( $field_data['options'] ) && $field_data['options'] ) {
				?>
				<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
					<?php
					if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
						?>
						<div class="meta-input-label">
							<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
						</div>
						<?php
					}
					?>
					<div class="meta-input-field">
						<?php
						if ( $multiple ) {
							?>
							<select class="<?php echo esc_attr( $select_class ); ?>" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" <?php echo esc_attr( $required ); ?> <?php echo esc_attr( $multiple ); ?>>
								<?php
								if ( is_string( $select_meta_field ) || empty( $select_meta_field ) ) {
									$select_meta_field = array();
								}

								if ( $select_meta_field && ( isset( $field_data['sortable'] ) && $field_data['sortable'] ) ) {
									foreach ( $select_meta_field as $select_meta_key ) {
										if ( array_key_exists( $select_meta_key, $field_data['options'] ) ) {
											?>
											<option value="<?php echo esc_attr( $select_meta_key ); ?>" <?php selected( 1, 1 ); ?>><?php echo esc_html( $field_data['options'][ $select_meta_key ] ); ?></option>
											<?php
										}
									}

									foreach ( $field_data['options'] as $option_key => $option_value ) {
										if ( ! in_array( $option_key, $select_meta_field ) ) {
											?>
											<option value="<?php echo esc_attr( $option_key ); ?>"><?php echo esc_html( $option_value ); ?></option>
											<?php
										}
									}
								} else {
									foreach ( $field_data['options'] as $option_key => $option_value ) {
										?>
										<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( in_array( $option_key, $select_meta_field ) ); ?>><?php echo esc_html( $option_value ); ?></option>
										<?php
									}
								}
								?>
							</select>
							<?php
						} else {
							?>
							<select class="<?php echo esc_attr( $select_class ); ?>" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" <?php echo esc_attr( $required ); ?> <?php echo esc_attr( $multiple ); ?>>
								<?php

								if ( is_array( $select_meta_field ) ) {
									$select_meta_field = '';
								}

								foreach ( $field_data['options'] as $option_key => $option_value ) {
									?>
									<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $select_meta_field, $option_key ); ?>><?php echo esc_html( $option_value ); ?></option>
									<?php
								}
								?>
							</select>
							<?php
						}
						?>
					</div>
					<?php
					if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
						?>
						<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
						</p>
						<?php
					}
					?>
				</div>
				<?php
			}
		}
		
		/**
		 * Function for background meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_background( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {

			$tab_id                       = '';
			$show_preview                 = '';
			$preview_height               = '';
			$conditional_logic            = '';
			$uniqid                       = uniqid();
			$select_background_repeat     = '';
			$select_background_attachment = '';
			$select_background_size       = '';
			$select_background_position   = '';
			$select_background_id         = '';
			$select_background_image      = '';
			$bg_image_url                 = '';
			$select_media_id              = '';
			$select_media_height          = '';
			$select_media_width           = '';
			$select_media_thumbnail       = '';

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}
			
			if ( isset( $field_data['show_preview'] ) && $field_data['show_preview'] ) {
				$show_preview = $field_data['show_preview'];
			}
			
			if ( isset( $field_data['preview_height'] ) && ! $field_data['preview_height'] ) {
				$preview_height = $field_data['preview_height'];
			}
			
			if ( isset( $field_data['background_repeat'] ) && ! $field_data['background_repeat'] ) {
				$select_background_repeat = $field_data['background_repeat'];
			}
			
			if ( isset( $field_data['background_size'] ) && ! $field_data['background_size'] ) {
				$select_background_size = $field_data['background_size'];
			}
			
			if ( isset( $field_data['background_attachment'] ) && ! $field_data['background_attachment'] ) {
				$select_background_attachment = $field_data['background_attachment'];
			}
			
			if ( isset( $field_data['background_position'] ) && ! $field_data['background_position'] ) {
				$select_background_position = $field_data['background_position'];
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-background' : 'meta-field meta-field-background';

			if ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$select_meta_field = get_option( 'options_' . $field_id );
			} else {
				$select_meta_field = get_post_meta( $post_id, $field_id, true );
			}
			
			if ( $select_meta_field ) {
				if ( isset( $select_meta_field[ 'background-repeat' ] ) && $select_meta_field[ 'background-repeat' ] ) {
					$select_background_repeat = $select_meta_field[ 'background-repeat' ];
				}
				
				if ( isset( $select_meta_field[ 'background-attachment' ] ) && $select_meta_field[ 'background-attachment' ] ) {
					$select_background_attachment = $select_meta_field[ 'background-attachment' ];
				}
				
				if ( isset( $select_meta_field[ 'background-size' ] ) && $select_meta_field[ 'background-size' ] ) {
					$select_background_size = $select_meta_field[ 'background-size' ];
				}
				
				if ( isset( $select_meta_field[ 'background-position' ] ) && $select_meta_field[ 'background-position' ] ) {
					$select_background_position = $select_meta_field[ 'background-position' ];
				}
				
				if ( isset( $select_meta_field[ 'background-id' ] ) && $select_meta_field[ 'background-id' ] ) {
					$select_background_id = $select_meta_field[ 'background-id' ];
				}
				
				if ( isset( $select_meta_field[ 'background-image' ] ) && $select_meta_field[ 'background-image' ] ) {
					$select_background_image = $select_meta_field[ 'background-image' ];
				}
				
				if ( isset( $select_meta_field['media']['id'] ) && $select_meta_field['media']['id'] ) {
					$select_media_id = $select_meta_field['media']['id'];
				}
				
				if ( isset( $select_meta_field['media']['height'] ) && $select_meta_field['media']['height'] ) {
					$select_media_height = $select_meta_field['media']['height'];
				}
				
				if ( isset( $select_meta_field['media']['width'] ) && $select_meta_field['media']['width'] ) {
					$select_media_width = $select_meta_field['media']['width'];
				}
				
				if ( isset( $select_meta_field['media']['thumbnail'] ) && $select_meta_field['media']['thumbnail'] ) {
					$select_media_thumbnail = $select_meta_field['media']['thumbnail'];
				}
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$select_meta_field = array();
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<?php 
					$background_repeat_options = array(
						''          => esc_html__( 'Select Background Repeat', 'pgs-core' ),
						'no-repeat' => esc_html__( 'No Repeat', 'pgs-core' ),
						'repeat'    => esc_html__( 'Repeat All', 'pgs-core' ),
						'repeat-x'  => esc_html__( 'Repeat Horizontally', 'pgs-core' ),
						'repeat-y'  => esc_html__( 'Repeat Vertically', 'pgs-core' ),
						'inherit'   => esc_html__( 'Inherit', 'pgs-core' ),
					);
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . '-background-repeat-' . $uniqid ); ?>"><?php esc_html_e( 'Background Repeat', 'pgs-core' ); ?></label>
					</div>
					<select class="select-background-repeat" name="<?php echo esc_attr( $field_id . '[background-repeat]' ); ?>" id="<?php echo esc_attr( $field_id . '-background-repeat-' . $uniqid ); ?>" >
						<?php 
						foreach ( $background_repeat_options as $key => $option ) {
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $select_background_repeat, $key ); ?>><?php echo esc_html( $option ); ?></option>
							<?php
						}
						?>
					</select>
					<?php
					$background_repeat_options = array(
						''        => esc_html__( 'Select Background Size', 'pgs-core' ),
						'cover'   => esc_html__( 'Cover', 'pgs-core' ),
						'contain' => esc_html__( 'Contain', 'pgs-core' ),
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'auto'    => esc_html__( 'Auto', 'pgs-core' ),
					);
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . '-background-size-' . $uniqid ); ?>"><?php esc_html_e( 'Background Size', 'pgs-core' ); ?></label>
					</div>
					<select class="select-background-size" name="<?php echo esc_attr( $field_id . '[background-size]' ); ?>" id="<?php echo esc_attr( $field_id . '-background-size-' . $uniqid ); ?>" >
						<?php 
						foreach ( $background_repeat_options as $key => $option ) {
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $select_background_size, $key ); ?>><?php echo esc_html( $option ); ?></option>
							<?php
						}
						?>
					</select>
					<?php
					$background_attachment_options = array(
						''        => esc_html__( 'Select Background Attachment', 'pgs-core' ),
						'scroll'  => esc_html__( 'Scroll', 'pgs-core' ),
						'fixed'   => esc_html__( 'Fixed', 'pgs-core' ),
						'local'   => esc_html__( 'Local', 'pgs-core' ),
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
					);
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . '-background-attachment-' . $uniqid ); ?>"><?php esc_html_e( 'Background Attachment', 'pgs-core' ); ?></label>
					</div>
					<select class="select-background-attachment" name="<?php echo esc_attr( $field_id . '[background-attachment]' ); ?>" id="<?php echo esc_attr( $field_id . '-background-attachment-' . $uniqid ); ?>">
						<?php 
						foreach ( $background_attachment_options as $key => $option ) {
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $select_background_attachment, $key ); ?>><?php echo esc_html( $option ); ?></option>
							<?php
						}
						?>
					</select>
					<?php
					$background_position_options = array(
						''              => esc_html__( 'Select Background Position', 'pgs-core' ),
						'left top'      => esc_html__( 'left top', 'pgs-core' ),
						'left center'   => esc_html__( 'left center', 'pgs-core' ),
						'left bottom'   => esc_html__( 'left bottom', 'pgs-core' ),
						'center top'    => esc_html__( 'center top', 'pgs-core' ),
						'center center' => esc_html__( 'center center', 'pgs-core' ),
						'center bottom' => esc_html__( 'center bottom', 'pgs-core' ),
						'right top'     => esc_html__( 'right top', 'pgs-core' ),
						'right center'  => esc_html__( 'right center', 'pgs-core' ),
						'right bottom'  => esc_html__( 'right bottom', 'pgs-core' ),
						'inherit'       => esc_html__( 'Inherit', 'pgs-core' ),
					);
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . '-background-position-' . $uniqid ); ?>"><?php esc_html_e( 'Background Position', 'pgs-core' ); ?></label>
					</div>
					<select class="select-background-position" name="<?php echo esc_attr( $field_id . '[background-position]' ); ?>" id="<?php echo esc_attr( $field_id . '-background-position-' . $uniqid ); ?>" >
						<?php 
						foreach ( $background_position_options as $key => $option ) {
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $select_background_position, $key ); ?>><?php echo esc_html( $option ); ?></option>
							<?php
						}
						?>
					</select>

					<div class="select-background-image">
						<div class="meta-input-label">
							<label><?php esc_html_e( 'Background Image', 'pgs-core' ); ?></label>
						</div>
						<div class="meta-input-field">
							<div class="meta-image-holder">
								<?php
								$upload_btn_text  = esc_html__( 'Add Image', 'pgs-core' );
								$upload_btn_class = 'button meta-bg-image-upload';

								if ( $select_background_id ) {
									$image_data = wp_get_attachment_image_src( $select_background_id, 'thumbnail' );
									if ( isset( $image_data[0] ) && $image_data[0] ) {
										$bg_image_url = $image_data[0];
									}
								} else {
									$bg_image_url = $select_background_image;
								}

								if ( $bg_image_url ) {
									?>
									<img src="<?php echo esc_url( $bg_image_url ); ?>" />
									<?php
									$upload_btn_text  = esc_html__( 'Remove Image', 'pgs-core' );
									$upload_btn_class = 'button meta-bg-image-remove';
								}
								?>
							</div>
							
							<input type="hidden" class="image-media-id" id="" name="<?php echo esc_attr( $field_id . '[media][id]' ); ?>" value="<?php echo esc_attr( $select_media_id ); ?>" />
							<input type="hidden" class="image-media-height" id="" name="<?php echo esc_attr( $field_id . '[media][height]' ); ?>" value="<?php echo esc_attr( $select_media_height ); ?>" />
							<input type="hidden" class="image-media-width" id="" name="<?php echo esc_attr( $field_id . '[media][width]' ); ?>" value="<?php echo esc_attr( $select_media_width ); ?>" />
							<input type="hidden" class="image-media-thumbnail" id="" name="<?php echo esc_attr( $field_id . '[media][thumbnail]' ); ?>" value="<?php echo esc_attr( $select_media_thumbnail ); ?>" />

							<input type="hidden" class="image-field-id" id="" name="<?php echo esc_attr( $field_id . '[background-id]' ); ?>" value="<?php echo esc_attr( $select_background_id ); ?>" />
							<input type="hidden" class="image-field-url" id="" name="<?php echo esc_attr( $field_id . '[background-image]' ); ?>" value="<?php echo esc_attr( $select_background_image ); ?>" />
							<div class="meta-input-field">
								<input type="button" class="<?php echo esc_attr( $upload_btn_class ); ?>"  value="<?php echo esc_attr( $upload_btn_text ); ?>" />
							</div>

							<?php
							if ( $show_preview ) {
								?>
								<div class="meta-input-label">
									<label><?php esc_html_e( 'Background Preview', 'pgs-core' ); ?></label>
								</div>
								<?php
								$preview_css = '';
								if ( $select_background_repeat ) {
									$preview_css .= 'background-repeat:' . $select_background_repeat . ';';
								}

								if ( $select_background_attachment ) {
									$preview_css .= 'background-attachment:' . $select_background_attachment . ';';
								}
								
								if ( $select_background_size ) {
									$preview_css .= 'background-size:' . $select_background_size . ';';
								}
								
								if ( $select_background_position ) {
									$preview_css .= 'background-position:' . $select_background_position . ';';
								}
								
								if ( $select_background_size ) {
									$preview_css .= 'background-image:url(' . $select_background_image . ');';
									if ( $preview_height ) {
										$preview_css .= 'height: ' . $preview_height . 'px;';
									} else {
										$preview_css .= 'height: 200px;';
									}
								}
								?>
								<div class="meta-background-preview-live" data-preview-height="<?php echo esc_attr( $preview_height ); ?>" style="<?php echo esc_attr( $preview_css ); ?>"></div> 
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
					<?php
					echo wp_kses(
						$field_data['instructions'],
						array(
							'a'      => array(
								'href'   => true,
								'target' => true,
								'title'  => true,
								'rel'    => true,
							),
							'strong' => array(),
						)
					);
					?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}
		
		/**
		 * Function for select meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_post_object( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$required          = '';
			$select_class      = 'meta-field-post-object-select';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}
			
			if ( ! isset( $field_data['post_type'] ) || ( isset( $field_data['post_type'] ) && ! $field_data['post_type'] ) ) {
				return;
			}
			
			if ( isset( $field_data['per_page'] ) && ! $field_data['per_page'] ) {
				$per_page = $field_data['per_page'];
			} else {
				$per_page = 10;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-post_object' : 'meta-field meta-field-post_object';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$select_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$select_meta_field = get_option( 'options_' . $field_id );
			} else {
				$select_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$select_meta_field = '';
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field" data-post-type="<?php echo esc_attr( $field_data['post_type'] ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>">	
					<select class="<?php echo esc_attr( $select_class ); ?>" name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" <?php echo esc_attr( $required ); ?> >
						<?php
						if ( $select_meta_field ) {
							?>
							<option value="<?php echo esc_attr( $select_meta_field ); ?>" selected><?php echo get_the_title( $select_meta_field ); ?></option>
							<?php
						} else {
							?>
							<option value=""></option>
							<?php
						}
						?>
					</select>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
					<?php
					echo wp_kses(
						$field_data['instructions'],
						array(
							'a'      => array(
								'href'   => true,
								'target' => true,
								'title'  => true,
								'rel'    => true,
							),
							'strong' => array(),
						)
					);
					?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for image meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_image( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {

			$tab_id            = '';
			$conditional_logic = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field meta-field-image with-tabs' : 'meta-field meta-field-image';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$image_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$image_meta_field = get_option( 'options_' . $field_id );
			} else {
				$image_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$image_meta_field = '';
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-image-holder">
					<?php
					$upload_btn_text  = esc_html__( 'Add Image', 'pgs-core' );
					$upload_btn_class = 'button meta-image-upload';
					if ( $image_meta_field ) {
						$image_data = wp_get_attachment_image_src( $image_meta_field, 'thumbnail' );
						if ( isset( $image_data[0] ) && $image_data[0] ) {
							?>
							<img src="<?php echo esc_url( $image_data[0] ); ?>" />
							<?php
							$upload_btn_text  = esc_html__( 'Remove Image', 'pgs-core' );
							$upload_btn_class = 'button meta-image-remove';
						}
					}
					?>
				</div>
				<input type="hidden" class="image-field-id" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $image_meta_field ); ?>" />
				<div class="meta-input-field">
					<input type="button" class="<?php echo esc_attr( $upload_btn_class ); ?>"  value="<?php echo esc_attr( $upload_btn_text ); ?>" />
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for textarea meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_textarea( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$readonly          = '';
			$required          = '';
			$placeholder       = '';
			$conditional_logic = '';
			$rows              = 4;
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-textarea' : 'meta-field meta-field-textarea';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$textarea_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$textarea_meta_field = get_option( 'options_' . $field_id );
			} else {
				$textarea_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$textarea_meta_field = '';
			}

			if ( isset( $field_data['readonly'] ) && $field_data['readonly'] ) {
				$readonly = 'readonly';
			}

			if ( isset( $field_data['required'] ) && $field_data['required'] ) {
				$required = $field_data['required'];
			}

			if ( isset( $field_data['placeholder'] ) && $field_data['placeholder'] ) {
				$required = 'required';
			}

			if ( isset( $field_data['rows'] ) && $field_data['rows'] ) {
				$rows = $field_data['rows'];
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-input-field">
					<textarea id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" rows="<?php echo esc_attr( $rows ); ?>" <?php echo esc_attr( $readonly ); ?> <?php echo esc_attr( $required ); ?> ><?php echo esc_html( $textarea_meta_field ); ?></textarea>
				</div>
				<?php
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for checkbox meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_checkbox( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id              = '';
			$conditional_logic   = '';
			$readonly            = '';
			$checkbox_meta_field = array();
			$uniqid              = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			if ( isset( $field_data['mutiselect'] ) && $field_data['mutiselect'] ) {
				$input_class = 'meta-mutiselect-input';
			} else {
				$input_class = 'meta-single-input';
			}

			$field_class = ( $tab_id ) ? 'meta-field meta-checkbox with-tabs meta-field-checkbox' : 'meta-field meta-checkbox meta-field-checkbox';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$checkbox_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$checkbox_meta_field = get_option( 'options_' . $field_id );
			} else {
				$checkbox_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( ! $checkbox_meta_field ) {
				if ( isset( $field_data['default_value'] ) && $field_data['default_value'] ) {
					$checkbox_meta_field = array( $field_data['default_value'] );
				}
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				if ( isset( $field_data['options'] ) ) {
					if ( ! is_array( $checkbox_meta_field ) ) {
						$checkbox_meta_field = array( $checkbox_meta_field );
					}
					?>
					<div class="checkbox-wrapper">
					<?php
					foreach ( $field_data['options'] as $key => $field ) {
						?>
						<label for="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>">
						<input type="checkbox" class="<?php echo esc_attr( $input_class ); ?>" id="<?php echo esc_attr( $field_data['field_id'] . '-' . $key . '-' . $uniqid ); ?>" name="<?php echo esc_attr( $field_id . '[]' ); ?>" value="<?php echo esc_attr( $key ); ?>"<?php checked( in_array( $key, $checkbox_meta_field ) ); ?> /><?php echo esc_attr( $field ); ?>
						</label>
						<?php
					}
					?>
					</div>
					<?php
				}
				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for image gallery meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_image_gallery( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field meta-fields-gallery with-tabs' : 'meta-field meta-fields-gallery';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$gallery_image_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$gallery_image_meta_field = get_option( 'options_' . $field_id );
			} else {
				$gallery_image_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['new_field'] ) && $field_data['new_field'] ) {
				$gallery_image_meta_field = array();
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<div class="meta-fields-gallery-image-container" data-field-title="<?php echo esc_attr( $field_id ); ?>">
					<div class="meta-fields-gallery-image-list">
					<?php
					if ( $gallery_image_meta_field ) {
						foreach ( $gallery_image_meta_field as $key => $gallery_image_meta_field_id ) {
							$image = wp_get_attachment_image_src( $gallery_image_meta_field_id );
							if ( $image ) {
								?>
								<div class="meta-fields-gallery-image">
									<input type="hidden" name="<?php echo esc_attr( $field_id . '[]' ); ?>" value="<?php echo esc_attr( $gallery_image_meta_field_id ); ?>">
									<img class="image-preview" src="<?php echo esc_url( $image[0] ); ?>" height="150" width="150">
									<a class="meta-field-remove-image" href="#">
										<i title="<?php echo esc_attr__( 'Remove Image', 'pgs-core' ); ?>" class="fa fa-times-circle" aria-hidden="true"></i>
									</a>
									<div class="image-title">
										<?php echo esc_html( get_the_title( $gallery_image_meta_field_id ) ); ?>
									</div>
								</div>
								<?php
							}
						}
					}
					?>
					</div>
					<a class="meta-fields-gallery-image-add button" href="#" data-uploader-title="<?php echo esc_attr__( 'Add images', 'pgs-core' ); ?>" data-uploader-button-text="<?php echo esc_attr__( 'Add Images', 'pgs-core' ); ?>">
						<?php echo esc_html__( 'Add Images', 'pgs-core' ); ?>
					</a>
				</div>
			</div>
			<?php
		}

		/**
		 * Function for file meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 * @param int   $parent_field_id parent field id.
		 * @param int   $count field count.
		 */
		public function meta_field_file( $field_data, $post_id = '', $parent_field_id = '', $count = '' ) {
			$tab_id            = '';
			$conditional_logic = '';
			$file_types        = '';
			$uniqid            = uniqid();

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( $parent_field_id ) {
				$field_id = $parent_field_id . '_' . $count . '_' . $field_data['field_id'];
			} else {
				$field_id = $field_data['field_id'];
				$tab_id   = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			}

			$field_class = ( $tab_id ) ? 'meta-field with-tabs meta-field-file' : 'meta-field meta-field-file';

			if ( isset( $field_data['taxonomy'] ) && $field_data['taxonomy'] ) {
				$file_meta_field = get_term_meta( $post_id, $field_id, true );
			} elseif ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$file_meta_field = get_option( 'options_' . $field_id );
			} else {
				$file_meta_field = get_post_meta( $post_id, $field_id, true );
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}

			if ( isset( $field_data['file_types'] ) && $field_data['file_types'] ) {
				$file_types = $field_data['file_types'];
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_id ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>" data-metafield-file-type="<?php echo esc_attr( $file_types ); ?>">
				<?php
				if ( isset( $field_data['heading'] ) && $field_data['heading'] ) {
					?>
					<div class="meta-input-label">
						<label for="<?php echo esc_attr( $field_id . $uniqid ); ?>"><?php echo esc_html( $field_data['heading'] ); ?></label>
					</div>
					<?php
				}
				?>
				<input class="meta-field-file-button" type="button" value="<?php esc_html_e( 'Upload', 'pgs-core' ); ?>" />
				<input class="meta-file-id" id="<?php echo esc_attr( $field_id . $uniqid ); ?>" name="<?php echo esc_attr( $field_id ); ?>" type="hidden" value="<?php echo esc_attr( $file_meta_field ); ?>" />
				<?php
				if ( $file_meta_field ) {
					$attached_file_meta = wp_get_attachment_metadata( $file_meta_field );
					?>
					<div class="meta-file-content">
						<div class="meta-file-info">
							<a class="meta-file-remove" href="#" title="Remove">x</a>
							<strong><?php esc_html_e( 'File name: ', 'pgs-core' ); ?></strong>
							<a href="<?php echo esc_url( wp_get_attachment_url( $file_meta_field ) ); ?>" target="_blank">
								<?php echo esc_html( basename( get_attached_file( $file_meta_field ) ) ); ?>
							</a>
						</div>
					</div>
					<?php
				}

				if ( isset( $field_data['instructions'] ) && $field_data['instructions'] ) {
					?>
					<p class="description">
						<?php
						echo wp_kses(
							$field_data['instructions'],
							array(
								'a'      => array(
									'href'   => true,
									'target' => true,
									'title'  => true,
									'rel'    => true,
								),
								'strong' => array(),
							)
						);
						?>
					</p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * Function for repeater meta field.
		 *
		 * @param array $field_data field info array.
		 * @param int   $post_id post id.
		 */
		public function meta_field_repeater( $field_data, $post_id = '' ) {

			$repeater_order    = array();
			$conditional_logic = '';
			$count             = 0;
			$tab_id            = isset( $field_data['tab'] ) ? $field_data['tab'] : '';
			$field_class       = ( $tab_id ) ? 'meta-field repeater with-tabs' : 'meta-field repeater';
			$field_class       .= isset( $field_data['layout'] ) ? ' repeater-' . $field_data['layout'] : ' repeater-vertical';

			if ( ! isset( $field_data['field_id'] ) || ( isset( $field_data['field_id'] ) && ! $field_data['field_id'] ) ) {
				return;
			}

			if ( isset( $field_data['button_label'] ) && $field_data['button_label'] ) {
				$button_label = $field_data['button_label'];
			} else {
				$button_label = esc_html__( 'Add another', 'pgs-core' );
			}

			if ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
				$repeater_meta_field = get_option( 'options_' . $field_data['field_id'] );
			} else {
				$repeater_meta_field = get_post_meta( $post_id, $field_data['field_id'], true );
			}

			if ( isset( $field_data['conditional_logic'] ) && $field_data['conditional_logic'] ) {
				if ( is_array( $field_data['conditional_logic'] ) ) {
					$conditional_logic = wp_json_encode( $field_data['conditional_logic'] );
				}
			}
			?>
			<div class="<?php echo esc_attr( $field_class ); ?>" data-metafield-tab="<?php echo esc_attr( $tab_id ); ?>" data-metafield-id="<?php echo esc_attr( $field_data['field_id'] ); ?>" data-conditional-logic="<?php echo esc_attr( $conditional_logic ); ?>">
				<table class="repeater-table" id="<?php echo esc_attr( $field_data['field_id'] . '_repeater' ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-repeater-id="<?php echo esc_attr( $field_data['field_id'] ); ?>" data-repeater-fields="<?php echo esc_attr( wp_json_encode( $field_data ) ); ?>">
					<tbody>
					<?php
					for ( $count; $count < $repeater_meta_field; $count++ ) {
						$repeater_order[] = $count;
						?>
						<tr class="repeater-outer-field" data-fields-index="<?php echo esc_attr( $count ); ?>">
							<?php
							if ( isset( $field_data['layout'] ) && 'horizontal' === $field_data['layout'] ) {
								foreach ( $field_data['inner_fields'] as $inner_field ) {
									?>
									<th class="repeater-inner-field">
										<?php
										if ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
											$inner_field['is_option'] = true;
										}
										$get_fields_html = 'meta_field_' . $inner_field['type'];
										if ( method_exists( $this, $get_fields_html ) ) {
											$this->$get_fields_html( $inner_field, $post_id, $field_data['field_id'], $count );
										}
										?>
									</th>
									<?php
								}
							} else {
								?>
								<th class="repeater-inner-field">
								<?php
								foreach ( $field_data['inner_fields'] as $inner_field ) {
									if ( isset( $field_data['is_option'] ) && $field_data['is_option'] ) {
										$inner_field['is_option'] = true;
									}
									$get_fields_html = 'meta_field_' . $inner_field['type'];
									if ( method_exists( $this, $get_fields_html ) ) {
										$this->$get_fields_html( $inner_field, $post_id, $field_data['field_id'], $count );
									}
								}
								?>
								</th>
								<?php
							}
							?>
							<th class="remove-field"><a class="button remove-row" href="#">-</a></th>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
				<?php
				$field_id       = $field_data['field_id'];
				$field_order_id = $field_data['field_id'] . '_order';
				?>
				<input type="hidden" id="<?php echo esc_attr( $field_data['field_id'] ); ?>" name="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $repeater_meta_field ); ?>">
				<input type="hidden" id="<?php echo esc_attr( $field_data['field_id'] . '_order' ); ?>" name="<?php echo esc_attr( $field_order_id ); ?>" value="<?php echo esc_attr( implode( ',', $repeater_order ) ); ?>">
				<p><a class="button add-row" href="#"><?php echo esc_html( $button_label ); ?></a></p>
			</div>
			<?php
		}
	}
}
