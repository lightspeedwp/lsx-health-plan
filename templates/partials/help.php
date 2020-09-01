<?php
	$lsx_hp_documentation = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/getting-started/' );
	$lsx_hp_settings      = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/installation/' );
	$lsx_hp_features      = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/' );
	$version              = esc_html( LSX_HEALTH_PLAN_VER );

	//Product Urls
	$health_plan_link  = esc_url( 'https://wordpress.org/plugins/lsx-health-plan/' );
	$lsx_hp_plans      = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/plans/' );
	$lsx_hp_weeks      = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/plans/#week' );
	$lsx_hp_tips       = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/tips/' );
	$lsx_hp_workouts   = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/workouts/' );
	$lsx_hp_exercises  = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/exercises/' );
	$lsx_hp_meals      = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/meals/' );
	$lsx_hp_recipes    = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/recipes/' );
	$lsx_hp_shortcodes = esc_url( 'https://www.lsdev.biz/lsx/documentation/lsx-health/shortcodes/' );
	
?>

<div class="row">
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-12">
				<div class="box documentation">
					<h2><?php esc_html_e( 'Getting Support', 'lsx-health-plan' ); ?></h2>
					<p><?php esc_html_e( 'Our website\'s', 'lsx-health-plan' ); ?> <a href="<?php echo wp_kses_post( $lsx_hp_documentation ); ?>" target="_blank"><?php esc_html_e( 'documentation', 'lsx-health-plan' ); ?></a> <?php esc_html_e( 'page is a great place to start to learn how to configure and customize our plugin. Here are some links to some of the key settings and modules:', 'lsx-health-plan' ); ?></p>

					<ul>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_documentation ); ?>" target="_blank"><?php esc_html_e( 'Getting Started:', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( 'Setup a new Health Plan site from scratch.', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_settings ); ?>" target="_blank"><?php esc_html_e( 'Settings overview:', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( 'A thorough walkthrough of The Health Plan site configuration options and the settings that are available to you.', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_features ); ?>" target="_blank"><?php esc_html_e( 'Features overview:', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( 'A complete look at the features you can expect to see right out of the box as well as how to use them.', 'lsx-health-plan' ); ?></li>

						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_plans ); ?>" target="_blank"><?php esc_html_e( 'Plans', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Parent Post Type)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_weeks ); ?>" target="_blank"><?php esc_html_e( 'Weeks', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Global Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_tips ); ?>" target="_blank"><?php esc_html_e( 'Tips', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Global Post type connected to all other post types)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_workouts ); ?>" target="_blank"><?php esc_html_e( 'Workouts', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Plans Child Post Type)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_exercises ); ?>" target="_blank"><?php esc_html_e( 'Exercises', 'lsx-health-plan' ); ?></a></strong>  <?php esc_html_e( '(Workouts Child Post Type)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_exercises ); ?>" target="_blank"><?php esc_html_e( 'Exercise Types', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Exercises Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_exercises ); ?>" target="_blank"><?php esc_html_e( 'Equipment', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Exercises Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_exercises ); ?>" target="_blank"><?php esc_html_e( 'Muscle Group ', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Exercises Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_meals ); ?>" target="_blank"><?php esc_html_e( 'Meals', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Plans Child Post Type)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_recipes ); ?>" target="_blank"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Meal Plans Child Post Type)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_recipes ); ?>" target="_blank"><?php esc_html_e( 'Types', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Recipes Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_recipes ); ?>" target="_blank"><?php esc_html_e( 'Cuisines', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( '(Recipes Taxonomy)', 'lsx-health-plan' ); ?></li>
						<li><strong><a href="<?php echo wp_kses_post( $lsx_hp_shortcodes ); ?>" target="_blank"><?php esc_html_e( 'Shortcodes:', 'lsx-health-plan' ); ?></a></strong> <?php esc_html_e( 'Insert content blocks for any content type.', 'lsx-health-plan' ); ?></li>
					</ul>
				</div>
			</div>
		</div>


	</div>

	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				<div class="box info">
					<h2><?php esc_html_e( 'Health Plan', 'lsx-health-plan' ); ?></h2>

					<ul>
						<li><strong><?php esc_html_e( 'Latest Version:', 'lsx-health-plan' ); ?></strong> <?php echo esc_attr( $version ); ?></li>
						<li><strong><?php esc_html_e( 'Requires:', 'lsx-health-plan' ); ?></strong> <?php esc_html_e( 'WordPress 5.0+', 'lsx-health-plan' ); ?></li>
						<li><strong><?php esc_html_e( 'Tested up to:', 'lsx-health-plan' ); ?></strong> <?php esc_html_e( 'WordPress 5.0', 'lsx-health-plan' ); ?></li>
					</ul>

					<div class="more-button">
						<a href="<?php echo wp_kses_post( $health_plan_link ); ?>" target="_blank" class="button button-primary">
							<?php esc_html_e( 'Visit plugin website', 'lsx-health-plan' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="box news">
					<h3><?php esc_html_e( 'Support', 'lsx-health-plan' ); ?></h3>
					<p><?php esc_html_e( 'If the documentation is not getting you where you need to be, you can contact us directly for support and assistance.', 'lsx-health-plan' ); ?></p>
					<p><?php esc_html_e( 'You can contact us for support at', 'lsx-health-plan' ); ?> <a href="mailto:support@lsdev.biz"><?php esc_html_e( 'support@lsdev.biz.', 'lsx-health-plan' ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</div>