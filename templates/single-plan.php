<?php
/**
 * The Template for displaying all single posts.
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>

	<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php include( LSX_HEALTH_PLAN_PATH . '/templates/content-plan.php' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

		<div class="row">
			<?php if ( lsx_health_plan_has_warmup() ) { 
				lsx_health_plan_warmup_box();
			} ?>

			<?php if ( lsx_health_plan_has_workout() ) { 
				lsx_health_plan_workout_box();
			} ?>

			<?php if ( lsx_health_plan_has_meal() ) { 
				lsx_health_plan_meal_box();
			} ?>

			<?php if ( lsx_health_plan_has_recipe() ) { 
				lsx_health_plan_recipe_box();
			} ?>

			<?php if ( lsx_health_plan_has_downloads() ) { 
				lsx_health_plan_downloads_box();
			} ?>												
		</div>

		<?php lsx_content_bottom(); ?>

	</main><!-- #main -->

	<?php lsx_content_after(); ?>

	<?php
		if ( is_singular( 'post' ) ) {
			lsx_post_nav();
		}
	?>

	<?php
		if ( comments_open() ) {
			comments_template();
		}
	?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer();
