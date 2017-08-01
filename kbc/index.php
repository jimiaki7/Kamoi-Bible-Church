<?php
/*
@package kbc
*******************
	index.php
*******************
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit; 
?>

    <?php get_header(); ?>
    <main role="main">
        <!-- section -->
        <section class="section">
            <h2>This is index.php!!</h2>

            <?php $loop = new WP_Query( 'page_id='.$post->ID ); ?>
            <?php if (have_posts()) : while ( $loop->have_posts() ) : $loop->the_post(); /* サブループ開始 */ ?>
            <article class="page-post">
                <h2>
                    <?php the_title(); ?>
                </h2>

                <?php the_content(); ?>
            </article>
            <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>



            <!-- Main Loop -->
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

                <!-- post meta -->
                <time class="date"><?php the_time('Y年Fd日 l'); ?><?php the_time('H:i'); ?></time>
                <!-- category -->
                <ul>
                    <?php
                    $categories = get_the_category();
                    $separator = ' ';
                    $output = '';
                    if ( $categories ) {
                    foreach( $categories as $category ) {
                    $output .= '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">' . $category->cat_name . '</a></li>' . $separator;	
                    }
                    echo trim( $output, $separator );
                    } ?>
                </ul>

                <!-- content -->
                <?php the_content(); ?>
            </article>
            <hr>
            <?php endwhile; ?>
            <?php else : ?>

            <!-- article not found -->
            <article>
                <p>
                    <?php _e( 'Sorry, nothing to display.', 'kbc' ); ?>
                </p>
            </article>
            <hr>

            <?php endif; ?>

            <?php get_template_part('pagination'); ?>

        </section>
        <!-- /section -->

        <!-- sidebar -->
        <?php get_sidebar(); ?>

    </main>

    <?php get_footer(); ?>
