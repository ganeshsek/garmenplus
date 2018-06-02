<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mapprovalmodel extends CI_Model {

    function fnGetApprovalInfo($VarApproval='',$VarStatus='',$VarId='') {
        $this->db->select('id,approvalname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_APPROVAL);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarApproval<>'') {
            $ArrWhere['approvalname'] 		= $VarApproval;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckApproval($VarApproval='',$VarId='') {
        $this->db->select('id,approvalname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_APPROVAL);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarApproval<>'') {
            $ArrWhere['approvalname']		= $VarApproval;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveApprovalInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetApprovalInfo($ArrUpdateData['approvalname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_APPROVAL,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This approval already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckApproval($ArrUpdateData['approvalname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['approvalname']<>'') {
                if($this->db->update(KN_MASTER_APPROVAL,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This approval has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountApproval($VarApproval='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarApproval<>'') {
            $ArrWhere[]             = "an.approvalname like '%".$VarApproval."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "an.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "an.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlApproval          = "SELECT count(1) as trec  FROM ".KN_MASTER_APPROVAL." AS an INNER JOIN ".KN_USERS." AS u ON an.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlApproval)->row();
        return $ObjRows->trec;
    }

    function fnListApproval($VarApproval='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'an.approvalname','2'=>'an.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'an.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarApproval<>'') {
            $ArrWhere[]             = "an.approvalname like '%".$VarApproval."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "an.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "an.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlApproval             = "SELECT an.id,an.approvalname,u.contactname,an.datecreated,an.dateupdated,an.status FROM ".KN_MASTER_APPROVAL." AS an INNER JOIN ".KN_USERS." AS u ON an.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlApproval);
        return $ObjResult;
    }

    function fnDelApproval($VarApprovalId='',$VarUpdatedBy='') {
        if(@$VarApprovalId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_APPROVAL,$ArrUpdateData,array('id'=>$VarApprovalId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarApprovalId;
                $ArrResult['eid']							= urlencode(base64_encode($VarApprovalId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}   