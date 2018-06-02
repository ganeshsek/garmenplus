$(function() {
	if (localStorage.chkbx && localStorage.chkbx != '') {
		$('#frmLoginRememberMe').attr('checked', 'checked');
		$('#frmEmail').val(localStorage.usrname);
		$('#frmPass').val(localStorage.pass);
	} else {
		$('#frmLoginRememberMe').removeAttr('checked');
		$('#frmEmail').val('');
		$('#frmPass').val('');
	}
});

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
	fnRemeberMePass();
	var Parameters = "e="+InpEmail+"&p="+InpPassword;
	MakePostRequest(base_path+'login/validate',Parameters,'json',FnDisplayLogin);
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
			if(data.ut==1) {
				window.location.href=base_path+'cadmin/dashboard';
			} else if(data.ut==2) {
				window.location.href=base_path+'company/dashboard';
			}
		}
	}
}

function fnRemeberMePass() {
	if($('#frmLoginRememberMe').is(':checked')) {
		localStorage.usrname = $('#frmEmail').val();
		localStorage.pass = $('#frmPass').val();
		localStorage.chkbx = $('#frmLoginRememberMe').val();
	} else {
		localStorage.usrname = '';
		localStorage.pass = '';
		localStorage.chkbx = '';
	}
}




function fnForgotPass() {
	$('.form-control').css("border", "1px solid #cccccc");
	$('div.herr').html('');
	var InpEmail		= $("#frmFPEmail").val();
	if(jsTrim(InpEmail)== ""){
		$('#ErrFPEmail').html("Please fill the E-Mail Id");
		$('#frmFPEmail').focus();
		$('#frmFPEmail').css("border", "1px solid #B94A48");
		return false;		
	}
	var Parameters = "e="+InpEmail;
	MakePostRequest(base_path+'login/forgotpassword',Parameters,'json',fnForgotPassRes);
	return false;
}

function fnForgotPassRes(data){
	if(data!=''){ 
		if(data.errcode == '404') {
			fnCallSessionExpire();
			return false;
		} else if(data.errcode==-1){ 
			$('#ErrFPEmail').html(data.msg);
			return false;
		} else if(data.errcode==1){ 
			resetForm('frmNameForgotPass');
			$('#ErrForgotPassMsg').html(data.msg);
		}
	}
}