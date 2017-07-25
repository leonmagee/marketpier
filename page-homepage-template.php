<?php
/**
 * Template Name: Homepage
 *
 * @package MarketPier
 */

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


        <div class="homepage-section homepage-section-1">

			<?php if ( $section_tagline_1 = get_field( 'section_tagline_1', 'option' ) ) { ?>
                <h2 class="section-title"><?php echo $section_tagline_1; ?></h2>
			<?php } ?>
        </div>

        <div class="homepage-section homepage-section-2">

            <div class="homepage-cta-boxes-outer">
				<?php
				$homepage_cta_boxes = get_field( 'homepage_cta_boxes', 'option' );
				if ( $homepage_cta_boxes ) { ?>
                    <div class="homepage-cta-boxes-wrap">
						<?php foreach ( $homepage_cta_boxes as $cta_box ) { ?>
                            <div class="homepage-cta-boxes-inner">
                                <div class="cta-inside">
                                    <div class="title-wrap">
                                        <img src="<?php echo $cta_box['icon']; ?>" />
                                        <h3><?php echo $cta_box['title']; ?></h3>
                                    </div>
                                    <p><?php echo $cta_box['excerpt']; ?></p>
                                </div>
                            </div>
						<?php } ?>
                    </div>
				<?php } ?>
            </div>

        </div>


        <div class="homepage-section homepage-section-3">

            <div class="homepage-cta-boxes-outer">
			    <?php
			    $homepage_cta_boxes = get_field( 'homepage_cta_boxes', 'option' );
			    if ( $homepage_cta_boxes ) { ?>
                    <div class="homepage-cta-boxes-wrap">
					    <?php foreach ( $homepage_cta_boxes as $cta_box ) { ?>
                            <div class="homepage-cta-boxes-inner"
                                 style="background-image: url(<?php echo $cta_box['image']; ?>)">
                                <div class="cta-inside">
                                    <h3><?php echo $cta_box['title']; ?></h3>
                                    <p><?php echo $cta_box['excerpt']; ?></p>
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
