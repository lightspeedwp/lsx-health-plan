<?php
namespace lsx_health_plan\classes;
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
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );
		add_action( 'cmb2_admin_init', array( $this, 'workout_connections' ), 15 );
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
			'menu_icon'          => 'dashicons-universal-access',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'workout',
			),
			'capability_type'    => 'post',
			'has_archive'        => 'workouts',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
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
	 * Define the metabox and field configurations.
	 */
	function details_metaboxes() {
		$workout_sections = apply_filters( 'lsx_health_plan_workout_sections_amount', 6 );
		if ( false !== $workout_sections && null !== $workout_sections ) {
			$i = 1;
			while ( $i <= $workout_sections ) {

				$cmb_group = new_cmb2_box( array(
					'id'           => $this->slug . '_section_' . $i . '_metabox',
					'title'        => esc_html__( 'Section ', 'lsx-health-plan' ) . $i,
					'object_types' => array( $this->slug ),
				) );

				$cmb_group->add_field( array(
					'name'       => __( 'Title', 'lsx-health-plan' ),
					'id'         => $this->slug . '_section_' . $i . '_title',
					'type'       => 'text',
					'show_on_cb' => 'cmb2_hide_if_no_cats',		
				) );				

				$cmb_group->add_field( array(
					'name'       => __( 'Description', 'lsx-health-plan' ),
					'id'         => $this->slug . '_section_' . $i . '_description',
					'type'       => 'wysiwyg',
					'show_on_cb' => 'cmb2_hide_if_no_cats',
					'options' => array(
						'textarea_rows' => 5,
					),		
				) );	

				/**
				 * Repeatable Field Groups
				 */
				// $group_field_id is the field id string, so in this case: $prefix . 'demo'
				$group_field_id = $cmb_group->add_field( array(
					'id'          => $this->slug . '_section_' . $i,
					'type'        => 'group',
					'options'     => array(
						'group_title'    => esc_html__( 'Exercise {#}', 'lsx-health-plan' ), // {#} gets replaced by row number
						'add_button'     => esc_html__( 'Add New', 'lsx-health-plan' ),
						'remove_button'  => esc_html__( 'Delete', 'lsx-health-plan' ),
						'sortable'       => true,
					),
				) );
				/**
				 * Group fields works the same, except ids only need
				 * to be unique to the group. Prefix is not needed.
				 *
				 * The parent field's id needs to be passed as the first argument.
				 */
				$cmb_group->add_group_field( $group_field_id, array(
					'name'       => esc_html__( 'Workout Name', 'lsx-health-plan' ),
					'id'         => 'name',
					'type'       => 'text',
					// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
				) );
				$cmb_group->add_group_field( $group_field_id, array(
					'name'       => esc_html__( 'Reps / Time / Distance', 'lsx-health-plan' ),
					'id'         => 'reps',
					'type'       => 'text',
					// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
				) );

				if ( class_exists( 'LSX_Videos' ) ) {
					$cmb_group->add_group_field( $group_field_id, array(
						'name'      	=> __( 'Video', 'lsx-health-plan' ),
						'id'        	=> 'connected_video',
						'type'      	=> 'post_search_ajax',
						// Optional :
						'limit'      	=> 1, 		// Limit selection to X items only (default 1)
						'sortable' 	 	=> true, 	// Allow selected items to be sortable (default false)
						'query_args'	=> array(
							'post_type'			=> array( 'video' ),
							'post_status'		=> array( 'publish' ),
							'posts_per_page'	=> -1
						)
					) );					
				}

				$i++;
			};
		}		
	}	

	/**
	 * Registers the workout connections on the plan post type.
	 *
	 * @return void
	 */
	public function recipes_connections() {
		$cmb = new_cmb2_box( array(
			'id'            => $this->slug . '_connections_metabox',
			'title'         => __( 'Recipes', 'lsx-health-plan' ),
			'desc'			=> __( 'Start typing to search for your recipes', 'lsx-health-plan' ),
			'object_types'  => array( 'meal' ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => false,
		) );
		$cmb->add_field( array(
			'name'      	=> __( 'Recipes', 'lsx-health-plan' ),
			'id'        	=> 'connected_recipes',
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

	/**
	 * Registers the workout connections on the plan post type.
	 *
	 * @return void
	 */
	public function workout_connections() {
		$cmb = new_cmb2_box( array(
			'id'            => $this->slug . '_connections_metabox',
			'title'         => __( 'Workouts', 'lsx-health-plan' ),
			'desc'			=> __( 'Start typing to search for your workouts', 'lsx-health-plan' ),
			'object_types'  => array( 'plan' ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => false,
		) );
		$cmb->add_field( array(
			'name'      	=> __( 'Workouts', 'lsx-health-plan' ),
			'id'        	=> 'connected_workouts',
			'type'      	=> 'post_search_ajax',
			// Optional :
			'limit'      	=> 15, 		// Limit selection to X items only (default 1)
			'sortable' 	 	=> true, 	// Allow selected items to be sortable (default false)
			'query_args'	=> array(
				'post_type'			=> array( 'workout' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		) );	
	}
}
