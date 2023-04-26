<?php
/**
 * Admin Premium class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Admin_Premium' ) ) {
	/**
	 * WooCommerce Brands Admin
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Admin_Premium extends YITH_WCBR_Admin {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCBR_Admin_Premium
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Constructor method
		 *
		 * @return \YITH_WCBR_Admin_Premium
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct();

			$this->filter_available_tabs();

			// register premium settings
			add_filter( 'yith_wcbr_general_settings', array( $this, 'filter_setting_options' ) );
			add_action( 'woocommerce_admin_field_yith_wcbr_upload_image', array(
				$this,
				'print_image_upload_field'
			), 10, 1 );
			add_action( 'woocommerce_admin_field_yith_wcbr_image_size', array(
				$this,
				'print_image_size_field'
			), 10, 1 );
			add_action( 'init', array( $this, 'check_woocommerce_brand_taxonomy' ), 3 );
			add_action( 'yith_wcbr_tools_panel', array( $this, 'print_tools_panel' ) );

			// import/export handling
			add_action( YITH_WCBR::$brands_taxonomy . '_add_form', array( $this, 'add_import_link' ) );
			add_action( 'admin_footer', array( $this, 'add_export_action' ) );
			add_action( 'admin_init', array( $this, 'export_csv' ) );
			add_action( 'admin_init', array( $this, 'register_csv_importer' ) );

			// add product page filters
			add_action( 'restrict_manage_posts', array( $this, 'add_product_filter_by_brand' ), 15 );

			// register brand taxonomy as sortable
			add_filter( 'woocommerce_sortable_taxonomies', array( $this, 'register_as_sortable' ) );

			// add coupons restrictions on brand
			add_action( 'woocommerce_coupon_options_usage_restriction', array(
				$this,
				'add_brand_coupon_restrictions'
			), 10, 2 );
			add_action( 'woocommerce_coupon_options_save', array( $this, 'save_brand_coupon_restrictions' ), 10, 2 );

			// adds compatibility with WooCommerce products' csv export
			add_filter( 'woocommerce_product_export_product_default_columns', array(
				$this,
				'register_brands_for_wc_export'
			) );
			add_filter( 'woocommerce_product_export_product_column_brand_ids', array(
				$this,
				'retrieve_brands_for_wc_export'
			), 10, 2 );
			add_filter( 'woocommerce_csv_product_import_mapping_default_columns', array(
				$this,
				'normalize_brands_column_for_wc_import'
			) );
			add_filter( 'woocommerce_csv_product_import_mapping_options', array( $this, 'map_brands_for_wc_import' ) );
			add_filter( 'woocommerce_product_importer_formatting_callbacks', array(
				$this,
				'register_brands_for_wc_import'
			), 10, 2 );
			add_action( 'woocommerce_product_import_inserted_product_object', array(
				$this,
				'bind_product_to_brands_for_wc_import'
			), 10, 2 );

			// brand rewrite
			add_action( 'admin_init', array( $this, 'add_permalink_setting' ) );
			add_filter( 'pre_update_option_woocommerce_permalinks', array( $this, 'save_permalink_setting' ), 10, 1 );
		}

		/**
		 * Enqueue plugin admin styles when required
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			$screen = get_current_screen();

			parent::enqueue();

			if ( $screen->id == 'edit-' . YITH_WCBR::$brands_taxonomy ) {
				wp_enqueue_style( 'yith-wcbr-admin', YITH_WCBR_URL . 'assets/css/admin/yith-wcbr.css' );
			}
		}

		/* === PLUGIN PANEL METHODS === */

		/**
		 * Filters available tabs on premium version of the plugin
		 *
		 * @return void
		 * @since 1.1.2
		 */
		public function filter_available_tabs() {
			// adds tools tab
			$this->available_tabs['tools'] = __( 'Tools', 'yith-woocommerce-brands-add-on' );

			// remove premium tab
			unset( $this->available_tabs['premium'] );
		}

		/**
		 * Adds premium option to plugin panel
		 *
		 * @param $options mixed Original options array
		 *
		 * @return mixed Filtered option array
		 * @since 1.0.0
		 */
		public function filter_setting_options( $options ) {
			$section_start = array_splice( $options['settings'], 0, 1 );
			$section_end   = array_splice( $options['settings'], - 1, 1 );

			$product_taxonomies          = array();
			$product_taxonomies_raw      = get_object_taxonomies( 'product', 'objects' );
			$excluded_product_taxonomies = array(
				'product_type',
				'product_shipping_class',
				'yith_product_brand'
			);

			if ( ! empty( $product_taxonomies_raw ) ) {
				foreach ( $product_taxonomies_raw as $taxonomy_slug => $taxonomy ) {
					if ( in_array( $taxonomy_slug, $excluded_product_taxonomies ) ) {
						continue;
					}

					$product_taxonomies[ $taxonomy_slug ] = $taxonomy->label;
				}
			}

			$premium_options_chunck_1 = array(
				'general-brand-taxonomy'         => array(
					'id'      => 'yith_wcbr_brands_taxonomy',
					'name'    => __( 'Product brand taxonomy', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'select',
					'options' => apply_filters( 'yith_wcbr_product_taxonomies', array_merge(
						array(
							'yith_product_brand' => __( 'Default brand taxonomy', 'yith-woocommerce-brands-add-on' )
						),
						$product_taxonomies
					) ),
					'desc'    => __( 'Select the taxonomy whose terms will be used as brands; not all taxonomies support all plugin features, so if you change this option it is at your own risk', 'yith-woocommerce-brands-add-on' ),
					'class'   => 'wc-enhanced-select',
					'default' => 'yith_product_brand',
					'css'     => 'max-width:300px;'
				),
				'general-brand-taxonomy-rewrite' => array(
					'id'      => 'yith_wcbr_brands_taxonomy_rewrite',
					'name'    => __( 'Product brand taxonomy rewrite', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'text',
					'desc'    => __( 'Enter slug that should be used when generating brands\' urls; please note that after changing this option you may need to re-save your permalinks to avoid 404 errors', 'yith-woocommerce-brands-add-on' ),
					'default' => 'product-brands',
					'css'     => 'min-width:300px;'
				)
			);

			$premium_options_chunck_2 = array(
				'general-brand-single-product-position'  => array(
					'id'      => 'yith_wcbr_single_product_brands_position',
					'name'    => __( 'Single product brand position', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'select',
					'options' => array(
						'none'                                     => __( 'Hide on single product page', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_before_single_title' => __( 'Before product title', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_title'        => __( 'After product title', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_price'        => __( 'After product price', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_excerpt'      => __( 'After product excerpt', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_add_to_cart'  => __( 'After single Add to Cart', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_product_meta_end'             => __( 'After product meta', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_sharing'      => __( 'After product share', 'yith-woocommerce-brands-add-on' )
					),
					'desc'    => __( 'Position for brand list', 'yith-woocommerce-brands-add-on' ),
					'default' => 'woocommerce_template_single_meta',
					'css'     => 'min-width:300px;'
				),
				'general-brand-single-product-content'   => array(
					'id'      => 'yith_wcbr_single_product_brands_content',
					'name'    => __( 'Single product brand content', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'select',
					'options' => array(
						'both' => __( 'Both name and logo', 'yith-woocommerce-brands-add-on' ),
						'logo' => __( 'Only logo', 'yith-woocommerce-brands-add-on' ),
						'name' => __( 'Only name', 'yith-woocommerce-brands-add-on' )
					),
					'desc'    => __( 'Content to show for brands in single product page', 'yith-woocommerce-brands-add-on' ),
					'default' => 'both',
					'css'     => 'min-width:300px;'
				),
				'general-brand-single-product-size'      => array(
					'id'      => 'yith_wcbr_single_product_brands_size',
					'name'    => __( 'Standard size of brand images in product page', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'yith_wcbr_image_size',
					'desc'    => __( 'This is the size of images that will be used as brand thumbnails in single product page', 'yith-woocommerce-brands-add-on' ),
					'default' => array(
						'width'  => apply_filters( 'yith_wcbr_single_thumb_width', 0 ),
						'height' => apply_filters( 'yith_wcbr_single_thumb_width', 30 ),
						'crop'   => apply_filters( 'yith_wcbr_single_thumb_width', true )
					)
				),
				'general-brand-loop-product-position'    => array(
					'id'      => 'yith_wcbr_loop_product_brands_position',
					'name'    => __( 'Product brand position in loop page', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'select',
					'options' => array(
						'none'                                  => __( 'Hide on loop', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_loop_price'       => __( 'After product price', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_loop_add_to_cart' => __( 'After "Add to Cart" in loop', 'yith-woocommerce-brands-add-on' )
					),
					'desc'    => __( 'Position of brand list', 'yith-woocommerce-brands-add-on' ),
					'default' => 'woocommerce_template_loop_price',
					'css'     => 'min-width:300px;'
				),
				'general-brand-loop-product-size'        => array(
					'id'      => 'yith_wcbr_loop_product_brands_size',
					'name'    => __( 'Standard size of brand images in shop page', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'yith_wcbr_image_size',
					'desc'    => __( 'This is the size of images that will be used as brand thumbnails in shop page', 'yith-woocommerce-brands-add-on' ),
					'default' => array(
						'width'  => apply_filters( 'yith_wcbr_grid_thumb_width', 0 ),
						'height' => apply_filters( 'yith_wcbr_grid_thumb_height', 60 ),
						'crop'   => apply_filters( 'yith_wcbr_grid_thumb_crop', true )
					)
				),
				'general-brand-loop-product-content'     => array(
					'id'      => 'yith_wcbr_loop_product_brands_content',
					'name'    => __( 'Loop product brand content', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'select',
					'options' => array(
						'both' => __( 'Both name and logo', 'yith-woocommerce-brands-add-on' ),
						'logo' => __( 'Only logo', 'yith-woocommerce-brands-add-on' ),
						'name' => __( 'Only name', 'yith-woocommerce-brands-add-on' )
					),
					'desc'    => __( 'Content to show for brands in loop page', 'yith-woocommerce-brands-add-on' ),
					'default' => 'name',
					'css'     => 'min-width:300px;'
				),
				'genera-brand-loop-enable-brand-sorting' => array(
					'id'      => 'yith_wcbr_enable_brand_sorting',
					'name'    => __( 'Enable "Sort by Brand"', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'checkbox',
					'desc'    => __( 'Enable "Sort by Brand" option in shop archive page', 'yith-woocommerce-brands-add-on' ),
					'default' => 'no',
					'css'     => 'min-width:300px;'
				),
				'general-brand-use-logo-default'         => array(
					'id'      => 'yith_wcbr_use_logo_default',
					'name'    => __( 'Use brand default logo', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'checkbox',
					'desc'    => __( 'Use default image when no logo is selected or not', 'yith-woocommerce-brands-add-on' ),
					'default' => 'no',
					'css'     => 'min-width:300px;'
				),
				'general-brand-logo-default'             => array(
					'id'   => 'yith_wcbr_logo_default',
					'name' => __( 'Default logo', 'yith-woocommerce-brands-add-on' ),
					'type' => 'yith_wcbr_upload_image',
				)
			);

			$options['settings'] = array_merge( $section_start, $premium_options_chunck_1, $options['settings'], $premium_options_chunck_2, $section_end );

			return $options;
		}

		/**
		 * Print custom upload filed on plugin panel
		 *
		 * @param $value mixed Array of filed options
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_image_upload_field( $value ) {
			// define templates for the field
			extract( $value );

			$image_id = get_option( 'yith_wcbr_logo_default' );
			$image    = $image_id ? wp_get_attachment_thumb_url( $image_id ) : wc_placeholder_img_src();

			// include field template
			include( YITH_WCBR_DIR . 'templates/admin/fields/upload-image.php' );
		}

		/**
		 * Print custom image size filed on plugin panel
		 *
		 * @param $value mixed Array of filed options
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_image_size_field( $value ) {
			// define templates for the field
			extract( $value );

			if ( ! isset( $default ) ) {
				$default = array(
					'width'  => 0,
					'height' => 30,
					'crop'   => false
				);
			}

			$image_size = get_option( $id, $default );

			// include field template
			include( YITH_WCBR_DIR . 'templates/admin/fields/image-size.php' );
		}

		/**
		 * Print tools panel for brand page
		 *
		 * @return void
		 * @since 1.1.2
		 */
		public function print_tools_panel() {
			$this->execute_tools();

			include( YITH_WCBR_DIR . 'templates/admin/tools-panel.php' );
		}

		/**
		 * Handle tools panel actions
		 *
		 * @return void
		 * @since 1.1.2
		 */
		public function execute_tools() {
			if ( ! empty( $_GET['action'] ) && ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'yith_wcbr_tools' ) ) {
				switch ( $_GET['action'] ) {
					case 'clear_transient_brand_category':
						delete_transient( 'yith_wcbr_brand_category_relationships' );
						echo '<div class="updated"><p>' . __( 'Transient successfully deleted', 'yith-woocommerce-brands-add-on' ) . '</p></div>';
						break;
					case 'clear_transient_category_brand':
						delete_transient( 'yith_wcbr_category_brand_relationships' );
						echo '<div class="updated"><p>' . __( 'Transient successfully deleted', 'yith-woocommerce-brands-add-on' ) . '</p></div>';
						break;
					case 'clear_transients':
						delete_transient( 'yith_wcbr_brand_category_relationships' );
						delete_transient( 'yith_wcbr_category_brand_relationships' );
						echo '<div class="updated"><p>' . __( 'Transient successfully deleted', 'yith-woocommerce-brands-add-on' ) . '</p></div>';
						break;
					case 'recount_terms':
						$brands = yith_wcbr_get_terms( YITH_WCBR::$brands_taxonomy, array(
							'hide_empty' => false,
							'fields'     => 'tt_ids'
						) );

						wp_update_term_count_now( $brands, YITH_WCBR::$brands_taxonomy );
						echo '<div class="updated"><p>' . __( 'Terms correctly counted', 'yith-woocommerce-brands-add-on' ) . '</p></div>';
						break;
				}
			}
		}

		/* === PLUGIN TAXONOMY METHODS === */

		/**
		 * Prints custom term fields on "Add Brand" page
		 *
		 * @param $term string Current taxonomy id
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_brand_taxonomy_fields( $term ) {
			// include basic options
			parent::add_brand_taxonomy_fields( $term );

			// include premium options
			include( YITH_WCBR_DIR . 'templates/admin/add-brand-taxonomy-form-premium.php' );
		}

		/**
		 * Prints custom term fields on "Edit Brand" page
		 *
		 * @param $term string Current taxonomy id
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function edit_brand_taxonomy_fields( $term ) {
			// include basic options
			parent::edit_brand_taxonomy_fields( $term );

			$banner_id  = absint( yith_wcbr_get_term_meta( $term->term_id, 'banner_id', true ) );
			$banner     = $banner_id ? wp_get_attachment_thumb_url( $banner_id ) : wc_placeholder_img_src();
			$custom_url = yith_wcbr_get_term_meta( $term->term_id, 'custom_url', true );

			// include premium options
			include( YITH_WCBR_DIR . 'templates/admin/edit-brand-taxonomy-form-premium.php' );
		}

		/**
		 * Save custom term fields
		 *
		 * @param $term_id  int Currently saved term id
		 * @param $tt_id    |string int Term Taxonomy id
		 * @param $taxonomy string Current taxonomy slug
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function save_brand_taxonomy_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			parent::save_brand_taxonomy_fields( $term_id, $tt_id, $taxonomy );

			if ( isset( $_POST['product_brand_banner_id'] ) && YITH_WCBR::$brands_taxonomy === $taxonomy ) {
				yith_wcbr_update_term_meta( $term_id, 'banner_id', absint( $_POST['product_brand_banner_id'] ) );
			}

			if ( isset( $_POST['product_brand_custom_url'] ) && YITH_WCBR::$brands_taxonomy === $taxonomy ) {
				yith_wcbr_update_term_meta( $term_id, 'custom_url', esc_url( $_POST['product_brand_custom_url'] ) );
			}
		}

		/**
		 * Check whether we're using an attribute as Brand taxonomy, and change register_taxonomy args consequently
		 *
		 * @return void
		 * @since 1.0.10
		 */
		public function check_woocommerce_brand_taxonomy() {
			$wc_product_attributes = wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_name' );
			$taxonomy_name         = YITH_WCBR::$brands_taxonomy;

			foreach ( $wc_product_attributes as $index => $attribute ) {
				$wc_product_attributes[ $index ] = wc_attribute_taxonomy_name( $attribute );
			}

			if ( in_array( $taxonomy_name, (array) $wc_product_attributes ) ) {
				add_filter( "woocommerce_taxonomy_args_{$taxonomy_name}", array(
					$this,
					'change_woocommerce_brand_taxonomy_args'
				) );
			}
		}

		/**
		 * Set show_in_menu param for attributes taxonomy, when used as brand taxonomy
		 *
		 * @param $args array Original register_taxonomy arguments
		 *
		 * @return array Filtered register_taxonomy arguments
		 * @since 1.0.10
		 */
		public function change_woocommerce_brand_taxonomy_args( $args ) {
			$args['show_admin_column'] = true;

			return $args;
		}

		/* === IMPORT EXPORT METHODS === */

		/**
		 * Print "Import CSV" button in brand taxonomy
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_import_link() {
			$screen = get_current_screen();

			if ( $screen->id == 'edit-' . YITH_WCBR::$brands_taxonomy ) {
				$action = sprintf( '<p class="import-csv"></p><a href="%s" class="button button-secondary">%s</a></p>', admin_url( 'admin.php?import=yith_wcbr_brand_csv' ), __( 'Import from CSV', 'yith-woocommerce-brands-add-on' ) );

				echo $action;
			}
		}

		/**
		 * Register wordpress importer
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_csv_importer() {
			register_importer( 'yith_wcbr_brand_csv', __( 'YITH Brands (CSV)', 'yith-woocommerce-brands-add-on' ), __( 'Import <strong>brands</strong> to your store via csv file.', 'yith-woocommerce-brands-add-on' ), array(
				$this,
				'import_csv'
			) );
			register_importer( 'yith_wcbr_brand_connection_csv', __( 'YITH Brands Connections (CSV)', 'yith-woocommerce-brands-add-on' ), __( 'Import <strong>brands connections</strong> to your store via csv file.', 'yith-woocommerce-brands-add-on' ), array(
				$this,
				'import_csv'
			) );
		}

		/**
		 * Print js code used to add bulk action "Export CSV" in add tag screen
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_export_action() {
			$screen = get_current_screen();

			if ( $screen->id == 'edit-' . YITH_WCBR::$brands_taxonomy ):
				?>

				<script type="text/javascript">
					jQuery(function () {
						jQuery('<option>').val('export_csv').text('<?php _e( 'Export CSV', 'yith-woocommerce-brands-add-on' )?>').appendTo("select[name='action']");
						jQuery('<option>').val('export_csv').text('<?php _e( 'Export CSV', 'yith-woocommerce-brands-add-on' )?>').appendTo("select[name='action2']");
					});
				</script>

			<?php
			endif;
		}

		/**
		 * Generate file csv to export brands
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function export_csv() {
			global $pagenow;

			if (
				$pagenow == 'edit-tags.php' &&
				! empty( $_REQUEST['delete_tags'] ) &&
				(
					( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'export_csv' ) ||
					( isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] == 'export_csv' )
				)
			) {
				$terms = $_REQUEST['delete_tags'];

				$sitename = sanitize_key( get_bloginfo( 'name' ) );
				$sitename .= ( ! empty( $sitename ) ) ? '.' : '';
				$filename = $sitename . 'wordpress.' . date( 'Y-m-d' ) . '.csv';
				$base_url = is_multisite() ? network_home_url() : get_bloginfo_rss( 'url' );

				// create csv file content
				$formatted_terms   = array();
				$formatted_terms[] = array(
					'id',
					'name',
					'slug',
					'description',
					'parent',
					'base_siste_url',
					'thumbnail',
					'banner',
					'custom_url'
				);

				foreach ( $terms as $term_id ) {
					// retrieve term
					$term = get_term( $term_id, YITH_WCBR::$brands_taxonomy );

					// retrieve thumbnail
					$term_thumbnail_id = absint( yith_wcbr_get_term_meta( $term_id, 'thumbnail_id', true ) );
					$term_image        = $term_thumbnail_id ? wp_get_attachment_url( $term_thumbnail_id ) : '';

					// retrieve banner
					$term_banner_id = absint( yith_wcbr_get_term_meta( $term_id, 'banner_id', true ) );
					$term_banner    = $term_banner_id ? wp_get_attachment_url( $term_banner_id ) : '';

					// retrieve custom url
					$term_custom_url = yith_wcbr_get_term_meta( $term_id, 'custom_url', true );

					// retrieve term parent
					$term_parent_slug = '';
					if ( $term->parent ) {
						$term_parent_obj  = get_term( $term->parent, YITH_WCBR::$brands_taxonomy );
						$term_parent_slug = ( $term_parent_obj && ! is_wp_error( $term_parent_obj ) ) ? $term_parent_obj->slug : '';
					}

					$formatted_terms[] = array(
						$term_id,
						$term->name,
						$term->slug,
						$term->description,
						$term_parent_slug,
						$base_url,
						$term_image,
						$term_banner,
						$term_custom_url
					);
				}

				header( 'Content-Description: File Transfer' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );

				$df = fopen( 'php://output', 'w' );

				foreach ( $formatted_terms as $row ) {
					fputcsv( $df, $row );
				}

				fclose( $df );

				die();
			}
		}

		/**
		 * Import brands from csv
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function import_csv() {
			$importer = wc_clean( $_REQUEST['import'] );

			if ( ! class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

				if ( file_exists( $class_wp_importer ) ) {
					require $class_wp_importer;
				}
			}

			switch ( $importer ) {
				case 'yith_wcbr_brand_csv':
					require YITH_WCBR_DIR . 'includes/importer/class.yith-wcbr-csv-importer.php';
					$importer_class = YITH_WCBR_CSV_Importer();
					break;
				case 'yith_wcbr_brand_connection_csv':
					require YITH_WCBR_DIR . 'includes/importer/class.yith-wcbr-csv-connection-importer.php';
					$importer_class = YITH_WCBR_CSV_Connection_Importer();
					break;
				default:
					return;
			}

			// Dispatch
			$importer_class->dispatch();
		}

		/* === COUPON RESTRICTIONS === */

		/**
		 * Print additional coupon fields
		 *
		 * @return void
		 * @var $coupon    \WC_Coupon Coupon
		 * @var $coupon_id int Coupon id
		 */
		public function add_brand_coupon_restrictions( $coupon_id, $coupon ) {
			$brands          = get_terms( array(
				'taxonomy' => YITH_WCBR::$brands_taxonomy
			) );
			$allowed_brands  = array();
			$excluded_brands = array();

			if ( $coupon ) {
				$allowed_brands  = $coupon->get_meta( 'allowed_brands', true );
				$excluded_brands = $coupon->get_meta( 'excluded_brands', true );
			}

			include YITH_WCBR_DIR . 'templates/admin/coupon-restrictions.php';
		}

		/**
		 * Save additional coupon fields
		 *
		 * @return void
		 * @var $coupon    \WC_Coupon Coupon
		 * @var $coupon_id int Coupon id
		 */
		public function save_brand_coupon_restrictions( $coupon_id, $coupon ) {
			$allowed_brands  = isset( $_POST['allowed_brands'] ) ? (array) $_POST['allowed_brands'] : array();
			$excluded_brands = isset( $_POST['excluded_brands'] ) ? (array) $_POST['excluded_brands'] : array();

			$coupon->update_meta_data( 'allowed_brands', array_filter( array_map( 'intval', $allowed_brands ) ) );
			$coupon->update_meta_data( 'excluded_brands', array_filter( array_map( 'intval', $excluded_brands ) ) );

			$coupon->save();
		}

		/* === WC IMPORT/EXPORT COMPATIBILITY METHODS === */

		/**
		 * Register brands column in WooCommerce exporter
		 *
		 * @param $column array Array of column to export
		 *
		 * @return array Array of filtered columns
		 *
		 * @since 1.2.0
		 */
		public function register_brands_for_wc_export( $columns ) {
			$tag_pos = array_search( 'tag_ids', array_keys( $columns ) ) + 1;

			$columns = array_merge(
				array_slice( $columns, 0, $tag_pos ),
				array( 'brand_ids' => __( 'Brands', 'yith-woocommerce-brands-add-on' ) ),
				array_slice( $columns, $tag_pos )
			);

			return $columns;
		}

		/**
		 * Retrieves brands to export
		 *
		 * @param $value   mixed Original value for the cell
		 * @param $product \WC_Product Product for the current row
		 *
		 * @return mixed Filtered value of the cell
		 *
		 * @since 1.2.0
		 */
		public function retrieve_brands_for_wc_export( $value, $product ) {
			$brand_ids = wp_get_post_terms( yit_get_base_product_id( $product ), YITH_WCBR::$brands_taxonomy, array( 'fields' => 'ids' ) );
			$exporter  = new WC_Product_CSV_Exporter();

			return $exporter->format_term_ids( $brand_ids, YITH_WCBR::$brands_taxonomy );
		}

		/**
		 * Binds "Brands" column heading to brands' handling
		 *
		 * @param $columns array Original array of relationships
		 *
		 * @return array Filtered array of relationships
		 *
		 * @since 1.2.0
		 */
		public function normalize_brands_column_for_wc_import( $columns ) {
			$columns[ __( 'Brands', 'yith-woocommerce-brands' ) ] = 'brand_ids';

			return $columns;
		}

		/**
		 * Add Brands option to import fields
		 *
		 * @param $mapping array Original array of import fields
		 *
		 * @return array Filtered array of import fields
		 *
		 * @since 1.2.0
		 */
		public function map_brands_for_wc_import( $mapping ) {
			$tag_pos = array_search( 'tag_ids', array_keys( $mapping ) ) + 1;

			$mapping = array_merge(
				array_slice( $mapping, 0, $tag_pos ),
				array( 'brand_ids' => __( 'Brands', 'yith-woocommerce-brands-add-on' ) ),
				array_slice( $mapping, $tag_pos )
			);

			return $mapping;
		}

		/**
		 * Register callback for brands handling during import
		 *
		 * @param $callbacks array Original array of callbacks
		 * @param $importer  \WC_Product_CSV_Importer Importer object
		 *
		 * @return array Filtered array of callbacks
		 *
		 * @since 1.2.0
		 */
		public function register_brands_for_wc_import( $callbacks, $importer ) {
			$mapped_keys = $importer->get_mapped_keys();
			$brand_pos   = array_search( 'brand_ids', $mapped_keys );

			if ( $brand_pos !== false ) {
				$callbacks[ $brand_pos ] = array( $this, 'parse_brands_for_wc_import' );
			}

			return $callbacks;
		}

		/**
		 * Parse brands cell for import
		 *
		 * @param $value mixed Value of the Brands column
		 *
		 * @return mixed Filtered value of the Brands column
		 *
		 * @since 1.2.0
		 */
		public function parse_brands_for_wc_import( $value ) {
			if ( empty( $value ) ) {
				return array();
			}

			$row_terms = explode( ',', $value );
			$brands    = array();

			foreach ( $row_terms as $row_term ) {
				$parent = null;
				$_terms = array_map( 'trim', explode( '>', $row_term ) );
				$total  = count( $_terms );

				foreach ( $_terms as $index => $_term ) {
					// Check if brand exists. Parent must be empty string or null if doesn't exists.
					$term = term_exists( $_term, YITH_WCBR::$brands_taxonomy, $parent );

					if ( is_array( $term ) ) {
						$term_id = $term['term_id'];
					} else {
						$term = wp_insert_term( $_term, YITH_WCBR::$brands_taxonomy, array( 'parent' => intval( $parent ) ) );

						if ( is_wp_error( $term ) ) {
							break; // We cannot continue if the term cannot be inserted.
						}

						$term_id = $term['term_id'];
					}

					// Only requires assign the last brand.
					if ( ( 1 + $index ) === $total ) {
						$brands[] = $term_id;
					} else {
						// Store parent to be able to insert or query categories based in parent ID.
						$parent = $term_id;
					}
				}
			}

			return $brands;
		}

		/**
		 * Add brands terms to currently imported product
		 *
		 * @param $object \WC_Product Imported product
		 * @param $data   array Array of original CSV row
		 *
		 * @return void
		 *
		 * @since 1.2.0
		 */
		public function bind_product_to_brands_for_wc_import( $object, $data ) {
			if ( empty( $data['brand_ids'] ) ) {
				return;
			}

			foreach ( $data['brand_ids'] as $id ) {
				$term = get_term_by( 'id', $id, YITH_WCBR::$brands_taxonomy );
				wp_add_object_terms( yit_get_base_product_id( $object ), $term->name, YITH_WCBR::$brands_taxonomy );
			}
		}

		/* === ADD BRAND FILTER TO ADMIN PRODUCT PAGE === */

		/**
		 * Brand filter for products post type
		 *
		 * @return void
		 * @since 1.0.9
		 */
		public function add_product_filter_by_brand() {
			global $typenow;

			if ( 'product' == $typenow ) {

				$current_product_brand = isset( $_GET[ apply_filters( 'yith_wcbr_change_brand_name_in_filter', YITH_WCBR::$brands_taxonomy ) ] ) ? $_GET[ apply_filters( 'yith_wcbr_change_brand_name_in_filter', YITH_WCBR::$brands_taxonomy ) ] : '';

				$terms  = yith_wcbr_get_terms( YITH_WCBR::$brands_taxonomy, apply_filters( 'yith_wcbr_product_filter_by_brand_args', array( 'orderby' => 'name' ) ) );
				$output = '';

				if ( ! empty( $terms ) ) {
					$output .= '<select name="' . apply_filters( 'yith_wcbr_change_brand_name_in_filter', YITH_WCBR::$brands_taxonomy ) . '" class="dropdown_product_brand">';

					$output .= '<option value="" ' . selected( $current_product_brand, '', false ) . '>' . __( 'Select a brand', 'yith-woocommerce-brands-add-on' ) . '</option>';

					foreach ( $terms as $term ) {
						$output .= '<option value="' . $term->slug . '" ' . selected( $current_product_brand, $term->slug, false ) . '>' . sprintf( '%s (%d)', $term->name, $term->count ) . '</option>';
					}

					$output .= '</select>';
				}

				echo $output;
			}
		}

		/* === REGISTER BRAND TAXONOMY AS SORTABLE === */

		/**
		 * Register brand taxonomy as sortable for WooCommerce
		 *
		 * @param $sortable_taxonomies array Array of sortable taxonomies
		 *
		 * @return array Filtered array of sortable taxonomies
		 * @since 1.0.10
		 */
		public function register_as_sortable( $sortable_taxonomies ) {
			$sortable_taxonomies[] = YITH_WCBR::$brands_taxonomy;

			return $sortable_taxonomies;
		}

		/* === REWRITE === */

		/**
		 * Register brand rewrite settings to be print out on permalinks settings page
		 *
		 * @return void
		 * @since 1.3.7
		 */
		public function add_permalink_setting() {
			add_settings_field(
				'yith_wcbr_brands_taxonomy_rewrite',
				__( 'Product brand base', 'yith-woocommerce-brands-add-on' ),
				array( $this, 'print_permalink_setting' ),
				'permalink',
				'optional'
			);
		}

		/**
		 * Print field to enter brand rewrite on permalinks settings page
		 *
		 * @return void
		 * @since 1.3.7
		 */
		public function print_permalink_setting() {
			$brand_rewrite = get_option( 'yith_wcbr_brands_taxonomy_rewrite', 'product-brands' );
			?>
			<input name="yith_wcbr_brands_taxonomy_rewrite" type="text" class="regular-text code" value="<?php echo esc_attr( $brand_rewrite ); ?>" placeholder="<?php echo esc_attr_x( 'product-brand', 'slug', 'yith-woocommerce-brands-add-on' ); ?>"/>
			<?php
		}

		/**
		 * Save permalinks settings
		 *
		 * This method will:
		 * - save brand rewrite, if submitted
		 * - filter woocommerce permalinks and apply fix to product rewrite if needed to avoid conflict with page url
		 *   when using %yith_product_brand% placeholder
		 *
		 * @param $permalinks array Array of store permalinks being saved
		 *
		 * @return array Array of filtered store permalinks to save
		 * @since 1.3.7
		 */
		public function save_permalink_setting( $permalinks ) {

			// fix product rewrite
			$brand_taxonomy = YITH_WCBR::$brands_taxonomy;
			$product_base   = isset( $permalinks['product_base'] ) ? $permalinks['product_base'] : '';

			if ( "/%{$brand_taxonomy}%/" === trailingslashit( $product_base ) ) {
				$product_base = '/' . _x( 'product', 'slug', 'woocommerce' ) . $product_base;
			}

			$permalinks['product_base'] = wc_sanitize_permalink( $product_base );

			// save brand rewrite
			if ( isset( $_POST['yith_wcbr_brands_taxonomy_rewrite'] ) ) {
				$brand_rewrite = wc_sanitize_permalink( wp_unslash( $_POST['yith_wcbr_brands_taxonomy_rewrite'] ) );
				update_option( 'yith_wcbr_brands_taxonomy_rewrite', $brand_rewrite );
			}

			return $permalinks;
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCBR_Admin_Premium
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCBR_Admin_Premium class
 *
 * @return \YITH_WCBR_Admin_Premium
 * @since 1.0.0
 */
function YITH_WCBR_Admin_Premium() {
	return YITH_WCBR_Admin_Premium::get_instance();
}