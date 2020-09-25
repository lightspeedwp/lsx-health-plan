<?php
/**
* Template used to display single planf top nav.
*
* @package lsx-health-plan
*/

$plan_link       = get_permalink();
$current_section = get_query_var( 'section', false );
if ( '' !== $current_section ) {
	$plan_link = \lsx_health_plan\functions\plan\get_permalink( get_the_ID(), $current_section );
}

if ( false !== $current_section && \lsx_health_plan\functions\plan\has_sections() ) {
	$section_info = \lsx_health_plan\functions\plan\get_section_info( $current_section );
	if ( empty( $section_info ) || ( isset( $section_info['rest_day_enabled'] ) && ! empty( $section_info['rest_day_enabled'] ) && ! lsx_health_plan_has_meal() ) ) {
		return;
	}
}

?>
<div id="single-plan-nav">
	<ul class="nav nav-pills">
		<li class="<?php lsx_health_plan_nav_class( '' ); ?>"><a class="overview-tab" href="<?php echo esc_attr( $plan_link ); ?>"><?php lsx_get_svg_icon( 'eye.svg' ); ?> <?php esc_html_e( 'Overview', 'lsx-health-plan' ); ?></a></li>
		<?php
		if ( lsx_health_plan_has_warmup() ) {
			$warm_up = \lsx_health_plan\functions\get_option( 'endpoint_warm_up', false );
			if ( false === $warm_up ) {
				$warm_up = 'warm-up';
			}
			?>
				<li class="<?php lsx_health_plan_nav_class( 'warm-up' ); ?>"><a class="warm-up-tab" href="<?php echo esc_attr( $plan_link ); ?><?php echo esc_attr( $warm_up ); ?>/"><?php lsx_get_svg_icon( 'warm.svg' ); ?> <?php esc_html_e( 'Warm-up', 'lsx-health-plan' ); ?></a></li>				
			<?php
		}
		if ( lsx_health_plan_has_workout() ) {
			$workout = \lsx_health_plan\functions\get_option( 'endpoint_workout', false );
			if ( false === $workout ) {
				$workout = 'workout';
			}
			?>
				<li class="<?php lsx_health_plan_nav_class( 'workout' ); ?>"><a class="workout-tab" href="<?php echo esc_attr( $plan_link ); ?><?php echo esc_attr( $workout ); ?>/"><?php lsx_get_svg_icon( 'work.svg' ); ?> <?php esc_html_e( 'Workout', 'lsx-health-plan' ); ?></a></li>
			<?php
		}
		if ( lsx_health_plan_has_meal() ) {
			$meal = \lsx_health_plan\functions\get_option( 'endpoint_meal', false );
			if ( false === $meal ) {
				$meal = 'meal';
			}
			?>
				<li class="<?php lsx_health_plan_nav_class( 'meal' ); ?>"><a class="meal-plan-tab" href="<?php echo esc_attr( $plan_link ); ?><?php echo esc_attr( $meal ); ?>/"><?php lsx_get_svg_icon( 'meal.svg' ); ?> <?php esc_html_e( 'Meal Plan', 'lsx-health-plan' ); ?></a></li>
			<?php
		}
		?>
	</ul>
</div>
