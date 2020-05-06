<?php
/**
 * Template used to display the workout content in list form
 *
 * @package lsx-health-plan
 */

global $group_name;
$groups = get_post_meta( get_the_ID(), $group_name, true );
if ( ! empty( $groups ) ) {
	?>
	<div class="set-list">
		<div class="workout-list">
			<?php
			foreach ( $groups as $group ) {
				if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] ) {
					$reps = '';
					if ( isset( $group['reps'] ) && '' !== $group['reps'] ) {
						$reps = '<span class="reps">' . esc_html( $group['reps'] ) . '</span>';
					}
					?>
					<article class="lsx-slot box-shadow">
						<div class="row">
							<div class="col-md-4">
								<div class="exercise-feature-img">
									<a data-toggle="modal" href="#workout-exercise-modal-<?php echo esc_attr( $group['connected_exercises'] ); ?>">
										<?php
										// We call the button to register the modal, but we do not output it.
										lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false );

										$featured_image = get_the_post_thumbnail( $group['connected_exercises'], 'lsx-thumbnail-square', array( 'class' => 'aligncenter' ) );
										if ( ! empty( $featured_image ) && '' !== $featured_image ) {
											echo wp_kses_post( $featured_image );
										} else {
											?>
											<img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
											<?php
										}
										?>
									</a>
								</div>
							</div>
							<div class="col-md-8">
								<div class="title">
									<h3>
										<a data-toggle="modal" href="#workout-exercise-modal-<?php echo esc_attr( $group['connected_exercises'] ); ?>">
											<?php
											$exercise_title = get_the_title( $group['connected_exercises'] );
											if ( '' !== $reps ) {
												$exercise_title .= ' - ' . $reps;
											}
											echo wp_kses_post( $exercise_title );
											?>
										</a>
									</h3>
									<?php
									if ( has_excerpt( $group['connected_exercises'] ) ) {
										$content = apply_filters( 'the_excerpt', get_the_excerpt( $group['connected_exercises'] ) );
										echo wp_kses_post( $content );
									}
									?>
								</div>	
							</div>
						</div>
					</article>
					<?php
				}
			}
			?>
		</div>
	</div>	
	<?php
}
