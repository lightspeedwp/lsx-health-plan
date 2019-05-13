<?php
/**
 * LSX Health Plan functions.
 *
 * @package lsx-health-plan
 */

/**
 * Adds text domain.
 */
function lsx_health_plan_load_plugin_textdomain() {
	load_plugin_textdomain( 'lsx-health-plan', false, basename( LSX_HEALTH_PLAN_PATH ) . '/languages' );
}
add_action( 'init', 'lsx_health_plan_load_plugin_textdomain' );
