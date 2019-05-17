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
		<div class="single-plan-section-title recipes-plan">
			<h2 class="title-lined">Recipes <span class="blue-title">Day 1</span></h2>
		</div>
		<div class="single-plan-inner recipes-content">
			<div class="recipes">
				<div class="row eating-row">
					<div class="col-md-4 recipe-column">
						<div class="content-box box-shadow">
							<h3 class="recipe-title title-lined">Marinated Hake</h3>
							<table class="recipe-table">
								<tbody>
									<tr>
										<td>Prep time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Cooking time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Serves:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Portion size:</td>
										<td>30 min</td>
									</tr>
								</tbody>
							</table>
							<a href="#" class="btn btn-full">View Recipe</a>
						</div>
					</div>
					<div class="col-md-4 recipe-column">
						<div class="content-box box-shadow">
							<h3 class="recipe-title title-lined">Fish Creole</h3>
							<table class="recipe-table">
								<tbody>
									<tr>
										<td>Prep time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Cooking time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Serves:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Portion size:</td>
										<td>30 min</td>
									</tr>
								</tbody>
							</table>
							<a href="#" class="btn btn-full">View Recipe</a>
						</div>
					</div>
					<div class="col-md-4 recipe-column">
						<div class="content-box box-shadow">
							<h3 class="recipe-title title-lined">Creamed Tuna</h3>
							<table class="recipe-table">
								<tbody>
									<tr>
										<td>Prep time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Cooking time:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Serves:</td>
										<td>30 min</td>
									</tr>
									<tr>
										<td>Portion size:</td>
										<td>30 min</td>
									</tr>
								</tbody>
							</table>
							<a href="#" class="btn btn-full">View Recipe</a>
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
