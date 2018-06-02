function fnSaveDTHPlan() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var Amount									= $("#frmPlanAmount").val();
    var Validity								= $("#frmValidity").val();
    var Desc    								= $("#frmPlanDesc").val();
    var PlanType	            				= $("#frmPlanType").val();
    var OperatorCode							= $("#frmOperatorCode").val();
    var PlanId								    = '';
    if(GlbPlanId>=1) {PlanId=GlbPlanId;}
    if(jsTrim(Amount)== ""){
        $('#ErrPlanAmount').html("Please fill the Amount");
        $('#frmPlanAmount').focus();
        $('#frmPlanAmount').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(Desc)== ""){
        $('#ErrPlanDesc').html("Please fill the description");
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
    if (window.FormData){
        ProfileFormData								= new FormData();
        ProfileFormData.append("a",Amount);
        ProfileFormData.append("v",Validity);
        ProfileFormData.append("d",Desc);
        ProfileFormData.append("pt",PlanType);
        ProfileFormData.append("oc",OperatorCode);
        ProfileFormData.append("id",PlanId);
    }
    $.ajax({
        url 		: base_path+'admin/recharge/updateDTHPlanInfo',
        data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            data = jQuery.parseJSON(data);
            fnSaveDTHPlanRes(data);
        }
    });
    return false;
}

function fnSaveDTHPlanRes(data){
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
                fnRedirectPageTimeOut(base_path+'admin/recharge/adddthplan/'+GlbPlanId);
            } else {
                resetForm("frmNameDTHPlan");
            }
        }
    }
}

function fnSearchDTHPlan() {
    var PlanName							    = $("#frmSrchPlanName").val();
    var Amount									= $("#frmSrchPlanAmount").val();
    var OperatorCode							= $("#frmSrchOperatorCode").val();
    var PlanType								= $("#frmSrchPlanType").val();
    var GlbSearchParam							= "rfrom=1&pt="+PlanType+"&a="+Amount+"&opnm="+OperatorCode+"&pnm="+PlanName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'admin/recharge/manageDTHrechargeplan',GlbSearchParam,'json',fnListDTHPlanRes);
}

function fnListDTHPlan() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'admin/recharge/manageDTHrechargeplan',GlbSearchParam,'json',fnListDTHPlanRes);
}

function fnListDTHPlanRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Plan(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Plan Name</th><th>Plan Type</th><th>Operator Name</th><th>Amount</th><th>Validity</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td>'+value.pn+'</td><td>'+value.pt+'</td><td>'+value.on+'</td><td>'+value.a+'</td><td>'+value.vt+'</td><td>'+value.du+'</td><td>';
                            PageContent=PageContent+'<a href="'+base_path+'admin/recharge/addDTHplan/'+value.id+'/"><i class="fa fa-file-text-o"></i> Edit</a>';
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
    MakePostRequest(VarURL,Parameters,'json',fnListDTHPlanRes);
}

function fnDeletePlanInfo(Id) {
    if(confirm("Are you want to delete this plan?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+'admin/recharge/delDTHPlanInfo',Parameters,'json',fnDeletePlanInfoRes);
    }
}

function fnDeletePlanInfoRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchDTHPlan();
            }
        }
    }
}

function fnUploadDTHPlan() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var ProfileFormData							= false;
    var UploadFile	            				= $("#frmUploadFile").val();
    var PlanType	            				= $("#frmPlanType").val();
    var OperatorCode							= $("#frmOperatorCode").val();
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
    if (window.FormData){
        ProfileFormData								= new FormData();
        ProfileFormData.append("uf",$("#frmUploadFile").prop("files")[0]);
        ProfileFormData.append("pt",PlanType);
        ProfileFormData.append("oc",OperatorCode);
    }
    $.ajax({
        url 		: base_path+'admin/recharge/saveUploadDTHPlan',
        data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){
            data = jQuery.parseJSON(data);
            fnUploadDTHPlanRes(data);
        }
    });
    return false;
}

function fnUploadDTHPlanRes(data){
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
                resetForm("frmNameUploadDTHPlan");
            }
        }
    }
}