<?php

namespace Nhrrob\Plugin\Admin;

use Nhrrob\Plugin\Traits\Form_Error;

/**
 * Resourcebook Handler class
 */
class Resourcebook {

    use Form_Error;

    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/resource-new.php';
                break;

            case 'edit':
                $resource  = nhrrob_plugin_get_resource( $id );
                $template = __DIR__ . '/views/resource-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/resource-view.php';
                break;

            default:
                $template = __DIR__ . '/views/resource-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_resource'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-resource' ) ) {
            wp_die( 'Permission denied!' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Permission denied!' );
        }

        $id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
        $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $resource = isset( $_POST['resource'] ) ? sanitize_textarea_field( $_POST['resource'] ) : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a name', 'nhrrob-plugin' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'name'    => $name,
            'resource' => $resource,
        ];

        if ( $id ) {
            $args['id'] = $id;
        }

        $insert_id = nhrrob_plugin_insert_resource( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $id ) {
            $redirected_to = admin_url( 'admin.php?page=nhrrob-plugin&action=edit&resource-updated=true&id=' . $id );
        } else {
            $redirected_to = admin_url( 'admin.php?page=nhrrob-plugin&inserted=true' );
        }

        wp_redirect( $redirected_to );
        exit;
    }

    public function delete_resource() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'nhrrob-plugin-delete-resource' ) ) {
            wp_die( 'Permission denied!' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Permission denied!' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( nhrrob_plugin_delete_resource( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=nhrrob-plugin&resource-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=nhrrob-plugin&resource-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}
