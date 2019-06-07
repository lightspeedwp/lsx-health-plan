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
 * Undocumented function
 *
 * @return void
 */
function lsx_health_plan() {
	return \lsx_health_plan\classes\Core::get_instance();
}
lsx_health_plan();
