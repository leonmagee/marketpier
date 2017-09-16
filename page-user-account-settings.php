<?php
/**
 * Template Name: User Account Settings
 *
 * @package MarketPier
 */

logged_in_check_redirect();

acf_form_head();

get_template_part( 'template-parts/spinner' );

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">
                <header class="entry-header">
                    <h1 class="entry-title">Account Settings</h1>
                </header>
                <div class="logged-in-outer-wrap">
                    <div class="logged-in-user-content logged-in-edit-profile">
						<?php get_template_part( 'template-parts/account-settings' ); ?>
                    </div>
	                <?php get_template_part( 'template-parts/logged-in-user-sidebar' ); ?>
                </div>
            </div>
        </main>
    </div>
<?php
get_footer();
