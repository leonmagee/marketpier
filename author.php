<?php
/**
 * Template to display single Agent
 */

get_header();

/**
 *  global variable $author = author ID
 *
 *  $author_data = object
 *
 *  $author_name = get_user_by('slug', $author_name);
 *
 *  Get Author/Agent Data
 */
$author_info = get_user_by( 'slug', get_query_var( 'author_name' ) );
$author_id   = $author_info->ID;
$author_data = get_userdata( intval( $author_id ) );
$first_name  = get_user_meta( $author_id, 'first_name', true );
$last_name   = get_user_meta( $author_id, 'last_name', true );
if ( $first_name && $last_name ) {
	$name = $first_name . ' ' . $last_name;
} elseif ( $first_name ) {
	$name = $first_name;
} else {
	$name = $author_data->data->display_name;
}
$email = $author_data->data->user_email;

/**
 *  User Meta
 */
$agent_meta = get_user_meta( $author_id );
$agent_bio  = $agent_meta['description'][0];
$agent_bio  = shorten_string( $agent_bio, 500 );

/**
 *  ACF Custom Fields
 */
$phone_number    = get_field( 'phone_number', 'user_' . $author_id );
$company         = get_field( 'company', 'user_' . $author_id );
$company_logo    = get_field( 'company_logo', 'user_' . $author_id );
$headshot_field  = get_field( 'headshot', 'user_' . $author_id );
$headshot        = $headshot_field['sizes']['agent-headshot'];
$facebook        = get_field( 'facebook_url', 'user_' . $author_id );
$facebook_url    = mp_parse_url( $facebook );
$linkedin        = get_field( 'linkedin_url', 'user_' . $author_id );
$linkedin_url    = mp_parse_url( $linkedin );
$twitter         = get_field( 'twitter_url', 'user_' . $author_id );
$twitter_url     = mp_parse_url( $twitter );
$google_plus     = get_field( 'google_plus_url', 'user_' . $author_id );
$google_plus_url = mp_parse_url( $google_plus );
$youtube         = get_field( 'youtube_url', 'user_' . $author_id );
$youtube_url     = mp_parse_url( $youtube );
$instagram       = get_field( 'instagram_url', 'user_' . $author_id );
$instagram_url   = mp_parse_url( $instagram );
$pinterest       = get_field( 'pinterest_url', 'user_' . $author_id );
$pinterest_url   = mp_parse_url( $pinterest );
$testimonials    = get_field( 'testimonials', 'user_' . $author_id );

