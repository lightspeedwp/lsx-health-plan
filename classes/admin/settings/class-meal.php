<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Meal().
 */
class Meal {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Meal()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_meal_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Meal()    A single instance of this class.
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
				'name'        => __( 'Disable Meals', 'lsx-health-plan' ),
				'id'          => 'meal_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable meal post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'id'          => 'meal_archive_description',
				'type'        => 'wysiwyg',
				'name'        => __( 'Archive Description', 'lsx-health-plan' ),
				'description' => __( 'This will show up on the post type archive.', 'lsx-health-plan' ),
				'options'     => array(
					'textarea_rows' => get_option('default_post_edit_rows', 6),
				),
			)
		);

		$cmb->add_field(
			array(
				'name'    => __( 'Your Meal Plan Intro', 'lsx-health-plan' ),
				'id'      => 'meal_plan_intro',
				'type'    => 'textarea_small',
				'value'   => '',
				'default' => __( 'Get the right mix of nutrients to keep muscles strong & healthy.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'before_row' => '<h4><b><u>URL Slug Options</u></b></h4><p style="font-style: italic;">If you need to translate the custom slug for this custom post type, do so below.</p>',
				'name'       =>  __( 'Meal Slug', 'lsx-health-plan' ),
				'id'         => 'endpoint_meal',
				'type'       => 'input',
				'value'      => '',
				'default'    => 'meal',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Meals Archive Slug', 'lsx-health-plan' ),
				'id'      => 'endpoint_meal_archive',
				'type'    => 'input',
				'value'   => '',
				'default' => 'meals',
			)
		);
		$cmb->add_field(
			array(
				'name'    =>  __( 'Single Meal Slug', 'lsx-health-plan' ),
				'id'      => 'meal_single_slug',
				'type'    => 'input',
				'value'   => '',
				'default' => 'meal',
			)
		);

		$cmb->add_field(
			array(
				'before_row'  => '<h4><b><u>Default Options</u></b></h4>',
				'name'        => __( 'Default Meal Plan', 'lsx-health-plan' ),
				'description' => __( 'Set a default meal plan.', 'lsx-health-plan' ),
				'limit'       => 1,
				'id'          => 'connected_meals',
				'type'        => 'post_search_ajax',
				'query_args'  => array(
					'post_type'      => 'meal',
					'post_status'    => array( 'publish' ),
					'posts_per_page' => -1,
				),
			)
		);
		if ( function_exists( 'download_monitor' ) ) {
			$page_url    = 'https://wordpress.org/plugins/download-monitor/';
			$plugin_name = 'Download Monitor';
			$description = sprintf(
				/* translators: %s: The subscription info */
				__( 'If you are using <a target="_blank" href="%1$s">%2$s</a> you can set a default download file for your meal here.', 'lsx-search' ),
				$page_url,
				$plugin_name
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Default Meal Plan PDF', 'lsx-health-plan' ),
					'description' => $description,
					'id'          => 'download_meal',
					'type'        => 'post_search_ajax',
					'limit'       => 1,
					'query_args'  => array(
						'post_type'      => array( 'dlm_download' ),
						'post_status'    => array( 'publish' ),
						'posts_per_page' => -1,
					),
					'after_row'   => __( '<p style="font-style: italic;">If you have changed any URL slugs, please remember re-save your permalinks in Settings > Permalinks.</p>', 'lsx-health-plan' ),
				)
			);
		}
	}
}
Meal::get_instance();
