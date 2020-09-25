<?php
namespace lsx_health_plan\classes;

/**
 * Contains the endpoints
 *
 * @package lsx-health-plan
 */
class Modals {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Modals()
	 */
	protected static $instance = null;

	/**
	 * Holds the modals to be outputted
	 *
	 * @var array
	 */
	public $modals = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'output_modals' ) );
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
	 * Registers a modal to be outputted
	 *
	 * @param array $modal
	 * @param string $index
	 * @return void
	 */
	public function register_modal( $modal = array(), $index = '' ) {
		if ( '' !== $index && ! empty( $modal ) ) {
			$modal['id'] = $index;
			$this->modals[ $index ] = $modal;
		}
	}

	/**
	 * Registers the rewrites.
	 */
	public function output_modals() {
		if ( ! empty( $this->modals ) ) {
			wp_enqueue_script( 'lsx-health-plan-modals', LSX_HEALTH_PLAN_URL . 'assets/js/lsx-health-plan-modals.min.js', array( 'slick' ), LSX_HEALTH_PLAN_VER, true );

			foreach ( $this->modals as $index => $modal ) {
				\lsx_health_plan\functions\output_modal( $modal );
			}
		}
	}
}
