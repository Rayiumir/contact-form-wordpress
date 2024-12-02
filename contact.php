<?php

/*
* Plugin Name: Simple Contact
* Description: Simple Contact Form Plugin for Wordpress
* Version: 1.0
* Author: Raymond Baghumian
* Author URI: https://github.com/Rayiumir/contact-form-wordpress
*/

if(!defined('ABSPATH')){
    exit;
}

define( 'RAYIUM_CONTACT_INCLUDES', plugin_dir_path( __FILE__ ) . 'includes/' );
define( 'RAYIUM_CONTACT_VIEWS', plugin_dir_path( __FILE__ ) . 'views/' );

define( 'RAYIUM_CONTACT_CSS', plugin_dir_url( __FILE__ ) . 'css/' );
define( 'RAYIUM_CONTACT_JS', plugin_dir_url( __FILE__ ) . 'js/' );

// For Function contact_table

register_activation_hook( __FILE__, 'contact_table' );

// Include modules

require( RAYIUM_CONTACT_INCLUDES . 'functions.php' );
require( RAYIUM_CONTACT_INCLUDES . 'enqueue.php' );
require( RAYIUM_CONTACT_VIEWS . 'contactView.php' );
