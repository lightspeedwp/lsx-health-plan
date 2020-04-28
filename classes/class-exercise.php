<?php
namespace lsx_health_plan\classes;

/**
 * Contains the exercise post type
 *
 * @package lsx-health-plan
 */
class Exercise {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Exercise()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'exercise';

	/**
	 * Contructor
	 */
	public function __construct() {
		if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
			add_action( 'init', array( $this, 'register_post_type' ) );
			add_action( 'init', array( $this, 'workout_taxonomy_setup' ) );
			add_action( 'init', array( $this, 'exercise_type_taxonomy_setup' ) );
			add_action( 'init', array( $this, 'equipment_taxonomy_setup' ) );
			add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
			add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
			add_action( 'cmb2_admin_init', array( $this, 'video_metabox' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Exercise()    A single instance of this class.
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
			'name'               => esc_html__( 'Exercise', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Exercises', 'lsx-health-plan' ),
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
			'menu_name'          => esc_html__( 'Exercises', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-universal-access',
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
			),
		);
		register_post_type( 'exercise', $args );
	}

	/**
	 * Register the Workout taxonomy.
	 */
	public function workout_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Workout', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Workout', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Workouts', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'workout',
			),
		);

		register_taxonomy( 'workout', array( 'exercise' ), $args );
	}

	/**
	 * Register the Exercise taxonomy.
	 *
	 * @return void
	 */
	public function exercise_type_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Exercise Type', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Exercise Type', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Exercise Types', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'exercise-type',
			),
		);

		register_taxonomy( 'exercise-type', array( 'exercise' ), $args );
	}

	/**
	 * Register the Exercise taxonomy.
	 *
	 * @return void
	 */
	public function equipment_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Equipment', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Equipment', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Equipment', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'equipment',
			),
		);

		register_taxonomy( 'equipment', array( 'exercise' ), $args );
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
		$connections['exercise']['connected_workouts'] = 'connected_exercises';
		$connections['workout']['connected_exercise']  = 'connected_workouts';

		$connections['tip']['connected_exercises'] = 'connected_tips';
		$connections['exercise']['connected_tips'] = 'connected_exercises';
		return $connections;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function video_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_details_metabox',
				'title'        => __( 'Video Details', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Featured Video', 'lsx-health-plan' ),
				'desc'       => __( 'Enable the checkbox to feature this video, featured videos display in any page that has the video shortcode: [lsx_health_plan_featured_videos_block]', 'lsx-health-plan' ),
				'id'         => $this->slug . '_featured_video',
				'type'       => 'checkbox',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Youtube Source', 'lsx-health-plan' ),
				'desc'       => __( 'Drop in the url for your video from YouTube in this field, i.e: "https://www.youtube.com/watch?v=9xwazD5SyVg"', 'lsx-health-plan' ),
				'id'         => $this->slug . '_youtube_source',
				'type'       => 'oembed',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Giphy Source', 'lsx-health-plan' ),
				'desc'       => __( 'Drop in the iFrame embed code from Giphy in this field, i.e: &lt;iframe src="https://giphy.com/embed/3o7527Rn1HxXWqgxuo" width="480" height="270" frameborder="0" class="giphy-embed" allowfullscreen&gt;&lt;/iframe&gt;', 'lsx-health-plan' ),
				'id'         => $this->slug . '_giphy_source',
				'type'       => 'textarea_code',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
	}
}
