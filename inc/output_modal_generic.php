<?php

/**
 * Class mp_output_modal_generic
 *
 */
class mp_output_modal_generic {

	public $link_id;
	public $form_title;
	public $modal_text;

	public function __construct( $link_id, $form_title, $modal_text ) {

		$this->link_id    = $link_id;
		$this->form_title = $form_title;
		$this->modal_text = $modal_text;
	}

	public function output_modal() { ?>

        <div id="<?php echo $this->link_id; ?>" class="reveal" data-reveal>

            <h2 id="modalTitle"><?php echo $this->form_title; ?></h2>

            <div class="form-wrapper">

				<?php echo $this->modal_text; ?>

            </div>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

	<?php }
}