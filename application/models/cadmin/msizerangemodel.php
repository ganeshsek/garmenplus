<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class msizerangemodel extends CI_Model {

    function fnGetSizeRangeInfo($VarSizeRange='',$VarStatus='',$VarId='') {
        $this->db->select('id,sizename,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_SIZE_RANGE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarSizeRange<>'') {
            $ArrWhere['sizename'] 		= $VarSizeRange;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckSizeRange($VarSizeRange='',$VarId='') {
        $this->db->select('id,sizename,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_SIZE_RANGE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarSizeRange<>'') {
            $ArrWhere['sizename']		= $VarSizeRange;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveSizeRangeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetSizeRangeInfo($ArrUpdateData['sizename'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_SIZE_RANGE,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This size range already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckSizeRange($ArrUpdateData['sizename'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['sizename']<>'') {
                if($this->db->update(KN_MASTER_SIZE_RANGE,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This size range has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountSizeRange($VarSizeRange='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarSizeRange<>'') {
            $ArrWhere[]             = "sn.sizename like '%".$VarSizeRange."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "sn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "sn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlSizeRange            = "SELECT count(1) as trec  FROM ".KN_MASTER_SIZE_RANGE." AS sn INNER JOIN ".KN_USERS." AS u ON sn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlSizeRange)->row();
        return $ObjRows->trec;
    }

    function fnListSizeRange($VarSizeRange='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'sn.sizename','2'=>'sn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'sn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarSizeRange<>'') {
            $ArrWhere[]             = "sn.sizename like '%".$VarSizeRange."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "sn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "sn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlSizeRange          = "SELECT sn.id,sn.sizename,u.contactname,sn.datecreated,sn.dateupdated,sn.status FROM ".KN_MASTER_SIZE_RANGE." AS sn INNER JOIN ".KN_USERS." AS u ON sn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlSizeRange);
        return $ObjResult;
    }

    function fnDelSizeRange($VarSizeId='',$VarUpdatedBy='') {
        if(@$VarSizeId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_SIZE_RANGE,$ArrUpdateData,array('id'=>$VarSizeId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarSizeId;
                $ArrResult['eid']							= urlencode(base64_encode($VarSizeId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}