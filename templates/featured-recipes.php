<?php
/**
 * LSX Recipes Shortcode.
 *
 * @package lsx-health-plan
 */

$args      = array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_type'      => 'recipe',
	'posts_per_page' => 5,
);
$recipes = new WP_Query( $args );
?>

<div id="lsx-recipes-shortcode" class="daily-plan-block">
	<h2 class="title-lined"><?php esc_html_e( 'Featured Recipe', 'lsx-health-plan' ); ?></h2>
	<div class="lsx-recipes-shortcode lsx-recipes-slider slick-initialized slick-slider slick-dotted slick-has-arrows" data-slick="{'slidesToShow': 1, 'slidesToScroll': 1}" >

		<?php
		if ( $recipes->have_posts() ) :
			while ( $recipes->have_posts() ) :
				$recipes->the_post();

				$prep_time      = get_post_meta( get_the_ID(), 'recipe_prep_time', true );
				$cooking_time   = get_post_meta( get_the_ID(), 'recipe_cooking_time', true );
				$serves         = get_post_meta( get_the_ID(), 'recipe_serves', true );
				$portion        = get_post_meta( get_the_ID(), 'recipe_portion', true );
				$featured_image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'aligncenter' ) );
				?>

				<?php if ( get_post_meta( get_the_ID(), 'recipe_featured', 1 ) ) : ?>
					<div class="lsx-recipes-slot">
						<div class="row">
							<div class="col-md-5">
								<h4 class="lsx-recipes-title"><?php the_title(); ?></h4>
								<table>
									<tbody>
										<tr>
											<th><?php esc_html_e( 'Prep time:', 'lsx-health-plan' ); ?></th>
											<td>
												<?php
												if ( ! empty( $prep_time ) ) {
													echo $prep_time;
												}
												?>
											</td>
										</tr>
										<tr>
											<th><?php esc_html_e( 'Cooking time:', 'lsx-health-plan' ); ?></th>
											<td>
												<?php
												if ( ! empty( $cooking_time ) ) {
													echo $cooking_time;
												}
												?>
											</td>
										</tr>
										<tr>
											<th><?php esc_html_e( 'Serves:', 'lsx-health-plan' ); ?></th>
											<td>
												<?php
												if ( ! empty( $serves ) ) {
													echo $serves;
												}
												?>
											</td>
										</tr>
										<tr>
											<th><?php esc_html_e( 'Portion size:', 'lsx-health-plan' ); ?></th>
											<td>
												<?php
												if ( ! empty( $portion ) ) {
													echo $portion;
												}
												?>
											</td>
										</tr>
									</tbody>
								</table>
								<a href="<?php echo get_permalink(); ?>" class="btn"><?php esc_html_e( 'VIEW RECIPE', 'lsx-health-plan' ); ?></a>
							</div>
							<div class="col-md-7">
								<?php
								if ( ! empty( $featured_image ) ) {
									echo $featured_image;
								}
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
