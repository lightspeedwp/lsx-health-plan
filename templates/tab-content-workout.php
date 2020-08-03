<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */
?>

<?php lsx_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
					'after'       => '</div></div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				)
			);
		?>
		<div class="single-plan-inner workout-content">
			<?php
			if ( ! is_singular( 'workout' ) ) { ?>
				<div class="single-plan-section-title workout title-lined">
					<?php lsx_get_svg_icon( 'work.svg' ); ?>
					<h2><?php esc_html_e( 'My Workout', 'lsx-health-plan' ); ?></h2>
				</div>
			<?php } ?>
			<?php
			if ( lsx_health_plan_has_warmup() && ( ! is_singular( 'workout' ) ) ) {
				?>
				<div class="workout-instructions">
					<div class="row">
						<div class="col-md-8">
							<h3><?php esc_html_e( "Don't forget your warm up!", 'lsx-health-plan' ); ?></h3>
							<p><?php esc_html_e( 'Be sure to do the warm-up before every workout session.', 'lsx-health-plan' ); ?></p>
						</div>
						<div class="col-md-4">
							<div class="single-plan-inner-buttons">
								<?php
								$download = \lsx_health_plan\functions\get_option( 'download_page', false );
								if ( ! empty( $download ) ) {
									?>
									<div class="complete-plan-btn">
										<?php
										echo wp_kses_post( do_shortcode( '[download id="' . $download . '"]' ) );
										?>
									</div>
								<?php } ?>
								<div  class="back-plan-btn">
									<a class="btn secondary-btn wrm-up-btn" href="<?php the_permalink(); ?>warm-up/"><?php esc_html_e( 'See Warm-Up', 'lsx-health-plan' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<?php lsx_health_plan_workout_sets(); ?>
		</div>

	</div><!-- .entry-content -->

	<footer class="footer-meta clearfix">
		<?php if ( has_tag() || class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) : ?>
			<div class="post-tags-wrapper">
				<?php lsx_content_post_tags(); ?>

				<?php
				if ( class_exists( 'LSX_Sharing' ) ) {
					lsx_content_sharing();
				} else {
					if ( function_exists( 'sharing_display' ) ) {
						sharing_display( '', true );
					}

					if ( class_exists( 'Jetpack_Likes' ) ) {
						$custom_likes = new Jetpack_Likes();
						echo wp_kses_post( $custom_likes->post_likes( '' ) );
					}
				}
				?>
		<?php endif ?>
	</footer><!-- .footer-meta -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();

