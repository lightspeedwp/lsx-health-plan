<?php
namespace lsx_health_plan\classes;
/**
 * Contains all the classes for 3rd party Integrations
 *
 * @package lsx-health-plan
 */
class Integrations {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Integrations()
	 */
	protected static $instance = null;

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \MAG_CMB2_Field_Post_Search_Ajax()
	 */
	public $cmb2_post_search_ajax = false;	

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'cmb2_post_search_ajax' ) );
		add_action( 'init', array( $this, 'download_monitor_init' ) );

		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'only_one_in_cart' ), 99, 2 );
		add_filter( 'woocommerce_order_button_text', array( $this, 'checkout_button_text' ), 10, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Integrations()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Includes the Post Search Ajax if it is there.
	 *
	 * @return void
	 */
	public function cmb2_post_search_ajax() {
		if ( class_exists( 'CMB2_Bootstrap_260' ) ) {
			require_once( LSX_HEALTH_PLAN_PATH . 'vendor/lsx-field-post-search-ajax/cmb-field-post-search-ajax.php' );
			$mag_cmb2_field_post_search_ajax = new \MAG_CMB2_Field_Post_Search_Ajax();	
		}
	}

	/**
	 * Includes the Post Search Ajax if it is there.
	 *
	 * @return void
	 */
	public function download_monitor_init() {
		if ( function_exists( 'download_monitor' ) ) {
			require_once( LSX_HEALTH_PLAN_PATH . 'classes/class-downloads.php' );
			$this->download_monitor = Downloads::get_instance();	
		}
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
}
