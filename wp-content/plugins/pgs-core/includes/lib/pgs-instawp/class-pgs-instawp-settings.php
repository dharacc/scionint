<?php
/**
 * PGS_InstaWP_Settings wrapper class.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PGS_InstaWP_Settings class.
 */
if ( ! class_exists( 'PGS_InstaWP_Settings' ) ) :

class PGS_InstaWP_Settings {

	/**
	 * Sections array.
	 *
	 * @var   array
	 */
	private $settings_sections = array();

	/**
	 * Fields array.
	 *
	 * @var   array
	 */
	private $settings_fields = array();

	/**
	 * Settings menu slug.
	 *
	 * @var   string
	 */
	private $menu_slug = '';

	/**
	 * Settings Page Title.
	 *
	 * @var   string
	 */
	private $settings_page_title = '';

	/**
	 * Settings Menu Title.
	 *
	 * @var   string
	 */
	private $settings_menu_title = '';

	/**
	 * Constructor.
	 *
	 * @param array $args  Class arguments.
	 * @since 1.0.0
	 */
	public function __construct( $args = array() ) {

		$defaults = array(
			'page_title'    => esc_html__( 'PGS InstaWP Settings', 'pgs-core' ),
			'menu_title'    => esc_html__( 'PGS InstaWP', 'pgs-core' ),
			'menu_slug'     => 'pgs_instawp',
			'option_prefix' => 'pgs_instawp',
		);

		$settings_args = wp_parse_args( $args, $defaults );

		$this->settings_page_title = $settings_args['page_title'];
		$this->settings_menu_title = $settings_args['menu_title'];
		$this->menu_slug           = $settings_args['menu_slug'];

		// Enqueue the admin scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

	}

