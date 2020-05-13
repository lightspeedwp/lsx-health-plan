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
							<div class="col-sm-6 col-md-2">
								<div class="exercise-feature-img">
									<a data-toggle="modal" href="#workout-exercise-modal-<?php echo esc_attr( $group['connected_exercises'] ); ?>">
										<?php
										// We call the button to register the modal, but we do not output it.
										lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false );
										$thumbnail_args = array(
											'class' => 'aligncenter',
										);
										$featured_image = get_the_post_thumbnail( $group['connected_exercises'], 'lsx-thumbnail-square', $thumbnail_args );
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
							</div>
							<div class="col-sm-6 col-md-10">
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
								</div>
								<a href="<?php echo esc_url( get_permalink( $group['connected_exercises'] ) ); ?>" class="btn  border-btn"><?php esc_html_e( 'How to do it?', 'lsx-health-plan' ); ?></a>
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
