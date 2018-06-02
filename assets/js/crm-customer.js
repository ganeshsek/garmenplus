function fnShowProfileCont(VarDivShow) {
    var ArrProfileContList = ["DivContBasicInfo","DivContPwdInfo","DivContUsernameInfo"];
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
    if(VarDivShow=="DivContAddressInfo") {
        fnShowHideEndUserSub(2,'divShowAddressInfo');
    }
    $("#"+VarDivShow).addClass('show');
}

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

function fnSearchCustomer() {
    var ContactName							    = $("#frmSrchContactName").val();
    var Email									= $("#frmSrchEmailId").val();
    var Mobile      							= $("#frmSrchMobileNo").val();
    GlbSearchParam							    = "rfrom=1&n="+ContactName+"&e="+Email+"&m="+Mobile;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'profile/managecustomer',GlbSearchParam,'json',fnListCustomerRes);
}

function fnListCustomer() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'profile/managecustomer',GlbSearchParam,'json',fnListCustomerRes);
}

function fnListCustomerRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Customer(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Name</th><th>E-Mail Id</th><th>Password</th><th>Mobile No</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+'profile/addeditcustomer/'+escape(base64_encode(value.id))+'/">'+value.n+'</a></td><td>'+value.e+'</td><td>'+value.p+'</td><td>'+value.m+'</td><td>'+value.du+'</td><td>';
                            PageContent=PageContent+'<a href="'+base_path+'profile/addeditcustomer/'+escape(base64_encode(value.id))+'/"><i class="fa fa-file-text-o"></i> Edit</a>';
                            PageContent=PageContent+'&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteUser('+value.id+')"><i class="fa fa-trash-o"></i> Delete</a>';
                            PageContent=PageContent+'</td></td>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No User(s) found</td></tr>';
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
function fnPaginationCustomer(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListCustomerRes);
}

function fnDeleteUser(Id) {
    if(confirm("Are you want to delete this employee?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+'profile/delCustomer',Parameters,'json',fnDeleteUserRes);
    }
}

function fnDeleteUserRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchCustomer();
            }
        }
    }
}

function fnSaveCustomer() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Name        							= $("#frmBasicContactName").val();
        var Email									= $("#frmBasicEmail").val();
        var Mobile  								= $("#frmBasicMobile").val();

        var UserId								    = '';
        if(GlbUserId>=1) {UserId=GlbUserId;}
        if(jsTrim(Name)== ""){
            $('#ErrBasicContactName').html("Please fill the name");
            $('#frmBasicContactName').focus();
            $('#frmBasicContactName').css("border", "1px solid #B94A48");
            return false;
        }
        if($("#frmBasicEmail").length) {
            if (jsTrim(Email) == "") {
                $('#ErrBasicEmail').html("Please fill the email id");
                $('#frmBasicEmail').focus();
                $('#frmBasicEmail').css("border", "1px solid #B94A48");
                return false;
            } else if (!isEmail(Email)) {
                $('#ErrBasicEmail').html("Invalid email id!");
                $('#frmBasicEmail').focus();
                $('#frmBasicEmail').css("border", "1px solid #B94A48");
                return false;
            }
        }
        if(jsTrim(Mobile)== ""){
            $('#ErrBasicMobile').html("Please fill the mobile no");
            $('#frmBasicMobile').focus();
            $('#frmBasicMobile').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("n",Name);
            ProfileFormData.append("e",Email);
            ProfileFormData.append("m",Mobile);
            ProfileFormData.append("id",UserId);
        }
        $.ajax({
            url 		: base_path+'profile/updateCustomer',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveCustomerRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveCustomerRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicEmail').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbUserId   = data.uid;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("User profile updated at successfully!");
            fnRedirectPageTimeOut(base_path+'profile/addeditcustomer/'+data.euid);
        }
    }
}

function fnCustomerResetPassword() {
    var Parameters = "uid="+GlbUserId;
    MakePostRequest(base_path+'profile/customerResetPassword',Parameters,'json',fnCustomerResetPasswordRes);
}

function fnCustomerResetPasswordRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            //$('#ErrAddressName').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessPasswordInfoMsg").removeClass('hide');
            $("#divSuccessPasswordInfoMsg").html("New Password has been sent!");
        }
    }
}