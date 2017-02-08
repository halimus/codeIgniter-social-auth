<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Social-Auth</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

        <script>var base_url = '<?php echo base_url(); ?>';</script>
        <script>
            /*
             * Initiate Facebook JS SDK
             */
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '<?php echo $this->config->item('facebook_app_id'); ?>', // Your app id
                    cookie: true, // enable cookies to allow the server to access the session
                    xfbml: false, // disable xfbml improves the page load time
                    version: 'v2.5', // use version 2.4
                    status: true // Check for user login status right away
                });
                FB.getLoginStatus(function (response) {
                    //console.log('getLoginStatus', response);
                    loginCheck(response);
                });
            };

            $(function () {
                /*
                 * Trigger login
                 */
                $('#login').on('click', function () {
                    FB.login(function () {
                        loginCheck();
                    }, {scope: '<?php echo implode(",", $this->config->item('facebook_permissions')); ?>'});
                });

                /*
                 * 
                 */
                $('#logout').on('click', function () {
                    $.ajax({
                        type: "POST",
                        url: base_url + "auth/logout_js",
                        dataType: 'JSON',
                        success: function (response) {
                            logout();
                            console.log('FB logout');
                        },
                        error: function () {
                            lobibox('error', 'Failed request to delete');
                            console.log('cant logout from the server');
                        }
                    }); 
                });
            });

            function logout() {
                FB.logout(function (response) {
                    // Person is now logged out
                    loginCheck();
                });
            }
            /*
             * Get login status
             */
            function loginCheck() {
                FB.getLoginStatus(function (response) {
                    //console.log('loginCheck', response);
                    statusCheck(response);
                });
            }

            /*
             * Check login status
             */
            function statusCheck(response) {
                console.log('statusCheck', response.status);
                if (response.status === 'connected') {
                    user = getUser();
                    console.log(user);
                    // alert(user.name);
                    // $('.login').hide();
                    // $('.logout').show();
                    // $('.form').fadeIn();

                } else if (response.status === 'not_authorized') {
                    // User logged into facebook, but not to our app.
                    $('#is_login').hide();
                    $('#is_logout').show();
                    $('#user').html('');
                } else {
                    // User not logged into Facebook.
                    $('#is_login').hide();
                    $('#is_logout').show();
                    $('#user').html('');
                }
            }

            /*
             * Here we run a very simple test of the Graph API after login is
             * successful.  See statusChangeCallback() for when this call is made.
             */
            function getUser() {
                //FB.api('/me', function (response) {
                FB.api("/me", {fields: "id,name,email,picture"}, function(response){
                    $('.user_id').html(response.id);
                    $('.user_name').html(response.name);
                    $('.user_email').html(response.email);
                    $('.user_picture img').attr("src", "http://graph.facebook.com/" + response.id + "/picture?type=small");
                    
                    $('#is_login').show();
                    $('#is_logout').hide();
                });
            }

            /*
             * Load the SDK asynchronously
             */
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

    </head>
    <body>







