<?php
namespace lsx_health_plan\classes;

/**
 * Contains the recipe post type
 *
 * @package lsx-health-plan
 */
class Recipe {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Recipe()
	 */
	protected static $instance = null;

	/**
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'recipe';

	/**
	 * Holds post_type labels
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $labels = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'taxonomy_setup' ) );
		add_action( 'admin_menu', array( $this, 'register_menus' ) );

		// Frontend Actions and Filters.
		add_action( 'wp_head', array( $this, 'remove_archive_original_header' ), 99 );
		add_action( 'lsx_content_wrap_before', array( $this, 'hp_lsx_archive_header' ) );

		add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_connections', array( $this, 'enable_connections' ), 10, 1 );
		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );
		add_filter( 'lsx_display_global_header_description', array( $this, 'disable_global_header_description' ), 100 );

		//Breadcrumbs
		add_filter( 'wpseo_breadcrumb_links', array( $this, 'recipes_breadcrumb_filter' ), 30, 1 );
		add_filter( 'woocommerce_get_breadcrumb', array( $this, 'recipes_breadcrumb_filter' ), 30, 1 );

		// Backend Actions and Filters.
		add_action( 'cmb2_admin_init', array( $this, 'featured_metabox' ) );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Recipe()    A single instance of this class.
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
		$this->labels = array(
			'name'               => esc_html__( 'Recipes', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Recipe', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All Recipes', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Recipes', 'lsx-health-plan' ),
		);
		$args         = array(
			'labels'             => $this->labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=meal-pseudo',
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-editor-ul',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'recipe',
			),
			'capability_type'    => 'post',
			'has_archive'        => 'recipes',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			),
		);
		register_post_type( 'recipe', $args );
	}

	/**
	 * Registers the Recipes under the Meals Post type menu.
	 *
	 * @return void
	 */
	public function register_menus() {
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Recipes', 'lsx-health-plan' ), esc_html__( 'Recipes', 'lsx-health-plan' ), 'edit_posts', 'edit.php?post_type=recipe' );
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Recipe Types', 'lsx-health-plan' ), esc_html__( 'Recipe Types', 'lsx-health-plan' ), 'edit_posts', 'edit-tags.php?taxonomy=recipe-type&post_type=recipe' );
		add_submenu_page( 'edit.php?post_type=meal', esc_html__( 'Cuisines', 'lsx-health-plan' ), esc_html__( 'Cuisines', 'lsx-health-plan' ), 'edit_posts', 'edit-tags.php?taxonomy=recipe-cuisine&post_type=recipe' );
	}

