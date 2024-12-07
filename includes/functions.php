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
                <th scope="col" class="manage-column column-name column-primary" width="50px;">ID</th>
                    <th scope="col" class="manage-column column-name column-primary" width="150px;">Name</th>
                    <th scope="col" class="manage-column column-email" width="150px;">Email</th>
                    <th scope="col" class="manage-column column-message">Message</th>
                    <th scope="col" class="manage-column column-created_at" width="150px;">Created At</th>
                    <th scope="col" class="manage-column column-created_at" width="50px;">Action</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php foreach ($contacts as $row) { ?>
                    <tr id="row-<?php echo esc_attr($row->id) ?>">
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->message; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                        <td><button type="button" class="delete-button" data-id="<?php echo esc_attr($row->id) ?>">Delete</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Removing Data Contacts

function handle_delete_data() {
    global $wpdb;

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'delete_data_nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    $id = intval($_POST['id']);
    $tableName = $wpdb->prefix . 'contacts';
    $deleted = $wpdb->delete($tableName, ['id' => $id], ['%d']);

    if ($deleted) {
        wp_send_json_success('Row deleted successfully');
    } else {
        wp_send_json_error('Failed to delete row');
    }

    wp_die();
}
add_action('wp_ajax_delete_data', 'handle_delete_data');
add_action('wp_ajax_nopriv_delete_data', 'handle_delete_data');
