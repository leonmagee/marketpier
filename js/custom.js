(function ($) {
    /**
     * Initialize Foundation
     */
    $(document).foundation();


    /**
    * Handle menu nav toggle
    */
    $('.header-right .logged-in-agent-headshot-wrap').click( function() {
        $(this).toggleClass('show-menu');
    });

    /**
    * Homepage search trigger on icon click
    */
    $('.homepage-wrap-outer .search-form-wrap .fa-search').click(function() {
        $('.homepage-wrap-outer .search-form-wrap form').submit();
    });

    /**
    * On Caldera Forms submission
    */
    $(document).on( 'cf.form.submit', function (event, data ) {
        //data.$form is a jQuery object for the form that just submitted.
    
        var $form = data.$form;

        var formId = $form.attr('id');

        //console.log(formId);

        if ( formId == 'CF5a1dd37b48484_1') {
            ga('send', 'event', 'formSubmission', 'submit', 'Subscribe Form Submit', '', '');
        }
    });


    /**
     * Handle Listing Search Functionality
     */
    // $('.search-form-wrap').hover(function() {
    //     //console.log('hovering?');
    //     //$(this).find('.dropdwon-pane').show();
    //     $('.search-form-wrap .dropdown-pane').show();
    // });

    // $('.search-form-wrap .input-wrap').click(function() {
    //     $(this).toggleClass('menu-open');
    //     //$('.search-form-wrap .dropdown-pane').toggle();
    // });




    // $('.input-wrap').on('mouseenter', function() {
    //     console.log('enter');
    //     $(this).find('.dropdown-pane, .county-choices').css('visibility', 'visible').show();
    // });

    $('.input-wrap').on('click', function() {
        $(this).find('.dropdown-pane').css('visibility', 'visible').toggle();
    });

    // $('.input-wrap').on('mouseleave', function() {
    //     console.log('leave');
    //     $(this).find('.dropdown-pane, .county-choices').css('visibility', 'hidden').hide();
    // });

    $('.search-form-wrap .dropdown-pane ul li').click(function () {
        //console.log('clicky?');


        var selected_value = $(this).html();
        var selected_name = $(this).attr('name');
        $(this).parent().find('.selected').removeClass('selected');
        $(this).addClass('selected').parent().parent().parent().find('.select-toggle').html(selected_value).parent().find('input.hidden-input').val(selected_name);
        // var current_dropdown = $(this).parent().parent();
        // current_dropdown.hide();

        // var show_drop = function() {

        //     current_dropdown.show();
        // };

        // $('body').off('mouseenter', '.search-form-wrap .input-wrap', show_drop);

        // setTimeout(function() {

        //     $('body').on('mouseenter', '.search-form-wrap .input-wrap', show_drop);
        // }, 300);
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
        // @todo get email address here?
        $('input[name="agent_email"]').val(agent_email);
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
    var active_page = 1;
    $('.add-listing-navigation .nav-button.next.enabled').click(function () {

        /**
         * Required Fields
         */
        var validation_succeeds = true;
        var val_message = $('.add-listing-validation-callout');

        function check_validation(data_name, type) {
            if (type === 'input') {
                var selector = $("div[data-name='" + data_name + "'] input");
            } else if (type === 'textarea') {
                var selector = $("div[data-name='" + data_name + "'] textarea");
            }
            var current_value = selector.val();

            if (!current_value) {
                if (selector.length) {
                    selector.addClass('validation-error');
                    validation_succeeds = false;
                    val_message.show();
                }
            }
        }

        check_validation('listing_address', 'input');
        check_validation('listing_city', 'input');
        check_validation('listing_state', 'input');
        check_validation('listing_zip', 'input');
        check_validation('listing_space_available', 'input');
        check_validation('listing_monthly_rent', 'input');
        check_validation('listing_description', 'textarea');

        if (validation_succeeds) {
            val_message.hide();
            $('.validation-error').removeClass('validation-error');
            if (active_page <= 2) {
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
        }
    });

    $('.add-listing-navigation .nav-button.prev').click(function () {
        if (active_page >= 2) {
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

    /**
     * Reset Page Number on Submit click
     */
    $('.search-form-wrap-snippets input.submit-input').click(function () {
        $('input[name="page-number"]').val(1);
    });

    /**
     * Form County Select
     */

    // $('.county-choices a').click(function () {
    //     var county_name = $(this).html();

    //     $('input[name="city-zip"]').val(county_name);
    // });

    // $('.county-choices li').click(function () {
    //     var county_name = $(this).html();

    //     $('input[name="city-zip"]').val(county_name);

    //     $(this).parent().find('.selected').removeClass('selected');
    //     $(this).addClass('selected');
    //     //$('.county-choices').hide();

    //     // var current_dropdown = $(this).parent().parent();
    //     // current_dropdown.hide();

    //     // var show_drop = function() {

    //     //     current_dropdown.show();
    //     // };

    //     // $('body').off('mouseenter', '.search-form-wrap .input-wrap', show_drop);

    //     // setTimeout(function() {

    //     //     $('body').on('mouseenter', '.search-form-wrap .input-wrap', show_drop);
    //     // }, 300);




    // });



    /**
    * Delete Saved Listings
    */
    $('.user-listings-wrap .logged-in-user-listing a.remove-saved-listing').click(function () {

        var saved_id = $(this).parent().parent().attr('saved-id');

        var parent_element = $(this).parent().parent();

        var formdata = new FormData();

        formdata.append("saved_id", saved_id);

        formdata.append("action", "mp_delete_favorite_listing");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                if (data) {
                    parent_element.fadeOut();
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }

        });

    });




    /**
     * Delete Listings
     * @todo this will use ajax
     * @todo this will send an are you sure notice
     */
    $('.delete-listing-link').click(function () {
        var listing_id = $(this).attr('listing-id');
        $(this).parent().find('span[listing-id="' + listing_id + '"]').addClass('display-link');
    });

    $('.user-listings-wrap .logged-in-user-listing .delete-listing-link-hidden a.cancel').click(function () {
        //console.log('so far');
        $(this).parent().removeClass('display-link');
    });

    $('.user-listings-wrap .logged-in-user-listing .delete-listing-link-hidden a.finalize').click(function () {
        var listing_id_new = $(this).parent().attr('listing-id');
        //console.log('finalize: ' + listing_id_new);

        //$(this).parent().parent().parent().fadeOut();

        var parent_element = $(this).parent().parent().parent();

        var formdata = new FormData();

        formdata.append("listing_id", listing_id_new);

        formdata.append("action", "mp_user_delete_listing");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                //console.log('listing deleted?', data);
                if (data) {
                    parent_element.fadeOut();
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });


    });

}(jQuery));
