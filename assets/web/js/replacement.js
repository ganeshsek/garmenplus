function fnShowProfileCont(VarDivShow) {
    var ArrProfileContList = ["divRequestInfo","divRequestList"];
    //Remove Class
    for(i=0;i<ArrProfileContList.length;i++) {
        $("#"+ArrProfileContList[i]).removeClass('show');
        $("#"+ArrProfileContList[i]).removeClass('hide');
    }
    //Add Class
    for(i=0;i<ArrProfileContList.length;i++) {
        if(VarDivShow!=ArrProfileContList[i]) {
            $("#"+ArrProfileContList[i]).addClass('hide');
        }
    }
    $("#"+VarDivShow).addClass('show');
}

function fnSendRequest() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Comments 							    = $("#frmRequestComments").val();
        var OrderId        							= $("#frmRequestOrderCode").val();
        var RequestFile 						    = $("#frmRequestFile").prop("files")[0];
        if(jsTrim(OrderId)== ""){
            $('#ErrRequestOrderCode').html("Please choose the order code");
            $('#frmRequestOrderCode').focus();
            $('#frmRequestOrderCode').css("border", "1px solid #B94A48");
            return false;
        }
        if(typeof(RequestFile)== "undefined"){
            $('#ErrRequestFile').html("Please choose the file");
            $('#frmRequestFile').focus();
            $('#frmRequestFile').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Comments)== ""){
            $('#ErrRequestComments').html("Please fill the comments");
            $('#frmRequestComments').focus();
            $('#frmRequestComments').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("oid",OrderId);
            ProfileFormData.append("c",Comments);
            ProfileFormData.append("rf",$("#frmRequestFile").prop("files")[0]);
        }
        $.ajax({
            url 		: base_path+'orders/updateReplacement',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSendRequestRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSendRequestRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrRequestOrderCode').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessRequestReplacement").removeClass('hide');
            $("#divSuccessRequestReplacement").html("Your replacement request has been sent!");
            resetForm('frmNameRequestReplacement');
            fnListReplacementHistory();
        }
    }
}


var GlbSearchParam='';
function fnListReplacementHistory() {
    GlbSearchParam								= "rfrom=1";
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'orders/replacementhistory/',GlbSearchParam,'json',fnListReplacementHistoryRes);
}

function fnListReplacementHistoryRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Request(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Request Date</th><th>Request Code</th><th>Order Code</th><th>File Name</th><th>Status</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td>'+value.rd+'</td><td>'+value.rc+'</td><td><a href="'+base_path+'checkout/paymentsummary/'+value.pl+'/" target="_blank">'+value.oc+'</a></td><td><a href="'+base_path+'uploads/replacement/'+value.rf+'">Download</a></td><td>'+value.rs+'</td><td><a href="javascript:void(0);" onclick="fnViewRequestInfo('+value.id+')">View</a></td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Request(s) found</td></tr>';
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


function fnPaginationReplacementHistoryList(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListReplacementHistoryRes);
}

function fnViewRequestInfo(ReplacementId) {
    var Parameters      = 'rid='+ReplacementId;
    MakePostRequest(base_path+'orders/getReplacementInfo/',Parameters,'json',fnViewRequestInfoRes);
}

function fnViewRequestInfoRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.id>0) {
                    $('#modalReplacementInfo').modal();
                    $('#modalReplacementInfo').modal('show');
                    $("#divRepRequestCode").html(data.rc);
                    $("#divRepOrderCode").html(data.oc);
                    $("#divRepReqFile").html('<a href="'+base_path+'uploads/replacement/'+data.rf+'">Download/View</a>');
                    $("#divRepComments").html(data.c);
                }
            }
        }
    }
}