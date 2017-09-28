<?php
/**
 * Template Name: Add New Listing Choice
 *
 * @package MarketPier
 */

logged_in_check_redirect();
acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header();

$standard_text     = get_field( 'standard_text', 'option' );
$premium_text      = get_field( 'premium_text', 'option' );
$standard_features = get_field( 'standard_features', 'option' );
$premium_features  = get_field( 'premium_features', 'option' );
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Choose Listing Type</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

                        <div class="two-buttons"><!-- @todo make different class? -->
                            <div class="listing-choice standard">
                                <a href="<?php echo site_url(); ?>/listing-creation-complete">
                                    <div class="choice-header">Standard Listing</div>
                                    <div class="details">
                                        <h3><?php echo $standard_text; ?></h3>
                                        <ul>
                                            <?php foreach( $standard_features as $feature ) { ?>
                                               <li><i class="fa fa-check" aria-hidden="true"></i><?php echo $feature['feature']; ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                            <div class="listing-choice premium">
                                <a href="<?php echo site_url(); ?>/checkout/?level=1">
                                    <div class="choice-header">Premium Listing</div>
                                    <div class="details">
                                        <h3><?php echo $premium_text; ?></h3>
                                        <ul>
			                                <?php foreach( $premium_features as $feature ) { ?>
                                                <li><i class="fa fa-check" aria-hidden="true"></i><span><?php echo $feature['feature']; ?></span></li>
			                                <?php } ?>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();

