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
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return \lsx_health_plan\functions\has_attached_post( $post_id, 'connected_workouts' );
}

/**
 * Checks if the current post or supplied $post_ID has a meal attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_meal( $post_id = '' ) {
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return \lsx_health_plan\functions\has_attached_post( $post_id, 'connected_meals' );
}

/**
 * Checks if the current post or supplied $post_ID has a recipes attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_recipe( $post_id = '' ) {
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return \lsx_health_plan\functions\has_attached_post( $post_id, 'connected_recipes' );
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
    $downloads = \lsx_health_plan\functions\get_downloads( 'all', $post_id );
    if ( ! empty( $downloads ) ) {
        $has_downloads = true;
    }
    return $has_downloads;
}

/**
 * Checks if the current post or supplied $post_ID has a tips attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_has_tip( $post_id = '' ) {
    if ( '' === $post_id ) {
        $post_id = get_the_ID();
    }
    return \lsx_health_plan\functions\has_attached_post( $post_id, 'connected_tips' );
}

/**
 * Checks to see if the current user has a valid purchase.
 *
 * @return boolean
 */
function lsx_health_plan_user_has_purchase() {
    $valid_order = false;
    $product_id = \lsx_health_plan\functions\get_option( 'membership_product', false );        

    if ( is_user_logged_in() && false !== $product_id ) {
        $current_user = wp_get_current_user();     
        if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product_id ) ) {
            $valid_order = true;
        }
    }
    return $valid_order;
}

/**
 * Checks if the current post or supplied $post_ID has a tips attached.
 *
 * @param string $post_id
 * @return boolean
 */
function lsx_health_plan_is_current_tab( $needle = '' ) {
    $is_tab = false;
    if ( is_singular( 'plan' ) ) {
        $endpoint = get_query_var( 'endpoint' );
        if ( false !== $endpoint && $needle === $endpoint ) {
            $is_tab = true;
        }
    }
    return $is_tab;
}