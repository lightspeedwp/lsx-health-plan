<?php
namespace eetplan_lsx_child\classes;

/**
 * Contains the endpoints
 *
 * @package eetplan_lsx_child
 */
class Endpoints {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \eetplan_lsx_child\classes\Endpoints()
	 */
	protected static $instance = null;

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'setup' ), 11 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \eetplan_lsx_child\classes\Endpoints()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Runs on init
	 */
	public function setup() {
		$this->add_rewrite_rules();
	}

	/**
	 * Registers the rewrites.
	 */
	public function add_rewrite_rules() {
		// Here is where we add in the rewrite rules above the normal WP ones.
		add_rewrite_rule( 'plan/([^/]+)/ontbyt/?$', 'index.php?plan=$matches[1]&endpoint=recipes&endpoint=ontbyt', 'top' );
		add_rewrite_rule( 'plan/([^/]+)/middagete/?$', 'index.php?plan=$matches[1]&endpoint=recipes&endpoint=middagete', 'top' );
		add_rewrite_rule( 'plan/([^/]+)/aandete/?$', 'index.php?plan=$matches[1]&endpoint=recipes&endpoint=aandete', 'top' );
	}
}
