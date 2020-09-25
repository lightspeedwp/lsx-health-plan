<?php
/**
 * Template used to display the overview for the current section.
 *
 * @package lsx-health-plan
 */

$section_key  = get_query_var( 'section' );
$endpoint_key = get_query_var( 'endpoint' );
if ( '' !== $section_key && '' === $endpoint && \lsx_health_plan\functions\plan\has_sections() ) {
	$section_info = \lsx_health_plan\functions\plan\get_section_info( $section_key );
	if ( isset( $section_info['description'] ) && '' !== $section_info['description'] ) {
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
					echo wp_kses_post( apply_filters( 'the_content', $section_info['description'] ) );

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
							<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>

			<?php lsx_entry_bottom(); ?>

		</article><!-- #post-## -->

		<?php
	}
}
?>
