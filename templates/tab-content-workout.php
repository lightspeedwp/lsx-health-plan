<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

global $shortcode_args;

// Getting translated endpoint.
$archive_workout = \lsx_health_plan\functions\get_option( 'endpoint_workout_archive', 'workout' );
$workout         = \lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' );

$connected_articles = get_post_meta( get_the_ID(), ( $workout . '_connected_articles' ), true );

?>

<?php lsx_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->
	<?php
		the_content();
	?>
	<div class="entry-content">
		<div class="single-plan-inner workout-content">
			<?php
			if ( is_singular( 'workout' ) ) { ?>
				<div class="single-plan-section-title workout title-lined">
					<?php lsx_get_svg_icon( 'work.svg' ); ?>
					<h2><?php the_title(); ?></h2>
					<?php if ( class_exists( 'LSX_Sharing' ) ) {
						lsx_content_sharing();
					} ?>
				</div>
			<?php } else { ?>
				<div class="single-plan-section-title workout title-lined">
					<?php lsx_get_svg_icon( 'work.svg' ); ?>
					<h2><?php esc_html_e( 'My Workout', 'lsx-health-plan' ); ?></h2>
				</div>
			<?php } ?>
			<?php
			if ( lsx_health_plan_has_warmup() && ( ! is_singular( 'workout' ) ) ) {
				?>
				<div class="workout-instructions">
					<div class="row">
						<div class="col-md-12">
							<div class="content-intro">
								<h3><?php esc_html_e( "Don't forget your warm up!", 'lsx-health-plan' ); ?></h3>
								<p><?php esc_html_e( 'Be sure to do the warm-up before every workout session.', 'lsx-health-plan' ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<?php lsx_health_plan_workout_sets(); ?>
		</div>
	</div><!-- .entry-content -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->
<?php if ( is_singular( $workout ) ) { ?>
	<div  class="back-plan-btn">
		<a class="btn" href="/<?php echo $archive_workout; ?>"><?php esc_html_e( 'Back to workouts', 'lsx-health-plan' ); ?></a>
	</div>
<?php } ?>
<?php
if ( ! empty( $connected_articles ) ) {
	lsx_hp_single_related( $connected_articles, __( 'Related articles', 'lsx-health-plan' ) );
}
