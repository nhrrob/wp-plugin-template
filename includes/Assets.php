<?php

namespace Reslab\ReslabMatchingForm;

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
            'reslab-matching-form-script' => [
                'src'     => RESLAB_MATCHING_FORM_ASSETS . '/js/frontend.js',
                'version' => filemtime( RESLAB_MATCHING_FORM_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'reslab-matching-form-admin-script' => [
                'src'     => RESLAB_MATCHING_FORM_ASSETS . '/js/admin.js',
                'version' => filemtime( RESLAB_MATCHING_FORM_PATH . '/assets/js/admin.js' ),
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
            'reslab-matching-form-style' => [
                'src'     => RESLAB_MATCHING_FORM_ASSETS . '/css/frontend.css',
                'version' => filemtime( RESLAB_MATCHING_FORM_PATH . '/assets/css/frontend.css' )
            ],
            'reslab-matching-form-admin-style' => [
                'src'     => RESLAB_MATCHING_FORM_ASSETS . '/css/admin.css',
                'version' => filemtime( RESLAB_MATCHING_FORM_PATH . '/assets/css/admin.css' )
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

        wp_localize_script( 'reslab-matching-form-admin-script', 'reslabMatchingForm', [
            'nonce' => wp_create_nonce( 'reslab-matching-form-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'reslab-matching-form' ),
            'error' => __( 'Something went wrong', 'reslab-matching-form' ),
        ] );
    }
}
