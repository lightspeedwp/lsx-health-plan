<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); 
		include( LSX_HEALTH_PLAN_PATH . '/templates/content-plan.php' ); 
	endwhile;
endif;
?>

<div class="row tab-content-plan">
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
