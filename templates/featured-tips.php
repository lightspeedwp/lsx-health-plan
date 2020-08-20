<?php
/**
 * LSX Tips Shortcode.
 *
 * @package lsx-health-plan
 */
global $shortcode_args;

$this_post_type = get_post_type( get_the_ID() );

$connected_tips = get_post_meta( get_the_ID(), ( $this_post_type . '_connected_tips' ), true );

// Check for any shortcode overrides.
if ( null !== $shortcode_args && isset( $shortcode_args['include'] ) ) {
	$connected_tips = array( get_the_ID() );
}

if ( ! empty( $connected_tips ) ) {
	$args = array(
		'orderby'        => 'date',
		'order'          => 'ASC',
		'post_type'      => 'tip',
		'posts_per_page' => -1,
		'post__in'       => $connected_tips,
	);
}

if ( ! empty( $args ) ) {
	$tips = new WP_Query( $args );

	?>
	<div id="lsx-tips-shortcode" class="daily-plan-block">
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
