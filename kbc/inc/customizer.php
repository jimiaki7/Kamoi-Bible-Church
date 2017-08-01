<?php 
/*
@package kbc
=====================
    THEME SUPPORT
=====================
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! function_exists( 'generate_customize_register' ) ) :
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( 'customize_register', 'generate_customize_register' );
function generate_customize_register( $wp_customize ) {
	// Get our default values
	$defaults = generate_get_defaults();

	// Load custom controls
	require_once get_template_directory() . '/inc/controls.php';
	require_once get_template_directory() . '/inc/sanitize.php';
	
	if ( $wp_customize->get_control( 'blogdescription' ) ) {
		$wp_customize->get_control('blogdescription')->priority = 3;
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}
	
	if ( $wp_customize->get_control( 'blogname' ) ) {
		$wp_customize->get_control('blogname')->priority = 1;
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	}
	
	// Add control types so controls can be built using JS
	if ( method_exists( $wp_customize, 'register_control_type' ) ) {
		$wp_customize->register_control_type( 'Generate_Customize_Misc_Control' );
		$wp_customize->register_control_type( 'Generate_Customize_Width_Slider_Control' );
	}
    
    
    // Add selective refresh to site title and description
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.main-title a',
			'render_callback' => 'generate_customize_partial_blogname',
		) );
		
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'render_callback' => 'generate_customize_partial_blogdescription',
		) );
	}
    
    
    // Remove title
	$wp_customize->add_setting( 
		'generate_settings[hide_title]', 
		array(
			'default' => $defaults['hide_title'],
			'type' => 'option',
			'sanitize_callback' => 'generate_sanitize_checkbox'
		)
	);
	
	$wp_customize->add_control(
		'generate_settings[hide_title]',
		array(
			'type' => 'checkbox',
			'label' => __('Hide site title','generatepress'),
			'section' => 'title_tagline',
			'priority' => 2
		)
	);
	
	// Remove tagline
	$wp_customize->add_setting( 
		'generate_settings[hide_tagline]', 
		array(
			'default' => $defaults['hide_tagline'],
			'type' => 'option',
			'sanitize_callback' => 'generate_sanitize_checkbox'
		)
	);
	
	$wp_customize->add_control(
		'generate_settings[hide_tagline]',
		array(
			'type' => 'checkbox',
			'label' => __('Hide site tagline','generatepress'),
			'section' => 'title_tagline',
			'priority' => 4
		)
	);
	
	// Only show this option if we're not using WordPress 4.5
	if ( ! function_exists( 'the_custom_logo' ) ) {
		$wp_customize->add_setting( 
			'generate_settings[logo]', 
			array(
				'default' => $defaults['logo'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
	 
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'generate_settings[logo]',
				array(
					'label' => __('Logo','generatepress'),
					'section' => 'title_tagline',
					'settings' => 'generate_settings[logo]'
				)
			)
		);
    }
    
    
    //カラーパネル
    if ( $wp_customize->get_panel( 'generate_colors_panel' ) ) {		
		$wp_customize->add_section(
			'body_section',
			array(
				'title' => __( 'Body', 'generatepress' ),
				'capability' => 'edit_theme_options',
				'priority' => 30,
				'panel' => 'generate_colors_panel'
			)
		); 
	} else {
		$wp_customize->add_section(
			'body_section',
			array(
				'title' => __( 'Colors', 'generatepress' ),
				'capability' => 'edit_theme_options',
				'priority' => 30,
			)
		); 
	}
	
	// Add color settings
	$body_colors = array();
	$body_colors[] = array(
		'slug'=>'background_color', 
		'default' => $defaults['background_color'],
		'label' => __('Background Color', 'generatepress'),
		'transport' => 'postMessage'
	);
	$body_colors[] = array(
		'slug'=>'text_color', 
		'default' => $defaults['text_color'],
		'label' => __('Text Color', 'generatepress'),
		'transport' => 'postMessage'
	);
	$body_colors[] = array(
		'slug'=>'link_color', 
		'default' => $defaults['link_color'],
		'label' => __('Link Color', 'generatepress'),
		'transport' => 'postMessage'
	);
	$body_colors[] = array(
		'slug'=>'link_color_hover', 
		'default' => $defaults['link_color_hover'],
		'label' => __('Link Color Hover', 'generatepress'),
		'transport' => 'postMessage'
	);
	$body_colors[] = array(
		'slug'=>'link_color_visited', 
		'default' => $defaults['link_color_visited'],
		'label' => __('Link Color Visited', 'generatepress'),
		'transport' => 'refresh'
	);

	foreach( $body_colors as $color ) {
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_sanitize_hex_color',
				'transport' => $color['transport']
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'body_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']'
				)
			)
		);
	}


    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    

}
endif;


