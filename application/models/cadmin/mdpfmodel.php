<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mdpfmodel extends CI_Model {

    function fnGetDPFInfo($VarDPF='',$VarStatus='',$VarId='') {
        $this->db->select('id,dpfname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_DRY_PROCESSING_FINISHING);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarDPF<>'') {
            $ArrWhere['dpfname'] 		    = $VarDPF;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckDPF($VarDPF='',$VarId='') {
        $this->db->select('id,dpfname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_DRY_PROCESSING_FINISHING);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarDPF<>'') {
            $ArrWhere['dpfname']		= $VarDPF;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveDPFInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetDPFInfo($ArrUpdateData['dpfname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_DRY_PROCESSING_FINISHING,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This dry processing finishing name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckDPF($ArrUpdateData['dpfname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['dpfname']<>'') {
                if($this->db->update(KN_MASTER_DRY_PROCESSING_FINISHING,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This dry processing finishing name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountDPF($VarDPF='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarDPF<>'') {
            $ArrWhere[]             = "dn.dpfname like '%".$VarDPF."%'";
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
        $VarSqlDPF                  = "SELECT count(1) as trec  FROM ".KN_MASTER_DRY_PROCESSING_FINISHING." AS dn INNER JOIN ".KN_USERS." AS u ON dn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlDPF)->row();
        return $ObjRows->trec;
    }

    function fnListDPF($VarDPF='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'dn.dpfname','2'=>'dn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarDPF<>'') {
            $ArrWhere[]             = "dn.dpf like '%".$VarDPF."%'";
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
        $VarSqlDPF          = "SELECT dn.id,dn.dpfname,u.contactname,dn.datecreated,dn.dateupdated,dn.status FROM ".KN_MASTER_DRY_PROCESSING_FINISHING." AS dn INNER JOIN ".KN_USERS." AS u ON dn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlDPF);
        return $ObjResult;
    }

    function fnDelDPF(  $VarDPFId='',$VarUpdatedBy='') {
        if(@$VarDPFId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_DRY_PROCESSING_FINISHING,$ArrUpdateData,array('id'=>$VarDPFId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarDPFId;
                $ArrResult['eid']							= urlencode(base64_encode($VarDPFId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}