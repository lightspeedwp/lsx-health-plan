<?php
/**
 * LSX Health Plan WooCommerce functions.
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\functions\woocommerce;

/**
 * Returns true or false if the plan has products.
 *
 * @return boolean
 */
function plan_has_products() {
	$lsx_hp       = lsx_health_plan();
	$has_products = false;
	if ( ! empty( $lsx_hp->integrations->woocommerce->plans->product_ids ) ) {
		$has_products = true;
	}
	return $has_products;
}

/**
 * Returns product ids attached in an array.
 *
 * @return array
 */
function get_plan_products() {
	$lsx_hp       = lsx_health_plan();
	$has_products = array();
	if ( ! empty( $lsx_hp->integrations->woocommerce->plans->product_ids ) ) {
		$has_products = $lsx_hp->integrations->woocommerce->plans->product_ids;
	}
	return $has_products;
}

/**
 * Returns the product IDS of your memberships
 *
 * @return array
 */
function get_membership_products() {
	$product_ids = array();
	if ( function_exists( 'wc_memberships_get_user_memberships' ) ) {
		$user_memberships = wc_memberships_get_user_memberships();

		if ( ! empty( $user_memberships ) ) {
			foreach ( $user_memberships as $membership ) {
				$current_products = $membership->plan->get_product_ids();
				if ( ! empty( $current_products ) ) {
					$product_ids = array_merge( $product_ids, $current_products );
				}
			}
		}
	}
	if ( ! empty( $product_ids ) ) {
		$product_ids = array_unique( $product_ids );
	}
	return $product_ids;
}
