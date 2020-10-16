<?php
/**
 * Template used to display the workout content in table form
 *
 * @package lsx-health-plan
 */

global $group_name;
$groups = get_post_meta( get_the_ID(), $group_name, true );
if ( is_singular( 'workout' ) ) {
	$groups = get_post_meta( get_queried_object_id(), $group_name, true );
}
if ( ! empty( $groups ) ) {
	?>
	<div class="set-table">
		<table class="workout-table">
			<?php
			$table_headers = array();
			$table_body    = array();

			foreach ( $groups as $group ) {
				$this_row = array();

				$this_row[] = '<tr>';

				// Getting the connected exercise.
				if ( post_type_exists( 'exercise' ) ) {
					if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] && ! empty( \lsx_health_plan\functions\check_posts_exist( array( $group['connected_exercises'] ) ) ) ) {
						$exercise    = $group['connected_exercises'];
						$exercise_id = get_post( $exercise );
					}
				} else {
					$exercise    = false;
					$exercise_id = false;
				}

				if ( false !== $exercise && '' !== $exercise ) {
					$exercise_name         = get_the_title( $exercise_id );
					$this_row[]            = '<td class="workout-title-item">' . esc_html( $exercise_name ) . '</td>';
					$table_headers['name'] = true;
				} else {
					if ( isset( $group['name'] ) && '' !== $group['name'] ) {
						$this_row[]            = '<td class="workout-title-item">' . esc_html( $group['name'] ) . '</td>';
						$table_headers['name'] = true;
					}
				}
				// Only display this is exercise is disabled.
				if ( false === $exercise && isset( $group['description'] ) && '' !== $group['description'] ) {
					$this_row[]                   = '<td class="workout-desc-item"><p>' . esc_html( $group['description'] ) . '</td>';
					$table_headers['description'] = true;
				}

				if ( isset( $group['reps'] ) && '' !== $group['reps'] ) {
					$this_row[]            = '<td class="reps-field-item center-mobile">' . esc_html( $group['reps'] ) . '</td>';
					$table_headers['reps'] = true;
				}

				// Only display this is exercise is disabled.
				if ( false === $exercise ) {
					if ( isset( $group['equipment'] ) && '' !== $group['equipment'] ) {
						$this_row[]                 = '<td class="equipment-field-item center-mobile">' . esc_html( $group['equipment'] ) . '</td>';
						$table_headers['equipment'] = true;
					}
					if ( isset( $group['muscle'] ) && '' !== $group['muscle'] ) {
						$this_row[]              = '<td class="muscle-field-item center-mobile">' . esc_html( $group['muscle'] ) . '</td>';
						$table_headers['muscle'] = true;
					}
				}
				if ( post_type_exists( 'video' ) && isset( $group['connected_videos'] ) && '' !== $group['connected_videos'] && ! empty( \lsx_health_plan\functions\check_posts_exist( array( $group['connected_videos'] ) ) ) ) {
					$this_row[]             = '<td class="video-button-item center-mobile">' . lsx_health_plan_workout_video_play_button( $m, $group, false ) . '</td>';
					$table_headers['video'] = true;
				}
				if ( post_type_exists( 'exercise' ) && isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] && ! empty( \lsx_health_plan\functions\check_posts_exist( array( $group['connected_exercises'] ) ) ) ) {
					$this_row[]             = '<td class="video-button-item center-mobile">' . lsx_health_plan_workout_exercise_button( $m, $group, false ) . '</td>';
					$table_headers['exercise'] = true;
				}
				$this_row[] = '</tr>';

				$table_body[] = implode( '', $this_row );
				$m++;
			}

			// Now we build the table header.
			$table_header   = array();
			$table_header[] = '<tr>';
			if ( isset( $table_headers['name'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'Workout', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['description'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'Description', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['reps'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'Reps / Time / Distance', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['equipment'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'Equipment', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['muscle'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'Muscle', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['video'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'How To', 'lsx-health-plan' ) . '</th>';
			}
			if ( isset( $table_headers['exercise'] ) ) {
				$table_header[] = '<th class="center-mobile">' . __( 'How To', 'lsx-health-plan' ) . '</th>';
			}
			$table_header[] = '</tr>';
			?>
			<thead>
				<?php echo wp_kses_post( implode( '', $table_header ) ); ?>
			</thead>
			<tbody>
				<?php echo wp_kses_post( implode( '', $table_body ) ); ?>
			</tbody>
		</table>
	</div>
	<?php
}
