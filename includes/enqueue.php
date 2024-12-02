<?php

defined('ABSPATH') || exit;

define("RAYIUM_CONTACT_VERSION", '1.0.0');
define("RAYIUM_ASSETS_VERSION", defined('WP_DEBUG') && WP_DEBUG ? time() : RAYIUM_CONTACT_VERSION);

function contact_styles(){
    
    wp_enqueue_style(
        'contact_css',
        RAYIUM_CONTACT_CSS . 'contact.css',
        RAYIUM_CONTACT_VERSION
    );

}
add_action( 'wp_head', 'contact_styles', 1);