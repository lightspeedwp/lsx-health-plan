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
			// Post Type and Taxonomies.
			add_action( 'init', array( $this, 'register_post_type' ) );
			add_action( 'init', array( $this, 'exercise_type_taxonomy_setup' ) );
			add_action( 'init', array( $this, 'equipment_taxonomy_setup' ) );
			add_action( 'init', array( $this, 'muscle_group_taxonomy_setup' ) );
			add_action( 'admin_menu', array( $this, 'register_menus' ) );

			// Settings.
			add_action( 'lsx_hp_settings_page', array( $this, 'register_settings' ), 10, 1 );

			// Custom Fields.
			add_action( 'cmb2_admin_init', array( $this, 'exercise_details' ), 8 );
			add_action( 'cmb2_admin_init', array( $this, 'gallery_metabox' ), 9 );
			add_action( 'cmb2_admin_init', array( $this, 'tips_metabox' ) );
			add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );

			// Template Redirects.
			add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );
			add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
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
			'show_in_menu'       => false,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-universal-access',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => \lsx_health_plan\functions\get_option( 'endpoint_exercise_single', 'exercise' ),
			),
			'capability_type'    => 'post',
			'has_archive'        => \lsx_health_plan\functions\get_option( 'endpoint_exercise_archive', 'exercises' ),
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
				'excerpt',
			),
		);
		register_post_type( 'exercise', $args );
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
				'slug' => \lsx_health_plan\functions\get_option( 'endpoint_exercise_type', 'exercise-type' ),
			),
			'show_in_rest'      => true,
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
				'slug' => \lsx_health_plan\functions\get_option( 'endpoint_exercise_equipment', 'equipment' ),
			),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'equipment', array( 'exercise' ), $args );
	}

	/**
	 * Register the Muscle Group taxonomy.
	 *
	 * @return void
	 */
	public function muscle_group_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Muscle Groups', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Muscle Group', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Muscle Groups', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => \lsx_health_plan\functions\get_option( 'endpoint_exercise_muscle_group', 'muscle-group' ),
			),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'muscle-group', array( 'exercise' ), $args );
	}

	/**
	 * Registers the Recipes under the Meals Post type menu.
	 *
	 * @return void
	 */
	public function register_menus() {
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Exercises', 'lsx-health-plan' ), esc_html__( 'Exercises', 'lsx-health-plan' ), 'edit_posts', 'edit.php?post_type=exercise' );
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Exercise Types', 'lsx-health-plan' ), esc_html__( 'Exercise Types', 'lsx-health-plan' ), 'edit_posts', 'edit-tags.php?taxonomy=exercise-type&post_type=exercise' );
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Equipment', 'lsx-health-plan' ), esc_html__( 'Equipment', 'lsx-health-plan' ), 'edit_posts', 'edit-tags.php?taxonomy=equipment&post_type=exercise' );
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Muscle Groups', 'lsx-health-plan' ), esc_html__( 'Muscle Groups', 'lsx-health-plan' ), 'edit_posts', 'edit-tags.php?taxonomy=muscle-group&post_type=exercise' );
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function tips_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_tips_details_metabox',
				'title'        => __( 'Exercise Tips', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'normal',
				'priority'     => 'low',
				'show_names'   => true,
			)
		);

		// Repeatable group.
		$tip_group = $cmb->add_field(
			array(
				'id'      => $this->slug . '_tips',
				'type'    => 'group',
				'options' => array(
					'group_title'   => __( 'Tip', 'your-text-domain' ) . ' {#}', // {#} gets replaced by row number
					'add_button'    => __( 'Add another tip', 'your-text-domain' ),
					'remove_button' => __( 'Remove tip', 'your-text-domain' ),
					'sortable'      => true,
				),
				'classes' => 'lsx-admin-row',
			)
		);

		// Title.
		$cmb->add_group_field(
			$tip_group,
			array(
				'name' => __( 'Thumbnail', 'your-text-domain' ),
				'id'   => $this->slug . '_tip_thumbnail',
				'type' => 'file',
				'text'        => array(
					'add_upload_file_text' => __( 'Add File', 'lsx-health-plan' ),
				),
				'desc'        => __( 'Upload an image 300px x 300px in size.', 'lsx-health-plan' ),
				'query_args' => array(
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

		$cmb->add_group_field(
			$tip_group,
			array(
				'name'    => __( 'Description', 'your-text-domain' ),
				'id'      => $this->slug . '_tip_content',
				'type'    => 'textarea',
				'classes' => 'lsx-field-col lsx-field-connect-field lsx-field-col-75',
			)
		);
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
		$connections['workout']['connected_exercises'] = 'connected_workouts';
		return $connections;
	}

	/**
	 * Registers the lsx_search_settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function register_settings( $cmb ) {
		$cmb->add_field(
			array(
				'id'          => 'exercise_archive_settings_title',
				'type'        => 'title',
				'name'        => __( 'Exercises Archive', 'lsx-health-plan' ),
				'description' => __( 'All of the settings relating to the exercises post type archive.', 'lsx-health-plan' ),
			)
		);
		$cmb->add_field(
			array(
				'id'          => 'exercise_archive_description',
				'type'        => 'wysiwyg',
				'name'        => __( 'Archive Description', 'lsx-health-plan' ),
				'description' => __( 'This will show up on the post type archive.', 'lsx-health-plan' ),
			)
		);
		do_action( 'lsx_hp_exercise_settings_page', $cmb );
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function gallery_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_gallery_details_metabox',
				'title'        => __( 'Exercise Gallery', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ),
				'context'      => 'normal',
				'priority'     => 'low',
				'show_names'   => true,
			)
		);

		$cmb->add_field(
			array(
				'name'    => __( 'Layout', 'lsx-health-plan' ),
				'id'      => $this->slug . '_gallery_layout',
				'type'    => 'radio',
				'options' => array(
					'slider' => __( 'Slider', 'your-text-domain' ) . ' {#}', // {#} gets replaced by row number
					'grid'   => __( 'Grid', 'your-text-domain' ),
				),
			)
		);

		$cmb->add_field(
			array(
				'name'    => __( 'Grid Columns', 'lsx-health-plan' ),
				'id'      => $this->slug . '_gallery_columns',
				'type'    => 'text',
				'default' => '3',
			)
		);

		// Repeatable group.
		$gallery_group = $cmb->add_field(
			array(
				'id'      => $this->slug . '_gallery',
				'type'    => 'group',
				'options' => array(
					'group_title'   => __( 'Gallery', 'your-text-domain' ) . ' {#}', // {#} gets replaced by row number
					'add_button'    => __( 'Add Item', 'your-text-domain' ),
					'remove_button' => __( 'Remove Item', 'your-text-domain' ),
					'sortable'      => true,
				),
				'classes' => 'lsx-admin-row',
			)
		);

		// Title.
		$cmb->add_group_field(
			$gallery_group,
			array(
				'name'       => __( 'Image', 'your-text-domain' ),
				'id'         => $this->slug . '_gallery_image',
				'type'       => 'file',
				'text'       => array(
					'add_upload_file_text' => __( 'Add File', 'lsx-health-plan' ),
				),
				'desc'       => __( 'Upload an image a minimum of 800px x 600px in size.', 'lsx-health-plan' ),
				'query_args' => array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),
				'preview_size' => 'lsx-thumbnail-wide',
				'classes'      => 'lsx-field-col lsx-field-add-field  lsx-field-col-33',
			)
		);

		// Title.
		$cmb->add_group_field(
			$gallery_group,
			array(
				'name'         => __( 'oEmbed', 'your-text-domain' ),
				'id'           => $this->slug . '_gallery_embed',
				'type'         => 'text',
				'desc'         => __( 'Drop in the embed url for your video from YouTube, Vimeo or DailyMotion, e.g: "https://www.youtube.com/watch?v=9xwazD5SyVg". A full list of supports formats can be found at <a href="https://make.wordpress.org/support/user-manual/content/media/adding-media-to-your-pages-and-posts/embedding-media-from-other-sites/">WordPress</a>', 'lsx-health-plan' ),
				'classes'      => 'lsx-field-col lsx-field-connect-field  lsx-field-col-33',
			)
		);

		$cmb->add_group_field(
			$gallery_group,
			array(
				'name'         => __( 'External Media', 'your-text-domain' ),
				'id'           => $this->slug . '_gallery_external',
				'type'         => 'textarea_code',
				'desc'         => __( 'Drop in the iFrame embed code from Giphy in this field, i.e: &lt;iframe src="https://giphy.com/embed/3o7527Rn1HxXWqgxuo" width="480" height="270" frameborder="0" class="giphy-embed" allowfullscreen&gt;&lt;/iframe&gt;', 'lsx-health-plan' ),
				'classes'      => 'lsx-field-col lsx-field-connect-field  lsx-field-col-33',
			)
		);
	}

	/**
	 * Registers the general settings for the exercise.
	 *
	 * @return void
	 */
	public function exercise_details() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_general_details_metabox',
				'title'        => __( 'Details', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);

		$cmb->add_field(
			array(
				'name'    => __( 'Side', 'lsx-health-plan' ),
				'id'      => $this->slug . '_side',
				'type'    => 'select',
				'options' => array(
					''      => __( 'Select', 'your-text-domain' ),
					'left'  => __( 'Left', 'your-text-domain' ),
					'right' => __( 'Right', 'your-text-domain' ),
				),
				'desc'    => __( 'Select which side this exercise uses. ', 'lsx-health-plan' ),
			)
		);
	}
}
