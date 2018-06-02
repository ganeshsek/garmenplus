<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class membelltype extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(CNFCOMPANY."/membellmodel");
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
            $ArrResults     									= $this->membellmodel->fnGetEmbellTypeInfo('','',$VarUserId);
            $ArrData['ArrBasicInfo']	    				    = $ArrResults[0];
            $ArrData['VarId']					                = $ArrResults[0]['id'];
        } else {
            $ArrData['VarNew']  							    = 1;
        }
        $this->load->view(CNFCOMPANY.'/addeditembelltype',$ArrData);
    }

    public function updateEmbellInfo() {
        $ArrResult                                              = array();
        $VarEmbellName				    						= xssclean($this->input->post('en'));
        $VarStatus												= xssclean($this->input->post('s'));
        $VarId       											= xssclean($this->input->post('id'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarEmbellName<>'') {
            $ArrUpdateData                                      = array('id'=>$VarId,'embellname'=>$VarEmbellName,'status'=>$VarStatus,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
            if($VarId=='' || $VarId==0) {
                $ArrUpdateData['datecreated']                   = date('Y-m-d H:i:s');
            }
            $ArrStatus                                          = $this->membellmodel->saveEmbellTypeInfo($ArrUpdateData);
            echo json_encode($ArrStatus);unset($ArrStatus);unset($ArrUpdateData);die;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = 'Invalid Input!';
        }
        echo json_encode($ArrResult);
    }

    public function manageembelltype() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarEmbellName											= xssclean($this->input->post('en'));
        $VarStatus  											= xssclean($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCOMPANY.'membelltype/manageembelltype/';
            $config['total_rows']								= $this->membellmodel->fnCountEmbellType($VarEmbellName,$VarStatus);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrEmbellTypeList								    = $this->membellmodel->fnListEmbellType($VarEmbellName,$VarStatus,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('EmbellType');
            $i=0;
            $ArrFnlList										    = array();
            $ArrStatus                                          = unserialize(ARRSTATUS);
            foreach ($ArrEmbellTypeList as $ObjEmbell){
                $ArrFnlList[$i]['id']						    = $ObjEmbell->id;
                $ArrFnlList[$i]['n']						    = $ObjEmbell->embellname;
                $ArrFnlList[$i]['ub']						    = $ObjEmbell->contactname;
                $ArrFnlList[$i]['s']						    = $ArrStatus[$ObjEmbell->status];
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjEmbell->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);
            die;
        } else {
            $this->load->view(CNFCOMPANY.'/manageembelltype');
        }
    }

    function delEmbellTypeInfo() {
        $VarEmbellId                                            = xssclean($this->input->post('id'));
        $VarUpdatedBy                                           = fnGetUserLoggedInfo();
        if($VarEmbellId>=1) {
            $ArrResult             					            = $this->membellmodel->fnDelEmbellType($VarEmbellId,$VarUpdatedBy);
        } else {
            $ArrResult['errcode']						        = -1;
            $ArrResult['msg']							        = '';
        }
        echo json_encode($ArrResult);
    }

}