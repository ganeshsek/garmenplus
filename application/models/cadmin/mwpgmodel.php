<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mwpgmodel extends CI_Model {

    function fnGetWPGInfo($VarWPG='',$VarStatus='',$VarId='') {
        $this->db->select('id,wpgname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_WET_PROCESSING_GREIGE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarWPG<>'') {
            $ArrWhere['wpgname'] 		    = $VarWPG;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckWPG($VarWPG='',$VarId='') {
        $this->db->select('id,wpgname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_WET_PROCESSING_GREIGE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarWPG<>'') {
            $ArrWhere['wpgname']		= $VarWPG;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveWPGInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetWPGInfo($ArrUpdateData['wpgname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_WET_PROCESSING_GREIGE,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This wet processing greige name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckWPG($ArrUpdateData['wpgname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['wpgname']<>'') {
                if($this->db->update(KN_MASTER_WET_PROCESSING_GREIGE,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This wet processing greige name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountWPG($VarWPG='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarWPG<>'') {
            $ArrWhere[]             = "wn.wpgname like '%".$VarWPG."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "wn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "wn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlWPG                  = "SELECT count(1) as trec  FROM ".KN_MASTER_WET_PROCESSING_GREIGE." AS wn INNER JOIN ".KN_USERS." AS u ON wn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlWPG)->row();
        return $ObjRows->trec;
    }

    function fnListWPG($VarWPG='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'wn.wpgname','2'=>'wn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'wn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarWPG<>'') {
            $ArrWhere[]             = "wn.wpg like '%".$VarWPG."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "wn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "wn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlWPG          = "SELECT wn.id,wn.wpgname,u.contactname,wn.datecreated,wn.dateupdated,wn.status FROM ".KN_MASTER_WET_PROCESSING_GREIGE." AS wn INNER JOIN ".KN_USERS." AS u ON wn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlWPG);
        return $ObjResult;
    }

    function fnDelWPG($VarWPGId='',$VarUpdatedBy='') {
        if(@$VarWPGId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_WET_PROCESSING_GREIGE,$ArrUpdateData,array('id'=>$VarWPGId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarWPGId;
                $ArrResult['eid']							= urlencode(base64_encode($VarWPGId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}