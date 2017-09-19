<?php
/**
 *  Account Settings for agent
 *  Get Agent/User ID
 */
$user = wp_get_current_user();

$agent_id = $user->ID;

$username = $user->user_login;

/**
 *  Create Input Objects
 */
$input_fields = account_settings::output_input_array( $agent_id ); ?>

<div class="profile-update-form-wrapper">

    <div class="mp-update-success success callout">Your profile has been successfully updated.</div>

    <form method="post" name="registration-form">

        <div class="agent-update-form">

            <input type="hidden" name="agent-id" class="agent-id" value="<?php echo $agent_id; ?>"/>

			<?php foreach ( $input_fields as $input ) {

				$input->get_value();

				if ( $input->input_type == 'input' ) {?>

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
            <a type="submit" class="mp-button" id="account-settings-submit">Update</a>
        </div>

    </form>

</div>
