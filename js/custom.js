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
        var agent_email = $(this).find('.agent-email').html();
        console.log('email: ', agent_email);
        // @todo get email address here?
        $('input[name="agent_email"]').val(agent_email);
    });

    $('.toggle-advanced-options').click(function () {
        $('.advanced-options-toggle').toggleClass('open');
    });

    /**
     * Auto Calculation for net income
     */
    // var list_price = false;
    // var cap_rate = false;
    //
    // function calculate_net_income(list_price, cap_rate) {
    //     var net_income = ( list_price * (cap_rate / 100));
    //     return '$' + net_income.toFixed(2);
    // }
    //
    // function change_net_income() {
    //     if (list_price && cap_rate) {
    //         var income = calculate_net_income(list_price, cap_rate);
    //         $('div[data-name="listing_net_operating_income"] input').val(income);
    //     }
    // }
    //
    // $('div[data-name="listing_price"] input').keyup(function () {
    //     list_price = $(this).val();
    //     change_net_income();
    // });
    // $('div[data-name="listing_cap_rate"] input').keyup(function () {
    //     cap_rate = $(this).val();
    //     change_net_income();
    // });

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
    var active_page = 1;
    $('.add-listing-navigation .nav-button.next.enabled').click(function () {
        if (active_page <= 2) {
            //console.log( 'next', active_page);
            $('.add-listing-navigation .nav-button.prev').addClass('enabled');
            active_page = ( active_page + 1);
            if (active_page === 2) {
                $('.add-a-listing-wrap.page-1').removeClass('page-1').addClass('page-2');
            }
            if (active_page === 3) {
                $('.add-a-listing-wrap.page-2').removeClass('page-2').addClass('page-3');
                $(this).removeClass('enabled');
            }
        }
    });


    $('.add-listing-navigation .nav-button.prev').click(function () {
        if (active_page >= 2) {
            //console.log( 'prev', active_page);
            $('.add-listing-navigation .nav-button.next').addClass('enabled');
            active_page = ( active_page - 1);
            if (active_page === 1) {
                $('.add-a-listing-wrap.page-2').removeClass('page-2').addClass('page-1');
                $(this).removeClass('enabled');
            }
            if (active_page === 2) {
                $('.add-a-listing-wrap.page-3').removeClass('page-3').addClass('page-2');
            }
        }
    });

    function get_page_number() {
        var current_page_number = $('.search-form-wrap-snippets input[name="page-number"]').val();
        return parseInt(current_page_number);
    }

    function set_page_number(page_number) {
        $('.search-form-wrap-snippets input[name="page-number"]').val(page_number);
    }

    function submit_form() {
        $('.search-form-wrap-snippets form').submit();
    }

    $('.nav-link.prev-page.active').click(function () {
        $(this).unbind('click');
        set_page_number(get_page_number() - 1);
        submit_form();
    });
    $('.nav-link.next-page.active').click(function () {
        $(this).unbind('click');
        set_page_number(get_page_number() + 1);
        submit_form();
    });

    // $('.two-buttons #sale-listing').click(function () {
    //     $('div[data-name="listing_for_sale_or_for_lease"] select').val('for_sale');
    //     $('.two-buttons #lease-listing').removeClass('active');
    //     //$('select[name=""]').val('for_sale');
    //     $(this).addClass('active');
    //     $('.for-lease-listing').hide();
    //     $('.for-sale-listing').fadeIn();
    // });
    //
    // $('.two-buttons #lease-listing').click(function () {
    //     $('div[data-name="listing_for_sale_or_for_lease"] select').val('for_lease');
    //     $('.two-buttons #sale-listing').removeClass('active');
    //     $(this).addClass('active');
    //     $('.for-sale-listing').hide();
    //     $('.for-lease-listing').fadeIn();
    // });

    // var agent_modal = $('#contact-agent-modal');
    //
    // agent_modal.foundation('open');

    // $.ajax('/url')
    //     .done(function(resp){
    //         $modal.html(resp).foundation('open');


}(jQuery));




