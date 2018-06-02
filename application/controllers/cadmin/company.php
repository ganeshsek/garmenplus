<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        $this->load->model('cadmin/companymodel');
        fnIfCheckUserLoggedIn();
    }

    public function managecompany() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarCompanyName											= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarPhoneNo												= xssclean($this->input->post('p'));
        $VarCountry 											= xssclean($this->input->post('ctry'));
        $VarCity     											= xssclean($this->input->post('c'));
        $VarState     											= xssclean($this->input->post('s'));
        $VarBusinessType										= xssclean($this->input->post('bt'));
        $VarContactName 										= xssclean($this->input->post('cn'));
        $VarCompanyStatus										= (xssclean($this->input->post('s'))=='')?array(1):array($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 3;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'/company/managecompany/';
            $config['total_rows']								= $this->companymodel->fnCountCompany($VarCompanyName,$VarEmail,$VarMobile,$VarCountry,$VarCity,$VarPhoneNo,$VarState,$VarCompanyStatus,$VarBusinessType,$VarContactName);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "companyname";
            $sortorder											= "asc";
            $ArrCompanyList									    = $this->companymodel->fnListCompany($VarCompanyName,$VarEmail,$VarMobile,$VarCountry,$VarCity,$VarPhoneNo,$VarState,$VarCompanyStatus,$VarBusinessType,$VarContactName,$this->limit,$offset,$sortby,$sortorder)->result();

            $data['pagination']									= $this->pagination->create_linkswithajax('Company');
            $i=0;
            $ArrFnlList										    = array();
            $ArrCountryList                						= unserialize(ARRCOUNTRYLIST);
            $ArrBusinessType                					= unserialize(ARRCOMPANYBUSINESSTYPE);
            $ArrFactoryOwnership              					= unserialize(ARRCOMPANYFACTORYOWNERSHIP);

            foreach ($ArrCompanyList as $ObjCompanyInfo){
                $ArrFnlList[$i]['id']						    = $ObjCompanyInfo->id;
                $ArrFnlList[$i]['ctn']						    = $ArrCountryList[$ObjCompanyInfo->country];
                $ArrFnlList[$i]['n']	    					= $ObjCompanyInfo->companyname;
                $ArrFnlList[$i]['u']						    = $ObjCompanyInfo->username;
                $ArrFnlList[$i]['p']							= base64_decode($ObjCompanyInfo->password);
                $ArrFnlList[$i]['bt']							= $ArrBusinessType[$ObjCompanyInfo->businesstype];
                $ArrFnlList[$i]['fo']					        = $ArrFactoryOwnership[$ObjCompanyInfo->factoryownership];
                $ArrFnlList[$i]['c']					        = $ObjCompanyInfo->city;
                $ArrFnlList[$i]['s']					        = $ObjCompanyInfo->state;
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjCompanyInfo->dateupdated));
                //$ArrCustomerList[]  					        = $ObjCompanyInfo->customerid;
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);die;
        } else {
            $this->load->view(CNFCADMIN.'managecompany');
        }
    }

    public function addeditcompany() {
        $ArrData												= array('ArrFactoryBasicInfo'=>array(),'VarFactoryId'=>'','VarNewFactory'=>0);
        $VarCompanyId											= $this->uri->segment(4);
        if($VarCompanyId<>'') {
            $VarCompanyId                                       = base64_decode(urldecode($VarCompanyId));
            $ArrCompanyInfo		    							= $this->companymodel->fnGetCompanyInfo($VarCompanyId);
            $ArrData['ArrCompanyBasicInfo']					    = $ArrCompanyInfo[0];
            $ArrData['VarCompanyId']				            = $ArrCompanyInfo[0]['id'];
        } else {
            $ArrData['VarNewCompany']							= 1;
        }
        $VarRedirectAddress										= $this->uri->segment(5);
        $ArrData['VarRedirectAddress']							= $VarRedirectAddress;
        $this->load->view(CNFCADMIN.'addeditcompany',$ArrData);
    }

    public function updateCompanyBasicInfo() {
        $VarMsg													= '';
        $VarProductCapacity										= xssclean($this->input->post('pc'));
        $VarTurnOver    										= xssclean($this->input->post('to'));
        $VarNumberOfEmployee									= xssclean($this->input->post('ne'));
        $VarZipCode     										= xssclean($this->input->post('zc'));
        $VarContractWorker   									= xssclean($this->input->post('cw'));
        $VarOwnershipFactory									= xssclean($this->input->post('of'));
        $VarMajorCustomer   									= xssclean($this->input->post('mc'));
        $VarExportCustomer										= xssclean($this->input->post('ec'));
        $VarCompanyProfile										= xssclean($this->input->post('cp'));
        $VarCompanyId   										= xssclean($this->input->post('cid'));
        $VarCompanyName 										= xssclean($this->input->post('cn'));
        $VarBusinessType										= xssclean($this->input->post('bt'));
        $VarFactorySize											= xssclean($this->input->post('fz'));
        $VarAddress     										= xssclean($this->input->post('a'));
        $VarNumberOfMachine 									= xssclean($this->input->post('nm'));
        $VarCity      											= xssclean($this->input->post('c'));
        $VarState    											= xssclean($this->input->post('s'));
        $VarCountry 											= xssclean($this->input->post('ctry'));
        $VarUpdatedBy                                           = fnGetUserLoggedInfo();
        if($VarCompanyId=="") {
            $ArrCompanyDetails  						        = array('status'=>1,'companyname'=>$VarCompanyName,'productioncapacity'=>$VarProductCapacity,'annualturnover'=>$VarTurnOver,'noofemployee'=>$VarNumberOfEmployee,'zipcode'=>$VarZipCode,'noofcontract'=>$VarContractWorker,'factoryownership'=>$VarOwnershipFactory,'majorcustomer'=>$VarMajorCustomer,'exportcustomer'=>$VarExportCustomer,'businesstype'=>$VarBusinessType,'factorysize'=>$VarFactorySize,'address'=>$VarAddress,'noofmachine'=>$VarNumberOfMachine,'city'=>$VarCity,'state'=>$VarState,'updatedby'=>$VarUpdatedBy,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'country'=>$VarCountry,'companyprofile'=>$VarCompanyProfile);
            $VarCompanyId       							    = $this->companymodel->fnSaveCompanyInfo($ArrCompanyDetails);
            if($VarCompanyId) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Company Details has been added successfully!';
                $ArrResult['cid']							    = $VarCompanyId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarCompanyId));

            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= $VarMsg;
            }
        } else {
            $ArrCompanyDetails  						        = array('companyname'=>$VarCompanyName,'productioncapacity'=>$VarProductCapacity,'annualturnover'=>$VarTurnOver,'noofemployee'=>$VarNumberOfEmployee,'zipcode'=>$VarZipCode,'noofcontract'=>$VarContractWorker,'factoryownership'=>$VarOwnershipFactory,'majorcustomer'=>$VarMajorCustomer,'exportcustomer'=>$VarExportCustomer,'businesstype'=>$VarBusinessType,'factorysize'=>$VarFactorySize,'address'=>$VarAddress,'noofmachine'=>$VarNumberOfMachine,'city'=>$VarCity,'state'=>$VarState,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'country'=>$VarCountry,'companyprofile'=>$VarCompanyProfile);
            $VarUpdateCompanyInfo								= $this->companymodel->fnUpdateCompanyBasicInfo($ArrCompanyDetails,$VarCompanyId);
            if($VarUpdateCompanyInfo) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Company Details has been updated successfully!';
                $ArrResult['cid']							    = $VarCompanyId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarCompanyId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= '';
            }
        }
        echo json_encode($ArrResult);
    }

    function updateCompanyContactInfo() {
        $VarMsg													= '';
        $VarContactName     									= xssclean($this->input->post('cn'));
        $VarContactEmail   										= xssclean($this->input->post('ce'));
        $VarContactDesignation									= xssclean($this->input->post('cd'));
        $VarContactPhone       									= xssclean($this->input->post('cp'));
        $VarContactId  											= xssclean($this->input->post('id'));
        $VarContactMobile										= xssclean($this->input->post('cm'));
        $VarCompanyId  											= xssclean($this->input->post('cid'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarContactId=='') {
            $ArrCompanyDetails							        = array('status'=>1,'contactname'=>$VarContactName,'contactemail'=>$VarContactEmail,'contactphone'=>$VarContactPhone,'contactmobile'=>$VarContactMobile,'companyid'=>$VarCompanyId,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'datecreated'=>date('Y-m-d H:i:s'),'contactdesignation'=>$VarContactDesignation);
            $VarUpdateFactory							        = $this->companymodel->fnSaveCompanyContactInfo($ArrCompanyDetails);
        } else if($VarContactId>=1) {
            $ArrCompanyDetails							        = array('status'=>1,'contactname'=>$VarContactName,'contactemail'=>$VarContactEmail,'contactphone'=>$VarContactPhone,'contactmobile'=>$VarContactMobile,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'contactdesignation'=>$VarContactDesignation);
            $VarUpdateFactory								    = $this->companymodel->fnUpdateCompanyContactInfo($ArrCompanyDetails,$VarContactId);
        }
        if($VarUpdateFactory) {
            $ArrResult['errcode']							    = 1;
            $ArrResult['msg']								    = 'Company Contact Details has been updated at successfully!';
            $ArrResult['cid']							        = $VarContactId;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = $VarMsg;
        }
        echo json_encode($ArrResult);
    }

    public function managecompanycontact() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarCompanyId  										    = xssclean($this->input->post('cid'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'/company/managecompanycontact/';
            $config['total_rows']								= $this->companymodel->fnCountCompanyContact($VarCompanyId);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrContactList								        = $this->companymodel->fnListCompanyContact($VarCompanyId,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('CompanyContact');
            $i=0;
            $ArrFnlList										    = array();
            foreach ($ArrContactList as $ObjContactInfo){
                $ArrFnlList[$i]['id']						    = $ObjContactInfo->id;
                $ArrFnlList[$i]['cn']					        = $ObjContactInfo->contactname;
                $ArrFnlList[$i]['e']					        = $ObjContactInfo->contactemail;
                $ArrFnlList[$i]['m']					        = $ObjContactInfo->contactmobile;
                $ArrFnlList[$i]['p']					        = $ObjContactInfo->contactphone;
                $ArrFnlList[$i]['d']					        = $ObjContactInfo->contactdesignation;
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjContactInfo->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);die;
        }
    }

    public function getcompanycontactInfo() {
        $VarCompanyId 											= xssclean($this->input->post('cid'));
        $VarContactId 											= xssclean($this->input->post('id'));
        $ArrContactInfo		    							    = $this->companymodel->fnGetCompanyContactInfo($VarCompanyId,$VarContactId);
        $ArrFinalInfo                                           = array();
        if(count($ArrContactInfo)>=1){
            $ArrFinalInfo['errcode']                            = 1;
            $ArrFinalInfo['n']                                 = $ArrContactInfo[0]['contactname'];
            $ArrFinalInfo['e']                                  = $ArrContactInfo[0]['contactemail'];
            $ArrFinalInfo['p']                                  = $ArrContactInfo[0]['contactphone'];
            $ArrFinalInfo['d']                                  = $ArrContactInfo[0]['contactdesignation'];
            $ArrFinalInfo['m']                                  = $ArrContactInfo[0]['contactmobile'];
        } else {
            $ArrFinalInfo['errcode']                               = '-1';
        }
        echo json_encode($ArrFinalInfo);
    }


    function updateCompanyMachineInfo() {
        $VarMsg													= '';
        $VarMachineFlag     									= xssclean($this->input->post('mf'));
        $VarMachineType     									= xssclean($this->input->post('mt'));
        $VarTableType     									    = xssclean($this->input->post('tt'));
        $VarNumberOfMachine										= xssclean($this->input->post('mc'));
        $VarMachineId  											= xssclean($this->input->post('id'));
        $VarCompanyId  											= xssclean($this->input->post('cid'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarMachineFlag==1) {
            $VarTypeValue                                       = $VarMachineType;
        } else if($VarMachineFlag==2) {
            $VarTypeValue                                       = $VarTableType;
        }
        if($VarMachineId=='') {
            $ArrCompanyDetails							        = array('status'=>1,'machineflag'=>$VarMachineFlag,'machinetype'=>$VarTypeValue,'numberofmachine'=>$VarNumberOfMachine,'companyid'=>$VarCompanyId,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'datecreated'=>date('Y-m-d H:i:s'));
            $VarUpdateMachine							        = $this->companymodel->fnSaveCompanyMachineInfo($ArrCompanyDetails);
        } else if($VarMachineId>=1) {
            $ArrCompanyDetails							        = array('machineflag'=>$VarMachineFlag,'machinetype'=>$VarTypeValue,'numberofmachine'=>$VarNumberOfMachine,'companyid'=>$VarCompanyId,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
            $VarUpdateMachine								    = $this->companymodel->fnUpdateCompanyMachineInfo($ArrCompanyDetails,$VarMachineId);
        }
        if($VarUpdateMachine) {
            $ArrResult['errcode']							    = 1;
            $ArrResult['msg']								    = 'Company Machine Details has been updated at successfully!';
            $ArrResult['cid']							        = $VarCompanyId;
        } else {
            $ArrResult['errcode']							    = '-1';
            $ArrResult['msg']								    = $VarMsg;
        }
        echo json_encode($ArrResult);
    }

    public function managecompanymachine() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarCompanyId  										    = xssclean($this->input->post('cid'));
        if($VarFrom==1) {
            $VarURLSegment										= 4;
            $this->load->library('pagination');
            $config['base_url']									= base_url().CNFCADMIN.'/company/managecompanymachine/';
            $config['total_rows']								= $this->companymodel->fnCountCompanyMachine($VarCompanyId);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrMachineList								        = $this->companymodel->fnListCompanyMachine($VarCompanyId,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('CompanyMachine');
            $i=0;
            $ArrFnlList										    = array();
            $ArrCompanyMachine              					= unserialize(ARRCOMPANYMACHINEPLANTTYPE);
            $ArrMachineType                                     = unserialize(ARRCOMPANYMACHINETYPE);
            $ArrTableType                                       = unserialize(ARRCOMPANYTABLETYPE);
            foreach ($ArrMachineList as $ObjMachineInfo){
                $ArrFnlList[$i]['id']						    = $ObjMachineInfo->id;
                $ArrFnlList[$i]['mf']					        = $ArrCompanyMachine[$ObjMachineInfo->machineflag];
                if($ObjMachineInfo->machinetype==1) {
                    $ArrFnlList[$i]['mt']					    = $ArrMachineType[$ObjMachineInfo->machinetype];
                } else {
                    $ArrFnlList[$i]['mt']					    = $ArrTableType[$ObjMachineInfo->machinetype];
                }


                $ArrFnlList[$i]['mfid']					        = $ObjMachineInfo->machineflag;
                $ArrFnlList[$i]['c']					        = $ObjMachineInfo->numberofmachine;
                $ArrFnlList[$i]['du']						    = date('d-m-Y H:i:s',strtotime($ObjMachineInfo->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlList);die;
        }
    }

    public function getcompanymachineInfo() {
        $VarCompanyId 											= xssclean($this->input->post('cid'));
        $VarMachineId 											= xssclean($this->input->post('id'));
        $ArrContactInfo		    							    = $this->companymodel->fnGetCompanyMachineInfo($VarCompanyId,$VarMachineId);
        $ArrFinalInfo                                           = array();
        if(count($ArrContactInfo)>=1){
            $ArrFinalInfo['errcode']                            = 1;
            $ArrFinalInfo['mf']                                 = $ArrContactInfo[0]['machineflag'];
            $ArrFinalInfo['mt']                                 = $ArrContactInfo[0]['machinetype'];
            $ArrFinalInfo['nom']                                = $ArrContactInfo[0]['numberofmachine'];
        } else {
            $ArrFinalInfo['errcode']                               = '-1';
        }
        echo json_encode($ArrFinalInfo);
    }

}
?>