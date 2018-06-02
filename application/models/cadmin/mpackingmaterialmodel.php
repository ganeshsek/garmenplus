<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mpackingmaterialmodel extends CI_Model {

    function fnGetPackingMaterialInfo($VarPackingMaterial='',$VarStatus='',$VarId='') {
        $this->db->select('id,packingmaterialname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_PACKING_MATERIAL);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarPackingMaterial<>'') {
            $ArrWhere['packingmaterialname'] 		= $VarPackingMaterial;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckPackingMaterial($VarPackingMaterial='',$VarId='') {
        $this->db->select('id,packingmaterialname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_PACKING_MATERIAL);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarPackingMaterial<>'') {
            $ArrWhere['packingmaterialname']		= $VarPackingMaterial;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function savePackingMaterialInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetPackingMaterialInfo($ArrUpdateData['packingmaterialname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_PACKING_MATERIAL,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This packing material already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckPackingMaterial($ArrUpdateData['packingmaterialname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['packingmaterialname']<>'') {
                if($this->db->update(KN_MASTER_PACKING_MATERIAL,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountPackingMaterial($VarPackingMaterial='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarPackingMaterial<>'') {
            $ArrWhere[]             = "pn.packingmaterialname like '%".$VarPackingMaterial."%'";
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
        $VarSqlPackingMaterial      = "SELECT count(1) as trec  FROM ".KN_MASTER_PACKING_MATERIAL." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlPackingMaterial)->row();
        return $ObjRows->trec;
    }

    function fnListPackingMaterial($VarPackingMaterial='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'pn.packingmaterialname','2'=>'pn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'pn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarPackingMaterial<>'') {
            $ArrWhere[]             = "pn.packingmaterialname like '%".$VarPackingMaterial."%'";
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
        $VarSqlPackingMaterial      = "SELECT pn.id,pn.packingmaterialname,u.contactname,pn.datecreated,pn.dateupdated,pn.status FROM ".KN_MASTER_PACKING_MATERIAL." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlPackingMaterial);
        return $ObjResult;
    }

    function fnDelPackingMaterial($VarPackingMaterial='',$VarUpdatedBy='') {
        if(@$VarPackingMaterial>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_PACKING_MATERIAL,$ArrUpdateData,array('id'=>$VarPackingMaterial))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarPackingMaterial;
                $ArrResult['eid']							= urlencode(base64_encode($VarPackingMaterial));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}