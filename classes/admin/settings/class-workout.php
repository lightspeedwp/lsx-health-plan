<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Workout().
 */
class Workout {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Workout()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_workout_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Workout()    A single instance of this class.
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
				'id'          => 'workout_tab_layout',
				'type'        => 'select',
				'name'        => __( 'Workout Tab Layout', 'lsx-health-plan' ),
				'description' => __( 'Choose the layout for the workouts.', 'lsx-health-plan' ),
				'options'     => array(
					'table' => __( 'Table', 'lsx-health-plan' ),
					'list'  => __( 'List', 'lsx-health-plan' ),
					'grid'  => __( 'Grid', 'lsx-health-plan' ),
				),
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'workout_tab_link',
				'type'        => 'select',
				'name'        => __( 'Workout Tab Link', 'lsx-health-plan' ),
				'description' => __( 'Choose to show the excerpt, full content or nothing.', 'lsx-health-plan' ),
				'options'     => array(
					''       => __( 'None', 'lsx-health-plan' ),
					'single' => __( 'Single', 'lsx-health-plan' ),
					'modal'  => __( 'Modal', 'lsx-health-plan' ),
				),
				'default' => 'modal',
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'workout_tab_modal_content',
				'type'        => 'select',
				'name'        => __( 'Modal Content', 'lsx-health-plan' ),
				'description' => __( 'Choose to show the excerpt, full content or nothing. For the modal content only', 'lsx-health-plan' ),
				'options'     => array(
					''        => __( 'None', 'lsx-health-plan' ),
					'excerpt' => __( 'Excerpt', 'lsx-health-plan' ),
					'full'    => __( 'Full Content', 'lsx-health-plan' ),
				),
				'default' => '',
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'workout_tab_columns',
				'type'        => 'select',
				'name'        => __( 'Grid Columns', 'lsx-health-plan' ),
				'description' => __( 'If you are displaying a grid, set the amount of columns you want to use.', 'lsx-health-plan' ),
				'options'     => array(
					'12' => __( '1', 'lsx-health-plan' ),
					'6'  => __( '2', 'lsx-health-plan' ),
					'4'  => __( '3', 'lsx-health-plan' ),
					'3'  => __( '4', 'lsx-health-plan' ),
					'2'  => __( '6', 'lsx-health-plan' ),
				),
				'default' => '4',
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'workout_tab_content',
				'type'        => 'select',
				'name'        => __( 'Grid Content', 'lsx-health-plan' ),
				'description' => __( 'Choose to show the excerpt, full content or nothing. For the grid layout only', 'lsx-health-plan' ),
				'options'     => array(
					''        => __( 'None', 'lsx-health-plan' ),
					'excerpt' => __( 'Excerpt', 'lsx-health-plan' ),
					'full'    => __( 'Full Content', 'lsx-health-plan' ),
				),
				'default' => '',
			)
		);
	}
}
Workout::get_instance();
