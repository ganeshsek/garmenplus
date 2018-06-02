<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mpackingcodemodel extends CI_Model {

    function fnGetPackingCodeInfo($VarPackingCode='',$VarStatus='',$VarId='') {
        $this->db->select('id,packingcode,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_PACKING_CODE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarPackingCode<>'') {
            $ArrWhere['packingcode'] 		= $VarPackingCode;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckPackingCode($VarPackingCode='',$VarId='') {
        $this->db->select('id,packingcode,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_PACKING_CODE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarPackingCode<>'') {
            $ArrWhere['packingcode']		= $VarPackingCode;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function savePackingCodeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetPackingCodeInfo($ArrUpdateData['packingcode'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_PACKING_CODE,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This packing code already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckPackingCode($ArrUpdateData['packingcode'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['packingcode']<>'') {
                if($this->db->update(KN_MASTER_PACKING_CODE,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This packing code has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountPackingCode($VarPackingCode='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarPackingCode<>'') {
            $ArrWhere[]             = "pn.packingcode like '%".$VarPackingCode."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "pn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "pn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlPackingCode            = "SELECT count(1) as trec  FROM ".KN_MASTER_PACKING_CODE." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlPackingCode)->row();
        return $ObjRows->trec;
    }

    function fnListPackingCode($VarPackingCode='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'pn.packingcode','2'=>'pn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'pn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarPackingCode<>'') {
            $ArrWhere[]             = "pn.packingcode like '%".$VarPackingCode."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "pn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "pn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlPackingCode          = "SELECT pn.id,pn.packingcode,u.contactname,pn.datecreated,pn.dateupdated,pn.status FROM ".KN_MASTER_PACKING_CODE." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlPackingCode);
        return $ObjResult;
    }

    function fnDelPackingCode($VarPackingId='',$VarUpdatedBy='') {
        if(@$VarPackingId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_PACKING_CODE,$ArrUpdateData,array('id'=>$VarPackingId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarPackingId;
                $ArrResult['eid']							= urlencode(base64_encode($VarPackingId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}