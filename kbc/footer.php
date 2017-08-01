<?php
/*
@package kbc
*******************
	footer.php
*******************
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit; 
?>

    </div>
    <!-- #content -->
    </div>
    <!-- #page -->

    <!-- footer -->
    <footer class="footer" role="contentinfo">

        <!-- Other stuff inside footer -->


        <!-- Footer Widget -->


        <!-- Footer Menu -->

        <?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>


        <!-- #footer note -->
        <?php
$checked = get_option( 'footer_note_display' );
$footerNote = get_option( 'footer_note' );
if( $checked == 1 ) {
    print '<span id="footer-note">'.$footerNote.'</span><br />';
} ?>
            <!-- #footer note -->

            <!-- #copyright -->
            <span id="copyright">
    Copyright &copy;
    <?php echo date('Y'); ?>
    <a href="<?php echo home_url(); ?>">
    <?php bloginfo('name'); ?>
    </a>
    all rights reserved
        </span>
            <!-- #copyright -->

    </footer>
    <!-- /footer -->

    </div>
    <!-- #container -->

    <?php wp_footer(); ?>
    </body>
    <!-- /body -->

    </html>
