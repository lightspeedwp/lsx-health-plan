<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class Account {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Account()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 20, 1 );

		// Redirect to the Edit Account Template.
		add_filter( 'template_include', array( $this, 'account_endpoint_redirect' ), 99 );

		add_action( 'woocommerce_edit_account_form', array( $this, 'print_user_frontend_fields' ), 10 );

		add_filter( 'lsx_hp_profile_fields', array( $this, 'add_post_data_to_account_fields' ), 10, 1 );
		add_action( 'show_user_profile', array( $this, 'print_user_admin_fields' ), 30 );

		add_action( 'personal_options_update', array( $this, 'save_account_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_account_fields' ) );

		add_action( 'woocommerce_save_account_details', array( $this, 'save_account_fields' ) );
		add_filter( 'woocommerce_save_account_details_errors', array( $this, 'validate_user_frontend_fields' ), 10 );

		// Profile Fields.
		add_filter( 'woocommerce_form_field_text', array( $this, 'lsx_profile_photo_field_filter' ), 10, 4 );
		add_action( 'woocommerce_after_edit_account_form', array( $this, 'action_woocommerce_after_edit_account_form' ), 10, 0 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integration\woocommerce\Account()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Runs on init
	 *
	 * @return void
	 */
	public function init() {
		remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
	}

	/**
	 * Redirects to the my account template.
	 *
	 * @param string $template
	 * @return string
	 */
	public function account_endpoint_redirect( $template ) {
		if ( function_exists( 'is_account_page' ) && is_account_page() ) {
			if ( empty( locate_template( array( 'page-template-my-plan.php' ) ) ) && file_exists( LSX_HEALTH_PLAN_PATH . 'templates/page-template-my-plan.php' ) ) {
				$template = LSX_HEALTH_PLAN_PATH . 'templates/page-template-my-plan.php';
			}
		}
		return $template;
	}

	/**
	 * Add post values to account fields if set.
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public function add_post_data_to_account_fields( $fields ) {
		if ( empty( $_POST ) && wp_verify_nonce( sanitize_key( $_POST ) ) ) {
			return $fields;
		}

		foreach ( $fields as $key => $field_args ) {
			if ( isset( $_POST[ $key ] ) && empty( $_POST[ $key ] ) && wp_verify_nonce( sanitize_key( $_POST[ $key ] ) ) ) {
				$fields[ $key ]['value'] = '';
				continue;
			}

			if ( isset( $_POST[ $key ] ) ) {
				$fields[ $key ]['value'] = sanitize_key( $_POST[ $key ] );
			}
		}

		return $fields;
	}

	/**
	 * Add fields to registration form and account area.
	 */
	public function print_user_frontend_fields() {
		$fields            = $this->get_account_fields();
		$is_user_logged_in = is_user_logged_in();

		$all_disabled = \lsx_health_plan\functions\get_option( 'disable_all_stats', false );
		if ( 'on' !== $all_disabled ) {
			echo wp_kses_post( '<h2 class="title-lined my-stats-title">' . __( 'My Stats', 'lsx-health-plan' ) . '</h2><p><strong>' . __( 'My physical info', 'lsx-health-plan' ) . '</strong></p>' );
			echo wp_kses_post( '<div class="my-stats-wrap"><div class="my-stats">' );
			foreach ( $fields as $key => $field_args ) {
				$value = null;
				if ( ! $this->is_field_visible( $field_args ) ) {
					continue;
				}
				if ( $is_user_logged_in ) {
					$user_id = $this->get_edit_user_id();
					$value   = $this->get_userdata( $user_id, $key );
				}
				$value = ( isset( $field_args['value'] ) && '' !== $field_args['value'] ) ? $field_args['value'] : $value;
				woocommerce_form_field( $key, $field_args, $value );
			}
			$is_bmi_disabled = \lsx_health_plan\functions\get_option( 'disable_bmi_checkbox', false );
			if ( 'on' !== $is_bmi_disabled ) {
				echo wp_kses_post( '<p class="form-row calculate-bmi"><label>BMI</label><button class="btn border-btn">' . __( 'Calculate', 'lsx-health-plan' ) . '<i class="fa fa-calculator" aria-hidden="true"></i></button></p>' );
				echo wp_kses_post( '</div>' );
				echo wp_kses_post( '<div class="description"><p class="bmi-title"><strong>' . __( 'Your BMI score', 'lsx-health-plan' ) . '</strong></p>' );
				echo wp_kses_post( '<p>' . __( "BMI is a measurement of a person's leanness or corpulence based on their height and weight, and is intended to quantify tissue mass. It is widely used as a general indicator of whether a person has a healthy body weight for their height.", 'lsx-health-plan' ) . '</p></div></div>' );
			}
			
		}
	}

	/**
	 * Get user data.
	 *
	 * @param $user_id
	 * @param $key
	 *
	 * @return mixed|string
	 */
	public function get_userdata( $user_id, $key ) {
		if ( ! $this->is_userdata( $key ) ) {
			return get_user_meta( $user_id, $key, true );
		}

		$userdata = get_userdata( $user_id );

		if ( ! $userdata || ! isset( $userdata->{$key} ) ) {
			return '';
		}

		return $userdata->{$key};
	}

	/**
	 * Get currently editing user ID (frontend account/edit profile/edit other user).
	 *
	 * @return int
	 */
	public function get_edit_user_id() {
		return ( isset( $_GET['user_id'] ) && wp_verify_nonce( sanitize_key( $_GET['user_id'] ) ) ) ? (int) $_GET['user_id'] : get_current_user_id();
	}


	/**
	 * Save registration fields.
	 *
	 * @param int $customer_id
	 */
	public function save_account_fields( $customer_id ) {
		$nonce_value = wc_get_var( $_REQUEST['save-account-details-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
		if ( ! wp_verify_nonce( $nonce_value, 'save_account_details' ) ) {
			return;
		}

		$fields         = $this->get_account_fields();
		$sanitized_data = array();
		foreach ( $fields as $key => $field_args ) {
			if ( ! $this->is_field_visible( $field_args ) ) {
				continue;
			}

			$sanitize = isset( $field_args['sanitize'] ) ? $field_args['sanitize'] : 'wc_clean';
			$value    = ( isset( $_POST[ $key ] ) ) ? call_user_func( $sanitize, $_POST[ $key ] ) : '';
			if ( $this->is_userdata( $key ) ) {

				$sanitized_data[ $key ] = $value;
				continue;
			}

			if ( 'profile_photo' === $key ) {
				// This handles the image uploads.
				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';

				$id = media_handle_upload( $key, 0, '' );
				if ( ! is_wp_error( $id ) ) {
					update_term_meta( $customer_id, $key . '_id', $id );
					update_term_meta( $customer_id, $key, $id );
				}
			} else {
				delete_user_meta( $customer_id, $key );
				update_user_meta( $customer_id, $key, $value );
			}
		}

		if ( ! empty( $sanitized_data ) ) {
			$sanitized_data['ID'] = $customer_id;
			wp_update_user( $sanitized_data );
		}
	}


	/**
	 * Is this field core user data.
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function is_userdata( $key ) {
		$userdata = array(
			'user_pass',
			'user_login',
			'user_nicename',
			'user_url',
			'user_email',
			'display_name',
			'nickname',
			'first_name',
			'last_name',
			'description',
			'rich_editing',
			'user_registered',
			'role',
			'jabber',
			'aim',
			'yim',
			'show_admin_bar_front',
		);

		return in_array( $key, $userdata, true );
	}

	/**
	 * Is field visible.
	 *
	 * @param $field_args
	 *
	 * @return bool
	 */
	public function is_field_visible( $field_args ) {
		$visible = true;
		$action  = filter_input( INPUT_POST, 'action' );

		if ( is_admin() && ! empty( $field_args['hide_in_admin'] ) ) {
			$visible = false;
		} elseif ( ( is_account_page() || 'save_account_details' === $action ) && is_user_logged_in() && ! empty( $field_args['hide_in_account'] ) ) {
			$visible = false;
		} elseif ( ( is_account_page() || 'save_account_details' === $action ) && ! is_user_logged_in() && ! empty( $field_args['hide_in_registration'] ) ) {
			$visible = false;
		} elseif ( is_checkout() && ! empty( $field_args['hide_in_checkout'] ) ) {
			$visible = false;
		}

		// Disable the fitness fields if needed.
		$weight_key  = __( 'Weight:' );
		$waist_key   = __( 'Waist:' );
		$fitness_key = __( 'BMI Score:' );
		if ( $weight_key === $field_args['label'] || $waist_key === $field_args['label'] || $fitness_key === $field_args['label'] ) {

			// Check if all stats are disabled.
			$all_disabled = \lsx_health_plan\functions\get_option( 'disable_all_stats', false );

			$option_key = '';
			switch ( $field_args['label'] ) {
				case $weight_key:
					$option_key = 'disable_weight_checkbox';
					break;

				case $weight_key:
					$option_key = 'disable_height_checkbox';
					break;
				
				case $waist_key:
					$option_key = 'disable_waist_checkbox';
					break;

				case $fitness_key:
					$option_key = 'disable_bmi_checkbox';
					break;
			}
			$is_disabled = \lsx_health_plan\functions\get_option( $option_key, false );
			if ( 'on' === $all_disabled || 'on' === $is_disabled ) {
				$visible = false;
			}
		}
		return $visible;
	}

	/**
	 * Add fields to admin area.
	 */
	public function print_user_admin_fields() {
		$fields = $this->get_account_fields();
		?>
		<h2><?php esc_html_e( 'Additional Information', 'lsx-health-plan' ); ?></h2>
		<table class="form-table" id="iconic-additional-information">
			<tbody>
			<?php foreach ( $fields as $key => $field_args ) { ?>
				<?php
				if ( ! $this->is_field_visible( $field_args ) ) {
					continue;
				}

				$user_id = $this->get_edit_user_id();
				$value   = get_user_meta( $user_id, $key, true );
				?>
				<tr>
					<th>
						<label for="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $field_args['label'] ); ?></label>
					</th>
					<td>
						<?php $field_args['label'] = false; ?>
						<?php woocommerce_form_field( $key, $field_args, $value ); ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Validate fields on frontend.
	 *
	 * @param WP_Error $errors
	 *
	 * @return WP_Error
	 */
	public function validate_user_frontend_fields( $errors ) {
		$fields = $this->get_account_fields();

		foreach ( $fields as $key => $field_args ) {
			if ( empty( $field_args['required'] ) ) {
				continue;
			}

			/*if ( ! isset( $_POST['register'] ) && wp_verify_nonce( sanitize_key( $_POST['register'] ) ) && ! empty( $field_args['hide_in_account'] ) ) {
				continue;
			}*/

			if ( isset( $_POST['register'] ) && wp_verify_nonce( sanitize_key( $_POST['register'] ) ) && ! empty( $field_args['hide_in_registration'] ) ) {
				continue;
			}

			if ( empty( $_POST[ $key ] ) ) {
				/* translators: %s: field */
				$message = sprintf( __( '%s is a required field.', 'lsx-health-plan' ), '<strong>' . $field_args['label'] . '</strong>' );
				$errors->add( $key, $message );
			}
		}

		return $errors;
	}

	/**
	 * Changes the text into a file upload.
	 * @param $field
	 * @param $key
	 * @param $args
	 * @param $value
	 *
	 * @return mixed
	 */
	public function lsx_profile_photo_field_filter( $field, $key, $args, $value ) {
		if ( 'profile_photo' === $args['id'] ) {

			if ( $args['required'] ) {
				$args['class'][] = 'validate-required';
				$required        = ' <abbr class="required" title="' . esc_attr__( 'required', 'lsx-health-plan' ) . '">*</abbr>';
			} else {
				$required = '';
			}

			if ( is_string( $args['label_class'] ) ) {
				$args['label_class'] = array( $args['label_class'] );
			}

			if ( is_null( $value ) ) {
				$value = $args['default'];
			}

			// Custom attribute handling.
			$custom_attributes         = array();
			$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

			if ( $args['maxlength'] ) {
				$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
			}

			if ( ! empty( $args['autocomplete'] ) ) {
				$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
			}

			if ( true === $args['autofocus'] ) {
				$args['custom_attributes']['autofocus'] = 'autofocus';
			}

			if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
				foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
					$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
				}
			}

			if ( ! empty( $args['validate'] ) ) {
				foreach ( $args['validate'] as $validate ) {
					$args['class'][] = 'validate-' . $validate;
				}
			}

			$field_html      = '';
			$field           = '';
			$label_id        = $args['id'];
			$sort            = $args['priority'] ? $args['priority'] : '';
			$field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p>';
			$args['class'][] = 'validate-required';
			$required        = ' <abbr class="required" title="' . esc_attr__( 'required', 'lsx-health-plan' ) . '">*</abbr>';

			$field .= '<input accept="image/*" type="file" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="" ' . implode( ' ', $custom_attributes ) . ' />';

			if ( '' !== $value && $value !== $args['default'] ) {
				$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '_id" id="' . esc_attr( $args['id'] ) . '_id" placeholder="' . esc_attr( $args['placeholder'] ) . '_id"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
			}

			$field .= '<input type="hidden" name="MAX_FILE_SIZE" value="500000" />';

			if ( $args['label'] && 'checkbox' !== $args['type'] ) {
				$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
			}

			$field_html .= $field;

			if ( $args['description'] ) {
				$field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
			}

			$container_class = esc_attr( implode( ' ', $args['class'] ) );
			$container_id    = esc_attr( $args['id'] ) . '_field';
			$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
		}
		return $field;
	}


	public function action_woocommerce_after_edit_account_form() {
		echo do_shortcode( '[avatar_upload /]' );
	}

	/**
	 * Get additional account fields.
	 *
	 * @return array
	 */
	public function get_account_fields() {
		$account_fields = apply_filters( 'lsx_hp_profile_fields', array(
			'age'  => array(
				'type'                 => 'text',
				'label'                => __( 'Age:', 'lsx-health-plan' ),
				'placeholder'          => __( '#', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
			'weight'  => array(
				'type'                 => 'text',
				'label'                => __( 'Weight:', 'lsx-health-plan' ),
				'placeholder'          => __( 'kg', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
			'gender'   => array(
				'type'                 => 'select',
				'label'                => __( 'Gender:', 'lsx-health-plan' ),
				'placeholder'          => __( 'm/f', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
				'options'     => array(
					'male'   => __( 'Male', 'lsx-health-plan' ),
					'female' => __( 'Female', 'lsx-health-plan' ),
				),
			),
			'waist'   => array(
				'type'                 => 'text',
				'label'                => __( 'Waist:', 'lsx-health-plan' ),
				'placeholder'          => __( 'cm', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
			'height'     => array(
				'type'                 => 'text',
				'label'                => __( 'Height:', 'lsx-health-plan' ),
				'placeholder'          => __( 'cm', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
		) );

		$is_weight_disabled = \lsx_health_plan\functions\get_option( 'disable_weight_checkbox', false );
		if ( 'on' === $is_weight_disabled ) {
			$account_fields['weight']['required'] = false;
		}
		$is_height_disabled = \lsx_health_plan\functions\get_option( 'disable_height_checkbox', false );
		if ( 'on' === $is_height_disabled ) {
			$account_fields['height']['required'] = false;
		}
		$is_waist_disabled = \lsx_health_plan\functions\get_option( 'disable_waist_checkbox', false );
		if ( 'on' === $is_waist_disabled ) {
			$account_fields['waist']['required'] = false;
		}
		return $account_fields;
	}
}
