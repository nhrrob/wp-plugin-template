<?php

namespace Nhrrob\Plugin;

/**
 * Ajax handler class
 */
class Ajax {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_ajax_nhrrob_plugin_enquiry', [ $this, 'submit_enquiry'] );
        add_action( 'wp_ajax_nopriv_nhrrob_plugin_enquiry', [ $this, 'submit_enquiry'] );

        add_action( 'wp_ajax_wd-nhrrob-plugin-delete-contact', [ $this, 'delete_contact'] );
    }

    /**
     * Handle Enquiry Submission
     *
     * @return void
     */
    public function submit_enquiry() {

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'nhrrob-plugin-enquiry-form' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'nhrrob-plugin' )
            ] );
        }

        wp_send_json_success([
            'message' => __( 'Enquiry has been sent successfully!', 'nhrrob-plugin' )
        ]);
    }

    /**
     * Handle contact deletion
     *
     * @return void
     */
    public function delete_contact() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'nhrrob-plugin-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'nhrrob-plugin' )
            ] );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'No permission!', 'nhrrob-plugin' )
            ] );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
        nhrrob_plugin_delete_resource( $id );

        wp_send_json_success();
    }
}
