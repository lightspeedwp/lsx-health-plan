<?php
namespace lsx_health_plan\classes\frontend;

/**
 * Holds the functionality to check and control your status with the current plan.
 *
 * @package lsx-health-plan
 */
class Plan_Query {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\frontend\Plan_Query()
	 */
	protected static $instance = null;

	/**
	 * Holds the sections for the current plan.
	 *
	 * @var array
	 */
	public $sections = array();

	/**
	 * Holds the variable true/false if the current plan has sections or not.
	 *
	 * @var array
	 */
	public $has_sections = false;

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\frontend\Plan_Query()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function query_sections( $plan_id = '' ) {
		if ( '' === $plan_id ) {
			$plan_id = get_the_ID();
		}

		$section_array = get_post_meta( $plan_id, 'plan_sections', true );
		if ( ! empty( $section_array ) ) {
			$this->has_sections = true;
			$this->sections     = $section_array;
		}
		return $this->has_sections;
	}

	public function get_sections( $group = false ) {
		$sections = $this->sections;
		if ( false !== $group ) {
			$sections = $this->group_sections( $sections );
		}
		return $sections;
	}

	public function get_section_count() {
		return count( $this->sections );
	}

	/**
	 * This will group the sections by their "Group" field.
	 *
	 * @param  array $sections
	 * @return array
	 */
	public function group_sections( $sections = array() ) {
		$groups = array();
		if ( ! empty( $sections ) ) {
			foreach ( $sections as $section_key => $section_values ) {
				$group_key = apply_filters( 'lsx_hp_default_plan_group', __( 'Daily Plan', 'lsx-health-plan' ) );
				if ( isset( $section_values['group'] ) && '' !== $section_values['group'] ) {
					$group_key = $section_values['group'];
				}
				$group_key                            = sanitize_title( $group_key );
				$groups[ $group_key ][ $section_key ] = $section_values;
			}
		}
		return $groups;
	}
}
