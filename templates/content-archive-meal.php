<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */

$featured = get_post_meta( get_the_ID(), 'meal_featured_meal', true );
?>

<?php lsx_entry_before(); ?>

<div class="col-xs-12 col-sm-6 col-md-4">
	<article class="lsx-slot box-shadow">
		<?php lsx_entry_top(); ?>

		<?php lsx_hp_exercise_plan_meta(); ?>

		<div class="meal-feature-img">
			<?php if ( $featured ) { ?>
				<span class="featured-meal"><?php lsx_get_svg_icon( 'icon-featured.svg' ); ?></span>
			<?php } ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			$featured_image = get_the_post_thumbnail();
			if ( ! empty( $featured_image ) && '' !== $featured_image ) {
				the_post_thumbnail( 'lsx-thumbnail-square', array(
					'class' => 'aligncenter',
				) );
			} else {
				?>
				<img loading="lazy" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
				<?php
			}
			?>
			</a>
		</div>
		<div class="content-box meal-content-box white-bg">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title( '<h3 class="meal-title">', '</h3>' ); ?>
			</a>
			<?php
			if ( ! has_excerpt() ) {
				$content = wp_trim_words( get_the_content(), 20 );
				$content = '<p>' . $content . '</p>';
			} else {
				$content = apply_filters( 'the_excerpt', get_the_excerpt() );
			}
			echo wp_kses_post( $content );
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn border-btn"><?php esc_html_e( 'See meal', 'lsx-health-plan' ); ?></a>
		</div>
		<?php lsx_entry_bottom(); ?>
	</article>
</div>

<?php
lsx_entry_after();
