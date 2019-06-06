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
			//the_content();

			wp_link_pages( array(
				'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
				'after'       => '</div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
		<div class="single-plan-section-title recipes-plan">

			<h2 class="title-lined"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?> <span class="blue-title"><?php the_title(); ?></span></h2>
		</div>
		<div class="single-plan-inner recipes-content">
			<div class="recipes">
			<div class="row eating-row">
			<?php
			$connected_recipes = get_post_meta( get_the_ID(), 'connected_recipes', true );
			if ( empty( $connected_recipes ) ) {
				return;
			}
			$args    = array(
				'orderby'   => 'date',
				'order'     => 'DESC',
				'post_type' => 'recipe',
				'post__in'  => $connected_recipes,
			);
			$recipes = new WP_Query( $args );

			if ( $recipes->have_posts() ) {
				while ( $recipes->have_posts() ) {
					$recipes->the_post();
					$post_id = get_the_id();

					?>
					<div class="col-md-4 recipe-column">
						<div class="content-box box-shadow">
							<h3 class="recipe-title title-lined"><?php echo the_title(); ?></h3>
							<?php table_recipe_data(); ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-full">View Recipe</a>
						</div>
					</div>
				<?php
				}
			}
			?>
			<?php wp_reset_postdata(); ?>
			</div>
			</div>
		</div>
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
