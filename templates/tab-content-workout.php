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
		<div class="single-plan-inner workout-content">
			<div class="set workout-content-box">
				<h3 class="set-title">Set One:</h3>
				<div class="set-content">
					<p>Do three rounds before moving on to set two. Take a short rest once you’ve completed all reps of a particular exercise. Take a longer rest (up to a minute) between rounds.</p>
				</div>
				<div class="set-table">
					<table class="workout-table">
						<tbody>
							<tr>
								<th>Workout</th> 
								<th class="center-mobile">Reps / Time / Distance</th>
								<th class="center-mobile">Video</th>
							</tr>
							<tr>
								<td class="workout-title-item">Push-up rotation</td>
								<td class="reps-field-item center-mobile">10 REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
							<tr>
								<td class="workout-title-item">Back lunge to hammer curl press</td>
								<td class="reps-field-item center-mobile">12REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
							<tr>
								<td class="workout-title-item">Speed skaters</td>
								<td class="reps-field-item center-mobile">45 REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-626">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="set workout-content-box">
				<h3 class="set-title">Set One:</h3>
				<div class="set-content">
					<p>Do three rounds before moving on to set two. Take a short rest once you’ve completed all reps of a particular exercise. Take a longer rest (up to a minute) between rounds.</p>
				</div>
				<div class="set-table">
					<table class="workout-table">
						<tbody>
							<tr>
								<th>Workout</th> 
								<th class="center-mobile">Reps / Time / Distance</th>
								<th class="center-mobile">Video</th>
							</tr>
							<tr>
								<td class="workout-title-item">Push-up rotation</td>
								<td class="reps-field-item center-mobile">10 REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
							<tr>
								<td class="workout-title-item">Back lunge to hammer curl press</td>
								<td class="reps-field-item center-mobile">12REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
							<tr>
								<td class="workout-title-item">Speed skaters</td>
								<td class="reps-field-item center-mobile">45 REPS</td>
								<td class="video-button-item center-mobile">
									<a href="#" data-toggle="modal" data-target="#sftw-626">
										<span class="fa fa-play-circle"></span>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
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
