<?php

namespace Reslab\ReslabMatchingForm\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initialize the class
     */
    function __construct() {
        add_shortcode( 'reslab-matching-form', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        wp_enqueue_script( 'reslab-matching-form-script' );
        wp_enqueue_style( 'reslab-matching-form-style' );

        return '<div class="reslab-matching-form-shortcode">Hello from Shortcode</div>';
    }
}
