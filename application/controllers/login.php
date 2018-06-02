<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model("loginmodel");
        $this->load->helper('cookie');
        $this->load->library('email');
        $this->load->helper('email');
        $this->load->helper('common');
        $this->load->helper('xssclean');
    }

    public function index() {
        $this->load->view('login');
    }

    public function validate() {
        $VarUsername									= xssclean($this->input->post('e'));
        $VarPassword									= base64_encode(xssclean($this->input->post('p')));
        $ArrProfileStatus								= $this->loginmodel->fnValidate($VarUsername,$VarPassword,2);
        $ArrResult										= array();
        if(count($ArrProfileStatus)>=1) {
            $ArrResult['errcode']						= '1';
            $ArrResult['ut']						    = $ArrProfileStatus[0]['usertype'];
            $ArrResult['msg']							= "";
            $ArrProfileStatus							= $ArrProfileStatus[0];
            $ArrProfileInfo								= array("UI"=>array('id'=>$ArrProfileStatus['id'],'name'=>$ArrProfileStatus['contactname'],'username'=>$VarUsername,'email'=>$ArrProfileStatus['emailid'],'mobile'=>$ArrProfileStatus['emailid'],'usertype'=>$ArrProfileStatus['usertype'],"pp"=>$ArrProfileStatus['profilepermission'],'pimg'=>$ArrProfileStatus['profileimg'],'companycode'=>$ArrProfileStatus['companyprefixcode'],'companyname'=>$ArrProfileStatus['companyname']));
            $this->session->set_userdata($ArrProfileInfo);
            if($ArrProfileStatus['usertype']==2) {
                $_SESSION["CompUserName"]                   = $VarUsername;
            } else {
                $_SESSION["CompUserName"]                   = '';
            }

        } else {
            $ArrResult['errcode']						= '-1';
            $ArrResult['msg']							= "Invalid Username/Password";
        }
        echo json_encode($ArrResult);die;
    }

    function signout() {
        $ArrProfileInfo									= fnGetUserLoggedInfo();
        if(@$ArrProfileInfo['id']>=1) {
            $this->session->unset_userdata();
            $this->session->sess_destroy();
            $this->_userdata = '';
            redirect(base_url());
        } else {
            redirect(base_url());
        }
    }

    public function forgotpassword() {
        $VarEmail										= xssclean($this->input->post('e'));
        $ArrProfileInfo									= $this->loginmodel->fnValidate($VarEmail,'',2);
        $ArrResult										= array();
        if(count($ArrProfileInfo)>=1) {
            $ArrProfileStatus							= $ArrProfileInfo[0];
            $VarName									= $ArrProfileStatus['contactname'];
            $VarEmail									= $ArrProfileStatus['username'];
            $VarUserId									= $ArrProfileStatus['id'];
            $VarPassword								= str_rand(8,'alphanum');
            $VarDomainName								= $this->config->item('domainname');
            $ArrSaveDetails								= array('password'=>base64_encode($VarPassword),'dateupdated'=>date('Y-m-d H:i:s'));
            $VarResult									= $this->loginmodel->fnUpdateUser($ArrSaveDetails,$VarUserId);
            if($VarResult) {
                $ArrEmailReplaceArgs					= array("##NAME##"=>$VarName,"##DOMAINNAME##"=>$VarDomainName,"##EMAILID##"=>$VarEmail,"##PASSWORD##"=>$VarPassword,"##DOMAINURL##"=>base_url());
                if(SendEmail($VarEmail,'New Password Request','EmployeeForgotPassword',$ArrEmailReplaceArgs)) {
                    $ArrResult['errcode']				= '1';
                    $ArrResult['msg']					= "Your new password has been sent to your email id!";
                }
            } else {
                $ArrResult['errcode']					= '-1';
                $ArrResult['msg']						= "Invalid E-Mail Id!";
            }
        } else {
            $ArrResult['errcode']						= '-1';
            $ArrResult['msg']							= "Invalid E-Mail Id!";
        }
        echo json_encode($ArrResult);die;
    }

}