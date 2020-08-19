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
	 * Holds post_type slug used as an index
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $slug = 'plan';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'plan_type_taxonomy_setup' ) );
		add_action( 'init', array( $this, 'week_taxonomy_setup' ) );

		// Icons for the plan types.
		add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_meta' ), 10, 2 );
		$prefix_taxonomy = 'plan-type';
		add_action( sprintf( '%s_edit_form_fields', $prefix_taxonomy ), array( $this, 'add_thumbnail_form_field' ), 3, 1 );

		// Register the Metaboxes.
		add_action( 'cmb2_admin_init', array( $this, 'featured_metabox' ), 5 );
		add_action( 'cmb2_admin_init', array( $this, 'details_metaboxes' ), 5 );
		add_action( 'cmb2_admin_init', array( $this, 'plan_connections' ), 5 );
		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );

		add_filter( 'lsx_global_header_title',  array( $this, 'hp_recipe_header_title' ), 200, 1 );

		// Template Redirects.
		add_filter( 'lsx_health_plan_archive_template', array( $this, 'enable_post_type' ), 10, 1 );
		add_filter( 'lsx_health_plan_single_template', array( $this, 'enable_post_type' ), 10, 1 );

		// Plan Archive Actions.
		add_action( 'pre_get_posts', array( $this, 'set_parent_only' ), 10, 1 );
		add_action( 'lsx_content_top', 'lsx_hp_plan_archive_filters', 10, 1 );
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
			'name'               => esc_html__( 'Plans', 'lsx-health-plan' ),
			'singular_name'      => esc_html__( 'Plan', 'lsx-health-plan' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'lsx-health-plan' ),
			'add_new_item'       => esc_html__( 'Add New', 'lsx-health-plan' ),
			'edit_item'          => esc_html__( 'Edit', 'lsx-health-plan' ),
			'new_item'           => esc_html__( 'New', 'lsx-health-plan' ),
			'all_items'          => esc_html__( 'All Plans', 'lsx-health-plan' ),
			'view_item'          => esc_html__( 'View', 'lsx-health-plan' ),
			'search_items'       => esc_html__( 'Search', 'lsx-health-plan' ),
			'not_found'          => esc_html__( 'None found', 'lsx-health-plan' ),
			'not_found_in_trash' => esc_html__( 'None found in Trash', 'lsx-health-plan' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Plans', 'lsx-health-plan' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-welcome-write-blog',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => \lsx_health_plan\functions\get_option( 'plan_single_slug', 'plan' ),
			),
			'capability_type'    => 'page',
			'has_archive'        => \lsx_health_plan\functions\get_option( 'endpoint_plan_archive', 'plans' ),
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
		register_post_type( 'plan', $args );
	}

	/**
	 * Register the Type taxonomy.
	 */
	public function plan_type_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Plan Type', 'taxonomy general name', 'lsx-health-plan' ),
			'singular_name'     => esc_html_x( 'Plan Type', 'taxonomy singular name', 'lsx-health-plan' ),
			'search_items'      => esc_html__( 'Search', 'lsx-health-plan' ),
			'all_items'         => esc_html__( 'All', 'lsx-health-plan' ),
			'parent_item'       => esc_html__( 'Parent', 'lsx-health-plan' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'lsx-health-plan' ),
			'edit_item'         => esc_html__( 'Edit', 'lsx-health-plan' ),
			'update_item'       => esc_html__( 'Update', 'lsx-health-plan' ),
			'add_new_item'      => esc_html__( 'Add New', 'lsx-health-plan' ),
			'new_item_name'     => esc_html__( 'New Name', 'lsx-health-plan' ),
			'menu_name'         => esc_html__( 'Plan Types', 'lsx-health-plan' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'plan-type',
			),
		);

		register_taxonomy( 'plan-type', array( 'plan' ), $args );
	}

	/**
	 * Register the Week taxonomy.
	 */
	public function week_taxonomy_setup() {
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
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug' => 'week',
			),
		);

		register_taxonomy( 'week', array( 'plan' ), $args );
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_thumbnail_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value         = get_term_meta( $term->term_id, 'thumbnail', true );
			$image_preview = wp_get_attachment_image_src( $value, 'thumbnail' );

			if ( is_array( $image_preview ) ) {
				$image_preview = '<img style="height: 50px; width: 50px;" src="' . esc_url( $image_preview[0] ) . '" width="' . $image_preview[1] . '" height="' . $image_preview[2] . '" class="alignnone size-thumbnail d wp-image-' . $value . '" />';
			}
		} else {
			$image_preview = false;
			$value         = false;
		}
		?>
		<tr class="form-field form-required term-thumbnail-wrap">
			<th scope="row"><label for="thumbnail"><?php esc_html_e( 'Icon Image', 'lsx-health-plan' ); ?></label></th>
			<td>
				<input class="input_image_id" type="hidden" name="thumbnail" value="<?php echo wp_kses_post( $value ); ?>">
				<div class="thumbnail-preview">
					<?php echo wp_kses_post( $image_preview ); ?>
				</div>
				<a style="<?php if ( '' !== $value && false !== $value ) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'lsx-health-plan' ); ?></a>
				<a style="<?php if ( '' === $value || false === $value ) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php esc_html_e( 'Remove Image', 'lsx-health-plan' ); ?></a>
				<?php wp_nonce_field( 'lsx_hp_term_thumbnail_nonce', 'lsx_hp_term_thumbnail_nonce' ); ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Saves the Taxonomy term icon image
	 *
	 * @since 0.1.0
	 *
	 * @param  int    $term_id
	 * @param  string $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['thumbnail'] ) ) {
			return;
		}

		if ( check_admin_referer( 'lsx_hp_term_thumbnail_nonce', 'lsx_hp_term_thumbnail_nonce' ) ) {
			if ( ! isset( $_POST['thumbnail'] ) ) {
				return;
			}

			$thumbnail_meta = sanitize_text_field( $_POST['thumbnail'] );
			$thumbnail_meta = ! empty( $thumbnail_meta ) ? $thumbnail_meta : '';

			if ( empty( $thumbnail_meta ) ) {
				delete_term_meta( $term_id, 'thumbnail' );
			} else {
				update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
			}
		}
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function details_metaboxes() {
		$cmb = new_cmb2_box( array(
			'id'           => $this->slug . '_details_metabox',
			'title'        => __( 'Details', 'lsx-health-plan' ),
			'object_types' => array( $this->slug ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );

		$warmup_type = 'page';
		if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
			$warmup_type = array( 'page', 'workout' );
		}
		$cmb->add_field( array(
			'name'       => __( 'Warmup', 'lsx-health-plan' ),
			'desc'       => __( 'Connect the warm up page that applies to this day plan using the field provided.', 'lsx-health-plan' ),
			'id'         => $this->slug . '_warmup',
			'type'       => 'post_search_ajax',
			// Optional :
			'limit'      => 3,  // Limit selection to X items only (default 1)
			'sortable'   => true, // Allow selected items to be sortable (default false)
			'query_args' => array(
				'post_type'      => $warmup_type,
				'post_status'    => array( 'publish' ),
				'posts_per_page' => -1,
			),
		) );
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
	public function plan_connections() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_connections_metabox',
				'title'        => __( 'Plans', 'lsx-health-plan' ),
				'object_types' => array( 'workout', 'meal', 'tip', 'recipe' ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Plan', 'lsx-health-plan' ),
				'id'         => 'connected_plans',
				'desc'       => __( 'Connect this to the day plan it applies to, using the field provided.', 'lsx-health-plan' ),
				'type'       => 'post_search_ajax',
				'limit'      => 15,
				'sortable'   => true,
				'query_args' => array(
					'post_type'      => array( 'plan' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
	}

	/**
	 * Remove the "Archives:" from the post type.
	 *
	 * @param string $title the term title.
	 * @return string
	 */
	public function get_the_archive_title( $title ) {
		if ( is_post_type_archive( 'plan' ) ) {
			$title = __( 'Our health plans', 'lsx-health-plan' );
		}
		return $title;
	}

	/**
	 * Remove the single recipe and exercise title
	 */
	public function hp_recipe_header_title( $title ) {

		if ( is_single() && is_singular( 'recipe' ) ) {

			$title = __( 'Recipe', 'lsx-health-plan' );
		}

		if ( is_single() && is_singular( 'exercise' ) ) {

			$title = __( 'Exercise', 'lsx-health-plan' );
		}

		return $title;
	}

	/**
	 * Set the post type archive to show the parent plans only.
	 *
	 * @param object $wp_query
	 * @return array
	 */
	public function set_parent_only( $wp_query ) {
		if ( ! is_admin() && $wp_query->is_main_query() && ( $wp_query->is_post_type_archive( 'plan' ) || $wp_query->is_tax( 'plan-type' ) ) ) {
			$wp_query->set( 'post_parent', '0' );
		}
	}

	/**
	 * Define the metabox and field configurations.
	 */
	public function featured_metabox() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->slug . '_featured_metabox_plan',
				'title'        => __( 'Featured Plan', 'lsx-health-plan' ),
				'object_types' => array( $this->slug ), // Post type
				'context'      => 'side',
				'priority'     => 'high',
				'show_names'   => true,
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Featured Plan', 'lsx-health-plan' ),
				'desc'       => __( 'Enable a featured plan' ),
				'id'         => $this->slug . '_featured_plan',
				'type'       => 'checkbox',
				'show_on_cb' => 'cmb2_hide_if_no_cats',
			)
		);
	}
}
