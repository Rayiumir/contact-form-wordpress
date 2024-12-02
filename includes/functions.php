<?php

// Contact Table 

function contact_table() {

    global $wpdb;

    $tableName = $wpdb->prefix . 'contacts';
    $charsetCollate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charsetCollate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}

// Contact Handle Form

function contact_handle_form(){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if(empty($name) || empty($email) || empty($message)){
        wp_die('All Fields are required.');
    }

    global $wpdb;
    $tableName = $wpdb->prefix . 'contacts';
    $wpdb->insert($tableName, [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'created_at' => current_time('mysql')
    ]);

    wp_redirect(home_url('/'));
    exit;
}
add_action( 'admin_post_contact_handle_form', 'contact_handle_form' );
add_action( 'admin_post_nopriv_contact_handle_form', 'contact_handle_form' );