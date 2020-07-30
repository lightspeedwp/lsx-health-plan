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
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
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
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_breakfast_snack ) );
						echo '</div>';
					}
					?>
				</div>
				<div class="col-md-4 eating-column">
				<?php
					if ( ! empty( $pre_lunch_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
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
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $post_lunch_snack ) );
						echo '</div>';
					}
					?>
				</div>
				<div class="col-md-4 eating-column">
				<?php
					if ( ! empty( $pre_dinner_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $pre_dinner_snack ) );
						echo '</div>';
					}
					?>						
					<?php
					if ( ! empty( $dinner ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Supper', 'lsx-health-plan' ) . '</h3>';
						echo wp_kses_post( apply_filters( 'the_content', $dinner ) );
						echo '</div>';
					}
					?>
					<?php
					if ( ! empty( $post_dinner_snack ) ) {
						echo '<div class="content-box"><h3 class="eating-title">' . esc_html__( 'Snack', 'lsx-health-plan' ) . '</h3>';
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
<?php
