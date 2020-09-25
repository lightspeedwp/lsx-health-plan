<?php
/**
 * LSX Health Plan Items Shortcode.
 *
 * @package lsx-health-plan
 */
global $shortcode_args;
$args        = $shortcode_args;
$taxonomy    = $args['taxonomy'];
$term        = $args['term'];
$columns     = $args['columns'];
$limit       = $args['limit'];
$description = $args['description'];
$link        = $args['link'];
$link_class  = $args['link_class'];
$image_size  = $args['image_size'];

$query_array = array(
	'orderby'        => $args['orderby'],
	'order'          => $args['order'],
	'post_type'      => $args['post_type'],
	'posts_per_page' => $limit,
);

// If we are calling the exercises with the parent workout.
if ( false !== 'parent' && 'exercise' === $args['post_type'] ) {
	$items = \lsx_health_plan\functions\get_exercises_by_workout( $args['parent'] );
	if ( ! empty( $items ) ) {
		$args['include'] = $items;
	}
}

if ( isset( $args['include'] ) && ( '' !== $args['include'] ) ) {
	if ( is_array( $args['include'] ) ) {
		$include = $args['include'];
	} else {
		$include = explode( ',', $args['include'] );
	}
	$include_filter          = $include;
	$query_array['post__in'] = $include_filter;
	$query_array['orderby']  = 'post__in';
}

if ( isset( $taxonomy ) && ( '' !== $taxonomy ) && isset( $term ) && ( '' !== $term ) ) {
	$taxonomy_filter          = array(
		array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $term,
		),
	);
	$query_array['tax_query'] = $taxonomy_filter;
}

$exercises = new WP_Query( $query_array );
?>

<div id="lsx-exercises-shortcode" class="daily-plan-block layout-<?php echo esc_html( $args['layout'] ); ?> columns-<?php echo esc_html( $args['columns'] ); ?> shortcode-type-<?php echo esc_html( $args['post_type'] ); ?>">
	<div class="lsx-exercises-shortcode" >
		<?php
		if ( $exercises->have_posts() ) {
			while ( $exercises->have_posts() ) {
				$exercises->the_post();
				switch ( $args['post_type'] ) {
					case 'workout':
						include LSX_HEALTH_PLAN_PATH . 'templates/partials/workout-sets.php';
						break;

					case 'meal':
						include LSX_HEALTH_PLAN_PATH . 'templates/partials/meal-plans.php';
						break;

					/*case 'exercise':
						include LSX_HEALTH_PLAN_PATH . 'templates/partials/content-shortcode-exercise.php';
						break;*/

					case 'exercise':
					case 'recipe':
					case 'tip':
						include LSX_HEALTH_PLAN_PATH . 'templates/content-archive-' . $args['post_type'] . '.php';
						break;

					default:
						include LSX_HEALTH_PLAN_PATH . 'templates/partials/content-default.php';
						break;
				}
			}
		}
		wp_reset_postdata();
		?>
	</div>
	<?php
	if ( isset( $args['view_more'] ) && false !== $args['view_more'] ) {
		?>
			<div class="col-md-12">
				<a class="<?php echo esc_html( $link_class ); ?>" href="<?php echo esc_url( get_post_type_archive_link( $args['post_type'] ) ); ?>"><?php echo esc_html_e( 'Show More', 'lsx-health-plan' ); ?></a>
			</div>
		<?php
	}
	?>
</div>
<?php
$shortcode_args = null;
