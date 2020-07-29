<?php
namespace lsx_health_plan\classes;

/**
 * LSX Health Plan Frontend Class.
 *
 * @package lsx-health-plan
 */
class Frontend {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Frontend()
	 */
	protected static $instance = null;

	/**
	 * @var object \lsx_health_plan\classes\Endpoints();
	 */
	public $endpoints;

	/**
	 * @var object \lsx_health_plan\classes\Modals();
	 */
	public $modals;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ), 5 );

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-endpoints.php';
		$this->endpoints = Endpoints::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-modals.php';
		$this->modals = Modals::get_instance();

		require_once LSX_HEALTH_PLAN_PATH . 'classes/frontend/class-gallery.php';
		$this->gallery = frontend\Gallery::get_instance();

		if ( is_admin() ) {
			add_filter( 'lsx_customizer_colour_selectors_body', array( $this, 'customizer_body_colours_handler' ), 15, 2 );
		} else {
			add_action( 'body_class', array( $this, 'hp_add_body_classes' ) );
			// Handle the template redirects.
			add_filter( 'template_include', array( $this, 'archive_template_include' ), 99 );
			add_filter( 'template_include', array( $this, 'single_template_include' ), 99 );
			add_filter( 'template_include', array( $this, 'taxonomy_template_include' ), 99 );
			add_action( 'template_redirect', array( $this, 'redirect' ) );

			add_action( 'init', array( $this, 'handle_day_action' ), 100 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'wpkses_post_tags' ), 100, 2 );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Frontend()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Registers the plugin frontend assets
	 *
	 * @return void
	 */
	public function assets() {
		wp_enqueue_style( 'lsx-health-plan', LSX_HEALTH_PLAN_URL . 'assets/css/lsx-health-plan.css', array(), LSX_HEALTH_PLAN_VER );
		wp_style_add_data( 'lsx-health-plan', 'rtl', 'replace' );
		wp_enqueue_script( 'lsx-health-plan-scripts', LSX_HEALTH_PLAN_URL . 'assets/js/src/lsx-health-plan-admin.js', array( 'jquery' ) );
	}

	/**
	 * Handle body colours that might be change by LSX Customizer.
	 */
	public function customizer_body_colours_handler( $css, $colors ) {
		$css .= '
			@import "' . LSX_HEALTH_PLAN_PATH . '/assets/css/scss/partials/customizer-health-plan-body-colours";

			/**
			 * LSX Customizer - Body (LSX Health Plan)
			 */
			@include customizer-health-plan-body-colours (
				$bg: 		' . $colors['background_color'] . ',
				$breaker: 	' . $colors['body_line_color'] . ',
				$color:    	' . $colors['body_text_color'] . ',
				$link:    	' . $colors['body_link_color'] . ',
				$hover:    	' . $colors['body_link_hover_color'] . ',
				$small:    	' . $colors['body_text_small_color'] . '
			);
		';

		return $css;
	}

	/**
	 * Archive template.
	 */
	public function archive_template_include( $template ) {
		$applicable_post_types = apply_filters( 'lsx_health_plan_archive_template', array() );
		if ( ! empty( $applicable_post_types ) && is_main_query() && is_post_type_archive( $applicable_post_types ) ) {
			$post_type = get_post_type();
			if ( empty( locate_template( array( 'archive-' . $post_type . '.php' ) ) ) && file_exists( LSX_HEALTH_PLAN_PATH . 'templates/archive-' . $post_type . '.php' ) ) {
				$template = LSX_HEALTH_PLAN_PATH . 'templates/archive-' . $post_type . '.php';
			}
		}
		return $template;
	}

	/**
	 * Add body classes to body.
	 *
	 * @param array $classes
	 * @return void
	 */
	public function hp_add_body_classes( $classes = array() ) {
		global $post;

		if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'lsx_health_plan_my_profile_block' ) ) {
			$classes[] = 'my-plan-shortcode';
		}

		if ( is_single() && is_singular( 'plan' ) ) {
			$args = array(
				'post_parent' => get_the_ID(),
				'post_type'   => 'plan',
			);

			$post_id      = get_the_ID();
			$has_children = get_children( $args );
			$has_parent   = wp_get_post_parent_id( $post_id );

			if ( ! empty( $has_children ) ) {
				$plan_type_class = 'parent-plan-page';
				if ( 0 !== $has_parent ) {
					$plan_type_class = 'parent-sub-plan-page';
				}
			} else {
				$plan_type_class = 'unique-plan-page';
				if ( 0 !== $has_parent ) {
					$plan_type_class = 'child-plan-page';
				}
			}
			$classes[] = $plan_type_class;
		}
		return $classes;
	}

	/**
	 * Single template.
	 */
	public function single_template_include( $template ) {
		$applicable_post_types = apply_filters( 'lsx_health_plan_single_template', array() );
		if ( ! empty( $applicable_post_types ) && is_main_query() && is_singular( $applicable_post_types ) ) {
			$post_type = get_post_type();
			if ( empty( locate_template( array( 'single-' . $post_type . '.php' ) ) ) && file_exists( LSX_HEALTH_PLAN_PATH . 'templates/single-' . $post_type . '.php' ) ) {
				$template = LSX_HEALTH_PLAN_PATH . 'templates/single-' . $post_type . '.php';
			}
		}
		return $template;
	}

	/**
	 * Redirect WordPress to the taxonomy located in the plugin
	 *
	 * @param     $template string
	 * @return    string
	 */
	public function taxonomy_template_include( $template ) {
		$applicable_taxonomies = apply_filters( 'lsx_health_plan_taxonomies_template', array() );
		if ( is_main_query() && is_tax( $applicable_taxonomies ) ) {
			$current_taxonomy = get_query_var( 'taxonomy' );
			if ( '' === locate_template( array( 'taxonomy-' . $current_taxonomy . '.php' ) ) && file_exists( LSX_HEALTH_PLAN_PATH . 'templates/taxonomy-' . $current_taxonomy . '.php' ) ) {
				$template = LSX_HEALTH_PLAN_PATH . 'templates/taxonomy-' . $current_taxonomy . '.php';
			}
		}
		return $template;
	}

	/**
	 * Redirect the user from the cart or checkout page if they have purchased the product already.
	 *
	 * @return void
	 */
	public function redirect() {
		if ( ! is_user_logged_in() || ! function_exists( 'wc_get_page_id' ) || is_home() ) {
			return;
		}
		if ( lsx_health_plan_user_has_purchase() && ( is_page( wc_get_page_id( 'cart' ) ) || is_page( wc_get_page_id( 'checkout' ) ) ) ) {
			wp_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) );
			die;
		}

		$product_id = \lsx_health_plan\functions\get_option( 'membership_product', false );
		if ( false !== $product_id && is_single( $product_id ) ) {
			wp_redirect( home_url() );
			die;
		}
	}

	/**
	 * Registers the rewrites.
	 */
	public function handle_day_action() {
		if ( isset( $_POST['lsx-health-plan-actions'] ) && wp_verify_nonce( $_POST['lsx-health-plan-actions'], 'complete' ) ) {
			update_user_meta( get_current_user_id(), 'day_' . sanitize_key( $_POST['lsx-health-plan-id'] ) . '_complete', true );
			wp_safe_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) );
		}

		if ( isset( $_POST['lsx-health-plan-actions'] ) && wp_verify_nonce( $_POST['lsx-health-plan-actions'], 'unlock' ) ) {
			delete_user_meta( get_current_user_id(), 'day_' . sanitize_key( $_POST['lsx-health-plan-id'] ) . '_complete' );
		}
	}

	/**
	 * Registers the rewrites.
	 */
	public function wpkses_post_tags( $tags, $context ) {
		if ( 'post' === $context ) {
			$tags['iframe'] = array(
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
			);
		}
		return $tags;
	}
}
