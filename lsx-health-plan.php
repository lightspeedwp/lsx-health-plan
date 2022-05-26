<?php
/*
 * Plugin Name:	LSX Health
 * Plugin URI:	https://github.com/lightspeeddevelopment/lsx-health-plan
 * Description:	LSX Health Plan extension adds a meal and workout plan, with recipes.
 * Author:		LightSpeed
 * Version: 	2.0.2
 * Author URI: 	https://www.lsdev.biz/
 * License: 	GPL3
 * Text Domain: lsx-health-plan
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'LSX_HEALTH_PLAN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_HEALTH_PLAN_CORE', __FILE__ );
define( 'LSX_HEALTH_PLAN_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_HEALTH_PLAN_VER', '2.0.1' );

/* ======================= Below is the Plugin Class init ========================= */

require_once LSX_HEALTH_PLAN_PATH . '/classes/class-core.php';

/**
 * Remove unnecessary custom post types
 *
 * @return void
 */
function lsx_remove_extra_meta_box() {
	global $wp_meta_boxes;
	$all_post_types = [ 'plan', 'video', 'workout', 'tip', 'recipe', 'meal' ];
	//remove_meta_box( 'wpseo_meta', $all_post_types, 'normal' );
	remove_meta_box( 'commentsdiv', $all_post_types, 'normal' );
	remove_meta_box( 'commentstatusdiv', $all_post_types, 'normal' );
	remove_meta_box( 'lsx_blocks_title_meta', $all_post_types, 'side' );
}
add_action( 'add_meta_boxes', 'lsx_remove_extra_meta_box', 100 );

/**
 * Redirect user after login or redirect
 *
 * @return void
 */
function lsx_login_redirect() {
	$plan_slug = \lsx_health_plan\functions\get_option( 'my_plan_slug', false );
	if ( false === $plan_slug ) {
		$plan_slug = 'my-plan';
	}
	return home_url( $plan_slug );
}
add_filter( 'woocommerce_login_redirect', 'lsx_login_redirect' );

/**
 * Undocumented function
 *
 * @return object lsx_health_plan\classes\Core::get_instance();
 */
function lsx_health_plan() {
	return \lsx_health_plan\classes\Core::get_instance();
}
lsx_health_plan();

/**
 * Creates the svg path
 *
 * @return void
 */
function lsx_get_svg_icon( $icon ) {
	$path = '/assets/images/';

	if ( file_exists( LSX_HEALTH_PLAN_PATH . $path . $icon ) ) {
		// Load and return the contents of the file.
		return include LSX_HEALTH_PLAN_PATH . $path . $icon;
	}

	// Return a blank string if we can't find the file.
	return '';
}
