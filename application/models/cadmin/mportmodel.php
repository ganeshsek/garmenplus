<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class mportmodel extends CI_Model {

    function fnGetPortInfo($VarPort='',$VarStatus='',$VarId='') {
        $this->db->select('id,portname,portaddress,portcity,portstate,portcountry,updatedby,status,datecreated,dateupdated'); // Select field
        $this->db->from(KN_MASTER_PORT);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarId<>'') {
            $ArrWhere['id'] 				= $VarId;
        }
        if($VarPort<>'') {
            $ArrWhere['portname'] 		= $VarPort;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrResultList	    	    		= $this->db->get()->result_array();
        return $ArrResultList;
    }

    function fnCheckPort($VarPort='',$VarId='') {
        $this->db->select('id,portname,portaddress,portcity,portstate,portcountry,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_MASTER_PORT);
        $ArrWhere = array('status'=>"1");
        if($VarId<>'') {
            $this->db->where_not_in('id',array($VarId));
        }
        if($VarPort<>'') {
            $ArrWhere['portname']		= $VarPort;
        }
        $this->db->where($ArrWhere);
        $ObjResult  					= $this->db->get();
        $ArrResultList					= $ObjResult->result_array();
        return $ArrResultList;
    }

    function savePortInfo($ArrUpdateData){
        $VarId                                                  = $ArrUpdateData['id'];
        if($VarId=="") {
            $ArrCheckExist			       					    = $this->fnGetPortInfo($ArrUpdateData['portname'],1);
            if(@$ArrCheckExist['id']=='' && @$ArrCheckExist['id']==0) {
                unset($ArrUpdateData['id']);
                $this->db->insert(KN_MASTER_PORT,$ArrUpdateData);
                $VarId                                          = $this->db->insert_id();
                $ArrResult['errcode']						    = 1;
                $ArrResult['msg']							    = '';
                $ArrResult['id']							    = $VarId;
                $ArrResult['eid']							    = urlencode(base64_encode($VarId));
            } else {
                $ArrResult['errcode']							= '-1';
                $ArrResult['msg']								= "This port name already exists!!";
            }
        } else {
            $ArrCheckExist									    = $this->fnCheckPort($ArrUpdateData['portname'],$VarId);
            if(@$ArrCheckExist['id']=='' && $ArrUpdateData['portname']<>'') {
                if($this->db->update(KN_MASTER_PORT,$ArrUpdateData,array('id'=>$VarId))) {
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
                $ArrResult['msg']							    = "This port has already Exist!";
            }
        }
        return $ArrResult;
    }

    function fnCountPort($VarPortName='',$VarPortAddress='',$VarPortCity='',$VarPortCountry='',$VarStatus=''){
        $ArrWhere                   = array();
        if($VarPortName<>'') {
            $ArrWhere[]             = "pn.portname like '%".$VarPortName."%'";
        }
        if($VarPortAddress<>'') {
            $ArrWhere[]             = "pn.portaddress like '%".$VarPortAddress."%'";
        }
        if($VarPortCity<>'') {
            $ArrWhere[]             = "pn.portcity like '%".$VarPortCity."%'";
        }
        if($VarPortCountry<>'') {
            $ArrWhere[]             = "pn.portcountry=".$VarPortCountry;
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
        $VarSqlPort                 = "SELECT count(1) as trec  FROM ".KN_MASTER_PORT." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlPort)->row();
        return $ObjRows->trec;
    }

    function fnListPort($VarPortName='',$VarPortAddress='',$VarPortCity='',$VarPortCountry='',$VarStatus='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'pn.portname','2'=>'pn.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'pn.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarPortName<>'') {
            $ArrWhere[]             = "pn.portname like '%".$VarPortName."%'";
        }
        if($VarPortAddress<>'') {
            $ArrWhere[]             = "pn.portaddress like '%".$VarPortAddress."%'";
        }
        if($VarPortCity<>'') {
            $ArrWhere[]             = "pn.portcity like '%".$VarPortCity."%'";
        }
        if($VarPortCountry<>'') {
            $ArrWhere[]             = "pn.portcountry=".$VarPortCountry;
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
        $VarSqlPort          = "SELECT pn.id,pn.portname,u.contactname,pn.datecreated,pn.dateupdated,pn.status,pn.portaddress,pn.portcity,pn.portstate,pn.portcountry FROM ".KN_MASTER_PORT." AS pn INNER JOIN ".KN_USERS." AS u ON pn.updatedby = u.id WHERE ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlPort);
        return $ObjResult;
    }

    function fnDelPort($VarPortId='',$VarUpdatedBy='') {
        if(@$VarPortId>=1) {
            $ArrUpdateData          = array('status'=>3,'dateupdated'=>date('Y-m-d H:i:s'),'updatedby'=>$VarUpdatedBy);
            if($this->db->update(KN_MASTER_PORT,$ArrUpdateData,array('id'=>$VarPortId))) {
                $ArrResult['errcode']					    = 1;
                $ArrResult['msg']							= '';
                $ArrResult['id']							= $VarPortId;
                $ArrResult['eid']							= urlencode(base64_encode($VarPortId));
            } else {
                $ArrResult['errcode']						= '-1';
                $ArrResult['msg']							= 'Invalid Data!';
            }
        }
        return $ArrResult;
    }

}