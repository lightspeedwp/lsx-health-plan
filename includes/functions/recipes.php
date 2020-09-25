<?php
/**
 * LSX Health Plan WooCommerce functions.
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\functions\recipes;

/**
 * Returns true or false if the plan has products.
 *
 * @param array $args
 * @return boolean
 */
function register_recipe_modal() {
	remove_action( 'lsx_content_sharing', 'lsx_sharing_output', 20 );
	ob_start();
	include LSX_HEALTH_PLAN_PATH . '/templates/content-recipe.php';
	$modal_body = ob_get_clean();
	add_action( 'lsx_content_sharing', 'lsx_sharing_output', 20 );
	\lsx_health_plan\functions\register_modal( 'recipe-modal-' . get_the_ID(), '', $modal_body );
}
