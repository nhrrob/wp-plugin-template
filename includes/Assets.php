<?php

namespace Nhrrob\WpPluginTemplate;

/**
 * Assets handler class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'wp-plugin-template-script' => [
                'src'     => WP_PLUGIN_TEMPLATE_ASSETS . '/js/frontend.js',
                'version' => filemtime( WP_PLUGIN_TEMPLATE_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wp-plugin-template-admin-script' => [
                'src'     => WP_PLUGIN_TEMPLATE_ASSETS . '/js/admin.js',
                'version' => filemtime( WP_PLUGIN_TEMPLATE_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ]
            ],
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'wp-plugin-template-style' => [
                'src'     => WP_PLUGIN_TEMPLATE_ASSETS . '/css/frontend.css',
                'version' => filemtime( WP_PLUGIN_TEMPLATE_PATH . '/assets/css/frontend.css' )
            ],
            'wp-plugin-template-admin-style' => [
                'src'     => WP_PLUGIN_TEMPLATE_ASSETS . '/css/admin.css',
                'version' => filemtime( WP_PLUGIN_TEMPLATE_PATH . '/assets/css/admin.css' )
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'wp-plugin-template-admin-script', 'wpPluginTemplate', [
            'nonce' => wp_create_nonce( 'wp-plugin-template-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'wp-plugin-template' ),
            'error' => __( 'Something went wrong', 'wp-plugin-template' ),
        ] );
    }
}
