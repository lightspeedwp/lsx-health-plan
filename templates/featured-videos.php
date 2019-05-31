<?php
/**
 * LSX Videos Shortcode.
 *
 * @package lsx-health-plan
 */

$args      = array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_type'      => 'video',
	'posts_per_page' => 5,
);
$videos = new WP_Query( $args );
?>

<div id="lsx-videos-shortcode" class="daily-plan-block">
	<h2 class="title-lined"><?php esc_html_e( 'Featured Workout', 'lsx-health-plan' ); ?></h2>
	<div class="lsx-videos-shortcode lsx-videos-slider slick-initialized slick-slider slick-dotted slick-has-arrows" data-slick="{'slidesToShow': 1, 'slidesToScroll': 1}" >

		<?php
		if ( $videos->have_posts() ) :
			while ( $videos->have_posts() ) :
				$videos->the_post();

				$featured       = get_post_meta( get_the_ID(), 'video_featured_video', true );
				$giphy          = get_post_meta( get_the_ID(), 'video_giphy_source', true );
				$youtube        = esc_url( get_post_meta( get_the_ID(), 'video_youtube_source', 1 ) );
				?>

				<?php if ( get_post_meta( get_the_ID(), 'video_featured_video', 1 ) ) : ?>
					<div class="lsx-videos-slot">
						<div class="row">
							<div class="col-md-4">
								<h4 class="lsx-videos-title"><?php the_title(); ?></h4>
								<?php the_content(); ?>
							</div>
							<div class="col-md-8">
								<?php
								if ( ! empty( $giphy ) ) {
									echo $giphy;
								} elseif ( ! empty( $youtube ) ) {
									echo wp_oembed_get( $youtube, array( 'width' => 480 ) );
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
