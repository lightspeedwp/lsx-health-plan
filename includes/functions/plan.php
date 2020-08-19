<?php
/**
 * LSX Health Plan Plan specific functions.
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\functions\plan;


/**
 * Return a true or false if the search is enabled.
 *
 * @return boolean
 */
function is_search_enabled() {
	$enabled = false;
	if ( function_exists( 'lsx_search' ) ) {
		$search_instance = \LSX_Search::get_instance();
		if ( null !== $search_instance ) {
			$enabled = $search_instance->frontend->is_search_enabled();
		}
	}
	return $enabled;
}
