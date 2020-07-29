<?php
namespace lsx_health_plan\classes\integration\woocommerce;

/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class Account {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integration\woocommerce\Account()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 20, 1 );

		// Redirect to the Edit Account Template.
		add_filter( 'template_include', array( $this, 'account_endpoint_redirect' ), 99 );
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
}
