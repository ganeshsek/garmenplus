<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class msewingtrimmingtypemodel extends CI_Model {

    function fnGetSewingTrimmingTypeInfo($VarSewingTrimmingType='',$VarStatus='',$VarId='') {
        $this->db->select('id,trimmingname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_SEWING_TRIMMING_TYPE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarSewingTrimmingType<>'') {
            $ArrWhere['trimmingname'] 		= $VarSewingTrimmingType;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckSewingTrimmingType($VarSewingTrimmingType='',$VarId='') {
        $this->db->select('id,trimmingname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_SEWING_TRIMMING_TYPE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarSewingTrimmingType<>'') {
            $ArrWhere['trimmingname']		= $VarSewingTrimmingType;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveSewingTrimmingTypeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetSewingTrimmingTypeInfo($ArrUpdateData['trimmingname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_SEWING_TRIMMING_TYPE,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This method name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckSewingTrimmingType($ArrUpdateData['trimmingname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['trimmingname']<>'') {
                if($this->db->update(KN_MASTER_SEWING_TRIMMING_TYPE,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This dyeing method has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountSewingTrimmingType($VarSewingTrimmingType='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarSewingTrimmingType<>'') {
            $ArrWhere[]             = "tn.trimmingname like '%".$VarSewingTrimmingType."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "tn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "tn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlSewingTrimmingType            = "SELECT count(1) as trec  FROM ".KN_MASTER_SEWING_TRIMMING_TYPE." AS tn INNER JOIN ".KN_USERS." AS u ON tn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlSewingTrimmingType)->row();
        return $ObjRows->trec;
    }

    function fnListSewingTrimmingType($VarSewingTrimmingType='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'tn.trimmingname','2'=>'tn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'tn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarSewingTrimmingType<>'') {
            $ArrWhere[]             = "tn.trimmingname like '%".$VarSewingTrimmingType."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "tn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "tn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlSewingTrimmingType          = "SELECT tn.id,tn.trimmingname,u.contactname,tn.datecreated,tn.dateupdated,tn.status FROM ".KN_MASTER_SEWING_TRIMMING_TYPE." AS tn INNER JOIN ".KN_USERS." AS u ON tn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlSewingTrimmingType);
        return $ObjResult;
    }

    function fnDelSewingTrimmingType($VarTrimmingId='',$VarUpdatedBy='') {
        if(@$VarTrimmingId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_SEWING_TRIMMING_TYPE,$ArrUpdateData,array('id'=>$VarTrimmingId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarTrimmingId;
                $ArrResult['eid']							= urlencode(base64_encode($VarTrimmingId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}