	/**
	 * Register the Cuisine taxonomy.
	 */
	public function taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Cuisine', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Cuisines', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Cuisines', 'lsx-health-plan' ),
		);
		$args   = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_menu'      => 'edit.php?post_type=meal',
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'recipe-cuisine',
			),
		);
		register_taxonomy( 'recipe-cuisine', array( $this->slug ), $args );

		$labels = array(
			'name'              => esc_html_x( 'Recipe Type', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Recipe Types', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Types', 'lsx-health-plan' ),
		);
		$args   = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_menu'      => 'edit.php?post_type=meal',
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'recipe-type',
			),
		);
		register_taxonomy( 'recipe-type', array( $this->slug ), $args );
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
		$connections['recipe']['connected_plans'] = 'connected_recipes';
		$connections['plan']['connected_recipes'] = 'connected_plans';
		return $connections;
	}

	/**
	 * Remove the "Archives:" from the post type recipes.
	 *
	 * @param string $title the term title.
	 * @return string
	 */
	public function get_the_archive_title( $title ) {
		if ( is_post_type_archive( 'recipe' ) ) {
			$title = __( 'Recipes', 'lsx-health-plan' );
		}
		if ( is_post_type_archive( 'exercise' ) ) {
			$title = __( 'Exercises', 'lsx-health-plan' );
		}
		if ( is_tax( 'recipe-type' ) ) {
			$queried_object = get_queried_object();
			if ( isset( $queried_object->name ) ) {
				$title = $queried_object->name . ' ' . __( 'Recipes', 'lsx-health-plan' );
			}
		}
		return $title;
	}

	public function remove_archive_original_header() {
		if ( is_post_type_archive( 'recipe' ) || is_post_type_archive( 'exercise' ) ) {
			remove_action( 'lsx_content_wrap_before', 'lsx_global_header' );
		}
		if ( is_singular( 'recipe' ) || is_singular( 'exercise' ) ) {
			remove_action( 'lsx_content_wrap_before', 'lsx_global_header' );
		}
		if ( ! is_post_type_archive() ) {
			add_action( 'lsx_content_wrap_before', 'lsx_health_plan_recipe_archive_description', 11 );
		}
	}

	public function hp_lsx_archive_header() {
		if ( is_post_type_archive( 'recipe' ) || is_post_type_archive( 'exercise' ) ) {
		?>
			<div class="archive-header-wrapper banner-archive">
				<?php lsx_global_header_inner_bottom(); ?>
				<header class="archive-header">
					<h1 class="archive-title">
						<?php if ( has_post_format() && ! is_category() && ! is_tag() && ! is_date() && ! is_tax( 'post_format' ) ) { ?>
							<?php the_archive_title( esc_html__( 'Type:', 'lsx' ) ); ?>
						<?php } else { ?>
							<?php echo wp_kses_post( apply_filters( 'lsx_global_header_title', get_the_archive_title() ) ); ?>
						<?php } ?>
					</h1>

					<?php
					lsx_health_plan_recipe_archive_description();
					?>
				</header>
			</div>
		<?php
		}
	}

	/**
	 * Disables the global header description
	 *
	 * @param boolean $disable
	 * @return boolean
	 */
	public function disable_global_header_description( $disable ) {
		if ( is_tax( 'recipe-type' ) ) {
			$disable = true;
		}
		return $disable;
	}

	/**
	 * Holds the array for the breadcrumbs.
	 *
	 * @var array $crumbs
	 * @return array
	 */
	public function recipes_breadcrumb_filter( $crumbs ) {
		$recipe  = \lsx_health_plan\functions\get_option( 'endpoint_recipe', 'recipe' );
		$recipes = \lsx_health_plan\functions\get_option( 'endpoint_recipe_archive', 'recipes' );
		$url     = get_post_type_archive_link( 'recipe' );

		if ( is_singular( 'recipe' ) ) {
			$recipe_name     = get_the_title();
			$term_obj_list   = get_the_terms( get_the_ID(), 'recipe-type' );
			$recipe_type     = $term_obj_list[0]->name;
			$recipe_type_url = get_term_link( $term_obj_list[0]->term_id );

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $recipes,
					1 => $url,
				);
				$new_crumbs[2] = array(
					0 => $recipe_type,
					1 => $recipe_type_url,
				);
				$new_crumbs[3] = array(
					0 => $recipe_name,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $recipes,
					'url'  => $url,
				);
				$new_crumbs[2] = array(
					'text' => $recipe_type,
					'url'  => $recipe_type_url,
				);
				$new_crumbs[3] = array(
					'text' => $recipe_name,
				);
			}
			$crumbs = $new_crumbs;
		}
		if ( is_tax( 'recipe-type' ) || is_tax( 'recipe-cuisine' ) ) {
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 

			$single_term_title = str_replace( '-', ' ', $term->taxonomy ) . ': ' . $term->name;

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $recipes,
					1 => $url,
				);
				$new_crumbs[2] = array(
					0 => $single_term_title,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $recipes,
					'url'  => $url,
				);
				$new_crumbs[2] = array(
					'text' => $single_term_title,
				);
			}
			$crumbs = $new_crumbs;
		}
		if ( is_post_type_archive( 'recipe' ) ) {

			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				$new_crumbs[1] = array(
					0 => $recipes,
				);
			} else {
				$new_crumbs[1] = array(
					'text' => $recipes,
				);
			}
			$crumbs = $new_crumbs;
		}
		return $crumbs;
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function featured_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_featured_metabox',
				'title'        => __( 'Featured', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ),
				'context'      => 'side',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Featured', 'lsx-health-plan' ),
				'desc'       => __( 'Enable the checkbox to feature this recipe, featured recipes display in any page that has the recipe shortcode: [lsx_health_plan_featured_recipes_block]', 'lsx-health-plan' ),
				'id'         => $this->slug . '_featured',
				'type'       => 'checkbox',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function details_metaboxes() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_details_metabox',
				'title'        => __( 'Cooking Info', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Prep Time', 'lsx-health-plan' ),
				'id'         => $this->slug . '_prep_time',
				'desc'       => __( 'Add the preparation time for the entire meal i.e: 25 mins', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Cooking Time', 'lsx-health-plan' ),
				'id'         => $this->slug . '_cooking_time',
				'desc'       => __( 'Add the cooking time i.e: 15 mins', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Serves', 'lsx-health-plan' ),
				'id'         => $this->slug . '_serves',
				'desc'       => __( 'Add the recommended serving size i.e: 6', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
				'attributes' => array(
					'type'    => 'number',
					'pattern' => '\d*',
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Portion', 'lsx-health-plan' ),
				'desc'       => __( 'Add the recommended portion size i.e: 200mg', 'lsx-health-plan' ),
				'id'         => $this->slug . '_portion',
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_nutritional_metabox',
				'title'        => __( 'Nutritional Info', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Energy', 'lsx-health-plan' ),
				'id'         => $this->slug . '_energy',
				'desc'       => __( 'Add the energy amount for the entire meal i.e: 700 kj', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Protein', 'lsx-health-plan' ),
				'id'         => $this->slug . '_protein',
				'desc'       => __( 'Add the protein amount for the entire meal i.e: 50 g', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Carbohydrates', 'lsx-health-plan' ),
				'id'         => $this->slug . '_carbohydrates',
				'desc'       => __( 'Add the carbohydrates amount for the entire meal i.e: 5 g', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Fibre', 'lsx-health-plan' ),
				'id'         => $this->slug . '_fibre',
				'desc'       => __( 'Add the fibre amount for the entire meal i.e: 5 g', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Fat', 'lsx-health-plan' ),
				'id'         => $this->slug . '_fat',
				'desc'       => __( 'Add the fat amount for the entire meal i.e: 20 g', 'lsx-health-plan' ),
				'type'       => 'text',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
	}
}
