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
$content_setting = '';
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
				$link_html  = '<a href="' . get_permalink( $group['connected_plans'] ) . '">';
				$link_close = '</a>';
				break;

			case 'modal':
				$link_html  = '<a data-toggle="modal" href="#workout-plan-modal-' . $group['connected_plans'] . '">';
				$link_close = '</a>';
				$modal_content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_modal_content', 'excerpt' );
				$modal_args = array(
					'modal_content' => $modal_content_setting,
				);
				// We call the button to register the modal, but we do not output it.
				lsx_health_plan_workout_plan_button( $group['connected_plans'], $group, false, $modal_args );
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

<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_class ); ?>">
	<article class="lsx-slot box-shadow">
		<?php lsx_entry_top(); ?>

		<div class="plan-feature-img">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			$featured_image = get_the_post_thumbnail();
			if ( ! empty( $featured_image ) && '' !== $featured_image ) {
				the_post_thumbnail( 'lsx-thumbnail', array(
					'class' => 'aligncenter',
				) );
			} else {
				?>
				<img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
				<?php
			}
			?>
			</a>
		</div>
		<div class="content-box plan-content-box white-bg">
			<h3 class="plan id-<?php the_ID(); ?> <?php echo esc_attr( $completed_class ); ?>"> <?php the_title(); ?> </h3>
			<?php
				echo wp_kses_post( \lsx_health_plan\functions\hp_get_plan_type_meta( $post ) );
			?>
			<div class="excerpt">
				<?php
				if ( ! has_excerpt() ) {
					$content = wp_trim_words( get_the_content(), 20 );
					$content = '<p>' . $content . '</p>';
				} else {
					$content = apply_filters( 'the_excerpt', get_the_excerpt() );
				}
				echo wp_kses_post( $content );
				?>
			</div>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn"><?php esc_html_e( 'See plan', 'lsx-health-plan' ); ?></a>
		</div>
		<?php lsx_entry_bottom(); ?>
	</article>
</div>

<?php
lsx_entry_after();
