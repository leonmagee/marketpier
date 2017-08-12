<?php

/**
 * Class mp_register_user
 *
 */
class mp_register_user {

	public $username;
	public $first_name;
	public $last_name;
	public $email;
	public $user_id;
	//public $headshot_url;

	public function __construct(
		$username,
		$first_name,
		$last_name,
		$email,
		$headshot_url = null
	) {

		$this->username           = $username;
		$this->first_name         = $first_name;
		$this->email              = $email;
		//$this->headshot_url       = $headshot_url;
	}

	private function register_user() {

		$this->user_id = register_new_user( $this->username, $this->email );
		/**
		 * @todo use the user id to update meta values?
		 */
	}

	public function process_registration_form() {

		if ( isset( $_POST['username'] ) ) {

			$this->register_user();
			//die( 'form submit working' );
		}
	}


}