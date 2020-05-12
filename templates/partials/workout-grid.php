<?php
/**
 * Template used to display the workout content in table form
 *
 * @package lsx-health-plan
 */

global $group_name;
$groups = get_post_meta( get_the_ID(), $group_name, true );
if ( ! empty( $groups ) ) {
	?>
	<div class="set-grid">
		<div class="workout-grid row">
			<?php
			foreach ( $groups as $group ) {
				if ( isset( $group['connected_exercises'] ) ) {
					$reps = '';
					if ( isset( $group['reps'] ) && '' !== $group['reps'] ) {
						$reps = '<span class="reps">' . esc_html( $group['reps'] ) . '</span>';
					}
					?>
					<div class="col-xs-12 col-sm-6 col-md-4">
						<article class="lsx-slot box-shadow">
							<div class="exercise-feature-img">
								<a data-toggle="modal" href="#workout-exercise-modal-<?php echo esc_attr( $group['connected_exercises'] ); ?>">
									<?php
									// We call the button to register the modal, but we do not output it.
									lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false );

									$featured_image = get_the_post_thumbnail( $group['connected_exercises'], 'lsx-thumbnail-square',array( 'class' => 'aligncenter' ) );
									if ( ! empty( $featured_image ) && '' !== $featured_image ) {
										echo wp_kses_post( $featured_image );
									} else {
										?>
										<img src="<?php echo esc_attr( plugin_dir_url( __DIR__ ) . '../assets/images/placeholder.jpg' ); ?>">
										<?php
									}
									?>
								</a>
							</div>
							<div class="title">
								<h3>
									<a data-toggle="modal" href="#workout-exercise-modal-<?php echo esc_attr( $group['connected_exercises'] ); ?>">
										<?php
										$exercise_title = get_the_title( $group['connected_exercises'] );
										if ( '' !== $reps ) {
											$exercise_title .= $reps;
										}
										echo wp_kses_post( $exercise_title );
										?>
									</a>
								</h3>
								<a href="<?php echo esc_url( get_permalink( $group['connected_exercises'] ) ); ?>" class="btn  border-btn"><?php esc_html_e( 'How to do it?', 'lsx-health-plan' ); ?></a>
							</div>
						</article>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<?php
}
