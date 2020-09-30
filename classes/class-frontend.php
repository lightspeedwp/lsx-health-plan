<?php
namespace lsx_health_plan\classes;

/**
 * LSX Health Plan Frontend Class.
 *
 * @package lsx-health-plan
 */
class Frontend {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Frontend()
	 */
	protected static $instance = null;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Endpoints();
	 */
	public $endpoints;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Modals();
	 */
	public $modals;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Gallery();
	 */
	public $gallery;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Plan_Status();
	 */
	public $plan_status;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Plan_Query();
	 */
	public $plan_query;

	/**
	 * @var object \lsx_health_plan\classes\frontend\General();
	 */
	public $general;

	/**
	 * @var object \lsx_health_plan\classes\frontend\Template_Redirects();
	 */
	public $template_redirects;

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			$this->load_classes();
		}	
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Frontend()    A single instance of this class.
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
		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-endpoints.php';
		$this->endpoints = frontend\Endpoints::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-modals.php';
		$this->modals = Modals::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-gallery.php';
		$this->gallery = frontend\Gallery::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-plan-status.php';
		$this->plan_status = frontend\Plan_Status::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-plan-query.php';
		$this->plan_query = frontend\Plan_Query::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-general.php';
		$this->general = frontend\General::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-template-redirects.php';
		$this->template_redirects = frontend\Template_Redirects::get_instance();
	}

	/**
	 * Remove the "Archives:" from the post type recipes.
	 *
	 * @param string $title the term title.
	 * @return string
	 */
	public function get_the_archive_title( $title ) {
		if ( is_tax() ) {
			$queried_object = get_queried_object();
			if ( isset( $queried_object->name ) ) {
				$title = $queried_object->name;
			}
		}
		return $title;
	}
}
