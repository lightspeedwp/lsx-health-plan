<?php
namespace lsx_health_plan\classes;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class FacetWP {

	/**
	 * Holds class instance
	 *
	 * @var      object \lsx_health_plan\classes\FacetWP()
	 */
	protected static $instance = null;

	/**
	 * Holds the indexer filters for the workouts.
	 *
	 * @var      object \lsx_health_plan\classes\integrations\FacetWP\Workouts_Indexer()
	 */
	public $workouts = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_classes();
		add_filter( 'facetwp_facet_sources', array( $this, 'register_sources' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\FacetWP()    A single instance of this class.
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
		require_once LSX_HEALTH_PLAN_PATH . 'classes/integrations/facetwp/class-connected-plans.php';
		$this->connected_plans = integrations\facetwp\Connected_Plans::get_instance();
	}

	/**
	 * Registers the custom sources.
	 *
	 * @param array $sources
	 * @return array
	 */
	public function register_sources( $sources ) {
		$sources['lsx_health_plan'] = array(
			'label'   => __( 'LSX Health Plan', 'lsx-health-plan' ),
			'choices' => array(
				'lsx_hp/connected_plans' => 'Connected Plans',
			),
		);

		return $sources;
	}
}
