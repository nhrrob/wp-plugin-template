<?php
/**
 * Plugin Name: Reslab Matching Form
 * Description: Therapists selection Quiz. Provides a form for the user to submit and then automatically matches therapists based on the answers.
 * Plugin URI: https://www.resiliencelab.us/
 * Author: Reslab Matching Form
 * Author URI: https://www.resiliencelab.us/
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
final class Reslab_Matching_Form {

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
     * @return \Reslab_Matching_Form
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
        define( 'RESLAB_MATCHING_FORM_VERSION', self::version );
        define( 'RESLAB_MATCHING_FORM_FILE', __FILE__ );
        define( 'RESLAB_MATCHING_FORM_PATH', __DIR__ );
        define( 'RESLAB_MATCHING_FORM_URL', plugins_url( '', RESLAB_MATCHING_FORM_FILE ) );
        define( 'RESLAB_MATCHING_FORM_ASSETS', RESLAB_MATCHING_FORM_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Reslab\ReslabMatchingForm\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Reslab\ReslabMatchingForm\Ajax();
        }

        if ( is_admin() ) {
            new Reslab\ReslabMatchingForm\Admin();
        } else {
            new Reslab\ReslabMatchingForm\Frontend();
        }

        new Reslab\ReslabMatchingForm\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Reslab\ReslabMatchingForm\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Reslab_Matching_Form
 */
function reslab_matching_form() {
    return Reslab_Matching_Form::init();
}

//call the plugin
reslab_matching_form();
