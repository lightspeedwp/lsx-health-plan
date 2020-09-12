<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

// Getting translated endpoint.

$archive_meals = \lsx_health_plan\functions\get_option( 'endpoint_meal_archive', 'meals' );
$meal          = \lsx_health_plan\functions\get_option( 'endpoint_meal', 'meal' );

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
					<?php if ( class_exists( 'LSX_Sharing' ) ) {
						lsx_content_sharing();
					} ?>
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
	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<div  class="back-plan-btn">
	<?php if ( is_single() && is_singular( 'meal' ) ) { ?>
		<a class="btn border-btn" href="/<?php echo $archive_meals; ?>"><?php esc_html_e( 'Back to meals', 'lsx-health-plan' ); ?></a>
	<?php } ?>

	<?php
	// Shoping list
	$shopping_list = get_post_meta( get_the_ID(), 'meal_shopping_list', true );
	if ( ! empty( $shopping_list ) ) {
		?>
		<a class="btn border-btn btn-shopping" href="<?php echo esc_url( get_page_link( $shopping_list ) ); ?>" target="_blank"><?php esc_html_e( 'Download Shopping List', 'lsx-health-plan' ); ?><i class="fa fa-download" aria-hidden="true"></i></a>
	<?php
	}

	?>
</div>

<?php
if ( ! empty( $connected_articles ) ) {
	lsx_hp_single_related( $connected_articles, __( 'Related articles', 'lsx-health-plan' ) );
}
