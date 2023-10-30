<?php
namespace eetplan_lsx_child\classes;
/**
 * Contains the downlaods functions post type
 *
 * @package eetplan_lsx_child
 */
class Woocommerce {
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \eetplan_lsx_child\classes\Woocommerce()
	 */
	protected static $instance = null;
	/**
	 * Contructor
	 */
	public function __construct() {
		//add_action( 'init', array( $this, 'init' ), 20, 1 );
		add_filter( 'iconic_account_fields', array( $this, 'go_get_account_fields' ) );
	}
	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \eetplan_lsx_child\classes\Woocommerce()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function go_get_account_fields() {
		return array(
			'go_ouderdom'  => array(
				'type'                 => 'text',
				'label'                => __( 'Ouderdom:', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
			'go_gewig'   => array(
				'type'                 => 'text',
				'label'                => __( 'Gewig:', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
			'go_geslag' => array(
				'type'                 => 'text',
				'label'                => __( 'Geslag:', 'lsx-health-plan' ),
				'hide_in_account'      => false,
				'hide_in_admin'        => false,
				'hide_in_checkout'     => false,
				'hide_in_registration' => false,
				'required'             => false,
			),
		);
	}
}
$woocommerce = new Woocommerce();