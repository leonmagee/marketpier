jQuery(function ($) {

    /**
     * Process ajax to update agent info
     */
    $("a#account-settings-submit").click(function (event) {

        event.preventDefault();

        $('.mp-update-success').hide();
        $('.uploads-spinner').css({'display': 'flex'});

        var user_email = $(".profile-update-form-wrapper input.user_email").val();
        var first_name = $(".profile-update-form-wrapper input.first_name").val();
        var last_name = $(".profile-update-form-wrapper input.last_name").val();
        var phone_number = $(".profile-update-form-wrapper input.phone_number").val();

        // var description = $(".profile-update-form-wrapper textarea.description").val();
        // //var agency = $(".profile-update-form-wrapper input.agency").val();
        // var company = $(".profile-update-form-wrapper input.company").val();
        // var facebook_url = $(".profile-update-form-wrapper input.facebook_url").val();
        // var linkedin_url = $(".profile-update-form-wrapper input.linkedin_url").val();
        // var twitter_url = $(".profile-update-form-wrapper input.twitter_url").val();
        // var google_plus_url = $(".profile-update-form-wrapper input.google_plus_url").val();
        // var youtube_url = $(".profile-update-form-wrapper input.youtube_url").val();
        // var instagram_url = $(".profile-update-form-wrapper input.instagram_url").val();
        // var pinterest_url = $(".profile-update-form-wrapper input.pinterest_url").val();

        //console.log('phone', phone_number);

        var formdata = new FormData();

        formdata.append("mp_agent_update_click", 'click');

        formdata.append("user_email", user_email);
        formdata.append("first_name", first_name);
        formdata.append("last_name", last_name);
        formdata.append("phone_number", phone_number);

        // formdata.append("description", description);
        // //formdata.append("agency", agency);
        // formdata.append("company", company);
        // formdata.append("facebook_url", facebook_url);
        // formdata.append("linkedin_url", linkedin_url);
        // formdata.append("twitter_url", twitter_url);
        // formdata.append("google_plus_url", google_plus_url);
        // formdata.append("youtube_url", youtube_url);
        // formdata.append("instagram_url", instagram_url);
        // formdata.append("pinterest_url", pinterest_url);

        formdata.append("action", "mp_settings_update");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                $('.uploads-spinner').hide();
                $('.mp-update-success').show();
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

    /**
     * Process ajax to update agent info
     */
    $("a#agent-update-submit").click(function (event) {

        event.preventDefault();

        $('.mp-update-success').hide();
        $('.uploads-spinner').css({'display': 'flex'});

        // var user_email = $(".profile-update-form-wrapper input.user_email").val();
        // var first_name = $(".profile-update-form-wrapper input.first_name").val();
        // var last_name = $(".profile-update-form-wrapper input.last_name").val();
        // var phone_number = $(".profile-update-form-wrapper input.phone_number").val();
        var description = $(".profile-update-form-wrapper textarea.description").val();
        //var agency = $(".profile-update-form-wrapper input.agency").val();
        var company = $(".profile-update-form-wrapper input.company").val();
        var facebook_url = $(".profile-update-form-wrapper input.facebook_url").val();
        var linkedin_url = $(".profile-update-form-wrapper input.linkedin_url").val();
        var twitter_url = $(".profile-update-form-wrapper input.twitter_url").val();
        var google_plus_url = $(".profile-update-form-wrapper input.google_plus_url").val();
        var youtube_url = $(".profile-update-form-wrapper input.youtube_url").val();
        var instagram_url = $(".profile-update-form-wrapper input.instagram_url").val();
        var pinterest_url = $(".profile-update-form-wrapper input.pinterest_url").val();

        //console.log('phone', phone_number);

        var formdata = new FormData();

        formdata.append("mp_agent_update_click", 'click');

        // formdata.append("user_email", user_email);
        // formdata.append("first_name", first_name);
        // formdata.append("last_name", last_name);
        // formdata.append("phone_number", phone_number);
        formdata.append("description", description);
        //formdata.append("agency", agency);
        formdata.append("company", company);
        formdata.append("facebook_url", facebook_url);
        formdata.append("linkedin_url", linkedin_url);
        formdata.append("twitter_url", twitter_url);
        formdata.append("google_plus_url", google_plus_url);
        formdata.append("youtube_url", youtube_url);
        formdata.append("instagram_url", instagram_url);
        formdata.append("pinterest_url", pinterest_url);

        formdata.append("action", "mp_agent_update");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                $('.uploads-spinner').hide();
                $('.mp-update-success').show();
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });


    /**
     * Process ajax register new user
     */
    $("#register-new-user-submit").click(function (event) {

        event.preventDefault();

        $('.mp-update-success').hide();
        $('.uploads-spinner').css({'display': 'flex'});

        var username = $(".registration-input-wrap input.username").val();
        var password = $(".registration-input-wrap input.password").val();
        var email_address = $(".registration-input-wrap input.email_address").val();
        var first_name = $(".registration-input-wrap input.first_name").val();
        var last_name = $(".registration-input-wrap input.last_name").val();
        var phone_number = $(".registration-input-wrap input.phone_number").val();
        //var agency_name = $(".registration-input-wrap input.agency_name").val();
        var company = $(".registration-input-wrap input.company_name").val();

        if (username && password && email_address && first_name && last_name) {

            var formdata = new FormData();

            formdata.append("mp_register_user_click", 'click');

            formdata.append("username", username);
            formdata.append("password", password);
            formdata.append("email_address", email_address);
            formdata.append("first_name", first_name);
            formdata.append("last_name", last_name);
            formdata.append("phone_number", phone_number);
            //formdata.append("agency_name", agency_name);
            formdata.append("company", company);

            formdata.append("action", "mp_register_user");

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data, textStatus, XMLHttpRequest) {
                    //console.log( 'made it to success????');
                    $('.register-user-email-taken').hide();
                    $('.uploads-spinner').hide();
                    if (data === 'email_already_taken') {
                        $('.register-user-email-taken').show();
                    } else {
                        $('.mp-update-success').show();
                    }
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        } else {
            $('.uploads-spinner').hide();
            $('.mp-required-fields').show();
        }
    });


    $('a.save-link, a.contact-link.save-listing').click(function () {

        $(this).find('.fa-spin').css({'opacity': '1'});

        var listing_address = $(this).attr('listing_address');
        var listing_url = $(this).attr('listing_url');
        var user_id = $(this).attr('user_id');
        var current_link = $(this);
        console.log('number 1');

        /**
         * This will toggle the saved link, and also change it in the database - removing it if already set...
         */
        //event.preventDefault();

        if (user_id && listing_address && listing_url) {
            console.log('number 2');

            var formdata = new FormData();

            //formdata.append("mp_register_user_click", 'click');

            formdata.append("user_id", user_id);
            formdata.append("listing_address", listing_address);
            formdata.append("listing_url", listing_url);

            formdata.append("action", "mp_favorite_listing");

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data, textStatus, XMLHttpRequest) {
                    console.log('save listing?', data);
                    current_link.toggleClass('saved').find('.fa-spin').css({'opacity': '0'});
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

    });


    $('a.save-search-link').click(function () {

        $(this).find('.fa-spin').css({'opacity': '1'});

        var search_request = $(this).attr('search_request');
        var user_id = $(this).attr('user_id');
        var current_link = $(this);

        //console.log('search', search_request, user_id);

        /**
         * This will toggle the saved link, and also change it in the database - removing it if already set...
         */
        //event.preventDefault();

        if (user_id && search_request) {

            var formdata = new FormData();

            //formdata.append("mp_register_user_click", 'click');

            formdata.append("user_id", user_id);
            formdata.append("search_request", search_request);

            formdata.append("action", "mp_save_search");

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data, textStatus, XMLHttpRequest) {
                    //console.log('save search ajax success?');
                    current_link.toggleClass('saved').find('.fa-spin').css({'opacity': '0'});
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

    });


    /**
     * Process ajax to submit contact agent form
     */
    $(".listing-agent-form-wrap input.submit").click(function (event) {

        event.preventDefault();
        $('.uploads-spinner').css({'display': 'flex'});

        var user_name = $(".listing-agent-form-wrap input.name").val();
        var user_phone = $(".listing-agent-form-wrap input.phone").val();
        var user_email = $(".listing-agent-form-wrap input.email").val();
        var user_comment = $(".listing-agent-form-wrap textarea.comment").val();
        var agent_email = $(".listing-agent-form-wrap input.agent_email").val();
        //console.log(user_name, user_phone, user_email, user_comment, agent_email);

        var formdata = new FormData();

        formdata.append("mp_email_listing_agent_click", 'click');

        formdata.append("user_name", user_name);
        formdata.append("user_phone", user_phone);
        formdata.append("user_email", user_email);
        formdata.append("user_comment", user_comment);
        formdata.append("agent_email", agent_email);

        formdata.append("action", "mp_send_listing_agent_email");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                //console.log('data!', data);
                $('.uploads-spinner').hide();
                var agent_modal = $('#contact-agent-modal');
                agent_modal.foundation('open');
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });


    });


});