<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     *
     * 
     */
    function __construct() {
        parent::__construct();
    }

    /**
     *
     */
    public function index() {
        
        

        $this->load->view('includes/header');
        $this->load->view('home');
        $this->load->view('includes/footer'); 
    }
    
    /**
     *
     */
    public function logout() {
        
        

        $this->load->view('includes/header');
        $this->load->view('home');
        $this->load->view('includes/footer'); 
    }
    

}
