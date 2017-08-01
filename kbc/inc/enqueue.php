<?php
/*
@package kbc
=======================
    enqueue.php
=======================
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;


/* 
===============================
        BACK-END ENQUEUE
===============================
*/

function kbc_admin_scripts( $hook ){
    
    if( 'toplevel_page_kbc_settings' != $hook ){ return; }
        
    wp_register_style( 'kbc_admin_css', get_template_directory_uri() . '/css/kbc-admin.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'kbc_admin_css' );
    
    
    // calling the media upleader
    wp_enqueue_media();
    
    wp_register_script( 'kbc_admin_script', get_template_directory_uri() . '/js/kbc-admin.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'kbc_admin_script' );
}
add_action( 'admin_enqueue_scripts', 'kbc_admin_scripts' );


/* 
===============================
        FRONT-END ENQUEUE
===============================
*/

// normalize.css & style.css
function kbc_style_sheets() {
    wp_register_style( 'kbc_custom_style', get_template_directory_uri() . '/css/kbc.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'kbc_custom_style' );
}
add_action( 'wp_enqueue_scripts', 'kbc_style_sheets' );

// javascripts
function kbc_javascripts() {}
add_action( 'wp_enqueue_scripts', 'kbc_javascripts' );
