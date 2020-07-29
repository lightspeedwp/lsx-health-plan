<?php
namespace lsx_health_plan\classes;

/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class Woocommerce {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Woocommerce()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		$this->load_classes();
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Woocommerce()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Loads the variable classes and the static classes.
	 */
	private function load_classes() {
		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-account.php';
		$this->account = integrations\woocommerce\Account::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-my-plans.php';
		$this->my_plans = integrations\woocommerce\My_Plans::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-login.php';
		$this->login = integrations\woocommerce\Login::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-checkout.php';
		$this->checkout = integrations\woocommerce\Checkout::get_instance();
	}
}
