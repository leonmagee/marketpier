<?php
/**
 *  Process data with Ajax
 */


/**
 *  Add Ajax url to header for selected pages
 */
function mp_ajaxurl() {

	if ( is_page( 'your-profile' ) || is_page( 'register-account' ) ) { ?>

        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
        </script>

		<?php
	}
}

add_action( 'wp_head', 'mp_ajaxurl' );

/**
 *  Update Agent Settings
 */
function mp_agent_update() {

	if ( isset( $_POST['mp_agent_update_click'] ) ) {

		$user = wp_get_current_user();

		$agent_id = $user->ID;

		/**
		 *  Loop through agent fields
		 *
		 *  Process form submittal method
		 */
		$input_fields = agent_update::output_input_array( $agent_id );

		foreach ( $input_fields as $input ) {

			$input->update_value();
		}
	}
}


/**
 *  Ajax Action Hooks - references name of JS function
 */
add_action( 'wp_ajax_mp_agent_update', 'mp_agent_update' );


/**
 *  Register New User
 */
function mp_register_user() {

	if ( isset( $_POST['mp_register_user_click'] ) ) {

		if ( isset( $_POST['username'] ) ) {
			$username      = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS );
			$first_name    = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS );
			$last_name     = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS );
			$email_address = filter_input( INPUT_POST, 'email_address', FILTER_SANITIZE_SPECIAL_CHARS );
			$password      = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS );
			//$agency_name   = filter_input( INPUT_POST, 'agency_name', FILTER_SANITIZE_SPECIAL_CHARS );
			$company      = filter_input( INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS );
			$phone_number = filter_input( INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS );

			// @todo get other inputs

			if ( email_exists( $email_address ) ) {
				wp_die( 'email_already_taken' );
			} else {
				require_once( 'mp_register_user.php' );
				$new_user = new mp_register_user(
					$username,
					$first_name,
					$last_name,
					$email_address,
					$password,
					$phone_number,
					$company );
				$new_user->process_registration_form();
				wp_die( 'user_registered' );
			}

		}


	}
}


/**
 *  Ajax Action Hooks - references name of JS function
 */
add_action( 'wp_ajax_mp_register_user', 'mp_register_user' ); //@todo remove this? (redirect if logged in?)
add_action( 'wp_ajax_nopriv_mp_register_user', 'mp_register_user' );

