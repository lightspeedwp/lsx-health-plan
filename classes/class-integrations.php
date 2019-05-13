<?php
namespace lsx_health_plan\classes;
/**
 * Contains all the classes for 3rd party Integrations
 *
 * @package lsx-health-plan
 */
class Integrations {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Integrations()
	 */
	protected static $instance = null;

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \MAG_CMB2_Field_Post_Search_Ajax()
	 */
	public $cmb2_post_search_ajax = false;	

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'cmb2_post_search_ajax' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Integrations()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Includes the Post Search Ajax if it is there.
	 *
	 * @return void
	 */
	public function cmb2_post_search_ajax() {
		if ( class_exists( 'CMB2_Bootstrap_260' ) ) {
			require_once( LSX_HEALTH_PLAN_PATH . 'vendor/cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php' );
			$mag_cmb2_field_post_search_ajax = new \MAG_CMB2_Field_Post_Search_Ajax();
		}
	}
}
