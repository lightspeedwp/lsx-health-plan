<?php
/**
 * LSX Exercises Shortcode.
 *
 * @package lsx-health-plan
 */

?>

<?php
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
				$featured_image = get_the_post_thumbnail_url( $post_id, $image_size );
				?>
				<div style="background-image:url('<?php echo esc_url( $featured_image ); ?>')" class="lsx-exercises-item bg-<?php echo esc_html( $image_size ); ?>">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="exercise-link excerpt-<?php echo esc_html( $description ); ?>">
						<h4 class="lsx-exercises-title"><?php the_title(); ?></h4>
						<?php if ( isset( $description ) && ( 'none' !== $description ) ) { ?>
							<?php
							if ( 'excerpt' === $description ) {
								if ( ! has_excerpt() ) {
									$content = wp_trim_words( get_the_content(), 20 );
									$content = '<p>' . $content . '</p>';
								} else {
									$content = get_the_excerpt();
								}
								?>
								<p class="lsx-exercises-excerpt"><?php echo wp_kses_post( $content ); ?></p>
							<?php } ?>
							<?php if ( 'full' === $description ) { ?>
								<?php echo wp_kses_post( get_the_content() ); ?>
							<?php } ?>
						<?php } ?>
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
				<a class="<?php echo esc_html( $link_class ); ?>" href="<?php echo esc_url( get_post_type_archive_link( 'exercise' ) ); ?>"><?php echo esc_html_e( 'Show More', 'lsx-health-plan' ); ?></a>
			</div>
		<?php
	}
	?>
</div>
