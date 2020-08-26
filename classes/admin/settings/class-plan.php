<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Plan().
 */
class Plan {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Plan()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_plan_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Plan()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Registers the general settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function settings( $cmb ) {
		$cmb->add_field(
			array(
				'name'        => __( 'Plan Filters', 'lsx-health-plan' ),
				'id'          => 'plan_filters_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Toggle the display of the tab filters on the post type archive.', 'lsx-health-plan' ),
			)
		);
	}
}
Plan::get_instance();
