<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mdsrmodel extends CI_Model {

    function fnGetDSRInfo($VarDSR='',$VarStatus='',$VarId='') {
        $this->db->select('id,dsrname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_DYEING_SPECIAL_REQUEST);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarDSR<>'') {
            $ArrWhere['dsrname'] 		    = $VarDSR;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckDSR($VarDSR='',$VarId='') {
        $this->db->select('id,dsrname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_DYEING_SPECIAL_REQUEST);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarDSR<>'') {
            $ArrWhere['dsrname']		= $VarDSR;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveDSRInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetDSRInfo($ArrUpdateData['dsrname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_DYEING_SPECIAL_REQUEST,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This dyeing special request name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckDSR($ArrUpdateData['dsrname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['dsrname']<>'') {
                if($this->db->update(KN_MASTER_DYEING_SPECIAL_REQUEST,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This dyeing special request name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountDSR($VarDSR='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarDSR<>'') {
            $ArrWhere[]             = "dn.dsrname like '%".$VarDSR."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "dn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "dn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlDSR                  = "SELECT count(1) as trec  FROM ".KN_MASTER_DYEING_SPECIAL_REQUEST." AS dn INNER JOIN ".KN_USERS." AS u ON dn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlDSR)->row();
        return $ObjRows->trec;
    }

    function fnListDSR($VarDSR='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'dn.dsrname','2'=>'dn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarDSR<>'') {
            $ArrWhere[]             = "dn.dsr like '%".$VarDSR."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "dn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "dn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlDSR          = "SELECT dn.id,dn.dsrname,u.contactname,dn.datecreated,dn.dateupdated,dn.status FROM ".KN_MASTER_DYEING_SPECIAL_REQUEST." AS dn INNER JOIN ".KN_USERS." AS u ON dn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlDSR);
        return $ObjResult;
    }

    function fnDelDSR($VarDSRId='',$VarUpdatedBy='') {
        if(@$VarDSRId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_DYEING_SPECIAL_REQUEST,$ArrUpdateData,array('id'=>$VarDSRId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarDSRId;
                $ArrResult['eid']							= urlencode(base64_encode($VarDSRId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}