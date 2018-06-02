function fnShowProfileCont(VarDivShow) {
    var ArrProfileContList = ["divAddEditTeacherInfo","divShowTeacherList"];
    for(i=0;i<ArrProfileContList.length;i++) {
        $("#"+ArrProfileContList[i]).removeClass('show');
        $("#"+ArrProfileContList[i]).removeClass('hide');
    }
    for(i=0;i<ArrProfileContList.length;i++) {
        if(VarDivShow!=ArrProfileContList[i]) {
            $("#"+ArrProfileContList[i]).addClass('hide');
        }
    }
    $("#"+VarDivShow).addClass('show');
}

function fnSearchMyAssessmentTest() {
    var TestName							    = $("#frmSrchTestName").val();
    GlbSearchParam							    = "rfrom=1&tn="+TestName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/myassessmenttestlist',GlbSearchParam,'json',fnListMyAssessmentTestRes);
}

function fnListMyAssessmentTest() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/myassessmenttestlist',GlbSearchParam,'json',fnListMyAssessmentTestRes);
}

function fnListMyAssessmentTestRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Assessment Test(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Test Name</th><th>Marks</th><th>Number of Question</th><th>Assigned Date</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+'assessment/schoolassessmentinfo/'+escape(base64_encode(value.id))+'/">'+value.tn+'</a></td><td>'+value.m+'</td><td>'+value.noq+'</td><td>'+value.du+'</td>';
                            PageContent=PageContent+'</td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Assessment Test(s) found</td></tr>';
                    $("#DivTotalCntResult").html('');
                }
                PageContent	= PageContent+'</tbody></table>';
                if(data.pa!=undefined) {
                    $("#ResPagination").html(base64_decode(data.pa));
                }
                $("#ResResult").html(PageContent);
            }
        }
    }
}

var GlbSearchParam='';
function fnPaginationMyAssessmentTest(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListMyAssessmentTestRes);
}

function fnListMyAssessmentTeacherList() {
    GlbSearchParam								= "rfrom=1&aid="+GlbAssignId+"&tid="+GlbAssessmentId;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/myassessmentteacherlist',GlbSearchParam,'json',fnListMyAssessmentTeacherListRes);
}

function fnListMyAssessmentTeacherListRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Teacher(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Teacher Name</th><th>Section</th><th>No. of Session</th><th>Assigned Date</th><th>Exam Date</th><th>No. Of Student Taken</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td>'+value.tn+'</td><td>'+value.sn+'</td><td>'+value.nose+'</td><td>'+value.du+'</td><td>'+value.ed+'</td><td>'+value.nos+'</td><td>';
                            if(GlbUserType==2) {
                                PageContent=PageContent+'<i class="fa fa-edit"></i>&nbsp;<a href="'+base_path+'assessment/enrollmarks/'+value.eid+'">Add Student Exam Info.</a>&nbsp;|&nbsp;';
                            }
                            PageContent=PageContent+'<i class="fa fa-file-excel-o"></i>&nbsp;<a href="'+base_path+'assessment/exportExamResults/'+value.eid+'">Download - Exam Result</a></td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="herr text-center">No Teacher(s) found</td></tr>';
                    $("#DivTotalCntResult").html('');
                }
                PageContent	= PageContent+'</tbody></table>';
                if(data.pa!=undefined) {
                    $("#ResPagination").html(base64_decode(data.pa));
                }
                $("#ResResult").html(PageContent);
            }
        }
    }
}

function fnPaginationMyTeacherTest(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListMyAssessmentTeacherListRes);
}

