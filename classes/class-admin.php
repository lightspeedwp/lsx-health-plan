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
	 * Stores the previous values needed to remove the post relations
	 *
	 * @var array
	 */
	public $previous_values = array();

	/**
	 * @var object \lsx_health_plan\classes\Settings();
	 */
	public $settings;	

	/**
	 * Contructor
	 */
	public function __construct() {
		require_once( LSX_HEALTH_PLAN_PATH . 'classes/class-settings.php' );
		$this->settings = Settings::get_instance();

		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'cmb2_override_meta_save', array( $this, 'save_previous_values' ), 4, 20 );
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
	 * Saves the previous values before they are overwritten by the new ones.
	 *
	 * @param [type] $value_to_save
	 * @param [type] $a
	 * @param [type] $args
	 * @param [type] $cmb2
	 * @return void
	 */
	public function save_previous_values( $value_to_save, $a, $args, $cmb2 ) {		
		if ( array_key_exists( $a['field_id'], $connections ) ) {
			//Get the previous values if the field, so we can run through them and remove the current ID from them later.
			$this->previous_values = get_post_meta( $a['id'], $a['field_id'] );
		}
		return $value_to_save;
	}

	/**
	 * Sets up the "post relations"
	 *
	 * @return    void
	 */
	public function post_relations( $field_id, $updated, $action, $cmb2 ) {
		//If the connections are empty then skip this function
		$connections = $this->get_connections();
		if ( empty( $connections ) ) {
			return;
		}	
	
		//If the field has been updated.
		$post_type = get_post_type( $cmb2->data_to_save['ID'] );
		if ( isset( $connections[ $post_type ] ) && array_key_exists( $field_id, $connections[ $post_type ] ) ) {
			$saved_values = get_post_meta( $cmb2->data_to_save['ID'], $field_id, true );
			if ( 'updated' === $action ) {
				$this->add_connected_posts( $saved_values, $cmb2->data_to_save['ID'], $connections[ $post_type ][ $field_id ] );
			} else if ( 'removed' === $action ) {
				$posts_to_remove = array_intersect( $saved_values, $this->previous_values );
				$this->remove_connected_posts( $posts_to_remove, $cmb2->data_to_save['ID'], $connections[ $post_type ][ $field_id ] );
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

		foreach ( $values as $value ) {
			$current_post_array = get_post_meta( $value, $connected_key, true );		
			$new_array = array();

			//Loop through only if the current ID has been saved against the post.
			if ( in_array( $current_ID, $current_post_array ) ) {
				
				//Loop through all the connected saved IDS and 
				foreach ( $current_post_array as $cpa ) {
					if ( $cpa !== $current_ID ) {
						$new_array[] = $cpa;
					}
				}				
				if ( ! empty( $new_array ) ) {			
					update_post_meta( $value, $connected_key, $new_array, $current_post_array );
				} else {
					delete_post_meta( $value, $connected_key );
				}
			}
		}	
	}
}
