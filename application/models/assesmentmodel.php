<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class assesmentmodel extends CI_Model {

    function fnGetAssessmentTestInfo($VarTestId='',$VarStatus='') {
        $this->db->select('id,testname,numberofquestion,instructions,marks,numberofstudent,status,datecreated,dateupdated'); // Select field
        $this->db->from(KP_ASSESSMENT_TEST);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarTestId<>'') {
            $ArrWhere['id'] 				= $VarTestId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrAssessmentList		    		= $this->db->get()->result_array();
        return $ArrAssessmentList;
    }

    function fnSaveAssessmentInfo($ArrAssessmentTestInfo){
        $this->db->insert(KP_ASSESSMENT_TEST,$ArrAssessmentTestInfo);
        return $this->db->insert_id();
    }

    function fnSaveAssessmentQuestionInfo($ArrAssessmentTestInfo){
        $this->db->insert(KP_ASSESSMENT_TEST_QUESTIONNAIRE_SETTINGS,$ArrAssessmentTestInfo);
        return $this->db->insert_id();
    }

    function fnSaveAssessmentOtherSettings($ArrAssessmentTestInfo){
        $this->db->insert(KP_ASSESSMENT_TEST_OTHERS,$ArrAssessmentTestInfo);
        return $this->db->insert_id();
    }

    function fnSaveAssessmentMaterial($ArrAssessmentTestInfo){
        $this->db->insert(KP_ASSESSMENT_TEST_MATERIAL,$ArrAssessmentTestInfo);
        return $this->db->insert_id();
    }

    function fnCountAssessmentTest($VarTestName=''){
        $this->db->select('id');
        $this->db->from(KP_ASSESSMENT_TEST);
        if($VarTestName<>'') {
            $this->db->like('testname', $VarTestName);
        }
        $VarCount = $this->db->get()->num_rows();
        return $VarCount;
    }

    function fnListAssessmentTest($VarTestName='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'testname',"2"=>'dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dateupdated';
        $this->db->select('id,testname,numberofquestion,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST);
        if($VarTestName<>'') {
            $this->db->like('testname', $VarTestName);
        }
        $this->db->order_by($VarSortBy,$VarSortOrder);
        $this->db->limit($VarLimit, $offset);
        $ArrResult					= $this->db->get();

        return $ArrResult;
    }

    function fnSaveAssignTest($ArrAssessmentTestInfo){
        $this->db->insert(KP_ASSESSMENT_TEST_SCHOOL,$ArrAssessmentTestInfo);
        return $this->db->insert_id();
    }

    function fnCountAssignTest($VarTestName='',$VarSchoolName=''){
        $ArrWhere                   = array();
        if($VarTestName<>'') {
            $ArrWhere[]             = "t.testname like '%".$VarTestName."%'";
        }
        if($VarSchoolName<>'') {
            $ArrWhere[]             = "s.schoolname like '%".$VarSchoolName."%'";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest          = "SELECT count(1) as trec  FROM ".KP_ASSESSMENT_TEST." AS t INNER JOIN ".KP_ASSESSMENT_TEST_SCHOOL." AS a ON t.id = a.testid INNER JOIN ".KP_USERS." AS s ON s.id=a.schoolid  WHERE a.status=1 ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlAssignaTest)->row();
        return $ObjRows->trec;
    }

    function fnListAssignTest($VarTestName='',$VarSchoolName='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'t.testname','2'=>'a.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'a.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarTestName<>'') {
            $ArrWhere[]             = "t.testname like '%".$VarTestName."%'";
        }
        if($VarSchoolName<>'') {
            $ArrWhere[]             = "s.schoolname like '%".$VarSchoolName."%'";
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest         = "SELECT a.id,t.testname,s.schoolname,a.datecreated,a.completionstatus,a.assigneddate,a.linkstatus,t.id as testid FROM ".KP_ASSESSMENT_TEST." AS t INNER JOIN ".KP_ASSESSMENT_TEST_SCHOOL." AS a ON t.id = a.testid INNER JOIN ".KP_USERS." AS s ON s.id=a.schoolid  WHERE a.status=1 ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAssignaTest);
        return $ObjResult;
    }

    function fnCountMyAssessmentTest($VarTestName='',$VarSchoolId=''){
        $ArrWhere                   = array();
        if($VarTestName<>'') {
            $ArrWhere[]             = "t.testname like '%".$VarTestName."%'";
        }
        if($VarSchoolId<>'') {
            $ArrWhere[]             = "a.schoolid=".$VarSchoolId;
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest          = "SELECT count(1) as trec  FROM ".KP_ASSESSMENT_TEST." AS t INNER JOIN ".KP_ASSESSMENT_TEST_SCHOOL." AS a ON t.id = a.testid INNER JOIN ".KP_USERS." AS s ON s.id=a.schoolid  WHERE a.status=1 ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlAssignaTest)->row();
        return $ObjRows->trec;
    }

    function fnListMyAssessmentTest($VarTestName='',$VarSchoolId='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'t.testname','2'=>'a.dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'a.dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarTestName<>'') {
            $ArrWhere[]             = "t.testname like '%".$VarTestName."%'";
        }
        if($VarSchoolId<>'') {
            $ArrWhere[]             = "a.schoolid=".$VarSchoolId;
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest         = "SELECT a.id,t.testname,s.schoolname,a.datecreated,a.completionstatus,a.assigneddate,a.linkstatus,t.marks,t.numberofquestion,t.numberofstudent FROM ".KP_ASSESSMENT_TEST." AS t INNER JOIN ".KP_ASSESSMENT_TEST_SCHOOL." AS a ON t.id = a.testid INNER JOIN ".KP_USERS." AS s ON s.id=a.schoolid  WHERE a.status=1 ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAssignaTest);
        return $ObjResult;
    }

    function fnGetAssignSchoolInfo($VarAssignId='',$VarStatus='') {
        $this->db->select('id,testid,schoolid,assigneddate,completionstatus,linkstatus,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_SCHOOL);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarAssignId<>'') {
            $ArrWhere['id'] 				= $VarAssignId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrAssessmentList		    		= $this->db->get()->result_array();
        return $ArrAssessmentList;
    }

    function fnGetAssessmentTestMaterialInfo($VarAssessmentTestId='',$VarStatus='') {
        $this->db->select('id,testid,materialtype,filename,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_MATERIAL);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarAssessmentTestId<>'') {
            $ArrWhere['testid'] 		    = $VarAssessmentTestId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrAssessmentMaterialList	  		= $this->db->get()->result_array();
        //print_r($this->db);
        $ArrFnlMaterialList                 = array();
        $i=0;
        foreach($ArrAssessmentMaterialList as $VarKey=>$ArrMaterialInfo) {
            $ArrFnlMaterialList[$i]['id']   = $ArrMaterialInfo['id'];
            $ArrFnlMaterialList[$i]['tid']  = $ArrMaterialInfo['testid'];
            $ArrFnlMaterialList[$i]['mt']   = $ArrMaterialInfo['materialtype'];
            $ArrFnlMaterialList[$i]['fn']   = $ArrMaterialInfo['filename'];
            $i                              = $i+1;
        }
        return $ArrFnlMaterialList;
    }

    function fnGetAssessmentTestTeacherInfo($VarAssessmentTestId='',$VarAssignId='',$VarStatus='',$VarTeacherId='') {
        $this->db->select('id,testid,schoolid,numberofstudent,assignid,sectionname,teachername,examdate,updatedby,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_SCHOOL_TEACHER);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarAssessmentTestId<>'') {
            $ArrWhere['testid'] 		    = $VarAssessmentTestId;
        }
        if($VarAssignId<>'') {
            $ArrWhere['assignid'] 		    = $VarAssignId;
        }
        if($VarTeacherId<>'') {
            $ArrWhere['id'] 		        = $VarTeacherId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $ArrTeacherList	  		            = $this->db->get()->result_array();
        $ArrFnlMaterialList                 = array();
        $i=0;
        foreach($ArrTeacherList as $VarKey=>$ArrTeacherInfo) {
            $ArrFnlMaterialList[$i]['id']   = $ArrTeacherInfo['id'];
            $ArrFnlMaterialList[$i]['tid']  = $ArrTeacherInfo['testid'];
            $ArrFnlMaterialList[$i]['aid']  = $ArrTeacherInfo['assignid'];
            $ArrFnlMaterialList[$i]['nos']  = $ArrTeacherInfo['numberofstudent'];
            $ArrFnlMaterialList[$i]['sn']   = $ArrTeacherInfo['sectionname'];
            $ArrFnlMaterialList[$i]['tn']   = $ArrTeacherInfo['teachername'];
            $ArrFnlMaterialList[$i]['ed']   = date('d M Y',strtotime($ArrTeacherInfo['examdate']));
            $i                              = $i+1;
        }
        return $ArrFnlMaterialList;
    }

    function fnSaveTestTeacherInfo($ArrTeacherInfo){
        $this->db->insert(KP_ASSESSMENT_TEST_SCHOOL_TEACHER,$ArrTeacherInfo);
        return $this->db->insert_id();
    }

    function fnCountMyAssessmentTeacherList($VarAssessmentTestId='',$VarAssessmentAssignId=''){
        $ArrWhere                   = array();
        if($VarAssessmentTestId<>'') {
            $ArrWhere[]             = "testid=".$VarAssessmentTestId;
        }
        if($VarAssessmentAssignId<>'') {
            $ArrWhere[]             = "assignid=".$VarAssessmentAssignId;
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest          = "SELECT count(1) as trec  FROM ".KP_ASSESSMENT_TEST_SCHOOL_TEACHER." WHERE status=1 ".$VarWhere;
        $ObjRows					= $this->db->query($VarSqlAssignaTest)->row();
        return $ObjRows->trec;
    }

    function fnListMyAssessmentTeacherList($VarAssessmentTestId='',$VarAssessmentAssignId='',$VarLimit = 10, $offset = 0,$VarSortBy,$VarSortOrder){
        $VarSortOrder				= ($VarSortOrder=='desc')? 'desc' : 'asc';
        $VarSortCols				= array("1"=>'teachername','2'=>'dateupdated');
        $VarSortBy					= (in_array($VarSortBy,$VarSortCols)) ? $VarSortBy : 'dateupdated';
        $VarLimitInfo				= $VarLimit;
        if($offset>=1) {$VarLimitInfo	 = $offset.",".$VarLimit;}
        $ArrWhere                   = array();
        if($VarAssessmentTestId<>'') {
            $ArrWhere[]             = "testid=".$VarAssessmentTestId;
        }
        if($VarAssessmentAssignId<>'') {
            $ArrWhere[]             = "assignid=".$VarAssessmentAssignId;
        }
        $VarWhere                   = '';
        if(@$ArrWhere[0]<>'') {
            $VarWhere               = " and ".implode(" and ",$ArrWhere);
        }
        $VarSqlAssignaTest         = "SELECT id,testid,numberofsession,schoolid,numberofstudent,assignid,sectionname,teachername,examdate,updatedby,status,datecreated,dateupdated FROM ".KP_ASSESSMENT_TEST_SCHOOL_TEACHER." WHERE status=1 ".$VarWhere." order by ".$VarSortBy." ".$VarSortOrder." limit ".$VarLimitInfo;
        $ObjResult					= $this->db->query($VarSqlAssignaTest);
        return $ObjResult;
    }

    function fnGetAssessmentTestQuestionInfo($VarAssessmentTestId='',$VarStatus='') {
        $this->db->select('id,testid,questionno,questiontype,marks,displayformat,noofanswer,correctanswera,correctanswerb,correctanswerc,status,displayanswer');
        $this->db->from(KP_ASSESSMENT_TEST_QUESTIONNAIRE_SETTINGS);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarAssessmentTestId<>'') {
            $ArrWhere['testid'] 			= $VarAssessmentTestId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by("questionno","asc");
        $ArrAssessmentQuestionSettingsList  = $this->db->get()->result_array();
        return $ArrAssessmentQuestionSettingsList;
    }

    function fnGetAssessmentTestQuestionOthersInfo($VarAssessmentTestId='',$VarStatus='') {
        $this->db->select('id,testid,moduletype,valueset1,valueset2,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_OTHERS);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarAssessmentTestId<>'') {
            $ArrWhere['testid'] 			= $VarAssessmentTestId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by("moduletype","asc");
        $ArrAssessmentQuestionSettingsList  = $this->db->get()->result_array();
        return $ArrAssessmentQuestionSettingsList;
    }

    function fnSaveStudentAnswers($VarStudentName='',$VarStudentAnswer='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='',$VarSchoolId='') {
        $ArrDBAnswerVal                 = $this->fnGetCalAnswerVal($VarAssessmentTestId,$VarStudentAnswer);
        if(@$ArrDBAnswerVal[1]['qt']>=1) {
            $ArrStudentMarks            = $this->fnGetCalStudentMarks($VarAssessmentTestId,$VarStudentAnswer,$ArrDBAnswerVal);
            $VarResultId                = $this->fnSaveStudentResults($VarAssessmentTestId,$VarAssignId,$VarTeacherId,$VarSchoolId,$ArrStudentMarks,$VarStudentName);
        }
        return $VarResultId;
    }

    function fnSaveStudentResults($VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='',$VarSchoolId='',$ArrStudentMarks=array(),$VarStudentName=array()) {
        $VarTotalMark                    = $ArrStudentMarks['tm'];
        $ArrResultDetails                = $ArrStudentMarks['md'];
        $ArrResultInfo                   = array('studentname'=>$VarStudentName,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'score'=>$VarTotalMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'));
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE,$ArrResultInfo);
        $VarAnswerId                     = $this->db->insert_id();
        if($VarAnswerId>=1) {
            foreach($ArrResultDetails as $VarQuestionNo=>$ArrAnswerInfo) {
                $ArrResultInfo           = array('questionno'=>$VarQuestionNo,'correctans'=>$ArrAnswerInfo['ca'],'selectedans'=>$ArrAnswerInfo['sa'],'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$ArrAnswerInfo['m'],'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
                $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_DETAILS,$ArrResultInfo);
                $VarAnswerDetailsId      = $this->db->insert_id();
            }
            if($VarAnswerDetailsId>=1) {
                $VarStatusOtherMarks    = $this->fnGetCalQuestionOtherSettings($VarAssessmentTestId,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
            }
            $this->fnSaveAssessmentTestStatsInfo($VarAssessmentTestId,$VarTeacherId,$VarAssignId);
        }
        return $VarAnswerId;
    }

    function fnSaveAssessmentTestStatsInfo($VarAssessmentTestId='',$VarTeacherId='',$VarAssignId='') {
        $SqlQuery                       = "update ".KP_ASSESSMENT_TEST_SCHOOL." set numberofstudent=numberofstudent+1 where testid=".$VarAssessmentTestId." and id=".$VarAssignId;
        $ObjRows					    = $this->db->query($SqlQuery);
        $SqlQuery                       = "update ".KP_ASSESSMENT_TEST_SCHOOL_TEACHER." set numberofstudent=numberofstudent+1 where testid=".$VarAssessmentTestId." and assignid=".$VarAssignId." and id=".$VarTeacherId;
        $ObjRows					    = $this->db->query($SqlQuery);
    }

    function fnGetCalQuestionOtherSettings($VarAssessmentTestId='',$ArrStudentMarks='',$VarAnswerId='',$VarAssignId='',$VarTeacherId='') {
        $ArrOtherSettingsInfo           = $this->fnGetAssessmentTestQuestionOthersInfo($VarAssessmentTestId,1);
        $ArrOtherSettingsDetails        = array();
        foreach($ArrOtherSettingsInfo as $VarKey=>$ArrOtherSettingsInfo) {
            $ArrOtherSettingsDetails[$ArrOtherSettingsInfo['moduletype']]['vs1'] = $ArrOtherSettingsInfo['valueset1'];
            $ArrOtherSettingsDetails[$ArrOtherSettingsInfo['moduletype']]['vs2'] = $ArrOtherSettingsInfo['valueset2'];
        }
        $VarSaveListSentMarkId          = $this->fnSaveListSentenceMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        if($VarSaveListSentMarkId>=1) {
            $VarSaveListWordMarkId          = $this->fnSaveListWordMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarSaveListWordMarkId>=1) {
            $VarSaveReadSentFluencyMark     = $this->fnSaveReadSentFluencyMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarSaveReadSentFluencyMark>=1) {
            $VarSaveReadWordVocaMark        = $this->fnSaveReadWordVocaMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarSaveReadWordVocaMark>=1) {
            $VarReadStoryCompMark        = $this->fnSaveReadStoryCompMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarReadStoryCompMark>=1) {
            $VarReadRememberMark        = $this->fnSaveRememberMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarReadRememberMark>=1) {
            $VarUnderstandMark        = $this->fnSaveUnderstandMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
        if($VarUnderstandMark>=1) {
            $VarApplyMark             = $this->fnSaveApplyMark($ArrOtherSettingsDetails,$ArrStudentMarks,$VarAnswerId,$VarAssessmentTestId,$VarAssignId,$VarTeacherId);
        }
    }

    function fnSaveApplyMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark1=$VarMark2=$VarMark = 0;
        $VarActualMark=$VarActualMark1=$VarActualMark2 = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[8]['vs1']);
        $ArrQuestionIdList1             = explode(",",$ArrOtherSettingsDetails[8]['vs2']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark1                   = $VarMark1+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark1             = $VarActualMark1+$ArrDBMarkList[$VarQuestionId];
        }
        foreach($ArrQuestionIdList1 as $VarKey=>$VarQuestionId) {
            $VarMark2                   = $VarMark2+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark2             = $VarActualMark2+$ArrDBMarkList[$VarQuestionId];
        }
        $VarMark1                       = ($VarMark1/$VarActualMark1)*count($ArrQuestionIdList)*1.5;
        $VarActualMark1                 = ($VarActualMark1/$VarActualMark1)*count($ArrQuestionIdList)*1.5;
        $VarMark                        = $VarMark1+$VarMark2;
        $VarActualMark                  = $VarActualMark1+$VarActualMark2;
        $ArrResultInfo                  = array('moduletype'=>8,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveUnderstandMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark1=$VarMark2=$VarMark = 0;
        $VarActualMark=$VarActualMark1=$VarActualMark2 = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[7]['vs1']);
        $ArrQuestionIdList1             = explode(",",$ArrOtherSettingsDetails[7]['vs2']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark1                   = $VarMark1+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark1             = $VarActualMark1+$ArrDBMarkList[$VarQuestionId];
        }
        foreach($ArrQuestionIdList1 as $VarKey=>$VarQuestionId) {
            $VarMark2                   = $VarMark2+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark2             = $VarActualMark2+$ArrDBMarkList[$VarQuestionId];
        }
        $VarMark2                       = ($VarMark2/$VarActualMark2)*count($ArrQuestionIdList1);
        $VarActualMark2                 = ($VarActualMark2/$VarActualMark2)*count($ArrQuestionIdList1);

        $VarMark                        = $VarMark1+$VarMark2;
        $VarActualMark                  = $VarActualMark1+$VarActualMark2;
        $ArrResultInfo                  = array('moduletype'=>7,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveRememberMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark                        = 0;
        $VarActualMark                  = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[6]['vs1']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark                    = $VarMark+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark              = $VarActualMark+$ArrDBMarkList[$VarQuestionId];
        }
        $ArrResultInfo                  = array('moduletype'=>6,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveReadStoryCompMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark                        = 0;
        $VarActualMark                  = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[5]['vs1']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark                    = $VarMark+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark              = $VarActualMark+$ArrDBMarkList[$VarQuestionId];
        }
        $ArrResultInfo                  = array('moduletype'=>5,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveReadWordVocaMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark1=$VarMark2=$VarMark = 0;
        $VarActualMark=$VarActualMark1=$VarActualMark2 = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[4]['vs1']);
        $ArrQuestionIdList1             = explode(",",$ArrOtherSettingsDetails[4]['vs2']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark1                   = $VarMark1+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark1             = $VarActualMark1+$ArrDBMarkList[$VarQuestionId];
        }
        foreach($ArrQuestionIdList1 as $VarKey=>$VarQuestionId) {
            $VarMark2                   = $VarMark2+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark2             = $VarActualMark2+$ArrDBMarkList[$VarQuestionId];
        }
        $VarMark1                       = ($VarMark1/$VarActualMark1)*count($ArrQuestionIdList)*1.5;
        $VarActualMark1                 = ($VarActualMark1/$VarActualMark1)*count($ArrQuestionIdList)*1.5;
        $VarMark                        = $VarMark1+$VarMark2;
        $VarActualMark                  = $VarActualMark1+$VarActualMark2;
        $ArrResultInfo                  = array('moduletype'=>4,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveReadSentFluencyMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark                        = 0;
        $VarActualMark                  = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[3]['vs1']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark                    = $VarMark+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark              = $VarActualMark+$ArrDBMarkList[$VarQuestionId];
        }
        $VarMark                        = ($VarMark/$VarActualMark)*count($ArrQuestionIdList);
        $VarActualMark                  = ($VarActualMark/$VarActualMark)*count($ArrQuestionIdList);
        $ArrResultInfo                  = array('moduletype'=>3,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveListWordMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark                        = 0;
        $VarActualMark                  = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[2]['vs1']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark                    = $VarMark+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark              = $VarActualMark+$ArrDBMarkList[$VarQuestionId];
        }
        $ArrResultInfo                  = array('moduletype'=>2,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnSaveListSentenceMark($ArrOtherSettingsDetails=array(),$ArrStudentMarks=array(),$VarAnswerId='',$VarAssessmentTestId='',$VarAssignId='',$VarTeacherId='') {
        $ArrStudentMarkList             = $ArrStudentMarks['ml'];
        $ArrDBMarkList                  = $ArrStudentMarks['dml'];
        $VarMark                        = 0;
        $VarActualMark                  = 0;
        $ArrQuestionIdList              = explode(",",$ArrOtherSettingsDetails[1]['vs1']);
        foreach($ArrQuestionIdList as $VarKey=>$VarQuestionId) {
            $VarMark                    = $VarMark+$ArrStudentMarkList[$VarQuestionId];
            $VarActualMark              = $VarActualMark+$ArrDBMarkList[$VarQuestionId];
        }
        $ArrResultInfo                  = array('moduletype'=>1,'testid'=>$VarAssessmentTestId,'assignid'=>$VarAssignId,'teacherid'=>$VarTeacherId,'marks'=>$VarMark,'actualmark'=>$VarActualMark,'status'=>1,'datecreated'=>date('Y-m-d H:i:s'),'dateupdated'=>date('Y-m-d H:i:s'),'scoreid'=>$VarAnswerId);
        $this->db->insert(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER,$ArrResultInfo);
        $VarInsertId                     = $this->db->insert_id();
        return $VarInsertId;
    }

    function fnGetCalStudentMarks($VarAssessmentTestId='',$VarStudentAnswer='',$ArrDBAnswerVal=array()) {
        $ArrStudentMarks                 = array();
        $ArrDBMarkList                   = array();
        $ArrStudentAnswers               = explode("|#|",$VarStudentAnswer);
        $VarNumberOfQuestion             = count($ArrStudentAnswers);
        $VarQuestionNo                   = 1;
        $VarTotalMark                    = 0;
        for($i=0;$i<$VarNumberOfQuestion;$i++) {
            if(@$ArrDBAnswerVal[$i]['qt']>=1) {
                $VarQuestionType            = @$ArrDBAnswerVal[$i]['qt'];
                $VarCorrectAnswer           = @$ArrDBAnswerVal[$i]['ca'];
                $VarMarks                   = @$ArrDBAnswerVal[$i]['m'];
                $VarNumberOfAnswer          = @$ArrDBAnswerVal[$i]['na'];
                $VarSelAnswer               = @$ArrStudentAnswers[$i];

                //Load the Student/DB Answer Ino.
                $ArrStudentMarks[$VarQuestionNo]['ca'] = $VarCorrectAnswer;
                $ArrStudentMarks[$VarQuestionNo]['sa'] = $ArrStudentAnswers[$i];
                if($VarQuestionType==1) {

                } else if($VarQuestionType==2) {
                    if($VarSelAnswer=='-' || $VarSelAnswer<>$VarCorrectAnswer) {
                        $ArrStudentMarks[$VarQuestionNo]['m'] = 0;
                    } else if($VarSelAnswer==$VarCorrectAnswer) {
                        $ArrStudentMarks[$VarQuestionNo]['m'] = $VarMarks;
                    }
                } else if($VarQuestionType==3) {
                    $VarCntWA               = 0;
                    $ArrDBSelOrder          = $this->fnGenerateOrderPatternVal($VarCorrectAnswer);
                    $ArrStudentSelOrder     = $this->fnGenerateOrderPatternVal($VarSelAnswer);
                    foreach($ArrStudentSelOrder as $VarKey=>$VarCombInfo){
                        if($VarCombInfo==@$ArrDBSelOrder[$VarKey]) {
                            $VarCntWA       = $VarCntWA+1;
                        }
                    }
                    $VarIndScore            = $VarMarks/count($ArrDBSelOrder);
                    $ArrStudentMarks[$VarQuestionNo]['m'] = $VarCntWA*$VarIndScore;
                    //$ArrStudentMarks[$VarQuestionNo]['is'] = $VarIndScore;
                    //$ArrStudentMarks[$VarQuestionNo]['cna'] = $VarCntWA;
                } else if($VarQuestionType==4) {
                    $VarCntWA               = 0;
                    for($j=0;$j<$VarNumberOfAnswer;$j++) {
                        if($VarSelAnswer[$j]==$VarCorrectAnswer[$j]) {
                            $VarCntWA       = $VarCntWA+1;
                        }
                    }
                    $VarIndScore            = $VarMarks/$VarNumberOfAnswer;
                    $ArrStudentMarks[$VarQuestionNo]['m'] = $VarCntWA*$VarIndScore;
                    //$ArrStudentMarks[$VarQuestionNo]['is'] = $VarIndScore;
                    //$ArrStudentMarks[$VarQuestionNo]['cna'] = $VarCntWA;
                }
                $ArrMarkList[$VarQuestionNo]= $ArrStudentMarks[$VarQuestionNo]['m'];
                $ArrDBMarkList[$VarQuestionNo]= $VarMarks;
                $VarTotalMark               = $VarTotalMark+$ArrStudentMarks[$VarQuestionNo]['m'];
                $VarQuestionNo              = $VarQuestionNo+1;
            }
        }
        $ArrResInfo['md']                   = $ArrStudentMarks;
        $ArrResInfo['tm']                   = $VarTotalMark;
        $ArrResInfo['ml']                   = $ArrMarkList;
        $ArrResInfo['dml']                  = $ArrDBMarkList;
        return $ArrResInfo;
    }

    function fnGenerateOrderPatternVal($VarString='') {
        $VarStrLen                      = strlen($VarString);
        for($i=0;$i<$VarStrLen;$i++) {
            if($i==0) {
                $ArrStrList[]           = $VarString[$i].$VarString[$i+1];
            } else {
                $ArrStrList[]           = $VarString[$i-1].$VarString[$i];
            }
        }
        unset($ArrStrList[0]);
        return $ArrStrList;
    }


    function fnGetCalAnswerVal($VarAssessmentTestId='',$VarStudentAnswer='') {
        $ArrAssessmentTestQuestionInfo  = $this->assesmentmodel->fnGetAssessmentTestQuestionInfo($VarAssessmentTestId,1);
        //Get Answer Position
        $ArrQuestionAnswerVal           = array();
        $ArrStudentSelAnswer            = explode("|#|",$VarStudentAnswer);
        $VarFirstQuesAnswerVal          = strtolower($ArrStudentSelAnswer[0]);
        if($VarFirstQuesAnswerVal!='-') {
            $i=0;
            foreach($ArrAssessmentTestQuestionInfo as $VarKey=>$ArrQuestionInfo) {
                $ArrQuestionAnswerVal[$i]['qt'] = $ArrQuestionInfo['questiontype'];
                $ArrQuestionAnswerVal[$i]['df'] = $ArrQuestionInfo['displayformat'];
                $ArrQuestionAnswerVal[$i]['na'] = $ArrQuestionInfo['noofanswer'];
                $ArrQuestionAnswerVal[$i]['da'] = $ArrQuestionInfo['displayanswer'];
                $ArrQuestionAnswerVal[$i]['m']  = $ArrQuestionInfo['marks'];
                $ArrQuestionAnswerVal[$i]['ca'] = $ArrQuestionInfo['correctanswer'.$VarFirstQuesAnswerVal];
                $i=$i+1;
            }
        }
        return $ArrQuestionAnswerVal;
    }

    function fnGetScoreStudentInfo($VarTeacherId='',$VarStatus='') {
        $this->db->select('id,testid,assignid,teacherid,studentname,score,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_RESULT_SCORE);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarTeacherId<>'') {
            $ArrWhere['teacherid'] 			= $VarTeacherId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by("id","asc");
        $ArrStudentScoreList  = $this->db->get()->result_array();
        return $ArrStudentScoreList;
    }

    function fnGetScoreOtherInfo($VarScoreId='',$VarStatus='') {
        $this->db->select('id,testid,scoreid,assignid,moduletype,marks,actualmark,teacherid,status,datecreated,dateupdated');
        $this->db->from(KP_ASSESSMENT_TEST_RESULT_SCORE_OTHER);
        if($VarStatus<>'') {
            $this->db->where_in('status',array($VarStatus));
        } else {
            $this->db->where_in('status',array(1,2));
        }
        if($VarScoreId<>'') {
            $ArrWhere['scoreid'] 			= $VarScoreId;
        }
        if(@count($ArrWhere)>=1) {
            $this->db->where($ArrWhere);
        }
        $this->db->order_by("moduletype","asc");
        $ArrStudentScoreOtherList           = $this->db->get()->result_array();
        $ArrFnlOtherScoreRes                = array();
        foreach($ArrStudentScoreOtherList as $VarKey=>$ArrStudentScoreOtherInfo) {
            $ArrFnlOtherScoreRes[$ArrStudentScoreOtherInfo['moduletype']]   = $ArrStudentScoreOtherInfo['marks'];
        }
        return $ArrFnlOtherScoreRes;
    }


}