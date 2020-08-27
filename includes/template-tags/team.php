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
	//$the_query = new WP_Query( $args );

	$plan_content = '<div class="all-plans-block plan-grid block-all-plans-block team-member-plans">
	<div class="row">';

	foreach ( $tab_plans['posts'] as $index => $post ) {

		$plan_content .= '<div class="col-xs-12 col-sm-6 col-md-4">';
		$plan_content .= '<article class="lsx-slot lsx-hp-shadow">';
		$plan_content .= '<div class="plan-feature-img">';
		$plan_content .= '<a href="' . get_permalink( $post ) . '">';

		$linked_product  = false;
		$restricted      = false;
		$product         = null;
		if ( \lsx_health_plan\functions\woocommerce\plan_has_products( $post ) ) {
			$products       = \lsx_health_plan\functions\woocommerce\get_plan_products( $post );
			$linked_product = wc_get_product( $products[0] );
			$product        = $linked_product;
		}
		if ( function_exists( 'wc_memberships_is_post_content_restricted' ) ) {
			$restricted = wc_memberships_is_post_content_restricted( get_the_ID() ) && ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
		}

		$featured_image = get_the_post_thumbnail( $post );
		if ( ! empty( $featured_image ) && '' !== $featured_image ) {
			$plan_content .= $featured_image;
		} else {
			$plan_content .= '<img loading="lazy" class="placeholder" src="' . plugin_dir_url( __DIR__ ) . '../assets/images/placeholder.jpg' . '">';
		}
		$plan_content .= '</a>';
		$plan_content .= '</div>';

		$plan_content .= '<div class="content-box plan-content-box">';
		$plan_content .= '<h3 class="plan"><a href="' . get_permalink( $post ) . '">' . get_the_title( $post ) . '</a></h3>';

		if ( false !== $linked_product && false !== $restricted ) {
			$plan_content .= $linked_product->get_price_html();
		}

		$plan_content .= '<div class="excerpt">';
		if ( ! has_excerpt( $post ) ) {
			$content = wp_trim_words( get_the_content( $post ), 20 );
			$plan_content .= '<p>' . $content . '</p>';
		} else {
			$plan_content .= apply_filters( 'the_excerpt', get_the_excerpt( $post ) );
		}
		$plan_content .= '</div>';

		$plan_content .= '</div>';
		$plan_content .= '</article>';
		$plan_content .= '</div>';

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
					<?php echo $tab['content']; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif;

