<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Recipe().
 */
class Recipe {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Recipe()
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_settings_page_recipe_top', array( $this, 'settings' ), 1, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Recipe()    A single instance of this class.
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
				'name'        => __( 'Disable Recipes', 'lsx-health-plan' ),
				'id'          => 'recipe_disabled',
				'type'        => 'checkbox',
				'value'       => 1,
				'default'     => 0,
				'description' => __( 'Disable recipe post type if you are wanting a minimal site.', 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'id'          => 'recipe_archive_description',
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
				'name'    => __( 'Recipes Intro', 'lsx-health-plan' ),
				'id'      => 'recipes_intro',
				'type'    => 'textarea_small',
				'value'   => '',
				'default' => __( "Let's get cooking! Delicious and easy to follow recipes.", 'lsx-health-plan' ),
			)
		);

		$cmb->add_field(
			array(
				'before_row' => '<h4><b><u>URL Slug Options</u></b></h4><p style="font-style: italic;">If you need to translate the custom slug for this custom post type, do so below.</p>',
				'name'       =>  __( 'Recipes Slug', 'lsx-health-plan' ),
				'id'         => 'endpoint_recipe',
				'type'       => 'input',
				'value'      => '',
				'default'    => 'recipe',
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
				'query_args'  => array(
					'post_type'      => 'recipe',
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
				__( 'If you are using <a target="_blank" href="%1$s">%2$s</a> you can set a default download file for your recipe here.', 'lsx-search' ),
				$page_url,
				$plugin_name
			);
			$cmb->add_field(
				array(
					'name'        => __( 'Default Recipe PDF', 'lsx-health-plan' ),
					'description' => $description,
					'id'          => 'download_recipe',
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
Recipe::get_instance();
