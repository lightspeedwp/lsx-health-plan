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
$restricted   = false;

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

// Get the plan restrictions.
if ( function_exists( 'wc_memberships_is_post_content_restricted' ) && wc_memberships_is_post_content_restricted( get_the_ID() ) ) {
	$restricted = ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
}
?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>

	<main id="main" class="site-main <?php echo esc_html( $plan_type_class ); ?>" role="main">

		<?php lsx_content_top(); ?>

		<?php
		if ( ! empty( $has_children ) ) {
			echo wp_kses_post( '<h2 class="my-plan-title">' . __( 'Your Game Plan', 'lsx-health-plan' ) . '</h2>' );

			if ( false === $restricted ) {
				echo wp_kses_post( '<span class="progress"><progress class="bar" value="' . \lsx_health_plan\functions\get_progress( get_the_ID() ) . '" max="100"> ' . \lsx_health_plan\functions\get_progress( get_the_ID() ) . '% </progress></span>' );
			}

			the_content();
			echo do_shortcode( '[lsx_health_plan_day_plan_block week_view="true" show_downloads="true" plan="' . get_the_ID() . '"]' );
		}

		if ( empty( $has_children ) ) {
			lsx_health_plan_single_nav();
			lsx_health_plan_single_tabs();
			?>

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
