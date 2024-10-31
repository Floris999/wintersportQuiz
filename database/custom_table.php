<?php
function create_custom_tables()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_name_wintersport = $wpdb->prefix . 'wintersport';
    $sql_wintersport = "CREATE TABLE $table_name_wintersport (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        land varchar(50) NOT NULL,
        vliegveld varchar(50) NOT NULL,
        grootte varchar(50) NOT NULL,
        sneeuwzekerheid varchar(50) NOT NULL,
        kindvriendelijk varchar(50) NOT NULL,
        offpiste varchar(50) NOT NULL,
        apresski varchar(50) NOT NULL,
        activiteiten varchar(50) NOT NULL,
        skimodern varchar(50) NOT NULL,
        metwie varchar(50) NOT NULL,
        budget varchar(50) NOT NULL,
    aanbeveling text NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_wintersport);
}
