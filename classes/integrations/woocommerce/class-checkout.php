<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class Checkout {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Checkout()
	 */
	protected static $instance = null;

	/**
	 * @var string
	 */
	public $plan_id = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_order_button_text', array( $this, 'checkout_button_text' ), 10, 1 );

		// Cart Messages.
		add_action( 'lsx_content_wrap_before', array( $this, 'cart_notices' ) );
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'add_to_cart_message' ), 10, 3 );

		// Thank you page links.
		add_filter( 'woocommerce_memberships_thank_you_message', array( $this, 'memberships_thank_you_links' ), 10, 3 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integrations\woocommerce\Checkout()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Return the Place Order Text
	 *
	 * @param string $label
	 * @return void
	 */
	public function checkout_button_text( $label = '' ) {
		$label = __( 'Place order', 'lsx-health-plan' );
		return $label;
	}

	/**
	 * Saves the Plan ID to the cart data, so we can attach it to the order later.
	 *
	 * @param array $cart_item_data
	 * @param string $product_id
	 * @param string $variation_id
	 * @return void
	 */
	public function add_plan_id_to_cart( $cart_item_data, $product_id, $variation_id ) {
		$plan_id = filter_input( INPUT_GET, 'plan_id' );
		if ( empty( $plan_id ) || '' === $plan_id ) {
			return $cart_item_data;
		}
		$cart_item_data['plan_id'] = $plan_id;
		return $cart_item_data;
	}

	/**
	 * Output the WooCommerce Cart Notices.
	 *
	 * @return void
	 */
	public function cart_notices() {
		if ( function_exists( 'woocommerce_output_all_notices' ) && is_post_type_archive( 'plan' ) ) {
			echo wp_kses_post( '<div class="col-md-12 col-sm-12 woocommerce-notices-wrapper">' );
			wc_print_notices();
			echo wp_kses_post( '</div>' );
		}
	}

	/**
	 * Changes the add to cart message and adds our course name.
	 *
	 * @param  string  $message
	 * @param  array   $products
	 * @param  boolean $show_qty
	 * @return string
	 */
	public function add_to_cart_message( $message, $products, $show_qty ) {
		if ( isset( $_GET['plan_id'] ) ) { // @codingStandardsIgnoreLine.
			$this->plan_id = sanitize_text_field( wp_slash( $_GET['plan_id'] ) ); // @codingStandardsIgnoreLine.

			$title = '<strong>' . get_the_title( $this->plan_id ) . '</strong>';
			$title = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', 1, 'lsx-health-plan' ), $title );

			// Output success messages.
			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
				$message   = sprintf( '<a href="%s" tabindex="1" class="btn button wc-forward">%s</a> %s', esc_url( $return_to ), esc_html__( 'Continue shopping', 'lsx-health-plan' ), $title );
			} else {
				$message = sprintf( '<a href="%s" tabindex="1" class="btn button wc-forward">%s</a> %s', esc_url( wc_get_cart_url() ), esc_html__( 'View cart', 'lsx-health-plan' ), $title );
			}
		}
		return $message;
	}

	/**
	 * Replaces the links on the thank you page.
	 *
	 * @param string $message
	 * @param int $order_id
	 * @param object $memberships
	 * @return string
	 */
	public function memberships_thank_you_links( $message, $order_id, $memberships ) {
		$plan_slug = \lsx_health_plan\functions\get_option( 'my_plan_slug', false );
		if ( false !== $plan_slug && '' !== $plan_slug ) {
			$message = preg_replace( '/<a(.*)href="([^"]*)"(.*)>/', '<a$1href="' . home_url( $plan_slug ) . '"$3>', $message );
		}
		return $message;
	}
}
