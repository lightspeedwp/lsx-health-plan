<?php
/**
 * The template for displaying plans Archive.
 *
 * @package lsx-health-plan
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

	<?php lsx_content_before(); ?>


		<main id="main" role="main">

			<?php lsx_content_top(); ?>

			<?php
				$args = array(
					'taxonomy'   => 'plan-type',
					'hide_empty' => false,
				);

				$groups = get_terms( $args );
				$group_selected = get_query_var( 'plan-type' );

				if ( count( $groups ) > 0 ) :
				?>
				<div id="type-nav">
					<ul class="nav nav-pills lsx-type-nav-filter">
						<?php
						$group_selected_class = '';

						if ( empty( $group_selected ) ) {
							$group_selected_class = ' class="active"';
						}
						?>

						<li<?php echo wp_kses_post( $group_selected_class ); ?>><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_post_type_archive_link( 'plan' ) ); ?>" data-filter="*"><?php esc_html_e( 'All', 'lsx-health-plan' ); ?></a></li>

						<?php foreach ( $groups as $group ) : ?>
							<?php
								$group_selected_class = '';

								if ( (string) $group_selected === (string) $group->slug ) {
									$group_selected_class = ' class="active"';
								}
							?>

							<li<?php echo wp_kses_post( $group_selected_class ); ?>><a href="<?php echo empty( $group_selected ) ? '#' : esc_url( get_term_link( $group ) ); ?>" data-filter=".filter-<?php echo esc_attr( $group->slug ); ?>"><?php echo esc_attr( $group->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php
				endif;
			?>

			<div class="post-wrapper plan-archive-plan archive-plan">
				<div class="row lsx-plan-row">
					<?php if ( have_posts() ) : ?>
						<?php

						$count = 0;

						while ( have_posts() ) :
							the_post();
							?>

							<?php include LSX_HEALTH_PLAN_PATH . '/templates/content-archive-plan.php'; ?>

						<?php endwhile; ?>

					<?php else : ?>

						<?php get_template_part( 'partials/content', 'none' ); ?>

					<?php endif; ?>
				</div>
				<?php lsx_paging_nav(); ?>

			</div>

			<?php lsx_content_bottom(); ?>

		</main><!-- #main -->	

	<?php lsx_content_after(); ?>

</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php //get_sidebar(); ?>

<?php
get_footer();
