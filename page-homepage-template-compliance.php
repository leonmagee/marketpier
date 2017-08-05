<?php
/**
 * Template Name: Homepage Compliance
 *
 * @package MarketPier
 */

require_once( 'inc/form-process-submit.php' );

get_header();

if ( $background = get_field( 'homepage_background_image', 'option' ) ) {
	$bg_style = "style='background-image: url(" . $background . ")'";
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

        <div class="homepage-section homepage-section-cta">

            <div class="homepage-cta-boxes-outer">
				<?php
				$homepage_cta_boxes = get_field( 'homepage_cta_boxes', 'option' );
				if ( $homepage_cta_boxes ) { ?>
                    <div class="homepage-cta-boxes-wrap">
						<?php foreach ( $homepage_cta_boxes as $cta_box ) { ?>
                            <div class="homepage-cta-boxes-inner">
                                <div class="cta-inside">
                                    <div class="title-wrap">
                                        <img src="<?php echo $cta_box['icon']; ?>"/>
                                        <h3>
                                            <a href="<?php echo site_url() . '/' . $cta_box['url']; ?>">
												<?php echo $cta_box['title']; ?>
                                            </a>
                                        </h3>
                                    </div>
                                    <p><?php echo $cta_box['excerpt']; ?></p>
                                    <a class='cta-link'
                                       href="<?php echo site_url() . '/' . $cta_box['url']; ?>"><?php echo $cta_box['link_text']; ?></a>
                                </div>
                            </div>
						<?php } ?>
                    </div>
				<?php } ?>
            </div>

        </div>

    </div>


<?php
get_footer();
