<?php
/**
 * LSX Tips Shortcode.
 *
 * @package lsx-health-plan
 */

$args = array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_type'      => 'tip',
	'posts_per_page' => 1,
);
$tips = new WP_Query( $args );
?>

<div id="lsx-tips-shortcode" class="daily-plan-block">
	<h2 class="title-lined"><?php esc_html_e( 'Featured Tips', 'lsx-health-plan' ); ?></h2>
	<div class="lsx-tips-shortcode lsx-tips-slider slick-initialized slick-slider slick-dotted slick-has-arrows" data-slick="{'slidesToShow': 1, 'slidesToScroll': 1}" >

		<?php
		if ( $tips->have_posts() ) :
			while ( $tips->have_posts() ) :
				$tips->the_post();
				$post_id = get_the_id();

				$featured_image = get_the_post_thumbnail( $post_id, array( 600, 300 ) );

				$test = get_post_meta( get_the_ID(), 'tip_featured_tip', 1 );

				?>
				<?php //if ( get_post_meta( get_the_ID(), '_featured_tip', 1 ) ) : ?>
					<div class="lsx-tips-slot">
						<div class="row">
							<div class="col-md-5">
								<h4 class="lsx-tips-title"><?php the_title(); ?></h4>
								<?php the_content(); ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn"><?php esc_html_e( 'View tip', 'lsx-health-plan' ); ?></a>
							</div>
							<div class="col-md-7">
								<?php
								if ( ! empty( $featured_image ) ) {
									echo wp_kses_post( $featured_image );
								}
								?>
							</div>
						</div>
					</div>
				<?php //endif; ?>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
