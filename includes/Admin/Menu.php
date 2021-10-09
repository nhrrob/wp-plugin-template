<?php

namespace Nhrrob\Plugin\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $resourcebook;

    /**
     * Initialize the class
     */
    function __construct( $resourcebook ) {
        $this->resourcebook = $resourcebook;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'nhrrob-plugin';
        $capability = 'manage_options';

        $hook = add_menu_page( __( 'Nhrrob Plugin', 'nhrrob-plugin' ), __( 'Nhrrob Plugin', 'nhrrob-plugin' ), $capability, $parent_slug, [ $this->resourcebook, 'plugin_page' ], 'dashicons-welcome-learn-more' );
        add_submenu_page( $parent_slug, __( 'Resource Book', 'nhrrob-plugin' ), __( 'Resource Book', 'nhrrob-plugin' ), $capability, $parent_slug, [ $this->resourcebook, 'plugin_page' ] );
        add_submenu_page( $parent_slug, __( 'Settings', 'nhrrob-plugin' ), __( 'Settings', 'nhrrob-plugin' ), $capability, 'nhrrob-plugin-settings', [ $this, 'settings_page' ] );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        echo 'Settings Page';
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'nhrrob-plugin-admin-style' );
        wp_enqueue_script( 'nhrrob-plugin-admin-script' );
    }
}
