<?php
/**
 * LSX Exercises Shortcode.
 *
 * @package lsx-health-plan
 */

$args      = array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_type'      => 'exercise',
	'posts_per_page' => 6,
);
$exercises = new WP_Query( $args );
?>


<div id="lsx-exercises-shortcode" class="daily-plan-block">
	<div class="lsx-exercises-shortcode" >
		<?php
		if ( $exercises->have_posts() ) :
			while ( $exercises->have_posts() ) :
				$exercises->the_post();
				$post_id        = get_the_id();
				$featured_image = get_the_post_thumbnail_url( $post_id );
				?>
				<div style="background-image:url('<?php echo esc_url( $featured_image ); ?>')" class="lsx-exercises-item">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="exercise-link">
						<h4 class="lsx-exercises-title"><?php the_title(); ?></h4>
					</a>
				</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>

