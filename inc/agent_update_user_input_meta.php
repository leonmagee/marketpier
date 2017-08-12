<?php

/**
 * Class agent_update_input_user_meta
 */
class agent_update_input_user_meta extends agent_update_input {

	public function get_value() {

		$this->value = get_user_meta( $this->agent_id, $this->name, true );
	}

	public function update_value() {

		$key = $this->name;

		$ajax_post = filter_input( INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS );

		update_user_meta( $this->agent_id, $key, $ajax_post );
	}
}