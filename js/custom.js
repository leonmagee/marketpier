(function ($) {
    /**
     * Initialize Foundation
     */
    $(document).foundation();

    /**
     * Handle Listing Search Functionality
     * The search bar uses foundation dropdowns to simulate a normal-ish search form.
     * @todo test on mobile!
     */

    $('.search-form-wrap .dropdown-pane ul li').click(function () {
        var selected_value = $(this).html();
        var selected_name = $(this).attr('name');
        //console.log('namey?', selected_name);
        //$(this).parent().parent().parent().find('.select-toggle').html(selected_value).parent().addClass('selected');
        //$(this).parent().parent().css({'visibility': 'hidden'}).parent().find('.select-toggle').html(selected_value);

        //@todo would be good to hide the panel on click but then it doesn't show up again on hover?
        $(this).parent().find('.selected').removeClass('selected');
        $(this).addClass('selected').parent().parent().parent().find('.select-toggle').html(selected_value).parent().find('input.hidden-input').val(selected_name);

        // @todo set value of hidden input

        //$(this).parent().find('.select-toggle').val('xxx');
    });

    // handle default value for just property type
    $('.search-form-wrap .property-type .dropdown-pane ul li').click(function () {
        var selected_value = $(this).html();

        $('.search-form-wrap .property-type .dropdown-pane ul li.default-choice').show();
        if (selected_value === 'All Property Types') {
            $('.search-form-wrap .property-type .dropdown-pane ul li.default-choice').hide();
        }
    });

    $('.listing-agent-form-wrap .agent-choice-wrap').click(function () {
        $('.listing-agent-form-wrap .agent-choice-wrap.active').removeClass('active');
        $(this).addClass('active');
    });

    $('.toggle-advanced-options').click(function () {
        $('.advanced-options-toggle').toggleClass('open');
    })


}(jQuery));




