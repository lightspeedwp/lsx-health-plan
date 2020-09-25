<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Settings().
 */
class Settings {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Settings()
	 */
	protected static $instance = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var string
	 */
	protected $screen_id = 'lsx_health_plan_settings';

	/**
	 * An array of the post types for the Global Downloads field.
	 *
	 * @var array
	 */
	public $download_types = array();

	/**
	 * An array of the post types for the Global Defaults field.
	 *
	 * @var array
	 */
	//public $default_types = array();

	/**
	 * An array of the endpoints for the Endpoint Translation field.
	 *
	 * @var array
	 */
	public $endpoints = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_classes();
		add_action( 'cmb2_admin_init', array( $this, 'register_settings_page' ) );
		add_action( 'lsx_hp_settings_page', array( $this, 'generate_tabs' ), 1, 1 );

		add_action( 'lsx_hp_settings_page_general_top', array( $this, 'general_settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Settings()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Loads the variable classes and the static classes.
	 */
	private function load_classes() {

		$this->post_types = array(
			'my-plans',
			'workout',
			'exercise',
			'meal',
			'recipe',
			//'tip',
			'recipe',
		);

		foreach ( $this->post_types as $post_type ) {
			$this->$post_type = require_once LSX_HEALTH_PLAN_PATH . 'classes/admin/settings/class-' . $post_type . '.php';
		}

	}

	/**
	 * Hook in and register a submenu options page for the Page post-type menu.
	 */
	public function register_settings_page() {
		$cmb = new_cmb2_box(
			array(
				'id'           => $this->screen_id,
				'title'        => esc_html__( 'Settings', 'lsx-health-plan' ),
				'object_types' => array( 'options-page' ),
				'option_key'   => 'lsx_health_plan_options', // The option key and admin menu page slug.
				'parent_slug'  => 'edit.php?post_type=plan', // Make options page a submenu item of the themes menu.
				'capability'   => 'manage_options', // Cap required to view options-page.
			)
		);
		do_action( 'lsx_hp_settings_page', $cmb );
	}

	/**
	 * Registers the general settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function general_settings( $cmb ) {
		$cmb->add_field(
			array(
				'name'        => __( 'Exercises', 'lsx-health-plan' ),
				'id'          => 'exercise_enabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Enabling the exercise post type will automatically replace the Video post type.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'name'        => __( 'Disable Workouts', 'lsx-health-plan' ),
				'id'          => 'workout_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable workout post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'name'        => __( 'Disable Recipes', 'lsx-health-plan' ),
				'id'          => 'recipe_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable recipe post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'name'        => __( 'Disable Meals', 'lsx-health-plan' ),
				'id'          => 'meal_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable meal post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);
		

		$cmb->add_field(
			array(
				'name'      =>  __( 'Login Slug', 'lsx-health-plan' ),
				'id'        => 'login_slug',
				'type'      => 'input',
				'value'     => '',
				'default'   => 'login',
				'after_row' => __( '<p style="font-style: italic;">If you have changed any URL slugs, please remember re-save your permalinks in Settings > Permalinks.</p>', 'lsx-health-plan' ),
			)
		);

	}

	/**
	 * Enable Business Directory Search settings only if LSX Search plugin is enabled.
	 *
	 * @param object $cmb The CMB2() class.
	 * @param string $section either engine,archive or single.
	 * @return void
	 */
	public function generate_tabs( $cmb ) {
		$tabs = $this->get_settings_tabs();

		foreach ( $tabs as $tab_key => $tab ) {
			$cmb->add_field(
				array(
					'id'          => 'settings_' . $tab_key . '_title',
					'type'        => 'title',
					'name'        => $tab['title'],
					'default'     => $tab['title'],
					'description' => $tab['desc'],
				)
			);
			do_action( 'lsx_hp_settings_page_' . $tab_key . '_top', $cmb );

			do_action( 'lsx_hp_settings_page_' . $tab_key . '_middle', $cmb );

			do_action( 'lsx_hp_settings_page_' . $tab_key . '_bottom', $cmb );

			$cmb->add_field(
				array(
					'id'   => 'settings_' . $tab_key . '_closing',
					'type' => 'tab_closing',
				)
			);
		}
	}


	/**
	 * Returns the tabs and their descriptions.
	 *
	 * @return array
	 */
	public function get_settings_tabs() {
		$tabs = array(
			'general' => array(
				'title' => __( 'General', 'lsx-health-plan' ),
				'desc'  => __( 'Control the sitewide settings for the LSX HP site.', 'lsx-health-plan' ),
			),
		);

		foreach ( $this->post_types as $post_type ) {
			switch ( $post_type ) {
				case 'my-plans':
					$page_url    = get_post_type_archive_link( 'plan' );
					$description = sprintf(
						/* translators: %s: The subscription info */
						__( 'Control the settings for your <a target="_blank" href="%1$s">%2$s</a> pages.', 'lsx-search' ),
						$page_url,
						__( 'plan', 'lsx-health-plan' )
					);
					$tabs[ $post_type ] = array(
						'title' => __( 'My Plans', 'lsx-health-plan' ),
						'desc'  => $description,
					);
					break;
				default:
					//if ( ! in_array( $post_type, \lsx\search\includes\get_restricted_post_types() ) ) {
						$temp_post_type = get_post_type_object( $post_type );
						if ( ! is_wp_error( $temp_post_type ) ) {
							$page_url    = get_post_type_archive_link( $temp_post_type->name );
							$description = sprintf(
								/* translators: %s: The subscription info */
								__( 'Control the settings for your <a target="_blank" href="%1$s">%2$s</a> archive.', 'lsx-search' ),
								$page_url,
								$temp_post_type->label
							);

							$tabs[ $post_type ] = array(
								'title' => $temp_post_type->label,
								'desc'  => $description,
							);
						}
					//}
					break;
			}
		}
		return $tabs;
	}
}
