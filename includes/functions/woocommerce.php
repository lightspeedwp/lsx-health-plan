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
