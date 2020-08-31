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
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'lsx_hp_help', array( $this, 'header' ), 10 );
		add_action( 'lsx_hp_help', array( $this, 'body' ), 20 );
		add_action( 'lsx_hp_help', array( $this, 'footer' ), 30 );
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
	public function assets( $hook_suffix ) {
		if ( 'plan_page_help' === $hook_suffix ) {
			wp_enqueue_style( 'lsx-hp-help-screen', LSX_HEALTH_PLAN_URL . 'assets/css/help.css', array(), LSX_HEALTH_PLAN_VER );
			wp_style_add_data( 'lsx-hp-help-screen', 'rtl', 'replace' );
		}
	}

	/**
	 * Creates the dashboard page.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function register_menu() {
		add_submenu_page( 'edit.php?post_type=plan', __( 'Help', 'lsx-health-plan' ), __( 'Help', 'lsx-health-plan' ), 'manage_options', 'help', array( $this, 'screen' ) );
	}


	/**
	 * The help screen.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function screen() {
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
			 * @hooked lsx_hp_help_body - 20
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
	public function header() {
		?>
		<div class="enrich">
			<h2><?php esc_html_e( 'LightSpeed’s LSX Health Plugin', 'lsx-health-plan' ); ?></h2>
			<p><?php esc_html_e( "Thank you for using the LSX Health plugin. All of us here at LightSpeed appreciate your ongoing support and we can't wait to see what people create with the plugin. We're committed to ensuring you have all the help you need to make the most of the plugin.", 'lsx-health-plan' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Help screen body section.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function body() {
		include LSX_HEALTH_PLAN_PATH . 'templates/partials/help.php';
	}

	/**
	 * Help screen contribute section.
	 *
	 * @package    lsx
	 * @subpackage hp-help-page
	 */
	public function footer() {

	}
}
