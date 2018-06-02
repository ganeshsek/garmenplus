<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mdyeingmethod extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model("cadmin/mdyeingmodel");
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
            $ArrResults     									= $this->mdyeingmodel->fnGetDyeingMethodInfo('','',$VarUserId);
            $ArrData['ArrBasicInfo']	    				    = $ArrResults[0];
            $ArrData['VarId']					                = $ArrResults[0]['id'];
        } else {
            $ArrData['VarNew']  							    = 1;
        }
        $this->load->view('cadmin/addeditdyeingmethod',$ArrData);
    }

    public function updateDyeingInfo() {
        $ArrResult                                              = array();
        $VarMethodName				    						= xssclean($this->input->post('mn'));
        $VarStatus												= xssclean($this->input->post('s'));
        $VarId       											= xssclean($this->input->post('id'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarMethodName<>'') {
            $ArrUpdateData                                      = array('id'=>$VarId,'dyeingname'=>$VarMethodName,'status'=>$VarStatus,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
            if($VarId=='' || $VarId==0) {
                $ArrUpdateData['datecreated']                   = date('Y-m-d H:i:s');
            }
            $ArrStatus                                          = $this->mdyeingmodel->saveDyeingMethodInfo($ArrUpdateData);
            echo json_encode($ArrStatus);unset($ArrStatus);unset($ArrUpdateData);die;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = 'Invalid Input!';
        }
        echo json_encode($ArrResult);
    }

    public function managedyeingmethod() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarMethodName											= xssclean($this->input->post('mn'));
        $VarStatus  											= xssclean($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'mdyeingmethod/managedyeingmethod/';
            $config['total_rows']								= $this->mdyeingmodel->fnCountDyeingMethod($VarMethodName,$VarStatus);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrDyeingMethodList								= $this->mdyeingmodel->fnListDyeingMethod($VarMethodName,$VarStatus,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('DyeingMethod');
            $i=0;
            $ArrFnlList										    = array();
            $ArrStatus                                          = unserialize(ARRSTATUS);
            foreach ($ArrDyeingMethodList as $ObjDyeing){
                $ArrFnlList[$i]['id']						    = $ObjDyeing->id;
                $ArrFnlList[$i]['n']						    = $ObjDyeing->dyeingname;
                $ArrFnlList[$i]['ub']						    = $ObjDyeing->contactname;
                $ArrFnlList[$i]['s']						    = $ArrStatus[$ObjDyeing->status];
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjDyeing->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);
            die;
        } else {
            $this->load->view(CNFCADMIN.'/managedyeingmethod');
        }
    }

    function delDeyingMethodInfo() {
        $VarMethodId                                            = xssclean($this->input->post('id'));
        $VarUpdatedBy                                           = fnGetUserLoggedInfo();
        if($VarMethodId>=1) {
            $ArrResult             					            = $this->mdyeingmodel->fnDelDeyingMethod($VarMethodId,$VarUpdatedBy);
        } else {
            $ArrResult['errcode']						        = -1;
            $ArrResult['msg']							        = '';
        }
        echo json_encode($ArrResult);
    }

}