	/**
	 * Admin Scripts.
	 *
	 * @since 1.0.0
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_media();
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery' );
		if ( ! wp_script_is( 'js-cookie', 'enqueued' ) ) {
			wp_enqueue_script( 'js-cookie', get_parent_theme_file_uri( '/js/cookie.min.js' ), array( 'jquery' ), '2.1.4', true );
		}
		wp_enqueue_script( 'pgs-instawp', trailingslashit( PGS_INSTAWP_URL ) . 'js/pgs-instawp.js', array( 'jquery' ), null, true );
	}

	/**
	 * Admin Styles.
	 *
	 * @since 1.0.0
	 */
	public function admin_styles() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'pgs-instawp', trailingslashit( PGS_INSTAWP_URL ) . 'css/pgs-instawp.css', array(), null );
	}


	/**
	 * Set Sections.
	 *
	 * @param array $sections   Sections.
	 * @since 1.0.0
	 */
	public function set_sections( $sections ) {
		// Bail if not array.
		if ( ! is_array( $sections ) ) {
			return false;
		}

		// Assign to the sections array.
		$this->settings_sections = $sections;

		return $this;
	}


	/**
	 * Add a single section.
	 *
	 * @param array $section   Section.
	 * @since 1.0.0
	 */
	public function add_section( $section ) {
		// Bail if not array.
		if ( ! is_array( $section ) ) {
			return false;
		}

		// Assign the section to sections array.
		$this->settings_sections[] = $section;

		return $this;
	}


	/**
	 * Set Fields.
	 *
	 * @param array $fields   Fields.
	 * @since 1.0.0
	 */
	public function set_fields( $fields ) {
		// Bail if not array.
		if ( ! is_array( $fields ) ) {
			return false;
		}

		// Assign the fields.
		$this->settings_fields = $fields;

		return $this;
	}



	/**
	 * Add a single field.
	 *
	 * @param array $section       Section.
	 * @param array $field_array   Field array.
	 * @since 1.0.0
	 */
	public function add_field( $section, $field_array ) {
		// Set the defaults.
		$defaults = array(
			'id'    => '',
			'title' => '',
			'desc'  => '',
			'type'  => 'text',
		);

		// Combine the defaults with user's arguements.
		$arg = wp_parse_args( $field_array, $defaults );

		// Each field is an array named against its section.
		$this->settings_fields[ $section ][] = $arg;

		return $this;
	}

	/**
	 * Initialize API.
	 *
	 * Initializes and registers the settings sections and fields.
	 * Usually this should be called at `admin_init` hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_init() {
		/**
		 * Register the sections.
		 *
		 * Sections array is like this:
		 *
		 * $settings_sections = array (
		 *   $section_array,
		 *   $section_array,
		 *   $section_array,
		 * );
		 *
		 * Section array is like this:
		 *
		 * $section_array = array (
		 *   'id'    => 'section_id',
		 *   'title' => 'Section Title'
		 * );
		 *
		 * @since 1.0.0
		 */
		foreach ( $this->settings_sections as $section ) {
			if ( false === (bool) get_option( $section['id'] ) ) {
				// Add a new field as section ID.
				add_option( $section['id'] );
			}

			// Deals with sections description.
			if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
				// Build HTML.
				$section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';

				// Create the callback for description.
				$callback = function() use ( $section ) {
					echo str_replace( '"', '\"', $section['desc'] );
				};

			} elseif ( isset( $section['callback'] ) ) {
				$callback = $section['callback'];
			} else {
				$callback = null;
			}

			/**
			 * Add a new section to a settings page.
			 *
			 * @param string $id
			 * @param string $title
			 * @param callable $callback
			 * @param string $page | Page is same as section ID.
			 * @since 1.0.0
			 */
			add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
		} // foreach ended.

		/**
		 * Register settings fields.
		 *
		 * Fields array is like this:
		 *
		 * $settings_fields = array (
		 *   $section => $field_array,
		 *   $section => $field_array,
		 *   $section => $field_array,
		 * );
		 *
		 *
		 * Field array is like this:
		 *
		 * $field_array = array (
		 *   'id'   => 'id',
		 *   'name' => 'Name',
		 *   'type' => 'text',
		 * );
		 *
		 * @since 1.0.0
		 */
		foreach ( $this->settings_fields as $section => $field_array ) {
			foreach ( $field_array as $field ) {

				if ( ! isset( $field['id'] ) || empty( $field['id'] ) ) {
					continue;
				}

				$field_id = $field['id'];

				$defaults = array(
					'id'                => $field_id,
					'type'              => 'text',
					'title'             => 'No Name Added',
					'label_for'         => $field_id,
					'desc'              => '',
					'desc_kses'         => array(),
					'section'           => $section,
					'class'             => '',
					'size'              => 'regular',
					'options'           => '',
					'default'           => '',
					'placeholder'       => '',
					'sanitize_callback' => '',
					'field-class'       => '',
				);

				$args = wp_parse_args( $field, $defaults );
				if ( isset( $args['class'] ) && ! empty( $args['class'] ) ) {
					$args['field-class'] = $args['class'];
				}
				$wrapper_class = array(
					'field-wrapper',
					'field-section-' . $section,
					'field-type-' . $args['type'],
					'field-' . $field_id,
				);
				$args['class'] = implode( ' ', array_filter( array_unique( $wrapper_class ) ) );

				/**
				 * Add a new field to a section of a settings page.
				 *
				 * @param string   $id
				 * @param string   $title
				 * @param callable $callback
				 * @param string   $page
				 * @param string   $section = 'default'
				 * @param array    $args = array()
				 * @since 1.0.0
				 */
				add_settings_field(
					$field_id,                                      // ID.
					$args['title'],                                 // Title.
					// array( $this, 'callback_' . $args['type'] ), // Callback.
					array( $this, 'callback_field' ),               // Callback.
					$args['section'],                               // Page.
					$args['section'],                               // Section.
					$args                                           // Arguments.
				);

				register_setting(
					$section,
					$field_id,
					array( $this, 'sanitize_fields' )
				);

			} // foreach ended.
		} // foreach ended.

	} // admin_init() ended.


	/**
	 * Sanitize callback for Settings API fields.
	 *
	 * @param array $fields  Array.
	 * @since 1.0.0
	 */
	public function sanitize_fields( $fields ) {

		if ( is_array( $fields ) ) {
			foreach ( $fields as $field_slug => $field_value ) {
				$sanitize_callback = $this->get_sanitize_callback( $field_slug );

				// If callback is set, call it.
				if ( $sanitize_callback ) {
					$fields[ $field_slug ] = call_user_func( $sanitize_callback, $field_value );
					continue;
				}
			}
		}

		return $fields;
	}


	/**
	 * Get sanitization callback for given option slug
	 *
	 * @param string $slug option slug.
	 * @return mixed string | bool false
	 * @since 1.0.0
	 */
	public function get_sanitize_callback( $slug = '' ) {
		if ( empty( $slug ) ) {
			return false;
		}

		// Iterate over registered fields and see if we can find proper callback.
		foreach ( $this->settings_fields as $section => $field_array ) {
			foreach ( $field_array as $field ) {
				if ( $field['name'] != $slug ) {
					continue;
				}

				// Return the callback name.
				return isset( $field['sanitize_callback'] ) && is_callable( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : false;
			}
		}

		return false;
	}


	/**
	 * Get field description for display
	 *
	 * @param array $args  Settings field args.
	 */
	public function get_field_description( $args ) {
		if ( ! empty( $args['desc'] ) ) {
			$desc_kses = ( isset( $args['desc_kses'] ) && ! empty( $args['desc_kses'] ) ) ? $args['desc_kses'] : $args['desc_kses'];
			printf(
				'<p class="description">%s</p>',
				wp_kses( $args['desc'], $desc_kses )
			);
		}
	}


	/**
	 * Get custom attributes.
	 *
	 * @param array $data   Field data.
	 * @return string
	 */
	public function get_custom_attribute_html( $data ) {
		$custom_attributes = array();

		if ( ! empty( $data['custom_attributes'] ) && is_array( $data['custom_attributes'] ) ) {
			foreach ( $data['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		return implode( ' ', $custom_attributes );
	}

	/**
	 * Get classes.
	 *
	 * @param  array $args   Field data.
	 * @return string
	 */
	public function generate_classes( $args ) {
		if ( isset( $args['size'] ) && ! empty( $args['size'] ) ) {
			if ( 'regular' === $args['size'] ) {
				$args['size'] = 'regular-text';
			}elseif ( 'large' === $args['size'] ) {
				$args['size'] = 'large-text';
			}
		} else {
			$args['size'] = 'regular-text';
		}

		if ( 'link' === $args['type'] && ( isset( $args['link_type'] ) && ! empty( $args['link_type'] ) && 'button' === $args['link_type'] ) ) {
			unset( $args['size'] );
			$args['size'] = 'button';
		}

		if ( 'link' === $args['type']
			&& ( isset( $args['is_text_btn'] ) && $args['is_text_btn'] )
		) {
			$args['type'] = 'text-btn';
		}

		$classes = array_merge(
			array(
				'pgs-instawp-field',
				'pgs-instawp-field-' . $args['type'],
			),
			(array) $args['size']
		);

		if ( isset( $args['field-class'] ) && ! empty( $args['field-class'] ) ) {
			$classes = array_merge(
				$classes,
				(array) ( ( is_string( $args['field-class'] ) ) ? explode( ' ', $args['field-class'] ) : $args['field-class'] )
			);
		}

		$classes = implode( ' ', array_filter( array_unique( $classes ) ) );
		return $classes;
	}

	/**
	 * Callback field function.
	 *
	 * @param array $form_fields (default: array()) Array of form fields.
	 * @param bool  $echo Echo or return.
	 * @return string the html for the settings
	 * @since 1.0.0
	 * @uses   method_exists()
	 */
	function callback_field( $field ) {
		if ( method_exists( $this, 'generate_' . $field['type'] . '_html' ) ) {
			$this->{'generate_' . $field['type'] . '_html'}( $field );
		} else {
			$this->generate_text_html( $field );
		}

	}


	/**
	 * Displays a title field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_title_html( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['default'] ) );
		if ( '' !== $args['title'] ) {
			$name = $args['title'];
		} else {
		};
		$type = isset( $args['type'] ) ? $args['type'] : 'title';

		$html = '';
		echo $html;
	}


	/**
	 * Displays a text field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_text_html( $args ) {
		$defaults  = array(
			'title'             => '',
			'disabled'          => false,
			'readonly'          => false,
			'class'             => '',
			'css'               => '',
			'size'              => 'regular',
			'placeholder'       => '',
			'type'              => 'text',
			'default'           => '',
			'value'             => $this->get_option( $args['id'], $args['default'] ),
			'desc_tip'          => false,
			'desc'              => '',
			'custom_attributes' => array(),
			'field-class'       => '',
		);

		$args = wp_parse_args( $args, $defaults );

		printf(
			'<input type="%1$s" class="%2$s" id="%3$s" name="%3$s" value="%4$s" placeholder="%5$s" style="%6$s" %7$s %8$s %9$s />',
			esc_attr( $args['type'] ),
			esc_attr( $this->generate_classes( $args ) ),
			esc_attr( $args['id'] ),
			esc_attr( $args['value'] ),
			esc_attr( $args['placeholder'] ),
			esc_attr( $args['css'] ),
			disabled( $args['disabled'], true, false ),
			readonly( $args['readonly'], true, false ),
			$this->get_custom_attribute_html( $args ) // WPCS: XSS ok.
		);

		if ( isset( $args['with_btn'] ) && $args['with_btn'] && isset( $args['btn_params'] ) && ! empty( $args['btn_params'] ) ) {
			$defaults  = array(
				'id'                => $args['id'] . '_btn',
				'type'              => 'link',
				'class'             => 'button btn-with-regular-text',
				'css'               => '',
				'desc_tip'          => false,
				'description'       => '',
				'custom_attributes' => array(),
				'target'            => '_self',
				'value'             => '#',
				'link_title'        => esc_html__( 'Click Here', 'pgs-core' ),
				'rel'               => '',
			);

			$btn_params = wp_parse_args( $args['btn_params'], $defaults );
			$btn_params['is_text_btn'] = true;
			unset( $btn_params['description'] );
			unset( $btn_params['desc'] );

			$this->generate_link_html( $btn_params );
		}

		$this->get_field_description( $args );

	}


	/**
	 * Displays a url field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_url_html( $args ) {
		$this->generate_text_html( $args );
	}


	/**
	 * Displays a number field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_number_html( $args ) {
		$custom_attributes = array();
		if ( isset( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			$custom_attributes = $args['custom_attributes'];
		}

		if ( isset( $args['min'] ) && '' !== $args['min'] ) {
			$custom_attributes['min'] = $args['min'];
		}

		if ( isset( $args['max'] ) && '' !== $args['max'] ) {
			$custom_attributes['max'] = $args['max'];
		}

		if ( isset( $args['step'] ) && '' !== $args['step'] ) {
			$custom_attributes['step'] = $args['step'];
		}

		$args['custom_attributes'] = $custom_attributes;

		$this->generate_text_html( $args );
	}

	/**
	 * Displays a password field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_password_html( $args ) {
		$this->generate_text_html( $args );
	}


	/**
	 * Displays a checkbox for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_checkbox_html( $args ) {
		$defaults  = array(
			'title'             => '',
			'disabled'          => false,
			'checked'           => false,
			'class'             => '',
			'css'               => '',
			'type'              => 'text',
			'default'           => $args['default'],
			'value'             => $this->get_option( $args['id'], $args['default'] ),
			'desc_tip'          => false,
			'descr'             => '',
			'custom_attributes' => array(),
			'field-class'       => '',
			'label'             => ( isset( $args['label'] ) && ! empty( $args['label'] ) ) ? $args['label'] : $args['title'],
		);

		$args = wp_parse_args( $args, $defaults );
		?>
		<fieldset>
			<?php
			printf(
				'<label for="%1$s">',
				esc_attr( $args['id'] )
			);
			printf(
				'<input type="checkbox" class="checkbox" id="%1$s" name="%2$s" value="on" style="%3$s" %4$s %5$s %6$s />%7$s',
				esc_attr( $args['id'] ),
				esc_attr( $args['id'] ),
				esc_attr( $args['css'] ),
				checked( $args['value'], 'on', false ),
				disabled( $args['disabled'], true, false ),
				$this->get_custom_attribute_html( $args ), // WPCS: XSS ok.
				esc_html( $args['label'] )
			);
			?>
			</label>
			<?php $this->get_field_description( $args ); ?>
		</fieldset>
		<?php
	}


	/**
	 * Displays a selectbox for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_select_html( $args ) {
		$defaults  = array(
			'disabled'          => false,
			'name'              => '',
			'class'             => '',
			'css'               => '',
			'size'              => 'regular',
			'default'           => '',
			'value'             => $this->get_option( $args['id'], $args['default'] ),
			'desc_tip'          => false,
			'desc'              => '',
			'custom_attributes' => array(),
			'field-class'       => '',
		);

		$args = wp_parse_args( $args, $defaults );

		printf(
			'<select class="%1$s" id="%2$s" name="%3$s" style="%4$s" %5$s %6$s>',
			esc_attr( $this->generate_classes( $args ) ),
			esc_attr( $args['id'] ),
			esc_attr( $args['id'] ),
			esc_attr( $args['css'] ),
			disabled( $args['disabled'], true, false ),
			$this->get_custom_attribute_html( $args ) // WPCS: XSS ok.
		);

		foreach ( $args['options'] as $key => $label ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $key ),
				selected( $args['value'], $key, false ),
				esc_html( $label )
			);
		}
		printf( '</select>' );

		$this->get_field_description( $args );
	}


	/**
	 * Displays a textarea for a settings field
	 *
	 * @param array $args settings field args.
	 * @return string
	 */
	function generate_html_html( $args ) {
		$wp_kses = isset( $args['wp_kses'] ) && is_array( $args['wp_kses'] ) && ! empty( $args['wp_kses'] ) ? $args['wp_kses'] : array(
			'strong' => array(),
		);

		echo wp_kses(
			$args['value'],
			$wp_kses
		);
	}

	/**
	 * Displays a separator field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_separator_html( $args ) {
		$type = isset( $args['type'] ) ? $args['type'] : 'separator';

		printf(
			'<div class="%1$s"></div>',
			esc_attr( 'pgs-instawp-separator' )
		);
	}

	/**
	 * Displays a iframe field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_iframe_html( $args ) {

		$defaults  = array(
			'name'              => '',
			'class'             => '',
			'css'               => '',
			'value'             => '',
			'height'            => '400px',
			'custom_attributes' => array(),
			'field-class'       => '',
			'iframe_css'        => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$css = array();

		if ( isset( $args['css'] ) && ! empty( $args['css'] ) ) {
			if ( is_string( $args['css'] ) ) {
				$args['css'] = explode( ';', $args['css'] );
			}
			$css = array_merge( $css, $args['css'] );
		}

		$css[] = 'width:100%';
		if ( ! isset( $args['custom_attributes']['data-is_video'] ) || ( 'yes' !== $args['custom_attributes']['data-is_video'] ) ) {
			$css[] = 'height:' . $args['height'];
		}

		$css = implode( ';', $css );

		$iframe_custom_attributes = array();

		if ( ! empty( $args['iframe-custom_attributes'] ) && is_array( $args['iframe-custom_attributes'] ) ) {
			foreach ( $args['iframe-custom_attributes'] as $attribute => $attribute_value ) {
				$iframe_custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		$iframe_custom_attributes = implode( ' ', $iframe_custom_attributes );

		printf(
			'<div id="%1$s" class="%2$s" style="%3$s" %4$s>',
			esc_attr( $args['id'] ),
			esc_attr( $this->generate_classes( $args ) ),
			esc_attr( $css ),
			$this->get_custom_attribute_html( $args ) // WPCS: XSS ok.
		);

		printf(
			'<iframe id="%1$s" class="%2$s" src="%3$s" %4$s></iframe>',
			esc_attr( $args['id'] ) . '-iframe',
			esc_attr( 'iframe-content' ),
			esc_url( $args['value'] ),
			$iframe_custom_attributes // WPCS: XSS ok.
		);

		printf(
			'</div>'
		);

	}


	/**
	 * Displays a code field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_code_html( $args ) {
		$defaults  = array(
			'class'             => '',
			'css'               => '',
			'size'              => 'regular',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		$value = $this->get_option( $args['id'], $args['default'] );

		printf(
			'<code id="%1$s" class="%2$s" %3$s %4$s>%5$s</code>',
			esc_attr( $args['id'] ),
			esc_attr( $this->generate_classes( $args ) ),
			esc_attr( $args['css'] ),
			$this->get_custom_attribute_html( $args ), // WPCS: XSS ok.
			esc_attr( $value )
		);

		$this->get_field_description( $args );

	}


	/**
	 * Displays a code field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function generate_link_html( $args ) {
		$defaults  = array(
			'class'             => 'button',
			'css'               => '',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array(),
			'target'            => '_self',
			'value'             => '#',
			'link_title'        => esc_html__( 'Click Here', 'pgs-core' ),
			'rel'               => '',
			'link_type'         => 'link',
		);

		$args = wp_parse_args( $args, $defaults );
		if ( $args['target'] === '_blank' ) {
			if ( is_string( $args['rel'] ) ) {
				$args['rel'] = explode( ' ', $args['rel'] );
			}
			$args['rel'][] = 'noreferrer';
			$args['rel'][] = 'noopener';
			$args['rel']   = implode( ' ', array_filter( array_unique( $args['rel'] ) ) );
		}

		if ( $args['target'] !== '_self' ) {
			$args['custom_attributes']['target'] = $args['target'];
		}

		if ( isset( $args['rel'] ) && ! empty( $args['rel'] ) ) {
			$args['custom_attributes']['rel'] = $args['rel'];
		}

		printf(
			'<a id="%1$s" class="%2$s" href="%3$s" style="%4$s" %5$s>%6$s</a>',
			esc_attr( $args['id'] ),
			esc_attr( $this->generate_classes( $args ) ),
			esc_url( $args['value'] ),
			esc_attr( $args['css'] ),
			$this->get_custom_attribute_html( $args ), // WPCS: XSS ok.
			esc_html( $args['link_title'] )
		);

		$this->get_field_description( $args );

	}


	/**
	 * Add submenu page to the Settings main menu.
	 *
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $capability
	 * @param string $menu_slug
	 * @param callable $function = ''
	 */

	// public function admin_menu( $page_title = 'Page Title', $menu_title = 'Menu Title', $capability = 'manage_options', $menu_slug = 'settings_page', $callable = 'plugin_page' ) {
	public function admin_menu() {
		// add_options_page( $page_title, $menu_title, $capability, $menu_slug, array( $this, $callable ) );
		add_options_page(
			$this->settings_page_title,
			$this->settings_menu_title,
			'manage_options',
			$this->menu_slug,
			array( $this, 'settings_page_callback' )
		);
	}

	public function settings_page_callback() {
		?>
		<div class="wrap pgs-instawp-wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<?php
			$this->show_navigation();
			$this->show_forms();
			?>
		</div>
		<?php
	}

	/**
	 * Show navigations as tab
	 *
	 * Shows all the settings section labels as tab
	 */
	function show_navigation() {
		$activetab = '';
		if ( isset( $_COOKIE['pgs_instawp_activetab'] ) && ! empty( $_COOKIE['pgs_instawp_activetab'] ) ) {
			$activetab = wp_unslash( $_COOKIE['pgs_instawp_activetab'] );
		}
		?>
		<div class="nav-tab-wrapper wp-clearfix">
			<?php
			$tab_sr = 1;
			foreach ( $this->settings_sections as $tab ) {
				$tab_id      = 'tab-' . $tab['id'];
				$content_id  = 'content-' . $tab['id'];
				$tab_classes = array(
					'nav-tab',
					'nav-tab-' . $tab['id'],
				);

				if ( ( ! empty( $activetab ) && $activetab === $tab['id'] ) || ( empty( $activetab ) && 1 === $tab_sr ) ) {
					$tab_classes[] = 'nav-tab-active';
				}

				$tab_classes = implode( ' ', array_filter( array_unique( $tab_classes ) ) );

				printf(
					'<a id="%1$s" class="%2$s" href="%3$s" data-tab="%4$s">%5$s</a>',
					esc_attr( $tab_id ),
					esc_attr( $tab_classes ),
					esc_url( "#{$content_id}" ),
					esc_attr( $tab['id'] ),
					esc_html( $tab['title'] )
				);
				$tab_sr++;
			}
			?>
		</div>
		<?php
	}

	/**
	 * Show the section settings forms
	 *
	 * This function displays every sections in a different form
	 */
	function show_forms() {
		?>
		<div class="tab-content-wrapper metabox-holder">
			<?php
			$activetab = '';
			if ( isset( $_COOKIE['pgs_instawp_activetab'] ) && ! empty( $_COOKIE['pgs_instawp_activetab'] ) ) {
				$activetab = wp_unslash( $_COOKIE['pgs_instawp_activetab'] );
			}

			$tab_content_sr = 1;
			foreach ( $this->settings_sections as $form ) {
				$style = 'display: none;';
				if ( ( ! empty( $activetab ) && $activetab === $form['id'] ) || ( empty( $activetab ) && 1 === $tab_content_sr ) ) {
					$style = '';
				}
				$tab_content_id  = 'content-' . $form['id'];
				?>
				<div id="<?php echo esc_attr( $tab_content_id ); ?>" class="tab-content group" style="<?php echo esc_attr( $style ); ?>">
					<form method="post" action="options.php">
						<?php
						do_action( 'pgs_instawp_form_top_' . $form['id'], $form );

						settings_fields( $form['id'] );
						do_settings_sections( $form['id'] );

						do_action( 'pgs_instawp_form_bottom_' . $form['id'], $form );
						?>
						<div style="padding-left: 10px">
							<?php submit_button(null, 'primary', 'submit_'.$form['id']); ?>
						</div>
					</form>
				</div>
				<?php
				$tab_content_sr++;
			}
			?>
		</div>
		<?php
	}

	/**
	 * Get the value of a settings field
	 *
	 * @param string $option  settings field name.
	 * @param string $section the section name this field belongs to.
	 * @param string $default default text if it's not found.
	 * @return string
	 */
	public function get_option( $option, $default = false ) {

		$option_data = get_option( $option, $default );

		if ( isset( $option_data ) ) {
			return $option_data;
		}

		return $default;
	}
}

endif;
