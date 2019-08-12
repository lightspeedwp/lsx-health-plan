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
		<div class="single-plan-section-title meal-plan">
			<?php lsx_get_svg_icon( 'meal.svg' ); ?>
			<h2 class="title-lined"><?php esc_html_e( 'My Meal Plan', 'lsx-health-plan' ); ?> <span class="blue-title"><?php the_title(); ?></span></h2>
		</div>
		<div class="single-plan-inner meal-content">
			<div class="meals">
			<?php
			$connected_meals = get_post_meta( get_the_ID(), 'connected_meals', true );
			if ( empty( $connected_meals ) ) {
				return;
			}
			$args  = array(
				'orderby'   => 'date',
				'order'     => 'DESC',
				'post_type' => 'meal',
				'post__in'  => $connected_meals,
			);
			$meals = new WP_Query( $args );

			if ( $meals->have_posts() ) {
				while ( $meals->have_posts() ) {
					$meals->the_post();
					$post_id = get_the_id();

					$shopping_list = get_post_meta( get_the_ID(), 'meal_shopping_list', true );

					$breakfast       = get_post_meta( get_the_ID(), 'meal_breakfast', true );
					$breakfast_snack = get_post_meta( get_the_ID(), 'meal_breakfast_snack', true );
					$lunch           = get_post_meta( get_the_ID(), 'meal_lunch', true );
					$lunch_snack     = get_post_meta( get_the_ID(), 'meal_lunch_snack', true );
					$dinner          = get_post_meta( get_the_ID(), 'meal_dinner', true );
					?>
					<div class="row eating-row">
						<div class="col-md-4 eating-column">
							<div class="content-box">
								<?php
								if ( ! empty( $breakfast ) ) {
									echo '<h3 class="eating-title title-lined">' . wp_kses_post( 'Breakfast', 'lsx-health-plan' ) . '</h3>';
									echo wp_kses_post( $breakfast );
								}
								if ( ! empty( $breakfast_snack ) ) {
									echo '<h3>' . wp_kses_post( 'Snack', 'lsx-health-plan' ) . '</h3>';
									echo wp_kses_post( $breakfast_snack );
								}
								?>
							</div>
						</div>
						<div class="col-md-4 eating-column">
							<div class="content-box">
								<?php
								if ( ! empty( $lunch ) ) {
									echo '<h3 class="eating-title title-lined">' . wp_kses_post( 'Lunch', 'lsx-health-plan' ) . '</h3>';
									echo wp_kses_post( $lunch );
								}
								if ( ! empty( $lunch_snack ) ) {
									echo '<h3>' . wp_kses_post( 'Snack', 'lsx-health-plan' ) . '</h3>';
									echo wp_kses_post( $lunch_snack );
								}
								?>
							</div>
						</div>
						<div class="col-md-4 eating-column">
							<div class="content-box">
								<?php
								if ( ! empty( $dinner ) ) {
									echo '<h3 class="eating-title title-lined">' . wp_kses_post( 'Supper', 'lsx-health-plan' ) . '</h3>';
									echo wp_kses_post( $dinner );
								}
								?>
							</div>
						</div>
					</div>
				<?php
				}
			}
			?>
			<?php wp_reset_postdata(); ?>
			<div class="extra-title">
						<h2 class="title-lined"><?php wp_kses_post( 'Meal Plan', 'lsx-health-plan' ); ?><span><?php wp_kses_post( 'Extras', 'lsx-health-plan' ); ?></span></h2>
					</div>
					<div class="row tip-row extras-box">
						<?php
						$connected_recipes = get_post_meta( get_the_ID(), 'connected_recipes', true );
						if ( ! empty( $connected_recipes ) ) {
							?>
							<div class="col-md-4">
								<div class="content-box tip-left box-shadow">
									<h3 class="eating-title title-lined"><?php echo wp_kses_post( 'Recipes', 'lsx-health-plan' ); ?></h3>
									<p><?php echo wp_kses_post( 'If theres a recipe for the day you can find it here or under the recipes tab.', 'lsx-health-plan' ); ?></p>
									<a class="btn border-btn btn-full" href="<?php echo the_permalink(); ?>recipes"><?php echo wp_kses_post( 'View Recipe', 'lsx-health-plan' ); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
								</div>	
							</div>
						<?php } ?>
						<?php
						if ( ! empty( $shopping_list ) ) {
							?>
							<div class="col-md-4">
								<div class="content-box tip-middle box-shadow">
									<h3 class="eating-title title-lined"><?php echo wp_kses_post( 'Shopping List', 'lsx-health-plan' ); ?></h3>
									<p><?php echo wp_kses_post( 'Checkout the shopping list and make sure you have all the goodies you need!', 'lsx-health-plan' ); ?></p>
									<a class="btn border-btn btn-full" href="<?php echo esc_url( get_page_link( $shopping_list ) ); ?>" target="_blank"><?php echo wp_kses_post( 'View Shopping List', 'lsx-health-plan' ); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
								</div>	
							</div>
						<?php } ?>
						
						<div class="col-md-4">
							<div class="tip-right">
								<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>
							</div>
						</div>
					</div>
			</div>
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
