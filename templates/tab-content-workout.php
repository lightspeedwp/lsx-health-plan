<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

global $shortcode_args;

// Getting translated endpoint.
$workout = \lsx_health_plan\functions\get_option( 'endpoint_workout', 'workout' );

$connected_members  = get_post_meta( get_the_ID(), ( $workout . '_connected_team_member' ), true );
$connected_articles = get_post_meta( get_the_ID(), ( $workout . '_connected_articles' ), true );

?>

<?php lsx_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
					'after'       => '</div></div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				)
			);
		?>
		<div class="single-plan-inner workout-content">
			<?php
			if ( is_singular( 'workout' ) ) { ?>
				<div class="single-plan-section-title workout title-lined">
					<?php lsx_get_svg_icon( 'work.svg' ); ?>
					<h2><?php the_title(); ?></h2>
				</div>
			<?php } else { ?>
				<div class="single-plan-section-title workout title-lined">
					<?php lsx_get_svg_icon( 'work.svg' ); ?>
					<h2><?php esc_html_e( 'My Workout', 'lsx-health-plan' ); ?></h2>
				</div>
			<?php } ?>
			<?php echo wp_kses_post( lsx_hp_member_connected( $connected_members, $workout ) ); ?>
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
							<?php if ( null === $shortcode_args ) { ?>
								<div class="tip-row extras-box">
									<?php if ( post_type_exists( 'tip' ) && lsx_health_plan_has_tips() ) { ?>
										<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block tab="' . $workout . '"]' ); ?>
									<?php } ?>
								</div>
							<?php } ?>
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

<?php
if ( ! empty( $connected_articles ) ) {
	lsx_hp_single_related( $connected_articles, __( 'Related articles', 'lsx-health-plan' ) );
}
?>

<?php
lsx_entry_after();

