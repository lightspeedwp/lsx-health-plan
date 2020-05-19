<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

$type         = lsx_health_plan_exercise_type();
$equipment    = lsx_health_plan_exercise_equipment();
$muscle_group = lsx_health_plan_muscle_group_equipment();
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div id="single-exercise" class="entry-content">

		<div class="exercise-title-section title-lined">
			<?php if ( class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) : ?>

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

			<?php lsx_health_plan_exercise_title( '<h2>', '</h2>' ); ?>

		</div>

		<div class="row">
			<div class="col-md-6 exercise-image lsx-hp-shadow">
				<?php lsx_health_plan_gallery(); ?>
				<?php
				$featured_image = get_the_post_thumbnail();
				if ( ! empty( $featured_image ) && '' !== $featured_image ) {
					the_post_thumbnail( 'large', array(
						'class' => 'aligncenter',
					) );
				} else {
					?>
					<img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
					<?php
				}
				?>



				<?php if ( ( ! empty( $type ) ) || ( ! empty( $equipment ) ) || ( ! empty( $muscle_group ) ) ) { ?>
					<div class="exercise-data">
						<?php lsx_health_plan_exercise_data(); ?>
					</div>
				<?php } ?>
			</div>
			<div class="col-md-6 exercise-content">
				<?php the_content(); ?>
				<div  class="back-plan-btn">
				<?php
				if ( function_exists( 'wc_get_page_id' ) ) {
					?>
					<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Smashed it! Back to my exercises', 'lsx-health-plan' ); ?></a>
					<?php
				}
				?>
				</div>
			</div>
		</div>
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
	</div><!-- .entry-content -->

	<footer class="footer-meta clearfix">
		<?php if ( has_tag() ) : ?>
			<?php lsx_content_post_tags(); ?>
		<?php endif ?>
	</footer>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();
