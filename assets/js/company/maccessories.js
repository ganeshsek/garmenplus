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

function fnSearchAccessories() {
    var Accessories          				    = $("#frmSrchAccessories").val();
    var Status          						= $("#frmSrchAccessoriesStatus").val();
    GlbSearchParam							    = "rfrom=1&an="+Accessories+"&s="+Status;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCompanyFdr+'/maccessories/manageaccessories',GlbSearchParam,'json',fnListAccessoriesRes);
}

function fnListAccessories() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCompanyFdr+'/maccessories/manageaccessories',GlbSearchParam,'json',fnListAccessoriesRes);
}

function fnListAccessoriesRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Record(s) : '+data.cn+'</div>';
                    PageContent	= "<table class='table table-bordered table-hover'><thead><tr><th>Accessories Name</th><th>Status</th><th>Updated By</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+GlbCompanyFdr+'/maccessories/addedit/'+escape(base64_encode(value.id))+'/">'+value.n+'</a></td><td>'+value.s+'</td><td>'+value.ub+'</td><td>'+value.du+'</td><td><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteAccessories('+value.id+')">Delete</a></td>';
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

function fnPaginationAccessories(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListAccessoriesRes);
}

function fnDeleteAccessories(Id) {
    if(confirm("Are you want to delete this accessories?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+GlbCompanyFdr+'/maccessories/delAccessoriesInfo',Parameters,'json',fnDeleteAccessoriesRes);
    }
}

function fnDeleteAccessoriesRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchAccessories();
            }
        }
    }
}

function fnSaveAccessoriesInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Accessories     						= $("#frmBasicAccessories").val();
        var Status        							= $("#frmBasicStatus").val();
        if(jsTrim(Accessories)== ""){
            $('#ErrBasicAccessories').html("Please fill the accessories");
            $('#frmBasicAccessories').focus();
            $('#frmBasicAccessories').css("border", "1px solid #B94A48");
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
            ProfileFormData.append("an",Accessories);
            ProfileFormData.append("s",Status);
            ProfileFormData.append("id",GlbId);
        }
        $.ajax({
            url 		: base_path+GlbCompanyFdr+'/maccessories/updateAccessoriesInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveAccessoriesRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveAccessoriesRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicAccessories').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbId       = data.id;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Accessories has updated at successfully!");
            fnRedirectPageTimeOut(base_path+GlbCompanyFdr+'/maccessories/addedit/'+data.eid);
        }
    }
}