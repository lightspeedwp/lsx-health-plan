<?php
namespace lsx_health_plan\classes;
/**
 * Contains the meal_plan post type
 *
 * @package lsx-health-plan
 */
class Plan {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Plan()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'taxonomy_setup' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Meal_Plan()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	/**
	 * Register the post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Plan', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Plans', 'lsx-health-plan' ),
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
			'menu_name'          => esc_html__( 'Plans', 'lsx-health-plan' ),
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-welcome-write-blog',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'plan',
			),
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
		register_post_type( 'plan', $args );
	}	
	
	/**
	 * Register the Week taxonomy.
	 */
	public function taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Week', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Week', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Weeks', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'week',
			),
		);

		register_taxonomy( 'week', array( 'plan' ), $args );
	}	
}
