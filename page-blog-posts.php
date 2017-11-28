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
                    <h1 class="entry-title blog-header">MarketPier Blog</h1>
                </header>

                <div class="blog-wrap-outer">
                <div class="blog-wrap">
                    <?php 
                    $args = array('post_type' => 'post');
                    $wp_blog_query = new WP_Query($args); 
                    while ( $wp_blog_query->have_posts() ) {
                        $wp_blog_query->the_post(); ?>
                        <div class="blog-post-wrap">
                            <?php if (has_post_thumbnail() ) { ?>
                            <div class="blog-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('listing-gallery'); ?>
                                </a>
                            </div>
                            <?php } ?>
                            <div class="blog-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="blog-post-excerpt">
                                <?php the_excerpt(); ?>
                                <a class="blog-read-more" href="<?php the_permalink(); ?>">Read More</a>
                            </div>
                        </div>
                        </div>
                    <?php } ?> 
                </div>
                <div class="blog-sidebar">
		<?php echo do_shortcode('[caldera_form id="CF5a1dd37b48484"]'); ?>
                        </div>
                            </div>
            </div>
        </main>
    </div>
<?php get_footer();
