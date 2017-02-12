<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Face extends CI_Controller {

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
        $data['title'] = 'Login Page';

        // Check if user is logged in
        if ($this->facebook->is_authenticated()) {
            //User logged in, get user details
            $user = $this->facebook->request('get', '/me?fields=id,name,email,picture');
            if (!isset($user['error'])) {
                $data['user'] = $user;
                //print_r($user);
            }
        }
        else{
            //echo 'not authenticated';
        }
        
        
        $this->load->view('includes/header', $data);
        $this->load->view('facebook/login_js');
        $this->load->view('includes/footer'); 
    }
    
    
    
    /**
     *
     */
    public function logout_js() {
        $reponse = '';
        if ($this->facebook->is_authenticated()) {
            $this->facebook->destroy_session();
        }
        echo json_encode($reponse);
    }
    
    /**
     *
     */
    public function logout() {
        $this->facebook->destroy_session();
        //die('logout');
        redirect('face', redirect);
    }
    
}
