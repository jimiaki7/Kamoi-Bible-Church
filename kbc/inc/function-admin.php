<?php

/*
@package kbc
==========================
    ADMIN Theme Option
==========================
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/* ----------------------------------------------------------------------------- */
/* Add Menu Page */
/* ----------------------------------------------------------------------------- */ 

function add_kbc_admin_menu() {
    add_menu_page (
        'KBC', // page title 
        'KBC', // menu title
        'manage_options', // capability
        'kbc_theme_options',  // menu-slug
        'kbc_admin_option',   // function that will render its output
        'dashicons-plus-alt',   // link to the icon that will be displayed in the sidebar
        '110'   // position of the menu option
    );
}
add_action('admin_menu', 'add_kbc_admin_menu');


// display tabs & tab headers
function kbc_admin_option() {
?>
    <?php  
        if( isset( $_GET[ 'tab' ] ) ) {  
            $active_tab = $_GET[ 'tab' ];  
        } else {
            $active_tab = 'tab_1';
        }
        ?>
    <div class="wrap">
        <!--Page Title-->
        <h2>
            <?php bloginfo('title'); echo ' : ', __('Theme Options')?>
        </h2>
        <div class="description">
            <?php echo __('Customize theme options here')?>
        </div>
        <?php settings_errors(); ?>
        <!--Tab Header Nav-->
        <h2 class="nav-tab-wrapper">
            <a href="?page=kbc_theme_options&tab=tab_1" class="nav-tab <?php echo $active_tab == 'tab_1' ? 'nav-tab-active' : ''; ?>">
                <?php echo __('General')?>
            </a>
            <a href="?page=kbc_theme_options&tab=tab_2" class="nav-tab <?php echo $active_tab == 'tab_2' ? 'nav-tab-active' : ''; ?>">
                <?php echo __('Theme Support')?>
            </a>
            <!--<a href="?page=kbc_theme_options&tab=tab_3" class="nav-tab < ?php echo $active_tab == 'tab_three' ? 'nav-tab-active' : ''; ?>">< ?php echo __('Theme Support')?></a>-->
        </h2>

        <form method="post" action="options.php">
            <?php
                if( $active_tab == 'tab_1' ) {  
                    // calling sections and field for tab 1
                    settings_fields( 'kbc-option-group' ); 
                    do_settings_sections( 'kbc_page_address_setting' ); 
                    
                    settings_fields( 'kbc-option-group' );
                    do_settings_sections( 'kbc_page_footer_note_setting' );

                } else if( $active_tab == 'tab_2' )  {
                    // calling sections and field for tab 2
                    settings_fields( 'kbc-theme-support-group' );
                    do_settings_sections( 'kbc_page_theme_support' );
                }
                /* add more tabs below if needed
                else if( $active_tab == 'tab_3' )  {
                    // calling sections and field for tab 3
                    settings_fields( 'kbc-theme-support-group' );
                    do_settings_sections( 'kbc_page_theme_support' );
                }
                */
            ?>
                <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function kbc_theme_settings() {
    // profile setting
    register_setting( 'kbc-option-group', 'phone_number' );
    register_setting( 'kbc-option-group', 'zip_code' );
    register_setting( 'kbc-option-group', 'address' );
    register_setting( 'kbc-option-group', 'contact_display', 'kbc_sanitize_checkbox' );
    
    add_settings_section( 'kbc-address-setting', __('Profile'), 'kbc_theme_setting', 'kbc_page_address_setting' );
    
    add_settings_field( 'phone_number', __('Phone Number'), 'kbc_phone_number', 'kbc_page_address_setting', 'kbc-address-setting' );
    add_settings_field( 'zip_code', __('Zip Code'), 'kbc_zip_code', 'kbc_page_address_setting', 'kbc-address-setting' );
    add_settings_field( 'address', __('Address'), 'kbc_address_line', 'kbc_page_address_setting', 'kbc-address-setting' );
    add_settings_field( 'contact_display', __('Display / Hide'), 'kbc_contact_display', 'kbc_page_address_setting', 'kbc-address-setting' );
    
    // footer note
    register_setting( 'kbc-option-group', 'footer_note' );
    register_setting( 'kbc-option-group', 'footer_note_display', 'kbc_sanitize_checkbox' );
    
    add_settings_section( 'kbc-footer-note-setting', __('Footer Message Setting'), 'kbc_footer_note_setting', 'kbc_page_footer_note_setting' );
    
    add_settings_field( 'footer_note', __('Footer Message'), 'kbc_footer_note', 'kbc_page_footer_note_setting', 'kbc-footer-note-setting' );
    add_settings_field( 'footer_note_display', __('Display / Hide'), 'kbc_footer_note_display', 'kbc_page_footer_note_setting', 'kbc-footer-note-setting' );
    
    // theme support
    register_setting( 'kbc-theme-support-group', 'post_formats' );
    register_setting( 'kbc-theme-support-group', 'custom_header', 'kbc_sanitize_checkbox' );
    register_setting( 'kbc-theme-support-group', 'custom_background', 'kbc_sanitize_checkbox' );
    
    add_settings_section( 'kbc-theme-support', __('Theme Support'), 'kbc_theme_support', 'kbc_page_theme_support' );
    
    add_settings_field( 'post-formats', __('Post Formats'), 'kbc_post_formats', 'kbc_page_theme_support', 'kbc-theme-support' );
    add_settings_field( 'custom-header', __('Custom Header'), 'kbc_custom_header', 'kbc_page_theme_support', 'kbc-theme-support' );
    add_settings_field( 'custom-background', __('Custom Background'), 'kbc_custom_background', 'kbc_page_theme_support', 'kbc-theme-support' );   
}
add_action( 'admin_init', 'kbc_theme_settings' );

// setting field callbacks
// profile setting
function kbc_theme_setting() {
    // サイト内に表示する住所や電話番号を設定する
    echo __('Set phone number and address information to display in a website'); 
}

function kbc_phone_number() {
    $phoneNumber = esc_attr( get_option( 'phone_number' ) );
    echo '<input type="text" name="phone_number" value="'.$phoneNumber.'" placeholder="例 : (000)-000-0000" />';
}

function kbc_zip_code() {
    $zipCode = esc_attr( get_option( 'zip_code' ) );
    echo '〒<input type="text" name="zip_code" value="'.$zipCode.'" placeholder="例 : 000-0000" />'; 
}

function kbc_address_line() {
    $address = esc_attr( get_option( 'address' ) );
    echo '<input type="text" name="address" size="50" value="'.$address.'" placeholder="例 : ◯◯県◯◯市◯◯区◯◯ 0-0-0" />';
}

function kbc_contact_display() {
    $options = get_option( 'contact_display' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    $label = __('Display profile information'); // 設定したプロフィール情報を表示する
    echo '<label><input type="checkbox" id="contact_display" name="contact_display" value="1" '.$checked.' />'.$label.'</label>';
}

// footer note setting
function kbc_footer_note_setting() {
    // フッター部分に表示するメッセージを設定する
    echo __('Set footer message to display in footer');
}

function kbc_footer_note() {
    $footerNote = esc_attr( get_option( 'footer_note' ) );
    echo '<textarea name="footer_note" cols="70" rows="5" />'.$footerNote.'</textarea>';
}

function kbc_footer_note_display() {
    $options = get_option( 'footer_note_display' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    $label = __('Display footer message'); // 設定したフッターメッセージを表示する
    echo '<label><input type="checkbox" id="footer_note_display" name="footer_note_display" value="1" '.$checked.' />'.$label.'</label>';
}

// theme support
function kbc_theme_support() {
    echo __('Activate Theme Support');
}

function kbc_post_formats() {
    $options = get_option( 'post_formats' );
    $formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
    $output = '';
    foreach ( $formats as $format ) {
        $checked = ( @$options[$format] == 1 ? 'checked' : '' );
        $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' />'.$format.'</label><br /><br /> ';
    }
    echo $output;
}

function kbc_custom_header() {
    $options = get_option( 'custom_header' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    $label = __('Activate Custom Header'); // カスタムヘッダーを有効にする
    echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' />'.$label.'</label>';
}

function kbc_custom_background() {
    $options = get_option( 'custom_background' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    $label = __('Activate Custom Background'); // カスタム背景を有効にする
    echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' />'.$label.'</label>';
}


function kbc_sanitize_checkbox( $input ) {
  if ( $input == true ) { return true; } else { return false; }
}






//カスタマイザーのデフォルト設定
if ( ! function_exists( 'generate_get_defaults' ) ) :
/**
 * Set default options
 */
function generate_get_defaults()
{	
	$generate_defaults = array(
		'hide_title' => '',
		'hide_tagline' => '',
		'logo' => '',
		'top_bar_width' => 'full',
		'top_bar_inner_width' => 'contained',
		'top_bar_alignment' => 'right',
		'container_width' => '1100',
		'header_layout_setting' => 'fluid-header',
		'header_inner_width' => 'contained',
		'nav_alignment_setting' => ( is_rtl() ) ? 'right' : 'left',
		'header_alignment_setting' => ( is_rtl() ) ? 'right' : 'left',
		'nav_layout_setting' => 'fluid-nav',
		'nav_inner_width' => 'contained',
		'nav_position_setting' => 'nav-below-header',
		'nav_dropdown_type' => 'hover',
		'nav_search' => 'disable',
		'content_layout_setting' => 'separate-containers',
		'layout_setting' => 'right-sidebar',
		'blog_layout_setting' => 'right-sidebar',
		'single_layout_setting' => 'right-sidebar',
		'post_content' => 'full',
		'footer_layout_setting' => 'fluid-footer',
		'footer_inner_width' => 'contained',
		'footer_widget_setting' => '3',
		'footer_bar_alignment' => 'right',
		'back_to_top' => '',
		'background_color' => '#efefef',
		'text_color' => '#3a3a3a',
		'link_color' => '#1e73be',
		'link_color_hover' => '#000000',
		'link_color_visited' => '',
	);
	
	return apply_filters( 'generate_option_defaults', $generate_defaults );
}
endif;