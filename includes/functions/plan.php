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

/**
 * Return a true or false if the search if the plan has sections.
 *
 * @param  integer $plan_id
 * @return boolean
 */
function has_sections( $plan_id = 0 ) {
	$sections = false;
	if ( 0 === $plan_id ) {
		$plan_id = get_the_ID();
	}

	$section_array = get_post_meta( $plan_id, 'plan_sections', true );

	if ( ! empty( $section_array ) ) {
		$sections = true;
	}
	return $sections;
}

/**
 * Returns the sections for a plan
 *
 * @param  integer $plan_id
 * @return array
 */
function get_sections( $plan_id = 0 ) {
	$sections = array();
	if ( 0 === $plan_id ) {
		$plan_id = get_the_ID();
	}

	$section_array = get_post_meta( $plan_id, 'plan_sections', true );

	if ( ! empty( $section_array ) ) {
		$sections = $section_array;
	}
	return $sections;
}

/**
 * Returns the sections for a plan
 *
 * @param  integer $plan_id
 * @param  string  $title
 * @return array
 */
function get_permalink( $plan_id = 0, $title = '' ) {
	if ( 0 === $plan_id ) {
		$plan_id = get_the_ID();
	}
	$url = \get_permalink( $plan_id );
	if ( '' !== $title ) {
		$url .= sanitize_title( $title ) . '/';
	}
	return $url;
}