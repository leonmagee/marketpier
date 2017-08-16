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

/**
 *  Button Modals
 */
$profile_picture = new mp_output_modal_acf(
	'headshot',
	'profile-picture-modal',
	'Profile Picture',
	$agent_id );

$profile_picture->output_modal();

$testimonials = new mp_output_modal_acf(
	'testimonials',
	'testimonials-modal',
	'Testimonials',
	$agent_id );

$testimonials->output_modal(); ?>

<div class="registration-form-wrapper">

    <div class="profile-header">

        <h3>Agent Profile Settings for <span><?php echo $username; ?></span></h3>

        <div class="agent-profile-links">

            <a href="<?php echo site_url(); ?>/user-dashboard">Dashboard</a> /
            <a href="<?php echo site_url(); ?>/agent/<?php echo $username; ?>">Your Profile</a> /
            <a href="<?php echo site_url(); ?>/add-listing">Create New Listing</a> /
            <a href="<?php echo site_url(); ?>">MarketPier Home</a> /
            <a href="<?php echo wp_logout_url( site_url() ); ?>">Log Out</a>
        </div>

        <div class="agent-profile-top-buttons">

            <a data-open="profile-picture-modal" class="button secondary short">Update Profile Picture</a>

            <a data-open="testimonials-modal" class="button secondary short">Add Testimonials</a>

        </div>
    </div>

    <div class="mp-update-success success callout">Your profile has been successfully updated.</div>

    <form method="post" name="registration-form">

        <div class="agent-update-form">

            <input type="hidden" name="agent-id" class="agent-id" value="<?php echo $agent_id; ?>"/>

			<?php foreach ( $input_fields as $input ) {

				$input->get_value();

				if ( $input->input_type == 'input' ) {

					//$input->get_placeholder();
					// not currently using placeholder
					?>

                    <div class="agent-input-wrap agent-text-wrap">

                        <!-- regular user detail -->
                        <label><?php echo $input->label; ?></label>

                        <input
                                class="<?php echo $input->name; ?>"
                                name="<?php echo $input->name; ?>"
                                value="<?php echo $input->value; ?>"/>
                        <!-- placeholder="<?php //echo $input->placeholder; ?>"-->
                    </div>

				<?php } elseif ( $input->input_type == 'textarea' ) { ?>

                    <div class="agent-input-wrap agent-textarea-wrap">

                        <!-- regular user detail -->
                        <label><?php echo $input->label; ?></label>

                        <textarea class="<?php echo $input->name; ?>"
                                  name="<?php echo $input->name; ?>"><?php echo $input->value; ?></textarea>
                    </div>

				<?php } ?>

			<?php } ?>

        </div>

        <div class="agent-update-submit-wrap">
            <a type="submit" class="mp-button" id="agent-update-submit">Update</a>
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
