<?php
/**
* Template used to display single planf top nav.
*
* @package lsx-health-plan
*/

?>
<div id="single-plan-nav">
	<ul class="nav nav-pills">
		<li class="<?php lsx_health_plan_nav_class( '' ); ?>"><a class="overview-tab" href="<?php the_permalink(); ?>"><?php lsx_get_svg_icon( 'eye.svg' ); ?> <?php esc_html_e( 'Overview', 'lsx-health-plan' ); ?></a></li>
		<?php
		if ( lsx_health_plan_has_warmup() ) {
			?>
				<li class="<?php lsx_health_plan_nav_class( 'warm-up' ); ?>"><a class="warm-up-tab" href="<?php the_permalink(); ?>warm-up/"><?php lsx_get_svg_icon( 'warm.svg' ); ?> <?php esc_html_e( 'Warm-up', 'lsx-health-plan' ); ?></a></li>				
			<?php
		}
		if ( lsx_health_plan_has_workout() ) {
			?>
				<li class="<?php lsx_health_plan_nav_class( 'workout' ); ?>"><a class="workout-tab" href="<?php the_permalink(); ?>workout/"><?php lsx_get_svg_icon( 'work.svg' ); ?> <?php esc_html_e( 'Workout', 'lsx-health-plan' ); ?></a></li>
			<?php
		}
		if ( lsx_health_plan_has_meal() ) {
			?>
				<li class="<?php lsx_health_plan_nav_class( 'meal' ); ?>"><a class="meal-plan-tab" href="<?php the_permalink(); ?>meal/"><?php lsx_get_svg_icon( 'meal.svg' ); ?> <?php esc_html_e( 'Meal Plan', 'lsx-health-plan' ); ?></a></li>
			<?php
		}
		if ( lsx_health_plan_has_recipe() ) {
			?>
				<li class="<?php lsx_health_plan_nav_class( 'recipes' ); ?>"><a class="recipes-tab" href="<?php the_permalink(); ?>recipes/"><?php lsx_get_svg_icon( 'recipes.svg' ); ?> <?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?></a></li>
			<?php
		}
		?>
	</ul>
</div>
