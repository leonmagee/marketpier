<?php
/**
 * Template Name: Homepage
 *
 * @package MarketPier
 */

get_header();

//$bg_string = "style='background-image: url(" . $area_3_bg . ")'";

if ( $background = get_field( 'homepage_background_image', 'option' ) ) {
	$bg_style = "style='background-image: url(" . $background . ")'";
	//var_dump( $bg_style );
} else {
	$bg_style = '';
}

?>

    <div class="homepage-wrap-outer">
        <div class="homepage-slider" <?php echo $bg_style; ?>>
            <div class="homepage-slider-overlay">
                <div class="homepage-slider-inner">
                    <div class="slider-items">
						<?php if ( $main_tagline = get_field( 'main_tagline', 'option' ) ) { ?>
                            <h1><?php echo $main_tagline; ?></h1>
						<?php }
						get_template_part( 'template-parts/homepage-form' ); ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
