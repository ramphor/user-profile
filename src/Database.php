<?php
namespace Ramphor\User;

class Database {
    public function create_table() {
        global $wpdb;

        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ramphor_user_metas(
            ID BIGINT NOT NULL AUTO_INCREMENT,
            wp_user_id BIGINT,
            provider VARCHAR(100),
            identifier VARCHAR(255),
            profile_url VARCHAR(255),
            photo_url VARCHAR(255),
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            display_name VARCHAR(255),
            email VARCHAR(255),
            token TEXT,
            refresh_token TEXT,
            last_mofified DATETIME,
            PRIMARY KEY (ID)
        )";

        $wpdb->query($sql);
    }
}
