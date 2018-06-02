<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mastersetup extends CI_Controller {

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

    public function managedyeingmethod() {
        $this->load->view(CNFCADMIN.'managedyeingmethod');
    }

    function addeditdyeingmethod() {
        $this->load->view(CNFCADMIN.'addeditdyeingmethod');
    }

    function managefabrictype() {
        $this->load->view(CNFCADMIN.'managefabrictypes');
    }

    function addeditfacbricstype() {
        $this->load->view(CNFCADMIN.'addeditfabricstype');
    }

    function manageprinttype() {
        $this->load->view(CNFCADMIN.'manageprinttype');
    }

    function addeditprinttype() {
        $this->load->view(CNFCADMIN.'addeditprinttype');
    }

    function manageembelltype() {
        $this->load->view(CNFCADMIN.'manageembellname');
    }

    function addeditembelltype() {
        $this->load->view(CNFCADMIN.'addeditembelltype');
    }

    function manageunitmeasure() {
        $this->load->view(CNFCADMIN.'manageunitmeasure');
    }

    function addeditunitmeasure() {
        $this->load->view(CNFCADMIN.'addeditunitmeasure');
    }

    function managetrimmingtype() {
        $this->load->view(CNFCADMIN.'managetrimmingtype');
    }

    function addedittrimmingtype() {
        $this->load->view(CNFCADMIN.'addedittrimmingtype');
    }

    function managesewingtrimmingtype() {
        $this->load->view(CNFCADMIN.'managesewingtrimmingtype');
    }

    function addeditsewingtrimmingtype() {
        $this->load->view(CNFCADMIN.'addeditsewingtrimmingtype');
    }

    function manageseason() {
        $this->load->view(CNFCADMIN.'manageseason');
    }

    function addeditseason() {
        $this->load->view(CNFCADMIN.'addeditseason');
    }

    function managegarmenttype() {
        $this->load->view(CNFCADMIN.'managegarmenttype');
    }

    function addeditgarmenttype() {
        $this->load->view(CNFCADMIN.'addeditgarmenttype');
    }

    function managesizerange() {
        $this->load->view(CNFCADMIN.'managesizerange');
    }

    function addeditsizerange() {
        $this->load->view(CNFCADMIN.'addeditsizerange');
    }

    function managepackingcode() {
        $this->load->view(CNFCADMIN.'managepackingcode');
    }

    function addeditpackingcode() {
        $this->load->view(CNFCADMIN.'addeditpackingcode');
    }

    function managedsr() {
        $this->load->view(CNFCADMIN.'managedsr');
    }

    function addeditdsr() {
        $this->load->view(CNFCADMIN.'addeditdsr');
    }

    function managewpg() {
        $this->load->view(CNFCADMIN.'managewpg');
    }

    function addeditwpg() {
        $this->load->view(CNFCADMIN.'addeditwpg');
    }

    function managedpf() {
        $this->load->view(CNFCADMIN.'managedpf');
    }

    function addeditdpf() {
        $this->load->view(CNFCADMIN.'addeditdpf');
    }

    function managefwd() {
        $this->load->view(CNFCADMIN.'managefwd');
    }

    function addeditfwd() {
        $this->load->view(CNFCADMIN.'addeditfwd');
    }

    function managegwd() {
        $this->load->view(CNFCADMIN.'managegwd');
    }

    function addeditgwd() {
        $this->load->view(CNFCADMIN.'addeditgwd');
    }

    function manageprocessflow() {
        $this->load->view(CNFCADMIN.'manageprocessflow');
    }

    function addeditprocessflow() {
        $this->load->view(CNFCADMIN.'addeditprocessflow');
    }

    function manageapproval() {
        $this->load->view(CNFCADMIN.'manageapproval');
    }

    function addeditapproval() {
        $this->load->view(CNFCADMIN.'addeditapproval');
    }

    function managelab() {
        $this->load->view(CNFCADMIN.'managelab');
    }

    function addeditlab() {
        $this->load->view(CNFCADMIN.'addeditlab');
    }

    function managecategory() {
        $this->load->view(CNFCADMIN.'managecategory');
    }

    function addeditcategory() {
        $this->load->view(CNFCADMIN.'addeditcategory');
    }

    function manageport() {
        $this->load->view(CNFCADMIN.'manageport');
    }

    function addeditport() {
        $this->load->view(CNFCADMIN.'addeditport');
    }

}