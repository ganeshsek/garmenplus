<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class maccessoriesmodel extends CI_Model {

    function fnGetAccessoriesInfo($VarAccessories='',$VarStatus='',$VarId='') {
        $this->db->select('id,accessoriesname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_ACCESSORIES);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				                = $VarId;
        }
        if($VarAccessories<>'') {
            $ArrWhere['accessoriesname'] 		            = $VarAccessories;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		                = $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckAccessories($VarAccessories='',$VarId='') {
        $this->db->select('id,accessoriesname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_ACCESSORIES);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarAccessories<>'') {
            $ArrWhere['accessoriesname']		                    = $VarAccessories;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					                        = $this->db->get();
        $ArrResultList					                        = $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveAccessoriesInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetAccessoriesInfo($ArrUpdateData['accessoriesname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_ACCESSORIES,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This accessories already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckAccessories($ArrUpdateData['accessoriesname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['accessoriesname']<>'') {
                if($this->db->update(KN_MASTER_ACCESSORIES,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This accessories has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountAccessories($VarAccessories='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarAccessories<>'') {
            $ArrWhere[]             = "an.accessoriesname like '%".$VarAccessories."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "an.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "an.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlAccessories          = "SELECT count(1) as trec FROM ".KN_MASTER_ACCESSORIES." AS an INNER JOIN ".KN_USERS." AS u ON an.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlAccessories)->row();
        return $ObjRows->trec;
    }

    function fnListAccessories($VarAccessories='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'an.accessoriesname','2'=>'an.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'an.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarAccessories<>'') {
            $ArrWhere[]             = "an.accessoriesname like '%".$VarAccessories."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "an.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "an.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlAccessories                  = "SELECT an.id,an.accessoriesname,u.contactname,an.datecreated,an.dateupdated,an.status FROM ".KN_MASTER_ACCESSORIES." AS an INNER JOIN ".KN_USERS." AS u ON an.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAccessories);
        return $ObjResult;
    }

    function fnDelAccessories($VarAccessoriesId='',$VarUpdatedBy='') {
        if(@$VarAccessoriesId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_ACCESSORIES,$ArrUpdateData,array('id'=>$VarAccessoriesId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarAccessoriesId;
                $ArrResult['eid']							= urlencode(base64_encode($VarAccessoriesId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}