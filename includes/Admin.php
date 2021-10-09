<?php

namespace Nhrrob\Plugin;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $resourcebook = new Admin\Resourcebook();

        $this->dispatch_actions( $resourcebook );

        new Admin\Menu( $resourcebook );
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions( $resourcebook ) {
        add_action( 'admin_init', [ $resourcebook, 'form_handler' ] );
        add_action( 'admin_post_nhrrob-plugin-delete-resource', [ $resourcebook, 'delete_resource' ] );
    }
}
