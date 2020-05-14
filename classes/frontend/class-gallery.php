<?php
namespace lsx_health_plan\classes\lib;

/**
 * Contains the gallery functionality.
 *
 * @package lsx-health-plan
 */
class Gallery {

	/**
	 * Holds class instance
	 *
	 * @var object \lsx_health_plan\classes\lib\Gallery()
	 */
	protected static $instance = null;

	/**
	 * The current item ID.
	 *
	 * @var boolean | int
	 */
	public $item_id = false;

	/**
	 * If the current post has a gallery.
	 *
	 * @var boolean
	 */
	public $has_gallery = false;

	/**
	 * Holds the array of gallery images.
	 *
	 * @var array
	 */
	public $gallery = array();

	/**
	 * Contructor
	 */
	public function __construct() {
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\lib\Gallery()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Check if the item has a gallery of images returns true or false.
	 *
	 * @param  string $item_id
	 * @param  string $post_type
	 * @return boolean
	 */
	public function has_gallery( $item_id = '', $post_type = '' ) {
		if ( '' === $item_id ) {
			$this->item_id = get_the_ID();
		}
		if ( '' === $item_id ) {
			$post_type = get_post_type( $item_id );
		}
		$gallery = get_post_meta( $item_id, $post_type . '_gallery', true );
		if ( ! empty( $gallery ) ) {
			$this->gallery     = $gallery;
			$this->has_gallery = true;
		}
		$this->has_gallery;
	}
}
