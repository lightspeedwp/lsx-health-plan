<?php
namespace lsx_health_plan\classes;

/**
 * Contains the tip post type
 *
 * @package lsx-health-plan
 */
class Settings {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Settings()
	 */
	protected static $instance = null;

	/**
	 * Option key, and option page slug
		* @var string
		*/
	protected $screen_id = 'lsx_health_plan_settings';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'register_settings_page' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Settings()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	* Hook in and register a submenu options page for the Page post-type menu.
	*/
	public function register_settings_page() {
		/**
		* Registers options page menu item and form.
		*/
		$cmb = new_cmb2_box( array(
			'id'           => $this->screen_id,
			'title'        => esc_html__( 'LSX Health Plan', 'cmb2' ),
			'object_types' => array( 'options-page' ),
			/*
			* The following parameters are specific to the options-page box
			* Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			*/
			'option_key'   => 'lsx_health_plan_options', // The option key and admin menu page slug.
			'parent_slug'  => 'options-general.php', // Make options page a submenu item of the themes menu.
			'capability'   => 'manage_options', // Cap required to view options-page.
		) );

		$cmb->add_field( array(
			'name'       => __( 'Membership Product', 'lsx-health-plan' ),
			'id'         => 'membership_product',
			'type'       => 'post_search_ajax',
			// Optional :
			'limit'      => 1,  // Limit selection to X items only (default 1)
			'sortable'   => false, // Allow selected items to be sortable (default false)
			'query_args' => array(
				'post_type'      => array( 'product' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => -1,
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Your Warm-up Intro', 'lsx-health-plan' ),
			'id'      => 'warmup_intro',
			'type'    => 'textarea',
			'value'   => '',
			'default' => __( "Don't forget your warm-up! It's a vital part of your daily workout routine.", 'lsx-health-plan' ),
		) );
		$cmb->add_field( array(
			'name'    => __( 'Your Workout Intro', 'lsx-health-plan' ),
			'id'      => 'workout_intro',
			'type'    => 'textarea',
			'value'   => '',
			'default' => __( "Let's do this! Smash your daily workout and reach your fitness goals.", 'lsx-health-plan' ),
		) );
		$cmb->add_field( array(
			'name'    => __( 'Your Meal Plan Intro', 'lsx-health-plan' ),
			'id'      => 'meal_plan_intro',
			'type'    => 'textarea',
			'value'   => '',
			'default' => __( 'Get the right mix of nutrients to keep muscles strong & healthy.', 'lsx-health-plan' ),
		) );
		$cmb->add_field( array(
			'name'    => __( 'Recipes Intro', 'lsx-health-plan' ),
			'id'      => 'recipes_intro',
			'type'    => 'textarea',
			'value'   => '',
			'default' => __( "Let's get cooking! Delicious and easy to follow recipes.", 'lsx-health-plan' ),
		) );
		$cmb->add_field( array(
			'name'    => __( 'Recipes Intro', 'lsx-health-plan' ),
			'id'      => 'recipes_intro',
			'type'    => 'textarea',
			'value'   => '',
			'default' => __( "Let's get cooking! Delicious and easy to follow recipes.", 'lsx-health-plan' ),
		) );
		$cmb->add_field( array(
			'id'      => 'global_downloads_title',
			'type'    => 'title',
			'name'    => __( 'Global Downloads', 'lsx-health-plan' ),
			'default' => __( 'Global Downloads', 'lsx-health-plan' ),
		) );

		$download_types = array(
			'page'    => array(
				'title'       => __( 'Warm Up', 'lsx-health-plan' ),
				'description' => __( 'Set a default warm up routine.', 'lsx-health-plan' ),
			),
			'meal'    => array(
				'title'       => __( 'Meal Plan', 'lsx-health-plan' ),
				'description' => __( 'Set a default meal plan.', 'lsx-health-plan' ),
			),
			'recipe'  => array(
				'title'       => __( 'Recipe', 'lsx-health-plan' ),
				'description' => __( 'Set a default recipe.', 'lsx-health-plan' ),
			),
			'workout' => array(
				'title'       => __( 'Workout', 'lsx-health-plan' ),
				'description' => __( 'Set a default wourkout routine.', 'lsx-health-plan' ),
			),
			'video'   => array(
				'title'       => __( 'Workout Video', 'lsx-health-plan' ),
				'description' => __( 'Set a default wourkout video, this will be shown on all workouts that do not have a specific video set.', 'lsx-health-plan' ),
			),
		);

		foreach ( $download_types as $type => $download_type ) {
			$cmb->add_field( array(
				'name'       => $download_type['title'],
				'id'         => 'download_' . $type,
				'type'       => 'post_search_ajax',
				// Optional :
				'limit'      => 1,  // Limit selection to X items only (default 1)
				'sortable'   => false, // Allow selected items to be sortable (default false)
				'query_args' => array(
					'post_type'      => array( 'dlm_download' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			) );
		}
	}
}
