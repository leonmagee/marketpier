<?php

/**
 * Class mp_output_modal_shortcode
 *
 */
class mp_output_modal_shortcode {

	public $shortcode;
	public $link_id;
	public $form_title;

	public function __construct( $shortcode, $link_id, $form_title, $link_reg = null ) {

		$this->shortcode  = $shortcode;
		$this->link_id    = $link_id;
		$this->form_title = $form_title;
		$this->link_reg   = $link_reg;
	}

	public function output_modal() { ?>

        <div id="<?php echo $this->link_id; ?>" class="reveal" data-reveal>
			<?php if ( $this->link_reg ) { ?>
                <h2 class="sign-up-modal-title" id="modalTitle"><?php echo $this->form_title; ?> or <a href="<?php echo site_url(); ?>/register-account">Sign Up for New Account</a></h2>
			<?php } else { ?>
                <h2 id="modalTitle"><?php echo $this->form_title; ?></h2>
			<?php } ?>
            <div class="form-wrapper">
				<?php echo do_shortcode( $this->shortcode ); ?>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

	<?php }
}