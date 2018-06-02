<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mgpdmodel extends CI_Model {

    function fnGetGPDInfo($VarGPD='',$VarStatus='',$VarId='') {
        $this->db->select('id,gpdname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_GARMENT_PART_DESC);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarGPD<>'') {
            $ArrWhere['gpdname'] 		    = $VarGPD;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckGPD($VarGPD='',$VarId='') {
        $this->db->select('id,gpdname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_GARMENT_PART_DESC);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarGPD<>'') {
            $ArrWhere['gpdname']		= $VarGPD;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveGPDInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetGPDInfo($ArrUpdateData['gpdname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_GARMENT_PART_DESC,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This garment part desc. name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckGPD($ArrUpdateData['gpdname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['gpdname']<>'') {
                if($this->db->update(KN_MASTER_GARMENT_PART_DESC,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This garment part desc. name has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountGPD($VarGPD='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarGPD<>'') {
            $ArrWhere[]             = "gn.gpdname like '%".$VarGPD."%'";
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
        $VarSqlGPD                  = "SELECT count(1) as trec  FROM ".KN_MASTER_GARMENT_PART_DESC." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlGPD)->row();
        return $ObjRows->trec;
    }

    function fnListGPD($VarGPD='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'gn.gpdname','2'=>'gn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'gn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarGPD<>'') {
            $ArrWhere[]             = "gn.gpd like '%".$VarGPD."%'";
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
        $VarSqlGPD          = "SELECT gn.id,gn.gpdname,u.contactname,gn.datecreated,gn.dateupdated,gn.status FROM ".KN_MASTER_GARMENT_PART_DESC." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlGPD);
        return $ObjResult;
    }

    function fnDelGPD($VarGPDId='',$VarUpdatedBy='') {
        if(@$VarGPDId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_GARMENT_PART_DESC,$ArrUpdateData,array('id'=>$VarGPDId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarGPDId;
                $ArrResult['eid']							= urlencode(base64_encode($VarGPDId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}