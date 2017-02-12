<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

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
        $data['title'] = 'Login Page';
        $this->load->view('includes/header', $data);
        $this->load->view('index');
        $this->load->view('includes/footer'); 
    }
    
}
