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
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
				'after'       => '</div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
		<div class="single-plan-inner workout-content">
			<div class="single-plan-section-title workout">
				<h2 class="title-lined"><?php esc_html_e( 'My Workout', 'lsx-health-plan' ); ?> <span class="blue-title"><?php the_title(); ?></span></h2>
			</div>
			<?php
			if ( lsx_health_plan_has_warmup() ) {
				?>
				<div class="workout-instructions">
					<div class="row">
						<div class="col-md-6">
							<h3>Dont forget your warm up!</h3>
							<p>Be sure to do the warm-up before every workout session.</p>
						</div>
						<div class="col-md-6">
							<div class="single-plan-inner-buttons">
								<div class="complete-plan-btn">
									<a class="btn border-btn" href="#"><?php esc_html_e( 'Download Warm-Up', 'lsx-health-plan' ); ?></a>
								</div>
								<div  class="back-plan-btn">
									<a class="btn secondary-btn" href="<?php the_permalink(); ?>warm-up/"><?php esc_html_e( 'See Warm-Up', 'lsx-health-plan' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<div class="sets">
				<?php
				$connected_workouts = get_post_meta( get_the_ID(), 'connected_workouts', true );
				if ( empty( $connected_workouts ) ) {
					return;
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

						$i               = 1;
						$m               = 1;
						$section_counter = 6;
						while ( $i <= $section_counter ) {

							$workout_section = 'workout_section_' . ( $i ) . '_title';
							$workout_desc    = 'workout_section_' . ( $i ) . '_description';
							$section_title   = get_post_meta( get_the_ID(), $workout_section, true );
							$description     = get_post_meta( get_the_ID(), $workout_desc, true );

							if ( '' === $section_title ) {
								$i++;
								continue;
							}
							?>
							<div class="set-box set content-box">
								<h3 class="set-title"><?php echo esc_html( $section_title ); ?></h3>
								<div class="set-content">
									<p><?php echo esc_html( $description ); ?></p>
								</div>

								<?php
								$group_name = 'workout_section_' . $i;
								$groups     = get_post_meta( get_the_ID(), $group_name, true );

								if ( ! empty( $groups ) ) {
									?>
									<div class="set-table">
										<table class="workout-table">
											<tbody>
												<tr>
													<th>Workout</th> 
													<th class="center-mobile">Reps / Time / Distance</th>
													<th class="center-mobile">Video</th>
												</tr>
												<?php
												foreach ( $groups as $group ) {
													$workout_name = '';
													if ( isset( $group['name'] ) ) {
														$workout_name = esc_html( $group['name'] );
													}
													$workout_reps = '';
													if ( isset( $group['reps'] ) ) {
														$workout_reps = esc_html( $group['reps'] );
													}
													$workout_video = '';
													$giphy         = '';
													$youtube       = '';
													if ( isset( $group['connected_videos'] ) ) {
														$workout_video = esc_html( $group['connected_videos'] );
														$giphy         = get_post_meta( $workout_video, 'video_giphy_source', true );
														$youtube       = esc_url( get_post_meta( $workout_video, 'video_youtube_source', 1 ) );
													}
													?>
													<tr>
														<td class="workout-title-item"><?php echo esc_html( $workout_name ); ?></td>
														<td class="reps-field-item center-mobile"><?php echo esc_html( $workout_reps ); ?></td>
														<td class="video-button-item center-mobile">
															<a href="#" data-toggle="modal" data-target="#modal-<?php echo esc_html( $m ); ?>">
																<span class="fa fa-play-circle"></span>
															</a>
														</td>
													</tr>
													<!-- Modal -->
													<div class="modal fade" id="#modal-<?php echo esc_html( $m++ ); ?>" tabindex="-1" role="dialog">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title"><?php echo esc_html( $workout_name ); ?></h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<?php
																if ( ! empty( $giphy ) ) {
																	echo $giphy; // WPCS: XSS OK.
																} elseif ( ! empty( $youtube ) ) {
																	echo wp_oembed_get( $youtube, array( // WPCS: XSS OK.
																		'width' => 480,
																	) );
																}
																?>
																</div>
															</div>
														</div>
													</div>
													<!-- End Modal -->
													<?php
												}
												?>
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
					?>
				<?php } ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>

	</div><!-- .entry-content -->

	<div class="single-plan-inner-buttons">
		<div class="complete-plan-btn">
			<a class="btn cta-btn" href="#"><?php esc_html_e( 'COMPLETE DAY', 'lsx-health-plan' ); ?></a>
		</div>
		<div  class="back-plan-btn">
			<a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'BACK TO MY PLAN', 'lsx-health-plan' ); ?></a>
		</div>
	</div>

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
