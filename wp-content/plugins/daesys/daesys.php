<?php

/**
 * Plugin Name: DAESys
 * Plugin URI: https://ic.unicamp.br/~everton
 * Description: Plugin para gerenciamento do site DAESys
 * Author: EvM.
 * Version: 1.0
 * Text Domain: DAESys
 * Plugin DAESys
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// ***************** Add DB
function add_db_access()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'access';
    $sql = "CREATE TABLE $table_name (`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,`ipadress` text NOT NULL,`time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL)$charset_collate;";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    $table_name2 = $wpdb->prefix . 'login';
    $sql = "CREATE TABLE $table_name2 (`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT, `user` text NOT NULL,`ipadress` text NOT NULL,`time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL)$charset_collate;";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name2'") != $table_name2) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } 
    
    $table_name3 = $wpdb->prefix . 'snis';
    $sql = "CREATE TABLE $table_name3 (`ano` int PRIMARY KEY NOT NULL AUTO_INCREMENT,`IN001` decimal (10,2),`IN008` decimal (10,2),`IN011` decimal (10,2),`IN016` decimal (10,2),`IN020` decimal (10,2),`IN023` decimal (10,2),`IN024` decimal (10,2),`IN026` decimal (10,2),`IN030` decimal (10,2),`IN049` decimal (10,2),`IN053` decimal (10,2),`IN060` decimal (10,2),`IN102` decimal (10,2))$charset_collate;";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name3'") != $table_name3) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    //administrator
    //editor
    //author
    //contributor
    //subscriber

    remove_role('contributor');
    remove_role('author');
    flush_rewrite_rules();
    
}
register_activation_hook(__FILE__, 'add_db_access');


// DEACTIVATE *************************************************
function deactivate()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'deactivate');


// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/daesys/includes/functions.php';
include ABSPATH . '/wp-content/plugins/daesys/includes/oracle.php';

// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/daesys/includes/settings.php';

// POSTMETA ************************************************
include ABSPATH . '/wp-content/plugins/daesys/includes/post.php';
