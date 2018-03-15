<?php
/**
 * Plugin Name: Jet Subscribe Extra
 * Plugin URI:  https://jettabs.zemez.io/
 * Description:
 * Version:     1.0.0
 * Author:      Zemez
 * Author URI:  https://zemez.io/wordpress/
 * Text Domain: jet-subscribe-extra
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Subscribe_Extra` doesn't exists yet.
if ( ! class_exists( 'Jet_Subscribe_Extra' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Subscribe_Extra {

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.0.0';

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Load files.
			add_action( 'init', array( $this, 'init' ), -999 );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'before_enqueue_scripts' ) );

			// Page popup initialization
			add_action( 'wp_footer', array( $this, 'popup_init' ) );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			do_action( 'jet-subscribe-extra/init', $this );

		}

		/**
		 * [popup_init description]
		 * @return [type] [description]
		 */
		public function popup_init() {
			require $this->get_template( 'popup-1.php' );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {

			wp_enqueue_style(
				'jet-subscribe-extra',
				$this->plugin_url( 'assets/css/jet-subscribe-extra.css' ),
				false,
				$this->get_version()
			);

		}

		/**
		 * [before_enqueue_scripts description]
		 * @return [type] [description]
		 */
		public function before_enqueue_scripts() {
			wp_enqueue_script(
				'jet-subscribe-extra',
				$this->plugin_url( 'assets/js/jet-subscribe-extra.js' ),
				array( 'elementor-frontend' ),
				$this->get_version(),
				true
			);
		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}
		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = $this->plugin_path( 'templates/' . $name );

			var_dump($template);

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

if ( ! function_exists( 'jet_subscribe_extra' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_subscribe_extra() {
		return Jet_Subscribe_Extra::get_instance();
	}
}

jet_subscribe_extra();
