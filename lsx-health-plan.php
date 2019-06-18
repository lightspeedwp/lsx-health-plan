<?php
/*
 * Plugin Name:	LSX Health Plan
 * Plugin URI:	https://github.com/lightspeeddevelopment/lsx-health-plan
 * Description:	A meal and workout plan, with recipes
 * Author:		LightSpeed
 * Version: 	1.0.0
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
define( 'LSX_HEALTH_PLAN_VER', '1.0.0' );

/* ======================= Below is the Plugin Class init ========================= */

require_once LSX_HEALTH_PLAN_PATH . '/classes/class-core.php';

/**
 * Remove unnesesary custom post types
 */
function lsx_remove_extra_meta_box() {
	global $wp_meta_boxes;
	$all_post_types = [ 'plan', 'video', 'workout', 'tip', 'recipe', 'meal' ];
	remove_meta_box( 'wpseo_meta', $all_post_types, 'normal' );
	remove_meta_box( 'commentsdiv', $all_post_types, 'normal' );
	remove_meta_box( 'commentstatusdiv', $all_post_types, 'normal' );
	remove_meta_box( 'lsx_blocks_title_meta', $all_post_types, 'side' );
}
add_action( 'add_meta_boxes', 'lsx_remove_extra_meta_box', 100 );

/**
 * Undocumented function
 *
 * @return void
 */
function lsx_health_plan() {
	return \lsx_health_plan\classes\Core::get_instance();
}
lsx_health_plan();
