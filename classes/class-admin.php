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
		add_action( 'cmb2_save_field', array( $this, 'post_relations' ), 4, 20 );
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
		if ( empty( $connections ) || empty( $updated ) ) {
			return;
		}			
	
		//If the field has been updated.
		if ( array_key_exists( $field_id, $connections ) ) {
			$saved_values = get_post_meta( $cmb2->data_to_save['ID'], $field_id, true );
			if ( 'updated' === $action ) {
				$this->add_connected_posts( $saved_values, $cmb2->data_to_save['ID'], $connections[ $field_id ] );
			} else if ( 'removed' === $action ) {

			}
		}
	}

	/**
	 * Updates the connected posts witht he current post ID
	 *
	 * @param [type] $values
	 * @param [type] $current_ID
	 * @param [type] $connected_key
	 * @return void
	 */
	public function add_connected_posts( $values, $current_ID, $connected_key ) {
		foreach ( $values as $value ) {
			$current_post_array = get_post_meta( $value, $connected_key, true );
			$previous_values = $current_post_array;
			//If the current connected post has no saved connections then we create it.
			if ( false === $current_post_array || empty( $current_post_array ) ) {
				$current_post_array = array( $current_ID );
			} else if ( ! in_array( $current_ID, $current_post_array ) ) {
				$current_post_array[] = $current_ID;
			}

			//Check if the values are empty, if not update them.
			if ( ! empty( $current_post_array ) ) {
				update_post_meta( $value, $connected_key, $current_post_array, $previous_values );
			}
		}
	}

	/**
	 * Removes the post ID from the connected posts.
	 *
	 * @param [type] $values
	 * @param [type] $current_ID
	 * @param [type] $connected_key
	 * @return void
	 */
	public function remove_connected_posts( $values, $current_ID, $connected_key ) {
		
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
