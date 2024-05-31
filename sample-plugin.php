<?php
/**
 * Plugin Name: Sample Plugin
 * Description: This is a sample plugin. Feel free to use as template.
 * Plugin URI: https://www.example.com/
 * Author: Plugin Author
 * Author URI: https://www.example.com/
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
final class Sample_Plugin {

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
     * @return \Sample_Plugin
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
        define( 'SAMPLE_PLUGIN_VERSION', self::version );
        define( 'SAMPLE_PLUGIN_FILE', __FILE__ );
        define( 'SAMPLE_PLUGIN_PATH', __DIR__ );
        define( 'SAMPLE_PLUGIN_URL', plugins_url( '', SAMPLE_PLUGIN_FILE ) );
        define( 'SAMPLE_PLUGIN_ASSETS', SAMPLE_PLUGIN_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new SamplePlugin\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new SamplePlugin\Ajax();
        }

        if ( is_admin() ) {
            new SamplePlugin\Admin();
        } else {
            new SamplePlugin\Frontend();
        }

        new SamplePlugin\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new SamplePlugin\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Sample_Plugin
 */
function sample_plugin() {
    return Sample_Plugin::init();
}

//call the plugin
sample_plugin();
