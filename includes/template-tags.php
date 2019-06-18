<?php
/**
 * LSX Health Plan Template Tags.
 *
 * @package lsx-health-plan
 */

/**
 * Outputs the warmup box on the single plan page.
*
* @return void
*/
function lsx_health_plan_warmup_box() {
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title warm-up-title title-lined"><?php esc_html_e( 'Your Warm-up', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<?php
			$intro_text = \lsx_health_plan\functions\get_option( 'warmup_intro', false );
			if ( false !== $intro_text ) {
				?>
				<div class="excerpt">
					<p><?php echo wp_kses_post( $intro_text ); ?></p>
				</div>
				<?php
			}
			?>
			<a href="<?php the_permalink(); ?>warm-up/" class="btn"><?php esc_html_e( 'Start your warm-up', 'lsx-health-plan' ); ?></a>
		</div>
	</div>
<?php
}

/**
 * Outputs the workout box on the single plan page.
*
* @return void
*/
function lsx_health_plan_workout_box() {
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title work-out-title title-lined"><?php esc_html_e( 'Your Workout', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<?php
			$intro_text = \lsx_health_plan\functions\get_option( 'workout_intro', false );
			if ( false !== $intro_text ) {
				?>
				<div class="excerpt">
					<p><?php echo wp_kses_post( $intro_text ); ?></p>
				</div>
				<?php
			}
			?>
			<a href="<?php the_permalink(); ?>workout/" class="btn"><?php esc_html_e( 'Start your workout', 'lsx-health-plan' ); ?></a>
		</div>
	</div>
<?php
}

/**
 * Outputs the meal plan box on the single plan page.
*
* @return void
*/
function lsx_health_plan_meal_box() {
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title meal-plan-title title-lined"><?php esc_html_e( 'Your Meal Plan', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<?php
			$intro_text = \lsx_health_plan\functions\get_option( 'meal_plan_intro', false );
			if ( false !== $intro_text ) {
				?>
				<div class="excerpt">
					<p><?php echo wp_kses_post( $intro_text ); ?></p>
				</div>
				<?php
			}
			?>
			<a href="<?php the_permalink(); ?>meal/" class="btn"><?php esc_html_e( 'View your meal plan', 'lsx-health-plan' ); ?></a>
		</div>
	</div>
<?php
}

/**
 * Outputs the recipe box on the single plan page.
*
* @return void
*/
function lsx_health_plan_recipe_box() {
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title recipes-title title-lined"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<?php
			$intro_text = \lsx_health_plan\functions\get_option( 'recipes_intro', false );
			if ( false !== $intro_text ) {
				?>
				<div class="excerpt">
					<p><?php echo wp_kses_post( $intro_text ); ?></p>
				</div>
				<?php
			}
			?>
			<a href="<?php the_permalink(); ?>recipes/" class="btn"><?php esc_html_e( 'View all recipes', 'lsx-health-plan' ); ?></a>
		</div>
	</div>
<?php
}

/**
 * Outputs the downloads box on the single plan page.
*
* @return void
*/
function lsx_health_plan_downloads_box() {
	global $current_user;
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title downloads-title title-lined"><?php esc_html_e( 'Downloads', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<div class="download-list">
				<ul>
					<?php
					$downloads = \lsx_health_plan\functions\get_downloads();
					if ( ! empty( $downloads ) ) {
						foreach ( $downloads as $download ) {
							echo wp_kses_post( '<li><a href=""><i class="fa fa-file-pdf"></i>' . do_shortcode( '[download id="' . $download . '"]' ) . '</a></li>' );
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
<?php
}

/**
 * outputs the dynamic classes for the nav tabs.
 *
 * @param string $tab
 * @return void
 */
function lsx_health_plan_nav_class( $tab = '' ) {
	$nav_classes = array();
	if ( function_exists( 'is_wc_endpoint_url' ) && 'edit-account' === $tab && is_wc_endpoint_url( 'edit-account' ) ) {
		$nav_classes[] = 'active';
	} elseif ( lsx_health_plan_is_current_tab( $tab ) ) {
		$nav_classes[] = 'active';
	}
	if ( ! empty( $nav_classes ) ) {
		echo wp_kses_post( implode( ' ', $nav_classes ) );
	}
}

/**
 * Outputs the my profile tabs
 *
 * @return void
 */
function lsx_health_plan_my_profile_tabs() {
	?>
	<div id="account-nav">
		<ul class="nav nav-pills">
			<li class="
			<?php
			if ( ( function_exists( 'is_wc_endpoint_url' ) && ! is_wc_endpoint_url( 'edit-account' ) ) || ! function_exists( 'is_wc_endpoint_url' ) ) {
				echo esc_attr( 'active' );
			}
			?>
			"><a class="my-plan-tab" href="<?php the_permalink(); ?>"><?php esc_html_e( 'My Plan', 'lsx-health-plan' ); ?></a></li>
			<li class="
			<?php
			if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'edit-account' ) ) {
				echo esc_attr( 'active' );
			}
			?>
			"><a class="account-details-tab" href="<?php the_permalink(); ?>edit-account/"><?php esc_html_e( 'Account Details', 'lsx-health-plan' ); ?></a></li>
			<li class=""><a class="logout-tab" href="<?php echo esc_url( wp_logout_url() ); ?>"><?php esc_html_e( 'Logout', 'lsx-health-plan' ); ?></a></li>
		</ul>
	</div>
	<?php
}

