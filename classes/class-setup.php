<?php
namespace lsx_health_plan\classes;
/**
 * LSX Health Plan Admin Class.
 *
 * @package lsx-health-plan
 */
class Setup {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Setup()
	 */
	protected static $instance = null;

	/**
	 * @var object \lsx_health_plan\classes\Post_Type();
	 */
	public $post_types;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		require_once( LSX_HEALTH_PLAN_PATH . 'classes/class-post-type.php' );
		$this->post_types = Post_Type::get_instance();
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Setup()    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Adds text domain.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'lsx-health-plan', false, basename( LSX_HEALTH_PLAN_PATH ) . '/languages' );
	}	
}
