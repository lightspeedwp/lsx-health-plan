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

	<div id="single-recipe" class="entry-content">
		<h2 class="title-lined"><?php the_title(); ?></h2>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 recipe-image">
				<?php
				the_post_thumbnail( 'large', array(
					'class' => 'aligncenter',
				) );
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 recipe-content">
				<div class="recipe-data">
					<?php lsx_health_plan_recipe_data(); ?>
				</div>
				<?php the_content(); ?>
			</div>
		</div>
	</div><!-- .entry-content -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();
