<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */
global $shortcode_args, $product;
?>

<?php lsx_entry_before(); ?>

<?php
$content_setting = '';
$column_class    = '4';
$completed_class = '4';
$link_html       = '';
$link_close      = '';
$linked_product  = false;
$restricted      = '';
if ( function_exists( 'lsx_health_plan\functions\woocommerce\plan_has_products' ) && \lsx_health_plan\functions\woocommerce\plan_has_products() ) {
	$products       = \lsx_health_plan\functions\woocommerce\get_plan_products();
	$linked_product = wc_get_product( $products[0] );
	$product        = $linked_product;

	if ( function_exists( 'wc_memberships_is_post_content_restricted' ) && wc_memberships_is_post_content_restricted( get_the_ID() ) ) {
		$restricted = ! current_user_can( 'wc_memberships_view_restricted_post_content', get_the_ID() );
	}
}

// Check for shortcode overrides.
if ( null !== $shortcode_args ) {
	if ( isset( $shortcode_args['columns'] ) ) {
		$column_class = $shortcode_args['columns'];
		$column_class = \lsx_health_plan\functions\column_class( $column_class );
	}
	if ( isset( $shortcode_args['link'] ) ) {
		$link_setting = $shortcode_args['link'];
		// Setup our link and content.
		switch ( $link_setting ) {
			case 'single':
				$link_html  = '<a href="' . get_permalink( $group['connected_plans'] ) . '">';
				$link_close = '</a>';
				break;

			case 'modal':
				$link_html  = '<a data-toggle="modal" href="#workout-plan-modal-' . $group['connected_plans'] . '">';
				$link_close = '</a>';
				$modal_content_setting = \lsx_health_plan\functions\get_option( 'workout_tab_modal_content', 'excerpt' );
				$modal_args = array(
					'modal_content' => $modal_content_setting,
				);
				// We call the button to register the modal, but we do not output it.
				lsx_health_plan_workout_plan_button( $group['connected_plans'], $group, false, $modal_args );
				break;

			case 'none':
			default:
				$link_html  = '';
				$link_close = '';
				break;
		}
	}
	if ( isset( $shortcode_args['description'] ) ) {
		$content_setting = $shortcode_args['description'];
	}
}

$featured      = get_post_meta( get_the_ID(), 'plan_featured_plan', true );
?>

<div class="lsx-plan-column col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $column_class ); ?> <?php echo esc_attr( lsx_hp_plan_get_classes() ); ?>">
	<article class="lsx-slot box-shadow">
		<?php lsx_entry_top(); ?>

		<div class="plan-feature-img">
			<?php if ( $featured ) { ?>
				<span class="featured-plan"><?php //lsx_get_svg_icon( 'icon-featured.svg' ); ?></span>
			<?php } ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			$featured_image = get_the_post_thumbnail();
			if ( ! empty( $featured_image ) && '' !== $featured_image ) {
				the_post_thumbnail( 'lsx-thumbnail', array(
					'class' => 'aligncenter',
				) );
			} else {
				?>
				<img loading="lazy" class="placeholder" src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg' ); ?>">
				<?php
			}
			?>
			</a>
		</div>
		<div class="content-box plan-content-box white-bg">
			<h3 class="plan id-<?php the_ID(); ?> <?php echo esc_attr( $completed_class ); ?>"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
			<?php
				echo wp_kses_post( \lsx_health_plan\functions\hp_get_plan_type_meta( $post ) );
			?>
			<?php
			if ( false !== $linked_product ) {
				echo '<div class="plan-price">';
				echo wp_kses_post( $linked_product->get_price_html() );
				echo '</div>';
			}
			?>
			<div class="excerpt">
				<?php
				if ( ! has_excerpt() ) {
					$content = wp_trim_words( get_the_content(), 20 );
					$content = '<p>' . $content . '</p>';
				} else {
					$content = apply_filters( 'the_excerpt', get_the_excerpt() );
				}
				echo wp_kses_post( $content );
				?>
			</div>

			<?php
			$button_link  = get_permalink();
			$button_text  = __( 'Sign Up', 'lsx-health-plan' );
			$button_class = '';

			if ( true === $restricted ) {
				if ( 1 < count( $products ) ) {
					$button_text = __( 'Select Options', 'lsx-health-plan' );
				} else {
					$button_link = $linked_product->add_to_cart_url() . '&plan_id=' . get_the_ID();
					$button_text = $linked_product->add_to_cart_text();
				}
				?>
				<?php
			} elseif ( false === $restricted ) {
				$button_text  = __( 'Already Signed Up', 'lsx-health-plan' );
				$button_class = 'btn-disabled';
			}
			?>
			<a class="btn <?php echo esc_attr( $button_class ); ?>" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_attr( $button_text ); ?></a>
		</div>
		<?php lsx_entry_bottom(); ?>
	</article>
</div>

<?php
lsx_entry_after();
