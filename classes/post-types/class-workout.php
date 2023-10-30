<?php
namespace lsx_health_plan\classes;

use function lsx_health_plan\functions\get_option;

/**
 * Contains the workout post type
 *
 * @package lsx-health-plan
 */
class Workout {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Workout()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'workout';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );
		add_action( 'cmb2_admin_init', array( $this, 'workout_connections' ), 15 );
		add_action( 'lsx_hp_settings_page', array( $this, 'register_settings' ), 8, 1 );
		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );

		// Template Redirects.
		add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Workout()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Register the post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Workout', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Workouts', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Workouts', 'lsx-health-plan' ),
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-universal-access',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => \lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' ),
			),
			'capability_type'    => 'post',
			'has_archive'        => \lsx_health_plan\functions\get_option( 'endpoint_workout_archive', false ),
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
				'excerpt',
			),
		);
		register_post_type( 'workout', $args );
	}

	/**
	 * Adds the post type to the different arrays.
	 *
	 * @param array $post_types
	 * @return array
	 */
	public function enable_post_type( $post_types = array() ) {
		$post_types[] = $this->slug;
		return $post_types;
	}

	/**
	 * Enables the Bi Directional relationships
	 *
	 * @param array $connections
	 * @return void
	 */
	public function enable_connections( $connections = array() ) {
		$connections['workout']['connected_plans'] = 'connected_workouts';
		$connections['plan']['connected_workouts'] = 'connected_plans';

		$connections['workout']['connected_videos'] = 'connected_workouts';
		$connections['video']['connected_workouts'] = 'connected_videos';

		$connections['workout']['connected_posts'] = 'connected_workouts';
		$connections['post']['connected_workouts'] = 'connected_posts';
		return $connections;
	}

	/**
	 * Remove the "Archives:" from the post type workouts.
	 *
	 * @param string $title the term title.
	 * @return string
	 */
	public function get_the_archive_title( $title ) {
		if ( is_post_type_archive( 'workout' ) ) {
			$title = __( 'Workouts', 'lsx-health-plan' );
		}
		return $title;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function details_metaboxes() {
		$workout_sections = apply_filters( 'lsx_health_plan_workout_sections_amount', 6 );
		if ( false !== $workout_sections && null !== $workout_sections ) {
			$i = 1;
			while ( $i <= $workout_sections ) {

				$cmb_group = new_cmb2_box( array(
					'id'           => $this->slug . '_section_' . $i . '_metabox',
					'title'        => esc_html__( 'Exercise Group ', 'lsx-health-plan' ) . $i,
					'object_types' => array( $this->slug ),
				) );

				$cmb_group->add_field( array(
					'name'       => __( 'Title', 'lsx-health-plan' ),
					'id'         => $this->slug . '_section_' . $i . '_title',
					'type'       => 'text',
					'show_on_cb' => 'cmb2_hide_if_no_cats',
				) );

				$cmb_group->add_field(
					array(
						'name'       => __( 'Description', 'lsx-health-plan' ),
						'id'         => $this->slug . '_section_' . $i . '_description',
						'type'       => 'wysiwyg',
						'show_on_cb' => 'cmb2_hide_if_no_cats',
						'options'    => array(
							'textarea_rows' => 5,
						),
					)
				);

				/**
				 * Repeatable Field Groups
				 */
				// $group_field_id is the field id string, so in this case: $prefix . 'demo'
				$group_field_id = $cmb_group->add_field(
					array(
						'id'      => $this->slug . '_section_' . $i,
						'type'    => 'group',
						'options' => array(
							'group_title'   => esc_html__( 'Exercise {#}', 'lsx-health-plan' ), // {#} gets replaced by row number
							'add_button'    => esc_html__( 'Add New', 'lsx-health-plan' ),
							'remove_button' => esc_html__( 'Delete', 'lsx-health-plan' ),
							'sortable'      => true,
						),
					)
				);

				if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
					$cmb_group->add_group_field(
						$group_field_id,
						array(
							'name'       => __( 'Exercise related to this workout', 'lsx-health-plan' ),
							'id'         => 'connected_exercises',
							'type'       => 'post_search_ajax',
							// Optional :
							'limit'      => 1, // Limit selection to X items only (default 1)
							'sortable'   => true,  // Allow selected items to be sortable (default false)
							'query_args' => array(
								'post_type'      => array( 'exercise' ),
								'post_status'    => array( 'publish' ),
								'posts_per_page' => -1,
							),
						)
					);
				} else {
					$cmb_group->add_group_field(
						$group_field_id,
						array(
							'name'       => __( 'Video related to this workout', 'lsx-health-plan' ),
							'id'         => 'connected_videos',
							'type'       => 'post_search_ajax',
							// Optional :
							'limit'      => 1, // Limit selection to X items only (default 1)
							'sortable'   => true,  // Allow selected items to be sortable (default false)
							'query_args' => array(
								'post_type'      => array( 'video' ),
								'post_status'    => array( 'publish' ),
								'posts_per_page' => -1,
							),
						)
					);
					$cmb_group->add_group_field(
						$group_field_id,
						array(
							'name' => esc_html__( 'Workout Name', 'lsx-health-plan' ),
							'id'   => 'name',
							'type' => 'text',
							// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
						)
					);

					$cmb_group->add_group_field(
						$group_field_id,
						array(
							'name'    => __( 'Description', 'lsx-health-plan' ),
							'id'      => 'description',
							'type'    => 'wysiwyg',
							'options' => array(
								'textarea_rows' => 2,
							),
						)
					);
				}

				$cmb_group->add_group_field(
					$group_field_id,
					array(
						'name' => esc_html__( 'Reps / Time / Distance', 'lsx-health-plan' ),
						'id'   => 'reps',
						'type' => 'text',
						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
					)
				);
				$i++;
			};
		}
	}

	/**
	 * Registers the workout connections on the plan post type.
	 *
	 * @return void
	 */
	public function workout_connections() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_workout_connections_metabox',
				'title'        => __( 'Workouts', 'lsx-health-plan' ),
				'desc'         => __( 'Start typing to search for your workouts', 'lsx-health-plan' ),
				'object_types' => array( 'plan' ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Workouts', 'lsx-health-plan' ),
				'id'         => 'connected_workouts',
				'desc'       => __( 'Connect the workout that applies to this day plan using the field provided.', 'lsx-health-plan' ),
				'type'       => 'post_search_ajax',
				'limit'      => 15,
				'sortable'   => true,
				'query_args' => array(
					'post_type'      => array( 'workout' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Pre Workout Snack', 'lsx-health-plan' ),
				'id'         => 'pre_workout_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Post Workout Snack', 'lsx-health-plan' ),
				'id'         => 'post_workout_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
	}

	/**
	 * Registers the lsx_search_settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function register_settings( $cmb ) {
		if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
			$cmb->add_field(
				array(
					'id'          => 'workout_settings_title',
					'type'        => 'title',
					'name'        => __( 'Workout Settings', 'lsx-health-plan' ),
					'description' => __( 'Choose the layout, content and link settings for your exercises.', 'lsx-health-plan' ),
				)
			);

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

			do_action( 'lsx_hp_workout_settings_page', $cmb );
		}
	}
}
