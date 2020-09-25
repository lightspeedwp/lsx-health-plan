<?php
/**
 * LSX Tips Shortcode.
 *
 * @package lsx-health-plan
 */


$this_post_type = get_post_type( get_the_ID() );

$connected_tips = get_post_meta( get_the_ID(), ( $this_post_type . '_connected_tips' ), true );

?>
<div id="lsx-tips-shortcode" class="daily-plan-block">
	<div class="lsx-tips-shortcode lsx-tips-slider slick-slider slick-dotted"  >
	<?php
	if (is_array($connected_tips) || is_object($connected_tips)) {
		foreach ( $connected_tips as $tip ) {
			$tip_link    = get_permalink( $tip );
			$tip_name    = get_the_title( $tip );
			$tip_content = get_post_field( 'post_content', $tip );
			$icon = LSX_HEALTH_PLAN_URL . 'assets/images/tips-icon.svg';
			?>
			<div class="content-box diet-tip-wrapper quick-tip">
				<div class="row">
					<div class="col-xs-2">
						<img loading="lazy" src="<?php echo esc_url( $icon ); ?>" alt="tip"/>
					</div>
					<div class="col-xs-10">
						<h3 class="tip-title"><?php echo esc_html( $tip_name ); ?></h3>
						<?php echo wp_kses_post( $tip_content ); ?>
					</div> 
				</div>
			</div>
			<?php
		}
	}
	?>
	</div>
</div>
<?php
