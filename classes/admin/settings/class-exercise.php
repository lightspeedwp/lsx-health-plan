<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Exercise().
 */
class Exercise {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Exercise()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_exercise_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Exercise()    A single instance of this class.
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
				'name'        => __( 'Exercises', 'lsx-health-plan' ),
				'id'          => 'exercise_enabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Enabling the exercise post type will automatically replace the Video post type.', 'lsx-health-plan' ),
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'exercise_archive_description',
				'type'        => 'wysiwyg',
				'name'        => __( 'Archive Description', 'lsx-health-plan' ),
				'description' => __( 'This will show up on the post type archive.', 'lsx-health-plan' ),
				'options'     => array(
					'textarea_rows' => get_option('default_post_edit_rows', 6),
				),
			)
		);
		$cmb->add_field(
			array(
				'before_row' => '<h4><b><u>URL Slug Options</u></b></h4><p style="font-style: italic;">If you need to translate the custom slug for this custom post type, do so below.</p>',
				'name'       =>  __( 'Single Exercise Slug', 'lsx-health-plan' ),
				'id'         => 'endpoint_exercise_single',
				'type'       => 'input',
				'value'      => '',
				'default'    => 'exercise',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Archive Exercise Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_exercise_archive',
				'type'    => 'input',
				'value'   => '',
				'default' => 'exercises',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Exercise Type Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_exercise_type',
				'type'    => 'input',
				'value'   => '',
				'default' => 'exercise-type',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Equipment Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_exercise_equipment',
				'type'    => 'input',
				'value'   => '',
				'default' => 'equipment',
			)
		);
		$cmb->add_field(
			array(
				'name'      =>  __( 'Muscle Group Slug', 'lsx-health-plan' ),
				'id'        => 'endpoint_exercise_musclegroup',
				'type'      => 'input',
				'value'     => '',
				'default'   => 'muscle-group',
				'after_row' => __( '<p style="font-style: italic;">If you have changed any URL slugs, please remember re-save your permalinks in Settings > Permalinks.</p>', 'lsx-health-plan' ),
			)
		);
	}
}
Exercise::get_instance();
