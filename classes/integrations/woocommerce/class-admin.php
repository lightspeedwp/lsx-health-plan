<?php
namespace lsx_health_plan\classes\integrations\woocommerce;

/**
 * Contains the downloads functions post type
 *
 * @package lsx-health-plan
 */
class Admin {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\integrations\woocommerce\Admin()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'products_metaboxes' ), 5 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\integrations\woocommerce\Admin()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the product metabox on the plan post type
	 */
	public function products_metaboxes() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'plan_product_metabox',
				'title'        => __( 'Products', 'lsx-health-plan' ),
				'object_types' => array( 'plan' ), // Post type.
				'context'      => 'side',
				'priority'     => 'low',
				'show_names'   => true,
			)
		);

		$cmb->add_field(
			array(
				'name'       => __( 'Search your products', 'lsx-health-plan' ),
				'desc'       => __( 'Connect the product(s) which sell access to this plan.', 'lsx-health-plan' ),
				'id'         => 'plan_product',
				'type'       => 'post_search_ajax',
				'limit'      => 5,  // Limit selection to X items only (default 1).
				'sortable'   => false, // Allow selected items to be sortable (default false).
				'query_args' => array(
					'post_type'      => 'product',
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
	}
}
