<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mfabricmodel extends CI_Model {

    function fnGetFabricTypeInfo($VarFabricName='',$VarStatus='',$VarId='') {
        $this->db->select('id,fabricname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_FABRIC_TYPE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarFabricName<>'') {
            $ArrWhere['fabricname'] 		= $VarFabricName;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckFabricType($VarFabricName='',$VarId='') {
        $this->db->select('id,fabricname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_FABRIC_TYPE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarFabricName<>'') {
            $ArrWhere['fabricname']		= $VarFabricName;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveFabricTypeInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetFabricTypeInfo($ArrUpdateData['fabricname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_FABRIC_TYPE,$ArrUpdateData);
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
            $ArrCheckExist									    = $this->fnCheckFabricType($ArrUpdateData['fabricname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['fabricname']<>'') {
                if($this->db->update(KN_MASTER_FABRIC_TYPE,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountFabricType($VarFabricName='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarFabricName<>'') {
            $ArrWhere[]             = "f.fabricname like '%".$VarFabricName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "f.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "f.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSelectDyeing            = "SELECT count(1) as trec  FROM ".KN_MASTER_FABRIC_TYPE." AS f INNER JOIN ".KN_USERS." AS u ON f.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSelectDyeing)->row();
        return $ObjRows->trec;
    }

    function fnListFabricType($VarFabricName='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'f.fabricname','2'=>'f.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'f.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarFabricName<>'') {
            $ArrWhere[]             = "f.fabricname like '%".$VarFabricName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "f.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "f.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest         = "SELECT f.id,f.fabricname,u.contactname,f.datecreated,f.dateupdated,f.status FROM ".KN_MASTER_FABRIC_TYPE." AS f INNER JOIN ".KN_USERS." AS u ON f.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAssignaTest);
        return $ObjResult;
    }

    function fnDelFabricType($VarFabricId='',$VarUpdatedBy='') {
        if(@$VarFabricId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_FABRIC_TYPE,$ArrUpdateData,array('id'=>$VarFabricId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarFabricId;
                $ArrResult['eid']							= urlencode(base64_encode($VarFabricId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}