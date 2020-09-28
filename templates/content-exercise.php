<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */

$exercise_type = lsx_health_plan_exercise_type();
$equipment     = lsx_health_plan_exercise_equipment();
$muscle_group  = lsx_health_plan_muscle_group_equipment();

// Getting translated endpoint.
$exercise = \lsx_health_plan\functions\get_option( 'endpoint_exercise_single', 'exercise' );

$connected_members  = get_post_meta( get_the_ID(), ( $exercise . '_connected_team_member' ), true );
$connected_articles = get_post_meta( get_the_ID(), ( $exercise . '_connected_articles' ), true );

$sharing = 'sharing-disabled';
if ( class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) :
	$sharing = 'sharing-enabled';
endif;

?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div id="single-exercise" class="entry-content">

		<div class="exercise-title-section title-lined <?php echo esc_html( $sharing ); ?>">
			<?php if ( class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) : ?>

					<?php
					if ( class_exists( 'LSX_Sharing' ) ) {
						lsx_content_sharing();
					} else {
						if ( function_exists( 'sharing_display' ) ) {
							sharing_display( '', true );
						}

						if ( class_exists( 'Jetpack_Likes' ) ) {
							$custom_likes = new Jetpack_Likes();
							echo wp_kses_post( $custom_likes->post_likes( '' ) );
						}
					}
					?>
			<?php endif ?>

			<?php lsx_health_plan_exercise_title( '<h2>', '</h2>', false ); ?>
		</div>
		<?php echo wp_kses_post( lsx_hp_member_connected( $connected_members, 'exercise' ) ); ?>
		<div class="row">
			<div class="col-md-6 exercise-image lsx-hp-shadow">

			<?php
			$lsx_hp = lsx_health_plan();

			if ( $lsx_hp->frontend->gallery->has_gallery( get_the_ID() ) ) {
				lsx_health_plan_gallery();
			} else {
				$featured_image = get_the_post_thumbnail();
				if ( ! empty( $featured_image ) && '' !== $featured_image ) {
					the_post_thumbnail( 'large', array(
						'class' => 'aligncenter',
					) );
				} else {
					?>
					<img loading="lazy" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
					<?php
				}
			}
			?>

				<?php if ( ( ! empty( $exercise_type ) ) || ( ! empty( $equipment ) ) || ( ! empty( $muscle_group ) ) ) { ?>
					<div class="exercise-data">
						<?php lsx_health_plan_exercise_data(); ?>
					</div>
				<?php } ?>
			</div>
			<div class="col-md-6 exercise-content">
				<?php the_content(); ?>
				<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>
				<div  class="back-plan-btn">
				<?php
				if ( function_exists( 'wc_get_page_id' ) ) {
					?>
					<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Back to my plans', 'lsx-health-plan' ); ?></a>
					<?php
				}
				?>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php
if ( ! empty( $connected_articles ) ) {
	lsx_hp_single_related( $connected_articles, __( 'Related articles', 'lsx-health-plan' ) );
}
?>

<?php
lsx_entry_after();
