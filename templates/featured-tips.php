<?php
/**
 * LSX Tips Shortcode.
 *
 * @package lsx-health-plan
 */

$args = array(
	'orderby'        => 'date',
	'order'          => 'ASC',
	'post_type'      => 'tip',
	'posts_per_page' => 3,
);
$tips = new WP_Query( $args );
?>

<div id="lsx-tips-shortcode" class="daily-plan-block content-box box-shadow">
	<div class="lsx-tips-shortcode lsx-tips-slider slick-initialized slick-slider slick-dotted slick-has-arrows" data-slick="{'slidesToShow': 1, 'slidesToScroll': 1}" >
		<div class="diet-tip-wrapper">
			<?php
			if ( $tips->have_posts() ) :
				while ( $tips->have_posts() ) :
					$tips->the_post();
					$post_id = get_the_id();

					$featured_image = get_the_post_thumbnail( $post_id, array( 600, 300 ) );
					?>
					<?php if ( get_post_meta( get_the_ID(), 'tip_featured_tip', 1 ) ) : ?>
							<div class="row quick-tip">
								<div id="quick-tip" class="carousel slide" data-ride="carousel">
								<a href="<?php echo esc_url( get_permalink() ); ?>" ><h3 class="title-lined"><?php the_title(); ?></h3></a>
									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<div class="carousel-item active">
											<div class="col-sm-6 col-xs-6">
												<div class="tipimage">
												<?php
												if ( ! empty( $featured_image ) ) {
													?>
													<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumbnail tip-thumbnail"><?php echo wp_kses_post( $featured_image ); ?></a>
													<?php
												}
												?>
												</div>
											</div>
											<div class="col-sm-6 col-xs-6">
											<?php the_content(); ?>
											</div> 
										</div>
									</div>
								</div>
							</div>
			<?php endif; ?>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		</div>
	</div>
</div>


