<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mgwdmodel extends CI_Model {

    function fnGetGWDInfo($VarGWD='',$VarStatus='',$VarId='') {
        $this->db->select('id,gwdname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_GARMENT_WASH);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarGWD<>'') {
            $ArrWhere['gwdname'] 		    = $VarGWD;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckGWD($VarGWD='',$VarId='') {
        $this->db->select('id,gwdname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_GARMENT_WASH);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarGWD<>'') {
            $ArrWhere['gwdname']		= $VarGWD;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveGWDInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetGWDInfo($ArrUpdateData['gwdname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_GARMENT_WASH,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This garment wash name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckGWD($ArrUpdateData['gwdname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['gwdname']<>'') {
                if($this->db->update(KN_MASTER_GARMENT_WASH,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This garment wash name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountGWD($VarGWD='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarGWD<>'') {
            $ArrWhere[]             = "gn.gwdname like '%".$VarGWD."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "gn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "gn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlGWD                  = "SELECT count(1) as trec  FROM ".KN_MASTER_GARMENT_WASH." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlGWD)->row();
        return $ObjRows->trec;
    }

    function fnListGWD($VarGWD='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'gn.gwdname','2'=>'gn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'gn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarGWD<>'') {
            $ArrWhere[]             = "gn.gwd like '%".$VarGWD."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "gn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "gn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlGWD          = "SELECT gn.id,gn.gwdname,u.contactname,gn.datecreated,gn.dateupdated,gn.status FROM ".KN_MASTER_GARMENT_WASH." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlGWD);
        return $ObjResult;
    }

    function fnDelGWD($VarGWDId='',$VarUpdatedBy='') {
        if(@$VarGWDId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_GARMENT_WASH,$ArrUpdateData,array('id'=>$VarGWDId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarGWDId;
                $ArrResult['eid']							= urlencode(base64_encode($VarGWDId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}