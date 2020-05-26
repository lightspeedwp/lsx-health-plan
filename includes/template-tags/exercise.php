<?php
/**
 * LSX Health Plan Template Tags.
 *
 * @package lsx-health-plan
 */

/**
 * Outputs the exercise type.
 *
 * @return exercise_type
 */
function lsx_health_plan_exercise_type() {
	$term_obj_list = get_the_term_list( get_the_ID(), 'exercise-type', '', ', ' );
	if ( ! empty( $term_obj_list ) ) {
		return $term_obj_list;
	}
}

/**
 * Outputs the exercise Muscle Groups.
 *
 * @return muscle_group_equipment
 */
function lsx_health_plan_muscle_group_equipment() {
	$term_obj_list = get_the_term_list( get_the_ID(), 'muscle-group', '', ', ' );
	if ( ! empty( $term_obj_list ) ) {
		return $term_obj_list;
	}
}

/**
 * Outputs the exercise equipment.
 *
 * @return exercise_equipment
 */
function lsx_health_plan_exercise_equipment() {
	$term_obj_list = get_the_term_list( get_the_ID(), 'equipment', '', ', ' );
	if ( ! empty( $term_obj_list ) ) {
		return $term_obj_list;
	}
}

/**
 * Outputs the exercise info on a table.
 *
 * @return void
 */
function lsx_health_plan_exercise_data() {
	include LSX_HEALTH_PLAN_PATH . '/templates/table-exercise-data.php';
}

/**
 * A function to call the play button
 *
 * @param string  $m A unique ID for the modal.
 * @param array   $group The current workout set being looped through.
 * @param boolean $echo
 * @param array   $args
 * @return void
 */
function lsx_health_plan_workout_exercise_button( $m, $group, $echo = true, $args = array() ) {
	$defaults    = array(
		'modal_trigger' => 'button',
	);
	$args        = wp_parse_args( $args, $defaults );
	$exercise_id = '';
	if ( isset( $group['connected_exercises'] ) && '' !== $group['connected_exercises'] ) {
		$exercise_id     = esc_html( $group['connected_exercises'] );
		$content         = get_post_field( 'post_content', $exercise_id );
		$content         = wp_trim_words( $content, 40 );
		$url             = get_permalink( $exercise_id );
		$equipment_group = get_the_term_list( $exercise_id, 'equipment', '', ', ' );
		$muscle_group    = get_the_term_list( $exercise_id, 'muscle-group', '', ', ' );
		$lsx_hp          = lsx_health_plan();

		if ( 'link' ) {
			$play_button = '<a data-toggle="modal" href="#workout-exercise-modal-' . $m . '">' . get_the_title( $exercise_id ) . '</a>';
		} else {
			$play_button = '<button data-toggle="modal" data-target="#workout-exercise-modal-' . $m . '"><span class="fa fa-play-circle"></span></button>';
		}

		$modal_body  = '';
		if ( $lsx_hp->frontend->gallery->has_gallery( $exercise_id ) ) {
			$gallery_args = array(
				'css_class' => 'modal-slider',
			);
			$modal_body .= $lsx_hp->frontend->gallery->get_gallery( '', '', $gallery_args );
		} else {
			$modal_body .= '<div class="modal-image"/>' . get_the_post_thumbnail( $exercise_id, 'lsx-thumbnail-single' ) . '</div>';
		}

		$modal_body .= '<div class="title-lined exercise-modal"><h5 class="modal-title">' . get_the_title( $exercise_id ) . '</h5>';

		if ( ! empty( $equipment_group ) ) {
			$modal_body .= '<span class="equipment-terms">Equipment: ' . $equipment_group . '</span>';
		}
		if ( ! empty( $muscle_group ) ) {
			$modal_body .= '<span class="muscle-terms">Muscle Group: ' . $muscle_group . '</span>';
		}
		$modal_body .= '</div>';
		$modal_body .= '<div class="modal-excerpt"/>' . $content . '</div>';
		$modal_body .= '<a class="moretag" target="_blank" href="' . $url . '">' . __( 'Read More', 'lsx-heal-plan' ) . '</a>';
		\lsx_health_plan\functions\register_modal( 'workout-exercise-modal-' . $m, '', $modal_body );

		if ( true === $echo ) {
			echo wp_kses_post( $play_button );
		} else {
			return $play_button;
		}
	}
}

/**
 * Outputs the modal button and registers the exercise modal to show.
 *
 * @param int $m
 * @param array $group
 * @return void
 */
function lsx_health_plan_shortcode_exercise_button( $m, $content = true ) {
	$equipment_group = get_the_term_list( $m, 'equipment', '', ', ' );
	$muscle_group    = get_the_term_list( $m, 'muscle-group', '', ', ' );
	$title           = get_the_title();
	$lsx_hp          = lsx_health_plan();
	$button     = '<a data-toggle="modal" href="#exercise-modal-' . $m . '" data-target="#exercise-modal-' . $m . '"></a>';

	if ( true === $content ) {
		$content = get_the_content();
	}

	$modal_body = '';
	if ( $lsx_hp->frontend->gallery->has_gallery( $m ) ) {
		$gallery_args = array(
			'css_class' => 'modal-slider',
		);
		$modal_body .= $lsx_hp->frontend->gallery->get_gallery( '', '', $gallery_args );
	} else {
		$modal_body .= '<div class="modal-image">' . get_the_post_thumbnail( $m, 'lsx-thumbnail-single' ) . '</div>';
	}
	$modal_body .= '<div class="title-lined exercise-modal"><h5 class="modal-title">' . $title . '</h5>';

	if ( ! empty( $equipment_group ) ) {
		$modal_body .= '<span class="equipment-terms">Equipment: ' . $equipment_group . '</span>';
	}
	if ( ! empty( $muscle_group ) ) {
		$modal_body .= '<span class="muscle-terms">Muscle Group: ' . $muscle_group . '</span>';
	}
	$modal_body .= '</div>';
	$modal_body .= $content;
	\lsx_health_plan\functions\register_modal( 'exercise-modal-' . $m, '', $modal_body );

	return ( $button );
}

/**
 * Gets the exercise title along with the side its on.
 *
 * @param  string $before
 * @param  string $after
 * @param  boolean $echo
 * @return string
 */
function lsx_health_plan_exercise_title( $before = '', $after = '', $echo = true, $exercise_id = false ) {
	if ( false === $exercise_id ) {
		$exercise_id = get_the_ID();
	}
	$title = get_the_title( $exercise_id );
	$side  = get_post_meta( $exercise_id, 'exercise_side', true );
	if ( '' !== $side ) {
		$title .= ' - ' . ucwords( $side );
	}
	$title = apply_filters( 'lsx_health_plan_exercise_title', $before . $title . $after, $title, $before, $after, $exercise_id );
	if ( true === $echo ) {
		echo wp_kses_post( $title );
	} else {
		return $title;
	}
}
