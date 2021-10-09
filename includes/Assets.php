<?php

namespace Nhrrob\Plugin;

/**
 * Assets handlers class
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
            'nhrrob-plugin-script' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/js/frontend.js',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'nhrrob-plugin-enquiry-script' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/js/enquiry.js',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/js/enquiry.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'nhrrob-plugin-admin-script' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/js/admin.js',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/js/admin.js' ),
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
            'nhrrob-plugin-style' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/css/frontend.css',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/css/frontend.css' )
            ],
            'nhrrob-plugin-admin-style' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/css/admin.css',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/css/admin.css' )
            ],
            'nhrrob-plugin-enquiry-style' => [
                'src'     => NHRROB_PLUGIN_ASSETS . '/css/enquiry.css',
                'version' => filemtime( NHRROB_PLUGIN_PATH . '/assets/css/enquiry.css' )
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

        wp_localize_script( 'nhrrob-plugin-enquiry-script', 'nhrrobPlugin', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'error'   => __( 'Something went wrong', 'nhrrob-plugin' ),
        ] );

        wp_localize_script( 'nhrrob-plugin-admin-script', 'nhrrobPlugin', [
            'nonce' => wp_create_nonce( 'nhrrob-plugin-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'nhrrob-plugin' ),
            'error' => __( 'Something went wrong', 'nhrrob-plugin' ),
        ] );
    }
}
