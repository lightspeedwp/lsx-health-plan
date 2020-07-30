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
		// Remove the default restrictions, as we will add our own.
		add_action( 'wp', array( $this, 'set_screen' ) );
		add_action( 'wp', array( $this, 'disable_wc_membership_course_restrictions' ), 999 );

		// Initiate the WP Head functions.
		add_action( 'wp_head', array( $this, 'set_screen' ) );
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
	public function set_screen() {
		global $post;
		if ( is_singular( 'plan' ) ) {
			if ( 0 === wp_get_post_parent_id( $post ) ) {
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
	 * Disable WC Memberships restrictions for plan parents. We add our own custom
	 * restriction functionality elsewhere.
	 */
	public function disable_wc_membership_course_restrictions() {
		if ( ! is_singular( 'plan' ) || 'parent_plan' !== $this->screen ) {
			return;
		}

		$restrictions = wc_memberships()->get_restrictions_instance()->get_posts_restrictions_instance();
		remove_action( 'the_post', [ $restrictions, 'restrict_post' ], 0 );
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
