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
        $this->load->view(CNFCOMPANY.'managedyeingmethod');
    }

    function addeditdyeingmethod() {
        $this->load->view(CNFCOMPANY.'addeditdyeingmethod');
    }

    function managefabrictype() {
        $this->load->view(CNFCOMPANY.'managefabrictypes');
    }

    function addeditfacbricstype() {
        $this->load->view(CNFCOMPANY.'addeditfabricstype');
    }

    function manageprinttype() {
        $this->load->view(CNFCOMPANY.'manageprinttype');
    }

    function addeditprinttype() {
        $this->load->view(CNFCOMPANY.'addeditprinttype');
    }

    function manageembelltype() {
        $this->load->view(CNFCOMPANY.'manageembellname');
    }

    function addeditembelltype() {
        $this->load->view(CNFCOMPANY.'addeditembelltype');
    }

    function manageunitmeasure() {
        $this->load->view(CNFCOMPANY.'manageunitmeasure');
    }

    function addeditunitmeasure() {
        $this->load->view(CNFCOMPANY.'addeditunitmeasure');
    }

    function managetrimmingtype() {
        $this->load->view(CNFCOMPANY.'managetrimmingtype');
    }

    function addedittrimmingtype() {
        $this->load->view(CNFCOMPANY.'addedittrimmingtype');
    }

    function managesewingtrimmingtype() {
        $this->load->view(CNFCOMPANY.'managesewingtrimmingtype');
    }

    function addeditsewingtrimmingtype() {
        $this->load->view(CNFCOMPANY.'addeditsewingtrimmingtype');
    }

    function manageseason() {
        $this->load->view(CNFCOMPANY.'manageseason');
    }

    function addeditseason() {
        $this->load->view(CNFCOMPANY.'addeditseason');
    }

    function managegarmenttype() {
        $this->load->view(CNFCOMPANY.'managegarmenttype');
    }

    function addeditgarmenttype() {
        $this->load->view(CNFCOMPANY.'addeditgarmenttype');
    }

    function managesizerange() {
        $this->load->view(CNFCOMPANY.'managesizerange');
    }

    function addeditsizerange() {
        $this->load->view(CNFCOMPANY.'addeditsizerange');
    }

    function managepackingcode() {
        $this->load->view(CNFCOMPANY.'managepackingcode');
    }

    function addeditpackingcode() {
        $this->load->view(CNFCOMPANY.'addeditpackingcode');
    }

    function managedsr() {
        $this->load->view(CNFCOMPANY.'managedsr');
    }

    function addeditdsr() {
        $this->load->view(CNFCOMPANY.'addeditdsr');
    }

    function managewpg() {
        $this->load->view(CNFCOMPANY.'managewpg');
    }

    function addeditwpg() {
        $this->load->view(CNFCOMPANY.'addeditwpg');
    }

    function managedpf() {
        $this->load->view(CNFCOMPANY.'managedpf');
    }

    function addeditdpf() {
        $this->load->view(CNFCOMPANY.'addeditdpf');
    }

    function managefwd() {
        $this->load->view(CNFCOMPANY.'managefwd');
    }

    function addeditfwd() {
        $this->load->view(CNFCOMPANY.'addeditfwd');
    }

    function managegwd() {
        $this->load->view(CNFCOMPANY.'managegwd');
    }

    function addeditgwd() {
        $this->load->view(CNFCOMPANY.'addeditgwd');
    }

    function manageprocessflow() {
        $this->load->view(CNFCOMPANY.'manageprocessflow');
    }

    function addeditprocessflow() {
        $this->load->view(CNFCOMPANY.'addeditprocessflow');
    }

    function manageapproval() {
        $this->load->view(CNFCOMPANY.'manageapproval');
    }

    function addeditapproval() {
        $this->load->view(CNFCOMPANY.'addeditapproval');
    }

    function managelab() {
        $this->load->view(CNFCOMPANY.'managelab');
    }

    function addeditlab() {
        $this->load->view(CNFCOMPANY.'addeditlab');
    }

    function managecategory() {
        $this->load->view(CNFCOMPANY.'managecategory');
    }

    function addeditcategory() {
        $this->load->view(CNFCOMPANY.'addeditcategory');
    }

    function manageport() {
        $this->load->view(CNFCOMPANY.'manageport');
    }

    function addeditport() {
        $this->load->view(CNFCOMPANY.'addeditport');
    }

    function managemerchant() {
        $this->load->view(CNFCOMPANY.'managemerchant');
    }

    function addeditmerchant() {
        $this->load->view(CNFCOMPANY.'addeditmerchant');
    }

    function managedepartment() {
        $this->load->view(CNFCOMPANY.'managedepartment');
    }

    function addeditdepartment() {
        $this->load->view(CNFCOMPANY.'addeditdepartment');
    }

    function manageclass() {
        $this->load->view(CNFCOMPANY.'manageclass');
    }

    function addeditclass() {
        $this->load->view(CNFCOMPANY.'addeditclass');
    }

    function managecontent() {
        $this->load->view(CNFCOMPANY.'managecontent');
    }

    function addeditcontent() {
        $this->load->view(CNFCOMPANY.'addeditcontent');
    }

    function managegpd() {
        $this->load->view(CNFCOMPANY.'managegpd');
    }

    function addeditgpd() {
        $this->load->view(CNFCOMPANY.'addeditgpd');
    }

    function manageaccessories() {
        $this->load->view(CNFCOMPANY.'manageaccessories');
    }

    function addeditaccessories() {
        $this->load->view(CNFCOMPANY.'addeditaccessories');
    }

    function managepackingmaterial() {
        $this->load->view(CNFCOMPANY.'managepackingmeatrial');
    }

    function addeditpackingmaterial() {
        $this->load->view(CNFCOMPANY.'addeditpackingmaterial');
    }

}