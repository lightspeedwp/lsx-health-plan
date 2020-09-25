<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */
global $shortcode_args;
?>

<?php lsx_entry_before(); ?>

<?php
$column_class = '4';
// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['columns'] ) ) {
		$column_class = $shortcode_args['columns'];
		$column_class = \lsx_health_plan\functions\column_class( $column_class );
	}
}
?>

<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_class ); ?>">
	<article class="lsx-slot box-shadow">
		<?php lsx_entry_top(); ?>

		<?php lsx_hp_recipe_plan_meta(); ?>

		<div class="recipe-feature-img">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			$featured_image = get_the_post_thumbnail();
			if ( ! empty( $featured_image ) && '' !== $featured_image ) {
				the_post_thumbnail( 'lsx-thumbnail-square', array(
					'class' => 'aligncenter',
				) );
			} else {
				?>
				<img loading="lazy" class="placeholder" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
				<?php
			}
			?>
			</a>
		</div>
		<div class="content-box white-bg">
			<?php lsx_health_plan_recipe_data(); ?>
			<a class="recipe-title-link" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title( '<h3 class="recipe-title">', '</h3>' ); ?>
			</a>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn border-btn"><?php esc_html_e( 'See Recipe', 'lsx-health-plan' ); ?></a>
		</div>
		<?php lsx_entry_bottom(); ?>
	</article>
</div>

<?php
lsx_entry_after();
