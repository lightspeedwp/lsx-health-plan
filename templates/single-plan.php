<?php
/**
 * The Template for displaying the single day plan and its connected items
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>

	<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>

		<?php include( LSX_HEALTH_PLAN_PATH . '/templates/single-plan-tabs.php' ); ?>

		<?php
			$endpoint = get_query_var( 'endpoint' );
			switch( $endpoint ) {

				case 'meal':
					include( LSX_HEALTH_PLAN_PATH . '/templates/tab-content-meal.php' );
				break;

				case 'recipes':
					include( LSX_HEALTH_PLAN_PATH . '/templates/tab-content-recipes.php' );
				break;				

				case 'workout':
					include( LSX_HEALTH_PLAN_PATH . '/templates/tab-content-workout.php' );
				break;

				default:
					include( LSX_HEALTH_PLAN_PATH . '/templates/tab-content-plan.php' );
				break;
			}
		?>

		<?php lsx_content_bottom(); ?>

	</main><!-- #main -->

	<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer();
