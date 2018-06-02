<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class munitmeasuremodel extends CI_Model {

    function fnGetUnitMeasureInfo($VarUnitMeasure='',$VarStatus='',$VarId='') {
        $this->db->select('id,unitname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_UNIT_MEASURE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarUnitMeasure<>'') {
            $ArrWhere['unitname'] 		= $VarUnitMeasure;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckUnitMeasure($VarUnitMeasure='',$VarId='') {
        $this->db->select('id,unitname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_UNIT_MEASURE);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarUnitMeasure<>'') {
            $ArrWhere['unitname']		= $VarUnitMeasure;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveUnitMeasureInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetUnitMeasureInfo($ArrUpdateData['unitname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_UNIT_MEASURE,$ArrUpdateData);
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
            $ArrCheckExist									    = $this->fnCheckUnitMeasure($ArrUpdateData['unitname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['unitname']<>'') {
                if($this->db->update(KN_MASTER_UNIT_MEASURE,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountUnitMeasure($VarUnitMeasure='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarUnitMeasure<>'') {
            $ArrWhere[]             = "un.unitname like '%".$VarUnitMeasure."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "un.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "un.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlUnitMeasure            = "SELECT count(1) as trec  FROM ".KN_MASTER_UNIT_MEASURE." AS un INNER JOIN ".KN_USERS." AS u ON un.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlUnitMeasure)->row();
        return $ObjRows->trec;
    }

    function fnListUnitMeasure($VarUnitMeasure='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'un.unitname','2'=>'un.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'un.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarUnitMeasure<>'') {
            $ArrWhere[]             = "un.unitname like '%".$VarUnitMeasure."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "un.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "un.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlUnitMeasure          = "SELECT un.id,un.unitname,u.contactname,un.datecreated,un.dateupdated,un.status FROM ".KN_MASTER_UNIT_MEASURE." AS un INNER JOIN ".KN_USERS." AS u ON un.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlUnitMeasure);
        return $ObjResult;
    }

    function fnDelUnitMeasure($VarUnitId='',$VarUpdatedBy='') {
        if(@$VarUnitId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_UNIT_MEASURE,$ArrUpdateData,array('id'=>$VarUnitId))) {
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