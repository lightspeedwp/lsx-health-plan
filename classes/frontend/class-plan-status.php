<?php
namespace lsx_health_plan\classes\frontend;

/**
 * Holds the functionality to check and control your status with the current plan.
 *
 * @package lsx-health-plan
 */
class Plan_Status {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\frontend\Plan_Status()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\frontend\Plan_Status()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
