<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class loginmodel extends CI_Model {
	
	function fnValidate($VarUserName='',$VarPassword='',$Validate=1) {
		$this->db->select('id,password,usertype,username,contactname,profileimg,profilepermission,updatedby,status,datecreated,dateupdated');
		$this->db->from(KN_USERS);
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

	function fnGetUserInfo($VarUserId='',$VarUserType='',$VarProfilePermission='',$VarStatus='',$VarEmailId='') {
		$this->db->select('id,username,updatedby,usertype,password,contactname,profileimg,profilepermission,updatedby,status,datecreated,dateupdated'); // Select field
		$this->db->from(KN_USERS);
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
		return $ArrEmployeeList;
	}


}