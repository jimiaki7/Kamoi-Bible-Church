<?php
/*
@package kbc
============================
    CLEAN-UP FUNCTIONS
============================
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit; 

function kbc_head_cleanup () {

    remove_action( 'wp_head', 'wlwmanifest_link' ); // remove wlwmanifest.xml (needed to support windows live writer)
    remove_action( 'wp_head', 'wp_generator' ); // remove wordpress version

    remove_action( 'wp_head', 'rsd_link' ); // remove really simple discovery link
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); // remove shortlink

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // remove emojis
    remove_action( 'wp_print_styles', 'print_emoji_styles' );   // remove emojis
    
    remove_action( 'admin_print_script', 'print_emoji_detection_script' ); //remove admin emoji
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); // remove admin emoji
    
    //remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); remove next and previous post links

    remove_action( 'wp_head', 'feed_links', 2 ); // remove rss feed links
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // removes all extra rss feed links

    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 ); // remove the REST API link
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // remove oEmbed discovery links
    remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 ); // remove the REST API link from HTTP Headers

    remove_action( 'wp_head', 'wp_oembed_add_host_js' ); // remove oEmbed-specific javascript from front-end / back-end

    remove_action( 'rest_api_init', 'wp_oembed_register_route' ); // remove the oEmbed REST API route
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 ); // don't filter oEmbed results
    
    add_filter('the_generator', '__return_false');         
}
add_action('after_setup_theme', 'kbc_head_cleanup');

/* remove version string from js & css */
function kbc_remove_wp_version( $src ) {
    global $wp_version;
    parse_str( parse_url( $src, PHP_URL_QUERY ), $query );
    if( !empty( $query['ver'] ) && $query['ver'] == $wp_version ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'script_loader_src', 'kbc_remove_wp_version' );
add_filter( 'style_loader_src', 'kbc_remove_wp_version' );

/* remove 'text/css' tag from enqueued stylesheet */
function kbc_remove_style_loader_tag( $tag ) {
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}
/* remove 'text/javascript' tag from enqueued javascript */
function kbc_remove_script_loader_tag( $tag ) {
    return str_replace( "type='text/javascript'", "async='async'", $tag );
}
add_filter( 'style_loader_tag', 'kbc_remove_style_loader_tag' );
add_filter( 'style_loader_tag', 'kbc_remove_script_loader_tag' );

/* remove dns-prefetch */
function kbc_remove_dns_prefetch( $hints, $relation_type ) {
    if( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'kbc_remove_dns_prefetch', 10, 2 );

/* remove injected recent-comment style */
function kbc_remove_recent_comment_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array(
    $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ));
}
add_action( 'widgets_init', 'kbc_remove_recent_comment_style' );

/* remove injected classes, id's, and page id's from navigation <li> items */
function kbc_css_attributes_filter( $var ) {
    return is_array( $var ) ? array() : '';
}
add_filter( 'nav_menu_css_class', 'kbc_css_attributes_filter', 100, 1 );
add_filter( 'nav_menu_item_id', 'kbc_css_attributes_filter', 100 , 1 );
add_filter( 'page_css_class', 'kbc_css_attributes_filter', 100, 1 );

/* remove ":protected" title */
function kbc_remove_protected( $title ) {
    return'%s';
}
add_filter( 'protected_title_format', 'kbc_remove_protected' );

/*
==================
    * unautop *   
==================
remove auto injected <p> tag from whole site
*/

function override_mce_options( $init_array ) {
    global $allowedposttags;
    
    $init_array[ 'valid_elements' ]                 =   '*[*]';
    $init_array[ 'extended_valid_elements' ]        =   '*[*]';
    $init_array[ 'valid_children' ]        =   '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
    $init_array[ 'indent' ]                         =   true;
    $init_array[ 'wpautop' ]                        =   false;
    $init_array[ 'force_p_newlines' ]               =   false;
    
    return $init_array;
}
add_filter( 'tiny_mce_before_init', 'override_mce_options' );

/* uncomment below to apply unautop for certain post

add_filter( 'the_content', 'wpautop_filter', 9 );
function wpautop_filter( $content ) {
    global $post;
    $remove_filter = false;
     
    $arr_types = array( 'page', 'post' ); //autopを無効にする投稿タイプを配列として用意する
    $post_type = get_post_type( $post->ID );
    if ( in_array( $post_type, $arr_types )) $remove_filter = true;
     
    if ( $remove_filter ) {
        remove_filter( 'the_content', 'wpautop' );
        remove_filter( 'the_excerpt', 'wpautop' );
    }
    return $content;
}
*/
