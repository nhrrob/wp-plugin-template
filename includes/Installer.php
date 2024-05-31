<?php

namespace SamplePlugin;

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
        $installed = get_option( 'sample_plugin_installed' );

        if ( ! $installed ) {
            update_option( 'sample_plugin_installed', time() );
        }

        update_option( 'sample_plugin_version', SAMPLE_PLUGIN_VERSION );
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
