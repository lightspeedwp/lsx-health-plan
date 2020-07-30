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
	 * Holds the current array of product IDS.
	 *
	 * @var array
	 */
	public $product_ids = array();

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_action( 'lsx_content_top', 'lsx_hp_single_plan_products' );
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
			$product_ids = get_post_meta( get_the_ID(), 'plan_product', true );
			if ( false !== $product_ids && ! empty( $product_ids ) ) {
				$this->product_ids = $product_ids;
			}
		}
	}

	/**
	 * Returns the ids of the attached products.
	 *
	 * @return array
	 */
	public function get_products() {
		return $this->product_ids;
	}
}
