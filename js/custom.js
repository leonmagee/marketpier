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
    });


    /**
     * Auto Calculation for rent / SF
     */
    var space_available = false;
    var monthly_rent = false;

    function calculate_rent_sf(monthly_rent, listing_sqft) {
        var rent_value = ( monthly_rent / listing_sqft );

        return '$' + rent_value.toFixed(2);
    }

    function change_rate() {
        if (space_available && monthly_rent) {
            var rate = calculate_rent_sf(monthly_rent, space_available);
            $('div[data-name="rental_rate_sf_month"] input').val(rate);
        }
    }

    $('div[data-name="listing_space_available"] input').keyup(function () {
        space_available = $(this).val();
        change_rate();
    });
    $('div[data-name="listing_monthly_rent"] input').keyup(function () {
        monthly_rent = $(this).val();
        change_rate();
    });

    /**
     * Handle form navigation
     */

    $('.two-buttons #sale-listing').click(function () {
        $('.two-buttons #lease-listing').removeClass('active');
        $(this).addClass('active');
        $('.for-lease-listing').hide();
        $('.for-sale-listing').fadeIn();
    });

    $('.two-buttons #lease-listing').click(function () {
        $('.two-buttons #sale-listing').removeClass('active');
        $(this).addClass('active');
        $('.for-sale-listing').hide();
        $('.for-lease-listing').fadeIn();
    });


}(jQuery));




