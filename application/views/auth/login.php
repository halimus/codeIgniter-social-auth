<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top: 100px;">

            <div id="is_logout">
                <button type="button" class="btn btn-primary" id="login">Login</button>
            </div>



            <div id="is_login" style="display: none">
                <div id="user"></div>
                <button type="button" class="btn btn-danger" id="logout">Logout1</button>
                <a href="<?php echo site_url('auth/logout');?>" class="btn btn-danger" role="button">Logout2</a>

            </div>
<a href="<?php echo $this->facebook->logout_url(); ?>">Logout</a>


        </div>
    </div>
</div>

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
        $('#login00').on('click', function () {
            FB.login(function () {
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {

                        FB.api('/me', function (response) {
                            console.log('getUser', response);

                            console.log('id=' + response.id);
                            $('#user').append('id=' + response.id + '<br>');
                            $('#user').append('name=' + response.name + '<br>');
                            $('#is_login').show();
                            $('#is_logout').hide();

                        });
                    } else if (response.status === 'not_authorized') {
                        // User logged into facebook, but not to our app.
                    } else {
                        // User not logged into Facebook.
                    }
                });
            }, {scope: '<?php echo implode(",", $this->config->item('facebook_permissions')); ?>'});
        });

        $('#login').on('click', function () {
            FB.login(function () {
                loginCheck();
            }, {scope: '<?php echo implode(",", $this->config->item('facebook_permissions')); ?>'});
        });
        
        /*
         * 
         */
        $('#logout').on('click', function () {
            logout();
            console.log('logout');
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
        FB.api('/me', function (response) {
            //console.log('getUser', response);
            //console.log('id=' + response.id);
            //alert();

            $('#user').append('id=' + response.id + '<br>');
            $('#user').append('name=' + response.name + '<br><br>');
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