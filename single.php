<?php
/**
 * The template for displaying all pages
 *
 * @package MarketPier
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="page-content-wrap">
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content' );
				endwhile; // End of the loop. ?>
				<div class="post-nav-wrap">
					<?php the_post_navigation(); ?>
			</div>
						<?php // If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer();