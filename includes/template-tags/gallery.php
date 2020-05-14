<?php
/**
 * LSX Health Plan Gallery Template Tags
 *
 * @package lsx-health-plan
 */

/**
 * Output the health plan gallery.
 *
 * @param  string  $before
 * @param  string  $after
 * @param  boolean $echo
 * @param  string  $item_id
 * @return string
 */
function lsx_health_plan_gallery( $before = '', $after = '', $echo = true, $item_id = false ) {
	$gallery = '';
	$lsx_hp  = lsx_health_plan();
	if ( false === $item_id ) {
		$item_id = get_the_ID();
	}
	if ( $lsx_hp->frontend->gallery->has_gallery( $item_id ) ) {
		$gallery = $before . $lsx_hp->frontend->gallery->get_gallery() . $after;
	}
	if ( true === $echo ) {
		echo wp_kses_post( $gallery );
	} else {
		return $gallery;
	}
}
