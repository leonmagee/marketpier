<?php

/**
 * Class agent_update_input_user
 */
class agent_update_input_user extends agent_update_input {

	public function get_value() {

		$agent_data = get_userdata( $this->agent_id );

		$key = $this->name;

		$this->value = $agent_data->$key;
	}

	public function update_value() {

		/**
		 *  Right now, the only field using this method is the email field - this is good since I can
		 *  enter specific vaidation here for this field -
		 */

		$key = $this->name;

		$ajax_post = filter_input( INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS );

		if ( $ajax_post ) {

			/**
			 * @todo add validation here - check if is an actual email address
			 */
			$new_email = wp_update_user( array( 'ID' => $this->agent_id, $key => $ajax_post ) );

//			if ( is_wp_error( $new_email ) ) {
//
//				die( 'there was an error?');
//				// There was an error, probably that user doesn't exist.
//			} else {
//				// Success!
//				die('success');
//			}

			/**
			 *  to 'die' will stop other forms from working...
			 */
			//die( 'New Email: ' . $new_email );

//			if ( $new_email ) {
//
//				die( $new_email );
//
//				} else {
//
//				die( 'validation failed!' );
//			}
		}
	}
}