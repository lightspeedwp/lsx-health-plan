<?php
/**
 * Template used to display post content on single pages.
 *
 * @package lsx-health-plan
 */
?>

<?php
$prep_time     = get_post_meta( get_the_ID(), 'recipe_prep_time', true );
$cooking_time  = get_post_meta( get_the_ID(), 'recipe_cooking_time', true );
$serves        = get_post_meta( get_the_ID(), 'recipe_serves', true );
$portion       = get_post_meta( get_the_ID(), 'recipe_portion', true );
$energy        = get_post_meta( get_the_ID(), 'recipe_energy', true );
$protein       = get_post_meta( get_the_ID(), 'recipe_protein', true );
$carbohydrates = get_post_meta( get_the_ID(), 'recipe_carbohydrates', true );
$fibre         = get_post_meta( get_the_ID(), 'recipe_fibre', true );
$fat           = get_post_meta( get_the_ID(), 'recipe_fat', true );


// Getting translated endpoint.
$recipe = \lsx_health_plan\functions\get_option( 'endpoint_recipe_single', 'recipe' );

$connected_members  = get_post_meta( get_the_ID(), ( $recipe . '_connected_team_member' ), true );
$connected_articles = get_post_meta( get_the_ID(), ( $recipe . '_connected_articles' ), true );
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lsx_entry_top(); ?>

	<div class="entry-meta">
		<?php lsx_post_meta_single_bottom(); ?>
	</div><!-- .entry-meta -->

	<div id="single-recipe" class="entry-content">
		<h2 class="title-lined"><?php the_title(); ?>
		<?php if ( class_exists( 'LSX_Sharing' ) || ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) ) : ?>
			<div class="post-sharing-wrapper">

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
		</h2>
		<?php echo wp_kses_post( lsx_hp_member_connected( $connected_members, 'recipe' ) ); ?>
		<div class="row">
			<div class="col-md-6 recipe-image lsx-hp-shadow">
				<?php
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
				?>
				<?php if ( ( ! empty( $prep_time ) ) || ( ! empty( $cooking_time ) ) || ( ! empty( $serves ) ) || ( ! empty( $portion ) ) || ( ! empty( $energy ) ) || ( ! empty( $protein ) ) || ( ! empty( $carbohydrates ) ) || ( ! empty( $fibre ) ) || ( ! empty( $fat ) ) ) { ?>
				<div class="recipe-data">
					<?php lsx_health_plan_recipe_data(); ?>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-6 recipe-content">
				<?php the_content(); ?>
				<?php echo do_shortcode( '[lsx_health_plan_featured_tips_block]' ); ?>
				<div class="back-plan-btn">
				<?php
				if ( function_exists( 'wc_get_page_id' ) ) {
					?>
					<a class="btn" href="<?php echo wp_kses_post( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Back To My Plan', 'lsx-health-plan' ); ?></a>
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
