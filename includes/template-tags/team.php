<?php

global $product;
$tabs = array();

// Tab Experience
$tab_experience['title']     = esc_html__( 'Experience', 'lsx-team' );
$tab_experience['content']   = get_post_meta( get_the_ID(), 'team_member_experience', true );
$tab_experience['shortcode'] = '';
if ( ! empty( $tab_experience['content'] ) ) {
	$tabs[] = $tab_experience;
}

// Tab Featured plan
$tab_plans['title']     = esc_html__( 'Featured Plans', 'lsx-team' );
$tab_plans['posts']     = get_post_meta( get_the_ID(), 'connected_team_member_plan', true );
$tab_plans['content']   = '';
$tab_plans['shortcode'] = '';

if ( ! empty( $tab_plans['posts'] ) ) {

	$plan_content = '';

	$include = implode( ',', $tab_plans['posts'] );
	$args = array(
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_type'      => 'plan',
		'post__in'       => $tab_plans['posts'],
	);
	$plan_query = new WP_Query( $args );

	$plan_content = '<div class="all-plans-block plan-grid block-all-plans-block team-member-plans"><div class="row">';

	if ( $plan_query->have_posts() ) {
		add_action( 'lsx_sharing_is_disabled', '\lsx_health_plan\functions\triggers\disable_sharing', 10 );
		while ( $plan_query->have_posts() ) {
			$plan_query->the_post();
			ob_start();
			include LSX_HEALTH_PLAN_PATH . '/templates/content-archive-plan.php';
			$plan_content .= ob_get_clean();
		}
		wp_reset_postdata();
		remove_action( 'lsx_sharing_is_disabled', '\lsx_health_plan\functions\triggers\disable_sharing', 10 );
	}
	$plan_content .= '</div></div>';

	$tab_plans['content'] = $plan_content;
}
if ( ! empty( $tab_plans['content'] ) ) {
	$tabs[] = $tab_plans;
}


// Tab Testimonials
$tab_testimonial['post_type'] = 'testimonial';
$tab_testimonial['title']     = esc_html__( 'Testimonials', 'lsx-team' );
$tab_testimonial['posts']     = get_post_meta( get_the_ID(), 'testimonial_to_team', true );
$tab_testimonial['content']   = '';

if ( is_plugin_active( 'lsx-testimonials/lsx-testimonials.php' ) && ( ! empty( $tab_testimonial['posts'] ) ) ) {
	if ( count( $tab_testimonial['posts'] ) <= 2 ) {
		$columns = count( $tab_testimonial['posts'] );
	} else {
		$columns = 3;
	}

	$post_ids = join( ',', $tab_testimonial['posts'] );
	$tab_testimonial['shortcode'] = '[lsx_testimonials columns="' . $columns . '" include="' . $post_ids . '" orderby="date" order="DESC" display="excerpt"]';
	$tabs[] = $tab_testimonial;
}

if ( count( $tabs ) > 0 ) : ?>
	<div class="entry-tabs hp-entry-tabs">
		<ul class="nav nav-tabs">
			<?php foreach ( $tabs as $i => $tab ) : ?>
				<li<?php if ( 0 === $i ) echo ' class="active"'; ?>><a data-toggle="tab" href="#<?php echo esc_attr( sanitize_title( $tab['title'] ) ); ?>"><?php echo esc_html( $tab['title'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>

		<div class="tab-content">
			<?php foreach ( $tabs as $i => $tab ) : ?>
				<div id="<?php echo esc_attr( sanitize_title( $tab['title'] ) ); ?>" class="tab-pane fade<?php if ( 0 === $i ) echo ' in active'; ?>">
					<?php echo do_shortcode( $tab['shortcode'] ); ?>
					<?php echo wp_kses_post( $tab['content'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif;