<?php
/**
 * @package MarketPier
 */
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="page-content-wrap">

                <button class="button" type="button" data-toggle="example-dropdown">Toggle Dropdown</button>
                <div class="dropdown-pane" id="example-dropdown" data-dropdown data-auto-focus="true">
                    Example form in a dropdown.
                    <form>
                        <div class="row">
                            <div class="medium-6 columns">
                                <label>Name
                                    <input type="text" placeholder="Kirk, James T.">
                                </label>
                            </div>
                            <div class="medium-6 columns">
                                <label>Rank
                                    <input type="text" placeholder="Captain">
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <button class="button" type="button" data-toggle="example-dropdown-1">Hoverable Dropdown</button>
                <div class="dropdown-pane" id="example-dropdown-1" data-dropdown data-hover="true" data-hover-pane="true">
                    Just some junk that needs to be said. Or not. Your choice.
                </div>

            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