var GlbTeacherId = '';
function fnSaveTeacherInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var TeacherName   							= $("#frmAssessmentTeacherName").val();
        var SectionName 						    = $("#frmAssessmentSectionName").val();
        var ExamDate            				    = $("#frmAssessmentExamDate").val();
        var NoOfSession            				    = $("#frmAssessmentNoOfSession").val();
        if(jsTrim(TeacherName)== ""){
            $('#ErrBasicContactName').html("Please fill the teacher name");
            $('#frmBasicContactName').focus();
            $('#frmBasicContactName').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(SectionName)== ""){
            $('#ErrBasicMobile').html("Please fill the section name");
            $('#frmBasicMobile').focus();
            $('#frmBasicMobile').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(ExamDate)== ""){
            $('#ErrAssessmentExamDate').html("Please fill the exam date");
            $('#frmAssessmentExamDate').focus();
            $('#frmAssessmentExamDate').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(NoOfSession)== ""){
            $('#ErrAssessmentNoOfSession').html("Please choose the number of session");
            $('#frmAssessmentNoOfSession').focus();
            $('#frmAssessmentNoOfSession').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("tn",TeacherName);
            ProfileFormData.append("sn",SectionName);
            ProfileFormData.append("ed",ExamDate);
            ProfileFormData.append("nos",NoOfSession);
            ProfileFormData.append("tid",GlbAssessmentId);
            ProfileFormData.append("aid",GlbAssignId);
            ProfileFormData.append("id",GlbTeacherId);
        }
        $.ajax({
            url 		: base_path+'assessment/updateTeacherInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveTeacherInfoRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveTeacherInfoRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicEmail').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Teacher has been assigned to this assessment test!");
            fnListMyAssessmentTeacherList();
            resetForm('frmTeacherInfo');
            fnShowProfileCont('divShowTeacherList');
        }
    }
}

function fnStudentSelAnswer() {
    var NumberQuestion                          = parseInt(GlbNumberOfQuestion);
    var StudentAnswers=QuestionNo=QuestionType=DisplayFormat=NoOfAnswer='';
    //Get the Student Answers
    for(i=1;i<=NumberQuestion;i++) {
        var StrQuestionVal                      = GlbQuestionConfigArray[i];
        var ArrQuestionConfig                   = StrQuestionVal.split("-");
        QuestionNo                              = ArrQuestionConfig[0];
        QuestionType                            = ArrQuestionConfig[1];
        DisplayFormat                           = ArrQuestionConfig[2];
        NoOfAnswer                              = parseInt(ArrQuestionConfig[3]);
        if(QuestionType==1) {

        } else if(QuestionType==2) {
            var FieldName                      = "frmQuestionNo"+i;
            var SelAnswer                      = $('input[name='+FieldName+']:checked').val();
            if(typeof(SelAnswer)!="undefined") {
                StudentAnswers                  = StudentAnswers+SelAnswer+"|#|";
            } else if(typeof(SelAnswer)=="undefined") {
                StudentAnswers                  = StudentAnswers+"-"+"|#|";
            }
        } else if(QuestionType==3) {
            var j=1;var SubAnswers='';
            for(j=1;j<=NoOfAnswer;j++) {
                var FieldName                   = "frmQuestionNo"+i+"_"+j;
                var SelAnswer                   = $("#"+FieldName).val();
                //alert(SelAnswer);
                if(SelAnswer=='') {
                    SubAnswers                  = SubAnswers+"-";
                } else {
                    SubAnswers                  = SubAnswers+SelAnswer;
                }
            }
            StudentAnswers                      = StudentAnswers+SubAnswers+"|#|";
        } else if(QuestionType==4) {
            var j=1;var SubAnswers='';
            for(j=1;j<=NoOfAnswer;j++) {
                var FieldName                   = "frmQuestionNo"+i+"_"+j;
                var SelAnswer                   = $("#"+FieldName).val();
                //alert(SelAnswer);
                if(SelAnswer=='') {
                    SubAnswers                  = SubAnswers+"-";
                } else {
                    SubAnswers                  = SubAnswers+SelAnswer;
                }
            }
            StudentAnswers                      = StudentAnswers+SubAnswers+"|#|";
        }
    }
    return StudentAnswers;
}

function fnSaveStudentAnswers() {

    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var StudentName   							= $("#frmExamStudentName").val();
        var StudentSelAnswers                       = fnStudentSelAnswer();
        if(jsTrim(StudentName)== ""){
            $('#ErrExamStudentName').html("Please fill the student name");
            $('#frmExamStudentName').focus();
            $('#frmExamStudentName').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("sn",StudentName);
            ProfileFormData.append("sa",StudentSelAnswers);
            ProfileFormData.append("tid",GlbAssessmentId);
            ProfileFormData.append("aid",GlbAssignId);
            ProfileFormData.append("id",GlbTeacherEnrollId);
        }
        $.ajax({
            url 		: base_path+'assessment/updateStudentRes',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveStudentAnswersRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveStudentAnswersRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            return false;
        } else if(data.errcode==1){
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Student exam answers has been updated at successfully!");
            resetForm('frmBasicInfo');
            $('input[type=radio]').prop('checked',false);
        }
    }
}