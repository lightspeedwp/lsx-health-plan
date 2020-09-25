<?php
/**
 * Template used to loop through the meal plans
 *
 * @package lsx-health-plan
 */
global $connected_meals, $shortcode_args;

if ( is_singular( 'plan' ) ) {
	$section_key = get_query_var( 'section' );
	if ( '' !== $section_key && \lsx_health_plan\functions\plan\has_sections() ) {
		$section_info = \lsx_health_plan\functions\plan\get_section_info( $section_key );
		if ( isset( $section_info['connected_meals'] ) && '' !== $section_info['connected_meals'] ) {
			$connected_meals = \lsx_health_plan\functions\prep_array( $section_info['connected_meals'] );
		}
	}
}

// Check for any shortcode overrides.
if ( null !== $shortcode_args && isset( $shortcode_args['include'] ) ) {
	$connected_meals = array( get_the_ID() );
}
?>

<div class="meals">

	<?php

	// Looking for meals.
	if ( empty( $connected_meals ) ) {
		$connected_meals = get_post_meta( get_the_ID(), 'connected_meals', true );

		if ( empty( $connected_meals ) ) {
			$options = \lsx_health_plan\functions\get_option( 'all' );
			if ( isset( $options['connected_meals'] ) && '' !== $options['connected_meals'] && ! empty( $options['connected_meals'] ) ) {
				$connected_meals = $options['connected_meals'];
				if ( ! array( $connected_meals ) ) {
					$connected_meals = array( $connected_meals );
				}
			}
		}
	}

	// This is for the meal single template.
	if ( is_single() && is_singular( 'meal' ) ) {
		$connected_meals = array( get_the_ID() );
	}

	// The top part
	echo wp_kses_post( wp_kses_post( lsx_health_plan_meal_main_content() ) );

	if ( false !== $connected_meals && '' !== $connected_meals && ! empty( $connected_meals ) ) {

		$args  = array(
			'orderby'   => 'date',
			'order'     => 'DESC',
			'post_type' => 'meal',
			'post__in'  => $connected_meals,
		);
		$meals = new WP_Query( $args );
		if ( $meals->have_posts() ) {
			while ( $meals->have_posts() ) {
				$meals->the_post();
				$meal_id       = get_the_ID();
				

				// Breakfast.
				$pre_breakfast_snack  = get_post_meta( get_the_ID(), 'meal_pre_breakfast_snack', true );
				$breakfast            = get_post_meta( get_the_ID(), 'meal_breakfast', true );
				$post_breakfast_snack = get_post_meta( get_the_ID(), 'meal_breakfast_snack', true );

				// Lunch.
				$pre_lunch_snack  = get_post_meta( get_the_ID(), 'meal_pre_lunch_snack', true );
				$lunch            = get_post_meta( get_the_ID(), 'meal_lunch', true );
				$post_lunch_snack = get_post_meta( get_the_ID(), 'meal_lunch_snack', true );

				// Dinner.
				$pre_dinner_snack  = get_post_meta( get_the_ID(), 'meal_pre_dinner_snack', true );
				$dinner            = get_post_meta( get_the_ID(), 'meal_dinner', true );
				$post_dinner_snack = get_post_meta( get_the_ID(), 'meal_dinner_snack', true );

				//Main Meals Title
				//echo '<h3 class="meals-section-title">' . esc_html__( 'Meal Plan', 'lsx-health-plan' ) . '</h3>';
				?>
				<div class="row eating-row">
					<div class="col-md-4 eating-column">
					<?php
					if ( ! empty( $pre_breakfast_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_breakfast_snack ) );
						echo '</div>';
					}
					if ( ! empty( $breakfast ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Breakfast', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $breakfast ) );
						echo '</div>';
					}
					if ( ! empty( $post_breakfast_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_breakfast_snack ) );
						echo '</div>';
					}

					$args = array(
						'meal_id'   => $meal_id,
						'meal_time' => 'breakfast',
					);
					lsx_hp_meal_plan_recipes( $args );
					?>
					</div>
					<div class="col-md-4 eating-column">
					<?php
					if ( ! empty( $pre_lunch_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_lunch_snack ) );
						echo '</div>';
					}
					if ( ! empty( $lunch ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Lunch', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $lunch ) );
						echo '</div>';
					}
					if ( ! empty( $post_lunch_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_lunch_snack ) );
						echo '</div>';
					}

					$args = array(
						'meal_id'   => $meal_id,
						'meal_time' => 'lunch',
					);
					lsx_hp_meal_plan_recipes( $args );
					?>
					</div>
					<div class="col-md-4 eating-column">
						<?php
						if ( ! empty( $pre_dinner_snack ) ) {
							echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
							echo wp_kses_post( apply_filters( 'the_content', $pre_dinner_snack ) );
							echo '</div>';
						}
						if ( ! empty( $dinner ) ) {
							echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Dinner', 'lsx-health-plan' ) . '</h3>';
							echo wp_kses_post( apply_filters( 'the_content', $dinner ) );
							echo '</div>';
						}
						if ( ! empty( $post_dinner_snack ) ) {
							echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
							echo wp_kses_post( apply_filters( 'the_content', $post_dinner_snack ) );
							echo '</div>';
						}

						$args = array(
							'meal_id'   => $meal_id,
							'meal_time' => 'dinner',
						);
						lsx_hp_meal_plan_recipes( $args );
						?>
					</div>
				</div>
				<?php
			}
		}
	}
	?>
	<?php wp_reset_postdata(); ?>
</div>
<?php
