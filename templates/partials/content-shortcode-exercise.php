<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */
global $shortcode_args;

$column_class = '4';
// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['columns'] ) ) {
		$column_class = $shortcode_args['columns'];
		$column_class = \lsx_health_plan\functions\column_class( $column_class );
	}
}

lsx_entry_before();

$post_id        = get_the_id();
$featured_image = get_the_post_thumbnail_url( $post_id, $image_size );
?>
<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_class ); ?>">
	<div style="background-image:url('<?php echo esc_url( $featured_image ); ?>')" class="lsx-exercises-item bg-<?php echo esc_html( $image_size ); ?>">
		<?php
		if ( isset( $link ) && ( 'modal' === $link ) ) {
			echo wp_kses_post( lsx_health_plan_shortcode_exercise_button( $post_id, true ) );
		}

		if ( 'item' === $link ) {
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="exercise-link excerpt-<?php echo esc_html( $description ); ?>">
			<?php
		} else {
			?>
			<div class="exercise-link excerpt-<?php echo esc_html( $description ); ?>">
			<?php
		}
		?>

		<?php lsx_health_plan_exercise_title( '<h4 class="lsx-exercises-title">', '</h4>', false ); ?>
		<?php if ( isset( $description ) && ( 'none' !== $description ) ) { ?>
			<?php
			if ( 'excerpt' === $description ) {
				$excerpt = \lsx_health_plan\functions\hp_excerpt( $post_id );
				?>
				<p class="lsx-exercises-excerpt"><?php echo wp_kses_post( $excerpt ); ?></p>
			<?php } ?>
			<?php if ( 'full' === $description ) { ?>
				<?php echo wp_kses_post( get_the_content() ); ?>
			<?php } ?>
		<?php } ?>
		<?php
		if ( isset( $link ) && ( 'item' === $link ) ) {
		?>
			</a>
		<?php } else { ?>
			</div>
		<?php } ?>
	</div>
</div>
<?php
lsx_entry_after();
