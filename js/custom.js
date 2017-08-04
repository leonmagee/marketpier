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
        //$(this).parent().parent().parent().find('.select-toggle').html(selected_value).parent().addClass('selected');
        //$(this).parent().parent().css({'visibility': 'hidden'}).parent().find('.select-toggle').html(selected_value);
        //@todo would be good to hide the panel on click but then it doesn't show up again on hover?
        $(this).parent().find('.selected').removeClass('selected');
        $(this).addClass('selected').parent().parent().parent().find('.select-toggle').html(selected_value).parent().find('input.hidden-input').val(selected_value);

        // @todo set value of hidden input

        //$(this).parent().find('.select-toggle').val('xxx');
    })


}(jQuery));




