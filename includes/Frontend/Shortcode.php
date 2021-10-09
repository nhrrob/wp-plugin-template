<?php

namespace Nhrrob\Plugin\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'nhrrob-plugin', [ $this, 'render_shortcode' ] );
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
        wp_enqueue_script( 'nhrrob-plugin-script' );
        wp_enqueue_style( 'nhrrob-plugin-style' );

        return '<div class="nhrrob-plugin-shortcode">Hello from Shortcode</div>';
    }
}
