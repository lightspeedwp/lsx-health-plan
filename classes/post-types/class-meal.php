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
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'taxonomy_setup' ) );
		
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'featured_metabox' ), 5 );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );

		// Template Redirects.
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );

		add_action( 'pre_get_posts', array( $this, 'set_parent_only' ), 10, 1 );
		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );

		//Breadcrumbs
		add_filter( 'wpseo_breadcrumb_links', array( $this, 'meal_breadcrumb_filter' ), 30, 1 );
		add_filter( 'woocommerce_get_breadcrumb', array( $this, 'meal_breadcrumb_filter' ), 30, 1 );
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
			'name'               => esc_html__( 'Meals', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Meal', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All Meals', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'menu_name'          => esc_html__( 'Meals', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-carrot',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => \lsx_health_plan\functions\get_option( 'meal_single_slug', 'meal' ),
			),
			'capability_type'    => 'page',
			'has_archive'        => \lsx_health_plan\functions\get_option( 'endpoint_meal_archive', 'meals' ),
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'custom-fields',
			),
		);
		register_post_type( 'meal', $args );
	}

	/**
	 * Register the Meal Type taxonomy.
	 */
	public function taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Meal Type', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Meal Types', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Meal Types', 'lsx-health-plan' ),
		);
		$args   = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_menu'      => 'edit.php?post_type=meal',
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'meal-type',
			),
		);
		register_taxonomy( 'meal-type', array( $this->slug ), $args );
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
		$connections['meal']['connected_plans'] = 'connected_meals';
		$connections['plan']['connected_meals'] = 'connected_plans';
		return $connections;
	}

	/**
	 * Remove the "Archives:" from the post type meal.
	 *
	 * @param string $title the term title.
	 * @return string
	 */
	public function get_the_archive_title( $title ) {
		if ( is_post_type_archive( 'meal' ) ) {
			$title = __( 'Meals', 'lsx-health-plan' );
		}
		return $title;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function featured_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_featured_metabox_meal',
				'title'        => __( 'Featured Meal', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'side',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Featured Meal', 'lsx-health-plan' ),
				'desc'       => __( 'Enable a featured meal' ),
				'id'         => $this->slug . '_featured_meal',
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
			'id'           => $this->slug . '_shopping_list_metabox',
			'title'        => __( 'Shopping List', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );
		$cmb->add_field( array(
			'name'       => __( 'Shopping List', 'lsx-health-plan' ),
			'desc'       => __( 'Connect the shopping list page that applies to this meal by entering the name of the page in the field provided.' ),
			'id'         => $this->slug . '_shopping_list',
			'type'       => 'post_search_ajax',
			// Optional :
			'limit'      => 1,  // Limit selection to X items only (default 1)
			'sortable'   => true, // Allow selected items to be sortable (default false)
			'query_args' => array(
				'post_type'      => array( 'page' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => -1,
			),
		) );
		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_details_metabox',
			'title'        => __( 'Meal Details', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );

		$cmb->add_field( array(
			'name' => __( 'Meal Short Description', 'lsx-health-plan' ),
			'id'   => $this->slug . '_short_description',
			'type' => 'textarea_small',
			'desc' => __( 'Add a small description for this meal (optional)', 'lsx-health-plan' ),
		) );

		$cmb->add_field( array(
			'name'       => __( 'Pre Breakfast Snack', 'lsx-health-plan' ),
			'id'         => $this->slug . '_pre_breakfast_snack',
			'type'       => 'wysiwyg',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
			'options'    => array(
				'textarea_rows' => 5,
			),
		) );
		$cmb->add_field( array(
			'name'       => __( 'Breakfast', 'lsx-health-plan' ),
			'id'         => $this->slug . '_breakfast',
			'type'       => 'wysiwyg',
			'show_on_cb' => 'cmb2_hide_if_no_cats',
			'options'    => array(
				'textarea_rows' => 5,
			),
		) );

		$cmb->add_field(
			array(
				'name'       => __( 'Post Breakfast Snack', 'lsx-health-plan' ),
				'id'         => $this->slug . '_breakfast_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);

		if ( post_type_exists( 'recipe' ) ) {
			$cmb->add_field(
				array(
					'name'       => __( 'Breakfast Recipes', 'lsx-health-plan' ),
					'desc'       => __( 'Connect additional recipes options for breakfast.', 'lsx-health-plan' ),
					'id'         => 'breakfast_recipes',
					'type'       => 'post_search_ajax',
					// Optional :
					'limit'      => 15,  // Limit selection to X items only (default 1)
					'sortable'   => true, // Allow selected items to be sortable (default false)
					'query_args' => array(
						'post_type'      => array( 'recipe' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}

		$cmb->add_field(
			array(
				'name'       => __( 'Pre Lunch Snack', 'lsx-health-plan' ),
				'id'         => $this->slug . '_pre_lunch_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Lunch', 'lsx-health-plan' ),
				'id'         => $this->slug . '_lunch',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Post Lunch Snack', 'lsx-health-plan' ),
				'id'         => $this->slug . '_lunch_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);

		if ( post_type_exists( 'recipe' ) ) {
			$cmb->add_field(
				array(
					'name'       => __( 'Lunch Recipes', 'lsx-health-plan' ),
					'desc'       => __( 'Connect additional recipes options for lunch.', 'lsx-health-plan' ),
					'id'         => 'lunch_recipes',
					'type'       => 'post_search_ajax',
					// Optional :
					'limit'      => 15,  // Limit selection to X items only (default 1)
					'sortable'   => true, // Allow selected items to be sortable (default false)
					'query_args' => array(
						'post_type'      => array( 'recipe' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}

		$cmb->add_field(
			array(
				'name'       => __( 'Pre Dinner Snack', 'lsx-health-plan' ),
				'id'         => $this->slug . '_pre_dinner_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Dinner', 'lsx-health-plan' ),
				'id'         => $this->slug . '_dinner',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Post Dinner Snack', 'lsx-health-plan' ),
				'id'         => $this->slug . '_dinner_snack',
				'type'       => 'wysiwyg',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'options'    => array(
					'textarea_rows' => 5,
				),
			)
		);

		if ( post_type_exists( 'recipe' ) ) {
			$cmb->add_field(
				array(
					'name'       => __( 'Dinner Recipes', 'lsx-health-plan' ),
					'desc'       => __( 'Connect additional recipes options for dinner.', 'lsx-health-plan' ),
					'id'         => 'dinner_recipes',
					'type'       => 'post_search_ajax',
					// Optional :
					'limit'      => 15,  // Limit selection to X items only (default 1)
					'sortable'   => true, // Allow selected items to be sortable (default false)
					'query_args' => array(
						'post_type'      => array( 'recipe' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}
	}
	/**
	 * Set the post type archive to show the parent plans only.
	 *
	 * @param object $wp_query
	 * @return array
	 */
	public function set_parent_only( $wp_query ) {
		if ( ! is_admin() && $wp_query->is_main_query() && ( $wp_query->is_post_type_archive( 'meal' ) || $wp_query->is_tax( array( 'meal-type' ) ) ) ) {
			$wp_query->set( 'post_parent', '0' );
		}
	}


	/**
	 * Holds the array for the single meal breadcrumbs.
	 *
	 * @var array $crumbs
	 * @return array
	 */
	public function meal_breadcrumb_filter( $crumbs ) {
		$meal  = \lsx_health_plan\functions\get_option( 'endpoint_meal', 'meal' );
		$meals = \lsx_health_plan\functions\get_option( 'endpoint_meal_archive', 'meal' );

		if ( is_singular( 'meal' ) ) {	
			$meal_name     = get_the_title();
			$url           = get_post_type_archive_link( $meal );
			$term_obj_list = get_the_terms( get_the_ID(), 'meal-type' );
			$meal_type     = $term_obj_list[0]->name;
			if ( empty( $meal_type ) ) {
				$meal_type = __( 'Meal', 'lsx-health-plan' );
			}
			$meal_type_url = get_term_link( $term_obj_list[0]->term_id );

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $meals,
					1 => $url,
				);
				$new_crumbs[2] = array(
					0 => $meal_type,
					1 => $meal_type_url,
				);
				$new_crumbs[3] = array(
					0 => $meal_name,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $meals,
					'url'  => $url,
				);
				$new_crumbs[2] = array(
					'text' => $meal_type,
					'url'  => $meal_type_url,
				);
				$new_crumbs[3] = array(
					'text' => $meal_name,
				);
			}
			$crumbs = $new_crumbs;

		}
		if ( is_post_type_archive( 'meal' ) ) {

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $meals,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $meals,
				);
			}
			$crumbs = $new_crumbs;
		}
		return $crumbs;
	}
}
