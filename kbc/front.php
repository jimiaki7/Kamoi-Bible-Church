<?php
/*
@package kbc
*******************
	home.php
*******************
*/

/*
    Template Name: Front Page
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit; 
?>
    <?php get_header(); ?>
    <main role="main">
        <!-- section -->
        <section class="section">
            <h2>This is Front Page!</h2>
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


            <!-- News -->
            <div id="news">
                <h2>ニュース＆新着情報</h2>
                <div class="news">
                    <?php 
				    $args = array(
					'post_type' 		=> array( 'post' ),
					'posts_per_page' 	=> 20,
                    'orderby'           => 'date',
                    'order'             => 'DESC'
				    );
				$news = new WP_Query( $args );
				if ( $news->have_posts() ) : /* Sub-Loop */ ?>
                    <ul>
                        <?php while ( $news->have_posts() ) : $news->the_post(); ?>
                        <li>
                            <?php
                            /* 記事を公開してから指定した期間New!を表示する
                            $days = 12; //Newを表示させたい期間の時間
                            $today = date_i18n('U');
                            $entry = get_the_time('U');
                            $kiji = date('U',($today - $entry)) / 86400 ;
                            if( $days > $kiji ){ */
                            
                            /* 期間に関わらず最新数件にNew!を表示する */
                            if ($news->current_post < 3) {
                            
                            echo '<span class="new">New!</span>'; //echo New!
                            } ?>
                                <a href="<?php the_permalink(); ?>">
                                    <span><?php the_time( get_option( 'date_format' )); ?> -</span>&nbsp;
                                    <?php the_title(); ?>
                                </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php else: ?>
                    <p>新着情報はありません。</p>
                    <?php endif; /* サブループ終了 */ ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>

        </section>
        <!-- /section -->

    </main>

    <?php get_footer(); ?>
