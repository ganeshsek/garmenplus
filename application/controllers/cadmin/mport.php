<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mport extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model("cadmin/mportmodel");
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        fnIfCheckUserLoggedIn();
    }

    public function addedit() {
        $ArrData												= array('ArrBasicInfo'=>array(),'VarId'=>'','VarNew'=>0);
        $VarId		    									    = $this->uri->segment(4);
        if($VarId<>'' && base64_decode(urldecode($VarId))) {
            $VarUserId                                          = base64_decode(urldecode($VarId));
            $ArrResults     									= $this->mportmodel->fnGetPortInfo('','',$VarUserId);
            $ArrData['ArrBasicInfo']	    				    = $ArrResults[0];
            $ArrData['VarId']					                = $ArrResults[0]['id'];
        } else {
            $ArrData['VarNew']  							    = 1;
        }
        $this->load->view(CNFCADMIN.'/addeditport',$ArrData);
    }

    public function updatePortInfo() {
        $ArrResult                                              = array();
        $VarPortName				    						= xssclean($this->input->post('pn'));
        $VarPortAddress				    						= xssclean($this->input->post('pa'));
        $VarPortCity				    						= xssclean($this->input->post('pc'));
        $VarPortState				    						= xssclean($this->input->post('ps'));
        $VarPortCountry				    						= xssclean($this->input->post('pcntry'));
        $VarStatus												= xssclean($this->input->post('s'));
        $VarId       											= xssclean($this->input->post('id'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarPortName<>'') {
            $ArrUpdateData                                      = array('id'=>$VarId,'portname'=>$VarPortName,'portaddress'=>$VarPortAddress,'portcity'=>$VarPortCity,'portstate'=>$VarPortState,'portcountry'=>$VarPortCountry,'status'=>$VarStatus,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
            if($VarId=='' || $VarId==0) {
                $ArrUpdateData['datecreated']                   = date('Y-m-d H:i:s');
            }
            $ArrStatus                                          = $this->mportmodel->savePortInfo($ArrUpdateData);
            echo json_encode($ArrStatus);unset($ArrStatus);unset($ArrUpdateData);die;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = 'Invalid Input!';
        }
        echo json_encode($ArrResult);
    }

    public function manageport() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarPortName											= xssclean($this->input->post('pn'));
        $VarPortAddress											= xssclean($this->input->post('pa'));
        $VarPortCity											= xssclean($this->input->post('pc'));
        $VarPortCountry											= xssclean($this->input->post('pcntry'));
        $VarStatus  											= xssclean($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'mport/manageport/';
            $config['total_rows']								= $this->mportmodel->fnCountPort($VarPortName,$VarPortAddress,$VarPortCity,$VarPortCountry,$VarStatus);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrPortList								        = $this->mportmodel->fnListPort($VarPortName,$VarPortAddress,$VarPortCity,$VarPortCountry,$VarStatus,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('Port');
            $i=0;
            $ArrFnlList										    = array();
            $ArrStatus                                          = unserialize(ARRSTATUS);
            $ArrCountryList                                     = unserialize(ARRCOUNTRYLIST);
            foreach ($ArrPortList as $ObjPort){
                $ArrFnlList[$i]['id']						    = $ObjPort->id;
                $ArrFnlList[$i]['pn']						    = $ObjPort->portname;
                $ArrFnlList[$i]['pc']						    = $ObjPort->portcity;
                $ArrFnlList[$i]['pa']						    = $ObjPort->portaddress;
                $ArrFnlList[$i]['pcntry']					    = $ArrCountryList[$ObjPort->portcountry];
                $ArrFnlList[$i]['ub']						    = $ObjPort->contactname;
                $ArrFnlList[$i]['s']						    = $ArrStatus[$ObjPort->status];
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjPort->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);
            die;
        } else {
            $this->load->view(CNFCADMIN.'/manageport');
        }
    }

    function delPortInfo() {
        $VarPortId                                            = xssclean($this->input->post('id'));
        $VarUpdatedBy                                         = fnGetUserLoggedInfo();
        if($VarPortId>=1) {
            $ArrResult             					          = $this->mportmodel->fnDelPort($VarPortId,$VarUpdatedBy);
        } else {
            $ArrResult['errcode']						      = -1;
            $ArrResult['msg']							      = '';
        }
        echo json_encode($ArrResult);
    }

}