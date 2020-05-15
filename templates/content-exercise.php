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
		<?php lsx_health_plan_exercise_title( '<h2 class="title-lined">', '</h2>' ); ?>
		<div class="row">
			<div class="col-md-6 exercise-image lsx-hp-shadow">
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
				lsx_health_plan_gallery();
				?>



				<?php if ( ( ! empty( $type ) ) || ( ! empty( $equipment ) ) || ( ! empty( $muscle_group ) ) ) { ?>
					<table class="exercise-table">
						<tbody>
							<?php
							if ( ! empty( $type ) ) {
							?>
								<tr class="types">
									<td><?php esc_html_e( 'Type:', 'lsx-health-plan' ); ?>&nbsp</td>
									<td>
									<?php
										echo wp_kses_post( $type );
									?>
									</td>
								</tr>
							<?php
							}
							?>
							<?php
							if ( ! empty( $muscle_group ) ) {
							?>
								<tr class="muscle-group">
									<td><?php esc_html_e( 'Muscle Group:', 'lsx-health-plan' ); ?>&nbsp</td>
									<td>
									<?php
										echo wp_kses_post( $muscle_group );
									?>
									</td>
								</tr>
							<?php
							}
							?>
							<?php
							if ( ! empty( $equipment ) ) {
							?>
								<tr class="equipment">
									<td><?php esc_html_e( 'Equipment:', 'lsx-health-plan' ); ?>&nbsp</td>
									<td>
									<?php
										echo wp_kses_post( $equipment );
									?>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				<?php } ?>
			</div>
			<div class="col-md-6 exercise-content">
				<?php the_content(); ?>
				<div  class="back-plan-btn">
				<?php
				if ( function_exists( 'wc_get_page_id' ) ) {
					?>
					<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Back To My Plan', 'lsx-health-plan' ); ?></a>
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
