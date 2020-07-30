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
		<div class="single-plan-inner meal-content">
			<div class="single-plan-section-title meal-plan title-lined">
				<?php lsx_get_svg_icon( 'meal.svg' ); ?>
				<h2><?php esc_html_e( 'My Meal Plan', 'lsx-health-plan' ); ?> <?php the_title(); ?></h2>
			</div>
			<?php require LSX_HEALTH_PLAN_PATH . 'templates/partials/meal-plans.php'; ?>

		</div>
	</div><!-- .entry-content -->
	<?php if ( null === $shortcode_args ) { ?>
		<div class="row tip-row extras-box">
			<?php if ( post_type_exists( 'tip' ) && lsx_health_plan_has_tips() ) { ?>
				<div class="col-md-4">
					<div class="tip-right">
						<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
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
