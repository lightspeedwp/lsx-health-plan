<?php
namespace lsx_health_plan\classes;

/**
 * Contains the tip post type
 *
 * @package lsx-health-plan
 */
class Tip {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Tip()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'tip';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'featured_metabox' ) );
		add_action( 'cmb2_admin_init', array( $this, 'tips_connections' ), 15 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Tip()    A single instance of this class.
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
			'name'               => esc_html__( 'Tip', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Tips', 'lsx-health-plan' ),
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
			'menu_name'          => esc_html__( 'Tips', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-admin-post',
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
			),
		);
		register_post_type( 'tip', $args );
	}

	/**
	 * Enables the Bi Directional relationships
	 *
	 * @param array $connections
	 * @return void
	 */
	public function enable_connections( $connections = array() ) {
		$connections['tip']['connected_plans'] = 'connected_tips';
		$connections['plan']['connected_tips'] = 'connected_plans';
		return $connections;
	}

	/**
	 * Registers the workout connections on the plan post type.
	 *
	 * @return void
	 */
	public function tips_connections() {
		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_tips_connections_metabox',
			'title'        => __( 'Tips', 'lsx-health-plan' ),
			'object_types' => array( 'plan' ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => false,
		) );
		$cmb->add_field( array(
			'name'       => __( 'Tips', 'lsx-health-plan' ),
			'id'         => 'connected_tips',
			'desc'       => __( 'Connect the tips that apply to this day plan using the field provided.', 'lsx-health-plan' ),
			'type'       => 'post_search_ajax',
			// Optional :
			'limit'      => 15,  // Limit selection to X items only (default 1)
			'sortable'   => true,  // Allow selected items to be sortable (default false)
			'query_args' => array(
				'post_type'      => array( 'tip' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => -1,
			),
		) );
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function featured_metabox() {
		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_featured_metabox_tip',
			'title'        => __( 'Featured', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'side',
			'priority'     => 'high',
			'show_names'   => true,
		) );
		$cmb->add_field( array(
			'name'       => __( 'Featured', 'lsx-health-plan' ),
			'desc'       => __( 'Enable the checkbox to feature this tip, featured tips display in any page that has the tip shortcode: [lsx_health_plan_featured_tips_block]' ),
			'id'         => $this->slug . '_featured_tip',
			'type'       => 'checkbox',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
		) );
	}

}
