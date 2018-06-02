<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class membellmodel extends CI_Model {

    function fnGetEmbellTypeInfo($VarEmbellName='',$VarStatus='',$VarId='') {
        $this->db->select('id,embellname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_EMBELL_TYPE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarEmbellName<>'') {
            $ArrWhere['embellname'] 		= $VarEmbellName;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckEmbellType($VarEmbellName='',$VarId='') {
        $this->db->select('id,embellname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_EMBELL_TYPE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarEmbellName<>'') {
            $ArrWhere['embellname']		= $VarEmbellName;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveEmbellTypeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetEmbellTypeInfo($ArrUpdateData['embellname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_EMBELL_TYPE,$ArrUpdateData);
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
            $ArrCheckExist									    = $this->fnCheckEmbellType($ArrUpdateData['embellname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['embellname']<>'') {
                if($this->db->update(KN_MASTER_EMBELL_TYPE,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountEmbellType($VarEmbellName='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarEmbellName<>'') {
            $ArrWhere[]             = "e.embellname like '%".$VarEmbellName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "e.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "e.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlEmbellType            = "SELECT count(1) as trec  FROM ".KN_MASTER_EMBELL_TYPE." AS e INNER JOIN ".KN_USERS." AS u ON e.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlEmbellType)->row();
        return $ObjRows->trec;
    }

    function fnListEmbellType($VarEmbellName='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'e.embellname','2'=>'e.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'e.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarEmbellName<>'') {
            $ArrWhere[]             = "e.embellname like '%".$VarEmbellName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "e.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "e.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlEmbellType           = "SELECT e.id,e.embellname,u.contactname,e.datecreated,e.dateupdated,e.status FROM ".KN_MASTER_EMBELL_TYPE." AS e INNER JOIN ".KN_USERS." AS u ON e.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlEmbellType);
        return $ObjResult;
    }

    function fnDelEmbellType($VarEmbellId='',$VarUpdatedBy='') {
        if(@$VarEmbellId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_EMBELL_TYPE,$ArrUpdateData,array('id'=>$VarEmbellId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarEmbellId;
                $ArrResult['eid']							= urlencode(base64_encode($VarEmbellId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}