<?php

namespace SamplePlugin\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initialize the class
     */
    function __construct() {
        add_shortcode( 'sample-plugin', [ $this, 'render_shortcode' ] );
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
        wp_enqueue_script( 'sample-plugin-script' );
        wp_enqueue_style( 'sample-plugin-style' );

        return '<div class="sample-plugin-shortcode">Hello from Shortcode</div>';
    }
}
