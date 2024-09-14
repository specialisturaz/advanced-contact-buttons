<?php
// Direkt erişimi engelle
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function acb_create_tables() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'acb_buttons';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        type varchar(50) NOT NULL,
        label varchar(100) NOT NULL,
        icon varchar(100) DEFAULT '' NOT NULL,
        url varchar(255) DEFAULT '' NOT NULL,
        bg_color varchar(7) DEFAULT '#ffffff' NOT NULL,
        text_color varchar(7) DEFAULT '#000000' NOT NULL,
        border_radius varchar(10) DEFAULT '5px' NOT NULL,
        box_shadow varchar(50) DEFAULT '' NOT NULL,
        position varchar(20) DEFAULT 'bottom-right' NOT NULL,
        is_floating boolean DEFAULT true NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
