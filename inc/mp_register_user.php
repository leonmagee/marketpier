<?php

/**
 * Class mp_register_user
 * 1. wp_create_user (username, email, password)
 * 2. wp_update_user (first and last name, role)
 * 3. update_user_meta * (number of meta fields)
 */
class mp_register_user {

	public $username;
	public $email;
	public $password;
	public $first_name;
	public $last_name;
	public $phone_number;
	public $company;
	public $user_id;

	public function __construct(
		$username,
		$first_name,
		$last_name,
		$email,
		$password,
		$phone_number,
		$company
	) {
		$this->username     = $username;
		$this->email        = $email;
		$this->password     = $password;
		$this->first_name   = $first_name;
		$this->last_name    = $last_name;
		$this->phone_number = $phone_number;
		$this->company      = $company;
	}

	private function register_user() {

		$this->user_id = wp_create_user( $this->username, $this->password, $this->email );

		wp_update_user( array(
			'ID'         => $this->user_id,
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'role'       => 'agent'
		) );

		update_user_meta( $this->user_id, 'phone_number', $this->phone_number );
		update_user_meta( $this->user_id, 'company', $this->company );
	}

	public function process_registration_form() {
		if ( isset( $_POST['username'] ) ) {
			$this->register_user();
		}
	}


}