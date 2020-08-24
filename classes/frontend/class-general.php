<?php
namespace lsx_health_plan\classes\frontend;

/**
 * Holds the functions and actions which are shared accross the post types.
 *
 * @package lsx-health-plan
 */
class General {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\frontend\General()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'body_class', array( $this, 'body_classes' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\frontend\General()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add body classes to body.
	 *
	 * @param array $classes
	 * @return void
	 */
	public function body_classes( $classes = array() ) {
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
}
