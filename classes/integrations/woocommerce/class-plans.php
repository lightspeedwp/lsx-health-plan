<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class Plans {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Plans()
	 */
	protected static $instance = null;

	/**
	 * Holds the current screen var if it is active.
	 *
	 * @var string
	 */
	public $screen = '';

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'wp_head' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integrations\woocommerce\Plans()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the product metabox on the plan post type
	 */
	public function wp_head() {
		global $post;
		if ( is_singular( 'plan' ) ) {
			if ( false === wp_get_post_parent_id( $post ) ) {
				$this->screen = 'parent_plan';
			} else {
				$this->screen = 'child_plan';
			}
		}
	}
}
