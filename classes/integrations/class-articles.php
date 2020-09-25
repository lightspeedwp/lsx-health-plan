<?php
namespace lsx_health_plan\classes;

/**
 * Contains the related articles functions post type
 *
 * @package lsx-health-plan
 */
class Articles {

	/**
	 * Holds class instance
	 *
	 * @var      object \lsx_health_plan\classes\Articles()
	 */
	protected static $instance = null;

	/**
	 * An array of the post types for the Global Defaults field.
	 *
	 * @var array
	 */
	//public $default_types = array( 'exercise', 'recipe', 'meal', 'workout', 'plan' );

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->default_types = array(
			\lsx_health_plan\functions\get_option( 'endpoint_meal', 'meal' ),
			\lsx_health_plan\functions\get_option( 'endpoint_exercise_single', 'exercise' ),
			\lsx_health_plan\functions\get_option( 'endpoint_recipe_single', 'recipe' ),
			\lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' ),
			\lsx_health_plan\functions\get_option( 'endpoint_plan', 'plan' ),
		);
		add_action( 'cmb2_admin_init', array( $this, 'related_articles_metabox' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Articles()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the related articles member metabox and field configurations.
	 */
	public function related_articles_metabox() {
		foreach ( $this->default_types as $type => $default_type ) {
			$cmb = new_cmb2_box(
				array(
					'id'           => $default_type . '_related_articles_metabox',
					'title'        => __( 'Related Articles', 'lsx-health-plan' ),
					'object_types' => array( $default_type ), // Post type.
					'context'      => 'normal',
					'priority'     => 'low',
					'show_names'   => true,
				)
			);

			$cmb->add_field(
				array(
					'name'       => __( 'Related Articles', 'lsx-health-plan' ),
					'desc'       => __( 'Connect the related articles that applies to this ', 'lsx-health-plan' ) . $default_type,
					'id'         => $default_type . '_connected_articles',
					'type'       => 'post_search_ajax',
					'limit'      => 3,
					'sortable'   => true,
					'query_args' => array(
						'post_type'      => array( 'post' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => 3,
					),
				)
			);
		}

	}

}
