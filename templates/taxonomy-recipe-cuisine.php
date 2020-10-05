<?php
/**
 * The template for displaying Recipe Cuisine Archives.
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" role="main">

			<?php lsx_content_top(); ?>

			<div class="post-wrapper archive-plan">
				<div class="row">
					<?php if ( have_posts() ) : ?>
						<?php
						while ( have_posts() ) :
							the_post();
							?>

							<?php include LSX_HEALTH_PLAN_PATH . '/templates/content-archive-recipe.php'; ?>

						<?php endwhile; ?>

					<?php else : ?>

						<?php get_template_part( 'partials/content', 'none' ); ?>

					<?php endif; ?>
				</div>
				<?php lsx_paging_nav(); ?>
			</div>
			<?php lsx_content_bottom(); ?>

		</main><!-- #main -->

<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php //get_sidebar(); ?>

<?php
get_footer();
