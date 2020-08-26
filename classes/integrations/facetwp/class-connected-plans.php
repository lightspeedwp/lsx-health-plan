<?php
namespace lsx_health_plan\classes\integrations\facetwp;

/**
 * Contains the downloads functions post type
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
	 * This hold the current plan IDS, in case they need to be used in additional functions.
	 *
	 * @var array
	 */
	public $current_plan_ids = array();

	/**
	 * Constructor
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
					$return = $this->index_connected_plans( $params['defaults'] );
					$this->index_exercises( $params['defaults'] );
					break;

				case 'recipe':
					$return = $this->index_connected_plans( $params['defaults'] );
					break;

				case 'meal':
					$return = $this->index_connected_plans( $params['defaults'] );
					break;

				default:
					break;
			}
		}

		// Reset the current plan ids array.
		$this->current_plan_ids = array();
		return $return;
	}

	/**
	 * Adds the connected plan to the list of rows.
	 *
	 * @param array $rows
	 * @param array $params
	 * @return boolean
	 */
	public function index_connected_plans( $row ) {
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
			$top_level_plans        = array_unique( $top_level_plans );
			$this->current_plan_ids = $top_level_plans;
			$indexed                = true;
			foreach ( $top_level_plans as $plan_id ) {
				$row['facet_value']         = $plan_id;
				$row['facet_display_value'] = get_the_title( $plan_id );
				FWP()->indexer->index_row( $row );
			}
		}
		return $indexed;
	}

	/**
	 * We index the exercises from the workouts.
	 *
	 * @param array $rows
	 * @param array $params
	 * @return void
	 */
	public function index_exercises( $row ) {
		if ( empty( $this->current_plan_ids ) ) {
			return;
		}
		$i                  = 1;
		$section_counter    = 6;
		$unique_connections = array();

		while ( $i <= $section_counter ) {
			// Here we grab the exercises and we add them to the index with the plan IDS.
			$groups = get_post_meta( $row['post_id'], 'workout_section_' . $i, true );
			if ( ! empty( $groups ) ) {
				foreach ( $groups as $group ) {
					if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] ) {

						if ( ! is_array( $group['connected_exercises'] ) ) {
							$group['connected_exercises'] = array( $group['connected_exercises'] );
						}

						// Loop through each exercise and add it to the plan.
						foreach ( $group['connected_exercises'] as $eid ) {
							$exercise_default            = $row;
							$exercise_default['post_id'] = $eid;

							foreach ( $this->current_plan_ids as $plan_id ) {
								// Check to see if this connection has been added already.
								if ( isset( $unique_connections[ $eid . '_' . $plan_id ] ) ) {
									continue;
								}

								$title = get_the_title( $plan_id );
								if ( ! empty( $title ) ) {
									$exercise_default['facet_value']             = $plan_id;
									$exercise_default['facet_display_value']     = $title;
									$unique_connections[ $eid . '_' . $plan_id ] = $exercise_default;
								}
							}
						}
					}
				}
			}
			$i++;
		}

		// If we have some unique connections, we index them.
		if ( ! empty( $unique_connections ) ) {
			foreach ( $unique_connections as $unique_row ) {
				FWP()->indexer->index_row( $unique_row );
			}
		}
	}
}
