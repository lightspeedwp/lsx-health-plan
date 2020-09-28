<?php
/**
 * Template used to display the workout content in list form
 *
 * @package lsx-health-plan
 */

global $group_name,$shortcode_args;
$groups = get_post_meta( get_the_ID(), $group_name, true );
if ( is_singular( 'workout' ) ) {
	$groups = get_post_meta( get_queried_object_id(), $group_name, true );
}
$link_setting          = \lsx_health_plan\functions\get_option( 'workout_tab_link', 'single' );
$content_setting       = \lsx_health_plan\functions\get_option( 'workout_tab_content', '' );
$modal_content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_modal_content', 'excerpt' );

// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['link'] ) ) {
		$link_setting = $shortcode_args['link'];
	}
	if ( isset( $shortcode_args['description'] ) ) {
		$content_setting = $shortcode_args['description'];
	}
	if ( isset( $shortcode_args['modal_content'] ) ) {
		$modal_content_setting = $shortcode_args['modal_content'];
	}
}

$modal_args = array(
	'modal_content' => $modal_content_setting,
);

if ( ! empty( $groups ) ) {
	?>
	<div class="set-list">
		<div class="workout-list">
			<?php
			foreach ( $groups as $group ) {

				$connected_exercise = false;
				if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] ) {
					$connected_exercise = true;
				}

				if ( ( $connected_exercise ) || ( ( ! $connected_exercise ) && '' !== $group['alt_title'] && isset( $group['alt_title'] ) ) ) {

					$alt_title = '';
					if ( isset( $group['alt_title'] ) && '' !== $group['alt_title'] ) {
						$alt_title = '<span class="alt-title">' . esc_html( $group['alt_title'] ) . '</span>';
					}

					$alt_description = '';
					if ( isset( $group['alt_description'] ) && '' !== $group['alt_description'] ) {
						$alt_description = '<span class="alt-description">' . esc_html( $group['alt_description'] ) . '</span>';
					}

					$alt_image = '';
					if ( isset( $group['exercise_alt_thumbnail'] ) && '' !== $group['exercise_alt_thumbnail'] ) {
						$alt_image = $group['exercise_alt_thumbnail'];
					}

					$reps = '';
					if ( isset( $group['reps'] ) && '' !== $group['reps'] ) {
						$reps = '<span class="reps">' . esc_html( $group['reps'] ) . '</span>';
					}
					// Setup our link and content.
					switch ( $link_setting ) {
						case 'single':
							$link_html  = '';
							$link_close = '';
							if ( $connected_exercise ) {
								$link_html  = '<a href="' . get_permalink( $group['connected_exercises'] ) . '">';
								$link_close = '</a>';
							}
							break;

						case 'modal':
							$link_html  = '';
							$link_close = '';
							if ( $connected_exercise ) {
								if ( ( '' !== $alt_title ) || ( '' !== $alt_description ) || ( '' !== $alt_image ) ) {
									$link_html  = '<a class="alt-modal" data-toggle="modal" href="#workout-alt-exercise-modal-' . $group['connected_exercises'] . '">';
									$link_close = '</a>';
									// We call the button to register the alt modal, but we do not output it.
									lsx_health_plan_workout_exercise_alt_button( $group['connected_exercises'], $group, false, $modal_args, $alt_title, $alt_description, $alt_image );
								} else {
									$link_html  = '<a data-toggle="modal" href="#workout-exercise-modal-' . $group['connected_exercises'] . '">';
									$link_close = '</a>';
									// We call the button to register the modal, but we do not output it.
									lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false, $modal_args );
								}
							}
							break;

						case 'none':
						default:
							$link_html  = '';
							$link_close = '';
							break;
					}
					?>
					<article class="lsx-slot box-shadow">
						<div class="row">
							<div class="col-sm-6 col-md-2">
								<div class="exercise-feature-img">
									<?php echo wp_kses_post( $link_html ); ?>
										<?php
										// We call the button to register the modal, but we do not output it.
										lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false, $modal_args );
										$thumbnail_args = array(
											'class' => 'aligncenter',
										);
										$featured_image = get_the_post_thumbnail( $group['connected_exercises'], 'medium', $thumbnail_args );
										if ( $alt_image ) {
											$featured_image = '<img alt="thumbnail" loading="lazy" class="aligncenter wp-post-image" src="' . $alt_image . '">';
										}
										if ( ! empty( $featured_image ) && '' !== $featured_image ) {
											echo wp_kses_post( $featured_image );
										} else {
											?>
											<img loading="lazy" src="<?php echo esc_attr( plugin_dir_url( __DIR__ ) . '../assets/images/placeholder.jpg' ); ?>">
											<?php
										}
										?>
									<?php echo wp_kses_post( $link_close ); ?>
								</div>
							</div>
							<div class="col-sm-6 col-md-10">
								<div class="title">
									<h3>
									<?php echo wp_kses_post( $link_html ); ?>
											<?php
											$exercise_title = lsx_health_plan_exercise_title( '', '', false, false, $group['connected_exercises'] );
											if ( '' !== $alt_title ) {
												$exercise_title = $alt_title;
											}
											if ( '' !== $reps ) {
												$exercise_title .= $reps;
											}
											echo wp_kses_post( $exercise_title );
											?>
										<?php echo wp_kses_post( $link_close ); ?>
									</h3>
								</div>
								<?php if ( '' !== $link_html ) { ?>
									<?php echo wp_kses_post( str_replace( '<a', '<a class="btn border-btn" ', $link_html ) ); ?>
									<?php esc_html_e( 'How to do it?', 'lsx-health-plan' ); ?>
									<?php echo wp_kses_post( $link_close ); ?>
								<?php } ?>
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
