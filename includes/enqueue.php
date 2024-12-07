<?php

defined('ABSPATH') || exit;

define("RAYIUM_CONTACT_VERSION", '1.0.0');
define("RAYIUM_ASSETS_VERSION", defined('WP_DEBUG') && WP_DEBUG ? time() : RAYIUM_CONTACT_VERSION);

// For Styles

function contact_styles(){
    
    wp_enqueue_style(
        'contact_css',
        RAYIUM_CONTACT_CSS . 'contact.css',
        RAYIUM_CONTACT_VERSION
    );

}
add_action( 'wp_head', 'contact_styles', 1);

// For Scripts

function contact_scripts(){

    $deps = ['jquery'];

    wp_enqueue_script(
        'contact_js',
        RAYIUM_CONTACT_JS . 'contact.js',
        $deps,
        RAYIUM_CONTACT_VERSION,
        true
    );

    wp_localize_script('contact_js', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('delete_data_nonce'),
    ]);

}
add_action( 'admin_enqueue_scripts', 'contact_scripts');