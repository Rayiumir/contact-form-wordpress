<?php

// Contact Uninstall Table

function contact_uninstall_table(){
    global $wpdb;
    
    $tableName = $wpdb->prefix . 'contacts';
    $wpdb->query("DROP TABLE IF EXISTS $tableName");
}
register_uninstall_hook(__FILE__, 'contact_uninstall_table');