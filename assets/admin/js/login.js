function fnLogin() {
	$('.form-control').css("border", "1px solid #cccccc");
	$('div.herr').html('');
	var InpEmail		= $("#frmEmail").val();
	var InpPassword		= $("#frmPass").val();
	if(jsTrim(InpEmail)== ""){
		$('#ErrEmail').html("Please fill the E-Mail Id");
		$('#frmEmail').focus();
		$('#frmEmail').css("border", "1px solid #B94A48");
		return false;		
	}
	if(jsTrim(InpPassword)== ""){
		$('#ErrPass').html("Please fill the Password");
		$('#frmPass').focus();
		$('#frmPass').css("border", "1px solid #B94A48");
		return false;		
	}
	var Parameters = "e="+InpEmail+"&p="+InpPassword;
	MakePostRequest(base_path+'admin/login/validate',Parameters,'json',FnDisplayLogin);
	return false;
}

function FnDisplayLogin(data){
	if(data!=''){ 
		if(data.errcode == '404') {
			fnCallSessionExpire();
			return false;
		} else if(data.errcode==-1){ 
			$('#ErrLoginMsg').html(data.msg);
			return false;
		} else if(data.errcode==1){ 
			window.location.href=base_path+'admin/dashboard';
		}
	}
}

function fnShowLoginBox(VarType) {
	$('#ErrLoginMsg').html('');
	$('#ErrForgotPassMsg').html('');
	if(VarType==1) {
		$('#divFPBox').removeClass('hide');
		$('#divLoginBox').removeClass('hide');
		$('#divFPBox').removeClass('show');
		$('#divLoginBox').removeClass('show');
		$('#divLoginBox').addClass('show');
		$('#divFPBox').addClass('hide');
	} else {
		$('#divFPBox').removeClass('hide');
		$('#divLoginBox').removeClass('hide');
		$('#divFPBox').removeClass('show');
		$('#divLoginBox').removeClass('show');
		$('#divFPBox').addClass('show');
		$('#divLoginBox').addClass('hide');
	}
}

function fnForgotPass() {
	$('.form-control').css("border", "1px solid #cccccc");
	$('div.herr').html('');
	var InpEmail		= $("#frmFPEmail").val();
	if(jsTrim(InpEmail)== ""){
		$('#ErrEmail').html("Please fill the E-Mail Id");
		$('#frmEmail').focus();
		$('#frmEmail').css("border", "1px solid #B94A48");
		return false;		
	}
	var Parameters = "e="+InpEmail;
	MakePostRequest(base_path+'admin/login/forgotpassword',Parameters,'json',fnForgotPassRes);
	return false;
}

function fnForgotPassRes(data){
	if(data!=''){ 
		if(data.errcode == '404') {
			fnCallSessionExpire();
			return false;
		} else if(data.errcode==-1){ 
			$('#ErrLoginMsg').html(data.msg);
			return false;
		} else if(data.errcode==1){ 
			resetForm('frmNameForgotPass');
			$('#ErrForgotPassMsg').html(data.msg);
		}
	}
}