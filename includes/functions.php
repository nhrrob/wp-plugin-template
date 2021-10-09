<?php

/**
 * Insert a new resource
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function nhrrob_plugin_insert_resource( $args = [] ) {
    global $wpdb;

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name.', 'nhrrob-plugin' ) );
    }

    $defaults = [
        'name'       => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {

        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            $wpdb->prefix . 'nhrrob_plugin_resources',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%d',
                '%s'
            ],
            [ '%d' ]
        );

        nhrrob_plugin_resource_purge_cache( $id );

        return $updated;

    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'nhrrob_plugin_resources',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'nhrrob-plugin' ) );
        }

        nhrrob_plugin_resource_purge_cache();

        return $wpdb->insert_id;
    }
}

/**
 * Fetch Resources
 *
 * @param  array  $args
 *
 * @return array
 */
function nhrrob_plugin_get_resources( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $last_changed = wp_cache_get_last_changed( 'resource' );
    $key          = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $cache_key    = "all:$key:$last_changed";

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}nhrrob_plugin_resources
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = wp_cache_get( $cache_key, 'resource' );

    if ( false === $items ) {
        $items = $wpdb->get_results( $sql );

        wp_cache_set( $cache_key, $items, 'resource' );
    }

    return $items;
}

/**
 * Get the count of total resource
 *
 * @return int
 */
function nhrrob_plugin_resource_count() {
    global $wpdb;

    $count = wp_cache_get( 'count', 'resource' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}nhrrob_plugin_resources" );

        wp_cache_set( 'count', $count, 'resource' );
    }

    return $count;
}

/**
 * Fetch a single contact from the DB
 *
 * @param  int $id
 *
 * @return object
 */
function nhrrob_plugin_get_resource( $id ) {
    global $wpdb;

    $resource = wp_cache_get( 'book-' . $id, 'resource' );

    if ( false === $resource ) {
        $resource = $wpdb->get_row(
            $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}nhrrob_plugin_resources WHERE id = %d", $id )
        );

        wp_cache_set( 'book-' . $id, $resource, 'resource' );
    }

    return $resource;
}

/**
 * Delete an resource
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function nhrrob_plugin_delete_resource( $id ) {
    global $wpdb;

    nhrrob_plugin_resource_purge_cache( $id );

    return $wpdb->delete(
        $wpdb->prefix . 'nhrrob_plugin_resources',
        [ 'id' => $id ],
        [ '%d' ]
    );
}

/**
 * Purge the cache for books
 *
 * @param  int $book_id
 *
 * @return void
 */
function nhrrob_plugin_resource_purge_cache( $book_id = null ) {
    $group = 'resource';

    if ( $book_id ) {
        wp_cache_delete( 'book-' . $book_id, $group );
    }

    wp_cache_delete( 'count', $group );
    wp_cache_set( 'last_changed', microtime(), $group );
}
