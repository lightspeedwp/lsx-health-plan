<?php
/**
 * LSX Health Plan Template Tags.
 *
 * @package lsx-health-plan
 */

/**
 * Outputs the workout box on the single plan page.
*
* @return void
*/
function lsx_health_plan_workout_box() {
	if ( ! post_type_exists( 'workout' ) ) {
		return;
	}
	$intro_text = \lsx_health_plan\functions\get_option( 'workout_intro', false );
	?>
	<div class="workout-instructions">
		<div class="row">
			<div class="col-md-12">
			<?php
			if ( false !== $intro_text ) {
				?>
				<div class="excerpt">
					<p><?php echo wp_kses_post( wpautop( $intro_text ) ); ?></p>
				</div>
				<?php
			} else {
				?>
				<div class="content-intro">
					<h3><?php esc_html_e( "Don't forget your warm up!", 'lsx-health-plan' ); ?></h3>
					<p><?php esc_html_e( 'Be sure to do the warm-up before every workout session.', 'lsx-health-plan' ); ?></p>
				</div>
				<?php
			} ?>
			</div>
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
	if ( ! post_type_exists( 'meal' ) ) {
		return;
	}
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title meal-plan-title title-lined"><?php esc_html_e( 'Your Meal Plan', 'lsx-health-plan' ); ?><?php lsx_get_svg_icon( 'meal.svg' ); ?></h3>
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
			$meal = \lsx_health_plan\functions\get_option( 'endpoint_meal', false );
			if ( false === $meal ) {
				$meal = 'meal';
			}
			?>
			<a href="<?php the_permalink(); ?><?php echo esc_attr( $meal ); ?>/" class="btn"><?php esc_html_e( 'View your meal plan', 'lsx-health-plan' ); ?></a>
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
	if ( ! post_type_exists( 'recipe' ) ) {
		return;
	}
	?>
	<div class="col-md-4" >
		<div class="lsx-health-plan-box">
			<h3 class="title recipes-title title-lined"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?><?php lsx_get_svg_icon( 'recipes.svg' ); ?></h3>
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
			$recipes = \lsx_health_plan\functions\get_option( 'endpoint_recipe', false );
			if ( false === $recipes ) {
				$recipes = 'recipes';
			}
			?>
			<a href="<?php the_permalink(); ?><?php echo esc_attr( $recipes ); ?>/" class="btn"><?php esc_html_e( 'View all recipes', 'lsx-health-plan' ); ?></a>
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
	<div class="col-md-4 day-download-box" >
		<div class="lsx-health-plan-box">
			<h3 class="title downloads-title title-lined"><?php esc_html_e( 'Downloads', 'lsx-health-plan' ); ?><?php lsx_get_svg_icon( 'download.svg' ); ?></h3>
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
			"><a class="my-plan-tab" href="<?php the_permalink(); ?>"><?php esc_html_e( 'My Plans', 'lsx-health-plan' ); ?></a></li>
			<?php
			if ( function_exists( 'WC' ) ) {
				?>
				<li class="
				<?php
				if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'edit-account' ) ) {
					echo esc_attr( 'active' );
				}
				?>
				"><a class="account-details-tab" href="<?php the_permalink(); ?>edit-account/"><?php esc_html_e( 'Account Details', 'lsx-health-plan' ); ?></a></li>
				<?php
			}
			if ( is_user_logged_in() ) {
				?>
					<li class=""><a class="logout-tab" href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Logout', 'lsx-health-plan' ); ?></a></li>
				<?php
			}
			?>
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
	<div class="lsx-health-plan my-profile-block wp-block-cover alignfull">
		<div class="wp-block-cover__inner-container">
			<h2><?php esc_html_e( 'My Dashboard', 'lsx-health-plan' ); ?></h2>
			<?php if ( ( function_exists( 'WC' ) || class_exists( 'WP_User_Avatar_Setup' ) ) && is_user_logged_in() ) { ?>
				<section id="dashboard-card">
					<?php if ( function_exists( 'WC' ) || class_exists( 'WP_User_Avatar_Setup' ) ) { ?>
						<div class="profile-navigation">
							<div class="profile-photo">
							<?php
								global $current_user;
								if ( function_exists( 'WC' ) ) {
									get_current_user();
								}
								if ( class_exists( 'WP_User_Avatar_Setup' ) ) {
									echo get_avatar( $current_user->ID, 240 );
								}
								?>
							</div>
						</div>
					<?php } ?>
					<?php if ( function_exists( 'WC' ) ) { ?>
						<div class="profile-details">
							<h1 class="title-lined has-text-color"><?php echo esc_html( $current_user->display_name ); ?></h1>
							<?php
							$disable_stats = \lsx_health_plan\functions\get_option( 'disable_all_stats', false );
							if ( 'on' !== $disable_stats && function_exists( 'WC' ) ) {

								$is_weight_disabled = \lsx_health_plan\functions\get_option( 'disable_weight_checkbox', false );
								$is_height_disabled = \lsx_health_plan\functions\get_option( 'disable_height_checkbox', false );
								$is_waist_disabled  = \lsx_health_plan\functions\get_option( 'disable_waist_checkbox', false );
								$is_bmi_disabled    = \lsx_health_plan\functions\get_option( 'disable_bmi_checkbox', false );

								$weight = get_user_meta( get_current_user_id(), 'weight', true );
								$waist  = get_user_meta( get_current_user_id(), 'waist', true );
								$height = get_user_meta( get_current_user_id(), 'height', true );

								$height_m = 0;
								if ( is_numeric( $height ) ) {
									$height_m = $height / 100;
								}

								if ( 1 < $weight && 1 < $height_m ) {
									$bmi = $weight / ( $height_m * $height_m );
									$bmi = number_format( $bmi, 1 );
								} else {
									$bmi = __( 'Add more data', 'lsx-health-plan' );
								}

								?>

								<div>
									<?php if ( 'on' !== $is_weight_disabled ) { ?>
										<span><strong><?php esc_html_e( 'Weight:', 'lsx-health-plan' ); ?></strong>
										<?php
										if ( '' !== $weight ) {
											echo wp_kses_post( $weight . ' kg' );
										} else {
											echo '/';
										}
										?>
										</span>
									<?php }
									if ( 'on' !== $is_waist_disabled ) {
										?>
										<span><strong><?php esc_html_e( 'Waist:', 'lsx-health-plan' ); ?></strong>
										<?php
										if ( '' !== $waist ) {
											echo wp_kses_post( $waist . ' cm' );
										} else {
											echo '/';
										}
										?>
										</span>
									<?php }
									if ( 'on' !== $is_bmi_disabled ) {
										?>
										<span><strong><?php esc_html_e( 'BMI:', 'lsx-health-plan' ); ?></strong>
										<?php
										if ( '' !== $bmi ) {
											echo wp_kses_post( $bmi );
										} else {
											echo '/';
										}
										?>
										</span>
									<?php } ?>
								</div>
							<?php
							}

							// Only display the edit account link if woocommerce is active.
							if ( function_exists( 'WC' ) ) {
								?>
								<div class="edit-profile">
									<?php
									if ( function_exists( 'wc_get_page_id' ) ) {
										$url_id = wc_get_page_id( 'myaccount' );
									} else {
										$url_id = '';
									}
									?>
									<a href="<?php echo esc_url( get_permalink( $url_id ) ); ?>edit-account/"><?php esc_html_e( 'Edit', 'lsx-health-plan' ); ?></a>
								</div>
								<?php
							}
							?>
						</div>
					<?php } ?>
				</section>
			<?php } ?>
		</div>
	</div>
	<?php
}

