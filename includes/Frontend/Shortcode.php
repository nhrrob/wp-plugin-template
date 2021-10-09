<?php

namespace Nhrrob\WpPluginTemplate\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initialize the class
     */
    function __construct() {
        add_shortcode( 'wp-plugin-template', [ $this, 'render_shortcode' ] );
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
        wp_enqueue_script( 'wp-plugin-template-script' );
        wp_enqueue_style( 'wp-plugin-template-style' );

        return '<div class="wp-plugin-template-shortcode">Hello from Shortcode</div>';
    }
}
