<?php

/**
 * Class mp_send_email
 */
class mp_send_email {

	public $user_email;
	public $user_name;
	public $user_phone;
	public $user_comment;
	public $agent_email;


	public function __construct( $user_email, $user_name, $user_phone, $user_comment, $agent_email ) {

		$this->user_email   = $user_email;
		$this->user_name    = $user_name;
		$this->user_phone   = $user_phone;
		$this->user_comment = $user_comment;
		$this->agent_email  = $agent_email;
	}

	/**
	 * function for sending admin email and user email?
	 */
	public function send_email() {

		$website_url = 'https://marketpier.com';
		$user_email  = $this->user_email;
		$subject     = 'Welcome to MarketPier';

		$body_admin = '<div style="padding-left: 10px; padding-right: 10px;">

		<h2 style="color: #00A3E4">MarketPier</h2>

		<div>
			User Request for <strong>MarketPier</strong>.
		</div>
		<div style="margin: 5px 0">Email Address: <strong>' . $this->user_email . '</strong></div>
		<div style="margin: 5px 0">Name: <strong>' . $this->user_name . '</strong></div>
		<div style="margin: 5px 0">Phone: <strong>' . $this->user_phone . '</strong></div>
		<div style="margin: 5px 0">Comment: <strong>' . $this->user_comment . '</strong></div>
		<div>
			<div style="margin-top: 30px; margin-bottom: 15px;">
				<a style="text-decoration: none; font-size: 13px; background-color: #27A2DB; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-right: 15px;" href="' . $website_url . '">VISIT WEBSITE</a>
			</div>
		</div>
	</div>';


		$body_user = '<div style="padding-left: 10px; padding-right: 10px;">
		<h2 style="color: #D62839">MarketPier</h2>
		<div>
			Thank you for choosing <strong>MarketPier</strong>. 
		</div>
		<div>' . get_field( 'single_listing_email_text', 'option' ) . '</div>
			<div style="margin-top: 30px; margin-bottom: 15px;">
				<a style="text-decoration: none; font-size: 13px; background-color: #00A3E4; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-right: 15px;" href="' . $website_url . '">VISIT WEBSITE</a>
			</div>
		</div>
	</div>';


		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		$admin_emails = array(
//			'leads@carcoglobal.com',
			$this->agent_email
		);
		/**
		 * Admin Email
		 */
		wp_mail(
			$admin_emails,
			$subject,
			$body_admin,
			$headers
		);

		/**
		 * User Email
		 */
		wp_mail(
			$user_email,
			$subject,
			$body_user,
			$headers
		);
	}
}