/**
 * Outputs the my profile list of plans box
 *
 * @return void
 */
function lsx_health_plan_all_plans_block() {
	global $post, $product;

	// If this is the my plan page, and the user is logged out, show to WC login.
	$plan_slug = \lsx_health_plan\functions\get_option( 'my_plan_slug', false );
	if ( function_exists( 'is_wc_endpoint_url' ) && false !== $plan_slug && is_page( $plan_slug ) && ! is_user_logged_in() ) {
		echo wp_kses_post( '<div id="edit-account-tab"><div class="edit-account-section">' );
		echo wp_kses_post( '<h2 class="title-lined my-plan"></h2>' );
		echo do_shortcode( '[woocommerce_my_account]' );
		echo wp_kses_post( '</div></div>' );
		return;
	}

	$args = array(
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_type'      => 'plan',
		'nopagin'        => true,
		'post_parent'    => 0,
	);

	if ( function_exists( '\lsx_health_plan\functions\woocommerce\get_membership_products' ) ) {
		$product_ids = \lsx_health_plan\functions\woocommerce\get_membership_products();
		if ( ! empty( $product_ids ) ) {
			$args['meta_query'] = array(
				'relation' => 'OR',
				array(
					'key'     => '_plan_product_id',
					'value'   => $product_ids,
					'compare' => 'IN',
				),
				array(
					'key'     => '_plan_product_id',
					'compare' => 'NOT EXISTS',
				),
			);
		}
	}

	$the_query = new WP_Query( $args );
	?>
	<div class="all-plans-block plan-grid block-all-plans-block">
		<div class="row">
			<?php
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					lsx_entry_before();
					$completed_class = '';
					$linked_product  = false;
					$restricted      = false;
					$product         = null;
					if ( function_exists( 'lsx_health_plan\functions\woocommerce\plan_has_products' ) && \lsx_health_plan\functions\woocommerce\plan_has_products() ) {
						$products       = \lsx_health_plan\functions\woocommerce\get_plan_products();
						$linked_product = wc_get_product( $products[0] );
						$product        = $linked_product;
					}
					if ( function_exists( 'wc_memberships_is_post_content_restricted' ) ) {
						$restricted = wc_memberships_is_post_content_restricted( get_the_ID() ) && ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
					}

					if ( lsx_health_plan_is_plan_complete() ) {
						$completed_class = 'completed';
					}
					$round_progress     = '';
					$completed_progress = '100';
					if ( false === $restricted ) {
						$round_progress = round( \lsx_health_plan\functions\get_progress( get_the_ID() ), 0 );
					}
					?>
					<div class="col-xs-12 col-sm-6 col-md-4">
						<article class="lsx-slot lsx-hp-shadow <?php echo esc_html( 'progress-') . $round_progress; ?>">
							<div class="plan-feature-img">
								<?php if ( (int)$completed_progress === (int)$round_progress ) { ?>
									<span class="featured-plan"><?php lsx_get_svg_icon( 'icon-completed.svg' ); ?></span>
								<?php } ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php
								$featured_image = get_the_post_thumbnail();
								if ( ! empty( $featured_image ) && '' !== $featured_image ) {
									the_post_thumbnail( 'lsx-thumbnail', array(
										'class' => 'aligncenter',
									) );
								} else {
									?>
									<img loading="lazy"  class="placeholder" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
									<?php
								}
								?>
								</a>
							</div>
							<div class="content-box plan-content-box">
								<h3 class="plan id-<?php the_ID(); ?> <?php echo esc_attr( $completed_class ); ?>"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
								<?php
									echo wp_kses_post( \lsx_health_plan\functions\hp_get_plan_type_meta( $post ) );
								?>
								<?php
								if ( false !== $linked_product && false !== $restricted ) {
									echo wp_kses_post( $linked_product->get_price_html() );
								}
								?>
								<div class="excerpt">
									<?php
									if ( ! has_excerpt() ) {
										$content = wp_trim_words( get_the_content(), 20 );
										$content = '<p>' . $content . '</pre>';
									} else {
										$content = apply_filters( 'the_excerpt', get_the_excerpt() );
									}
									echo wp_kses_post( $content );
									?>
								</div>
								<?php
								if ( false === $restricted ) {
									echo wp_kses_post( '<span class="progress"><progress class="bar" value="' . \lsx_health_plan\functions\get_progress( get_the_ID() ) . '" max="100"> ' . \lsx_health_plan\functions\get_progress( get_the_ID() ) . '% </progress><span>' . $round_progress . '%</span></span>' );
								}
								?>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>

<?php
}

