<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class Login {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Login()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		// Lost Password fields
		add_action( 'woocommerce_before_lost_password_form', array( $this, 'lost_password_page_title' ), 10 );

		add_action( 'wp', array( $this, 'allow_reset_password_page' ), 9 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integrations\woocommerce\Login()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function lost_password_page_title() {
		?>
		<h1 class="lost-your-password-title"><?php esc_html_e( 'Lost your password?', 'lsx-health-plan' ); ?></h1>
		<?php
	}

	/**
	 * Removes the content restriction class to allow the password page to show.
	 *
	 * @return void
	 */
	public function allow_reset_password_page() {
		if ( ! is_user_logged_in() && function_exists( 'wc_memberships' ) && is_wc_endpoint_url( 'lost-password' ) ) {

			$members_instance           = wc_memberships();
			$restriction_instance       = $members_instance->get_restrictions_instance();
			$post_restrictions_instance = $restriction_instance->get_posts_restrictions_instance();
			remove_action( 'wp', array( $post_restrictions_instance, 'handle_restriction_modes' ), 10, 1 );
			add_action( 'body_class', array( $this, 'remove_body_classes' ) );
		}
	}

	/**
	 * Remove the gutenberg classes from the lost password page.
	 *
	 * @param array $classes
	 * @return void
	 */
	public function remove_body_classes( $classes = array() ) {
		if ( ! empty( $classes ) ) {
			foreach ( $classes as $class_key => $class_value ) {
				if ( 'gutenberg-compatible-template' === $class_value || 'using-gutenberg' === $class_value ) {
					unset( $classes[ $class_key ] );
				}
			}
		}
		return $classes;
	}
}
