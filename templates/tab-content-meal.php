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
		<div class="single-plan-section-title meal-plan">
			<h2 class="title-lined">My Meal Plan <span class="blue-title">Day 1</span></h2>
		</div>
		<div class="single-plan-inner meal-content">
			<div class="meals">
				<div class="row eating-row">
					<div class="col-md-4 eating-column">
						<div class="content-box">
							<h3 class="eating-title title-lined">Breakfast</h3>
							<p class="workout-title-item"></p>
							<ul>
								<li>1 slice toast OR 2 rice cakes</li>
								<li>3⁄4 tbsp nut butter</li>
								<li>Cinnamon to sprinkle on oats (optional)</li>
							</ul>
							<h3>Snack</h3>
							<p class="reps-field-item"></p>
							<ul>
								<li>1 fruit e.g. 1 apple</li>
								<li>1 tbsp nuts or seed mix</li>
								<li>100g fat-free yoghurt</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4 eating-column">
						<div class="content-box">
							<h3 class="eating-title title-lined">Lunch</h3>
							<p class="workout-title-item"></p>
							<ul>
								<li>6 cracker breads OR 4 rice cakes</li>
								<li>4 tbsp low-fat cottage cheese</li>
								<li>2 tsp salad dressing Salad</li>
							</ul>
							<h3>Snack</h3>
							<p class="reps-field-item"></p>
							<ul>
								<li>1 fruit e.g. 1 apple</li>
								<li>1 tbsp nuts or seed mix</li>
								<li>100g fat-free yoghurt</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4 eating-column">
						<div class="content-box">
							<h3 class="eating-title title-lined">Supper</h3>
							<p class="workout-title-item"></p>
							<ul>
								<li>1 baked potato</li>
								<li>90g chicken kebab, grilled (lemon and herb)</li>
								<li>1 cup cooked vegetables OR salad</li>
								<li>2 tsp salad dressing</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="extra-title">
					<h2 class="title-lined">Meal Plan <span>Extras</span></h2>
				</div>
				<div class="row tip-row extras-box">
					<div class="col-md-4">
						<div class="content-box tip-left box-shadow">
							<h3 class="eating-title title-lined">Recipes</h3>
							<p>If theres a recipe for the day you can find it here or under the recipes tab.</p>
							<a class="btn border-btn btn-full" href="#" target="_blank">View Recipe<i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="content-box tip-middle box-shadow">
							<h3 class="eating-title title-lined">Shopping List</h3>
							<p>Checkout the shopping list and make sure you have all the goodies you need!</p>
							<a class="btn border-btn btn-full" href="#" target="_blank">View Shopping List<i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="content-box tip-right box-shadow">
							<div class="diet-tip-wrapper">
								<div class="row quick-tip">
									<h3 class="title-lined">Top Top</h3>
									<div id="quick-tip" class="carousel slide" data-ride="carousel">
										<!-- Wrapper for slides -->
										<div class="carousel-inner">
											<div class="carousel-item active">
												<div class="col-sm-6 col-xs-6">
													<div class="tipimage">
														<img src="https://lsx-health-plan.feedmybeta.com/wp-content/uploads/2019/05/bolognaise.jpg" class="attachment-thumbnail size-thumbnail" alt="tip">
													</div>
												</div>
												<div class="col-sm-6 col-xs-6">
													<h4>AXE DIET FATIGUE:</h4>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
												</div> 
											</div>
											<div class="carousel-item ">
												<div class="col-sm-6 col-xs-6">
													<div class="tipimage">
														<img src="https://lsx-health-plan.feedmybeta.com/wp-content/uploads/2019/05/bolognaise.jpg" class="attachment-thumbnail size-thumbnail" alt="tip">
													</div>
												</div>
												<div class="col-sm-6 col-xs-6">
													<h4>AXE DIET 2:</h4>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
												</div> 
											</div>
										</div>
										<!-- Indicators -->
										<ol class="carousel-indicators">
											<li data-target="#quick-tip" data-slide-to="0" class="active"></li>	
											<li data-target="#quick-tip" data-slide-to="1"></li>	
										</ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->

	<div class="single-plan-inner-buttons">
		<div class="complete-plan-btn">
			<a class="btn cta-btn" href="#"><?php esc_html_e( 'COMPLETE DAY', 'lsx-health-plan' ); ?></a>
		</div>
		<div  class="back-plan-btn">
			<a class="btn" href="#"><?php esc_html_e( 'BACK TO MY PLAN', 'lsx-health-plan' ); ?></a>
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
							$custom_likes = new Jetpack_Likes;
							echo wp_kses_post( $custom_likes->post_likes( '' ) );
						}
					}
				?>
		<?php endif ?>
	</footer><!-- .footer-meta -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php lsx_entry_after();
