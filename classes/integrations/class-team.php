<?php
namespace lsx_health_plan\classes;

/**
 * Contains the LSX_Team functions post type
 *
 * @package lsx-health-plan
 */
class LSX_Team {

	/**
	 * Holds class instance
	 *
	 * @var      object \lsx_health_plan\classes\LSX_Team()
	 */
	protected static $instance = null;

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
		add_action( 'cmb2_admin_init', array( $this, 'related_team_metabox' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\LSX_Team()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the related team member metabox and field configurations.
	 */
	public function related_team_metabox() {
		foreach ( $this->default_types as $type => $default_type ) {
			$cmb = new_cmb2_box(
				array(
					'id'           => $default_type . '_related_team_member__metabox',
					'title'        => __( 'Related Team Member', 'lsx-health-plan' ),
					'object_types' => array( $default_type ), // Post type.
					'context'      => 'normal',
					'priority'     => 'low',
					'show_names'   => true,
				)
			);

			$cmb->add_field(
				array(
					'name'       => __( 'Related Team Member', 'lsx-health-plan' ),
					'desc'       => __( 'Connect the related team member that applies to this ', 'lsx-health-plan' ) . $default_type,
					'id'         => $default_type . '_connected_team_member',
					'type'       => 'post_search_ajax',
					'limit'      => 4,  // Limit selection to X items only (default 1).
					'sortable'   => true, // Allow selected items to be sortable (default false).
					'query_args' => array(
						'post_type'      => array( 'team' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
				)
			);
		}

	}

}
