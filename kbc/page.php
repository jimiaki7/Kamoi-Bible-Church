<?php
/*
@package kbc
*******************
	page.php
*******************
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
?>

    <?php get_header(); ?>
    <main role="main">
        <!-- section -->
        <section class="section">
            <h2>This is Page.php</h2>
            <!-- loop -->
            <?php if (have_posts()): while (have_posts()) : the_post(); ?>

            <!-- article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <!-- post thumbnail -->
                <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail(); // Declare pixel size you need inside the array ?>
                </a>
                <?php endif; ?>

                <!-- post title -->
                <h3>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>

                <!-- content -->
                <?php the_content() ?>

            </article>

            <?php endwhile; ?>
            <?php endif; ?>

        </section>
        <!-- /section -->

    </main>

    <?php get_footer(); ?>
