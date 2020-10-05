<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downloads functions post type
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
	 * Holds the curret parent ID.
	 *
	 * @var int
	 */
	public $parent_id = 0;

	/**
	 * Constructor
	 */
	public function __construct() {
		// Remove the default restrictions, as we will add our own.
		add_action( 'wp', array( $this, 'set_screen' ), 1 );
		add_action( 'wp', array( $this, 'disable_parent_plan_restrictions' ), 2 );
		add_action( 'wp', array( $this, 'child_plan_redirect_restrictions' ), 2 );

		// Initiate the WP Head functions.
		add_action( 'wp_head', array( $this, 'set_screen' ) );
		add_action( 'lsx_content_top', 'lsx_hp_single_plan_products' );

		// Plan Archive Actions.
		add_action( 'lsx_entry_before', array( $this, 'set_product_ids' ) );
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
		if ( is_singular( array( 'plan' ) ) ) {
			$section = get_query_var( 'section' );
			if ( ! empty( $section ) ) {
				$this->screen = 'child_plan';
			} else {
				$this->screen = 'parent_plan';
			}
			$product_ids = get_post_meta( get_the_ID(), 'plan_product', true );
			if ( false !== $product_ids && ! empty( $product_ids ) ) {
				$this->product_ids = $product_ids;
			}
		}
		if ( is_singular( array( 'workout', 'meal' ) ) ) {
			$parent_id = wp_get_post_parent_id( get_the_ID() );
			if ( 0 === $parent_id || false === $parent_id ) {
				$this->screen = 'parent_plan';
			} else {
				$this->screen = 'child_plan';
			}
		}
		if ( is_post_type_archive( array( 'plan', 'workout', 'meal' ) ) || is_tax( array( 'plan-type', 'workout-type', 'meal-type' ) ) ) {
			$this->screen = 'plan_archive';
		}
	}

	/**
	 * Sets the post type archive product ids.
	 *
	 * @return void
	 */
	public function set_product_ids() {
		$this->product_ids = false;
		if ( 'plan' === get_post_type() ) {
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
	public function disable_parent_plan_restrictions() {
		if ( '' === $this->screen || ! function_exists( 'wc_memberships' ) ) {
			return;
		}

		$restrictions = wc_memberships()->get_restrictions_instance()->get_posts_restrictions_instance();
		remove_action( 'wp', array( $restrictions, 'handle_restriction_modes' ) );
	}

	/**
	 * Disable WC Memberships restrictions for plan parents. We add our own custom
	 * restriction functionality elsewhere.
	 */
	public function child_plan_redirect_restrictions() {
		if ( ! function_exists( 'wc_memberships' ) || ! is_singular( 'plan' ) || 'child_plan' !== $this->screen || ! function_exists( 'wc_memberships_is_post_content_restricted' ) ) {
			return;
		}
		$restricted = wc_memberships_is_post_content_restricted() && ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
		if ( true === $restricted ) {
			wp_redirect( get_permalink( get_the_ID() ) );
			exit;
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
