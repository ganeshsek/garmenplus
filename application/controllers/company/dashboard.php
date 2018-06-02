<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        fnIfCheckUserLoggedIn();
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        //$this->load->model("profilemodel");
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
    }

    public function index() {
        $ArrProfileInfo                                 = fnGetUserLoggedInfo(1);
        if($ArrProfileInfo['usertype']==1) {
            $this->load->view('dashboard');
        } else if($ArrProfileInfo['usertype']==2) {
            $this->load->view('company/dashboard');
        }
    }

}