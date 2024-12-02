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

// Manage Contact

function contact_register_admin_page(){
   
    add_menu_page(
        'Manage Contact',
        'Manage Contact',
        'manage_options',
        'contact_submissions',
        'contact_display_admin_page',
        'dashicons-email-alt'
    );
}
add_action('admin_menu', 'contact_register_admin_page');

// Contact Page

function contact_display_admin_page(){

    global $wpdb;
    $tableName = $wpdb->prefix . 'contacts';
    $contacts = $wpdb->get_results("SELECT * FROM $tableName ORDER BY created_at DESC");

    ?>
    <div class="wrap">
        <h1 style="margin-top: 40px; margin-bottom: 20px;">Manage Contact</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-name column-primary" width="150px;">Name</th>
                    <th scope="col" class="manage-column column-email" width="150px;">Email</th>
                    <th scope="col" class="manage-column column-message">Message</th>
                    <th scope="col" class="manage-column column-created_at" width="150px;">Created At</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php foreach ($contacts as $row) { ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->message; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}
