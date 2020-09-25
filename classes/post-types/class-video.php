<?php
namespace lsx_health_plan\classes;

/**
 * Contains the video post type
 *
 * @package lsx-health-plan
 */
class Video {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Video()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'video';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Video()    A single instance of this class.
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
			'name'               => esc_html__( 'Videos', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Video', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All Videos', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Videos', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-format-video',
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'editor',
				'custom-fields',
			),
		);
		register_post_type( 'video', $args );
	}

	/**
	 * Registers the Recipes under the Meals Post type menu.
	 *
	 * @return void
	 */
	public function register_menus() {
		add_submenu_page( 'edit.php?post_type=workout', esc_html__( 'Videos', 'lsx-health-plan' ), esc_html__( 'Videos', 'lsx-health-plan' ), 'edit_posts', 'edit.php?post_type=video' );
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
		$connections['video']['connected_plans']    = 'connected_videos';
		$connections['plan']['connected_videos']    = 'connected_plans';
		$connections['video']['connected_workouts'] = 'connected_videos';
		$connections['plan']['connected_videos']    = 'connected_workouts';
		return $connections;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function details_metaboxes() {
		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_details_metabox',
			'title'        => __( 'Video Details', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );
		$cmb->add_field( array(
			'name'       => __( 'Featured Video', 'lsx-health-plan' ),
			'desc'       => __( 'Enable the checkbox to feature this video, featured videos display in any page that has the video shortcode: [lsx_health_plan_featured_videos_block]', 'lsx-health-plan' ),
			'id'         => $this->slug . '_featured_video',
			'type'       => 'checkbox',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Youtube Source', 'lsx-health-plan' ),
			'desc'       => __( 'Drop in the url for your video from YouTube in this field, i.e: "https://www.youtube.com/watch?v=9xwazD5SyVg"', 'lsx-health-plan' ),
			'id'         => $this->slug . '_youtube_source',
			'type'       => 'oembed',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Giphy Source', 'lsx-health-plan' ),
			'desc'       => __( 'Drop in the iFrame embed code from Giphy in this field, i.e: &lt;iframe src="https://giphy.com/embed/3o7527Rn1HxXWqgxuo" width="480" height="270" frameborder="0" class="giphy-embed" allowfullscreen&gt;&lt;/iframe&gt;', 'lsx-health-plan' ),
			'id'         => $this->slug . '_giphy_source',
			'type'       => 'textarea_code',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
	}

	// /**
	//  * Registers the workout connections on the workout post type.
	//  *
	//  * @return void
	//  */
	// public function videos_connections() {
	// 	$cmb = new_cmb2_box( array(
	// 		'id'           => $this->slug . '_videos_connections_metabox',
	// 		'title'        => __( 'Videos', 'lsx-health-plan' ),
	// 		'desc'         => __( 'Start typing to search for your workouts', 'lsx-health-plan' ),
	// 		'object_types' => array( 'workout' ), // Post type
	// 		'context'      => 'normal',
	// 		'priority'     => 'high',
	// 		'show_names'   => false,
	// 	) );
	// 	$cmb->add_field( array(
	// 		'name'       => __( 'Videos', 'lsx-health-plan' ),
	// 		'id'         => 'connected_videos',
	// 		'type'       => 'post_search_ajax',
	// 		// Optional :
	// 		'limit'      => 15, // Limit selection to X items only (default 1)
	// 		'sortable'   => true, // Allow selected items to be sortable (default false)
	// 		'query_args' => array(
	// 			'post_type'      => array( 'video' ),
	// 			'post_status'    => array( 'publish' ),
	// 			'posts_per_page' => -1,
	// 		),
	// 	) );
	// }

}
