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
		<div class="tip-row extras-box">
			<?php if ( post_type_exists( 'tip' ) && lsx_health_plan_has_tips() ) { ?>
				<div class="tip-right">
					<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block tab="meal"]' ); ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();
