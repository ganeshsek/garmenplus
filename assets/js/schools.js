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

function fnSearchSchools() {
    var ContactName							    = $("#frmSrchContactName").val();
    var Email									= $("#frmSrchEmailId").val();
    var Mobile      							= $("#frmSrchPhoneNo").val();
    var SchoolName      						= $("#frmSrchSchoolName").val();
    GlbSearchParam							    = "rfrom=1&n="+ContactName+"&e="+Email+"&m="+Mobile+"&sn="+SchoolName;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'schools/manageschools',GlbSearchParam,'json',fnListSchoolRes);
}

function fnListSchools() {
    GlbSearchParam								= "rfrom=1";
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(base_path+'schools/manageschools',GlbSearchParam,'json',fnListSchoolRes);
}

function fnListSchoolRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of School(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>School Name</th><th>Name</th><th>E-Mail Id</th><th>Username</th><th>Password</th><th>Phone No.</th><th>Date Updated</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td><a href="'+base_path+'schools/addeditschools/'+escape(base64_encode(value.id))+'/">'+value.sn+'</a></td><td><a href="'+base_path+'schools/addeditschools/'+escape(base64_encode(value.id))+'/">'+value.n+'</a></td><td>'+value.e+'</td><td>'+value.un+'</td><td>'+value.p+'</td><td>'+value.m+'</td><td>'+value.du+'</td>';
                            PageContent=PageContent+'</td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No School(s) found</td></tr>';
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
function fnPaginationSchools(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListSchoolRes);
}

function fnDeleteSchools(Id) {
    if(confirm("Are you want to delete this school?")) {
        var Parameters = "id="+Id;
        MakePostRequest(base_path+'schools/delSchool',Parameters,'json',fnDeleteAdminSchoolRes);
    }
}

function fnDeleteAdminSchoolRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                fnSearchSchools();
            }
        }
    }
}

function fnSaveSchool() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Name        							= $("#frmBasicContactName").val();
        var SchoolName     							= $("#frmBasicSchoolName").val();
        var Email									= $("#frmBasicEmail").val();
        var Phone     								= $("#frmBasicPhone").val();

        var SchoolId							    = '';
        if(GlbSchoolId>=1) {SchoolId=GlbSchoolId;}
        if(jsTrim(SchoolName)== ""){
            $('#ErrBasicSchoolName').html("Please fill the school name");
            $('#frmBasicSchoolName').focus();
            $('#frmBasicSchoolName').css("border", "1px solid #B94A48");
            return false;
        }
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
        if(GlbSchoolId==0) {
            var Username  								= $("#frmBasicUsername").val();
            var Password 							    = $("#frmBasicPassword").val();
            var ConfirmPassword						    = $("#frmBasicCnfPassword").val();
            if(jsTrim(Username)== ""){
                $('#ErrBasicUsername').html("Please fill the username");
                $('#frmBasicUsername').focus();
                $('#frmBasicUsername').css("border", "1px solid #B94A48");
                return false;
            } else if(!isUsername(Username)) {
                $('#ErrBasicUsername').html("Invalid Username");
                $('#frmBasicUsername').focus();
                $('#frmBasicUsername').css("border", "1px solid #B94A48");
                return false;
            }
            if(jsTrim(Password)== ""){
                $('#ErrBasicPassword').html("Please fill the New Password");
                $('#frmBasicPassword').focus();
                $('#frmBasicPassword').css("border", "1px solid #B94A48");
                return false;
            } else if(!isPasswordRule(Password)) {
                $('#ErrBasicPassword').html("Invalid Password!");
                $('#frmBasicPassword').focus();
                $('#frmBasicPassword').css("border", "1px solid #B94A48");
                return false;
            }
            if(jsTrim(ConfirmPassword)== ""){
                $('#ErrBasicCnfPassword').html("Please fill the confirm Password");
                $('#frmBasicCnfPassword').focus();
                $('#frmBasicCnfPassword').css("border", "1px solid #B94A48");
                return false;
            }
            if(jsTrim(Password)!=jsTrim(ConfirmPassword)){
                $('#ErrBasicCnfPassword').html("Password and Confirm Password should be same");
                $('#frmBasicCnfPassword').focus();
                $('#frmBasicCnfPassword').css("border", "1px solid #B94A48");
                return false;
            }
        }

        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("n",Name);
            ProfileFormData.append("sn",SchoolName);
            ProfileFormData.append("e",Email);
            ProfileFormData.append("ph",Phone);
            if(GlbSchoolId==0) {
                ProfileFormData.append("un",Username);
                ProfileFormData.append("p",Password);
            }
            ProfileFormData.append("id",SchoolId);
        }
        $.ajax({
            url 		: base_path+'schools/updateSchool',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnSaveSchoolRes(data);
            }
        });
        return false;
    } catch(e) {
        alert(e);
    }
}

function fnSaveSchoolRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicEmail').html(data.msg);
            return false;
        } else if(data.errcode==1){
            GlbSchoolId   = data.uid;
            $("#divSuccessBasicInfoMsg").removeClass('hide');
            $("#divSuccessBasicInfoMsg").html("School account has been created at successfully!");
            fnRedirectPageTimeOut(base_path+'schools/addeditschools/'+data.euid);
        }
    }
}

function fnSchoolResetPassword() {
    var Parameters = "uid="+GlbSchoolId;
    MakePostRequest(base_path+'schools/schoolResetPassword',Parameters,'json',fnSchoolResetPasswordRes);
}

function fnSchoolResetPasswordRes(data){
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