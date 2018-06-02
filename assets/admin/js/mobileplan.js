function fnSaveMobilePlan() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var PlanName    							= $("#frmPlanName").val();
    var Amount									= $("#frmPlanAmount").val();
    var Validity								= $("#frmValidity").val();
    var ValidityTxt 							= $("#frmValidityTxt").val();
    var Desc    								= $("#frmPlanDesc").val();
    var PlanType	            				= $("#frmPlanType").val();
    var OperatorCode							= $("#frmOperatorCode").val();
    var CircleCode								= $("#frmCircleCode").val();
    var PlanId								    = '';
    if(GlbPlanId>=1) {PlanId=GlbPlanId;}
    if(jsTrim(PlanName)== ""){
        $('#ErrPlanName').html("Please fill the Plan Name");
        $('#frmPlanName').focus();
        $('#frmPlanName').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(Amount)== ""){
        $('#ErrPlanAmount').html("Please fill the Amount");
        $('#frmPlanAmount').focus();
        $('#frmPlanAmount').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(Validity)== ""){
        $('#ErrValidity').html("Please Chose the Profile Name");
        $('#frmValidity').focus();
        $('#frmValidity').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(ValidityTxt)== ""){
        $('#ErrValidityTxt').html("Please Chose the Profile Name");
        $('#frmValidityTxt').focus();
        $('#frmValidityTxt').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(Desc)== ""){
        $('#ErrPlanDesc').html("Please Chose the Profile Name");
        $('#frmPlanDesc').focus();
        $('#frmPlanDesc').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(PlanType)== ""){
        $('#ErrPlanType').html("Please Choose the Plan Type");
        $('#frmPlanType').focus();
        $('#frmPlanType').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(OperatorCode)== ""){
        $('#ErrOperatorCode').html("Please Choose the Operator Code");
        $('#frmOperatorCode').focus();
        $('#frmOperatorCode').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(CircleCode)== ""){
        $('#ErrCircleCode').html("Please Chose the Circle Code");
        $('#frmCircleCode').focus();
        $('#frmCircleCode').css("border", "1px solid #B94A48");
        return false;
    }

    if (window.FormData){
        ProfileFormData								= new FormData();
        ProfileFormData.append("pn",PlanName);
        ProfileFormData.append("a",Amount);
        ProfileFormData.append("v",Validity);
        ProfileFormData.append("vt",ValidityTxt);
        ProfileFormData.append("d",Desc);
        ProfileFormData.append("pt",PlanType);
        ProfileFormData.append("oc",OperatorCode);
        ProfileFormData.append("cc",CircleCode);
        ProfileFormData.append("id",PlanId);
    }
    $.ajax({
        url 		: base_path+'admin/recharge/updatePlanInfo',
        data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            data = jQuery.parseJSON(data);
            fnSaveMobilePlanRes(data);
        }
    });
    return false;
}

function fnSaveMobilePlanRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrEmail').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessMsg").removeClass('hide');
            $("#divSuccessMsg").html("Your Plan Details has been saved at successfully!!!");
            if(GlbPlanId>=1) {
                fnRedirectPageTimeOut(base_path+'admin/recharge/addmobileplan/'+GlbPlanId);
            } else {
                resetForm("frmNameMobilePlan");
            }
        }
    }
}

function fnSearchMobilePlan() {
    var PlanName							    = $("#frmSrchPlanName").val();
    var Amount									= $("#frmSrchPlanAmount").val();
    var OperatorCode							= $("#frmSrchOperatorCode").val();
    var CircleCode								= $("#frmSrchCircleCode").val();
    var PlanType								= $("#frmSrchPlanType").val();
    var GlbSearchParam							= "rfrom=1&pt="+PlanType+"&a="+Amount+"&opnm="+OperatorCode+"&cc="+CircleCode+"&pnm="+PlanName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'admin/recharge/managemobilerechargeplan',GlbSearchParam,'json',fnListMobilePlanRes);
}

function fnListMobilePlan() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'admin/recharge/managemobilerechargeplan',GlbSearchParam,'json',fnListMobilePlanRes);
}

function fnListMobilePlanRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Plan(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Plan Name</th><th>Plan Type</th><th>Operator Name</th><th>Circle Code</th><th>Amount</th><th>Validity</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td>'+value.pn+'</td><td>'+value.pt+'</td><td>'+value.on+'</td><td>'+value.cn+'</td><td>'+value.a+'</td><td>'+value.vt+'</td><td>'+value.du+'</td><td>';
                            PageContent=PageContent+'<a href="'+base_path+'admin/recharge/addmobileplan/'+value.id+'/"><i class="fa fa-file-text-o"></i> Edit</a>';
                            PageContent=PageContent+'&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeletePlanInfo('+value.id+')"><i class="fa fa-trash-o"></i> Delete</a>';
                            PageContent=PageContent+'</td></td>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Records found</td></tr>';
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
function fnPagination(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListMobilePlanRes);
}

function fnDeletePlanInfo(Id) {
    if(confirm("Are you want to delete this plan?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+'admin/recharge/delMobilePlanInfo',Parameters,'json',fnDeletePlanInfoRes);
    }
}

function fnDeletePlanInfoRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchMobilePlan();
            }
        }
    }
}

function fnUploadMobilePlan() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var UploadFile	            				= $("#frmUploadFile").val();
    var PlanType	            				= $("#frmPlanType").val();
    var OperatorCode							= $("#frmOperatorCode").val();
    var CircleCode								= $("#frmCircleCode").val();
    if(jsTrim(UploadFile)== ""){
        $('#ErrUploadFile').html("Please Choose the CSV File");
        $('#frmUploadFile').focus();
        $('#frmUploadFile').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(PlanType)== ""){
        $('#ErrPlanType').html("Please Choose the Plan Type");
        $('#frmPlanType').focus();
        $('#frmPlanType').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(OperatorCode)== ""){
        $('#ErrOperatorCode').html("Please Choose the Operator Code");
        $('#frmOperatorCode').focus();
        $('#frmOperatorCode').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(CircleCode)== ""){
        $('#ErrCircleCode').html("Please Chose the Circle Code");
        $('#frmCircleCode').focus();
        $('#frmCircleCode').css("border", "1px solid #B94A48");
        return false;
    }
    if (window.FormData){
        ProfileFormData								= new FormData();
        ProfileFormData.append("uf",$("#frmUploadFile").prop("files")[0]);
        ProfileFormData.append("pt",PlanType);
        ProfileFormData.append("oc",OperatorCode);
        ProfileFormData.append("cc",CircleCode);
    }
    $.ajax({
        url 		: base_path+'admin/recharge/saveUploadMobilePlan',
        data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            data = jQuery.parseJSON(data);
            fnUploadMobilePlanRes(data);
        }
    });
    return false;
}

function fnUploadMobilePlanRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrUploadFile').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessMsg").removeClass('hide');
            $("#divSuccessMsg").html("Your Plan Details has been uploaded at successfully!!!");
            if(GlbPlanId>=1) {
                fnRedirectPageTimeOut(base_path+'admin/recharge/uploadmobileplan/');
            } else {
                resetForm("frmNameUploadMobilePlan");
            }
        }
    }
}