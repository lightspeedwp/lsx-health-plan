<?php
/**
 * Contains the settings class for LSX
 *
 * @package lsx-health-plan
 */

namespace lsx_health_plan\classes\admin;

/**
 * Contains the settings for each post type \lsx_health_plan\classes\admin\Help_Page().
 */
class Help_Page {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object \lsx_health_plan\classes\admin\Help_Page()
	 */
	protected static $instance = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var string
	 */
	protected $screen_id = 'lsx_hp_help';

	/**
	 * An array of the endpoints for the Endpoint Translation field.
	 *
	 * @var array
	 */
	public $endpoints = array();

	/**
	 * Contructor
	 */
	public function __construct() {
		add_action( 'lsx_hp_help', array( $this, 'lsx_hp_help_footer', 30 ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'lsx_hp_help_style' ) );
		add_action( 'admin_menu', array( $this, 'lsx_hp_help_register_menu' ) );
		add_action( 'lsx_hp_help', array( $this, 'lsx_hp_help_header', 10 ) );
		add_action( 'lsx_hp_help', array( $this, 'lsx_hp_help_enhance', 20 ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\admin\Help_Page()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}



	/**
	 * Load hp_help screen css.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 *
	 * @param string $hook_suffix the current page hook suffix.
	 */
	public function lsx_hp_help_style( $hook_suffix ) {
		if ( 'appearance_page_lsx-hp-help' === $hook_suffix ) {
			wp_enqueue_style( 'lsx-hp-help-screen-mailchimp', '//cdn-images.mailchimp.com/embedcode/classic-10_7.css', array(), LSX_VERSION );
			wp_enqueue_style( 'lsx-hp-help-screen', get_template_directory_uri() . '/assets/css/admin/help.css', array( 'lsx-hp-help-screen-mailchimp' ), LSX_VERSION );
			wp_style_add_data( 'lsx-hp-help-screen', 'rtl', 'replace' );
		}
	}

	/**
	 * Creates the dashboard page.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function lsx_hp_help_register_menu() {
		add_submenu_page( 'edit.php?post_type=plan', __( 'Help', 'lsx-health-plan' ), __( 'Help', 'lsx-health-plan' ), 'manage_options', 'lsx-hp-help', 'lsx_hp_help_screen' );
	}


	/**
	 * The help screen.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function lsx_hp_help_screen() {
		require_once ABSPATH . 'wp-load.php';
		require_once ABSPATH . 'wp-admin/admin.php';
		require_once ABSPATH . 'wp-admin/admin-header.php';
		?>
		<div class="wrap about-wrap">
			<?php
			/**
			 * Functions hooked into lsx_hp_help action
			 *
			 * @hooked lsx_hp_help_header  - 10
			 * @hooked lsx_hp_help_enhance - 20
			 * @hooked lsx_hp_help_footer  - 30
			 */
			do_action( 'lsx_hp_help' );
			?>
		</div>
		<?php
	}

	/**
	 * Help screen intro.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function lsx_hp_help_header() {

	}

	/**
	 * Help screen enhance section.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function lsx_hp_help_enhance() {

	}

	/**
	 * Help screen contribute section.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function lsx_hp_help_footer() {

	}
}
