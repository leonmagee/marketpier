<?php
/**
 *  Edit profile for agent
 *  new agents who register will be redirected here automatically
 *
 *  Get Agent/User ID
 */
$user = wp_get_current_user();

$agent_id = $user->ID;

$username = $user->user_login;



/**
 *  Create Input Objects
 */
$input_fields = agent_update::output_input_array( $agent_id );

?>

<div class="registration-form-wrapper">

    <div class="row">

        <main class="page-content">

            <div class="section-title-wrap">

                <h3>Profile Settings for <span><?php echo $username; ?></span></h3>

            </div>

            <div class="agent-profile-links">

                <a href="<?php echo site_url(); ?>/agent-home">Agent Home</a> /
                <a href="<?php echo site_url(); ?>/agent/<?php echo $username; ?>">Your Profile</a> /
                <a href="<?php echo site_url(); ?>/new-listing">Create New Listing</a> /
                <a href="<?php echo site_url(); ?>">Skyrises Home</a> /
                <a href="<?php echo wp_logout_url( site_url() ); ?>">Log Out</a>
            </div>

			<?php while ( have_posts() ) : the_post();

				the_content();

			endwhile; ?>

        </main>

    </div>

    <div class="row agent-profile-top-buttons">

        <div class="medium-4 columns left">

            <a data-reveal-id="profile-picture-modal" class="button secondary short">Update Profile Picture</a>

        </div>

        <div class="medium-4 columns left">

            <a data-reveal-id="background-img-modal" class="button secondary short">Update Background Image</a>

        </div>

        <div class="medium-4 columns left">

            <a data-reveal-id="testimonials-modal" class="button secondary short">Add Testimonials</a>

        </div>

		<?php
		/**
		 *  Button Modals
		 */

		$profile_picture = new skyrises_output_modal_acf(
			'headshot',
			'profile-picture-modal',
			'Profile Picture',
			$agent_id );

		$profile_picture->output_modal();

		$background_image = new skyrises_output_modal_acf(
			'large_background_image',
			'background-img-modal',
			'Background Image',
			$agent_id );

		$background_image->output_modal();

		$testimonials = new skyrises_output_modal_acf(
			'testimonials',
			'testimonials-modal',
			'Testimonials',
			$agent_id );

		$testimonials->output_modal();


		?>

    </div>

    <div class="row">

        <div class="skyrises-success">

            Your profile has been successfully updated.

        </div>

    </div>


    <div class="row">

        <form method="post" name="registration-form">

            <div class="registration-form-inner" id="agent-update-form">

                <input type="hidden" name="agent-id" class="agent-id" value="<?php echo $agent_id; ?>"/>

				<?php foreach ( $input_fields as $input ) {

					$input->get_value();

					if ( $input->input_type == 'input' ) {

						//$input->get_placeholder();
						// not currently using placeholder
						?>

                        <div class="medium-3 columns left">

                            <!-- regular user detail -->
                            <label><?php echo $input->label; ?></label>

                            <input
                                    class="<?php echo $input->name; ?>"
                                    name="<?php echo $input->name; ?>"
                                    value="<?php echo $input->value; ?>"/>
                            <!-- placeholder="<?php //echo $input->placeholder; ?>"-->
                        </div>

					<?php } elseif ( $input->input_type == 'textarea' ) { ?>

                        <div class="medium-12 columns left">

                            <!-- regular user detail -->
                            <label><?php echo $input->label; ?></label>

                            <textarea class="<?php echo $input->name; ?>"
                                      name="<?php echo $input->name; ?>"><?php echo $input->value; ?></textarea>
                        </div>

					<?php } ?>

				<?php } ?>

                <div class="medium-3">

                    <div class="agent-update-submit-wrap">

                        <a type="submit" class="button gold" id="agent-update-submit">Update</a>

                    </div>

                </div>

        </form>

		<?php


		/**
		 *  This ACF Form can be used just for adding new Testimonials.
		 */
		//		acf_form( array(
		//				'post_id' => 'user_' . $agent_id,
		//				'fields'  => array(
		//						'phone_number',
		//						'agency',
		//						'headshot',
		//						'facebook_url',
		//						'twitter_url',
		//						'google_plus_url',
		//						'linkedin_url',
		//						'youtube_url',
		//						'instagram_url',
		//						'pinterest_url',
		//						'testimonials'
		//				),
		//		) );

		?>


    </div>

</div>