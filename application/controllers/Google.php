<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends CI_Controller {

    /**
     *
     * 
     */
    function __construct() {
        parent::__construct();
        //https://github.com/moemoe89/google-login-ci3
        // http://www.codexworld.com/login-with-google-account-in-codeigniter/    => Google Project Creation 
    }

    /**
     *
     */
    public function index() {

        if ($this->session->userdata('login') == true) {
            redirect('google/profile');
        }

        if (isset($_GET['code'])) {

            $this->googleplus->getAuthenticate();
            $this->session->set_userdata('login', true);
            $this->session->set_userdata('user_profile', $this->googleplus->getUserInfo());
            redirect('google/profile');
        }

        $contents['login_url'] = $this->googleplus->loginURL();
        //$this->load->view('welcome_message', $contents);


        $this->load->view('includes/header');
        $this->load->view('google/login', $contents);
        $this->load->view('includes/footer'); 
        
    }

    /**
     *
     */
    public function profile() {
        if ($this->session->userdata('login') != true) {
            redirect('google');
        }

        $contents['user_profile'] = $this->session->userdata('user_profile');
        //$this->load->view('google/profile', $contents);
        
        //echo '<pre>';
        //print_r($contents['user_profile']);
        //echo '</pre>';
        
        $this->load->view('includes/header');
        $this->load->view('google/profile', $contents);
        $this->load->view('includes/footer'); 
        
    }

    /**
     * Logout for web redirect example
     *
     * @return  [type]  [description]
     */
    public function logout() {
        $this->session->sess_destroy();
        $this->googleplus->revokeToken();
	redirect('google');
    }

}
