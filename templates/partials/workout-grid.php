<?php
/**
 * Template used to display the workout content in table form
 *
 * @package lsx-health-plan
 */

global $group_name,$shortcode_args;
$groups = get_post_meta( get_the_ID(), $group_name, true );
if ( is_singular( 'workout' ) ) {
	$groups = get_post_meta( get_queried_object_id(), $group_name, true );
}

$link_setting          = \lsx_health_plan\functions\get_option( 'workout_tab_link', 'single' );
$modal_content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_modal_content', 'excerpt' );
$content_setting       = \lsx_health_plan\functions\get_option( 'workout_tab_content', '' );
$column_setting        = \lsx_health_plan\functions\get_option( 'workout_tab_columns', '4' );

// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['link'] ) ) {
		$link_setting = $shortcode_args['link'];
	}
	if ( isset( $shortcode_args['description'] ) ) {
		$content_setting = $shortcode_args['description'];
	}
	if ( isset( $shortcode_args['columns'] ) ) {
		$column_setting = $shortcode_args['columns'];
		$column_setting = \lsx_health_plan\functions\column_class( $column_setting );
	}
	if ( isset( $shortcode_args['modal_content'] ) ) {
		$modal_content_setting = $shortcode_args['modal_content'];
	}
}

$modal_args = array(
	'modal_content' => $modal_content_setting,
);

$counter = 1;

if ( ! empty( $groups ) ) {
	?>
	<div class="set-grid">
		<div class="workout-grid row">
			<?php
			foreach ( $groups as $group ) {
				$connected_exercise = false;
				if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] ) {
					$connected_exercise = true;
				}

				if ( ! $connected_exercise ) {
					$group['connected_exercises'] = '';
				}
				$alt_title_value = $group['alt_title'] ?? '';
				if ( ( $connected_exercise ) || ( ( ! $connected_exercise ) && $alt_title_value ) ) {

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
					$class_excerpt = 'no-excerpt';
					if ( 'excerpt' === $content_setting ) {
						$class_excerpt = 'has-excerpt';
					}
					// Setup our link and content.
					switch ( $link_setting ) {
						case 'single':
							$link_html  = '<a href="' . get_permalink( $group['connected_exercises'] ) . '">';
							$link_close = '</a>';
							break;

						case 'modal':
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
							<div class="content-box exercise-content-box white-bg">
								<h3 class="content-box-title <?php echo esc_html( $class_excerpt ); ?>">
									<?php echo wp_kses_post( $link_html ); ?>
											<?php
											$exercise_title = lsx_health_plan_exercise_title( '', '', false, false, $group['connected_exercises'] );
											
											if ( '' !== $alt_title ) {
												$exercise_title = '<span class="exercise-counter">' . $counter . '.</span>' . $alt_title;
											} else {
												$exercise_title = '<span class="exercise-counter">' . $counter . '.</span>' . $exercise_title;
											}
											echo wp_kses_post( $exercise_title );
											?>
										</a>
									<?php echo wp_kses_post( $link_close ); ?>
								</h3>
								<?php
								if ( '' !== $content_setting ) {
									?>
									<p class="lsx-exercises-excerpt">
										<?php
										if ( 'excerpt' === $content_setting ) {
											$excerpt = \lsx_health_plan\functions\hp_excerpt( $group['connected_exercises'] );

											if ( '' !== $alt_description ) {
												$excerpt = $alt_description;
											}
											echo wp_kses_post( $excerpt );
										}
										if ( 'full' === $content_setting ) {
											echo wp_kses_post( get_the_content( null, null, $group['connected_exercises'] ) );
										}
										?>
									</p>
									<?php
								}
								?>
								<?php
								$repsclass = '';
								if ( '' !== $reps ) {
									$repsclass = 'have-reps';
								}
								?>
								<div class="reps-container <?php echo esc_html( $repsclass ); ?>">
									<?php
									if ( '' !== $reps ) {
									?>
										<?php echo wp_kses_post( $reps ); ?>
									<?php
									}
									?>
									<?php if ( ( '' !== $link_html ) && ( $connected_exercise ) ) { ?>
										<?php echo wp_kses_post( str_replace( '<a', '<a class="btn-simple" ', $link_html ) ); ?>
										<?php echo wp_kses_post( $link_close ); ?>
									<?php } ?>
								</div>
							</div>
						</article>
					</div>
					<?php
					$counter ++;
				}
			}
			?>
		</div>
	</div>
	<?php
}
