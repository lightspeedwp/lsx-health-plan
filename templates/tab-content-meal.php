<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

// Getting translated endpoint.
$meal = \lsx_health_plan\functions\get_option( 'endpoint_meal', 'meal' );

$connected_members  = get_post_meta( get_the_ID(), ( $meal . '_connected_team_member' ), true );
$connected_articles = get_post_meta( get_the_ID(), ( $meal . '_connected_articles' ), true );

?>

<?php lsx_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<div class="single-plan-inner meal-content">
			<?php
			if ( is_singular( 'meal' ) ) { ?>
				<div class="single-plan-section-title meal-plan title-lined">
					<?php lsx_get_svg_icon( 'meal.svg' ); ?>
					<h2><?php the_title(); ?></h2>

				</div>
			<?php } else { ?>
				<div class="single-plan-section-title meal-plan title-lined">
					<?php lsx_get_svg_icon( 'meal.svg' ); ?>
					<h2><?php esc_html_e( 'My Meal Plan', 'lsx-health-plan' ); ?> <?php the_title(); ?></h2>
				</div>
			<?php } ?>

			<?php require LSX_HEALTH_PLAN_PATH . 'templates/partials/meal-plans.php'; ?>
		</div>

	</div><!-- .entry-content -->
	<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
if ( ! empty( $connected_articles ) ) {
	lsx_hp_single_related( $connected_articles, __( 'Related articles', 'lsx-health-plan' ) );
}
?>

<?php
lsx_entry_after();
