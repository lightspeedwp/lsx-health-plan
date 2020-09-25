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
$content_setting = 'excerpt';
$column_class    = '4';
$link_html       = '';
$link_close      = '';

// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['columns'] ) ) {
		$column_class = $shortcode_args['columns'];
		$column_class = \lsx_health_plan\functions\column_class( $column_class );
	}
	if ( isset( $shortcode_args['link'] ) ) {
		$link_setting = $shortcode_args['link'];
		// Setup our link and content.
		switch ( $link_setting ) {
			case 'single':
				$link_html  = '<a href="' . get_permalink( $group['connected_exercises'] ) . '">';
				$link_close = '</a>';
				break;

			case 'modal':
				$link_html  = '<a class="btn border-btn" data-toggle="modal" href="#workout-exercise-modal-' . $group['connected_exercises'] . '">';
				$link_close = '</a>';
				$modal_content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_modal_content', 'excerpt' );
				$modal_args = array(
					'modal_content' => $modal_content_setting,
				);
				// We call the button to register the modal, but we do not output it.
				lsx_health_plan_workout_exercise_button( $group['connected_exercises'], $group, false, $modal_args );
				break;

			case 'none':
			default:
				$link_html  = '';
				$link_close = '';
				break;
		}
	}
	if ( isset( $shortcode_args['description'] ) ) {
		$content_setting = $shortcode_args['description'];
	}
}

?>

<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_class ); ?> has-content-<?php echo esc_attr( $content_setting ); ?>">
	<article class="lsx-slot box-shadow">
		<?php lsx_entry_top(); ?>

		<div class="exercise-feature-img">
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
		<div class="content-box exercise-content-box white-bg">
			<div class="title-lined">
				<?php lsx_health_plan_exercise_title( '<h3 class="exercise-title">', '</h3>' ); ?>
				<?php lsx_health_plan_exercise_data(); ?>
			</div>
			<?php
			if ( '' !== $content_setting && 'excerpt' === $content_setting ) {
				if ( ! has_excerpt() ) {
					$content = wp_trim_words( get_the_content(), 20 );
					$content = '<p>' . $content . '</p>';
				} else {
					$content = apply_filters( 'the_excerpt', get_the_excerpt() );
				}
				echo wp_kses_post( $content );
			}
			if ( '' !== $content_setting && 'full' === $content_setting ) {
				the_content();
			}
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn border-btn"><?php esc_html_e( 'See exercise', 'lsx-health-plan' ); ?></a>
		</div>
		<?php lsx_entry_bottom(); ?>
	</article>
</div>

<?php
lsx_entry_after();
