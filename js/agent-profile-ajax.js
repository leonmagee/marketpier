jQuery(function ($) {

    /**
     * Process ajax to update agent info
     */
    $("a#agent-update-submit").click(function (event) {

        event.preventDefault();

        $('.mp-update-success').hide();
        $('.uploads-spinner').css({'display':'flex'});

        var user_email = $(".registration-form-inner input.user_email").val();
        var first_name = $(".registration-form-inner input.first_name").val();
        var last_name = $(".registration-form-inner input.last_name").val();
        var phone_number = $(".registration-form-inner input.phone_number").val();
        var description = $(".registration-form-inner textarea.description").val();
        var agency = $(".registration-form-inner input.agency").val();
        var facebook_url = $(".registration-form-inner input.facebook_url").val();
        var linkedin_url = $(".registration-form-inner input.linkedin_url").val();
        var twitter_url = $(".registration-form-inner input.twitter_url").val();
        var google_plus_url = $(".registration-form-inner input.google_plus_url").val();
        var youtube_url = $(".registration-form-inner input.youtube_url").val();
        var instagram_url = $(".registration-form-inner input.instagram_url").val();
        var pinterest_url = $(".registration-form-inner input.pinterest_url").val();

        var formdata = new FormData();

        formdata.append("skyrises_agent_update_click", 'click');

        formdata.append("user_email", user_email);
        formdata.append("first_name", first_name);
        formdata.append("last_name", last_name);
        formdata.append("phone_number", phone_number);
        formdata.append("description", description);
        formdata.append("agency", agency);
        formdata.append("facebook_url", facebook_url);
        formdata.append("linkedin_url", linkedin_url);
        formdata.append("twitter_url", twitter_url);
        formdata.append("google_plus_url", google_plus_url);
        formdata.append("youtube_url", youtube_url);
        formdata.append("instagram_url", instagram_url);
        formdata.append("pinterest_url", pinterest_url);

        formdata.append("action", "skyrises_agent_update");

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data, textStatus, XMLHttpRequest) {
                //console.log( data );
                $('.uploads-spinner').hide();
                $('.mp-update-success').show();
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });


});