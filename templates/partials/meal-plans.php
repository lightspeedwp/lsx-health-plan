<?php
/**
 * Template used to loop through the meal plans
 *
 * @package lsx-health-plan
 */
global $connected_meals,$shortcode_args;

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
	$args  = array(
		'orderby'   => 'date',
		'order'     => 'DESC',
		'post_type' => 'meal',
		'post__in'  => $connected_meals,
	);
	$meals = new WP_Query( $args );

	// Looking for recipes.
	$connected_recipes = get_post_meta( get_the_ID(), 'connected_recipes', true );
	if ( empty( $connected_recipes ) ) {
		$options = \lsx_health_plan\functions\get_option( 'all' );
		if ( isset( $options['connected_recipes'] ) && '' !== $options['connected_recipes'] && ! empty( $options['connected_recipes'] ) ) {
			$connected_recipes = $options['connected_recipes'];
			if ( ! array( $connected_recipes ) ) {
				$connected_recipes = array( $connected_recipes );
			}
		}
	}
	$args    = array(
		'orderby'   => 'date',
		'order'     => 'DESC',
		'post_type' => 'recipe',
		'post__in'  => $connected_recipes,
	);
	$recipes = new WP_Query( $args );

	if ( $meals->have_posts() ) {
		while ( $meals->have_posts() ) {
			$meals->the_post();
			$shopping_list = get_post_meta( get_the_ID(), 'meal_shopping_list', true );

			//Breakfast
			$pre_breakfast_snack = get_post_meta( get_the_ID(), 'meal_pre_breakfast_snack', true );
			$breakfast       = get_post_meta( get_the_ID(), 'meal_breakfast', true );
			$post_breakfast_snack = get_post_meta( get_the_ID(), 'meal_breakfast_snack', true );

			//Lunch
			$pre_lunch_snack = get_post_meta( get_the_ID(), 'meal_pre_lunch_snack', true );
			$lunch           = get_post_meta( get_the_ID(), 'meal_lunch', true );
			$post_lunch_snack     = get_post_meta( get_the_ID(), 'meal_lunch_snack', true );

			//Dinner
			$pre_dinner_snack     = get_post_meta( get_the_ID(), 'meal_pre_dinner_snack', true );
			$dinner          = get_post_meta( get_the_ID(), 'meal_dinner', true );
			$post_dinner_snack     = get_post_meta( get_the_ID(), 'meal_dinner_snack', true );


			?>
			<?php
			if ( ! empty( $shopping_list ) ) {
				?>
				<a class="btn border-btn btn-shopping" href="<?php echo esc_url( get_page_link( $shopping_list ) ); ?>" target="_blank"><?php esc_html_e( 'Download Shopping List', 'lsx-health-plan' ); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
			<?php } ?>
			<div class="row eating-row">
				<div class="col-md-4 eating-column">
				<?php
					if ( ! empty( $pre_breakfast_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'A.M. Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_breakfast_snack ) );
						echo '</div>';
					}
					?>						
					<?php
					if ( ! empty( $breakfast ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Breakfast', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $breakfast ) );
						echo '</div>';
					}
					?>
					<?php
					if ( ! empty( $post_breakfast_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'A.M. Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_breakfast_snack ) );
						echo '</div>';
					}
					?>
				</div>
				<div class="col-md-4 eating-column">
				<?php
					if ( ! empty( $pre_lunch_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'P.M. Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_lunch_snack ) );
						echo '</div>';
					}
					?>							
					<?php
					if ( ! empty( $lunch ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Lunch', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $lunch ) );
						echo '</div>';
					}
					if ( ! empty( $post_lunch_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'P.M. Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_lunch_snack ) );
						echo '</div>';
					}
					?>
				</div>
				<div class="col-md-4 eating-column">
				<?php
					if ( ! empty( $pre_dinner_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_dinner_snack ) );
						echo '</div>';
					}
					?>						
					<?php
					if ( ! empty( $dinner ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Dinner', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $dinner ) );
						echo '</div>';
					}
					?>
					<?php
					if ( ! empty( $post_dinner_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title snack-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_dinner_snack ) );
						echo '</div>';
					}
					?>
				</div>
			</div>
			<?php
		}
	}
	?>
	<?php wp_reset_postdata(); ?>

</div>
<div class="recipes">

		<div class="single-plan-inner recipes-content">
			<div class="recipes">
			<div class="row eating-row">
			<?php

			if ( $recipes->have_posts() ) {
				while ( $recipes->have_posts() ) {
					$recipes->the_post();
					$post_id = get_the_id();

					?>
					<div class="col-md-4 recipe-column">
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="recipe-box box-shadow">
							<div class="recipe-feature-img">
								<?php
								$featured_image = get_the_post_thumbnail();
								if ( ! empty( $featured_image ) && '' !== $featured_image ) {
									the_post_thumbnail( 'lsx-thumbnail-square', array(
										'class' => 'aligncenter',
									) );
								} else {
									?>
									<img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
									<?php
								}
								?>
							</div>
							<div class="recipe-content">
								<h3 class="recipe-title"><?php the_title(); ?></h3>
								<?php lsx_health_plan_recipe_data(); ?>
							</div>
						</a>
					</div>
				<?php
				}
			}
			?>
			<?php wp_reset_postdata(); ?>
			</div>
			</div>
		</div>
	</div>
<?php
