<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\My_Plans().
 */
class Plan {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\My_Plans()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_my-plans_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\My_Plans()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Registers the general settings.
	 *
	 * @param object $cmb new_cmb2_box().
	 * @return void
	 */
	public function settings( $cmb ) {
		$cmb->add_field(
			array(
				'name'        => __( 'Plan Filters', 'lsx-health-plan' ),
				'id'          => 'plan_filters_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Toggle the display of the tab filters on the post type archive.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'before_row'  => '<h4><b><u>URL Slug Options</u></b></h4><p style="font-style: italic;">If you need to translate the custom slug for this custom post type, do so below.</p>',
				'name'        =>  __( 'My Plan Slug', 'lsx-health-plan' ),
				'description' => __( 'This will be the slug url for redirecting users after login, use the login page slug.', 'lsx-health-plan' ),
				'id'          => 'my_plan_slug',
				'type'        => 'select',
				'default'     => 'my-plan',
				'options'     => $this->get_page_options(),
			)
		);

		$cmb->add_field(
			array(
				'before_row'  => '<h4><b><u>Default Options</u></b></h4>',
				'name'        => __( 'Recipe', 'lsx-health-plan' ),
				'description' => __( 'Set a default recipe.', 'lsx-health-plan' ),
				'limit'       => 1,
				'id'          => 'connected_recipes',
				'type'        => 'post_search_ajax',
			)
		);

		$cmb->add_field(
			array(
				'name'    =>  __( 'Single Plan Slug', 'lsx-health-plan' ),
				'id'      => 'plan_single_slug',
				'type'    => 'input',
				'value'   => '',
				'default' => 'plan',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Plans Archive Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_plan_archive',
				'type'    => 'input',
				'value'   => '',
				'default' => 'plans',
			)
		);

		$cmb->add_field(
			array(
				'before_row' => '<h4><b><u>My Stats Options</u></b></h4>',
				'name'       => __( 'Disable All Stats', 'lsx-health-plan' ),
				'desc'       => 'Disable All Stats',
				'id'         => 'disable_all_stats',
				'type'       => 'checkbox',
				'value'      => 1,
				'default'    => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Weight', 'lsx-health-plan' ),
				'id'      => 'disable_weight_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Height', 'lsx-health-plan' ),
				'id'      => 'disable_height_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'    => __( 'Disable Waist', 'lsx-health-plan' ),
				'id'      => 'disable_waist_checkbox',
				'type'    => 'checkbox',
				'value'   => 1,
				'default' => 0,
			)
		);
		$cmb->add_field(
			array(
				'name'      => __( 'Disable BMI', 'lsx-health-plan' ),
				'id'        => 'disable_bmi_checkbox',
				'type'      => 'checkbox',
				'value'     => 1,
				'default'   => 0,
				'after_row' => __( '<p style="font-style: italic;">If you have changed any URL slugs, please remember re-save your permalinks in Settings > Permalinks.</p>', 'lsx-health-plan' ),
			)
		);
	}

	public function get_page_options() {
		$query_args = array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'fields'         => array( 'ids' ),
		);
		$options = array(
			'' => __( 'Select a page', 'lsx-health-plan' ),
		);
		$page_query = new \WP_Query( $query_args );
		if ( $page_query->have_posts() ) {
			foreach ( $page_query->posts as $pid ) {
				$title       = get_the_title( $pid );
				$key         = sanitize_title( $title );
				$options[ $key ] = $title;
			}
		}
		return $options;
	}
}
Plan::get_instance();
