<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

global $shortcode_args;

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
						<div class="col-md-12">
							<div class="content-intro">
								<h3><?php esc_html_e( "Don't forget your warm up!", 'lsx-health-plan' ); ?></h3>
								<p><?php esc_html_e( 'Be sure to do the warm-up before every workout session.', 'lsx-health-plan' ); ?></p>
							</div>
							<?php if ( null === $shortcode_args ) { ?>
								<div class="tip-row extras-box">
									<?php if ( post_type_exists( 'tip' ) && lsx_health_plan_has_tips() ) { ?>
										<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block tab="workout"]' ); ?>
									<?php } ?>
								</div>
							<?php } ?>
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

