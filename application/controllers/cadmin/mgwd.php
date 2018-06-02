<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mgwd extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model("cadmin/mgwdmodel");
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
            $ArrResults     									= $this->mgwdmodel->fnGetGWDInfo('','',$VarUserId);
            $ArrData['ArrBasicInfo']	    				    = $ArrResults[0];
            $ArrData['VarId']					                = $ArrResults[0]['id'];
        } else {
            $ArrData['VarNew']  							    = 1;
        }
        $this->load->view(CNFCADMIN.'/addeditgwd',$ArrData);
    }

    public function updateGWDInfo() {
        $ArrResult                                              = array();
        $VarGWDName				    						    = xssclean($this->input->post('gn'));
        $VarStatus												= xssclean($this->input->post('s'));
        $VarId       											= xssclean($this->input->post('id'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarGWDName<>'') {
            $ArrUpdateData                                      = array('id'=>$VarId,'gwdname'=>$VarGWDName,'status'=>$VarStatus,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
            if($VarId=='' || $VarId==0) {
                $ArrUpdateData['datecreated']                   = date('Y-m-d H:i:s');
            }
            $ArrStatus                                          = $this->mgwdmodel->saveGWDInfo($ArrUpdateData);
            echo json_encode($ArrStatus);unset($ArrStatus);unset($ArrUpdateData);die;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = 'Invalid Input!';
        }
        echo json_encode($ArrResult);
    }

    public function managegwd() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarGWDName											    = xssclean($this->input->post('gn'));
        $VarStatus  											= xssclean($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'mgwd/managegwd/';
            $config['total_rows']								= $this->mgwdmodel->fnCountGWD($VarGWDName,$VarStatus);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrGWDList								            = $this->mgwdmodel->fnListGWD($VarGWDName,$VarStatus,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('GWD');
            $i=0;
            $ArrFnlList										    = array();
            $ArrStatus                                          = unserialize(ARRSTATUS);
            foreach ($ArrGWDList as $ObjUnit){
                $ArrFnlList[$i]['id']						    = $ObjUnit->id;
                $ArrFnlList[$i]['n']						    = $ObjUnit->gwdname;
                $ArrFnlList[$i]['ub']						    = $ObjUnit->contactname;
                $ArrFnlList[$i]['s']						    = $ArrStatus[$ObjUnit->status];
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjUnit->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);
            die;
        } else {
            $this->load->view(CNFCADMIN.'/managegwd');
        }
    }

    function delGWDInfo() {
        $VarPackingId                                         = xssclean($this->input->post('id'));
        $VarUpdatedBy                                         = fnGetUserLoggedInfo();
        if($VarPackingId>=1) {
            $ArrResult             					          = $this->mgwdmodel->fnDelGWD($VarPackingId,$VarUpdatedBy);
        } else {
            $ArrResult['errcode']						      = -1;
            $ArrResult['msg']							      = '';
        }
        echo json_encode($ArrResult);
    }

}