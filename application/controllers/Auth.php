<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    /**
     *
     * 
     */
    function __construct() {
        parent::__construct();
        $this->load->library('facebook');
        $this->load->helper('url');
    }

    /**
     *
     */
    public function index() {
        
        
        // Check if user is logged in
        if ($this->facebook->is_authenticated()) {
            //die('yes');
            // User logged in, get user details
            $user = $this->facebook->request('get', '/me?fields=id,name,email');
            if (!isset($user['error'])) {
                $data['user'] = $user;
                print_r($user);
                echo 'yess';
                //exit;
            }
            else{
                dei('not login');
            }
        }
        else{
            echo 'noo';
        }
        
        
        $this->load->view('includes/header');
        $this->load->view('auth/login');
        $this->load->view('includes/footer'); 
    }
    
    
    /**
     *
     */
    public function logout() {
        $this->facebook->destroy_session();
        //die('logout');
        redirect('auth', redirect);
    }
    
}
