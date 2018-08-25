<?php
/**
 * Template Name: Contact Us
 *
 * @package MarketPier
 */

get_header(); 

$header_image_url = get_field('header_image');
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="contact-us-header-image" style="background-image: url(<?php echo $header_image_url; ?>);">
                <div class="entry-header">
                    <?php the_title( '<h1 class="contact-us-title">', '</h1>' ); ?>
                </div><!-- .entry-header -->
            </div>
            <div class="page-content-wrap">

				<?php
				while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


                        <div class="entry-content">
                            <?php
                                the_content();
                            ?>
                        </div><!-- .entry-content -->

                    </article><!-- #post-<?php the_ID(); ?> -->



				<?php endwhile; // End of the loop.
				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
