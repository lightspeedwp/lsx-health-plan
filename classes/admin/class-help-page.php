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
	 * Contructor
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
			wp_enqueue_style( 'lsx-hp-help-screen', get_template_directory_uri() . '/assets/css/admin/help.css', array(), LSX_VERSION );
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
		<div class="box enrich">
			<h2><?php esc_html_e( 'Built to enrich your WordPress experience.', 'lsx-health-plan' ); ?></h2>
			<p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris iaculis feugiat consectetur. Integer mollis ex lacus, sed ultrices felis mollis vitae.', 'lsx-health-plan' ); ?></p>
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
		?>
		<div>
			<ul>
				<li>Getting started: Setup a new Health Plan site from scratch.</li>
				<li>Settings overview: A thorough walkthrough of The Health Plan site configuration options and the settings that are available to you.</li>
				<li>Features overview: A complete look at the features you can expect to see right out of the box as well as how to use them.</li>
				<li>Plans (Parent Post Type)</li>
				<li>Weeks (Global Taxonomy)</li>
				<li>Tips (Global Post type connected to all other post types)</li>
				<li>Workouts (Plans Child Post Type)</li>
				<li>Exercises (Workouts Child Post Type)</li>
				<li>Exercise Types (Exercises Taxonomy)</li>
				<li>Equipment (Exercises Taxonomy)</li>
				<li>Muscle Group (Exercises Taxonomy)</li>
				<li>Meals (Plans Child Post Type)</li>
				<li>Recipes (Meal Plans Child Post Type)</li>
				<li>Types (Recipes Taxonomy)</li>
				<li>Cuisines (Recipes Taxonomy)</li>
				<li>Shortcodes: Insert content blocks for any content type.</li>
				<li>Using stylesheets and page templates: An overview of the default templates and styles that are included in the plugin, as well as how to change them.</li>
			</ul>
		</div>
		<?php
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
