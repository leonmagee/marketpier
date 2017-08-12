<?php
/**
 *  Process data with Ajax
 */


/**
 *  Add Ajax url to header for selected pages
 */
function skyrises_ajaxurl() {

	if ( is_page( 'profile' ) ) { ?>

		<script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>

		<?php
	}
}

add_action( 'wp_head', 'skyrises_ajaxurl' );

/**
 *  Update Agent Settings
 */
function skyrises_agent_update() {

	if ( isset( $_POST['skyrises_agent_update_click'] ) ) {

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
add_action( 'wp_ajax_skyrises_agent_update', 'skyrises_agent_update' );
