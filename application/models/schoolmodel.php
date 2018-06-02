<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class schoolmodel extends CI_Model {

    function fnValidate($VarUserName='',$VarPassword='',$Validate=1) {
        $this->db->select('id,emailid,password,usertype,username,contactname,profileimg,profilepermission,mobileno,updatedby,status,datecreated,dateupdated');
        $this->db->from(KP_USERS);
        $ArrWhere = array('status'=>"1");
        if($VarUserName<>'') {
            $ArrWhere['username']		= $VarUserName;
        }
        if($VarPassword<>'') {
            $ArrWhere['password']		= $VarPassword;
        }
        $this->db->where($ArrWhere);
        $ObjUserInfo					= $this->db->get();
        if($Validate==1) {
            $VarNumRows					= $ObjUserInfo->num_rows();
            return $VarNumRows;
        } else {
            $ArrProfileInfo				= $ObjUserInfo->result_array();
            return $ArrProfileInfo;
        }
    }

    function fnCheckUserUpdate($VarUserId='',$VarEmailId='') {
        $this->db->select('id,emailid,password,usertype,username,contactname,profileimg,profilepermission,mobileno,updatedby,status,datecreated,dateupdated');
        $this->db->from(KP_USERS);
        $ArrWhere = array('status'=>"1");
        if($VarUserId<>'') {
            $this->db->where_not_in('id',array($VarUserId));
        }
        if($VarEmailId<>'') {
            $ArrWhere['emailid']		= $VarEmailId;
        }
        $this->db->where($ArrWhere);
        $ObjUserInfo					= $this->db->get();
        $ArrProfileInfo					= $ObjUserInfo->result_array();
        return $ArrProfileInfo;
    }

    function fnCountSchools($VarName='',$VarEmail='',$VarMobile='',$VarSchoolName='',$VarProfileStatus='',$VarUserType=''){
        $this->db->select('id');
        $this->db->from(KP_USERS);
        $ArrWhere['usertype']		= $VarUserType;
        if($VarName<>'') {
            $this->db->like('contactname', $VarName);
        }
        if($VarEmail<>'') {
            $this->db->like('emailid', $VarEmail);
        }
        if($VarMobile<>'') {
            $this->db->like('phoneno', $VarMobile);
        }
        if($VarSchoolName<>'') {
            $this->db->like('schoolname', $VarSchoolName);
        }
        if($VarProfileStatus<>'') {
            $this->db->where_in('status',$VarProfileStatus);
        }
        $this->db->where($ArrWhere);
        $VarCount = $this->db->get()->num_rows();
        return $VarCount;
    }

    function fnListSchools($VarName='',$VarEmail='',$VarMobile='',$VarSchoolName='',$VarProfileStatus='',$VarUserType='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'contactname',"2"=>'dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dateupdated';
        $this->db->select('id,emailid,password,designation,contactname,profileimg,profilepermission,updatedby,status,datecreated,dateupdated,mobileno,schoolname,phoneno,username');
        $this->db->from(KP_USERS);
        $ArrWhere['usertype']		= $VarUserType;
        if($VarName<>'') {
            $this->db->like('contactname', $VarName);
        }
        if($VarEmail<>'') {
            $this->db->like('emailid', $VarEmail);
        }
        if($VarMobile<>'') {
            $this->db->like('phoneno', $VarMobile);
        }
        if($VarSchoolName<>'') {
            $this->db->like('schoolname', $VarSchoolName);
        }
        if($VarProfileStatus<>'') {
            $this->db->where_in('status',$VarProfileStatus);
        }
        $this->db->where($ArrWhere);
        $this->db->order_by($VarSortBy,$VarSortOrder);
        $this->db->limit($VarLimit, $offset);
        $ArrResult					= $this->db->get();
        // print_r($this->db);
        return $ArrResult;
    }

    function fnDeleteSchools($VarUserId='') {
        $VarResult = $this->db->update(KP_USERS,array('status'=>3,"dateupdated"=>date('Y-m-d H:i:s')),array('id'=>$VarUserId));
        return $VarResult;
    }

    function fnGetSchoolInfo($VarUserId='',$VarUserType='',$VarProfilePermission='',$VarStatus='',$VarEmailId='') {
        $this->db->select('id,emailid,address,zipcode,username,updatedby,usertype,designation,gender,password,contactname,profileimg,profilepermission,mobileno,updatedby,status,datecreated,dateupdated,skypeid,wechatid,country,city,schoolname,username,phoneno'); // Select field
        $this->db->from(KP_USERS);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarUserType<>'') {
            $ArrWhere['usertype'] 			= $VarUserType;
        }
        if($VarEmailId>'') {
            $ArrWhere['emailid'] 			= $VarEmailId;
        }
        if($VarUserId<>'') {
            $ArrWhere['id'] 				= $VarUserId;
        }
        if($VarProfilePermission<>'') {
            $ArrWhere['profilepermission'] 	= $VarProfilePermission;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrEmployeeList						= $this->db->get()->result_array();
        //print_r($this->db);
        return $ArrEmployeeList;
    }

    function fnGetUserListDetails($ArrUserIdList) {
        $this->db->select('id,companyname,contactname,emailid'); // Select field
        $this->db->from(KP_USERS);
        $this->db->where_in('id',$ArrUserIdList);
        $ArrEmployeeList						= $this->db->get()->result_array();
        $ArrEmployeeDetails						= array();
        foreach($ArrEmployeeList as $VarKey=>$ArrEmployeeInfo) {
            $ArrEmployeeDetails[$ArrEmployeeInfo['id']]['n']	= $ArrEmployeeInfo['contactname'];
            $ArrEmployeeDetails[$ArrEmployeeInfo['id']]['cn']	= $ArrEmployeeInfo['companyname'];
            $ArrEmployeeDetails[$ArrEmployeeInfo['id']]['e']	= $ArrEmployeeInfo['emailid'];
        }
        return $ArrEmployeeDetails;
    }

    function fnSaveUser($ArrEmpInfo){
        $this->db->insert(KP_USERS,$ArrEmpInfo);
        return $this->db->insert_id();
    }

    function fnUpdateUser($ArrEmployeeInfo,$VarEmployeeId) {
        $VarResult = $this->db->update(KP_USERS,$ArrEmployeeInfo,array('id'=>$VarEmployeeId));
        return $VarResult;
    }

    function fnCheckUser($VarEmail='',$VarEmployeeId='',$VarUserId='',$VarPassword='',$VarUserName='') {
        $this->db->select('id'); // Select field
        $this->db->from(KP_USERS);
        $this->db->where_in('status',array(1,2));
        if($VarEmail<>'') {
            $ArrWhere['emailid'] = $VarEmail;
        }
        if($VarUserId<>'') {
            $ArrWhere['id'] = $VarUserId;
        }
        if($VarPassword<>'') {
            $ArrWhere['password'] = $VarPassword;
        }
        if($VarUserName<>'') {
            $ArrWhere['username'] = $VarUserName;
        }
        if($VarEmployeeId<>'') {
            $this->db->where_not_in('id',array($VarEmployeeId));
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $VarNumRows								= $this->db->get()->num_rows();
        return $VarNumRows;
    }

}
?>