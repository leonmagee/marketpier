<?php

/**
 * Class agent_update
 *
 * This will be used on the agent profile page, and the ajax processing page
 */
class agent_update {

	public static function output_input_array( $agent_id ) {

		$input_fields = array();

		$input_fields[] = new agent_update_input_user_meta( 'First Name', 'first_name', $agent_id );
		$input_fields[] = new agent_update_input_user_meta( 'Last Name', 'last_name', $agent_id );

		$input_fields[] = new agent_update_input_user( 'Email Address', 'user_email', $agent_id );

		$input_fields[] = new agent_update_input_acf( 'Phone Number', 'phone_number', $agent_id );

		$input_fields[] = new agent_update_input_user_meta( 'Bio', 'description', $agent_id, 'textarea' );

		$input_fields[] = new agent_update_input_acf( 'Brokerage Name', 'agency', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Facebook URL', 'facebook_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Linkedin URL', 'linkedin_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Twitter URL', 'twitter_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Google Plus URL', 'google_plus_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Youtube URL', 'youtube_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Instagram URL', 'instagram_url', $agent_id );
		$input_fields[] = new agent_update_input_acf( 'Pinterest URL', 'pinterest_url', $agent_id );

		return $input_fields;
	}

}