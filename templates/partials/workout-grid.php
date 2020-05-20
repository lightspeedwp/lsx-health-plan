<?php
/**
 * Template used to display the workout content in table form
 *
 * @package lsx-health-plan
 */

global $group_name;
$groups          = get_post_meta( get_the_ID(), $group_name, true );
$link_setting    = \lsx_health_plan\functions\get_option( 'workout_tab_link', 'single' );
$content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_content', '' );
$column_setting  = \lsx_health_plan\functions\get_option( 'workout_tab_columns', '4' );

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

					// Setup our link and content.
					switch ( $link_setting ) {
						case 'single':
							$link_html  = '<a href="' . get_permalink( $group['connected_exercises'] ) . '">';
							$link_close = '</a>';
							break;

						case 'modal':
							$link_html  = '<a data-toggle="modal" href="#workout-exercise-modal-' . $group['connected_exercises'] . '">';
							$link_close = '</a>';
							// We call the button to register the modal, but we do not output it.
							lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false );
							break;

						case 'none':
						default:
							$link_html  = '';
							$link_close = '';
							break;
					}
					?>
					<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_setting ); ?>">
						<article class="lsx-slot box-shadow">
							<div class="exercise-feature-img">
								<?php echo wp_kses_post( $link_html ); ?>
									<?php
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
								<?php echo wp_kses_post( $link_close ); ?>
							</div>
							<div class="title">
								<h3>
								<?php echo wp_kses_post( $link_html ); ?>
										<?php
										$exercise_title = lsx_health_plan_exercise_title( '', '', false, $group['connected_exercises'] );
										if ( '' !== $reps ) {
											$exercise_title .= $reps;
										}
										echo wp_kses_post( $exercise_title );
										?>
									</a>
								</h3>
								<?php echo wp_kses_post( $link_close ); ?>
							</div>
							<?php
							if ( '' !== $content_setting ) {
								if ( 'excerpt' === $content_setting ) {
									$excerpt = \lsx_health_plan\functions\hp_excerpt( $group['connected_exercises'] );
									?>
										<p class="lsx-exercises-excerpt"><?php echo wp_kses_post( $excerpt ); ?></p>
									<?php
								}
								if ( 'full' === $content_setting ) {
									echo wp_kses_post( get_the_content( null, null, $group['connected_exercises'] ) );
								}
							}
							?>
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
