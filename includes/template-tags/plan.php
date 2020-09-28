<?php
/**
 * LSX Health Plan Gallery Plans Template Tags
 *
 * @package lsx-health-plan
 */

/**
 * Outputs the plan archive filters
 *
 * @return void
 */
function lsx_hp_plan_archive_filters() {
	if ( is_post_type_archive( 'plan' ) && function_exists( 'wc_get_page_id' ) && false === apply_filters( 'lsx_hp_disable_plan_archive_filters', false ) ) {
		?>
		<div id="type-nav">
			<ul class="nav nav-pills lsx-type-nav-filter">
				<li class="active"><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_post_type_archive_link( 'plan' ) ); ?>" data-filter="*"><?php esc_html_e( 'All', 'lsx-health-plan' ); ?></a></li>
				<li><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_post_type_archive_link( 'plan' ) ); ?>" data-filter=".filter-free"><?php esc_html_e( 'Free', 'lsx-health-plan' ); ?></a></li>
				<li><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_post_type_archive_link( 'plan' ) ); ?>" data-filter=".filter-paid"><?php esc_html_e( 'Paid', 'lsx-health-plan' ); ?></a></li>
				<li><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_post_type_archive_link( 'plan' ) ); ?>" data-filter=".filter-featured"><?php esc_html_e( 'Featured', 'lsx-health-plan' ); ?></a></li>
			</ul>
		</div>
		<?php
	}
}

/**
 * Outputs the CSS classes.
 *
 * @return string
 */
function lsx_hp_plan_get_classes() {
	$classes = 'filter-free';
	if ( function_exists( 'lsx_health_plan\functions\woocommerce\plan_has_products' ) && \lsx_health_plan\functions\woocommerce\plan_has_products() ) {
		$products       = \lsx_health_plan\functions\woocommerce\get_plan_products();
		$linked_product = wc_get_product( $products[0] );
		$price          = $linked_product->get_price( 'raw' );
		if ( empty( $price ) ) {
			$classes = 'filter-free';
		} else {
			$classes = 'filter-paid';
		}

		$featured = get_post_meta( get_the_ID(), 'plan_featured_plan', true );
		if ( false !== $featured && '' !== $featured ) {
			$classes .= ' filter-featured';
		}
	}
	return $classes;
}

function lsx_health_plan_back_to_plan_button() {
	?>
	<div  class="back-plan-btn">
		<a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Back To Plan', 'lsx-health-plan' ); ?></a>
	</div>
	<?php
}
