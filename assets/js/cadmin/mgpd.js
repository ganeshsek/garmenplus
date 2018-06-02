var GlbSearchParam='';
function fnShowHideEndUserSub(VarType,VarDivShow) {
    var ArrProfileBasicList = ["divEditBasicInfo","divShowBasicInfo"];
    if(VarType==1) {
        var ArrFnalList	= ArrProfileBasicList;
    }
    //Remove Class
    for(i=0;i<ArrFnalList.length;i++) {
        $("#"+ArrFnalList[i]).removeClass('show');
        $("#"+ArrFnalList[i]).removeClass('hide');
    }
    //Add Class
    for(i=0;i<ArrFnalList.length;i++) {
        if(VarDivShow!=ArrFnalList[i]) {
            $("#"+ArrFnalList[i]).addClass('hide');
        }
    }
    $("#"+VarDivShow).addClass('show');
}

function fnSearchGPD() {
    var GPD          				            = $("#frmSrchGPDName").val();
    var Status          						= $("#frmSrchGPDStatus").val();
    GlbSearchParam							    = "rfrom=1&gn="+GPD+"&s="+Status;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/mgpd/managegpd',GlbSearchParam,'json',fnListGPDRes);
}

function fnListGPD() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/mgpd/managegpd',GlbSearchParam,'json',fnListGPDRes);
}

function fnListGPDRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Record(s) : '+data.cn+'</div>';
                    PageContent	= "<table class='table table-bordered table-hover'><thead><tr><th>Garment Part Desc. Name</th><th>Status</th><th>Updated By</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+GlbCAdminFdr+'/mgpd/addedit/'+escape(base64_encode(value.id))+'/">'+value.n+'</a></td><td>'+value.s+'</td><td>'+value.ub+'</td><td>'+value.du+'</td><td><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteGPD('+value.id+')">Delete</a></td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Records(s) found</td></tr>';
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

function fnPaginationGPD(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListGPDRes);
}

function fnDeleteGPD(Id) {
    if(confirm("Are you want to delete this garment part desc?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+GlbCAdminFdr+'/mgpd/delGPDInfo',Parameters,'json',fnDeleteGPDRes);
    }
}

function fnDeleteGPDRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchGPD();
            }
        }
    }
}

function fnSaveGPDInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var GPD     						        = $("#frmBasicGPDName").val();
        var Status        							= $("#frmBasicStatus").val();
        if(jsTrim(GPD)== ""){
            $('#ErrBasicGPDName').html("Please fill the garment part desc");
            $('#frmBasicGPDName').focus();
            $('#frmBasicGPDName').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Status)== ""){
            $('#ErrBasicStatus').html("Please choose the status");
            $('#frmBasicStatus').focus();
            $('#frmBasicStatus').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("gn",GPD);
            ProfileFormData.append("s",Status);
            ProfileFormData.append("id",GlbId);
        }
        $.ajax({
            url 		: base_path+GlbCAdminFdr+'/mgpd/updateGPDInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveGPDRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveGPDRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicGPD').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbId       = data.id;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Garment Part Desc. has updated at successfully!");
            fnRedirectPageTimeOut(base_path+GlbCAdminFdr+'/mgpd/addedit/'+data.eid);
        }
    }
}