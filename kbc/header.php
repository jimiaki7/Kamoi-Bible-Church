<?php
/*
@package kbc
*******************
	header.php
*******************
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
?>

    <!DOCTYPE html>
    <html <?php language_attributes(); ?> >

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="author" content="Kamoi Bible Church">
        <?php $desc = kbc_description(); if ( $desc ): ?>
        <meta name="description" content="<?php echo $desc ?>">
        <?php endif; ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no,address=no,email=no">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
<!-- Generate Body Schemaをパクる！function.php の中にそれ系のコードがあり、そこから構造化マークアップの仕組みが来てる。その他、NAVやGenerate Headerなどもそこにある。コントロール+シフト+Fで検索 -->
    <body <?php body_class(); ?>>
        <div id="container">
            <!-- header -->
            <div class="header" role="banner">
                <div class="logo-container">
                    <div class="logo">
                        <?php if ( function_exists( 'the_custom_logo' ) ) { the_custom_logo(); } ?>
                    </div>

                    <p id="description">
                        <?php bloginfo( 'description' ); ?>
                    </p>
                    <h1 id="title"><a href="<?php echo esc_url(home_url( '/' )); ?>"><span><?php bloginfo( 'name' ); ?></span></a></h1>
                </div>

                <div class="contact-info">
                    <?php
                $checked = get_option( 'contact_display' );
                $phoneNumber = get_option( 'phone_number' );
                $zipCode = get_option( 'zip_code' );
                $address = esc_attr( get_option( 'address' ) );
            if( $checked == 1 ) {
                echo
                '<span class="phone-number">'.$phoneNumber.'</span><br />',
                '<address><span class="zip-code">〒'.$zipCode.'</span>',
                '<span class="address">'.$address.'</span></address>';
                }
                    ?>
                </div>

                <!--   Header Main Navigation    -->
                <?php wp_nav_menu( array( 'theme_location' => 'main' ) ); ?>
            </div>
            <!-- /header -->

            <!-- page -->
            <div id="page" class="site grid-container grid-parent">
                <!-- content -->
                <div id="content" class="site-content">
