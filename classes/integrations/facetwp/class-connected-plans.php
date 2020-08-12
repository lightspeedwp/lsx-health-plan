<?php
namespace lsx_health_plan\classes\integrations\facetwp;

/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class Connected_Plans {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\facetwp\Connected_Plans()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		//add_filter( 'facetwp_index_row', array( $this, 'facetwp_index_row' ), 10, 2 );
		add_filter( 'facetwp_indexer_post_facet', array( $this, 'facetwp_indexer_post_facet' ), 10, 2 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integration\facetwp\Connected_Plans()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Index the connected plan
	 *
	 * @param array $return
	 * @param array $params
	 * @return array
	 */
	public function facetwp_indexer_post_facet( $return, $params ) {
		$facet    = $params['facet'];
		$source   = isset( $facet['source'] ) ? $facet['source'] : '';

		if ( 'lsx_hp/connected_plans' === $source ) {
			$post_type = get_post_type( $params['defaults']['post_id'] );
			switch ( $post_type ) {
				case 'workout':
					break;

				case 'exercise':
					break;

				case 'recipe':
					$return = $this->index_recipe( $params['defaults'] );
					break;

				case 'meal':
					break;

				default:
					break;
			}
		}

		return $return;
	}

	/**
	 * Adds the connected plan to the list of rows.
	 *
	 * @param array $rows
	 * @param array $params
	 * @return void
	 */
	public function index_recipe( $row ) {
		$indexed         = false;
		$top_level_plans = array();
		// Get meals this exercise is connected to.
		$plans = get_post_meta( $row['post_id'], 'connected_plans', true );

		if ( ! empty( $plans ) ) {
			$plan       = end( $plans );
			$has_parent = wp_get_post_parent_id( $plan );
			if ( 0 === $has_parent ) {
				$top_level_plans[] = $plan;
			} elseif ( false !== $top_level_plans ) {
				$top_level_plans[] = $has_parent;
			}
		}
		if ( ! empty( $top_level_plans ) && ( '' !== $top_level_plans ) ) {
			$top_level_plans = array_unique( $top_level_plans );
			$indexed         = true;
			foreach ( $top_level_plans as $plan_id ) {
				$row['facet_value']         = $plan_id;
				$row['facet_display_value'] = get_the_title( $plan_id );
				FWP()->indexer->index_row( $row );
			}
		}
		return $indexed;
	}
}
