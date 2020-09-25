<?php
namespace lsx_health_plan\classes;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class Woocommerce {

	/**
	 * Holds class instance
	 *
	 * @var      object \lsx_health_plan\classes\Woocommerce()
	 */
	protected static $instance = null;

	/**
	 * Holds class Account functionality
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Admin()
	 */
	public $admin = null;

	/**
	 * Holds class Account functionality
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Account()
	 */
	public $account = null;

	/**
	 * Holds class Plans functionality
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Plans()
	 */
	public $plans = null;

	/**
	 * Holds class Login functionality
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Login()
	 */
	public $login = null;

	/**
	 * Holds class Checkout functionality
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Checkout()
	 */
	public $checkout = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_classes();
		$this->load_includes();
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
		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-admin.php';
		$this->admin = integrations\woocommerce\Admin::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-account.php';
		$this->account = integrations\woocommerce\Account::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-plans.php';
		$this->plans = integrations\woocommerce\Plans::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-login.php';
		$this->login = integrations\woocommerce\Login::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/woocommerce/class-checkout.php';
		$this->checkout = integrations\woocommerce\Checkout::get_instance();
	}
	/**
	 * Loads the includes
	 */
	private function load_includes() {
		require_once LSX_HEALTH_PLAN_PATH . 'includes/functions/woocommerce.php';
		require_once LSX_HEALTH_PLAN_PATH . 'includes/template-tags/woocommerce.php';
	}
}
