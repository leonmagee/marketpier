<?php
/**
 * Template Name: Blog Archive Template 
 *
 * @package MarketPier
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Blog</h1>
                </header>

            <div class="blog-wrap">
                <?php 
                $args = array('post_type' => 'post');
                $wp_blog_query = new WP_Query($args); 
                while ( $wp_blog_query->have_posts() ) {
                    $wp_blog_query->the_post(); ?>
                    <div class="blog-post-wrap">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="blog-post-excerpt"><?php the_excerpt(); ?></div>
                    </div>
                <?php }
                
                ?> 
            </div>


            </div>
        </main>
    </div>
<?php get_footer();
