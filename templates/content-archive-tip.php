<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */

lsx_entry_before();
$tip_id         = get_the_id();
$featured_image = get_the_post_thumbnail( $tip_id, array( 600, 300 ) );
?>
<div class="diet-tip-wrapper quick-tip">
	<h3 class="title-lined"><?php the_title(); ?></h3>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="tipimage">
			<?php
			if ( ! empty( $featured_image ) && '' !== $featured_image ) {
				?>
				<div class="thumbnail tip-thumbnail"><?php echo wp_kses_post( $featured_image ); ?></div>
				<?php
			} else {
				?>
				<div class="thumbnail tip-thumbnail"><img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/TipPlaceholder.png' ); ?>"></div>
				<?php
			}
			?>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<?php the_content(); ?>
		</div> 
	</div>
</div>
<?php
lsx_entry_after();
