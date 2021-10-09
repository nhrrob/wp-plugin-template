<?php

namespace Nhrrob\Plugin;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'nhrrob_plugin_installed' );

        if ( ! $installed ) {
            update_option( 'nhrrob_plugin_installed', time() );
        }

        update_option( 'nhrrob_plugin_version', NHRROB_PLUGIN_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nhrrob_plugin_resources` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `created_by` bigint(20) unsigned NOT NULL,
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}
