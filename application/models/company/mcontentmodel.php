<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mcontentmodel extends CI_Model {

    function fnGetContentInfo($VarContent='',$VarStatus='',$VarId='') {
        $this->db->select('id,contentname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_CONTENT);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				                = $VarId;
        }
        if($VarContent<>'') {
            $ArrWhere['contentname'] 		                    = $VarContent;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		                = $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckContent($VarContent='',$VarId='') {
        $this->db->select('id,contentname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_CONTENT);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarContent<>'') {
            $ArrWhere['contentname']		                    = $VarContent;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					                        = $this->db->get();
        $ArrResultList					                        = $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveContentInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetContentInfo($ArrUpdateData['contentname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_CONTENT,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This content already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckContent($ArrUpdateData['contentname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['contentname']<>'') {
                if($this->db->update(KN_MASTER_CONTENT,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This content has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountContent($VarContent='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarContent<>'') {
            $ArrWhere[]             = "cn.contentname like '%".$VarContent."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "cn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "cn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlContent                  = "SELECT count(1) as trec FROM ".KN_MASTER_CONTENT." AS cn INNER JOIN ".KN_USERS." AS u ON cn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlContent)->row();
        return $ObjRows->trec;
    }

    function fnListContent($VarContent='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'cn.contentname','2'=>'cn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'cn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarContent<>'') {
            $ArrWhere[]             = "cn.contentname like '%".$VarContent."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "cn.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "cn.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlContent                  = "SELECT cn.id,cn.contentname,u.contactname,cn.datecreated,cn.dateupdated,cn.status FROM ".KN_MASTER_CONTENT." AS cn INNER JOIN ".KN_USERS." AS u ON cn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlContent);
        return $ObjResult;
    }

    function fnDelContent($VarContentId='',$VarUpdatedBy='') {
        if(@$VarContentId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_CONTENT,$ArrUpdateData,array('id'=>$VarContentId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarContentId;
                $ArrResult['eid']							= urlencode(base64_encode($VarContentId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}   