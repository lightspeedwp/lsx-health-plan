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
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_action( 'init', array( $this, 'workout_type_taxonomy_setup' ) );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'featured_metabox' ), 5 );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );
		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );

		// Template Redirects.
		add_action( 'pre_get_posts', array( $this, 'set_parent_only' ), 10, 1 );
		add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );

		//Breadcrumbs
		add_filter( 'wpseo_breadcrumb_links', array( $this, 'workout_breadcrumb_filter' ), 30, 1 );
		add_filter( 'woocommerce_get_breadcrumb', array( $this, 'workout_breadcrumb_filter' ), 30, 1 );
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
			'name'               => esc_html__( 'Workouts', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Workout', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All Workouts', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => esc_html__( 'Parent:', 'lsx-health-plan' ),
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
			'capability_type'    => 'page',
			'has_archive'        => \lsx_health_plan\functions\get_option( 'endpoint_workout_archive', 'workouts' ),
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
				'excerpt',
				'page-attributes',
				'custom-fields',
			),
		);
		register_post_type( 'workout', $args );
	}

	/**
	 * Register the Type taxonomy.
	 */
	public function workout_type_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Workout Type', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Workout Type', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Workout Types', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'workout-type',
			),
		);

		register_taxonomy( 'workout-type', array( 'workout' ), $args );
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
	public function featured_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_featured_metabox_workout',
				'title'        => __( 'Featured Workout', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'side',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Featured Workout', 'lsx-health-plan' ),
				'desc'       => __( 'Enable a featured workout' ),
				'id'         => $this->slug . '_featured_workout',
				'type'       => 'checkbox',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function details_metaboxes() {

		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_details_metabox',
			'title'        => __( 'Workout Details', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );

		$cmb->add_field( array(
			'name' => __( 'Workout Short Description', 'lsx-health-plan' ),
			'id'   => $this->slug . '_short_description',
			'type' => 'textarea_small',
			'desc' => __( 'Add a small description for this workout (optional)', 'lsx-health-plan' ),
		) );

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
							'closed'        => true, // true to have the groups closed by default
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
						'name' => esc_html__( 'Exercise title (Optional)', 'lsx-health-plan' ),
						'id'   => 'alt_title',
						'type' => 'text',
					)
				);
				$cmb_group->add_group_field(
					$group_field_id,
					array(
						'name' => esc_html__( 'Exercise Description (Optional)', 'lsx-health-plan' ),
						'id'   => 'alt_description',
						'type' => 'textarea_small',
					)
				);
				$cmb_group->add_group_field(
					$group_field_id,
					array(
						'name' => esc_html__( 'Reps / Time / Distance', 'lsx-health-plan' ),
						'id'   => 'reps',
						'type' => 'text',
						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
					)
				);
				$cmb_group->add_group_field(
					$group_field_id,
					array(
						'name'         => __( 'Exercise Image (Optional)', 'lsx-health-plan' ),
						'id'           => 'exercise_alt_thumbnail',
						'type'         => 'file',
						'text'         => array(
							'add_upload_file_text' => __( 'Add File', 'lsx-health-plan' ),
						),
						'desc'         => __( 'Upload an image 300px x 300px in size.', 'lsx-health-plan' ),
						'query_args'   => array(
							'type' => array(
								'image/gif',
								'image/jpeg',
								'image/png',
							),
						),
						'preview_size' => 'thumbnail',
						'classes'      => 'lsx-field-col lsx-field-add-field  lsx-field-col-25',
					)
				);

				$i++;
			};
		}
	}
	/**
	 * Set the post type archive to show the parent plans only.
	 *
	 * @param object $wp_query
	 * @return array
	 */
	public function set_parent_only( $wp_query ) {
		if ( ! is_admin() && $wp_query->is_main_query() && ( $wp_query->is_post_type_archive( 'workout' ) || $wp_query->is_tax( array( 'workout-type' ) ) ) ) {
			$wp_query->set( 'post_parent', '0' );
		}
	}

	/**
	 * Holds the array for the single workout breadcrumbs.
	 *
	 * @var array $crumbs
	 * @return array
	 */
	public function workout_breadcrumb_filter( $crumbs ) {
		$workout  = \lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' );
		$workouts = \lsx_health_plan\functions\get_option( 'endpoint_workout_archive', 'workout' );

		if ( is_singular( 'workout' ) ) {	
			$workout_name  = get_the_title();
			$url           = get_post_type_archive_link( $workout );
			$term_obj_list = get_the_terms( get_the_ID(), 'workout-type' );
			$workout_type  = $term_obj_list[0]->name;
			if ( empty( $workout_type ) ) {
				$workout_type = __( 'Workout', 'lsx-health-plan' );
			}
			$workout_type_url = get_term_link( $term_obj_list[0]->term_id );

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $workouts,
					1 => $url,
				);
				$new_crumbs[2] = array(
					0 => $workout_type,
					1 => $workout_type_url,
				);
				$new_crumbs[3] = array(
					0 => $workout_name,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $workouts,
					'url'  => $url,
				);
				$new_crumbs[2] = array(
					'text' => $workout_type,
					'url'  => $workout_type_url,
				);
				$new_crumbs[3] = array(
					'text' => $workout_name,
				);
			}
			$crumbs = $new_crumbs;

		}
		if ( is_post_type_archive( 'workout' ) ) {

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $workouts,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $workouts,
				);
			}
			$crumbs = $new_crumbs;
		}
		return $crumbs;
	}
}
