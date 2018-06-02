function fnGenerateQuestionPattern(NumberOfQuestion) {
    var i=1;
    var QuestionRow = "";
    var NumberOfQuestionRow = 0;
    if(NumberOfQuestion>GlbNumberOfQuestion) {
        NumberOfQuestionRow    = NumberOfQuestion-GlbNumberOfQuestion;
    } else {
        NumberOfQuestionRow    = GlbNumberOfQuestion-NumberOfQuestion;
    }
    NumberOfQuestionRow        = parseInt(NumberOfQuestionRow);
    if(NumberOfQuestionRow>=1) {
        if(GlbNumberOfQuestion==0) {
            QuestionRow        =  '<table id="example1" class="table table-bordered table-hover"><thead><tr><th width="5%">Q. No.</th><th width="18%">Question Type</th><th width="6%">Mark</th><th width="17%">Display Format</th><th width="17%">Number of Answer</th><th width="15%">Display Answer</th><th>Correct Answer</th></tr></thead><tbody>';
        }
        var StartRow           = NumberOfQuestion-NumberOfQuestionRow;
        if(StartRow==0) {StartRow=1;}
        QuestionRow            = QuestionRow+fnGenerateQuestionRow(NumberOfQuestion,StartRow,NumberOfQuestionRow);
        if(GlbNumberOfQuestion==0) {
            QuestionRow        =  QuestionRow+'</tbody></table>';
            $("#divConfQuesRow").html(QuestionRow);
        } else {

        }
        //GlbNumberOfQuestion     = NumberOfQuestion;
    }
}

function fnGenerateQuestionRow(NumberOfQuestion,StartRow,NumberOfQuestionRow) {
    var QuestionRow             = "";
    var i                       = 1;
    for(i=StartRow;i<=NumberOfQuestionRow;i++) {
        QuestionRow             = QuestionRow+"<tr id='QuesRow"+i+"'><td><input type='text' name='frmQueQuestionNo"+i+"' id='frmQueQuestionNo"+i+"' value='"+i+"' class='form-control'></td><td>"+fnGetAssessmentQuestionType(i)+"</td><td>"+fnGetAssessmentMark(i)+"</td><td>"+fnGetAssessmentQuestionFormat(i)+"</td><td>"+fnGetAssessmentMaxAnswers(i)+"</td><td>"+fnGetAssessmentMaxDisplayAnswers(i)+"</td><td><div class='float-left col-lg-4'>A:<input type='text' name='frmQueCorrectAnsA"+i+"' id='frmQueCorrectAnsA"+i+"' value='' class='form-control'></div><div class='float-left col-lg-4'>B:<input type='text' name='frmQueCorrectAnsB"+i+"' id='frmQueCorrectAnsB"+i+"' value='' class='form-control' ></div><div class='float-left col-lg-4'>C: <input type='text' name='frmQueCorrectAnsC"+i+"' id='frmQueCorrectAnsC"+i+"' value='' class='form-control' ></div></td></tr>";
    }
    return QuestionRow;
}

function fnGetAssessmentUnitType(RowId) {
    var HtmlContent             = '';
    HtmlContent                 = "<select name='frmQueUnitType"+RowId+"' id='frmQueUnitType"+RowId+"' class='form-control'><option value=''>Choose the Type</option>"+GlbUnitOptions+"</select>";
    return HtmlContent;
}

function fnGetAssessmentQuestionType(RowId) {
    var HtmlContent             = '';
    HtmlContent                 = "<select name='frmQueQuestionType"+RowId+"' id='frmQueQuestionType"+RowId+"' class='form-control'><option value=''>Choose the Question Type</option>"+GlbQuestionTypeOptions+"</select>";
    return HtmlContent;
}

function fnGetAssessmentMark(RowId) {
    var HtmlContent             = '';
    var i                       = 1;
    /*HtmlContent                 = "<select name='frmQueMarks"+RowId+"' id='frmQueMarks"+RowId+"' class='form-control'><option value=''>Choose the Marks</option>";
    for(i=1;i<=GlbAssessmentMaxMarks;i++) {
        HtmlContent             = HtmlContent+"<option value='"+i+"'>"+i+"</option>";
    }
    HtmlContent                 = HtmlContent+"</select>";
    */
    HtmlContent                 = "<input type='text' name='frmQueMarks"+RowId+"' id='frmQueMarks"+RowId+"' class='form-control'>";
    return HtmlContent;
}

