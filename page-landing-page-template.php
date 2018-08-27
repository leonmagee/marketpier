<?php
/**
 * Template Name: Landing Page
 *
 * @package MarketPier
 */

get_header(); 

$header_image_url = get_field('header_image');
?>
    <div id="primary" class="content-area landing-page-wrap">
        <main id="main" class="site-main">
            <div class="landing-header-image" style="background-image: url(<?php echo $header_image_url; ?>);">
            </div>
            <div class="page-content-wrap">

				<?php
				while ( have_posts() ) : the_post(); ?>



                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php
                                the_content();
                            ?>
                        </div><!-- .entry-content -->

                        <div class="related-searches">
                           <h2>Related Searches</h2> 

                           <div class="related-searches-flex">

                                <?php 

                                $related_searches = get_field('related_searches');

                                foreach( $related_searches as $search ) { ?>

                                    <a href="/<?php echo $search['url']; ?>"><?php echo $search['title']; ?></a>


                                <?php } ?>

                            </div>
                        </div>

                    </article><!-- #post-<?php the_ID(); ?> -->



				<?php endwhile; // End of the loop.
				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
