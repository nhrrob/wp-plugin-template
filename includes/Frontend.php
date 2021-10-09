<?php

namespace Nhrrob\Plugin;

/**
 * Frontend handler class
 */
class Frontend {

    /**
     * Initialize the class
     */
    function __construct() {
        new Frontend\Shortcode();
        new Frontend\Enquiry();
    }
}
