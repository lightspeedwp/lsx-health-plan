<?php
namespace lsx_health_plan\classes;

/**
 * Contains the endpoints
 *
 * @package lsx-health-plan
 */
class Endpoints {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Endpoints()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'setup' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Endpoints()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Runs on init
	 */
	public function setup() {
		$this->add_rewrite_rules();
	}

	/**
	 * Registers the rewrites.
	 */
	public function add_rewrite_rules() {

		// Variables to hold Translations.

		// Warm up.
		$warm_up = \lsx_health_plan\functions\get_option( 'endpoint_warm_up', false );
		if ( false === $warm_up ) {
			$warm_up = 'warm-up';
		}
		// Workout.
		$workout = \lsx_health_plan\functions\get_option( 'endpoint_workout', false );
		if ( false === $workout ) {
			$workout = 'workout';
		}

		// Meal.
		$meal = \lsx_health_plan\functions\get_option( 'endpoint_meal', false );
		if ( false === $meal ) {
			$meal = 'meal';
		}

		// Recipe.
		$recipe = \lsx_health_plan\functions\get_option( 'endpoint_recipe', false );
		if ( false === $recipe ) {
			$recipe = 'recipes';
		}

		// Here is where we add in the rewrite rules above the normal WP ones.
		add_rewrite_tag( '%endpoint%', '([^&]+)' );

		add_rewrite_rule( 'plan/([^/]+)/' . $warm_up . '/?$', 'index.php?plan=$matches[1]&endpoint=warm-up', 'top' );
		add_rewrite_rule( 'plan/([^/]+)/' . $workout . '/?$', 'index.php?plan=$matches[1]&endpoint=workout', 'top' );
		add_rewrite_rule( 'plan/([^/]+)/' . $meal . '/?$', 'index.php?plan=$matches[1]&endpoint=meal', 'top' );
		add_rewrite_rule( 'plan/([^/]+)/' . $recipe . '/?$', 'index.php?plan=$matches[1]&endpoint=recipes', 'top' );
	}
}
