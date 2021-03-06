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

function fnSearchPort() {
    var PortName          				        = $("#frmSrchPortName").val();
    var PortAddress        				        = $("#frmSrchPortAddress").val();
    var PortCity          				        = $("#frmSrchPortCity").val();
    var PortCountry       				        = $("#frmSrchPortCountry").val();
    var Status          						= $("#frmSrchPortStatus").val();
    GlbSearchParam							    = "rfrom=1&pn="+PortName+"&s="+Status+"&pa="+PortAddress+"&pc="+PortCity+"&pcntry="+PortCountry;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/mport/manageport',GlbSearchParam,'json',fnListPortRes);
}

function fnListPort() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+GlbCAdminFdr+'/mport/manageport',GlbSearchParam,'json',fnListPortRes);
}

function fnListPortRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Record(s) : '+data.cn+'</div>';
                    PageContent	= "<table class='table table-bordered table-hover'><thead><tr><th>Port Name</th><th>Port Address</th><th>Port City</th><th>Port Country</th><th>Status</th><th>Updated By</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+GlbCAdminFdr+'/mport/addedit/'+escape(base64_encode(value.id))+'/">'+value.pn+'</a></td><td>'+value.pa+'</td><td>'+value.pc+'</td><td>'+value.pcntry+'</td><td>'+value.s+'</td><td>'+value.ub+'</td><td>'+value.du+'</td><td><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteSizeRange('+value.id+')">Delete</a></td>';
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

function fnPaginationPort(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListPortRes);
}

function fnDeletePort(Id) {
    if(confirm("Are you want to delete this port?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+GlbCAdminFdr+'/mport/delPortInfo',Parameters,'json',fnDeletePortRes);
    }
}

function fnDeletePortRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchPort();
            }
        }
    }
}

function fnSavePortInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var PortName     							= $("#frmBasicPortName").val();
        var PortAddress    							= $("#frmBasicPortAddress").val();
        var PortCity     							= $("#frmBasicPortCity").val();
        var PortCountry   							= $("#frmBasicPortCountry").val();
        var PortState     							= $("#frmBasicPortState").val();
        var Status        							= $("#frmBasicStatus").val();
        if(jsTrim(PortName)== ""){
            $('#ErrBasicPortName').html("Please fill the port name");
            $('#frmBasicPortName').focus();
            $('#frmBasicPortName').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(PortAddress)== ""){
            $('#ErrBasicPortAddress').html("Please fill the port address");
            $('#frmBasicPortAddress').focus();
            $('#frmBasicPortAddress').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(PortCountry)== ""){
            $('#ErrBasicPortCountry').html("Please fill the port country");
            $('#frmBasicPortCountry').focus();
            $('#frmBasicPortCountry').css("border", "1px solid #B94A48");
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
            ProfileFormData.append("pn",PortName);
            ProfileFormData.append("pa",PortAddress);
            ProfileFormData.append("pc",PortCity);
            ProfileFormData.append("ps",PortState);
            ProfileFormData.append("pcntry",PortCountry);
            ProfileFormData.append("s",Status);
            ProfileFormData.append("id",GlbId);
        }
        $.ajax({
            url 		: base_path+GlbCAdminFdr+'/mport/updatePortInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSavePortRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSavePortRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicPortName').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbId       = data.id;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("Port has updated at successfully!");
            fnRedirectPageTimeOut(base_path+GlbCAdminFdr+'/mport/addedit/'+data.eid);
        }
    }
}