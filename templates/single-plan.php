<?php
/**
 * The Template for displaying the single day plan and its connected items
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

<?php
$args = array(
	'post_parent' => get_the_ID(),
	'post_type'   => 'plan',
);

$post_id      = get_the_ID();
$has_children = get_children( $args );
$has_parent   = wp_get_post_parent_id( $post_id );

if ( ! empty( $has_children ) ) {
	$plan_type_class = 'parent-plan';
	if ( 0 !== $has_parent ) {
		$plan_type_class = 'parent-sub-plan';
	}
} else {
	$plan_type_class = 'unique-plan';
	if ( 0 !== $has_parent ) {
		$plan_type_class = 'child-plan-' . $has_parent;
	}
}
?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>

	<main id="main" class="site-main <?php echo esc_html( $plan_type_class ); ?>" role="main">

		<?php lsx_content_top(); ?>

		<?php
		$progress_bar = '<span class="progress"><progress id="file" value="32" max="100"> 32% </progress></span>';
		if ( ! empty( $has_children ) ) {
			echo wp_kses_post( '<h2 class="my-plan-title">' . __( 'Your Game Plan', 'lsx-health-plan' ) . '</h2>' );
			echo $progress_bar;
			the_content();
			echo do_shortcode( '[lsx_health_plan_day_plan_block week_view="true" show_downloads="true" plan="' . get_the_ID() . '"]' );
		}

		if ( empty( $has_children ) ) {
			lsx_health_plan_single_nav();
			lsx_health_plan_single_tabs(); ?>

			<div class="row status-plan-buttons">
				<?php lsx_health_plan_day_button(); ?>
			</div>
		<?php } ?>

		<?php lsx_content_bottom(); ?>

	</main><!-- #main -->

	<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php
get_footer();
