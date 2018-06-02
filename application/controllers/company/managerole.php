<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class managerole extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        fnIfCheckUserLoggedIn();
    }

    public function manageroles() {
        $this->load->view(CNFCOMPANY.'manageroles');
    }

    public function addeditrole() {
        $this->load->view(CNFCOMPANY.'addeditrole');
    }

}