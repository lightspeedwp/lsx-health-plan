<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

global $shortcode_args;

?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<div class="overview">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="lsx-postnav-wrapper"><div class="lsx-postnav">',
				'after'       => '</div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
		</div>
	</div><!-- .entry-content -->
	<?php if ( null === $shortcode_args ) { ?>
		<?php if ( post_type_exists( 'tip' ) && lsx_health_plan_has_tips() ) { ?>
			<div class="tip-row extras-box">
				<div class="tip-right">
					<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block' ); ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
lsx_entry_after();
