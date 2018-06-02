function fnShowRegister() {
    $('#modalRegister').modal();
    $('#modalRegister').modal('show');
}

function fnHideRegister() {
    $('#modalRegister').modal();
    $('#modalRegister').modal('hide');
}

function fnShowLogin() {
    $('#modalLogin').modal();
    $('#modalLogin').modal('show');
}

function fnHideLogin() {
    $('#modalLogin').modal();
    $('#modalLogin').modal('hide');
}

function fnShowForgotPassword() {
    $('#modalForgotPassword').modal();
    $('#modalForgotPassword').modal('show');
}

function fnHideForgotPassword() {
    $('#modalForgotPassword').modal();
    $('#modalForgotPassword').modal('hide');
}

function fnUserRegister() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Name        							= $("#frmRegisterFullName").val();
        var RegAccept   							= $('input[name="frmRegisterTerms"]:checked').val();
        var Email									= $("#frmRegisterEmailId").val();
        var Mobile  								= $("#frmRegisterPhoneNo").val();
        if(jsTrim(Name)== ""){
            $('#ErrRegisterFullName').html("Please fill the name");
            $('#frmRegisterFullName').focus();
            $('#frmRegisterFullName').css("border", "1px solid #B94A48");
            return false;
        }
        if (jsTrim(Email) == "") {
            $('#ErrRegisterEmailId').html("Please fill the email id");
            $('#frmRegisterEmailId').focus();
            $('#frmRegisterEmailId').css("border", "1px solid #B94A48");
            return false;
        } else if (!isEmail(Email)) {
            $('#ErrRegisterEmailId').html("Invalid email id!");
            $('#frmRegisterEmailId').focus();
            $('#frmRegisterEmailId').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Mobile)== ""){
            $('#ErrRegisterPhoneNo').html("Please fill the mobile no");
            $('#frmRegisterPhoneNo').focus();
            $('#frmRegisterPhoneNo').css("border", "1px solid #B94A48");
            return false;
        }
        if(typeof(RegAccept)== "undefined"){
            $('#ErrRegisterTerms').html("Please choose the terms and condition");
            $('#frmRegisterTerms').focus();
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("n",Name);
            ProfileFormData.append("e",Email);
            ProfileFormData.append("m",Mobile);
        }
        $.ajax({
            url 		: base_path+'register/userRegister',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnUserRegisterRes(data);
            }
        });
        return true;
    } catch (e) {
        alert(e);
    }
}

function fnUserRegisterRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrRegisterEmailId').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessUserRegister").removeClass('hide');
            $("#divSuccessUserRegister").html("Thanks for registering with emaildatabase.io. Your password has been sent to your email id!");
            resetForm('frmNameWebRegister');
        }
    }
}

function fnUserLogin() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var EmailId        							= $("#frmLoginEmailId").val();
        var Password								= $("#frmLoginPassword").val();
        if (jsTrim(EmailId) == "") {
            $('#ErrLoginEmailId').html("Please fill the email id");
            $('#frmLoginEmailId').focus();
            $('#frmLoginEmailId').css("border", "1px solid #B94A48");
            return false;
        } else if (!isEmail(EmailId)) {
            $('#ErrLoginEmailId').html("Invalid email id!");
            $('#frmLoginEmailId').focus();
            $('#frmLoginEmailId').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Password)== ""){
            $('#ErrLoginPassword').html("Please fill the mobile no");
            $('#frmLoginPassword').focus();
            $('#frmLoginPassword').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("e",EmailId);
            ProfileFormData.append("p",Password);
        }
        $.ajax({
            url 		: base_path+'register/userLogin',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnUserLoginRes(data);
            }
        });
    } catch (e) {
        alert(e);
    }
}

function fnUserLoginRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrLoginEmailId').html(data.msg);
            return false;
        } else if(data.errcode==1){
            window.location.href=base_path+'profile/myprofile/';
            //$("#divSuccessUserRegister").removeClass('hide');
            //$("#divSuccessUserRegister").html("Product information has been saved at successfully!");
            //resetForm('frmNameWebRegister');
        }
    }
}


function fnFPSendPassword() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var EmailId        							= $("#frmForgotPassEmailId").val();
        if (jsTrim(EmailId) == "") {
            $('#ErrForgotPassEmailId').html("Please fill the email id");
            $('#frmForgotPassEmailId').focus();
            $('#frmForgotPassEmailId').css("border", "1px solid #B94A48");
            return false;
        } else if (!isEmail(EmailId)) {
            $('#ErrForgotPassEmailId').html("Invalid email id!");
            $('#frmForgotPassEmailId').focus();
            $('#frmForgotPassEmailId').css("border", "1px solid #B94A48");
            return false;
        }
        if (window.FormData){
            ProfileFormData								= new FormData();
            ProfileFormData.append("e",EmailId);
        }
        $.ajax({
            url 		: base_path+'register/forgotPassword',
            data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){
                data = jQuery.parseJSON(data);
                fnFPSendPasswordRes(data);
            }
        });
    } catch (e) {
        alert(e);
    }
}

function fnFPSendPasswordRes(data){
    if(data!=''){
        if(data.errcode == '404') {
            fnCallSessionExpire();
            return false;
        } else if(data.errcode==-1){
            $('#ErrForgotPassEmailId').html(data.msg);
            return false;
        } else if(data.errcode==1){
            $("#divSuccessForgotPassword").removeClass('hide');
            $("#divSuccessForgotPassword").html("Your Password has been sent to your E-Mail Id.");
            resetForm('frmNameForgotPassword');
        }
    }
}