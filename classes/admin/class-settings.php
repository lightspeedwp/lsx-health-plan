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
	public $default_types = array();

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
		add_action( 'lsx_hp_settings_page', array( $this, 'global_defaults' ), 3, 1 );
		add_action( 'lsx_hp_settings_page', array( $this, 'global_downloads' ), 5, 1 );
		add_action( 'lsx_hp_settings_page', array( $this, 'stat_disable' ), 6, 1 );
		add_action( 'lsx_hp_settings_page', array( $this, 'endpoint_translations' ), 7, 1 );
		add_action( 'lsx_hp_settings_page', array( $this, 'exercise_translations' ), 7, 1 );
		add_action( 'lsx_hp_settings_page', array( $this, 'post_type_toggles' ), 9, 1 );
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
			'plan',
			'workout',
			'exercise',
			//'meal',
			'recipe',
			//'tip',
		);

		foreach ( $this->post_types as $post_type ) {
			$this->$post_type = require_once LSX_HEALTH_PLAN_PATH . 'classes/admin/settings/class-' . $post_type . '.php';
		}
	}

	/**
	 * Sets the variables needed for the fields.
	 *
	 * @return void
	 */
	public function set_vars() {

		$this->default_types  = array(
			'page' => array(
				'title'       => __( 'Warm Up', 'lsx-health-plan' ),
				'description' => __( 'Set a default warm up routine.', 'lsx-health-plan' ),
				'limit'       => 1,
				'id'          => 'plan_warmup',
			),
		);
		$this->download_types = array(
			'page' => array(
				'title'       => __( 'Warm Up', 'lsx-health-plan' ),
				'description' => __( 'Set a default warm up routine.', 'lsx-health-plan' ),
				'limit'       => 1,
			),
		);
		$this->endpoints      = array(
			'endpoint_warm_up' => array(
				'title'       => __( 'Warm Up Endpoint', 'lsx-health-plan' ),
				'default'     => 'warm-up',
			),
		);

		if ( post_type_exists( 'meal' ) ) {
			$this->download_types['meal']     = array(
				'title'       => __( 'Meal Plan', 'lsx-health-plan' ),
				'description' => __( 'Set a default meal plan.', 'lsx-health-plan' ),
			);
			$this->default_types['meal']      = array(
				'title'       => __( 'Meal Plan', 'lsx-health-plan' ),
				'description' => __( 'Set a default meal plan.', 'lsx-health-plan' ),
				'id'          => 'connected_meals',
			);
			$this->endpoints['endpoint_meal'] = array(
				'title'       => __( 'Meal Endpoint', 'lsx-health-plan' ),
				'default'     => 'meal',
				'description' => __( 'Define the tab slug which shows on the single plan page.', 'lsx-health-plan' ),
			);
			$this->endpoints['endpoint_meal_archive'] = array(
				'title'   => __( 'Meals Archive Endpoint', 'lsx-health-plan' ),
				'default' => 'meals',
			);
			$this->endpoints['meal_single_slug'] = array(
				'title'   => __( 'Single Meal Slug', 'lsx-health-plan' ),
				'default' => 'meal',
			);
		}
		if ( post_type_exists( 'recipe' ) ) {
			$this->download_types['recipe'] = array(
				'title'       => __( 'Recipe', 'lsx-health-plan' ),
				'description' => __( 'Set a default recipe.', 'lsx-health-plan' ),
			);
			$this->default_types['recipe'] = array(
				'title'       => __( 'Recipe', 'lsx-health-plan' ),
				'description' => __( 'Set a default recipe.', 'lsx-health-plan' ),
				'id'          => 'connected_recipes',
			);
			$this->endpoints['endpoint_recipe'] = array(
				'title'   => __( 'Recipes Endpoint', 'lsx-health-plan' ),
				'default' => 'recipe',
			);
		}
		if ( post_type_exists( 'workout' ) ) {
			$this->download_types['workout'] = array(
				'title'       => __( 'Workout', 'lsx-health-plan' ),
				'description' => __( 'Set a default workout routine PDF.', 'lsx-health-plan' ),
			);
			$this->default_types['workout'] = array(
				'title'       => __( 'Workout', 'lsx-health-plan' ),
				'description' => __( 'Set a default workout routine.', 'lsx-health-plan' ),
				'id'          => 'connected_workouts',
			);
			$this->endpoints['endpoint_workout_archive'] = array(
				'title'   => __( 'Workouts Archive Endpoint', 'lsx-health-plan' ),
				'default' => '',
			);
			$this->endpoints['endpoint_workout'] = array(
				'title'   => __( 'Single Workout Endpoint', 'lsx-health-plan' ),
				'default' => 'workout',
			);
		}

		$this->endpoints['login_slug'] = array(
			'title'   => __( 'Login Slug', 'lsx-health-plan' ),
			'default' => 'login',
		);
		$this->endpoints['my_plan_slug'] = array(
			'title'   => __( 'My Plan Slug', 'lsx-health-plan' ),
			'default' => 'my-plan',
		);
		$this->endpoints['plan_single_slug'] = array(
			'title'   => __( 'Single Plan Slug', 'lsx-health-plan' ),
			'default' => 'plan',
		);
		$this->endpoints['endpoint_plan_archive'] = array(
			'title'   => __( 'Plans Archive Endpoint', 'lsx-health-plan' ),
			'default' => 'plans',
		);

		if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
			$this->endpoints['exercise'] = array(
				'exercise_single' => array(
					'title'   => __( 'Single Exercise Slug', 'lsx-health-plan' ),
					'default' => 'exercise',
				),
				'exercise_archive' => array(
					'title'   => __( 'Archive Exercise Slug', 'lsx-health-plan' ),
					'default' => 'exercises',
				),
				'exercise_type' => array(
					'title'   => __( 'Exercise Type Slug', 'lsx-health-plan' ),
					'default' => 'exercise-type',
				),
				'exercise_equipment' => array(
					'title'   => __( 'Equipment Slug', 'lsx-health-plan' ),
					'default' => 'equipment',
				),
				'exercise_musclegroup' => array(
					'title'   => __( 'Muscle Group Slug', 'lsx-health-plan' ),
					'default' => 'muscle-group',
				),
			);
		}
	}

	/**
	 * Hook in and register a submenu options page for the Page post-type menu.
	 */
	public function register_settings_page() {
		$this->set_vars();
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
				'name'       => __( 'Membership Product', 'lsx-health-plan' ),
				'id'         => 'membership_product',
				'type'       => 'post_search_ajax',
				'limit'      => 1,
				'sortable'   => false,
				'query_args' => array(
					'post_type'      => array( 'product' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);

		$cmb->add_field(
			array(
				'name'    => __( 'Your Warm-up Intro', 'lsx-health-plan' ),
				'id'      => 'warmup_intro',
				'type'    => 'textarea_small',
				'value'   => '',
				'default' => __( "Don't forget your warm-up! It's a vital part of your daily workout routine.", 'lsx-health-plan' ),
			)
		);
		if ( post_type_exists( 'workout' ) ) {
			$cmb->add_field(
				array(
					'name'    => __( 'Your Workout Intro', 'lsx-health-plan' ),
					'id'      => 'workout_intro',
					'type'    => 'textarea_small',
					'value'   => '',
					'default' => __( "Let's do this! Smash your daily workout and reach your fitness goals.", 'lsx-health-plan' ),
				)
			);
		}
		if ( post_type_exists( 'meal' ) ) {
			$cmb->add_field(
				array(
					'name'    => __( 'Your Meal Plan Intro', 'lsx-health-plan' ),
					'id'      => 'meal_plan_intro',
					'type'    => 'textarea_small',
					'value'   => '',
					'default' => __( 'Get the right mix of nutrients to keep muscles strong & healthy.', 'lsx-health-plan' ),
				)
			);
		}
		if ( post_type_exists( 'recipe' ) ) {
			$cmb->add_field(
				array(
					'name'    => __( 'Recipes Intro', 'lsx-health-plan' ),
					'id'      => 'recipes_intro',
					'type'    => 'textarea_small',
					'value'   => '',
					'default' => __( "Let's get cooking! Delicious and easy to follow recipes.", 'lsx-health-plan' ),
				)
			);
		}
	}

	/**
	 * Registers the global default settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function global_defaults( $cmb ) {
		$cmb->add_field(
			array(
				'id'      => 'global_defaults_title',
				'type'    => 'title',
				'name'    => __( 'Global Defaults', 'lsx-health-plan' ),
				'default' => __( 'Global Defaults', 'lsx-health-plan' ),
				'description' => __( 'If you have not connected a specific post to your day plan, set a default option below.', 'lsx-health-plan' ),
			)
		);

		foreach ( $this->default_types as $type => $default_type ) {
			$limit    = 5;
			$sortable = false;
			if ( isset( $default_type['limit'] ) ) {
				$limit    = $default_type['limit'];
				$sortable = true;
			}

			if ( 'page' === $type && false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
				$type = array( 'page', 'workout' );
			}

			$cmb->add_field(
				array(
					'name'       => $default_type['title'],
					'desc'       => $default_type['description'],
					'id'         => $default_type['id'],
					'type'       => 'post_search_ajax',
					'limit'      => $limit,
					'sortable'   => $sortable,
					'query_args' => array(
						'post_type'      => $type,
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}

		$cmb->add_field(
			array(
				'id'   => 'settings_global_defaults_closing',
				'type' => 'tab_closing',
			)
		);
	}

	/**
	 * Registers the global dowloads settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function global_downloads( $cmb ) {
		if ( ! function_exists( 'download_monitor' ) ) {
			return;
		}
		$page_url    = 'https://wordpress.org/plugins/download-monitor/';
		$plugin_name = 'Download Monitor';
		$description = sprintf(
			/* translators: %s: The subscription info */
			__( 'If you are using <a target="_blank" href="%1$s">%2$s</a> you can set a default download file for your plan here.', 'lsx-search' ),
			$page_url,
			$plugin_name
		);
		$cmb->add_field(
			array(
				'id'          => 'global_downloads_title',
				'type'        => 'title',
				'name'        => __( 'Global Downloads', 'lsx-health-plan' ),
				'default'     => __( 'Global Downloads', 'lsx-health-plan' ),
				'description' => $description,
			)
		);

		foreach ( $this->download_types as $type => $download_type ) {
			$limit    = 5;
			$sortable = false;
			if ( isset( $download_type['limit'] ) ) {
				$limit    = $download_type['limit'];
				$sortable = true;
			}

			$cmb->add_field(
				array(
					'name'       => $download_type['title'],
					'id'         => 'download_' . $type,
					'type'       => 'post_search_ajax',
					'limit'      => $limit,
					'sortable'   => $sortable,
					'query_args' => array(
						'post_type'      => array( 'dlm_download' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}
		$cmb->add_field(
			array(
				'id'   => 'settings_global_downloads_closing',
				'type' => 'tab_closing',
			)
		);
	}

	/**
	 * Registers the endpoint translation settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function endpoint_translations( $cmb ) {
		$cmb->add_field(
			array(
				'id'          => 'endpoints_title',
				'type'        => 'title',
				'name'        => __( 'Set Endpoint Translations', 'lsx-health-plan' ),
				'default'     => __( 'Set Endpoint Translations', 'lsx-health-plan' ),
			)
		);
		foreach ( $this->endpoints as $slug => $endpoint_vars ) {
			if ( 'exercise' === $slug ) {
				continue;
			}

			$cmb->add_field(
				array(
					'name'    => $endpoint_vars['title'],
					'id'      => $slug,
					'type'    => 'input',
					'value'   => '',
					'default' => $endpoint_vars['default'],
				)
			);
		}
		$cmb->add_field(
			array(
				'id'            => 'settings_endpoints_closing',
				'type'          => 'tab_closing',
				'before_row'    => '<p style="margin-top:20px; font-style: italic;">Endpoint is a web address (URL) at which the user can gain access to it. You need to resave your permalinks after changing the endpoint settings.</p>',
			)
		);
	}

	/**
	 * Registers the endpoint translation settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function exercise_translations( $cmb ) {
		if ( isset( $this->endpoints['exercise'] ) && '' !== $this->endpoints['exercise'] && ! empty( $this->endpoints['exercise'] ) ) {
			$cmb->add_field(
				array(
					'id'          => 'exercise_endpoints_title',
					'type'        => 'title',
					'name'        => __( 'Set Exercise Translations', 'lsx-health-plan' ),
					'default'     => __( 'Set Exercise Translations', 'lsx-health-plan' ),
					'description' => __( 'Change the exercise endpoints.', 'lsx-health-plan' ),
				)
			);

			foreach ( $this->endpoints['exercise'] as $slug => $endpoint_vars ) {
				$cmb->add_field(
					array(
						'name'    => $endpoint_vars['title'],
						'id'      => 'endpoint_' . $slug,
						'type'    => 'input',
						'value'   => '',
						'default' => $endpoint_vars['default'],
					)
				);
			}

			$cmb->add_field(
				array(
					'id'            => 'settings_exercise_endpoints_closing',
					'type'          => 'tab_closing',
					'before_row'    => '<p style="margin-top:20px; font-style: italic;">If you need to translate the exercise URL slugs, do so below.</p>',
				)
			);
		}
	}

	/**
	 * Registers the post type toggle settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function post_type_toggles( $cmb ) {
		$post_types = apply_filters( 'lsx_health_plan_post_types', isset( $this->post_types ) );

		$cmb->add_field(
			array(
				'id'          => 'post_type_toggles_title',
				'type'        => 'title',
				'name'        => __( 'Disable Post Types', 'lsx-health-plan' ),
				'default'     => __( 'Disable Post Types', 'lsx-health-plan' ),
				'description' => __( 'Disable post types if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);

		foreach ( $post_types as $post_type ) {
			if ( 'plan' === $post_type || 'exercise' === $post_type || ( 'video' === $post_type && false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) ) {
				continue;
			}

			$cmb->add_field(
				array(
					'name'    => ucwords( $post_type ),
					'id'      => $post_type . '_disabled',
					'type'    => 'checkbox',
					'value'   => 1,
					'default' => 0,
				)
			);
		}

		$cmb->add_field(
			array(
				'id'   => 'settings_post_type_toggles_closing',
				'type' => 'tab_closing',
			)
		);

		$cmb->add_field(
			array(
				'id'          => 'post_type_toggles_enable_title',
				'type'        => 'title',
				'name'        => __( 'Enable Post Types', 'lsx-health-plan' ),
				'default'     => __( 'Enable Post Types', 'lsx-health-plan' ),
				'description' => __( 'Enable new functionality like the "exercise" post type.', 'lsx-health-plan' ),
			)
		);
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
				'id'   => 'settings_post_type_toggles_enable_closing',
				'type' => 'tab_closing',
			)
		);
	}
	/**
	 * Registers the Profile Stat Toggle settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */

	public function stat_disable( $cmb ) {
		$cmb->add_field(
			array(
				'id'      => 'stat_disable_title',
				'type'    => 'title',
				'name'    => __( 'Disable Profile Stats', 'lsx-health-plan' ),
				'default' => __( 'Disable Profile Stats', 'lsx-health-plan' ),
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable All Stats', 'lsx-health-plan' ),
				'desc'    => 'Disable All Stats',
				'id'      => 'disable_all_stats',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Weight', 'lsx-health-plan' ),
				'id'      => 'disable_weight_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Height', 'lsx-health-plan' ),
				'id'      => 'disable_height_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Waist', 'lsx-health-plan' ),
				'id'      => 'disable_waist_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable BMI', 'lsx-health-plan' ),
				'id'      => 'disable_bmi_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'id'   => 'settings_stat_disable_closing',
				'type' => 'tab_closing',
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
