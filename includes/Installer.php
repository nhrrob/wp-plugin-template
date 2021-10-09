<?php

namespace Nhrrob\WpPluginTemplate;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'wp_plugin_template_installed' );

        if ( ! $installed ) {
            update_option( 'wp_plugin_template_installed', time() );
        }

        update_option( 'wp_plugin_template_version', WP_PLUGIN_TEMPLATE_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        //
    }
}
