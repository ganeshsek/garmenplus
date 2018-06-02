<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller {

    private $limit = 10;
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        $this->load->model("profilemodel");
        $this->load->helper('cookie');
        $this->load->helper('xssclean');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        fnIfCheckUserLoggedIn();
    }

    public function manageemployee() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarProfileRole											= xssclean($this->input->post('pp'));
        $VarUserType											= 1;
        $VarProfileStatus										= (xssclean($this->input->post('s'))=='')?array(1):array($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 3;
            $this->load->library('pagination');
            $config['base_url']									= base_url().'profile/manageemployee/';
            $config['total_rows']								= $this->profilemodel->fnCountEmployee($VarName,$VarEmail,$VarMobile,$VarProfileRole,$VarProfileStatus,$VarUserType);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrEmployeeList									= $this->profilemodel->fnListEmployee($VarName,$VarEmail,$VarMobile,$VarProfileRole,$VarProfileStatus,$VarUserType,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('Employee');
            $i=0;
            $ArrFnlEmpList										= array();
            $ArrStatus											= unserialize(ARRSTATUS);
            $ArrProfilePermissionInfo   						= unserialize(ARRPROFILEPERMISSION);
            foreach ($ArrEmployeeList as $ObjEmployeeInfo){
                $ArrFnlEmpList[$i]['id']						= $ObjEmployeeInfo->id;
                $ArrFnlEmpList[$i]['pp']						= $ArrProfilePermissionInfo[$ObjEmployeeInfo->profilepermission];
                $ArrFnlEmpList[$i]['n']							= $ObjEmployeeInfo->contactname;
                $ArrFnlEmpList[$i]['e']							= $ObjEmployeeInfo->emailid;
                $ArrFnlEmpList[$i]['p']						    = base64_decode($ObjEmployeeInfo->password);
                $ArrFnlEmpList[$i]['m']							= $ObjEmployeeInfo->mobileno;
                $ArrFnlEmpList[$i]['d']							= $ObjEmployeeInfo->designation;
                $ArrFnlEmpList[$i]['du']						= date('d-m-Y H:i:s',strtotime($ObjEmployeeInfo->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlEmpList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlEmpList);
            die;
        } else {
            $this->load->view('manageemployee');
        }
    }

    public function addeditemployee() {
        $ArrData												= array('ArrUserBasicInfo'=>array(),'VarUserId'=>'','VarNewUser'=>0);
        $VarUserId											    = $this->uri->segment(3);
        if($VarUserId<>'' && base64_decode(urldecode($VarUserId))) {
            $VarUserId                                          = base64_decode(urldecode($VarUserId));
            $ArrEmployeeInfo									= $this->profilemodel->fnGetUserInfo($VarUserId);
            $ArrData['ArrUserBasicInfo']					    = $ArrEmployeeInfo[0];
            $ArrData['VarUserId']					            = $ArrEmployeeInfo[0]['id'];

        } else {
            $ArrData['VarNewUser']							    = 1;
        }
        $this->load->view('addeditemployee',$ArrData);
    }

    public function updateEmployee() {
        $VarResult												= '';
        $VarMsg													= '';
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarGender  											= xssclean($this->input->post('g'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarDesignation											= xssclean($this->input->post('d'));
        $VarProfileRole 										= xssclean($this->input->post('p'));
        $VarUserId  											= xssclean($this->input->post('id'));
        $VarWeChatId  											= xssclean($this->input->post('wid'));
        $VarSkypeId  											= xssclean($this->input->post('sid'));
        $VarMailPassword                                        = str_rand(8,'alphanum');
        $VarPassword                                            = base64_encode($VarMailPassword);
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarUserId=="") {
            $CheckEmailExist								    = $this->profilemodel->fnCheckUser('','','','',$VarEmail);
            if($CheckEmailExist==0) {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'emailid'=>$VarEmail,'password'=>$VarPassword,'gender'=>$VarGender,'mobileno'=>$VarMobile,'designation'=>$VarDesignation,'profilepermission'=>$VarProfileRole,'updatedby'=>$VarUpdatedBy,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'username'=>$VarEmail,'usertype'=>1,'wechatid'=>$VarWeChatId,'skypeid'=>$VarSkypeId);
                $VarUserId										= $this->profilemodel->fnSaveUser($ArrEmpProfileDetails);
            } else {
                $VarMsg											= "This Email ID already exists!!";
            }
            if($VarUserId) {
                $VarDomainName                                  = APPDOMAINNAME;
                $ArrEmailReplaceArgs							= array("##NAME##"=>$VarName,"##DOMAINNAME##"=>$VarDomainName,"##USERNAME##"=>$VarEmail,"##PASSWORD##"=>$VarMailPassword,"##DOMAINURL##"=>base_url(),"##COMPANYNAME##"=>$VarDomainName);
                if(SendEmail($VarDomainName,'Welcome to '.$VarDomainName,'UserLoginDetails',$ArrEmailReplaceArgs)) {
                    $ArrResult['errcode']						= 1;
                    $ArrResult['msg']							= 'User Details has been added successfully!';
                    $ArrResult['uid']							= $VarUserId;
                    $ArrResult['euid']							= urlencode(base64_encode($VarUserId));
                }
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= $VarMsg;
            }
        } else {
            $CheckEmailExist									= $this->profilemodel->fnCheckUser($VarEmail,$VarUserId);
            if($CheckEmailExist==0 && $VarEmail<>'') {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'gender'=>$VarGender,'mobileno'=>$VarMobile,'designation'=>$VarDesignation,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'wechatid'=>$VarWeChatId,'skypeid'=>$VarSkypeId);
                if($VarEmail<>'') {
                    $ArrEmpProfileDetails['profilepermission']  = $VarProfileRole;
                    $ArrEmpProfileDetails['emailid']            = $VarEmail;
                }
                $VarUpdateEmpInfo								= $this->profilemodel->fnUpdateUser($ArrEmpProfileDetails,$VarUserId);
            } else if($VarEmail=='') {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'gender'=>$VarGender,'mobileno'=>$VarMobile,'designation'=>$VarDesignation,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'),'wechatid'=>$VarWeChatId,'skypeid'=>$VarSkypeId);
                $VarUpdateEmpInfo								= $this->profilemodel->fnUpdateUser($ArrEmpProfileDetails,$VarUserId);
            } else {
                $VarMsg											= "This E-Mail Id has already Exist!";
            }
            if($VarUpdateEmpInfo) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Employee Details has been updated successfully!';
                $ArrResult['uid']							    = $VarUserId;
                $ArrResult['euid']							    = urlencode(base64_encode($VarUserId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= '';
            }
        }
        echo json_encode($ArrResult);
    }

    public function delEmployee() {
        $VarUserId												= xssclean($this->input->post('id'));
        $VarResult												= $this->profilemodel->fnDeleteUser($VarUserId);
        if($VarResult) {
            echo json_encode(array('errcode'=>1,'msg'=>'User has been deleted successfuly!'));
        } else {
            echo json_encode(array('errcode'=>-1,'msg'=>'User has not deleted. Please try again!'));
        }
    }

    function employeeResetPassword() {
        $VarDomainName											= APPDOMAINNAME;
        $VarPassword											= str_rand(8);
        $VarUserId											    = xssclean($this->input->post('uid'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        $ArrSaveDetails											= array('password'=>base64_encode($VarPassword),'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
        $VarResult												= $this->profilemodel->fnUpdateUser($ArrSaveDetails,$VarUserId);
        if($VarResult) {
            $ArrUserBasicInfo									= $this->profilemodel->fnGetUserInfo($VarUserId);
            $ArrUserBasicInfo									= $ArrUserBasicInfo[0];
            $VarEmailId											= $ArrUserBasicInfo['emailid'];
            $VarContactName									    = $ArrUserBasicInfo['contactname'];
            $ArrEmailReplaceArgs								= array("##NAME##"=>$VarContactName,"##DOMAINNAME##"=>$VarDomainName,"##EMAILID##"=>$VarEmailId,"##PASSWORD##"=>$VarPassword,"##DOMAINURL##"=>base_url());
            if(SendEmail($VarEmailId,'Change Password Request','EndUserResetPassword',$ArrEmailReplaceArgs)) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Password has been sent!';
            }
        } else {
            $ArrResult['errcode']								= -1;
            $ArrResult['msg']									= 'Password has not sent!';
        }
        echo json_encode($ArrResult);
        unset($ArrResult);
    }

    public function changepassword() {
        $this->load->view('changepassword');
    }

    public function updatePassword() {
        $VarOldPassword											= xssclean($this->input->post('op'));
        $VarNewPassword											= xssclean($this->input->post('np'));
        $VarConfirmPassword										= xssclean($this->input->post('cp'));
        $VarUserId												= fnGetUserLoggedInfo();
        $VarUpdatedBy											= $VarUserId;
        $ArrResult												= array();
        if($VarUserId>=1) {
            $CheckSettingsExist									= $this->profilemodel->fnCheckUser('','',$VarUserId,base64_encode($VarOldPassword),'');
            if($CheckSettingsExist>=1) {
                $ArrProfileDetails								= array('password'=>base64_encode($VarNewPassword),'updatedby'=>$VarUpdatedBy,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'));
                $VarUpdateProfileInfo							= $this->profilemodel->fnUpdateUser($ArrProfileDetails,$VarUserId);
                if($VarUpdateProfileInfo && $this->fnChangePasswordEmail($VarUserId)) {
                    $ArrResult['errcode']						= 1;
                    $ArrResult['msg']							= 'Your Password has been updated successfully!';
                } else {
                    $ArrResult['errcode']						= '-1';
                    $ArrResult['msg']							= 'Your Password has not updated successfully!';
                }
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= 'Invalid Old Password!';
            }
        } else {
            $ArrResult['errcode']								= '-1';
            $ArrResult['msg']									= 'Invalid User Id!';
        }
        echo json_encode($ArrResult);
    }

    function fnChangePasswordEmail($VarUserId='') {
        if($VarUserId>=1) {
            $VarDomainName										= $this->config->item('domainname');
            $ArrUserBasicInfo									= $this->profilemodel->fnGetUserInfo($VarUserId);
            $ArrUserBasicInfo									= $ArrUserBasicInfo[0];
            $VarEmailId											= $ArrUserBasicInfo['username'];
            $VarContactName									    = $ArrUserBasicInfo['contactname'];
            $VarPassword									    = base64_decode($ArrUserBasicInfo['password']);
            $ArrEmailReplaceArgs								= array("##NAME##"=>$VarContactName,"##DOMAINNAME##"=>$VarDomainName,"##EMAILID##"=>$VarEmailId,"##PASSWORD##"=>$VarPassword);
            if(SendEmail($VarEmailId,'New Password','ChangePassword',$ArrEmailReplaceArgs)) {
                return true;
            }
        }
        return false;
    }

    public function managecustomer() {
        $VarFrom												= xssclean($this->input->post('rfrom'));
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarProfileRole                                         = 0;
        $VarUserType											= 2;
        $VarProfileStatus										= (xssclean($this->input->post('s'))=='')?array(1):array($this->input->post('s'));
        if($VarFrom==1) {
            $VarURLSegment										= 3;
            $this->load->library('pagination');
            $config['base_url']									= base_url().'profile/managecustomer/';
            $config['total_rows']								= $this->profilemodel->fnCountCustomer($VarName,$VarEmail,$VarMobile,$VarProfileStatus,$VarUserType);
            $config['per_page']									= 10;
            $config['uri_segment']								= $VarURLSegment;
            $offset												= $this->uri->segment($VarURLSegment);
            $this->pagination->initialize($config);
            $sortby												= "dateupdated";
            $sortorder											= "desc";
            $ArrEmployeeList									= $this->profilemodel->fnListCustomer($VarName,$VarEmail,$VarMobile,$VarProfileStatus,$VarUserType,$this->limit,$offset,$sortby,$sortorder)->result();
            $data['pagination']									= $this->pagination->create_linkswithajax('Customer');
            $i=0;
            $ArrFnlEmpList										= array();
            $ArrStatus											= unserialize(ARRSTATUS);
            foreach ($ArrEmployeeList as $ObjEmployeeInfo){
                $ArrFnlEmpList[$i]['id']						= $ObjEmployeeInfo->id;
                $ArrFnlEmpList[$i]['n']							= $ObjEmployeeInfo->contactname;
                $ArrFnlEmpList[$i]['e']							= $ObjEmployeeInfo->emailid;
                $ArrFnlEmpList[$i]['p']						    = base64_decode($ObjEmployeeInfo->password);
                $ArrFnlEmpList[$i]['m']							= $ObjEmployeeInfo->mobileno;
                $ArrFnlEmpList[$i]['du']						= date('d-m-Y H:i:s',strtotime($ObjEmployeeInfo->dateupdated));
                $i=$i+1;
            }
            echo json_encode(array('errcode'=>1,'cn'=>$config['total_rows'],'ct'=>$i,'re'=>$ArrFnlEmpList,'pa'=>base64_encode($data['pagination'])));
            unset($ArrFnlEmpList);
            die;
        } else {
            $this->load->view('managecustomer');
        }
    }

    function customerResetPassword() {
        $VarDomainName											= APPDOMAINNAME;
        $VarPassword											= str_rand(8);
        $VarUserId											    = xssclean($this->input->post('uid'));
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        $ArrSaveDetails											= array('password'=>base64_encode($VarPassword),'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
        $VarResult												= $this->profilemodel->fnUpdateUser($ArrSaveDetails,$VarUserId);
        if($VarResult) {
            $ArrUserBasicInfo									= $this->profilemodel->fnGetUserInfo($VarUserId);
            $ArrUserBasicInfo									= $ArrUserBasicInfo[0];
            $VarEmailId											= $ArrUserBasicInfo['emailid'];
            $VarContactName									    = $ArrUserBasicInfo['contactname'];
            $ArrEmailReplaceArgs								= array("##NAME##"=>$VarContactName,"##DOMAINNAME##"=>$VarDomainName,"##EMAILID##"=>$VarEmailId,"##PASSWORD##"=>$VarPassword,"##DOMAINURL##"=>base_url());
            if(SendEmail($VarEmailId,'Change Password Request','EndUserResetPassword',$ArrEmailReplaceArgs)) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Password has been sent!';
            }
        } else {
            $ArrResult['errcode']								= -1;
            $ArrResult['msg']									= 'Password has not sent!';
        }
        echo json_encode($ArrResult);
        unset($ArrResult);
    }

    public function delCustomer() {
        $VarUserId												= xssclean($this->input->post('id'));
        $VarResult												= $this->profilemodel->fnDeleteUser($VarUserId);
        if($VarResult) {
            echo json_encode(array('errcode'=>1,'msg'=>'User has been deleted successfuly!'));
        } else {
            echo json_encode(array('errcode'=>-1,'msg'=>'User has not deleted. Please try again!'));
        }
    }

    public function addeditcustomer() {
        $ArrData												= array('ArrUserBasicInfo'=>array(),'VarUserId'=>'','VarNewUser'=>0);
        $VarUserId											    = $this->uri->segment(4);
        if($VarUserId<>'' && urldecode(base64_decode($VarUserId))) {
            $VarUserId                                          = base64_decode(urldecode($VarUserId));
            $ArrEmployeeInfo									= $this->profilemodel->fnGetUserInfo($VarUserId);
            $ArrData['ArrUserBasicInfo']					    = $ArrEmployeeInfo[0];
            $ArrData['VarUserId']					            = $ArrEmployeeInfo[0]['id'];

        } else {
            $ArrData['VarNewUser']							    = 1;
        }
        $this->load->view('addeditcustomer',$ArrData);
    }

    public function updateCustomer() {
        $VarMsg													= '';
        $VarName												= xssclean($this->input->post('n'));
        $VarEmail												= xssclean($this->input->post('e'));
        $VarMobile												= xssclean($this->input->post('m'));
        $VarUserId  											= xssclean($this->input->post('id'));
        $VarMailPassword                                        = str_rand(8,'alphanum');
        $VarPassword                                            = base64_encode($VarMailPassword);
        $VarUpdatedBy											= fnGetUserLoggedInfo();
        if($VarUserId=="") {
            $CheckEmailExist								    = $this->profilemodel->fnCheckUser('','','','',$VarEmail);
            if($CheckEmailExist==0) {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'emailid'=>$VarEmail,'password'=>$VarPassword,'mobileno'=>$VarMobile,'updatedby'=>$VarUpdatedBy,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'username'=>$VarEmail,'usertype'=>1);
                $VarUserId										= $this->profilemodel->fnSaveUser($ArrEmpProfileDetails);
            } else {
                $VarMsg											= "This Email ID already exists!!";
            }
            if($VarUserId) {
                $VarDomainName                                  = APPDOMAINNAME;
                $ArrEmailReplaceArgs							= array("##NAME##"=>$VarName,"##DOMAINNAME##"=>$VarDomainName,"##USERNAME##"=>$VarEmail,"##PASSWORD##"=>$VarMailPassword,"##DOMAINURL##"=>base_url(),"##COMPANYNAME##"=>$VarDomainName);
                if(SendEmail($VarDomainName,'Welcome to '.$VarDomainName,'UserLoginDetails',$ArrEmailReplaceArgs)) {
                    $ArrResult['errcode']						= 1;
                    $ArrResult['msg']							= 'User Details has been added successfully!';
                    $ArrResult['uid']							= $VarUserId;
                    $ArrResult['euid']							= urlencode(base64_encode($VarUserId));
                }
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= $VarMsg;
            }
        } else {
            $CheckEmailExist									= $this->profilemodel->fnCheckUser($VarEmail,$VarUserId);
            if($CheckEmailExist==0 && $VarEmail<>'') {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'mobileno'=>$VarMobile,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
                if($VarEmail<>'') {
                    $ArrEmpProfileDetails['emailid']            = $VarEmail;
                }
                $VarUpdateEmpInfo								= $this->profilemodel->fnUpdateUser($ArrEmpProfileDetails,$VarUserId);
            } else if($VarEmail=='') {
                $ArrEmpProfileDetails							= array('status'=>1,'contactname'=>$VarName,'mobileno'=>$VarMobile,'updatedby'=>$VarUpdatedBy,'dateupdated'=>date('Y-m-d H:i:s'));
                $VarUpdateEmpInfo								= $this->profilemodel->fnUpdateUser($ArrEmpProfileDetails,$VarUserId);
            } else {
                $VarMsg											= "This E-Mail Id has already Exist!";
            }
            if($VarUpdateEmpInfo) {
                $ArrResult['errcode']							= 1;
                $ArrResult['msg']								= 'Customer Details has been updated successfully!';
                $ArrResult['uid']							    = $VarUserId;
                $ArrResult['euid']							    = urlencode(base64_encode($VarUserId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= '';
            }
        }
        echo json_encode($ArrResult);
    }


}
?>