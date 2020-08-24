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
 * @param  boolean $group_sections
 * @return array
 */
function get_sections( $plan_id = 0, $group_sections = false ) {
	$sections = array();
	if ( 0 === $plan_id ) {
		$plan_id = get_the_ID();
	}
	$section_array = get_post_meta( $plan_id, 'plan_sections', true );
	if ( ! empty( $section_array ) ) {
		$sections = $section_array;
		if ( false !== $group_sections ) {
			$sections = group_sections( $sections );
		}
	}
	return $sections;
}

/**
 * Gets the current sections array values.
 *
 * @param  string $section_key
 * @return array
 */
function get_section_info( $section_key = '' ) {
	$section_info = array();

	$sections = get_sections();
	if ( ! empty( $sections ) ) {
		foreach ( $sections as $key => $values ) {
			$current_key = sanitize_title( $values['title'] );
			if ( $current_key === $section_key ) {
				return $values;
			}
		}
	}
	return $section_info;
}

/**
 * This will group the sections by their "Group" field.
 *
 * @param  array $sections
 * @return array
 */
function group_sections( $sections = array() ) {
	$groups = array();
	if ( ! empty( $sections ) ) {
		foreach ( $sections as $section_key => $section_values ) {
			$group_key = apply_filters( 'lsx_hp_default_plan_group', __( 'Daily Plan', 'lsx-health-plan' ) );
			if ( isset( $section_values['group'] ) && '' !== $section_values['group'] ) {
				$group_key = $section_values['group'];
			}
			$group_key                            = sanitize_title( $group_key );
			$groups[ $group_key ][ $section_key ] = $section_values;
		}
	}
	return $groups;
}

/**
 * This will group title from the first section item.
 *
 * @param  array $sections
 * @return array
 */
function get_group_title( $sections = array() ) {
	$group_title = apply_filters( 'lsx_hp_default_plan_group', __( 'Daily Plan', 'lsx-health-plan' ) );
	if ( ! empty( $sections ) ) {
		$first_section = reset( $sections );
		if ( isset( $first_section['group'] ) && '' !== $first_section['group'] ) {
			$group_title = $first_section['group'];
		}
	}
	return $group_title;
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

/**
 * Return a true or false if the search is enabled.
 *
 * @return boolean
 */
function is_filters_disabled( $disabled = false ) {
	$is_disabled = \lsx_health_plan\functions\get_option( 'plan_filters_disabled', false );
	if ( false !== $is_disabled ) {
		$disabled = true;
	}
	return $disabled;
}

/**
 * Generates a unique ID for the current section item you are viewing,  e.g Day 1 of Week 1.
 * Can only be used on the single plan pages and endpoints.
 *
 * @return string
 */
function generate_section_id() {
	$key = '';
	if ( is_singular( 'plan' ) ) {
		$key          = get_the_ID();
		$section_key  = get_query_var( 'section' );
		
		if ( '' !== $section_key && \lsx_health_plan\functions\plan\has_sections() ) {
			$group_title  = apply_filters( 'lsx_hp_default_plan_group', __( 'Daily Plan', 'lsx-health-plan' ) );
			$section_info = \lsx_health_plan\functions\plan\get_section_info( $section_key );
			$key         .= '_' . sanitize_key( $group_title ) . '_' . sanitize_key( $section_info['title'] );
		}
	}
	return $key;
}
