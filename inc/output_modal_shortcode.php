<?php

/**
 * Class mp_output_modal_shortcode
 *
 */
class mp_output_modal_shortcode {

	public $shortcode;
	public $link_id;
	public $form_title;

	public function __construct( $shortcode, $link_id, $form_title ) {

		$this->shortcode  = $shortcode;
		$this->link_id    = $link_id;
		$this->form_title = $form_title;
	}

	public function output_modal() { ?>

        <div id="<?php echo $this->link_id; ?>" class="reveal" data-reveal>
            <h2 id="modalTitle"><?php echo $this->form_title; ?></h2>
            <div class="form-wrapper">
				<?php echo do_shortcode( $this->shortcode ); ?>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

	<?php }
}