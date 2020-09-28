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
	 * Constructor
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
				'name'        => __( 'Disable Workouts', 'lsx-health-plan' ),
				'id'          => 'workout_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable workout post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);
		if ( post_type_exists( 'workout' ) ) {
			$cmb->add_field(
				array(
					'name'    => __( 'Your Workout Intro', 'lsx-health-plan' ),
					'id'      => 'workout_intro',
					'type'    => 'wysiwyg',
					'value'   => '',
					'default' => __( "Let's do this! Smash your daily workout and reach your fitness goals.", 'lsx-health-plan' ),
					'options'     => array(
						'textarea_rows' => get_option('default_post_edit_rows', 6),
					),
				)
			);
		}
		$cmb->add_field(
			array(
				'before_row'  => '<h4><b><u>Layout Options</u></b></h4>',
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
					'none'   => __( 'None', 'lsx-health-plan' ),
					'single' => __( 'Single', 'lsx-health-plan' ),
					'modal'  => __( 'Modal', 'lsx-health-plan' ),
				),
				'default' => '',
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
				'default'     => '',
			)
		);

		$cmb->add_field(
			array(
				'before_row' => '<h4><b><u>URL Slug Options</u></b></h4><p style="font-style: italic;">If you need to translate the custom slug for this custom post type, do so below.</p>',
				'name'       =>  __( 'Single Workout Slug', 'lsx-health-plan' ),
				'id'         => 'endpoint_workout',
				'type'       => 'input',
				'value'      => '',
				'default'    => 'workout',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Workouts Archive Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_workout_archive',
				'type'    => 'input',
				'value'   => '',
				'default' => 'workouts',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Warm Up Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_warm_up',
				'type'    => 'input',
				'value'   => '',
				'default' => 'warm-up',
			)
		);
		
		
		$cmb->add_field(
			array(
				'before_row'  => '<h4><b><u>Default Options</u></b></h4>',
				'name'        => __( 'Warm Up', 'lsx-health-plan' ),
				'description' => __( 'Set a default warm up routine.', 'lsx-health-plan' ),
				'limit'       => 1,
				'id'          => 'plan_warmup',
				'type'        => 'post_search_ajax',
				'query_args'  => array(
					'post_type'      => 'post',
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'        => __( 'Workout', 'lsx-health-plan' ),
				'description' => __( 'Set a default workout routine.', 'lsx-health-plan' ),
				'limit'       => 1,
				'id'          => 'connected_workouts',
				'type'        => 'post_search_ajax',
				'query_args'  => array(
					'post_type'      => 'workout',
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
		if ( function_exists( 'download_monitor' ) ) {
			$page_url    = 'https://wordpress.org/plugins/download-monitor/';
			$plugin_name = 'Download Monitor';
			$description = sprintf(
				/* translators: %s: The subscription info */
				__( 'If you are using <a target="_blank" href="%1$s">%2$s</a> you can set a default download file for your meal here.', 'lsx-search' ),
				$page_url,
				$plugin_name
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Default Warm Up PDF', 'lsx-health-plan' ),
					'description' => $description,
					'id'          => 'download_page',
					'type'        => 'post_search_ajax',
					'limit'       => 1,
					'query_args'  => array(
						'post_type'      => array( 'dlm_download' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Default Workout PDF', 'lsx-health-plan' ),
					'description' => $description,
					'id'          => 'download_workout',
					'type'        => 'post_search_ajax',
					'limit'       => 1,
					'query_args'  => array(
						'post_type'      => array( 'dlm_download' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
					'after_row'   => __( '<p style="font-style: italic;">If you have changed any URL slugs, please remember re-save your permalinks in Settings > Permalinks.</p>', 'lsx-health-plan' ),
				)
			);
		}
	}
}
Workout::get_instance();
