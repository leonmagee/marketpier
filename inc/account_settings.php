<?php

/**
 * Class agent_update
 *
 * This will be used on the agent profile page, and the ajax processing page
 */
class account_settings {

	public static function output_input_array( $agent_id ) {

		$input_fields = array();

		$input_fields[] = new agent_update_input_user_meta( 'First Name', 'first_name', $agent_id );
		$input_fields[] = new agent_update_input_user_meta( 'Last Name', 'last_name', $agent_id );

		$input_fields[] = new agent_update_input_user( 'Email Address', 'user_email', $agent_id );

		$input_fields[] = new agent_update_input_acf( 'Phone Number', 'phone_number', $agent_id );

		return $input_fields;
	}

}