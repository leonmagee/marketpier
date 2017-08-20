jQuery(function ($) {

    /**
     * Process ajax to update agent info
     */
    $("a#agent-update-submit").click(function (event) {

        event.preventDefault();

        $('.mp-update-success').hide();
        $('.uploads-spinner').css({'display': 'flex'});

        var user_email = $(".profile-update-form-wrapper input.user_email").val();
        var first_name = $(".profile-update-form-wrapper input.first_name").val();
        var last_name = $(".profile-update-form-wrapper input.last_name").val();
        var phone_number = $(".profile-update-form-wrapper input.phone_number").val();
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

        console.log('phone', phone_number);

        var formdata = new FormData();

        formdata.append("mp_agent_update_click", 'click');

        formdata.append("user_email", user_email);
        formdata.append("first_name", first_name);
        formdata.append("last_name", last_name);
        formdata.append("phone_number", phone_number);
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
                    console.log( 'made it to success????');
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


});