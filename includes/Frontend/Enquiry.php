<?php

namespace Nhrrob\Plugin\Frontend;

/**
 * Shortcode handler class
 */
class Enquiry {

    /**
     * Initialize the class
     */
    function __construct() {
        add_shortcode( 'nhrrob-plugin-enquiry', [ $this, 'render_shortcode' ] );
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
        wp_enqueue_script( 'nhrrob-plugin-enquiry-script' );
        wp_enqueue_style( 'nhrrob-plugin-enquiry-style' );

        ob_start();
        include __DIR__ . '/views/enquiry.php';

        return ob_get_clean();
    }
}
