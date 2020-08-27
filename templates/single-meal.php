<?php
/**
 * The Template for displaying the single meal plan and its connected items
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

			<div class="post-wrapper">

				<?php
				while ( have_posts() ) :
					the_post();
				?>
					<div class="meal-content">
					<?php the_content(); ?>
					</div>
					<?php include LSX_HEALTH_PLAN_PATH . '/templates/tab-content-meal.php'; ?>
				<?php endwhile; ?>

			</div>

			<?php lsx_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'partials/content', 'none' ); ?>

		<?php endif; ?>


		<?php lsx_content_bottom(); ?>

	</main><!-- #main -->

	<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php
get_footer();
