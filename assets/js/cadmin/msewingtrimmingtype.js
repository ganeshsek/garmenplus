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

function fnSearchSewingTrimmingType() {
    var TrimmingName          				    = $("#frmSrchTrimmingName").val();
    var Status          						= $("#frmSrchUnitStatus").val();
    GlbSearchParam							    = "rfrom=1&tn="+TrimmingName+"&s="+Status;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/msewingtrimmingtype/managesewingtrimmingtype',GlbSearchParam,'json',fnListSewingTrimmingTypeRes);
}

function fnListSewingTrimmingType() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/msewingtrimmingtype/managesewingtrimmingtype',GlbSearchParam,'json',fnListSewingTrimmingTypeRes);
}

function fnListSewingTrimmingTypeRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Record(s) : '+data.cn+'</div>';
                    PageContent	= "<table class='table table-bordered table-hover'><thead><tr><th>Trimming Type</th><th>Status</th><th>Updated By</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+GlbCAdminFdr+'/msewingtrimmingtype/addedit/'+escape(base64_encode(value.id))+'/">'+value.n+'</a></td><td>'+value.s+'</td><td>'+value.ub+'</td><td>'+value.du+'</td><td><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteSewingTrimmingType('+value.id+')">Delete</a></td>';
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

function fnPaginationSewingTrimmingType(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListSewingTrimmingTypeRes);
}

function fnDeleteSewingTrimmingType(Id) {
    if(confirm("Are you want to delete this trimming type?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+GlbCAdminFdr+'/msewingtrimmingtype/delSewingTrimmingTypeInfo',Parameters,'json',fnDeleteSewingTrimmingTypeRes);
    }
}

function fnDeleteSewingTrimmingTypeRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchSewingTrimmingType();
            }
        }
    }
}

function fnSaveSewingTrimmingTypeInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var TrimmingName     						= $("#frmBasicTrimmingName").val();
        var Status        							= $("#frmBasicStatus").val();
        if(jsTrim(TrimmingName)== ""){
            $('#ErrBasicTrimmingName').html("Please fill the sewing trimming type");
            $('#frmBasicTrimmingName').focus();
            $('#frmBasicTrimmingName').css("border", "1px solid #B94A48");
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
            ProfileFormData.append("tn",TrimmingName);
            ProfileFormData.append("s",Status);
            ProfileFormData.append("id",GlbId);
        }
        $.ajax({
            url 		: base_path+GlbCAdminFdr+'/msewingtrimmingtype/updateTrimmingInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveSewingTrimmingTypeRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveSewingTrimmingTypeRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicTrimmingName').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbId       = data.id;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Trimming type has updated at successfully!");
            fnRedirectPageTimeOut(base_path+GlbCAdminFdr+'/msewingtrimmingtype/addedit/'+data.eid);
        }
    }
}