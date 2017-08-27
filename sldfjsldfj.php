<?php
/**
 * Template Name: Add New Listing
 *
 * @package MarketPier
 *
 * @todo maybe have a different template for each form part? Start by just creating two forms...
 */

logged_in_check_redirect();
acf_form_head(); // this should only be used on two pages - new listing and update profile?
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="page-content-wrap">
				<header class="entry-header">
					<h1 class="entry-title">Add New Listing</h1>
				</header>
				<div class="logged-in-outer-wrap">
					<div class="logged-in-user-content logged-in-user-add-listings add-or-edit-listing">

						<div class="two-buttons">
							<a href="<?php echo site_url(); ?>/add-listing-for-sale">
								<button class="mp-button" id="sale-listing">Add a Sale Listing</button>
							</a>
							<a href="<?php echo site_url(); ?>/add-listing-for-lease">
								<button class="mp-button" id="lease-listing">Add a Lease Listing</button>
							</a>
						</div>

					</div>
					<?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer();
