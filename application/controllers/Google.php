<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends CI_Controller {

    /*
     * http://www.codexworld.com/login-with-google-account-in-codeigniter/
     */
    function __construct() {
        parent::__construct();
        // Load user model
        $this->load->model('user');
    }

    /*
     * 
     */
    public function index() {
        // Include the google api php libraries
        include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

        // Google Project API Credentials
        $clientId = '415940856583-31ecmf41kl7ukk2pahl520susce6rgq3.apps.googleusercontent.com';
        $clientSecret = 'XkBlTGkER48vKOS-6cwA6Lni';
        $redirectUrl = base_url() . 'google/';
        
        
        
//        $config['googleplus']['application_name'] = 'liveone-158304';
//        $config['googleplus']['client_id']        = '415940856583-31ecmf41kl7ukk2pahl520susce6rgq3.apps.googleusercontent.com';
//        $config['googleplus']['client_secret']    = 'XkBlTGkER48vKOS-6cwA6Lni';  
//        $config['googleplus']['redirect_uri']     = 'https://accounts.google.com/o/oauth2/auth';
//        $config['googleplus']['api_key']          = 'https://accounts.google.com/o/oauth2/token';
//        $config['googleplus']['scopes']           = array();
        
        
        
        
        
        
        
        

        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['given_name'];
            $userData['last_name'] = $userProfile['family_name'];
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
            // Insert or update user data
            $userID = $this->user->checkUser($userData);
            if (!empty($userID)) {
                $data['userData'] = $userData;
                $this->session->set_userdata('userData', $userData);
            } 
            else {
                $data['userData'] = array();
            }
        } 
        else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
        
        $this->load->view('user_authentication/index', $data);
    }

    /*
     * 
     */
    public function logout() {
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        redirect('/google');
    }

}
