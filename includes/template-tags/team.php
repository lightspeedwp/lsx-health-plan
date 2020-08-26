<?php

$tabs = array();

// Tab Experience
$tab_experience['title']     = esc_html__( 'Experience', 'lsx-team' );
$tab_experience['content']   = get_post_meta( get_the_ID(), 'team_member_experience', true );
$tab_experience['shortcode'] = ''; 
if ( ! empty( $tab_experience['content'] ) ) {
	$tabs[] = $tab_experience;
}

// Tab Featured plan

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

