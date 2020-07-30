<?php
/**
 * LSX Health Plan Template Tags.
 *
 * @package lsx-health-plan
 */


function lsx_hp_single_plan_products() {
	global $product;

	if ( ! is_user_logged_in() && \lsx_health_plan\functions\woocommerce\plan_has_products() ) {
		$products      = \lsx_health_plan\functions\woocommerce\get_plan_products();
		$product_count = count( $products );
		if ( 1 === (int) $product_count ) {
			$class = 'col-md-12';
		} else {
			$class = 'col-md-6';
		}
		?>
			<div class="plans-products-wrapper row">
				<?php
				foreach ( $products as $product ) {
					$product = wc_get_product( $product );
					?>
						<div class="plan-product <?php echo esc_attr( $class ); ?>">
							<h3 class="title"><a href="<?php echo esc_html( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_title() ); ?></a></h3>
							<?php
							$description = $product->is_type( 'variation' ) ? $product->get_description() : $product->get_short_description();
							if ( '' !== $description ) {
								?>
									<div class="description">
										<?php echo esc_html( $description ); ?>
									</div>
								<?php
							}
							?>
							<?php echo wp_kses_post( $product->get_price_html() ); ?>

							<div class="add-to-cart">
								<a class="btn btn-primary" href="<?php echo esc_attr( $product->add_to_cart_url() ); ?>"><?php echo esc_attr( $product->add_to_cart_text() ); ?></a>
							</div>
						</div>
					<?php
				}
				?>
			</div>
		<?php
	}
}
