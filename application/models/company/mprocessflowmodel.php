<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mprocessflowmodel extends CI_Model {

    function fnGetProcessFlowInfo($VarProcessFlow='',$VarStatus='',$VarId='') {
        $this->db->select('id,processflowname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_PROCESS_FLOW);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarProcessFlow<>'') {
            $ArrWhere['processflowname'] 		= $VarProcessFlow;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckProcessFlow($VarProcessFlow='',$VarId='') {
        $this->db->select('id,processflowname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_PROCESS_FLOW);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarProcessFlow<>'') {
            $ArrWhere['processflowname']		= $VarProcessFlow;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveProcessFlowInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetProcessFlowInfo($ArrUpdateData['processflowname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_PROCESS_FLOW,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This process flow already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckProcessFlow($ArrUpdateData['processflowname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['processflowname']<>'') {
                if($this->db->update(KN_MASTER_PROCESS_FLOW,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This process flow has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountProcessFlow($VarProcessFlow='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarProcessFlow<>'') {
            $ArrWhere[]             = "pn.processflowname like '%".$VarProcessFlow."%'";
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
        $VarSqlProcessFlow          = "SELECT count(1) as trec  FROM ".KN_MASTER_PROCESS_FLOW." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlProcessFlow)->row();
        return $ObjRows->trec;
    }

    function fnListProcessFlow($VarProcessFlow='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'pn.processflowname','2'=>'pn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'pn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarProcessFlow<>'') {
            $ArrWhere[]             = "pn.processflowname like '%".$VarProcessFlow."%'";
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
        $VarSqlProcessFlow          = "SELECT pn.id,pn.processflowname,u.contactname,pn.datecreated,pn.dateupdated,pn.status FROM ".KN_MASTER_PROCESS_FLOW." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlProcessFlow);
        return $ObjResult;
    }

    function fnDelProcessFlow($VarSizeId='',$VarUpdatedBy='') {
        if(@$VarSizeId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_PROCESS_FLOW,$ArrUpdateData,array('id'=>$VarSizeId))) {
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