<?php
/**
 * Plugin Name: Nhrrob Plugin
 * Description: A starter WordPress plugin
 * Plugin URI: https://nazmulrobin.com
 * Author: Nazmul Hasan Robin
 * Author URI: https://nazmulrobin.com
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Nhrrob_Plugin {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     *
     * @return \Nhrrob_Plugin
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'NHRROB_PLUGIN_VERSION', self::version );
        define( 'NHRROB_PLUGIN_FILE', __FILE__ );
        define( 'NHRROB_PLUGIN_PATH', __DIR__ );
        define( 'NHRROB_PLUGIN_URL', plugins_url( '', NHRROB_PLUGIN_FILE ) );
        define( 'NHRROB_PLUGIN_ASSETS', NHRROB_PLUGIN_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Nhrrob\Plugin\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Nhrrob\Plugin\Ajax();
        }

        if ( is_admin() ) {
            new Nhrrob\Plugin\Admin();
        } else {
            new Nhrrob\Plugin\Frontend();
        }

        new Nhrrob\Plugin\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Nhrrob\Plugin\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Nhrrob_Plugin
 */
function nhrrob_plugin() {
    return Nhrrob_Plugin::init();
}

//call the plugin
nhrrob_plugin();
