<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mlabmodel extends CI_Model {

    function fnGetLabInfo($VarLab='',$VarStatus='',$VarId='') {
        $this->db->select('id,labname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_LAB);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				                = $VarId;
        }
        if($VarLab<>'') {
            $ArrWhere['labname'] 		                    = $VarLab;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		                = $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckLab($VarLab='',$VarId='') {
        $this->db->select('id,labname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_LAB);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarLab<>'') {
            $ArrWhere['labname']		                        = $VarLab;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					                        = $this->db->get();
        $ArrResultList					                        = $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveLabInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetLabInfo($ArrUpdateData['labname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_LAB,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This lab already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckLab($ArrUpdateData['labname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['labname']<>'') {
                if($this->db->update(KN_MASTER_LAB,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This lab has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountLab($VarLab='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarLab<>'') {
            $ArrWhere[]             = "ln.labname like '%".$VarLab."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "ln.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "ln.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlLab                  = "SELECT count(1) as trec  FROM ".KN_MASTER_LAB." AS ln INNER JOIN ".KN_USERS." AS u ON ln.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlLab)->row();
        return $ObjRows->trec;
    }

    function fnListLab($VarLab='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'ln.labname','2'=>'ln.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'ln.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarLab<>'') {
            $ArrWhere[]             = "ln.labname like '%".$VarLab."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "ln.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "ln.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlLab                  = "SELECT ln.id,ln.labname,u.contactname,ln.datecreated,ln.dateupdated,ln.status FROM ".KN_MASTER_LAB." AS ln INNER JOIN ".KN_USERS." AS u ON ln.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlLab);
        return $ObjResult;
    }

    function fnDelLab($VarLabId='',$VarUpdatedBy='') {
        if(@$VarLabId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_LAB,$ArrUpdateData,array('id'=>$VarLabId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarLabId;
                $ArrResult['eid']							= urlencode(base64_encode($VarLabId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}   