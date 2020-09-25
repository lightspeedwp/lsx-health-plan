<?php
/**
 * The Template for displaying the single day plan and its connected items
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

<?php
$args = array(
	'post_parent' => get_the_ID(),
	'post_type'   => 'plan',
);

$plan_id      = get_the_ID();
$has_sections = \lsx_health_plan\functions\plan\has_sections( $plan_id );
$restricted   = false;
$is_section   = get_query_var( 'section', false );

// Getting translated endpoint.
$plan = \lsx_health_plan\functions\get_option( 'endpoint_plan', 'plan' );

$connected_members  = get_post_meta( get_the_ID(), ( $plan . '_connected_team_member' ), true );
$connected_articles = get_post_meta( get_the_ID(), ( $plan . '_connected_articles' ), true );
$small_description  = get_post_meta( get_the_ID(), ( $plan . '_short_description' ), true );

if ( ! empty( $has_sections ) && empty( $is_section ) ) {
	$plan_type_class = 'parent-plan';
}
if ( ! empty( $has_sections ) && ! empty( $is_section ) ) {
	$plan_type_class = 'child-plan';
}

// Get the plan restrictions.
if ( function_exists( 'wc_memberships_is_post_content_restricted' ) && wc_memberships_is_post_content_restricted( get_the_ID() ) ) {
	$restricted = ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
}
if ( false === $restricted ) {
	$round_progress = round( \lsx_health_plan\functions\get_progress( get_the_ID() ), 0 );
}
?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>

	<main id="main" class="site-main <?php echo esc_html( $plan_type_class ); ?>" role="main">

		<?php lsx_content_top(); ?>

		<div class="post-wrapper">
			<?php if ( ! empty( $has_sections ) && empty( $is_section ) ) { ?>
				<div class="plan-content">
					<?php the_content(); ?>
				</div>
			<?php } ?>

			<?php
			if ( ! empty( $has_sections ) ) {
				if ( false === $is_section ) {
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<div class="single-plan-inner main-plan-content">
								<div class="single-plan-section-title title-lined">
									<?php lsx_get_svg_icon( 'my-plan.svg' ); ?>
									<h2><?php echo esc_html_e( 'Your Plan', 'lsx-health-plan' ); ?></h2>
									<?php if ( class_exists( 'LSX_Sharing' ) ) {
										lsx_content_sharing();
									} ?>
								</div>
								<div class="plan">
									<div class="set-box set content-box entry-content">
										<div class="plan-top-content">
										<?php
										if ( $connected_members ) {
											echo wp_kses_post( lsx_hp_member_connected( $connected_members, $plan ) );
										}
										if ( false === $restricted ) {
											echo wp_kses_post( '<span class="progress"><progress class="bar" value="' . $round_progress . '" max="100"> ' . $round_progress . '% </progress><span>' . $round_progress . '%</span></span>' );
										}
										if ( $small_description ) {
											?>
											<div class="the-content">
												<span><?php echo esc_html( $small_description ); ?></span>
											</div>
											<?php
										}
										?>
										</div>
										<?php
										if ( lsx_health_plan_has_tips() ) {
											echo wp_kses_post( do_shortcode( '[lsx_health_plan_featured_tips_block]' ) );
										} ?>
									</div>
									<div class="the-plan-content">
										<?php
										echo do_shortcode( '[lsx_health_plan_day_plan_block week_view="true" show_downloads="true" plan="' . get_the_ID() . '"]' );

										?>
										<div class="row status-plan-buttons main-plan-btn">
											<?php
											if ( function_exists( 'wc_get_page_id' ) ) {
												?>
												<a class="btn border-btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'My Plans', 'lsx-health-plan' ); ?></a>
												<?php
											}
											?>
										</div>
									</div>
								</div>

							</div>
						</div><!-- .entry-content -->
					</article>
					<?php
				} else {
					lsx_health_plan_single_nav();
					lsx_health_plan_single_tabs();
				}
			}
			?>
		</div>

		<?php
		// Show the buttons on the single plan tabs.
		if ( ! empty( $has_sections ) && false !== $is_section ) {
			?>
			<div class="row status-plan-buttons">
				<?php lsx_health_plan_day_button(); ?>
			</div>
			<?php
		}
		?>

		<?php lsx_content_bottom(); ?>

		<?php
		if ( ! empty( $connected_articles ) ) {
			lsx_hp_single_related( $connected_articles, __( 'Latest articles', 'lsx-health-plan' ) );
		}
		?>


	</main><!-- #main -->

	<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php
get_footer();
