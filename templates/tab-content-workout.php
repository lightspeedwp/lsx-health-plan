<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */
?>

<?php lsx_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php
			wp_link_pages( array(
				'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
				'after'       => '</div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
		<div class="single-plan-inner workout-content">
			<div class="single-plan-section-title workout">
				<?php lsx_get_svg_icon( 'work.svg' ); ?>
				<h2 class="title-lined"><?php esc_html_e( 'My Workout', 'lsx-health-plan' ); ?> <span class="blue-title"><?php the_title(); ?></span></h2>
			</div>
			<?php
			if ( lsx_health_plan_has_warmup() ) {
				?>
				<div class="workout-instructions">
					<div class="row">
						<div class="col-md-6">
							<h3><?php esc_html_e( "Don't forget your warm up!", 'lsx-health-plan' ); ?></h3>
							<p><?php esc_html_e( 'Be sure to do the warm-up before every workout session.', 'lsx-health-plan' ); ?></p>
						</div>
						<div class="col-md-6">
							<div class="single-plan-inner-buttons">
								<?php
								$download = \lsx_health_plan\functions\get_option( 'download_page', false );
								if ( ! empty( $download ) ) {
									?>
									<div class="complete-plan-btn">
										<?php
										echo wp_kses_post( do_shortcode( '[download id="' . $download . '"]' ) );
										?>
									</div>
								<?php } ?>
								<div  class="back-plan-btn">
									<a class="btn secondary-btn wrm-up-btn" href="<?php the_permalink(); ?>warm-up/"><?php esc_html_e( 'See Warm-Up', 'lsx-health-plan' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<!-- Pre Workout-->
			<?php lsx_workout_snacks( 'pre' ); ?>
			<div class="sets">
				<?php
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

				if ( ! empty( $connected_workouts ) ) {
					if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {

						foreach ( $connected_workouts as $workout ) {
							$exercises = get_post_meta( $workout, 'workout_exercises', true );
							if ( ! empty( $exercises ) ) {
								foreach ( $exercises as $exercise ) {


									if ( isset( $exercise['connected_exercises'] ) && '' !== $exercise['connected_exercises'] ) {
										$exercise_obj = get_post( $exercise['connected_exercises'] );
										if ( ! is_wp_error( $exercise_obj ) ) {
										?>
										<article class="exercise type-exercise status-publish has-post-thumbnail">
											<?php
												echo wp_kses_post( '<h3><a href="#exercise-modal-' . $exercise['connected_exercises'] . '" data-toggle="modal">' . $exercise_obj->post_title . '</a></h3>' );
												\lsx_health_plan\functions\register_modal( 'exercise-modal-' . $exercise['connected_exercises'], '', apply_filters( 'the_content', $exercise->post_content ) );
											?>
										</article>
										<?php
										}
									}
								}
							}
						}
					} else {

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
								$i               = 1;
								$m               = 1;
								$section_counter = 6;
								while ( $i <= $section_counter ) {

									$workout_section = 'workout_section_' . ( $i ) . '_title';
									$workout_desc    = 'workout_section_' . ( $i ) . '_description';
									$workout_extra_equipment = 'workout_section_' . ( $i ) . '_workoutgroup_equipment';
									$workout_extra_muscle = 'workout_section_' . ( $i ) . '_workoutgroup_muscle';
									$section_title   = get_post_meta( get_the_ID(), $workout_section, true );
									$description     = get_post_meta( get_the_ID(), $workout_desc, true );
									$extra_equipment     = get_post_meta( get_the_ID(), $workout_extra_equipment, true );
									$extra_muscle     = get_post_meta( get_the_ID(), $workout_extra_muscle, true );


									if ( '' === $section_title ) {
										$i++;
										continue;
									}
									?>
									<div class="set-box set content-box">
										<?php
										if ( ! empty( $post_dinner_snack ) ) {
											echo '<div class="content-box"><h3 class="eating-title title-lined">' . esc_html__( 'Pre-workout Snack', 'lsx-health-plan' ) . '</h3>';
											echo wp_kses_post( apply_filters( 'the_content', $pre_workout_snack ) );
											echo '</div>';
										}
										?>
										<h3 class="set-title"><?php echo esc_html( $section_title ); ?></h3>
										<div class="set-content">
											<p><?php echo wp_kses_post( apply_filters( 'the_content', $description ) ); ?></p>
										</div>

										<?php
										$group_name = 'workout_section_' . $i;
										$groups     = get_post_meta( get_the_ID(), $group_name, true );

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

														if ( isset( $group['name'] ) && '' !== $group['name'] ) {
															$this_row[]            = '<td class="workout-title-item">' . esc_html( $group['name'] ) . '</td>';
															$table_headers['name'] = true;
														}
														if ( isset( $group['description'] ) && '' !== $group['description'] ) {
															$this_row[]                   = '<td class="workout-desc-item"><p>' . esc_html( $group['description'] ) . '</td>';
															$table_headers['description'] = true;
														}
														if ( isset( $group['reps'] ) && '' !== $group['reps'] ) {
															$this_row[]            = '<td class="reps-field-item center-mobile">' . esc_html( $group['reps'] ) . '</td>';
															$table_headers['reps'] = true;
														}
														if ( isset( $group['equipment'] ) && '' !== $group['equipment'] ) {
															$this_row[]                 = '<td class="equipment-field-item center-mobile">' . esc_html( $group['equipment'] ) . '</td>';
															$table_headers['equipment'] = true;
														}
														if ( isset( $group['muscle'] ) && '' !== $group['muscle'] ) {
															$this_row[]              = '<td class="muscle-field-item center-mobile">' . esc_html( $group['muscle'] ) . '</td>';
															$table_headers['muscle'] = true;
														}
														if ( post_type_exists( 'video' ) && isset( $group['connected_videos'] ) && '' !== $group['connected_videos'] && ! empty( \lsx_health_plan\functions\check_posts_exist( array( $group['connected_videos'] ) ) ) ) {
															$this_row[]             = '<td class="video-button-item center-mobile">' . lsx_health_plan_workout_video_play_button( $m, $group, false ) . '</td>';
															$table_headers['video'] = true;
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
														$table_header[] = '<th class="center-mobile">' . __( 'Muscle Group', 'lsx-health-plan' ) . '</th>';
													}
													if ( isset( $table_headers['video'] ) ) {
														$table_header[] = '<th class="center-mobile">' . __( 'Video', 'lsx-health-plan' ) . '</th>';
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
											<?php
										}
										?>
										</div>
									</div>
									<?php
									$i++;
								}
							}
						}
						wp_reset_postdata();
					}
				}
				?>
			</div>
			<!-- Post Workout-->
			<?php lsx_workout_snacks( 'post' ); ?>
		</div>

	</div><!-- .entry-content -->

	<footer class="footer-meta clearfix">
		<?php if ( has_tag() || class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) : ?>
			<div class="post-tags-wrapper">
				<?php lsx_content_post_tags(); ?>

				<?php
				if ( class_exists( 'LSX_Sharing' ) ) {
					lsx_content_sharing();
				} else {
					if ( function_exists( 'sharing_display' ) ) {
						sharing_display( '', true );
					}

					if ( class_exists( 'Jetpack_Likes' ) ) {
						$custom_likes = new Jetpack_Likes();
						echo wp_kses_post( $custom_likes->post_likes( '' ) );
					}
				}
				?>
		<?php endif ?>
	</footer><!-- .footer-meta -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();

