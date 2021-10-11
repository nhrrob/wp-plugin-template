<?php

namespace Reslab\ReslabMatchingForm\Admin;

/**
 * The Menu handler class
 */
class Menu {

    /**
     * Initialize the class
     */
    function __construct( ) {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'reslab-matching-form';
        $capability = 'manage_options';

        $hook = add_menu_page( __( 'Reslab Matching Form', 'reslab-matching-form' ), __( 'Reslab Matching Form', 'reslab-matching-form' ), $capability, $parent_slug, [ $this, 'settings_page' ], 'dashicons-welcome-learn-more' );
        // add_submenu_page( $parent_slug, __( 'Resource Book', 'reslab-matching-form' ), __( 'Resource Book', 'reslab-matching-form' ), $capability, $parent_slug, [ $this, 'plugin_page' ] );
        // add_submenu_page( $parent_slug, __( 'Settings', 'reslab-matching-form' ), __( 'Settings', 'reslab-matching-form' ), $capability, 'reslab-matching-form-settings', [ $this, 'settings_page' ] );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        _e('Settings Page Content', 'wp-plugin_template');
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'reslab-matching-form-admin-style' );
        wp_enqueue_script( 'reslab-matching-form-admin-script' );
    }
}
