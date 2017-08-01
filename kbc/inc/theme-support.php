<?php 
/*
@package kbc
=====================
    THEME SUPPORT
=====================
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

function kbc_theme_support_setup(){

// post-thumbnails
add_theme_support('post-thumbnails');

// post-formats
$options = get_option( 'post_formats' );
$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
$output = array();
foreach ( $formats as $format ) {
    $output[] = ( @$options[$format] == 1 ? $format : '' );
}
if( !empty( $options ) ){
    add_theme_support( 'post-formats', $output );
}

// custom-header
$header = get_option( 'custom_header' );
if( @$header == 1 ){
    $deafaults = array(
    'default-image'          => '',
	'random-default'         => false,
	'width'                  => 0,
	'height'                 => 0,
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
    );
    add_theme_support( 'custom-header' );
}

// custom-background
$background = get_option( 'custom_background' );
if( @$background == 1 ){
    add_theme_support( 'custom-background' );
}

if( function_exists ('add_theme_support') ) {
    // html5
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
    
    // title-tag
    add_theme_support( 'title-tag' );
    
    // custom-logo
    add_theme_support( 'custom-logo', array(
        'height'      => 90,
        'width'       => 90,
        'flex-height' => true 
    ) );
    
    // menu
    add_theme_support( 'menus' ); 
    
    // register menu location
    register_nav_menu( 'main', 'Main Header Navigation'); //header main nav
    register_nav_menu( 'feature', 'feature Navigation'); //feature nav (such as feature link to other pages). 
    register_nav_menu( 'footer', 'Footer Navigation'); //Footer nav
    

}}
add_action( 'after_setup_theme', 'kbc_theme_support_setup' );

function kbc_title_separator ( $sep ) {
    $sep = ":";
    return $sep;
}
add_filter( 'document_title_separator', 'kbc_title_separator' );