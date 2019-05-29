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
function lsx_health_plan_warmup_box() { ?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title warm-up-title title-lined"><?php esc_html_e( 'Your Warm-up', 'lsx-health-plan' ); ?></h3>
			<div class="spacer"></div>
			<div class="excerpt">
				<p>Pellentesque non scelerisque dui.</p>
			</div>
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
			<div class="excerpt">
				<p>Vestibulum quis mi eu nisl eleifend maximus.</p>
			</div>
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
			<div class="excerpt">
				<p>Nam vestibulum augue id condimentum consectetur.</p>
			</div>
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
			<a href="<?php the_permalink(); ?>recipes/" class="btn"><?php esc_html_e( 'Recipe 1', 'lsx-health-plan' ); ?></a>
			<a href="<?php the_permalink(); ?>recipes/" class="btn"><?php esc_html_e( 'View all', 'lsx-health-plan' ); ?></a>
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
							echo wp_kses_post( '<li><a href=""><i class="fa fa-file-pdf"></i>' . do_shortcode( '[download id="' . $download . '"]' ) . '</li>' );
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
	if ( lsx_health_plan_is_current_tab( $tab ) ) {
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
			<li class="<?php lsx_health_plan_nav_class( '' ); ?>"><a class="my-plan-tab" href="<?php the_permalink(); ?>"><?php esc_html_e( 'My Plan', 'lsx-health-plan' ); ?></a></li>
			<li class="<?php lsx_health_plan_nav_class( 'edit-account' ); ?>"><a class="account-details-tab" href="<?php the_permalink(); ?>edit-account/"><?php esc_html_e( 'Account Details', 'lsx-health-plan' ); ?></a></li>
			<li class="<?php lsx_health_plan_nav_class( 'logout' ); ?>"><a class="logout-tab" href="<?php echo wp_logout_url(); ?>"><?php esc_html_e( 'Logout', 'lsx-health-plan' ); ?></a></li>
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
 * Outputs the my profile box
 *
 * @return void
 */
function lsx_health_plan_day_plan_block() {

	$args      = array(
		'orderby'        => 'date',
		'order'          => 'ASC',
		'post_type'      => 'plan',
		'posts_per_page' => 28,
	);
	$the_query = new WP_Query( $args );
	?>
	<div class="daily-plan-block">
		<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<a href="<?php the_permalink(); ?>" class="day id-<?php the_ID(); ?> state">
				<div class="plan-content"><?php the_title(); ?></div>
			</a>
		<?php endwhile; ?><?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>

<?php
}

/**
 * Outputs the featured video shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_video_block() {
	include( LSX_HEALTH_PLAN_PATH . '/templates/featured-videos.php' );
}

/**
 * Outputs the featured recipes shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_recipes_block() {
	include( LSX_HEALTH_PLAN_PATH . '/templates/featured-recipes.php' );
}
