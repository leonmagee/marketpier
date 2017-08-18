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

$author = 1;

$author_data = get_userdata( intval( $author ) );

//var_dump( $author_data );

$first_name = get_user_meta( $author, 'first_name', true );
$last_name  = get_user_meta( $author, 'last_name', true );

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
$agent_meta = get_user_meta( $author );

$agent_bio = $agent_meta['description'][0];

$agent_bio = shorten_string( $agent_bio, 500 );

/**
 *  ACF Custom Fields
 */
$phone_number = get_field( 'phone_number', 'user_' . $author );

$agency = get_field( 'agency', 'user_' . $author );

$headshot_field = get_field( 'headshot', 'user_' . $author );
$headshot       = $headshot_field['sizes']['agent-headshot'];

$facebook        = get_field( 'facebook_url', 'user_' . $author );
$facebook_url    = mp_parse_url( $facebook );
$linkedin        = get_field( 'linkedin_url', 'user_' . $author );
$linkedin_url    = mp_parse_url( $linkedin );
$twitter         = get_field( 'twitter_url', 'user_' . $author );
$twitter_url     = mp_parse_url( $twitter );
$google_plus     = get_field( 'google_plus_url', 'user_' . $author );
$google_plus_url = mp_parse_url( $google_plus );
$youtube         = get_field( 'youtube_url', 'user_' . $author );
$youtube_url     = mp_parse_url( $youtube );
$instagram       = get_field( 'instagram_url', 'user_' . $author );
$instagram_url   = mp_parse_url( $instagram );
$pinterest       = get_field( 'pinterest_url', 'user_' . $author );
$pinterest_url   = mp_parse_url( $pinterest );

$testimonials = get_field( 'testimonials', 'user_' . $author );

?>


    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap agent-profile-flex">


                <div class="agent-info-wrap">
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

                            <div class="agent-agency"><?php echo $agency; ?></div>

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
							$form_modal->output_modal();

							?>


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
					if ( $testimonials ) { ?>

                        <div class="agent-info-wrap testimonials">

                            <h4>Testimonials</h4>

							<?php

							if ( count( $testimonials ) == 1 ) { ?>

                                <div class="testimonial-text">

									<?php echo '<i class="fa fa-quote-left"></i>' . shorten_string( $testimonials[0]['testimonial'], 250 ) . '<i class="fa fa-quote-right"></i>'; ?>
                                </div>

                                <div class="testimonial-author">

									<?php
									echo $testimonials[0]['testimonial_author'] . '<br />';
									echo '<span>' . $testimonials[0]['date'] . '</span>';

									?>

                                </div>

							<?php } elseif ( count( $testimonials ) > 1 ) {

								//use unslider for this?
								?>

                                <div class="testimonial-carousel-wrap">

                                    <div class="testimonial-carousel-inner">

                                        <ul>

											<?php


											foreach ( $testimonials as $testimonial ) { ?>

                                                <li>

                                                    <div class="testimonial-text">
														<?php echo '<i class="fa fa-quote-left"></i>' . shorten_string( $testimonial['testimonial'], 250 ) . '<i class="fa fa-quote-right"></i>'; ?>
                                                    </div>

                                                    <div class="testimonial-author">

														<?php
														echo $testimonial['testimonial_author'] .
														     '<br />';
														echo '<span>' . $testimonial['date'] . '</span>';

														?>

                                                    </div>

                                                </li>

											<?php } ?>

                                    </div>
                                </div>

							<?php } ?>

                        </div>

					<?php } ?>

                </div>

            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();





