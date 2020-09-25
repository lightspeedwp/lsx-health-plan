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
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'handle_day_action' ), 100 );
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

	/**
	 * Registers the rewrites.
	 */
	public function handle_day_action() {
		if ( isset( $_POST['lsx-health-plan-actions'] ) && wp_verify_nonce( $_POST['lsx-health-plan-actions'], 'complete' ) ) {
			update_user_meta( get_current_user_id(), 'day_' . sanitize_key( $_POST['lsx-health-plan-id'] ) . '_complete', true );
			$plan_id     = sanitize_key( $_POST['lsx-health-plan-id'] );
			$plan_parent = wp_get_post_parent_id( $plan_id );
			if ( 0 !== $plan_parent ) {
				$plan_id = $plan_parent;
			}
			wp_safe_redirect( get_permalink( $plan_id ) );
		}

		if ( isset( $_POST['lsx-health-plan-actions'] ) && wp_verify_nonce( $_POST['lsx-health-plan-actions'], 'unlock' ) ) {
			delete_user_meta( get_current_user_id(), 'day_' . sanitize_key( $_POST['lsx-health-plan-id'] ) . '_complete' );
		}
	}
}
