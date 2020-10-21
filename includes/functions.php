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
		if ( ! is_array( $items ) ) {
			$items = array( $items );
		}
		$items = check_posts_exist( $items );
		if ( ! empty( $items ) ) {
			$has_post = true;
		}
	} else {
		// Check for defaults.
		$options = get_option( 'all' );
		if ( isset( $options[ $meta_key ] ) && '' !== $options[ $meta_key ] && ! empty( $options[ $meta_key ] ) ) {
			$has_post = true;
		}
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
	$opts = \get_option( 'lsx_health_plan_options', $default );
	$val  = $default;
	if ( 'all' === $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}

/**
 * Returns the downloads attached to the items
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function get_downloads( $type = 'all', $post_id = '' ) {
	$lsx_health_plan = \lsx_health_plan();
	$post_types      = $lsx_health_plan->get_post_types();
	if ( '' === $post_id ) {
		$post_id = get_the_ID();
	}
	$downloads = array();
	$options   = get_option( 'all' );

	foreach ( $post_types as $post_type ) {
		if ( 'all' === $type || in_array( $type, $post_types, true ) ) {

			// Get the default downloads for this post type.
			$default_downloads = array();
			$new_downloads     = array();
			if ( isset( $options[ 'download_' . $post_type ] ) ) {
				if ( is_array( $options[ 'download_' . $post_type ] ) ) {
					$default_downloads = $options[ 'download_' . $post_type ];
				} else {
					$default_downloads[] = $options[ 'download_' . $post_type ];
				}
			}

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
						$new_downloads = array_merge( $new_downloads, $current_downloads );
					}
				}
			}

			if ( ! empty( $new_downloads ) ) {
				$downloads = array_merge( $downloads, $new_downloads );
			} elseif ( ! empty( $default_downloads ) ) {
				$downloads = array_merge( $downloads, $default_downloads );
			}
			$downloads = array_unique( $downloads );
		}
	}
	$downloads = check_posts_exist( $downloads );
	return $downloads;
}

/**
 * Returns the weekly downloads for the week name
 *
 * @param  string $week    Week name 'week-1'.
 * @return array           an array of the downloads or empty.
 */
function get_weekly_downloads( $week = '' ) {
	$downloads = array();
	if ( '' !== $week ) {
		$saved_downloads = get_transient( 'lsx_hp_weekly_downloads_' . $week );
		if ( false !== $saved_downloads && ! empty( $saved_downloads ) ) {
			$downloads = $saved_downloads;
		} else {
			$args = array(
				'orderby'        => 'title',
				'order'          => 'ASC',
				'post_type'      => 'dlm_download',
				'posts_per_page' => -1,
				'nopagin'        => true,
				'fields'         => 'ids',
				'tax_query'      => array(
					array(
						'taxonomy' => 'dlm_download_category',
						'field'    => 'slug',
						'terms'    => array( $week ),
					),
				),
			);
			$download_query = new \WP_Query( $args );
			if ( $download_query->have_posts() ) {
				$downloads = $download_query->posts;
			}
		}
	}
	$downloads = check_posts_exist( $downloads );
	return $downloads;
}

/**
 * Checks to see if the downloads exist before adding them
 *
 * @param array $post_ids
 * @return void
 */
function check_posts_exist( $post_ids = array() ) {
	$new_ids = array();
	global $wpdb;
	if ( is_array( $post_ids ) && ! empty( $post_ids ) ) {
		$post_ids = "'" . implode( "','", $post_ids ) . "'";
		$query    = "
			SELECT `ID` 
			FROM `{$wpdb->posts}`
			WHERE `ID` IN ({$post_ids})
			AND `post_status` != 'trash'
		";
		$results = $wpdb->get_results( $query ); // WPCS: unprepared SQL
		if ( ! empty( $results ) ) {
			$new_ids = wp_list_pluck( $results, 'ID' );
		}
	}
	return $new_ids;
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
	lsx_health_plan()->frontend->modals->register_modal(
		array(
			'title' => $title,
			'body'  => $body,
		),
		$id
	);
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
			<button type="button" class="close" data-dismiss="modal">&times;</button>			
				<div class="modal-header">
					<?php
					if ( '' !== $args['title'] ) {
						echo wp_kses_post( '<h2>' . $args['title'] . '</h2>' );
					}
					?>
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
					if ( false !== \lsx_health_plan\functions\get_option( 'exercise_enabled', false ) ) {
						echo wp_kses_post( $args['body'] );
					} else {
						echo wp_kses( $args['body'], $allowed_html );
					}
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
function is_week_complete( $term_id = false, $section_keys = array(), $group_title = '' ) {
	$return = false;
	if ( ! empty( $section_keys ) ) {
		$group_count = count( $section_keys );
		foreach ( $section_keys as &$pid ) {
			$pid = 'day_' . \lsx_health_plan\functions\plan\generate_section_id( $pid ) . '_complete';
		}
		$days_complete = get_meta_amounts( $section_keys );
		if ( (int) $group_count === (int) $days_complete ) {
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
 * Get the taxonomy plans type meta.
 *
 * @param [type] $post
 * @return void
 */
function hp_get_plan_type_meta( $post ) {
	$plan_meta = '';

	$term_obj_list = get_the_terms( $post->ID, 'plan-type' );
	if ( false !== $term_obj_list ) {
		$terms_string = '';
		$terms_ids    = wp_list_pluck( $term_obj_list, 'term_id' );
		
		foreach ( $term_obj_list as $term ) {
			$term_link = get_term_link( $term );
			$term_name = '<a href="' . $term_link . '">' .$term->name . '<span>, </span></a>';
			
			$terms_string .= $term_name;
		}
		
		foreach ( $terms_ids as $terms_id ) {
			$term_thumbnail_id = get_term_meta( $terms_id, 'thumbnail', true );
			$img               = wp_get_attachment_image_src( $term_thumbnail_id, 'thumbnail' );
			if ( ! empty( $img ) ) {
				$image_url = $img[0];
				$img       = '<img loading="lazy" alt="thumbnail" style="width:24px; height: auto;" class="attachment-responsive wp-post-image lsx-responsive" src="' . esc_url( $image_url ) . '" />';
			}

			$plan_meta .= $img;
		}

		$plan_meta = '<div class="plan-meta">' . $plan_meta . '<span>' . $terms_string . '</span></div>';
	}

	return $plan_meta;
}

/**
 * Limit media library access
 */
function set_only_author( $wp_query ) {
	global $current_user;
	if ( is_admin() && ! current_user_can( 'edit_others_posts' ) ) {
		$wp_query->set( 'administrator', $current_user->ID );
		add_filter( 'views_upload', 'fix_media_counts' );
	}
}
add_action( 'pre_get_posts', '\lsx_health_plan\functions\set_only_author' );

/**
 * Outputs an excerpt even if there is not excerpt.
 *
 * @param [type] $post_id
 * @return void
 */
function hp_excerpt( $post_id ) {
	if ( ! has_excerpt( $post_id ) ) {
		$content = wp_trim_words( get_post_field( 'post_content', $post_id ), 10 );
	} else {
		$content = get_the_excerpt( $post_id );
	}
	return $content;
}

/**
 * Get the columns class for bootstrap.
 *
 * @param string $columns
 * @return void
 */
function column_class( $columns = '3' ) {
	$cols  = '';
	$cols .= '5' === $columns ? '15' : 12 / $columns;
	return $cols;
}

/**
 * Gets the exercises by the workout ID.
 *
 * @param string $workout
 * @return void
 */
function get_exercises_by_workout( $workout = '' ) {
	$exercises = array();
	$i               = 1;
	$section_counter = 6;
	while ( $i <= $section_counter ) {
		$group_name = 'workout_section_' . $i;
		$groups     = get_post_meta( $workout, $group_name, true );
		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				if ( isset( $group['connected_exercises'] ) ) {
					$exercises[] = $group['connected_exercises'];
				}
			}
		}
		$i++;
	}
	return $exercises;
}


/**
 * Gets the current users progress on a plan.
 *
 * @param  int $plan_id
 * @return int
 */
function get_progress( $plan_id = false ) {
	$progress = 0;
	$complete = array();
	$count    = 0;
	if ( false !== $plan_id &&  \lsx_health_plan\functions\plan\has_sections( $plan_id ) ) {
		$sections = \lsx_health_plan\functions\plan\get_sections();
		$all_count = count( $sections );
		$rest_days = 0;
		foreach ( $sections as $section_key => $section_values ) {
			if ( false !== $section_values['rest_day_enabled'] && ! $section_values['connected_meals'] ) {
				$rest_days++;
			} else if ( lsx_health_plan_is_day_complete( $plan_id, $section_values['title'] ) ) {
				$complete[] = true;
			}
		}
		$all_count = $all_count - $rest_days;
		$progress  = (int) count( $complete ) / (int) $all_count * 100;
	}
	return $progress;
}



/**
 * Link to back to archive for taxonomy pages
 *
 * @return void
 */
function hp_back_archive_link() {
	global $wp_taxonomies;
	$post_type = get_queried_object()->taxonomy;

	if ( is_tax() && isset( $wp_taxonomies[ $post_type ] ) ) {
		$post_type = $wp_taxonomies[ $post_type ]->object_type;
		?>
		<div class="archive-category-title hp-archive-category-title">
			<a class="back-to-blog" href="<?php echo ( esc_url( get_post_type_archive_link( $post_type[0] ) ) ); ?>"><?php echo esc_html__( 'Back To ', 'lsx' ) . esc_html( $post_type[0] ) . 's'; ?></a>
		</div>
		<?php
	}
}
add_action( 'lsx_content_wrap_before', '\lsx_health_plan\functions\hp_back_archive_link', 20 );

/**
 * Returns an array.
 *
 * @param  mixed $item
 * @return array
 */
function prep_array( $item ) {
	if ( ! is_array( $item ) ) {
		$item = explode( ',', $item );
		if ( ! is_array( $item ) ) {
			$item = array( $item );
		}
	}
	return $item;
}
