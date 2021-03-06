<?php
/**
 * Class mp_output_modal_acf
 *
 */
class mp_output_modal_acf {

	public $field_key;
	public $link_id;
	public $form_title;
	public $agent_id;

	public function __construct( $field_key, $link_id, $form_title, $agent_id ) {

		$this->field_key = $field_key;
		$this->link_id = $link_id;
		$this->form_title = $form_title;
		$this->agent_id = $agent_id;
	}

	public function output_modal() { ?>

		<div id="<?php echo $this->link_id; ?>" class="reveal" data-reveal>

			<h2 id="modalTitle"><?php echo $this->form_title; ?></h2>

			<div class="form-wrapper">

				<?php
				acf_form( array(
					'post_id' => 'user_' . $this->agent_id,
					//'uploader' => 'wp',
					'uploader' => 'basic',
					'fields'  => array(
						$this->field_key
						//'phone_number',
						//'agency',
//										'headshot',
//										'facebook_url',
//										'twitter_url',
//										'google_plus_url',
//										'linkedin_url',
//										'youtube_url',
//										'instagram_url',
//										'pinterest_url',
//										'testimonials'
					),
				) );
				?>

			</div>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>

		</div>

	<?php }
}