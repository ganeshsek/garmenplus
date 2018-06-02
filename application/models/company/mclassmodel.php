<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mclassmodel extends CI_Model {

    function fnGetClassInfo($VarClass='',$VarStatus='',$VarId='') {
        $this->db->select('id,classname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_CLASS);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				                = $VarId;
        }
        if($VarClass<>'') {
            $ArrWhere['classname'] 		                    = $VarClass;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		                = $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckClass($VarClass='',$VarId='') {
        $this->db->select('id,classname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_CLASS);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarClass<>'') {
            $ArrWhere['classname']		                        = $VarClass;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					                        = $this->db->get();
        $ArrResultList					                        = $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveClassInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetClassInfo($ArrUpdateData['classname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_CLASS,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This class already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckClass($ArrUpdateData['classname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['classname']<>'') {
                if($this->db->update(KN_MASTER_CLASS,$ArrUpdateData,array('id'=>$VarId))) {
                    $ArrResult['errcode']					    = 1;
                    $ArrResult['msg']							= '';
                    $ArrResult['id']							= $VarId;
                    $ArrResult['eid']							= urlencode(base64_encode($VarId));
                } else {
                    $ArrResult['errcode']						= '-1';
                    $ArrResult['msg']							= 'Invalid Data!';
                }
            }  else {
                $ArrResult['errcode']						    = '-1';
                $ArrResult['msg']							    = "This class has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountClass($VarClass='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarClass<>'') {
            $ArrWhere[]             = "cn.classname like '%".$VarClass."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "cn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "cn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlClass                  = "SELECT count(1) as trec  FROM ".KN_MASTER_CLASS." AS cn INNER JOIN ".KN_USERS." AS u ON cn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlClass)->row();
        return $ObjRows->trec;
    }

    function fnListClass($VarClass='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'cn.classname','2'=>'cn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'cn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarClass<>'') {
            $ArrWhere[]             = "cn.classname like '%".$VarClass."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "cn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "cn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlClass                = "SELECT cn.id,cn.classname,u.contactname,cn.datecreated,cn.dateupdated,cn.status FROM ".KN_MASTER_CLASS." AS cn INNER JOIN ".KN_USERS." AS u ON cn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlClass);
        return $ObjResult;
    }

    function fnDelClass($VarClassId='',$VarUpdatedBy='') {
        if(@$VarClassId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_CLASS,$ArrUpdateData,array('id'=>$VarClassId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarClassId;
                $ArrResult['eid']							= urlencode(base64_encode($VarClassId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}   