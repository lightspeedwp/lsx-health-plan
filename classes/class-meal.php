<?php
namespace lsx_health_plan\classes;
/**
 * Contains the day post type
 *
 * @package lsx-health-plan
 */
class Meal {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Meal()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'meal';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'meal_connections' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Day()    A single instance of this class.
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
			'name'               => esc_html__( 'Meal', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Meals', 'lsx-health-plan' ),
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
			'menu_name'          => esc_html__( 'Meals', 'lsx-health-plan' ),
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-carrot',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'day',
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
		register_post_type( 'meal', $args );
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
	 * Registers the workout connections on the plan post type.
	 *
	 * @return void
	 */
	public function meal_connections() {
		$cmb = new_cmb2_box( array(
			'id'            => $this->slug . '_connections_metabox',
			'title'         => __( 'Recipes', 'lsx-health-plan' ),
			'desc'			=> __( 'Start typing to search for your recipes', 'lsx-health-plan' ),
			'object_types'  => array( 'recipe' ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => false,
		) );
		$cmb->add_field( array(
			'name'      	=> __( 'Meals', 'lsx-health-plan' ),
			'id'        	=> 'connected_meals',
			'type'      	=> 'post_search_ajax',
			// Optional :
			'limit'      	=> 15, 		// Limit selection to X items only (default 1)
			'sortable' 	 	=> true, 	// Allow selected items to be sortable (default false)
			'query_args'	=> array(
				'post_type'			=> array( $this->slug ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		) );		
	}		
}
