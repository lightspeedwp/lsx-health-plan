<?php
/**
 * LSX Health Plan Conditional Helpers.
 *
 * @package lsx-health-plan
 */

/**
 * Checks if the current post or supplied $post_ID has a workout attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_warmup( $post_id = '' ) {
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return \lsx_health_plan\functions\has_attached_post( $post_id, 'plan_warmup' );
}

/**
 * Checks if the current post or supplied $post_ID has a workout attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_workout( $post_id = '' ) {
    $has_workout = false;
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return $has_workout;
}

/**
 * Checks if the current post or supplied $post_ID has a meal attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_meal( $post_id = '' ) {
    $has_meal = false;
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return $has_meal;
}

/**
 * Checks if the current post or supplied $post_ID has a workout attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_recipes( $post_id = '' ) {
    $has_workout = false;
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return $has_workout;
}

/**
 * Checks if the current post or supplied $post_ID has a downloads attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_downloads( $post_id = '' ) {
    $has_downloads = false;
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return $has_downloads;
}