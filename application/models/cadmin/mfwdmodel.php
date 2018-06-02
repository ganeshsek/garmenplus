<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mfwdmodel extends CI_Model {

    function fnGetFWDInfo($VarFWD='',$VarStatus='',$VarId='') {
        $this->db->select('id,fwdname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_FABRIC_WASH);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarFWD<>'') {
            $ArrWhere['fwdname'] 		    = $VarFWD;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckFWD($VarFWD='',$VarId='') {
        $this->db->select('id,fwdname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_FABRIC_WASH);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarFWD<>'') {
            $ArrWhere['fwdname']		= $VarFWD;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveFWDInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetFWDInfo($ArrUpdateData['fwdname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_FABRIC_WASH,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This fabric wash name name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckFWD($ArrUpdateData['fwdname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['fwdname']<>'') {
                if($this->db->update(KN_MASTER_FABRIC_WASH,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This fabric wash name name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountFWD($VarFWD='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarFWD<>'') {
            $ArrWhere[]             = "fn.fwdname like '%".$VarFWD."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "fn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "fn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlFWD                  = "SELECT count(1) as trec  FROM ".KN_MASTER_FABRIC_WASH." AS fn INNER JOIN ".KN_USERS." AS u ON fn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlFWD)->row();
        return $ObjRows->trec;
    }

    function fnListFWD($VarFWD='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'fn.fwdname','2'=>'fn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'fn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarFWD<>'') {
            $ArrWhere[]             = "fn.fwd like '%".$VarFWD."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "fn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "fn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlFWD          = "SELECT fn.id,fn.fwdname,u.contactname,fn.datecreated,fn.dateupdated,fn.status FROM ".KN_MASTER_FABRIC_WASH." AS fn INNER JOIN ".KN_USERS." AS u ON fn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlFWD);
        return $ObjResult;
    }

    function fnDelFWD($VarFWDId='',$VarUpdatedBy='') {
        if(@$VarFWDId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_FABRIC_WASH,$ArrUpdateData,array('id'=>$VarFWDId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarFWDId;
                $ArrResult['eid']							= urlencode(base64_encode($VarFWDId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}