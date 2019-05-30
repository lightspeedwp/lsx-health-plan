<?php
namespace lsx_health_plan\classes;
/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class Woocommerce {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Woocommerce()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 20, 1 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'only_one_in_cart' ), 99, 2 );
		add_filter( 'woocommerce_order_button_text', array( $this, 'checkout_button_text' ), 10, 1 );		
		add_filter( 'woocommerce_get_breadcrumb', array( $this, 'breadcrumbs' ), 30, 1 );
		add_filter( 'the_content', array( $this, 'edit_my_account' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Woocommerce()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Runs on init
	 *
	 * @return void
	 */
	public function init() {
		remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
	}

	/**
	 * Empties the cart before a product is added
	 *
	 * @param [type] $passed
	 * @param [type] $added_product_id
	 * @return void
	 */
	public function only_one_in_cart( $passed, $added_product_id ) {
		wc_empty_cart();
		return $passed;
	}

	/**
	 * Return the Place Order Text
	 *
	 * @param string $label
	 * @return void
	 */
	public function checkout_button_text( $label = '' ){
		$label = __( 'Place order', 'lsx-health-plan' );
		return $label;
	}	

	/**
	 * Add the "Blog" link to the breadcrumbs
	 * @param $crumbs
	 * @return array
	 */
	public function breadcrumbs( $crumbs ) {
		
		if ( is_singular( 'plan' ) ) {
			
			$new_crumbs    = array();
			$new_crumbs[0] = $crumbs[0];

			$new_crumbs[1] = array(
				0 => get_the_title( wc_get_page_id( 'myaccount' ) ),
				1 => get_permalink( wc_get_page_id( 'myaccount' ) ),
			);

			$endpoint = get_query_var( 'endpoint' );
			if ( '' === $endpoint || false === $endpoint ) {
				$new_crumbs[2] = array(
					0 => get_the_title(),
					1 => false,
				);
			} else {
				$new_crumbs[2] = array(
					0 => get_the_title(),
					1 => get_permalink(),
				);
				$new_crumbs[3] = array(
					0 => ucwords( $endpoint ),
					1 => false,
				);
			}

			$crumbs = $new_crumbs;
		}
		return $crumbs;
	}

	/**
	 * Outputs the my account shortcode if its the edit account endpoint.
	 *
	 * @param string $content
	 * @return string
	 */
	public function edit_my_account( $content = '' ) {
		if ( is_wc_endpoint_url( 'edit-account' ) ) {
			$content = '<div id="edit-account-tab">[lsx_health_plan_my_profile_tabs][woocommerce_my_account]</div>';
		}
		return $content;
	}
}
