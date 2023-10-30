<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */
global $group_name, $connected_workouts;

$warm_up = get_post_meta( get_the_ID(), 'plan_warmup', true );
if ( false === $warm_up || '' === $warm_up ) {
	$options = \lsx_health_plan\functions\get_option( 'all' );
	if ( isset( $options['plan_warmup'] ) && '' !== $options['plan_warmup'] && ! empty( $options['plan_warmup'] ) ) {
		$warm_up = $options['plan_warmup'];
	}
}

if ( false !== $warm_up && '' !== $warm_up ) {
	if ( ! is_array( $warm_up ) ) {
		$warm_up = array( $warm_up );
	}

	$warmup_type  = array( 'page', 'workout', 'exercise' );
	$warmup_query = new WP_Query(
		array(
			'post__in'  => $warm_up,
			'post_type' => $warmup_type,
		)
	);

	if ( $warmup_query->have_posts() ) {
		while ( $warmup_query->have_posts() ) {
			$warmup_query->the_post();
			lsx_entry_before();
			if ( 'workout' === get_post_type() ) {
				$connected_workouts = array( get_the_ID() );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php lsx_entry_top(); ?>
					<div class="entry-content">
						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
								'after'       => '</div></div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						?>
					</div><!-- .entry-content -->
					<?php lsx_entry_bottom(); ?>
				</article><!-- #post-## -->
				<?php
				lsx_health_plan_workout_sets();
			} else {
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php lsx_entry_top(); ?>
					<div class="entry-content">
						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
								'after'       => '</div></div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						?>
					</div><!-- .entry-content -->
					<?php lsx_entry_bottom(); ?>
				</article><!-- #post-## -->
				<?php
			}

			lsx_entry_after();
		}
		wp_reset_postdata();
	}
}
