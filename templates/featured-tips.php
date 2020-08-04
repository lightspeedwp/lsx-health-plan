<?php
/**
 * LSX Tips Shortcode.
 *
 * @package lsx-health-plan
 */
global $shortcode_args;
$connected_tips = get_post_meta( get_the_ID(), 'connected_tips', true );

if ( isset( $args['tab'] ) && '' !== $args['tab'] ) {
	echo 'is set';
}

// Check for any shortcode overrides.
if ( null !== $shortcode_args && isset( $shortcode_args['include'] ) ) {
	$connected_tips = array( get_the_ID() );
}

if ( empty( $connected_tips ) ) {
	// Featured Tips Global
	$connected_tips = 'tip_featured_tip';
	$args = array(
		'orderby'        => 'date',
		'order'          => 'ASC',
		'post_type'      => 'tip',
		'posts_per_page' => 1,
		'meta_key'       => $connected_tips,
	);
} else {
	$connected_tips = \lsx_health_plan\functions\check_posts_exist( $connected_tips );
	if ( ! empty( $connected_tips ) ) {
		$args = array(
			'orderby'        => 'date',
			'order'          => 'ASC',
			'post_type'      => 'tip',
			'posts_per_page' => 3,
			'post__in'       => $connected_tips,
		);
	}
}

if ( ! empty( $args ) ) {
	$tips = new WP_Query( $args );
	?>
	<div id="lsx-tips-shortcode" class="daily-plan-block content-box box-shadow">
		<div class="lsx-tips-shortcode lsx-tips-slider slick-slider slick-dotted"  >
		<?php
		if ( $tips->have_posts() ) {
			while ( $tips->have_posts() ) {
				$tips->the_post();
				include LSX_HEALTH_PLAN_PATH . 'templates/content-archive-tip.php';
			}
		}
		?>
		</div>
	</div>
	<?php
}
