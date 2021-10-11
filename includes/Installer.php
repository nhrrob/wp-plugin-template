<?php

namespace Reslab\ReslabMatchingForm;

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
        $installed = get_option( 'reslab_matching_form_installed' );

        if ( ! $installed ) {
            update_option( 'reslab_matching_form_installed', time() );
        }

        update_option( 'reslab_matching_form_version', RESLAB_MATCHING_FORM_VERSION );
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