/**
 * Outputs the my profile box
 *
 * @return void
 */
function lsx_health_plan_my_profile_box() {
	?>
	<div class="lsx-health-plan my-profile-block">
		<div class="profile-navigation">
			<div class="profile-photo">
			<?php
				global $current_user;
				get_current_user();
				echo get_avatar( $current_user->ID, 240 );
				?>
			</div>
			<div class="edit-profile">
				<a class="btn btn-green" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>edit-account/"><?php esc_html_e( 'Edit Profile', 'lsx-health-plan' ); ?></a>
			</div>
		</div>

		<div class="profile-details">
			<h1 class="title-lined"><?php echo esc_html( $current_user->display_name ); ?></h1>

			<table class="table personal-information">
				<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col"><strong><?php esc_html_e( 'Start', 'lsx-health-plan' ); ?></strong></th>
					<th scope="col"><strong><?php esc_html_e( 'Goal', 'lsx-health-plan' ); ?></strong></th>
					<th scope="col"><strong><?php esc_html_e( 'Current', 'lsx-health-plan' ); ?></strong></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<th scope="row"><strong><?php esc_html_e( 'Weight:', 'lsx-health-plan' ); ?></strong></th>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'weight_start', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'weight_start', true ) . "Kg's" );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'weight_goal', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'weight_goal', true ) . "Kg's" );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'weight_end', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'weight_end', true ) . "Kg's" );
						} else {
							echo '/';
						}
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong><?php esc_html_e( 'Waist:', 'lsx-health-plan' ); ?></strong></th>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'waist_start', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'waist_start', true ) . "cm's" );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'waist_goal', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'waist_goal', true ) . "cm's" );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'waist_end', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'waist_end', true ) . "cm's" );
						} else {
							echo '/';
						}
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><strong><?php esc_html_e( 'Fitness:', 'lsx-health-plan' ); ?></strong></th>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'fitness_start', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'fitness_start', true ) );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'fitness_goal', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'fitness_goal', true ) );
						} else {
							echo '/';
						}
						?>
					</td>
					<td>
						<?php
						if ( '' !== get_user_meta( get_current_user_id(), 'fitness_end', true ) ) {
							echo wp_kses_post( get_user_meta( get_current_user_id(), 'fitness_end', true ) );
						} else {
							echo '/';
						}
						?>
					</td>
				</tr>
				</tbody>
			</table>

		</div>
	</div>
<?php
}

/**
 * Outputs the my profile day view box
 *
 * @return void
 */
function lsx_health_plan_day_plan_block() {
	$args      = array(
		'orderby'        => 'date',
		'order'          => 'ASC',
		'post_type'      => 'plan',
		'posts_per_page' => -1,
		'nopagin'        => true,
	);
	$the_query = new WP_Query( $args );
	?>
	<div class="daily-plan-block day-grid">
		<?php
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				$completed_class = '';
				if ( lsx_health_plan_is_day_complete() ) {
					$completed_class = 'completed';
				}
				?>
				<a href="<?php the_permalink(); ?>" class="day id-<?php the_ID(); ?> <?php echo esc_attr( $completed_class ); ?>">
					<div class="plan-content"><?php the_title(); ?></div>
				</a>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>

<?php
}

/**
 * Outputs the my profile week view box
 *
 * @return void
 */
function lsx_health_plan_week_plan_block() {
	$weeks = get_terms(
		array(
			'taxonomy' => 'week',
		)
	);
	if ( ! empty( $weeks ) ) {
		$counter      = 1;
		$section_open = false;

		foreach ( $weeks as $week ) {
			//Grab the days of the week.
			$args           = array(
				'orderby'        => 'date',
				'order'          => 'ASC',
				'post_type'      => 'plan',
				'posts_per_page' => -1,
				'nopagin'        => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'week',
						'field'    => 'slug',
						'terms'    => array( $week->slug ),
					),
				),
			);
			$the_query      = new WP_Query( $args );
			$collapse_class = '';

			// Determine if the current week is complete.
			if ( $the_query->have_posts() ) {
				$day_ids = wp_list_pluck( $the_query->posts, 'ID' );

				if ( false === $section_open ) {
					if ( 1 === $counter && ! \lsx_health_plan\functions\is_week_complete( false, $day_ids ) ) {
						$collapse_class = 'in';
						$section_open   = true;
					} elseif ( ! \lsx_health_plan\functions\is_week_complete( false, $day_ids ) ) {
						$collapse_class = 'in';
						$section_open   = true;
					}
				}
			}
			?>
			<div class="daily-plan-block week-grid">
				<a href="#week-<?php echo esc_attr( $week->slug ); ?>" data-toggle="collapse" class="week-title"><?php echo esc_attr( $week->name ); ?></a>
				<div id="week-<?php echo esc_attr( $week->slug ); ?>" class="week-row collapse <?php echo esc_attr( $collapse_class ); ?>">
					<div class="week-row-inner">
						<?php
						if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) :
								$the_query->the_post();
								$completed_class = '';
								if ( lsx_health_plan_is_day_complete() ) {
									$completed_class = 'completed';
								}
								?>
								<a href="<?php the_permalink(); ?>" class="day id-<?php the_ID(); ?> <?php echo esc_attr( $completed_class ); ?>">
									<div class="plan-content"><?php the_title(); ?></div>
								</a>
								<?php
							endwhile;
						endif;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
			<?php
			++$counter;
		}
	}
}

