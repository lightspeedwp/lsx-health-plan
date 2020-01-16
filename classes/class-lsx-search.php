<?php
namespace lsx_health_plan\classes;

/**
 * Contains the downlaods functions post type
 *
 * @package lsx-health-plan
 */
class LSX_Search {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\Woocommerce()
	 */
	protected static $instance = null;

	/**
	 * An array of the active post types.
	 *
	 * @var array
	 */
	public $post_types = array();

	/**
	 * This holds the current facet info.
	 *
	 * @var array
	 */
	public $facet_data = array();

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page', array( $this, 'register_settings' ), 9, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\Woocommerce()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Sets the FacetWP variables.
	 */
	public function set_facetwp_vars() {
		if ( function_exists( '\FWP' ) ) {
			$facet_data = \FWP()->helper->get_facets();
		}

		$this->facet_data = array();

		$this->facet_data['search_form'] = esc_html__( 'Search Form', 'lsx-search' );
		if ( ! empty( $facet_data ) && is_array( $facet_data ) ) {
			foreach ( $facet_data as $facet ) {
				$this->facet_data[ $facet['name'] ] = $facet['label'];
			}
		}
	}

	/**
	 * Registers the lsx_search_settings
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function register_settings( $cmb ) {
		$this->set_facetwp_vars();
		$cmb->add_field(
			array(
				'id'          => 'lsx_search_settings_title',
				'type'        => 'title',
				'name'        => __( 'LSX Search Settings', 'lsx-health-plan' ),
				'description' => __( 'Enable search functionality on the recipe archive.', 'lsx-health-plan' ),
			)
		);
		if ( post_type_exists( 'recipe' ) ) {
			$cmb->add_field(
				array(
					'name'    => __( 'Enable Search', 'lsx-health-plan' ),
					'id'      => 'recipe_search_enable',
					'type'    => 'checkbox',
					'value'   => 1,
					'default' => 0,
				)
			);
			$cmb->add_field(
				array(
					'name'    => __( 'Layout', 'lsx-health-plan' ),
					'id'      => 'recipe_search_layout',
					'type'    => 'select',
					'options' => array(
						''    => __( 'Follow the theme layout', 'lsx-health-plan' ),
						'1c'  => __( '1 column', 'lsx-health-plan' ),
						'2cr' => __( '2 columns / Content on right', 'lsx-health-plan' ),
						'2cl' => __( '2 columns / Content on left', 'lsx-health-plan' ),
					),
					'default' => '',
				)
			);
			$cmb->add_field(
				array(
					'name'    => __( 'Disable per page', 'lsx-health-plan' ),
					'id'      => 'recipe_search_disable_per_page',
					'type'    => 'checkbox',
					'value'   => 1,
					'default' => 0,
				)
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Collapse', 'lsx-health-plan' ),
					'id'          => 'recipe_search_enable_collapse',
					'type'        => 'checkbox',
					'value'       => 1,
					'description' => __( 'Enable collapsible filters on search results', 'lsx-health-plan' ),
					'default'     => 0,
				)
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Disable Sorting', 'lsx-health-plan' ),
					'id'          => 'recipe_search_disable_all_sorting',
					'type'        => 'checkbox',
					'value'       => 1,
					'description' => __( 'Disables the sort by dropdown.', 'lsx-health-plan' ),
					'default'     => 0,
				)
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Disable the date option', 'lsx-health-plan' ),
					'id'          => 'recipe_search_disable_date_sorting',
					'type'        => 'checkbox',
					'value'       => 1,
					'description' => __( 'Disables the date option for the sort by dropdown.', 'lsx-health-plan' ),
					'default'     => 0,
				)
			);
			$cmb->add_field(
				array(
					'name'    => __( 'Display Result Count', 'lsx-health-plan' ),
					'id'      => 'recipe_search_display_result_count',
					'type'    => 'checkbox',
					'value'   => 1,
					'default' => 1,
				)
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Display Clear Button', 'lsx-health-plan' ),
					'id'          => 'recipe_search_display_clear_button',
					'type'        => 'checkbox',
					'value'       => 1,
					'description' => __( 'This will display a clear button next to the "result" count.', 'lsx-health-plan' ),
					'default'     => 1,
				)
			);

			$cmb->add_field(
				array(
					'name'        => __( 'Facets', 'lsx-health-plan' ),
					'description' => __( 'These are the filters that will appear on your archive page.', 'lsx-health-plan' ),
					'id'          => 'recipe_search_facets',
					'type'        => 'multicheck',
					'options'     => $this->facet_data,
				)
			);
		}
	}
}
