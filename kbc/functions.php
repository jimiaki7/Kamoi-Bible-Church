<?php
/*
@package kbc
**********************
	functions.php
**********************
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit; 

require get_template_directory() . '/inc/function-admin.php';
require get_template_directory() . '/inc/theme-support.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/clean-up.php';
require get_template_directory() . '/inc/enqueue.php';

// enable dashicons
function load_dashicons() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'load_dashicons' );


// add meta description to the head
function kbc_description () {
    $description = '';

    if ( is_home() || is_front_page() ) {
        $description = 'かもい聖書教会, JECA日本福音キリスト教会連合, JECA, Kamoi Bible Church, KBC, 横浜, Yokohama';
    } elseif ( is_single() || is_page() ) {
        $description = trim( strip_tags( get_the_excerpt() ) ); // strip_tags shouldn't be needed

        if ( strlen( $description ) > 100 ) {
            $description = substr( $description, 0, strpos( $description, ' ', 100 ) );
        }
    } elseif ( is_category() || is_tag() ) {
        $description = 'かもい聖書教会の “' . single_cat_title('', false) . '” カテゴリーの記事です。';
    }
    return esc_html( $description );
}

// Sidebar function
function kbc_widget_setup() {

    register_sidebar(
        array(
            'name'  =>  'Main Sidebar',
            'id'    =>  'sidebar',
            'class' =>  'custom',
            'description'   =>  'Main Sidebar',
            'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  =>  '</aside>',
            'before_title'  =>  '<h3 class="widget-title">',
            'after_title'   =>  '</h3>',
        )
    );
}
add_action( 'widgets_init', 'kbc_widget_setup' );