<?php
/**
 *  Process data with Ajax
 */


/**
 *  Add Ajax url to header for selected pages
 */
function mp_ajaxurl() {

	//if ( is_page( 'your-profile' ) || is_page( 'register-account' ) ) {
	?>

    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    </script>

	<?php
	//}
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
				//wp_die( 'response' );
			}

		}


	}
}


/**
 *  Ajax Action Hooks - references name of JS function
 */
add_action( 'wp_ajax_mp_register_user', 'mp_register_user' ); //@todo remove this? (redirect if logged in?)
add_action( 'wp_ajax_nopriv_mp_register_user', 'mp_register_user' );

/**
 *  Add New Note
 */
function mp_save_favorite_listing() {
	if ( isset( $_POST['listing_id'] ) ) {

		$listing_id = $_POST['listing_id'];
		$user_id    = $_POST['user_id'];

		global $wpdb;
		$prefix     = $wpdb->prefix;
		$table_name = $prefix . 'mp_favorite_listings';

		$favorite_query         = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}' AND `listing_id` = '{$listing_id}'";
		$query_favorite_listing = $wpdb->get_results( $favorite_query );

		if ( $query_favorite_listing ) {
			$entry_id              = $query_favorite_listing[0]->id;
			$favorite_query_delete = "DELETE FROM `{$table_name}` WHERE `id` = '{$entry_id}'";
			$wpdb->get_results( $favorite_query_delete );
		} else {

			$wpdb->insert( $table_name, array(
				'time'       => current_time( 'mysql' ),
				'user_id'    => $user_id,
				'listing_id' => $listing_id
			) );
		}
	}
}

add_action( 'wp_ajax_mp_favorite_listing', 'mp_save_favorite_listing' );




/**
 *  Add New Note
 */
function mp_save_search() {
	if ( isset( $_POST['search_request'] ) ) {

		$user_id    = $_POST['user_id'];
		$search_url = $_POST['search_request'];

		global $wpdb;
		$prefix     = $wpdb->prefix;
		$table_name = $prefix . 'mp_saved_searches';

		$saved_search_query         = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}' AND `search_url` = '{$search_url}'";
		$query_saved_search = $wpdb->get_results( $saved_search_query );

		if ( $query_saved_search ) {
			$entry_id              = $query_saved_search[0]->id;
			$save_search_delete = "DELETE FROM `{$table_name}` WHERE `id` = '{$entry_id}'";
			$wpdb->get_results( $save_search_delete );
		} else {

			$wpdb->insert( $table_name, array(
				'time'       => current_time( 'mysql' ),
				'user_id'    => $user_id,
				'search_url' => $search_url
			) );
		}
	}
}

add_action( 'wp_ajax_mp_save_search', 'mp_save_search' );