function fnGetAssessmentQuestionFormat(RowId) {
    var HtmlContent             = '';
    HtmlContent                 = "<select name='frmQueQuestionFormat"+RowId+"' id='frmQueQuestionFormat"+RowId+"' class='form-control'><option value=''>Choose the Display Format</option>"+GlbQuestionFormatOptions+"</select>";
    return HtmlContent;
}

function fnGetAssessmentMaxAnswers(RowId) {
    var HtmlContent             = '';
    var i                       = 1;
    HtmlContent                 = "<select name='frmQueAnswer"+RowId+"' id='frmQueAnswer"+RowId+"' class='form-control'><option value=''>Choose the No.of Answers</option>";
    for(i=1;i<=GlbAssessmentMaxAnswers;i++) {
        HtmlContent             = HtmlContent+"<option value='"+i+"'>"+i+"</option>";
    }
    HtmlContent                 = HtmlContent+"</select>";
    return HtmlContent;
}

function fnGetAssessmentMaxDisplayAnswers(RowId) {
    var HtmlContent             = '';
    var i                       = 1;
    HtmlContent                 = "<select name='frmQueDisplayAnswer"+RowId+"' id='frmQueDisplayAnswer"+RowId+"' class='form-control'><option value=''>Choose the Display Answers</option>";
    for(i=1;i<=GlbAssessmentMaxAnswers;i++) {
        HtmlContent             = HtmlContent+"<option value='"+i+"'>"+i+"</option>";
    }
    HtmlContent                 = HtmlContent+"</select>";
    return HtmlContent;
}

