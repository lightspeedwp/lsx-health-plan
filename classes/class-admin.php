<?php
namespace lsx_health_plan\classes;
/**
 * LSX Health Plan Admin Class.
 *
 * @package lsx-health-plan
 */
class Admin {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Admin()
	 */
	protected static $instance = null;

	/**
	 * The post relation fields
	 *
	 * @var array
	 */
	public $connections = array();	

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'cmb2_save_field', array( $this, 'post_relations' ), 3, 20 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx\member_directory\classes\Admin()    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function assets() {
		//wp_enqueue_media();
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );

		wp_enqueue_script( 'lsx-health-plan-admin', LSX_HEALTH_PLAN_URL . 'assets/js/lsx-health-plan-admin.min.js', array( 'jquery' ), LSX_HEALTH_PLAN_VER, true );
		wp_enqueue_style( 'lsx-health-plan-admin', LSX_HEALTH_PLAN_URL . 'assets/css/lsx-health-plan-admin.css', array(), LSX_HEALTH_PLAN_VER );
	}

	public function get_connections() {
		return apply_filters( 'lsx_health_plan_connections', $this->connections );
	}

	/**
	 * Sets up the "post relations"
	 *
	 * @return    void
	 */

	//$field_id, $updated, $action, $this
	public function post_relations( $field_id, $updated, $action, $cmb2 ) {
		//If the connections are empty then skip this function
		$connections = $this->get_connections();
		if ( empty( $connections ) ) {
			return;
		}

		//If the field has been updated.
		if ( ( 1 === $updated || true === $updated ) && ( 'updated' === $action ) ) {
			
		}

		print_r('<pre>');
		print_r($field_id);
		print_r($updated);
		print_r($action);
		print_r($cmb2);
		print_r('</pre>');
		
		/*if ( 'group' === $field['type'] && isset( $this->single_fields ) && array_key_exists( $field['id'], $this->single_fields ) ) {
			$delete_counter = array();

			foreach ( $this->single_fields[ $field['id'] ] as $fields_to_save ) {
				$delete_counter[ $fields_to_save ] = 0;
			}

			//Loop through each group in case of repeatable fields
			$relations          = false;
			$previous_relations = false;

			foreach ( $value as $group ) {
				//loop through each of the fields in the group that need to be saved and grab their values.
				foreach ( $this->single_fields[ $field['id'] ] as $fields_to_save ) {
					//Check if its an empty group
					if ( isset( $group[ $fields_to_save ] ) && ! empty( $group[ $fields_to_save ] ) ) {
						if ( $delete_counter[ $fields_to_save ] < 1 ) {
							//If this is a relation field, then we need to save the previous relations to remove any items if need be.
							if ( in_array( $fields_to_save, $this->connections ) ) {
								$previous_relations[ $fields_to_save ] = get_post_meta( $post_id, $fields_to_save, false );
							}

							delete_post_meta( $post_id, $fields_to_save );
							$delete_counter[ $fields_to_save ] ++;
						}

						//Run through each group
						foreach ( $group[ $fields_to_save ] as $field_value ) {
							if ( null !== $field_value ) {
								if ( 1 === $field_value ) {
									$field_value = true;
								}

								add_post_meta( $post_id, $fields_to_save, $field_value );

								//If its a related connection the save that
								if ( in_array( $fields_to_save, $this->connections ) ) {
									$relations[ $fields_to_save ][ $field_value ] = $field_value;
								}
							}
						}
					}
				}
			}//end of the repeatable group foreach

			//If we have relations, loop through them and save the meta
			if ( false !== $relations ) {
				foreach ( $relations as $relation_key => $relation_values ) {
					$temp_field = array(
						'id' => $relation_key,
					);

					$this->save_related_post( $post_id, $temp_field, $relation_values, $previous_relations[ $relation_key ] );
				}
			}
		} else {
			if ( in_array( $field['id'], $this->connections ) ) {
				$this->save_related_post( $post_id, $field, $value );
			}
		}*/
	}

	/**
	 * Save the reverse post relation.
	 *
	 * @return    null
	 */
	public function save_related_post( $post_id, $field, $value, $previous_values = false ) {
		$ids = explode( '_to_', $field['id'] );
		$relation = $ids[1] . '_to_' . $ids[0];

		if ( in_array( $relation, $this->connections ) ) {
			if ( false === $previous_values ) {
				$previous_values = get_post_meta( $post_id, $field['id'], false );
			}

			if ( false !== $previous_values && ! empty( $previous_values ) ) {
				foreach ( $previous_values as $tr ) {
					delete_post_meta( $tr, $relation, $post_id );
				}
			}

			if ( is_array( $value ) ) {
				foreach ( $value as $v ) {
					if ( '' !== $v && null !== $v && false !== $v ) {
						add_post_meta( $v, $relation, $post_id );
					}
				}
			}
		}
	}	

}
