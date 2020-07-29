<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downlaods functions post type
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
	 * Contructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'only_one_in_cart' ), 99, 2 );
		add_filter( 'woocommerce_order_button_text', array( $this, 'checkout_button_text' ), 10, 1 );
		add_filter( 'woocommerce_get_breadcrumb', array( $this, 'breadcrumbs' ), 30, 1 );

		// Checkout.
		add_action( 'woocommerce_after_checkout_form', array( $this, 'payment_gateway_logos' ) );
		add_action( 'body_class', array( $this, 'hp_wc_add_body_classes' ) );
		add_action( 'lsx_nav_before', array( $this, 'hp_link_lsx_navbar_header' ), 99 );
		add_action( 'wp_head', array( $this, 'hp_simple_checkout' ), 99 );

		add_filter( 'wc_add_to_cart_message_html', '__return_false' );
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
	public function checkout_button_text( $label = '' ) {
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
				$endpoint_translation = \lsx_health_plan\functions\get_option( 'endpoint_' . $endpoint, false );
				if ( false !== $endpoint_translation && '' !== $endpoint_translation ) {
					$endpoint = $endpoint_translation;
				}
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
	 * Adding the 'Home' link to the checkout.
	 *
	 * @return void
	 */
	public function hp_link_lsx_navbar_header() {
		if ( is_checkout() ) {
			$home_ulr = '<nav class="checkout-navbar"><ul class="nav navbar-nav"><li><a href="' . home_url() . '">' . __( 'Home', 'lsx-health-plan' ) . '</a></li></ul></nav>';
			echo wp_kses_post( $home_ulr );
		}
	}

	/**
	 * Add 'lsx-simple-checkout' class to body if it is woocommerce checkout page.
	 *
	 * @param array $classes
	 * @return void
	 */
	public function hp_wc_add_body_classes( $classes = array() ) {
		global $post;
		if ( is_checkout() ) {
			$classes[] = 'lsx-hp-simple-checkout';
		}
		return $classes;
	}

	/**
	 * Remove unnecessary items for simple woocommerce checkout page.
	 *
	 * @param array $classes
	 * @return void
	 */
	public function hp_simple_checkout() {
		if ( is_checkout() ) {
			remove_action( 'lsx_footer_before', 'lsx_add_footer_sidebar_area' );
		}
	}

	/**
	 * Add Lets Enrypt and PayFast logos to cart.
	**/
	public function payment_gateway_logos() {
		$encript_image = LSX_HEALTH_PLAN_URL . 'assets/images/lets-encript.svg';
		$payfast_image = LSX_HEALTH_PLAN_URL . 'assets/images/payfast-footer-logo.svg';
		$payment_logos = LSX_HEALTH_PLAN_URL . 'assets/images/payment-logos.svg';
		$payment_logos_mobile = LSX_HEALTH_PLAN_URL . 'assets/images/payment-logos-mobile.svg';
		?>
		<div class="row text-center vertical-align lsx-full-width-base-small checkout-cta-bottom">
			<div class="col-md-12 img-payfast">
				<img src="<?php echo esc_url( $payfast_image ); ?>" alt="payfast"/>
			</div>
			<div class="col-md-12 img-payments hidden-xs">
				<img src="<?php echo esc_url( $payment_logos ); ?>" alt="payments"/>
			</div>
			<div class="col-md-12 img-payments hidden-sm hidden-md hidden-lg">
				<img src="<?php echo esc_url( $payment_logos_mobile ); ?>" alt="payments"/>
			</div>
			<div class="col-md-12 img-encrypt">
				<img src="<?php echo esc_url( $encript_image ); ?>" alt="lets_encrypt"/>
			</div>
		</div>

		<?php
	}
}
