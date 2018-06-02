<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mdyeingmodel extends CI_Model {

    function fnGetDyeingMethodInfo($VarMethodName='',$VarStatus='',$VarId='') {
        $this->db->select('id,dyeingname,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_DYEING_METHOD);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarMethodName<>'') {
            $ArrWhere['dyeingname'] 		= $VarMethodName;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckDyeingMethod($VarMethodName='',$VarId='') {
        $this->db->select('id,dyeingname,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_DYEING_METHOD);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarMethodName<>'') {
            $ArrWhere['dyeingname']		= $VarMethodName;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function saveDyeingMethodInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetDyeingMethodInfo($ArrUpdateData['dyeingname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_DYEING_METHOD,$ArrUpdateData);
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
            $ArrCheckExist									    = $this->fnCheckDyeingMethod($ArrUpdateData['dyeingname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['dyeingname']<>'') {
                if($this->db->update(KN_MASTER_DYEING_METHOD,$ArrUpdateData,array('id'=>$VarId))) {
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

    function fnCountDyeingMethod($VarMethodName='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarMethodName<>'') {
            $ArrWhere[]             = "d.dyeingname like '%".$VarMethodName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "d.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "d.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSelectDyeing            = "SELECT count(1) as trec  FROM ".KN_MASTER_DYEING_METHOD." AS d INNER JOIN ".KN_USERS." AS u ON d.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSelectDyeing)->row();
        return $ObjRows->trec;
    }

    function fnListDyeingMethod($VarMethodName='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'d.dyeingname','2'=>'d.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'd.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarMethodName<>'') {
            $ArrWhere[]             = "d.dyeingname like '%".$VarMethodName."%'";
        }
        if($VarStatus<>'') {
            $ArrWhere[]             = "d.status=".$VarStatus;
        } else {
            $ArrWhere[]             = "d.status in(1,2)";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest         = "SELECT d.id,d.dyeingname,u.contactname,d.datecreated,d.dateupdated,d.status FROM ".KN_MASTER_DYEING_METHOD." AS d INNER JOIN ".KN_USERS." AS u ON d.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAssignaTest);
        return $ObjResult;
    }

    function fnDelDeyingMethod($VarMethodId='',$VarUpdatedBy='') {
        if(@$VarMethodId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_DYEING_METHOD,$ArrUpdateData,array('id'=>$VarMethodId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarMethodId;
                $ArrResult['eid']							= urlencode(base64_encode($VarMethodId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}