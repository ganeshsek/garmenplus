<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class schools extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        $this->load->model("schoolmodel");
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        fnIfCheckUserLoggedIn();
    }

    public function manageschools() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarSchoolName											= xssclean($this->input->post('sn'));
        $VarUserType											= 2;
        $VarProfileStatus										= (xssclean($this->input->post('s'))=='')?array(1):array($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 3;
            $this->load->library('pagination');
            $config['base_url']									= base_url().'schools/manageschools/';
            $config['total_rows']								= $this->schoolmodel->fnCountSchools($VarName,$VarEmail,$VarMobile,$VarSchoolName,$VarProfileStatus,$VarUserType);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrEmployeeList									= $this->schoolmodel->fnListSchools($VarName,$VarEmail,$VarMobile,$VarSchoolName,$VarProfileStatus,$VarUserType,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('Schools');
            $i=0;
            $ArrFnlSchoolList									= array();
            $ArrStatus											= unserialize(ARRSTATUS);
            $ArrProfilePermissionInfo   						= unserialize(ARRPROFILEPERMISSION);
            foreach ($ArrEmployeeList as $ObjEmployeeInfo){
                $ArrFnlSchoolList[$i]['id']						= $ObjEmployeeInfo->id;
                //$ArrFnlSchoolList[$i]['pp']						= $ArrProfilePermissionInfo[$ObjEmployeeInfo->profilepermission];
                $ArrFnlSchoolList[$i]['n']						= $ObjEmployeeInfo->contactname;
                $ArrFnlSchoolList[$i]['e']						= $ObjEmployeeInfo->emailid;
                $ArrFnlSchoolList[$i]['un']						= $ObjEmployeeInfo->username;
                $ArrFnlSchoolList[$i]['p']					    = base64_decode($ObjEmployeeInfo->password);
                $ArrFnlSchoolList[$i]['m']						= $ObjEmployeeInfo->phoneno;
                $ArrFnlSchoolList[$i]['sn']						= $ObjEmployeeInfo->schoolname;
                $ArrFnlSchoolList[$i]['du']						= date('d-m-Y H:i:s',strtotime($ObjEmployeeInfo->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlSchoolList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlSchoolList);
            die;
        } else {
            $this->load->view('manageschool');
        }
    }

    public function addeditschools() {
        $ArrData												= array('ArrSchoolBasicInfo'=>array(),'VarUserId'=>'','VarNewSchool'=>0);
        $VarSchoolId										    = $this->uri->segment(3);
        if($VarSchoolId<>'' && base64_decode(urldecode($VarSchoolId))) {
            $VarSchoolId                                        = base64_decode(urldecode($VarSchoolId));
            $ArrEmployeeInfo									= $this->schoolmodel->fnGetSchoolInfo($VarSchoolId);
            $ArrData['ArrSchoolBasicInfo']					    = $ArrEmployeeInfo[0];
            $ArrData['VarSchoolId']					            = $ArrEmployeeInfo[0]['id'];
        } else {
            $ArrData['VarNewSchool']							    = 1;
        }
        $this->load->view('addeditschools',$ArrData);
    }

    public function updateSchool() {
        $VarMsg													= '';
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarSchoolName 											= xssclean($this->input->post('sn'));
        $VarPhone												= xssclean($this->input->post('ph'));
        $VarUsername											= xssclean($this->input->post('un'));
        $VarMailPassword  										= xssclean($this->input->post('p'));
        $VarSchoolId  											= xssclean($this->input->post('id'));

        $VarPassword                                            = base64_encode($VarMailPassword);
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarSchoolId=="") {
            $CheckEmailExist								    = $this->schoolmodel->fnCheckUser('','','','',$VarEmail);
            if($CheckEmailExist==0) {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'emailid'=>$VarEmail,'password'=>$VarPassword,'phoneno'=>$VarPhone,'schoolname'=>$VarSchoolName,'updatedby'=>$VarUpdatedBy,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'username'=>$VarUsername,'usertype'=>2);
                $VarSchoolId										= $this->schoolmodel->fnSaveUser($ArrEmpProfileDetails);
            } else {
                $VarMsg											= "This Email ID already exists!!";
            }
            if($VarSchoolId) {
                $VarDomainName                                  = APPDOMAINNAME;
                $ArrEmailReplaceArgs							= array("##NAME##"=>$VarName,"##DOMAINNAME##"=>$VarDomainName,"##USERNAME##"=>$VarEmail,"##PASSWORD##"=>$VarMailPassword,"##DOMAINURL##"=>base_url(),"##COMPANYNAME##"=>$VarDomainName);
                if(SendEmail($VarDomainName,'Welcome to '.$VarDomainName,'UserLoginDetails',$ArrEmailReplaceArgs)) {
                    $ArrResult['errcode']						= 1;
                    $ArrResult['msg']							= 'User Details has been added successfully!';
                    $ArrResult['uid']							= $VarSchoolId;
                    $ArrResult['euid']							= urlencode(base64_encode($VarSchoolId));
                }
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= $VarMsg;
            }
        } else {
            $ArrEmpProfileDetails							    = array('contactname'=>$VarName,'emailid'=>$VarEmail,'phoneno'=>$VarPhone,'schoolname'=>$VarSchoolName,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'usertype'=>2);
            $VarUpdateEmpInfo								    = $this->schoolmodel->fnUpdateUser($ArrEmpProfileDetails,$VarSchoolId);
            if($VarUpdateEmpInfo) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'School Details has been updated successfully!';
                $ArrResult['uid']							    = $VarSchoolId;
                $ArrResult['euid']							    = urlencode(base64_encode($VarSchoolId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= '';
            }
        }
        echo json_encode($ArrResult);
    }


}
?>