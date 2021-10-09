<?php
/**
 * Plugin Name: Wp Plugin Template
 * Description: A basic WordPress plugin. Starter kit for plugin development.
 * Plugin URI: https://nazmulrobin.com
 * Author: Nazmul Hasan Robin
 * Author URI: https://nazmulrobin.com
 * Version: 1.0.0
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
final class Wp_Plugin_Template {

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
     * @return \Wp_Plugin_Template
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
        define( 'WP_PLUGIN_TEMPLATE_VERSION', self::version );
        define( 'WP_PLUGIN_TEMPLATE_FILE', __FILE__ );
        define( 'WP_PLUGIN_TEMPLATE_PATH', __DIR__ );
        define( 'WP_PLUGIN_TEMPLATE_URL', plugins_url( '', WP_PLUGIN_TEMPLATE_FILE ) );
        define( 'WP_PLUGIN_TEMPLATE_ASSETS', WP_PLUGIN_TEMPLATE_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Nhrrob\WpPluginTemplate\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Nhrrob\WpPluginTemplate\Ajax();
        }

        if ( is_admin() ) {
            new Nhrrob\WpPluginTemplate\Admin();
        } else {
            new Nhrrob\WpPluginTemplate\Frontend();
        }

        new Nhrrob\WpPluginTemplate\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Nhrrob\WpPluginTemplate\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Wp_Plugin_Template
 */
function wp_plugin_template() {
    return Wp_Plugin_Template::init();
}

//call the plugin
wp_plugin_template();