/**
 * Outputs the featured video shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_video_block() {
	include LSX_HEALTH_PLAN_PATH . '/templates/featured-videos.php';
}

/**
 * Outputs the featured recipes shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_recipes_block() {
	include LSX_HEALTH_PLAN_PATH . '/templates/featured-recipes.php';
}

/**
 * Outputs the featured tips shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_tips_block() {
	include LSX_HEALTH_PLAN_PATH . '/templates/featured-tips.php';
}

/**
 * Outputs the Health Plan Buttons
 *
 * @param string $button
 * @return void
 */
function lsx_health_plan_day_button() {
	if ( lsx_health_plan_is_day_complete() ) {
		lsx_health_plan_unlock_button();
	} else {
		lsx_health_plan_complete_button();
	}
}

/**
 * Outputs the health plan complete button.
 *
 * @return void
 */
function lsx_health_plan_complete_button() {
	?>
	<div class="single-plan-inner-buttons">
		<form action="<?php the_permalink(); ?>" method="post" class="form-complete-day complete-plan-btn">
			<?php wp_nonce_field( 'complete', 'lsx-health-plan-actions' ); ?>
			<button class="btn cta-btn" type="submit"><?php esc_html_e( 'Complete Day', 'lsx-health-plan' ); ?></button>
		</form>
		<div  class="back-plan-btn">
			<?php
			if ( function_exists( 'wc_get_page_id' ) ) {
				?>
				<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Back To My Plan', 'lsx-health-plan' ); ?></a>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}

/**
 * Outputs the health plan unlock button.
 *
 * @return void
 */
function lsx_health_plan_unlock_button() {
	?>
	<div class="single-plan-inner-buttons">
		<form action="<?php the_permalink(); ?>" method="post" class="form-complete-day complete-plan-btn">
			<?php wp_nonce_field( 'unlock', 'lsx-health-plan-actions' ); ?>
			<button class="btn secondary-btn" type="submit"><?php esc_html_e( 'Im not done!', 'lsx-health-plan' ); ?></button>
		</form>
		<div  class="back-plan-btn">
		<?php
		if ( function_exists( 'wc_get_page_id' ) ) {
			?>
			<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Back To My Plan', 'lsx-health-plan' ); ?></a>
			<?php
		}
		?>
		</div>
	</div>
	<?php
}


/**
 * Outputs the recipe info on a table.
 *
 * @return void
 */
function table_recipe_data() {
	include LSX_HEALTH_PLAN_PATH . '/templates/table-recipe-data.php';
}

/**
 * Outputs the modal button and registers the video modal to show.
 *
 * @param int $m
 * @param array $group
 * @return void
 */
function lsx_health_plan_workout_video_play_button( $m, $group ) {
	$workout_video = '';
	$giphy         = '';
	$youtube       = '';
	if ( isset( $group['connected_videos'] ) && '' !== $group['connected_videos'] ) {
		$workout_video = esc_html( $group['connected_videos'] );
		$giphy         = get_post_meta( $workout_video, 'video_giphy_source', true );
		$youtube       = esc_url( get_post_meta( $workout_video, 'video_youtube_source', 1 ) );
		$content       = get_post_field( 'post_content', $workout_video );
		?>
		<button data-toggle="modal" data-target="#workout-video-modal-<?php echo esc_html( $m ); ?>">
			<span class="fa fa-play-circle"></span>
		</button>
		<?php

		$modal_body = '';
		if ( ! empty( $giphy ) ) {
			$giphy      = \lsx_health_plan\functions\get_video_url( $giphy );
			$modal_body = $giphy; // WPCS: XSS OK.
		} elseif ( ! empty( $youtube ) ) {
			$modal_body = wp_oembed_get( $youtube, array( // WPCS: XSS OK.
				'width' => 480,
			) );
		}
		$modal_body .= '<h5 class="modal-title title-lined">' . $group['name'] . '</h5>';
		$modal_body .= $content;
		\lsx_health_plan\functions\register_modal( 'workout-video-modal-' . $m, '', $modal_body );
	}
}
