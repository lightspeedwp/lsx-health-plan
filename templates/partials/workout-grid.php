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

$link_setting    = \lsx_health_plan\functions\get_option( 'workout_tab_link', 'single' );
$content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_content', '' );
$column_setting  = \lsx_health_plan\functions\get_option( 'workout_tab_columns', '4' );

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
}

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
									$featured_image = get_the_post_thumbnail( $group['connected_exercises'], 'medium', $thumbnail_args );
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
							<div class="content-box exercise-content-box white-bg">
								<h3 class="title-lined <?php echo esc_html( $class_excerpt ); ?>">
									<?php echo wp_kses_post( $link_html ); ?>
											<?php
											$exercise_title = lsx_health_plan_exercise_title( '', '', false, $group['connected_exercises'] );
											echo wp_kses_post( $exercise_title );
											?>
										</a>
									<?php echo wp_kses_post( $link_close ); ?>
								</h3>
								<div class="reps-container">
									<?php
									if ( '' !== $reps ) {
									?>
										<?php echo wp_kses_post( $reps ); ?>
									<?php
									}
									?>
									<?php if ( '' !== $link_html ) { ?>
										<?php echo wp_kses_post( str_replace( '<a', '<a class="btn-simple" ', $link_html ) ); ?>
										<?php esc_html_e( 'How to do it?', 'lsx-health-plan' ); ?>
										<?php echo wp_kses_post( $link_close ); ?>
									<?php } ?>
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
									?>
									<a href="<?php echo esc_url( get_permalink( $group['connected_exercises'] ) ); ?>" class="btn border-btn"><?php esc_html_e( 'View exercise', 'lsx-health-plan' ); ?></a>
									<?php
								}
								?>
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
