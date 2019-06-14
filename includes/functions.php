<?php
namespace lsx_health_plan\functions;

/**
 * LSX Health Plan functions.
 *
 * @package lsx-health-plan
 */


/**
 * Checks to see if the current item has connected values.
 *
 * @param string $post_id
 * @param string $meta_key
 * @param boolean $single
 * @return boolean
 */
function has_attached_post( $post_id = '', $meta_key = '', $single = true ) {
	$has_post = false;
	if ( '' === $post_id ) {
		$post_id = get_the_ID();
	}
	$items = get_post_meta( $post_id, $meta_key, $single );
	if ( '' !== $items && false !== $items && 0 !== $items ) {
		$has_post = true;
	}
	return $has_post;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( 'lsx_health_plan_options', $key, $default );
	}
	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'lsx_health_plan_options', $default );
	$val  = $default;
	if ( 'all' === $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}

/**
 * Add Lets Enrypt and Peach Payments logos to cart
 **/

add_action( 'woocommerce_checkout_after_order_review', function() {
	$encript_image = LSX_HEALTH_PLAN_URL . 'assets/images/le-logo.svg';
	$peach_image   = LSX_HEALTH_PLAN_URL . 'assets/images/peach-payments-logo.svg';
	?>
	<div class="row text-center vertical-align">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<img src="<?php echo esc_url( $encript_image ); ?>" alt="lets_encrypt"/>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<img src="<?php echo esc_url( $peach_image ); ?>" alt="peach_payments"/>
		</div>
	</div>
	<?php
});

/**
 * Returns the downloads attached to the items
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function get_downloads( $type = 'all', $post_id = '' ) {
	$post_types = array(
		'page',
		'meal',
		'workout',
		'recipe',
		'video',
	);
	if ( '' === $post_id ) {
		$post_id = get_the_ID();
	}
	$downloads = array();
	foreach ( $post_types as $post_type ) {
		if ( 'all' === $type || in_array( $type, $post_types, true ) ) {

			if ( 'page' === $post_type ) {
				$key = 'plan_warmup';
			} else {
				$key = 'connected_' . $post_type . 's';
			}

			$connected_items = get_post_meta( $post_id, $key, true );
			if ( ! empty( $connected_items ) ) {
				foreach ( $connected_items as $connected_item ) {
					$current_downloads = get_post_meta( $connected_item, 'connected_downloads', true );
					if ( false !== $current_downloads && ! empty( $current_downloads ) ) {
						$downloads = array_merge( $downloads, $current_downloads );
					}
				}
			}
		}
	}
	return $downloads;
}

/**
 * Registered the modal to be outputted
 *
 * @param string $id
 * @param string $title
 * @param string $body
 * @return void
 */
function register_modal( $id = '', $title = '', $body = '' ) {
	lsx_health_plan()->frontend->modals->register_modal( array(
		'title' => $title,
		'body'  => $body,
	), $id );
}

/**
 * Outputs the modal HTML
 *
 * @param array $args
 * @return void
 */
function output_modal( $args = array() ) {
	$defaults = array(
		'id'    => '',
		'title' => '',
		'body'  => '',
	);
	$args     = wp_parse_args( $args, $defaults );
	?>
	<!-- Modal -->
	<div class="modal fade lsx-health-plan-modal" id="<?php echo esc_html( $args['id'] ); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo esc_html( $args['id'] ); ?>"  aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<?php
					if ( '' !== $args['title'] ) {
						echo wp_kses_post( '<h2>' . $args['title'] . '</h2>' );
					}
					?>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				<?php
				if ( '' !== $args['body'] ) {
						$allowed_html = array(
							'iframe' => array(
								'data-src'        => array(),
								'src'             => array(),
								'width'           => array(),
								'height'          => array(),
								'frameBorder'     => array( '0' ),
								'class'           => array(),
								'allowFullScreen' => array(),
								'style'           => array(),
							),
							'h5'     => array(
								'class' => array(),
							),
						);
					echo wp_kses( $args['body'], $allowed_html );
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<?php
}

/**
 * Gets the src attribute from an iframe embed.
 *
 * @param [type] $embed
 * @return void
 */
function get_video_url( $embed ) {
	$url = '';
	if ( false !== stripos( $embed, '<iframe' ) ) {
		preg_match( '/src="([^"]+)"/', $embed, $match );
		if ( is_array( $match ) && isset( $match[1] ) ) {
			$url = '<iframe data-src="' . $match[1] . '" style="border: 0;" frameBorder="0" class="giphy-embed" allowFullScreen height="300" width="100%"></iframe>';
		} else {
			$url = $embed;
		}
	} else {
		$url = $embed;
	}
	return $url;
}

/**
 * Takes the Week ID and sees if it is complete
 *
 * @param boolean $term_id
 * @param array $post_ids
 * @return boolean
 */
function is_week_complete( $term_id = false, $post_ids = array() ) {
	$return = false;
	if ( ! empty( $post_ids ) ) {
		foreach ( $post_ids as &$pid ) {
			$pid = 'day_' . $pid . '_complete';
		}
		$days_complete = get_meta_amounts( $post_ids );
		if ( 7 === $days_complete || '7' === $days_complete ) {
			$return = true;
		}
	}
	return $return;
}

/**
 * Gets the values straight from the DB
 *
 * @param integer $week
 * @param string $key
 * @return void
 */
function get_meta_amounts( $post_ids = array() ) {
	global $wpdb;
	$amount       = 0;
	$current_user = wp_get_current_user();
	if ( false !== $current_user && ! empty( $post_ids ) ) {
		$post_ids = "'" . implode( "','", $post_ids ) . "'";
		$query    = "
			SELECT COUNT(`meta_value`) 
			FROM `{$wpdb->usermeta}`
			WHERE `meta_key` IN ({$post_ids})
			AND `user_id` = '{$current_user->ID}'
		";
		$results  = $wpdb->get_var( $query ); // WPCS: unprepared SQL
		if ( ! empty( $results ) ) {
			$amount = $results;
		}
	}
	return $amount;
}

/**
 * Limit media library access
 */
function lsx_query_set_only_author( $wp_query ) {
	global $current_user;
	if ( is_admin() && ! current_user_can( 'edit_others_posts' ) ) {
		$wp_query->set( 'administrator', $current_user->ID );
		add_filter( 'views_upload', 'fix_media_counts' );
	}
}
add_action( 'pre_get_posts', 'lsx_query_set_only_author' );
