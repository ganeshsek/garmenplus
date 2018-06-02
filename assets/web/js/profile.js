function fnChangeProfileCont(VarDivShow) {
    var ArrProfileContList = ["divProfileBasicInfo","divProfileChangePassword"];
    for(i=0;i<ArrProfileContList.length;i++) {
        $("#"+ArrProfileContList[i]).removeClass('show');
        $("#"+ArrProfileContList[i]).removeClass('hide');
    }
    for(i=0;i<ArrProfileContList.length;i++) {
        if(VarDivShow!=ArrProfileContList[i]) {
            $("#"+ArrProfileContList[i]).addClass('hide');
        }
    }
    $("#"+VarDivShow).addClass('show');
}

function fnUpdateUserInfo() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Name        							= $("#frmBasicFullName").val();
        var Email									= $("#frmBasicEmailId").val();
        var Mobile  								= $("#frmBasicMobileNo").val();
        if(jsTrim(Name)== ""){
            $('#ErrBasicFullName').html("Please fill the name");
            $('#frmBasicFullName').focus();
            $('#frmBasicFullName').css("border", "1px solid #B94A48");
            return false;
        }
        if (jsTrim(Email) == "") {
            $('#ErrBasicEmailId').html("Please fill the email id");
            $('#frmBasicEmailId').focus();
            $('#frmBasicEmailId').css("border", "1px solid #B94A48");
            return false;
        } else if (!isEmail(Email)) {
            $('#ErrBasicEmailId').html("Invalid email id!");
            $('#frmBasicEmailId').focus();
            $('#frmBasicEmailId').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Mobile)== ""){
            $('#ErrBasicMobileNo').html("Please fill the mobile no");
            $('#frmBasicMobileNo').focus();
            $('#frmBasicMobileNo').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("n",Name);
            ProfileFormData.append("e",Email);
            ProfileFormData.append("m",Mobile);
        }
        $.ajax({
            url 		: base_path+'profile/updateUserInfo',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnUpdateUserInfoRes(data);
            }
        });
        return true;
    } catch (e) {
        alert(e);
    }
}

function fnUpdateUserInfoRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrBasicEmailId').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessUserBasicInfo").removeClass('hide');
            $("#divSuccessUserBasicInfo").html("Your profile details has been updated!!!");
        }
    }
}

function fnSaveChangePassword() {
    $('.form-control').css("border", "1px solid #cccccc");
    $('div.herr').html('');
    var InpOldPassword		= $("#frmCPOldPassword").val();
    var InpPassword			= $("#frmCPNewPassword").val();
    var InpConfPassword		= $("#frmCPConfirmPassword").val();
    if(jsTrim(InpOldPassword)== ""){
        $('#ErrCPOldPassword').html("Please fill the old Password");
        $('#frmCPOldPassword').focus();
        $('#frmCPOldPassword').css("border", "1px solid #B94A48");
        return false;
    } else if(jsTrim(InpOldPassword).length<=5) {
        $('#ErrCPOldPassword').html("Invalid Password!");
        $('#frmCPOldPassword').focus();
        $('#frmCPOldPassword').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(InpPassword)== ""){
        $('#ErrCPNewPassword').html("Please fill the New Password");
        $('#frmCPNewPassword').focus();
        $('#frmCPNewPassword').css("border", "1px solid #B94A48");
        return false;
    } else if(!isPasswordRule(InpPassword)) {
        $('#ErrCPNewPassword').html("Invalid Password!");
        $('#frmCPNewPassword').focus();
        $('#frmCPNewPassword').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(InpConfPassword)== ""){
        $('#ErrCPConfirmPassword').html("Please fill the confirm Password");
        $('#frmCPConfirmPassword').focus();
        $('#frmCPConfirmPassword').css("border", "1px solid #B94A48");
        return false;
    }
    if(jsTrim(InpPassword)!=jsTrim(InpConfPassword)){
        $('#ErrCPNewPassword').html("Password and Confirm Password should be same");
        $('#frmCPNewPassword').focus();
        $('#frmCPNewPassword').css("border", "1px solid #B94A48");
        return false;
    }
    var Parameters = "op="+InpOldPassword+"&np="+InpPassword+"&cp="+InpConfPassword;
    MakePostRequest(base_path+'profile/updatePassword',Parameters,'json',fnChangePasswordRes);
    return false;
}

function fnChangePasswordRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrCPOldPassword').html(data.msg);
            return false;
        } else if(data.errcode==1){
            resetForm('frmNameChangePassword');
            $('#divSuccessChangePasswordMsg').html(data.msg);
            $('#divSuccessChangePasswordMsg').removeClass('hide');
        }
    }
}