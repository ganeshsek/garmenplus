<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mseasonmodel extends CI_Model {

    function fnGetSeasonInfo($VarSeason='',$VarStatus='',$VarId='') {
        $this->db->select('id,seasonname,seasonyear,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_SEASON);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarSeason<>'') {
            $ArrWhere['seasonname'] 		= $VarSeason;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckSeason($VarSeason='',$VarId='') {
        $this->db->select('id,seasonname,seasonyear,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_SEASON);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarSeason<>'') {
            $ArrWhere['seasonname']		= $VarSeason;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveSeasonInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetSeasonInfo($ArrUpdateData['seasonname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_SEASON,$ArrUpdateData);
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
            $ArrCheckExist									    = $this->fnCheckSeason($ArrUpdateData['seasonname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['seasonname']<>'') {
                if($this->db->update(KN_MASTER_SEASON,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This season name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountSeason($VarSeason='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarSeason<>'') {
            $ArrWhere[]             = "sn.seasonname like '%".$VarSeason."%'";
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
        $VarSqlSeason            = "SELECT count(1) as trec  FROM ".KN_MASTER_SEASON." AS sn INNER JOIN ".KN_USERS." AS u ON sn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlSeason)->row();
        return $ObjRows->trec;
    }

    function fnListSeason($VarSeason='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'sn.seasonname','2'=>'sn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'sn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarSeason<>'') {
            $ArrWhere[]             = "sn.seasonname like '%".$VarSeason."%'";
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
        $VarSqlSeason          = "SELECT sn.id,sn.seasonname,sn.seasonyear,u.contactname,sn.datecreated,sn.dateupdated,sn.status FROM ".KN_MASTER_SEASON." AS sn INNER JOIN ".KN_USERS." AS u ON sn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlSeason);
        return $ObjResult;
    }

    function fnDelSeason($VarUnitId='',$VarUpdatedBy='') {
        if(@$VarUnitId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_SEASON,$ArrUpdateData,array('id'=>$VarUnitId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarUnitId;
                $ArrResult['eid']							= urlencode(base64_encode($VarUnitId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}