/**
 * Outputs the my profile day view box
 *
 * @return void
 */
function lsx_health_plan_day_plan_block( $args = array() ) {
	$defaults = array(
		'plan' => '',
	);
	$args     = wp_parse_args( $args, $defaults );

	if ( isset( $args['plan'] ) && '' !== $args['plan'] && \lsx_health_plan\functions\plan\has_sections( $args['plan'] ) ) {
		$sections = \lsx_health_plan\functions\plan\get_sections();
		?>
		<div class="daily-plan-block day-grid">
			<?php
			foreach ( $sections as $section_key => $section_values ) {
				$defaults    = array(
					'title' => __( 'Day', 'lsx-health-plan' ) . ' ' . ( $section_key + 1 ),
				);
				$section_args = wp_parse_args( $section_values, $defaults );

				$completed_class = '';
				if ( lsx_health_plan_is_day_complete() ) {
					$completed_class = 'completed';
				}
				?>
				<a href="<?php echo esc_attr( \lsx_health_plan\functions\plan\get_permalink( $args['plan'], $section_args['title'] ) ); ?>" class="day id-<?php echo esc_attr( $section_key + 1 ); ?> <?php echo esc_attr( $completed_class ); ?>">
					<div class="plan-content"><?php echo esc_attr( $section_args['title'] ); ?></div>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
}

/**
 * Outputs the my profile week view box
 *
 * @param  array $args An array of arguments.
 * @return void
 */
function lsx_health_plan_week_plan_block( $args = array() ) {
	$defaults = array(
		'show_downloads' => false,
		'plan'           => '',
	);
	$args     = wp_parse_args( $args, $defaults );

	if ( isset( $args['plan'] ) && '' !== $args['plan'] && \lsx_health_plan\functions\plan\has_sections( $args['plan'] ) ) {
		$groups = \lsx_health_plan\functions\plan\get_sections( true );

		if ( ! empty( $groups ) ) {
			$counter    = 1;
			$group_open = false;

			foreach ( $groups as $group_key => $sections ) {
				$collapse_class = '';
				$group_title    = \lsx_health_plan\functions\plan\get_group_title( $sections );

				// Determine if the current week is complete.
				$day_ids = wp_list_pluck( $sections, 'title' );
				if ( false === $group_open ) {
					if ( 1 === $counter && ! \lsx_health_plan\functions\is_week_complete( false, $day_ids, $group_title ) ) {
						$collapse_class = 'in';
						$group_open   = true;
					} elseif ( ! \lsx_health_plan\functions\is_week_complete( false, $day_ids, $group_title ) ) {
						$collapse_class = 'in';
						$group_open   = true;
					}
				}

				// Determine if there are any weekly downloads.
				$week_downloads_view = '';
				if ( isset( $args['show_downloads'] ) && false !== $args['show_downloads'] ) {
					$weekly_downloads = \lsx_health_plan\functions\get_weekly_downloads( $group_key );
					if ( ! empty( $weekly_downloads ) ) {
						$week_downloads_view = 'week-downloads-view-on';
					}
				}
				?>
				<div class="daily-plan-block week-grid">
					<a href="#group-<?php echo esc_attr( $group_key ); ?>" data-toggle="collapse" class="week-title"><?php echo esc_attr( $group_title ); ?></a>
					<div id="group-<?php echo esc_attr( $group_key ); ?>" class="week-row collapse <?php echo esc_attr( $collapse_class ); ?>">
						<div class="week-row-inner <?php echo esc_html( $week_downloads_view ); ?>">
							<div class="week-meals-recipes-box">

								<?php if ( ! empty( $week_downloads_view ) ) { ?>
									<h3 class="title"><?php lsx_get_svg_icon( 'daily-plan.svg' ); ?><?php echo esc_html_e( 'Plan', 'lsx-health-plan' ); ?></h3>
								<?php } ?>

								<div class="week-meals-recipes-box-inner">
								<?php

								foreach ( $sections as $section_key => $section_values ) {

									$defaults    = array(
										'title' => __( 'Day', 'lsx-health-plan' ) . ' ' . ( $section_key + 1 ),
									);
									$section_args = wp_parse_args( $section_values, $defaults );

									$completed_class = '';
									if ( lsx_health_plan_is_day_complete( $args['plan'], $section_args['title'] ) ) {
										$completed_class = 'completed';
									}
									if ( $section_args['rest_day_enabled'] && ! $section_args['connected_meals'] ) {
										?>
										<span class="day id-<?php echo esc_attr( $section_key + 1 ); ?> <?php echo esc_attr( $completed_class ); ?>">
											<div class="plan-content"><?php echo esc_attr( $section_args['title'] ); ?></div>
										</span>
										<?php
									} else {
										?>
										<a href="<?php echo esc_attr( \lsx_health_plan\functions\plan\get_permalink( $args['plan'], $section_args['title'] ) ); ?>" class="day id-<?php echo esc_attr( $section_key + 1 ); ?> <?php echo esc_attr( $completed_class ); ?>">
											<div class="plan-content"><?php echo esc_attr( $section_args['title'] ); ?></div>
										</a>
										<?php
									}
								}
								?>
								</div>
							</div>
							<?php
							if ( ! empty( $week_downloads_view ) ) {
								lsx_health_plan_weekly_downloads( $weekly_downloads );
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
}

/**
 * Outputs the weekly downloads box.
 *
 * @param array $weekly_downloads An array of the download ids.
 * @return void
 */
function lsx_health_plan_weekly_downloads( $weekly_downloads = array() ) {
	if ( ! empty( $weekly_downloads ) ) {
		?>
		<div class="week-download-box">
			<h3 class="title"><?php lsx_get_svg_icon( 'download.svg' ); ?><?php echo esc_html_e( 'Downloads', 'lsx-health-plan' ); ?></h3>
			<ul class="week-download-box-list">
				<?php
				foreach ( $weekly_downloads as $weekly_download ) {
					?>
					<li><?php echo wp_kses_post( do_shortcode( '[download id="' . $weekly_download . '"]' ) ); ?></li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}
}

/**
 * Outputs the featured items of any type shortcode (intended for exercises)
 *
 * @return void
 */
function lsx_health_plan_items( $args = array() ) {
	global $shortcode_args;
	$shortcode_args = $args;
	include LSX_HEALTH_PLAN_PATH . '/templates/partials/shortcode-loop.php';
}

/**
 * Outputs the featured video shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_video_block() {
	if ( ! post_type_exists( 'video' ) ) {
		return;
	}
	include LSX_HEALTH_PLAN_PATH . '/templates/featured-videos.php';
}

/**
 * Outputs the featured recipes shortcode
 *
 * @return void
 */
function lsx_health_plan_featured_recipes_block() {
	if ( ! post_type_exists( 'recipe' ) ) {
		return;
	}
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
			<input type="hidden" name="lsx-health-plan-id" value="<?php echo esc_attr( \lsx_health_plan\functions\plan\generate_section_id() ); ?>" />
			<button class="btn cta-btn" type="submit"><?php esc_html_e( 'Complete Day', 'lsx-health-plan' ); ?></button>
		</form>
		<?php lsx_health_plan_back_to_plan_button(); ?>
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
			<input type="hidden" name="lsx-health-plan-id" value="<?php echo esc_attr( \lsx_health_plan\functions\plan\generate_section_id() ); ?>" />
			<button class="btn secondary-btn" type="submit"><?php esc_html_e( 'Im not done!', 'lsx-health-plan' ); ?></button>
		</form>
		<?php lsx_health_plan_back_to_plan_button(); ?>
	</div>
	<?php
}

/**
 * Outputs the Single Plan Endpoint Tabs
 *
 * @param string $button
 * @return void
 */
function lsx_health_plan_single_nav() {
	$tab_template_path = apply_filters( 'lsx_health_plan_single_nav_path', LSX_HEALTH_PLAN_PATH . '/templates/single-plan-tabs.php' );
	if ( '' !== $tab_template_path ) {
		require $tab_template_path;
	}
}

/**
 * Outputs the Single Plan Tab based on the endpoint
 *
 * @param string $button
 * @return void
 */
function lsx_health_plan_single_tabs() {
	$endpoint = get_query_var( 'endpoint' );
	switch ( $endpoint ) {
		case 'meal':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . '/templates/tab-content-meal.php';
			break;

		case 'recipes':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . '/templates/tab-content-recipes.php';
			break;

		case 'workout':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . '/templates/tab-content-workout.php';
			break;

		case 'warm-up':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . '/templates/tab-content-warm-up.php';
			break;

		default:
			$tab_template_path = LSX_HEALTH_PLAN_PATH . '/templates/tab-content-plan.php';
			break;
	}
	$tab_template_path = apply_filters( 'lsx_health_plan_single_tab_path', $tab_template_path );
	if ( '' !== $tab_template_path ) {
		include $tab_template_path;
	}
}

/**
 * Outputs the recipe info on a table.
 *
 * @return void
 */
function lsx_health_plan_recipe_data() {
	include LSX_HEALTH_PLAN_PATH . '/templates/table-recipe-data.php';
}

/**
 * Outputs the recipe type.
 *
 * @return recipe_type
 */
function lsx_health_plan_recipe_type() {
	$term_obj_list = get_the_terms( get_the_ID(), 'recipe-type' );
	$recipe_type   = $term_obj_list[0]->name;
	if ( ! empty( $recipe_type ) ) {
		return $recipe_type;
	}
}

/**
 * Outputs the modal button and registers the video modal to show.
 *
 * @param int $m
 * @param array $group
 * @return void
 */
function lsx_health_plan_workout_video_play_button( $m, $group, $echo = true ) {
	$workout_video = '';
	$giphy         = '';
	$youtube       = '';
	if ( isset( $group['connected_videos'] ) && '' !== $group['connected_videos'] ) {
		$workout_video = esc_html( $group['connected_videos'] );
		$giphy         = get_post_meta( $workout_video, 'video_giphy_source', true );
		$youtube       = esc_url( get_post_meta( $workout_video, 'video_youtube_source', 1 ) );
		$content       = get_post_field( 'post_content', $workout_video );
		$play_button   = '<button data-toggle="modal" data-target="#workout-video-modal-' . $m . '"><span class="fa fa-play-circle"></span></button>';

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

		if ( true === $echo ) {
			echo wp_kses_post( $play_button );
		} else {
			return $play_button;
		}
	}
}

/**
 * Outputs the recipe description if it is included.
 *
 * @return void
 */
function lsx_health_plan_recipe_archive_description() {
	$description = '';
	if ( is_post_type_archive( 'recipe' ) ) {
		$description = \lsx_health_plan\functions\get_option( 'recipe_archive_description', '' );
	} elseif ( is_post_type_archive( 'exercise' ) ) {
		$description = \lsx_health_plan\functions\get_option( 'exercise_archive_description', '' );
	} elseif ( is_tax() ) {
		$description = get_the_archive_description();
	}
	if ( '' !== $description ) {
		?>
		<div class="lsx-hp-archive-description row">
			<div class="col-xs-12 description-wrapper"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		</div>
		<?php
	}
}

/**
 * Outputs the Single Plan Workout main content.
 *
 * @return void
 */
function lsx_health_plan_workout_main_content() {
	// Getting translated endpoint.
	$workout = \lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' );

	$connected_members = get_post_meta( get_the_ID(), ( $workout . '_connected_team_member' ), true );
	$small_description = get_post_meta( get_the_ID(), ( $workout . '_short_description' ), true );

	$content = '';
	if ( $small_description || $connected_members || lsx_health_plan_has_tips() ) {
		$content .= '<div class="short-desc set-box set content-box entry-content">';
		$content .= '<div class="the-content">';
		$content .= lsx_hp_member_connected( $connected_members, $workout );
		$content .= '<span>' . $small_description . '</span>';
		$content .= '</div>';
		$content .= do_shortcode( '[lsx_health_plan_featured_tips_block]' );
		$content .= '</div>';
	}
	return $content;
}

/**
 * Outputs the Single Plan Workout main content.
 *
 * @return void
 */
function lsx_health_plan_meal_main_content() {
	// Getting translated endpoint.
	$meal = \lsx_health_plan\functions\get_option( 'endpoint_meal', 'meal' );

	$connected_members = get_post_meta( get_the_ID(), ( $meal . '_connected_team_member' ), true );
	$small_description = get_post_meta( get_the_ID(), ( $meal . '_short_description' ), true );

	$content_meal = '';
	if ( $small_description || $connected_members || lsx_health_plan_has_tips() ) {
		$content_meal .= '<div class="set-box set content-box entry-content">';
		$content_meal .= '<div class="the-content">';
		$content_meal .= lsx_hp_member_connected( $connected_members, $meal );
		$content_meal .= '<span>' . $small_description . '</span>';
		$content_meal .= '</div>';
		$content_meal .= do_shortcode( '[lsx_health_plan_featured_tips_block]' );
		$content_meal .= '</div>';
	}
	return $content_meal;
}


/**
 * Outputs the Single Plan Workout Tab based on the layout selected.
 *
 * @param  string $index
 * @return void
 */
function lsx_health_plan_workout_tab_content( $index = 1 ) {
	global $group_name,$shortcode_args;
	$group_name = 'workout_section_' . $index;
	if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
		$layout = strtolower( \lsx_health_plan\functions\get_option( 'workout_tab_layout', 'table' ) );

		// Check for shortcode overrides.
		if ( null !== $shortcode_args && isset( $shortcode_args['layout'] ) ) {
			$layout = $shortcode_args['layout'];
		}
	} else {
		$layout = 'table';
	}

	switch ( $layout ) {
		case 'list':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-list.php';
			break;

		case 'grid':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-grid.php';
			break;

		case 'table':
			$tab_template_path = LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-table.php';
			break;
	}
	$tab_template_path = apply_filters( 'lsx_health_plan_workout_tab_content_path', $tab_template_path );
	if ( '' !== $tab_template_path ) {
		include $tab_template_path;
	}
}

/**
 * This will detect and include the Workout sets loop.
 *
 * @return void
 */
function lsx_health_plan_workout_sets() {
	if ( is_singular( 'workout' ) ) {
		global $connected_workouts;
		$connected_workouts = array( get_the_ID() );
	}
	if ( is_singular( 'plan' ) ) {

		global $connected_workouts;

		$section_key  = get_query_var( 'section' );
		if ( '' !== $section && \lsx_health_plan\functions\plan\has_sections() ) {
			$section_info = \lsx_health_plan\functions\plan\get_section_info( $section_key );
			if ( isset( $section_info['connected_workouts'] ) && '' !== $section_info['connected_workouts'] ) {

				$connected_workouts = \lsx_health_plan\functions\prep_array( $section_info['connected_workouts'] );
			}
		}
	}
	$template_path = LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-sets.php';
	$template_path = apply_filters( 'lsx_health_plan_workout_set_template_path', $template_path );
	if ( '' !== $template_path && ! empty( $template_path ) ) {
		include $template_path;
	}
}

/**
 * This will detect and include the Warmup sets loop.
 *
 * @param [type] $connected_workouts
 * @return void
 */
function lsx_health_plan_warmup_sets( $connected_workouts ) {
	
	$template_path = LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-sets.php';
	$template_path = apply_filters( 'lsx_health_plan_workout_set_template_path', $template_path );
	if ( '' !== $template_path && ! empty( $template_path ) ) {
		include $template_path;
	}
}

/**
 * Outputs the recipes connected to the meal plan.
 *
 * @param array $args
 * @return void
 */
function lsx_hp_meal_plan_recipes( $args = array() ) {
	$defaults = array(
		'meal_id'   => false,
		'meal_time' => '',
		'modal'     => true,
	);
	$args     = wp_parse_args( $args, $defaults );
	// Looking for recipes.
	$connected_recipes = get_post_meta( $args['meal_id'], $args['meal_time'] . '_recipes', true );
	if ( ! empty( $connected_recipes ) ) {
		$query_args    = array(
			'orderby'   => 'date',
			'order'     => 'DESC',
			'post_type' => 'recipe',
			'post__in'  => $connected_recipes,
		);
		$recipes = new WP_Query( $query_args );
		?>
		<div class="recipes">
			<div class="row eating-row">
			<?php
			if ( $recipes->have_posts() ) {
				while ( $recipes->have_posts() ) {
					$recipes->the_post();
					if ( false !== $args['modal'] ) {
						\lsx_health_plan\functions\recipes\register_recipe_modal();
					}
					?>
					<div class="recipe-column">
						<a data-toggle="modal" data-target="#recipe-modal-<?php echo esc_attr( get_the_ID() ); ?>" href="#recipe-modal-<?php echo esc_attr( get_the_ID() ); ?>" class="recipe-box box-shadow">
							<div class="recipe-feature-img">
								<?php
								$featured_image = get_the_post_thumbnail();
								if ( ! empty( $featured_image ) && '' !== $featured_image ) {
									the_post_thumbnail( 'lsx-thumbnail-square', array(
										'class' => 'aligncenter',
									) );
								} else {
									?>
									<img loading="lazy" class="placeholder" src="<?php echo esc_attr( plugin_dir_url( __DIR__ ) . 'assets/images/placeholder.jpg' ); ?>">
									<?php
								}
								?>
							</div>
							<div class="recipe-content">
								<h3 class="recipe-title"><?php the_title(); ?></h3>
								<?php lsx_health_plan_recipe_data(); ?>
							</div>
						</a>
					</div>
				<?php
				}
			}
			wp_reset_postdata();
			?>
			</div>
		</div>
		<?php

	}
}

/**
 * Output the connected.
 */
function lsx_hp_recipe_plan_meta( $args = array() ) {
	$defaults = array();
	$top_level_plans = array();
	// Get meals this exercise is connected to.
	$plans = get_post_meta( get_the_ID(), 'connected_plans', true );
	if ( ! empty( $plans ) ) {
		$plan       = end( $plans );
		$has_parent = wp_get_post_parent_id( $plan );
		if ( 0 === $has_parent ) {
			$top_level_plans[] = $plan;
		} elseif ( false !== $top_level_plans ) {
			$top_level_plans[] = $has_parent;
		}
	}
	if ( ! empty( $top_level_plans ) && ( '' !== $top_level_plans ) ) {
		$top_level_plans = array_unique( $top_level_plans );
		$top_level_plan  = end( $top_level_plans );
		?>
			<span class="recipe-type recipe-parent"><?php echo esc_html( get_the_title( $top_level_plan ) ); ?></span>
		<?php
	}
}

/**
 * Output the connected.
 */
function lsx_hp_exercise_plan_meta() {

	$top_level_plans = array();

	// Get workouts this exercise is connected to.
	$workouts = get_post_meta( get_the_ID(), 'connected_workouts', true );

	if ( '' !== $workouts && ! is_array( $workouts ) ) {
		$workouts = array( $workouts );
	}
	if ( ! empty( $workouts ) ) {
		foreach ( $workouts as $workout ) {
			// Get the plans this workout is connected to.
			$plans = get_post_meta( $workout, 'connected_plans', true );

			if ( '' !== $plans && ! is_array( $plans ) ) {
				$plans = array( $plans );
			}
			if ( ! empty( $plans ) ) {
				foreach ( $plans as $plan ) {
					$has_parent = wp_get_post_parent_id( $plan );
					if ( 0 === $has_parent ) {
						$top_level_plans = $plan;
					} else {
						$top_level_plans = $has_parent;
					}
				}
			}
		}
	}

	if ( ! empty( $top_level_plans ) && ( '' !== $top_level_plans ) ) {
		$top_level_plans = array_unique( $top_level_plans );
		$top_level_plan  = end( $top_level_plans );
		?>
			<span class="recipe-type recipe-parent"><?php echo esc_html( get_the_title( $top_level_plan ) ); ?></span>
		<?php
	}
}

/**
 * Template for related content box for all singles.
 *
 * @param [type] $related_content
 * @return void
 */
function lsx_hp_single_related( $related_content, $post_type_text ) {
	?>
	<section id="lsx-hp-related">
		<div class="row lsx-related-posts lsx-related-posts-title">
			<div class="col-xs-12">
				<h2 class="lsx-related-posts-headline"><?php echo esc_html( $post_type_text ); ?></h2>
			</div>
		</div>
		<div class="row lsx-related-posts lsx-related-posts-content">
			<div class="col-xs-12">
				<div class="lsx-related-posts-wrapper">
					<?php
					$i = 0;
					foreach ( $related_content as $article ) {
						$post_title      = get_the_title( $article );
						$post_categories = wp_get_post_categories( $article );
						$post_link       = get_permalink( $article );

						$cats = array();
						?>
						<article id="post-<?php echo esc_html( $article ); ?>" class="lsx-slot post">
							<div class="entry-layout lsx-hp-shadow">
								<div class="entry-layout-content">
									<header class="entry-header">
										<div class="entry-image">
											<a href="<?php echo esc_url( $post_link ); ?>" class="thumbnail">
											<?php
											$featured_image = get_the_post_thumbnail( $article, 'lsx-thumbnail-wide' );
											if ( ! empty( $featured_image ) && '' !== $featured_image ) {
												echo wp_kses_post( $featured_image );
											} else {
												?>
												<img loading="lazy" class="placeholder" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
												<?php
											}
											?>
											</a>
										</div>
										<div class="entry-meta">
										<?php
										foreach ( $post_categories as $c ) {
											$cat = get_category( $c );
											/* Translators: %s: category name */
											$cats[] = '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" title="' . sprintf( esc_html__( 'Posts in %s', 'lsx-blog-customizer' ), $cat->name ) . '">' . $cat->name . '</a>';
										}
										if ( ! empty( $cats ) ) { ?>
											<div class="post-categories"><span></span><?php echo wp_kses_post( implode( ', ', $cats ) ); ?></div>
										<?php } ?>
										</div>
										<h2 class="entry-title">
											<a href="<?php echo esc_url( $post_link ); ?>">
												<?php echo esc_html( $post_title ); ?>
											</a>
										</h2>
									</header>
								</div>
							</div>
						</article>

					<?php
					if (++$i === 3) break;
					} ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Template for connected members.
 *
 * @param [type] $connected_members
 * @return void
 */
function lsx_hp_member_connected( $connected_members, $post_type ) {
	if ( ! empty( $connected_members ) ) {
		$content = '<div id="hp-connected-members" class="hp-connected-members connected-' . $post_type . '">';
		foreach ( $connected_members as $member ) {
			$post_link   = get_permalink( $member );
			$member_name = get_the_title( $member );
			$member_name = '<span class="lsx-team-name">' . $member_name . '</span>';

			$member_link = '<a href="' . $post_link . '" >' . $member_name . '</a>';

			$roles = '';
			$terms = get_the_terms( $member, 'team_role' );

			if ( $terms && ! is_wp_error( $terms ) ) {
				$roles = array();

				foreach ( $terms as $term ) {
					$roles[] = $term->name;
				}

				$roles = join( ', ', $roles );
			}
			$member_roles = '' !== $roles ? "<small class='lsx-team-roles'>$roles</small>" : '';

			$content .= '<p>' . $member_roles . ': ' . $member_link . '</p>';
		}
		$content .= '</div>';
		return $content;
	}
}