?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap agent-profile-flex">
                <div class="agent-info-wrap agent-head">
                    <div class="agent-headshot-wrap">
						<?php
						/**
						 *  Headshot or default image
						 */
						if ( $headshot ) { ?>
                            <img src="<?php echo $headshot; ?>"/>
						<?php } else {
							$default_image_url = ''; ?>
                            <img src="<?php echo $default_image_url; ?>"/>
						<?php } ?>
                    </div>
                    <div class="agent-info-wrap-inner">
                        <div class="agent-name">
                            <h3><?php echo $name; ?></h3>
                        </div>
                        <div class="agent-user-info">

                            <div class="agent-company"><?php echo $company; ?></div>

							<?php if ( $company_logo ) { ?>
                                <div class="company-logo">
                                    <img src="<?php echo $company_logo; ?>"/>
                                </div>
							<?php } ?>

                            <div class="agent-phone"><?php echo $phone_number; ?></div>

                            <div class="agent-email">
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                            </div>

                            <div class="contact-me-wrap">
                                <a data-open="agent-form-modal" class="mp-button">Contact Me</a>
                            </div>

							<?php

							$form_modal = new mp_output_modal_shortcode(
								'[caldera_form id="CF5994d75066284"]',
								'agent-form-modal',
								'Contact Agent'
							);
							$form_modal->output_modal(); ?>
                        </div>
                        <div class="agent-social-media">
							<?php
							if ( $facebook ) { ?>
                                <a href="<?php echo $facebook_url; ?>" target="_blank">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
							<?php }
							if ( $linkedin ) { ?>
                                <a href="<?php echo $linkedin_url; ?>" target="_blank">
                                    <i class="fa fa-linkedin-square"></i>
                                </a>
							<?php }
							if ( $twitter ) { ?>
                                <a href="<?php echo $twitter_url; ?>" target="_blank">
                                    <i class="fa fa-twitter-square"></i>
                                </a>
							<?php }
							if ( $google_plus ) { ?>
                                <a href="<?php echo $google_plus_url; ?>" target="_blank">
                                    <i class="fa fa-google-plus-square"></i>
                                </a>
							<?php }
							if ( $youtube ) { ?>
                                <a href="<?php echo $youtube_url; ?>" target="_blank">
                                    <i class="fa fa-youtube-square"></i>
                                </a>
							<?php }
							if ( $instagram ) { ?>
                                <a href="<?php echo $instagram_url; ?>" target="_blank">
                                    <i class="fa fa-instagram"></i>
                                </a>
							<?php }
							if ( $pinterest ) { ?>
                                <a href="<?php echo $pinterest_url; ?>" target="_blank">
                                    <i class="fa fa-pinterest-square"></i>
                                </a>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <div class="testimonials-bio-section">
					<?php if ( $agent_bio ) { ?>
                        <div class="agent-info-wrap bio">
                            <h4><?php echo 'About ' . $name; ?></h4>
                            <div class="agent-bio"><?php echo $agent_bio; ?></div>
                        </div>
					<?php }

					/**
					 * Template Name: Search Listings
					 *
					 * @package MarketPier
					 */
					require_once( 'inc/snippet_data.php' );
					require_once( 'inc/snippet_data_search.php' );
					require_once( 'inc/form-process-submit.php' );
					$snippets_query = new snippet_data_search( $author_id, true );
					$snippets       = $snippets_query->snippet_object_array;

					?>
                    <div class="search-listings-wrap">

                        <div class="search-listings-half">
							<?php
							if ( $snippets ) {

								foreach ( $snippets as $snippet ) {
									if ( $snippet->combined_address ) {
										$address = $snippet->combined_address;
									} elseif ( $snippet->city_state_zip ) {

										$address = $snippet->city_state_zip;
									} else {
										$address = '';
									} ?>
                                    <div class="snippet-outer-outer-wrap">
                                        <div class="contact-wrap">
                                            <a href="" class="contact-link"><i class="fa fa-heart"
                                                                               aria-hidden="true"></i> Save</a>
                                            <a href="" class="contact-link"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i>
                                                Contact</a>
                                        </div>
                                        <a class="snippet-link-outer" href="<?php echo $snippet->listing_url; ?>">
                                            <div class="snippet-outer-wrap">
                                                <div class="image-wrap">
                                                    <div class="image-overlay">
                                                        <div class="image-overlay-text">
															<?php if ( $title = $snippet->property_name ) { ?>
                                                                <h3><?php echo $title; ?></h3>
															<?php } ?>
															<?php if ( $address ) { ?>
                                                                <h5><?php echo $address; ?></h5>
															<?php } ?>
                                                        </div>
                                                    </div>
                                                    <img src="<?php echo $snippet->image_gallery_first; ?>"/>
                                                </div>
                                                <div class="right-side-outer">
                                                    <div class="top-line">
														<?php echo $snippet->type; ?>
                                                    </div>
                                                    <div class="details-wrap">
														<?php if ( $price = $snippet->price ) { ?>
                                                            <div class="details-item-wrap">
                                                                <div class="details-item price-item">
                                                                    $<?php echo number_format( $price ); ?>
                                                                </div>
                                                                <label>Price</label>
                                                            </div>
														<?php } ?>
														<?php if ( $units = $snippet->number_of_units ) { ?>
                                                            <sep>|</sep>
                                                            <div class="details-item-wrap">
                                                                <div class="details-item units-item"><?php echo $units; ?></div>
                                                                <label>Units</label>
                                                            </div>
														<?php } ?>
														<?php if ( $building_size = $snippet->building_size ) { ?>
                                                            <sep>|</sep>
                                                            <div class="details-item-wrap">
                                                                <div class="details-item sqft-item"><?php echo number_format( $building_size ); ?></div>
                                                                <label>Bldg SF</label>
                                                            </div>
														<?php } ?>
														<?php if ( $cap_rate = $snippet->cap_rate ) { ?>
                                                            <sep>|</sep>
                                                            <div class="details-item-wrap">
                                                                <div class="details-item cap-rate-item"><?php echo $cap_rate; ?></div>
                                                                <label>Cap Rate</label>
                                                            </div>
														<?php } ?>
														<?php if ( $lot_size = $snippet->lot_size ) { ?>
                                                            <sep>|</sep>
                                                            <div class="details-item-wrap">
                                                                <div class="details-item lot-size-item"><?php echo number_format( $lot_size ); ?></div>
                                                                <label>Lot SF</label>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                    <div class="bottom-line">
														<?php if ( $days = $snippet->days_on_market ) {
															echo $days . 'd';
														} ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
								<?php }
							} else { ?>
                                <div class="callout warning">
                                    This agent has no listings yet.
                                </div>
							<?php } ?>
                        </div>
                    </div><!-- #primary -->

					<?php if ( $testimonials ) { ?>
                        <div class="agent-info-wrap testimonials">
                            <h4>Testimonials</h4>
                            <div class="testimonial-wrap">
								<?php foreach ( $testimonials as $testimonial ) { ?>
                                    <div class="testimonial-wrap-inner">
                                        <div class="text">
											<?php echo $testimonial['testimonial']; ?>
                                        </div>
                                        <div class="author">
											<?php echo $testimonial['testimonial_author']; ?>
                                            <span>
                                                - <?php echo $testimonial['date']; ?>
                                            </span>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();
