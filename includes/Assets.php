<?php

namespace SamplePlugin;

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
            'sample-plugin-script' => [
                'src'     => SAMPLE_PLUGIN_ASSETS . '/js/frontend.js',
                'version' => filemtime( SAMPLE_PLUGIN_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'sample-plugin-admin-script' => [
                'src'     => SAMPLE_PLUGIN_ASSETS . '/js/admin.js',
                'version' => filemtime( SAMPLE_PLUGIN_PATH . '/assets/js/admin.js' ),
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
            'sample-plugin-style' => [
                'src'     => SAMPLE_PLUGIN_ASSETS . '/css/frontend.css',
                'version' => filemtime( SAMPLE_PLUGIN_PATH . '/assets/css/frontend.css' )
            ],
            'sample-plugin-admin-style' => [
                'src'     => SAMPLE_PLUGIN_ASSETS . '/css/admin.css',
                'version' => filemtime( SAMPLE_PLUGIN_PATH . '/assets/css/admin.css' )
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

        wp_localize_script( 'sample-plugin-admin-script', 'samplePlugin', [
            'nonce' => wp_create_nonce( 'sample-plugin-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'sample-plugin' ),
            'error' => __( 'Something went wrong', 'sample-plugin' ),
        ] );
    }
}
