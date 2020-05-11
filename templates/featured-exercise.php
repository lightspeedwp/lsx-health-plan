<?php
/**
 * LSX Exercises Shortcode.
 *
 * @package lsx-health-plan
 */

?>

<?php
	$taxonomy = $args['taxonomy'];
	$term     = $args['term'];
	$columns  = $args['columns'];
	$limit    = $args['limit'];

	$query_array = array(
		'orderby'        => $args['orderby'],
		'order'          => $args['order'],
		'post_type'      => $args['post_type'],
		'posts_per_page' => $limit,
	);

	if ( isset( $args['include'] ) && ( '' !== $args['include'] ) ) {
		$include                 = explode( ',', $args['include'] );
		$include_filter          = $include;
		$query_array['post__in'] = $include_filter;
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

<div id="lsx-exercises-shortcode" class="daily-plan-block columns-<?php echo esc_html( $args['columns'] ); ?>">
	<div class="lsx-exercises-shortcode" >
		<?php
		if ( $exercises->have_posts() ) :
			while ( $exercises->have_posts() ) :
				$exercises->the_post();
				$post_id        = get_the_id();
				$featured_image = get_the_post_thumbnail_url( $post_id );
				?>
				<div style="background-image:url('<?php echo esc_url( $featured_image ); ?>')" class="lsx-exercises-item">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="exercise-link">
						<h4 class="lsx-exercises-title"><?php the_title(); ?></h4>
						<p class="lsx-exercises-excerpt"><?php the_excerpt(); ?></p>
					</a>
				</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<?php
	if ( isset( $args['view_more'] ) && false !== $args['view_more'] ) {
		?>
			<div class="col-md-12">
				<a class="btn border-btn" href="<?php echo esc_url( get_post_type_archive_link( 'exercise' ) ); ?>"><?php echo esc_html_e( 'Show More', 'lsx-health-plan' ); ?></a>
			</div>
		<?php
	}
	?>
</div>
