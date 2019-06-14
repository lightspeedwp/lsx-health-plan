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
	}
}
