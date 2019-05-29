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
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'videos_connections' ), 15 );
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
			self::$instance = new self;
		}
		return self::$instance;
	}
	/**
	 * Register the post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Video', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Videos', 'lsx-health-plan' ),
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
			'menu_name'          => esc_html__( 'Videos', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
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
				'thumbnail',
				'excerpt',
			),
		);
		register_post_type( 'video', $args );
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
		$connections['video']['connected_plans'] = 'connected_videos';
		$connections['plan']['connected_videos'] = 'connected_plans';
		return $connections;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	function details_metaboxes() {
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
			'id'         => $this->slug . '_featured_video',
			'type'       => 'checkbox',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Video Source', 'lsx-health-plan' ),
			'desc'       => __( 'Allowed formats: MP4 (.mp4), WebM (.webm) and Ogg/Ogv (.ogg)', 'lsx-health-plan' ),
			'id'         => $this->slug . '_video_source',
			'type'       => 'file',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				'type' => array(
					'video/mp4',
					'video/webm',
					'video/ogg',
				),
			),
		) );
		$cmb->add_field( array(
			'name'       => __( 'Youtube Source', 'lsx-health-plan' ),
			'desc'       => __( 'It will replace the original video source on front-end', 'lsx-health-plan' ),
			'id'         => $this->slug . '_youtube_source',
			'type'       => 'text',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
		$cmb->add_field( array(
			'name'       => __( 'Giphy Source', 'lsx-health-plan' ),
			'desc'       => __( 'The HTML will be stripped leaving only the URL', 'lsx-health-plan' ),
			'id'         => $this->slug . '_giphy_source',
			'type'       => 'text',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
	}

}