function fnSaveAssessmentTest() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var TestName								= $("#frmBasicAssTestName").val();
    var NumberOfQuestion    					= $("#frmBasicAssNoOfQuestion").val();
    var Instructions  							= $("#frmBasicAssInstructions").val();
    if(jsTrim(TestName)== ""){
        $('#ErrBasicAssTestName').html("Please fill the test name");
        $('#frmBasicAssTestName').focus();
        $('#frmBasicAssTestName').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(NumberOfQuestion)== ""){
        $('#ErrBasicAssNoOfQuestion').html("Please choose the number of question");
        $('#frmBasicAssNoOfQuestion').focus();
        $('#frmBasicAssNoOfQuestion').css("border", "1px solid #B94A48");
        return false;
    }
    var QuestionSettingsVal                     = "";
    var i                                       = 0;
    var QuestionSettingsIndVal                  = "";
    var QuestionNo=QuestionType=Mark=DisplayFormat=NumberOfAnswer=DisplayAns=DisplayAnswer=CorrectAnswer="";
    for(i=1;i<=NumberOfQuestion;i++) {
        QuestionNo                              = jsTrim($("#frmQueQuestionNo"+i).val());
        QuestionType                            = jsTrim($("#frmQueQuestionType"+i).val());
        Mark                                    = jsTrim($("#frmQueMarks"+i).val());
        DisplayFormat                           = jsTrim($("#frmQueQuestionFormat"+i).val());
        NumberOfAnswer                          = jsTrim($("#frmQueAnswer"+i).val());
        DisplayAnswer                           = jsTrim($("#frmQueDisplayAnswer"+i).val());
        CorrectAnswerA                          = jsTrim($("#frmQueCorrectAnsA"+i).val());
        CorrectAnswerB                          = jsTrim($("#frmQueCorrectAnsB"+i).val());
        CorrectAnswerC                          = jsTrim($("#frmQueCorrectAnsC"+i).val());
        if(QuestionNo=='' || QuestionType=='' || Mark=='' || DisplayFormat=='' || NumberOfAnswer=='' || DisplayAnswer=='' || CorrectAnswerA==''|| CorrectAnswerB=='' || CorrectAnswerC=='') {
            $("#tabHead2").trigger('click');
            alert("Fill the Question No. :"+QuestionNo);
            return false;
        } else if(!isFloatIntNumber(Mark)) {
            $("#tabHead2").trigger('click');
            alert("Fill the valid mark for question no.:"+QuestionNo);
            return false;
        } else {
            QuestionSettingsIndVal               = QuestionNo+"|#|"+QuestionType+"|#|"+Mark+"|#|"+DisplayFormat+"|#|"+NumberOfAnswer+"|#|"+DisplayAnswer+"|#|"+CorrectAnswerA+"|#|"+CorrectAnswerB+"|#|"+CorrectAnswerC+"|~|";
            QuestionSettingsVal                  = QuestionSettingsVal+QuestionSettingsIndVal;
        }
    }
    var ListSentFluency                          = jsTrim($("#frmListSentFluency").val());
    var ListWordVoca                             = jsTrim($("#frmListWordVoca").val());
    var ReadSentFluency                          = jsTrim($("#frmReadSentFluency").val());
    var ReadWordVoca1                            = jsTrim($("#frmReadWordVoca1").val());
    var ReadWordVoca2                            = jsTrim($("#frmReadWordVoca2").val());
    var ReadStory                                = jsTrim($("#frmReadStory").val());
    var Remember                                 = jsTrim($("#frmOthersRemember").val());
    var Understand1                              = jsTrim($("#frmOthersUnderstand1").val());
    var Understand2                              = jsTrim($("#frmOthersUnderstand2").val());
    var Apply1                                   = jsTrim($("#frmOthersApply1").val());
    var Apply2                                   = jsTrim($("#frmOthersApply2").val());
    if(ListSentFluency=='') {
        $('#ErrListSentFluency').html("Please fill the question no.");
        $('#frmListSentFluency').focus();
        $('#frmListSentFluency').css("border", "1px solid #B94A48");
        return false;
    }
    if(ListWordVoca=='') {
        $('#ErrListWordVoca').html("Please fill the question no.");
        $('#frmListWordVoca').focus();
        $('#frmListWordVoca').css("border", "1px solid #B94A48");
        return false;
    }
    if(ReadSentFluency=='') {
        $('#ErrReadSentFluency').html("Please fill the question no.");
        $('#frmReadSentFluency').focus();
        $('#frmReadSentFluency').css("border", "1px solid #B94A48");
        return false;
    }
    if(ReadWordVoca1=='') {
        $('#ErrReadWordVoca').html("Please fill the question no.");
        $('#frmReadWordVoca1').focus();
        $('#frmReadWordVoca1').css("border", "1px solid #B94A48");
        return false;
    }
    if(ReadWordVoca2=='') {
        $('#ErrReadWordVoca').html("Please fill the question no.");
        $('#frmReadWordVoca2').focus();
        $('#frmReadWordVoca2').css("border", "1px solid #B94A48");
        return false;
    }
    if(ReadStory=='') {
        $('#ErrReadStory').html("Please fill the question no.");
        $('#frmReadStory').focus();
        $('#frmReadStory').css("border", "1px solid #B94A48");
        return false;
    }
    if(Remember=='') {
        $('#ErrOthersRemember').html("Please fill the question no.");
        $('#frmOthersRemember').focus();
        $('#frmOthersRemember').css("border", "1px solid #B94A48");
        return false;
    }
    if(Understand1=='') {
        $('#ErrOthersUnderstand').html("Please fill the question no.");
        $('#frmOthersUnderstand1').focus();
        $('#frmOthersUnderstand1').css("border", "1px solid #B94A48");
        return false;
    }
    if(Understand2=='') {
        $('#ErrOthersUnderstand').html("Please fill the question no.");
        $('#frmOthersUnderstand2').focus();
        $('#frmOthersUnderstand2').css("border", "1px solid #B94A48");
        return false;
    }
    if(Apply1=='') {
        $('#ErrOthersApply').html("Please fill the question no.");
        $('#frmOthersApply1').focus();
        $('#frmOthersApply1').css("border", "1px solid #B94A48");
        return false;
    }
    if(Apply2=='') {
        $('#ErrOthersApply').html("Please fill the question no.");
        $('#frmOthersApply2').focus();
        $('#frmOthersApply2').css("border", "1px solid #B94A48");
        return false;
    }

    if(confirm("Are you want to generate the assessment test?")) {
        if (window.FormData){
            ProfileFormData								 = new FormData();
            ProfileFormData.append("qsv",QuestionSettingsVal);
            ProfileFormData.append("tn",TestName);
            ProfileFormData.append("noq",NumberOfQuestion);
            ProfileFormData.append("ins",Instructions);
            ProfileFormData.append("lsf",ListSentFluency);
            ProfileFormData.append("lwv",ListWordVoca);
            ProfileFormData.append("rsf",ReadSentFluency);
            ProfileFormData.append("rwv1",ReadWordVoca1);
            ProfileFormData.append("rwv2",ReadWordVoca2);
            ProfileFormData.append("rst",ReadStory);
            ProfileFormData.append("rem",Remember);
            ProfileFormData.append("us1",Understand1);
            ProfileFormData.append("us2",Understand2);
            ProfileFormData.append("a1",Apply1);
            ProfileFormData.append("a2",Apply2);
            ProfileFormData.append("aid",GlbAssessmentId);
        }
        $.ajax({
            url 		: base_path+'assessment/updateAssessmentInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveAssessmentTestRes(data);
            }
        });
    }
    return false;
}

function fnSaveAssessmentTestRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            //$('#ErrBasicEmail').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbAssessmentId   = data.aid;
            GlbEnAssessmentId   = data.eaid;
            $("#frmAssessmentId").val(GlbAssessmentId);
            $("#extrabutton").trigger('click');
        }
    }
}

function fnSearchAssessmentTest() {
    var TestName							    = $("#frmSrchTestName").val();
    GlbSearchParam							    = "rfrom=1&tn="+TestName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/manageassessmenttest',GlbSearchParam,'json',fnListAssessmentTestRes);
}

function fnListAssessmentTest() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/manageassessmenttest',GlbSearchParam,'json',fnListAssessmentTestRes);
}

function fnListAssessmentTestRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Assessment Test(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Test Name</th><th>Number or Question</th><th>Date Updated</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+'assessment/addeditassessment/'+escape(base64_encode(value.id))+'/">'+value.tn+'</a></td><td>'+value.noq+'</td><td>'+value.du+'</td>';
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

function fnPaginationAssessmentTest(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListAssessmentTestRes);
}

function fnSearchAssignedTest() {
    var TestName							    = $("#frmSrchTestName").val();
    var SchoolName							    = $("#frmSrchSchoolName").val();
    GlbSearchParam							    = "rfrom=1&tn="+TestName+"&sn="+SchoolName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/manageassignedlist',GlbSearchParam,'json',fnListAssignedTestRes);
}

function fnListAssignedTest() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'assessment/manageassignedlist',GlbSearchParam,'json',fnListAssignedTestRes);
}

function fnListAssignedTestRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Assessment Test(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Test Name</th><th>School Name</th><th>Assigned Date</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+'assessment/addeditassessment/'+escape(base64_encode(value.tid))+'/'+escape(base64_encode(value.id))+'">'+value.tn+'</a></td><td>'+value.sn+'</td><td>'+value.du+'</td>';
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
function fnPaginationAssignTest(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListAssignedTestRes);
}

function fnAssignTest() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var TestName								= $("#frmAssignTestName").val();
    var SchoolName          					= $("#frmAssignSchoolName").val();
    if(jsTrim(TestName)== ""){
        $('#ErrAssignTestName').html("Please choose the test name");
        $('#frmAssignTestName').focus();
        $('#frmAssignTestName').css("border", "1px solid #B94A48");
        return false;
    }
    if(SchoolName== null){
        $('#ErrAssignSchoolName').html("Please choose the school name");
        $('#frmAssignSchoolName').focus();
        $('#frmAssignSchoolName').css("border", "1px solid #B94A48");
        return false;
    }
    if (window.FormData){
        ProfileFormData								 = new FormData();
        ProfileFormData.append("tn",TestName);
        ProfileFormData.append("sn",SchoolName);
    }
    $.ajax({
        url 		: base_path+'assessment/SaveAssignTestInfo',
        data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            data = jQuery.parseJSON(data);
            fnAssignTestRes(data);
        }
    });
    return false;
}

function fnAssignTestRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            return false;
        } else if(data.errcode==1){
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Assessment test has been assigned to the school!");
            fnRedirectPageTimeOut(window.location.href);
        }
    }
}
