<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mgarmenttypemodel extends CI_Model {

    function fnGetGarmentTypeInfo($VarGarmentType='',$VarStatus='',$VarId='') {
        $this->db->select('id,garmentname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_GARMENT_TYPE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarGarmentType<>'') {
            $ArrWhere['garmentname'] 		= $VarGarmentType;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckGarmentType($VarGarmentType='',$VarId='') {
        $this->db->select('id,garmentname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_GARMENT_TYPE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarGarmentType<>'') {
            $ArrWhere['garmentname']		= $VarGarmentType;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveGarmentTypeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetGarmentTypeInfo($ArrUpdateData['garmentname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_GARMENT_TYPE,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This garment type already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckGarmentType($ArrUpdateData['garmentname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['garmentname']<>'') {
                if($this->db->update(KN_MASTER_GARMENT_TYPE,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountGarmentType($VarGarmentType='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarGarmentType<>'') {
            $ArrWhere[]             = "gn.garmentname like '%".$VarGarmentType."%'";
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
        $VarSqlGarmentType            = "SELECT count(1) as trec  FROM ".KN_MASTER_GARMENT_TYPE." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlGarmentType)->row();
        return $ObjRows->trec;
    }

    function fnListGarmentType($VarGarmentType='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'gn.garmentname','2'=>'gn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'gn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarGarmentType<>'') {
            $ArrWhere[]             = "gn.garmentname like '%".$VarGarmentType."%'";
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
        $VarSqlGarmentType          = "SELECT gn.id,gn.garmentname,u.contactname,gn.datecreated,gn.dateupdated,gn.status FROM ".KN_MASTER_GARMENT_TYPE." AS gn INNER JOIN ".KN_USERS." AS u ON gn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlGarmentType);
        return $ObjResult;
    }

    function fnDelGarmentType($VarGarmentId='',$VarUpdatedBy='') {
        if(@$VarGarmentId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_GARMENT_TYPE,$ArrUpdateData,array('id'=>$VarGarmentId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarGarmentId;
                $ArrResult['eid']							= urlencode(base64_encode($VarGarmentId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}