<?php
/**
 * Template used to loop through the workout sets and display the workouts.
 *
 * @package lsx-health-plan
 */
global $group_name, $connected_workouts, $shortcode_args;

// Check for any shortcode overrides.
if ( null !== $shortcode_args && isset( $shortcode_args['include'] ) ) {
	$connected_workouts = array( get_the_ID() );
}
?>
<div class="sets-wrapper">
	<?php
	if ( empty( $connected_workouts ) || null === $connected_workouts ) {
		$connected_workouts = get_post_meta( get_the_ID(), 'connected_workouts', true );
		if ( empty( $connected_workouts ) ) {
			$options = \lsx_health_plan\functions\get_option( 'all' );
			if ( isset( $options['connected_workouts'] ) && '' !== $options['connected_workouts'] && ! empty( $options['connected_workouts'] ) ) {
				$connected_workouts = $options['connected_workouts'];
				if ( ! array( $connected_workouts ) ) {
					$connected_workouts = array( $connected_workouts );
				}
			}
		}
	}
	$args     = array(
		'orderby'   => 'date',
		'order'     => 'DESC',
		'post_type' => 'workout',
		'post__in'  => $connected_workouts,
	);
	$workouts = new WP_Query( $args );

	if ( $workouts->have_posts() ) {
		while ( $workouts->have_posts() ) {
			$workouts->the_post();
			// Brings the workout post content first.
			echo wp_kses_post( lsx_health_plan_workout_main_content() );

			$i               = 1;
			$section_counter = 6;
			echo '<div class="sets">';
			while ( $i <= $section_counter ) {

				$workout_section = 'workout_section_' . ( $i ) . '_title';
				$workout_desc    = 'workout_section_' . ( $i ) . '_description';

				$section_title = get_post_meta( get_the_ID(), $workout_section, true );
				$description   = get_post_meta( get_the_ID(), $workout_desc, true );
				if ( is_singular( 'workout' ) ) {
					$section_title = get_post_meta( get_queried_object_id(), $workout_section, true );
					$description   = get_post_meta( get_queried_object_id(), $workout_desc, true );
				}

				if ( '' === $section_title ) {
					$i++;
					continue;
				}
				?>
				<div class="set-box set content-box">
					<h3 class="set-title"><?php echo esc_html( $section_title ); ?></h3>
					<div class="set-content">
						<p><?php echo wp_kses_post( apply_filters( 'the_content', $description ) ); ?></p>
					</div>
					<?php lsx_health_plan_workout_tab_content( $i ); ?>
				</div>
				<?php
				$i++;
			}
			echo '</div>';
		}
		?>
	<?php } ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php
