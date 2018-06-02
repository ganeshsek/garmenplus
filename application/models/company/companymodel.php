<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class companymodel extends CI_Model {

    function fnCreateCompanyAccount($VarDatabaseName='') {
        $ObjMasterDbConn    = mysqli_connect('localhost', MASTERDBUSER, MASTERDBPASS); // connect server 1
        mysqli_select_db($ObjMasterDbConn,MASTERDBNAME);  // select database 1

        $ObjCompanyDbConn   = mysqli_connect('localhost', MASTERDBUSER, MASTERDBPASS); // connect server 2
        $VarTableStatus     = false;
        if(MASTERDBUSER=="root") {
            // Create database
            $VarDbQuery         = "CREATE DATABASE ".$VarDatabaseName;
            if($ObjCompanyDbConn->query($VarDbQuery)===TRUE) {
                $VarTableStatus = TRUE;
                mysqli_select_db($ObjCompanyDbConn,$VarDatabaseName); // select database 2
            }
        } else {
            if($this->fnCpanelCreateDatabase($VarDatabaseName)) {
                $VarTableStatus = TRUE;
                mysqli_select_db($ObjCompanyDbConn,"rsgtrend_".$VarDatabaseName); // select database 2
            }
        }
        if($VarTableStatus) {
            $ArrMasterTable = array('kn_master_accessories','kn_master_approval','kn_master_class','kn_master_content','kn_master_dry_processing_finishing','kn_master_dyeing_method','kn_master_dyeing_special_request','kn_master_embel_type','kn_master_fabric_type','kn_master_fabric_wash','kn_master_garment_part_desc','kn_master_garment_type','kn_master_garment_wash','kn_master_lab','kn_master_packing_code','kn_master_packing_material','kn_master_port','kn_master_print_type','kn_master_process_flow','kn_master_season','kn_master_sewing_trimming_type','kn_master_sewing_trimming_type','kn_master_size_range','kn_master_trimming_type','kn_master_unit_measure','kn_master_wet_processing_greige');
            foreach($ArrMasterTable as $VarMasterId=>$VarTableName) {
                $ArrTableInfo  = mysqli_fetch_array(mysqli_query($ObjMasterDbConn,"SHOW CREATE TABLE ".$VarTableName));
                mysqli_query($ObjCompanyDbConn,$ArrTableInfo[1]); // use found structure to make table on server 2
                $result = mysqli_query($ObjMasterDbConn,"SELECT * FROM ".$VarTableName); // select all content
                while ($row = mysqli_fetch_array($result, MYSQL_ASSOC) ) {
                    mysqli_query($ObjCompanyDbConn,"INSERT INTO ".$VarTableName." (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')"); // insert one row into new table
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function fnCpanelCreateDatabase($VarDatabaseName='') {
        $VarDbCreateURL             = "http://app.knit2020.com/xmlapi/dbcreate.php";
        $ObjDBCURL					= curl_init();
        curl_setopt($ObjDBCURL, CURLOPT_URL,$VarDbCreateURL);
        curl_setopt($ObjDBCURL, CURLOPT_POST, 1);
        curl_setopt($ObjDBCURL, CURLOPT_POSTFIELDS,"DBName=$VarDatabaseName");
        curl_setopt($ObjDBCURL, CURLOPT_RETURNTRANSFER, 1);
        $ObjRes						= curl_exec($ObjDBCURL);
        $info						= curl_getinfo($ObjDBCURL);
        curl_close($ObjDBCURL);
        if (empty($ObjRes)) {
            return false;
        } else {
            return true;
        }
    }

    function fnSaveCompanyInfo($ArrCompanyDetails=array()) {
        $VarCompanyCode                                   = $this->fnGenerateCompanyCode();
        if($VarCompanyCode>=1) {
            $VarDatabaseName                              = $VarCompanyCode."_knit2020";
            $ArrCompanyDetails['databasename']            = $VarDatabaseName;
            $ArrCompanyDetails['companycode']             = $VarCompanyCode;
            $this->db->insert(KN_COMPANY_DETAILS,$ArrCompanyDetails);
            $VarCompanyId                                 = $this->db->insert_id();
            if($VarCompanyId>=1) {
                $VarPassword                              = str_rand(8,'alpha');
                $ArrUserLoginTblInfo                      = array('status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'username'=>$VarCompanyCode,"password"=>base64_encode($VarPassword),'usertype'=>2,'updatedby'=>fnGetUserLoggedInfo(),'companyid'=>$VarCompanyId);
                $this->db->insert(KN_USERS,$ArrUserLoginTblInfo);
                $VarLoginId                               = $this->db->insert_id();
                if($VarLoginId>=1) {
                    $VarDatabaseStatus                    = $this->fnCreateCompanyAccount($VarDatabaseName);
                    if($VarDatabaseStatus) {
                        return $VarCompanyId;
                    }
                }
            }
        }
    }

    function fnGenerateCompanyCode() {
        $VarSqlCompanyCode                 = "select max(companycode) as companycode from ".KN_COMPANY_DETAILS." group by companycode";
        $ArrGenerateCompanyStatus          = $this->db->query($VarSqlCompanyCode)->result_array();
        $VarCompanyCode                    = $ArrGenerateCompanyStatus[0]['companycode'];
        if(@$VarCompanyCode=='') {
            $VarCompanyCode                = "10000";
        } else {
            $VarCompanyCode                = $VarCompanyCode+1;
        }
        $VarCompanyCode                    = str_rand(8,'numeric');
        return $VarCompanyCode;
    }

    function fnGetCompanyInfo($VarCompanyId='',$VarStatus='') {
        $this->db->select('id,companyname,companycode,databasename,businesstype,factorysize,address,noofmachine,city,state,country,zipcode,productioncapacity,annualturnover,noofemployee,noofcontract,factoryownership,majorcustomer,yearofest,exportcustomer,companyprofile,updatedby,status,datecreated,dateupdated');
        $this->db->from(KN_COMPANY_DETAILS);
        if($VarStatus=='') {
            $this->db->where_in('status',array(1,2,3));
        } else {
            $this->db->where_in('status',array(1));
        }
        if($VarCompanyId<>'') {
            $ArrWhere['id'] = $VarCompanyId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrCompanyList						= $this->db->get()->result_array();
        return $ArrCompanyList;
    }

    function fnCountCompany($VarCompanyName='',$VarEmail='',$VarMobile='',$VarCountry='',$VarCity='',$VarPhoneNo='',$VarState='',$VarCompanyStatus='',$VarBusinessType='',$VarContactName=''){
        $ArrWhere                   = $this->fnConstructCompanyWhereCond($VarCompanyName,$VarEmail,$VarMobile,$VarCountry,$VarCity,$VarPhoneNo,$VarState,$VarCompanyStatus,$VarBusinessType,$VarContactName);
        $VarWhere                   = '';
        if($ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        if($VarEmail<>'' || $VarMobile<>'' || $VarPhoneNo<>'' || $VarContactName<>'') {
            $VarSqlCompanyInfo      = "SELECT count(1) as trec FROM ".KN_USERS." as u INNER JOIN ".KN_COMPANY_DETAILS." AS c ON c.id=u.companyid INNER JOIN ".KN_COMPANY_CONTACT_DETAILS." as cc ON cc.companyid=c.id WHERE c.status=1 ".$VarWhere." group by c.id";
        } else {
           $VarSqlCompanyInfo      = "SELECT count(1) as trec FROM ".KN_USERS." as u INNER JOIN ".KN_COMPANY_DETAILS." AS c ON c.id=u.companyid WHERE c.status=1 ".$VarWhere." group by c.id";
        }
        $ObjRows					= $this->db->query($VarSqlCompanyInfo)->row();
        return $ObjRows->trec;
    }

    function fnListCompany($VarCompanyName='',$VarEmail='',$VarMobile='',$VarCountry='',$VarCity='',$VarPhoneNo='',$VarState='',$VarCompanyStatus='',$VarBusinessType='',$VarContactName='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array('1'=>'c.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'c.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = $this->fnConstructCompanyWhereCond($VarCompanyName,$VarEmail,$VarMobile,$VarCountry,$VarCity,$VarPhoneNo,$VarState,$VarCompanyStatus,$VarBusinessType,$VarContactName);
        $VarWhere                   = '';
        if($ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        if($VarEmail<>'' || $VarMobile<>'' || $VarPhoneNo<>'' || $VarContactName<>'') {
            $VarSqlCompanyInfo      = "SELECT c.companyname,u.username,c.businesstype,c.factoryownership,u.password,c.dateupdated,c.city,c.state,c.country,c.id FROM ".KN_USERS." as u INNER JOIN ".KN_COMPANY_DETAILS." AS c ON c.id=u.companyid INNER JOIN ".KN_COMPANY_CONTACT_DETAILS." as cc ON cc.companyid=c.id WHERE c.status=1 ".$VarWhere." group by c.id "." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        } else {
            //echo "Test";
            $VarSqlCompanyInfo      = "SELECT c.companyname,u.username,c.businesstype,c.factoryownership,u.password,c.dateupdated,c.city,c.state,c.country,c.id FROM ".KN_USERS." as u INNER JOIN ".KN_COMPANY_DETAILS." AS c ON c.id=u.companyid WHERE c.status=1 ".$VarWhere." group by c.id "." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        }
        $ObjResult					= $this->db->query($VarSqlCompanyInfo);
        return $ObjResult;
    }

    function fnConstructCompanyWhereCond($VarCompanyName='',$VarEmail='',$VarMobile='',$VarCountry='',$VarCity='',$VarPhoneNo='',$VarState='',$VarCompanyStatus='',$VarBusinessType='',$VarContactName='') {
        $ArrWhere                   = array();
        if($VarCompanyName<>'') {
            $ArrWhere[]             = "c.companyname like '%".$VarCompanyName."%'";
        }
        if($VarContactName<>'') {
            $ArrWhere[]             = "cc.contactname like '%".$VarContactName."%'";
        }
        if($VarEmail<>'') {
            $ArrWhere[]             = "cc.contactemail like '%".$VarEmail."%'";
        }
        if($VarMobile<>'') {
            $ArrWhere[]             = "cc.contactmobile like '%".$VarMobile."%'";
        }
        if($VarMobile<>'') {
            $ArrWhere[]             = "cc.contactphone like '%".$VarPhoneNo."%'";
        }
        if($VarCity<>'') {
            $ArrWhere[]             = "c.city like '%".$VarCity."%'";
        }
        if($VarState<>'') {
            $ArrWhere[]             = "c.state like '%".$VarState."%'";
        }
        if($VarBusinessType<>'') {
            $ArrWhere[]             = "c.businesstype=".$VarBusinessType;
        }
        if($VarCountry<>'') {
            $ArrWhere[]             = "c.country=".$VarCountry;
        }
        if(@$VarCompanyStatus[0]<>'') {
            $ArrWhere[]             = "c.status in(".implode(",",$VarCompanyStatus).")";
        }
        return $ArrWhere;
    }

    function fnCountCompanyContact($VarCompanyId=''){
        $this->db->select('id');
        $this->db->from(KN_COMPANY_CONTACT_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	= $VarCompanyId;
        }
        if(count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $VarCount = $this->db->get()->num_rows();
        return $VarCount;
    }

    function fnListCompanyContact($VarCompanyId='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'contactname',"2"=>'dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dateupdated';
        $this->db->select('id,companyid,contactname,contactemail,contactmobile,contactdesignation,contactphone,status,updatedby,datecreated,dateupdated');
        $this->db->from(KN_COMPANY_CONTACT_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	= $VarCompanyId;
        }
        if(count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by($VarSortBy,$VarSortOrder);
        $this->db->limit($VarLimit, $offset);
        $ArrResult					= $this->db->get();
        return $ArrResult;
    }

    function fnGetCompanyContactInfo($VarCompanyId='',$VarContactId='') {
        $this->db->select('id,companyid,contactname,contactemail,contactmobile,contactdesignation,contactphone,status,updatedby,datecreated,dateupdated');
        $this->db->from(KN_COMPANY_CONTACT_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	= $VarCompanyId;
        }
        if($VarContactId<>'') {
            $ArrWhere['id']                 = $VarContactId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrFactoryList						= $this->db->get()->result_array();
        return $ArrFactoryList;
    }

    function fnUpdateCompanyBasicInfo($ArrCompanyBasicInfo,$VarCompanyId) {
        $VarResult = $this->db->update(KN_COMPANY_DETAILS,$ArrCompanyBasicInfo,array('id'=>$VarCompanyId));
        return $VarResult;
    }

    function fnSaveCompanyContactInfo($ArrCompanyContactInfo) {
        $this->db->insert(KN_COMPANY_CONTACT_DETAILS,$ArrCompanyContactInfo);
        return $this->db->insert_id();
    }

    function fnUpdateCompanyContactInfo($ArrCompanyContactInfo,$VarContactId) {
        $VarResult = $this->db->update(KN_COMPANY_CONTACT_DETAILS,$ArrCompanyContactInfo,array('id'=>$VarContactId));
        return $VarResult;
    }

    function fnSaveCompanyMachineInfo($ArrCompanyMachineInfo) {
        $this->db->insert(KN_COMPANY_MACHINE_DETAILS,$ArrCompanyMachineInfo);
        return $this->db->insert_id();
    }

    function fnUpdateCompanyMachineInfo($ArrCompanyMachineInfo,$VarMachineId) {
        $VarResult = $this->db->update(KN_COMPANY_MACHINE_DETAILS,$ArrCompanyMachineInfo,array('id'=>$VarMachineId));
        return $VarResult;
    }

    function fnCountCompanyMachine($VarCompanyId=''){
        $this->db->select('id');
        $this->db->from(KN_COMPANY_MACHINE_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	= $VarCompanyId;
        }
        if(count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $VarCount = $this->db->get()->num_rows();
        return $VarCount;
    }

    function fnListCompanyMachine($VarCompanyId='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'contactname',"2"=>'dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dateupdated';
        $this->db->select('id,companyid,machineflag,machinetype,numberofmachine,status,updatedby,datecreated,dateupdated');
        $this->db->from(KN_COMPANY_MACHINE_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	= $VarCompanyId;
        }
        if(count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by($VarSortBy,$VarSortOrder);
        $this->db->limit($VarLimit, $offset);
        $ArrResult					= $this->db->get();
        return $ArrResult;
    }

    function fnGetCompanyMachineInfo($VarCompanyId='',$VarMachineId='') {
        $this->db->select('id,companyid,machineflag,machinetype,numberofmachine,status,updatedby,datecreated,dateupdated');
        $this->db->from(KN_COMPANY_MACHINE_DETAILS);
        if($VarCompanyId<>'') {
            $ArrWhere['companyid']	        = $VarCompanyId;
        }
        if($VarMachineId<>'') {
            $ArrWhere['id']                 = $VarMachineId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrMachineList						= $this->db->get()->result_array();
        return $ArrMachineList;
    }

}