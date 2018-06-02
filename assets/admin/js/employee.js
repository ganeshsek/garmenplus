function fnSaveEmployee() {
	$('.form-control').css("border", "1px solid #cccccc");
	$('div.herr').html('');
	var ProfileFormData							= false;
	var EmployeeName							= $("#frmEmployeeName").val();
	var Email									= $("#frmEmail").val();
	var EmpPassword								= $("#frmPassword").val();
	var EmCnfPassword							= $("#frmCnfPassword").val();
	var MobileNo								= $("#frmMobile").val();
	var EmpPermisssionProfile					= $("#frmPermissionProfile").val();
	var EmployeeId								= '';
	var ProfileStatus							= $('input[name="frmProfileStatus"]:checked').val();
	if(GlbEmployeeId>=1) {EmployeeId=GlbEmployeeId;}
	if(jsTrim(EmployeeName)== ""){
		$('#ErrEmployeeName').html("Please fill the Employee Name");
		$('#frmEmployeeName').focus();
		$('#frmEmployeeName').css("border", "1px solid #B94A48");
		return false;		
	}
	if(jsTrim(Email)== ""){
		$('#ErrEmail').html("Please fill the E-Mail Id");
		$('#frmEmail').focus();
		$('#frmEmail').css("border", "1px solid #B94A48");
		return false;		
	} else if(!isEmail(Email)) {
		$('#ErrEmail').html("Please fill the Vaild E-Mail Id!!!");
		$('#frmEmail').focus();
		$('#frmEmail').css("border", "1px solid #B94A48");
		return false;		
	}
	if(GlbEmployeeId=='' || (jsTrim(EmpPassword)!= "" || jsTrim(EmCnfPassword)!='')) {
		if(jsTrim(EmpPassword)== ""){
			$('#ErrPassword').html("Please fill the Password");
			$('#frmPassword').focus();
			$('#frmPassword').css("border", "1px solid #B94A48");
			return false;		
		} else if(jsTrim(EmpPassword).length<=5) {
			$('#ErrPassword').html("Password Should be minimum 6 Characters!!!");
			$('#frmPassword').focus();
			$('#frmPassword').css("border", "1px solid #B94A48");
			return false;	
		}
		if(jsTrim(EmCnfPassword)== ""){
			$('#ErrCnfPassword').html("Please fill the Confirm Password");
			$('#frmCnfPassword').focus();
			$('#frmCnfPassword').css("border", "1px solid #B94A48");
			return false;		
		}
	}
	if(jsTrim(EmpPermisssionProfile)== ""){
		$('#ErrPermissionProfile').html("Please Chose the Profile Name");
		$('#frmPermissionProfile').focus();
		$('#frmPermissionProfile').css("border", "1px solid #B94A48");
		return false;		
	}
	
	if (window.FormData){
		ProfileFormData								= new FormData();
		ProfileFormData.append("en", EmployeeName);
		ProfileFormData.append("e",Email);
		ProfileFormData.append("p",EmpPassword);
		ProfileFormData.append("cp",EmCnfPassword);	
		ProfileFormData.append("pp",EmpPermisssionProfile);	
		ProfileFormData.append("ps",ProfileStatus);	
		ProfileFormData.append("id",EmployeeId);
		ProfileFormData.append("m",MobileNo);
		ProfileFormData.append("pi",$("#frmProfileImg").prop("files")[0]);
	}
	$.ajax({
		url 		: base_path+'admin/administration/updateEmployee',
		data        : ProfileFormData ? ProfileFormData : ObjForm.serialize(),
		cache       : false,
		contentType : false,
		processData : false,
		type        : 'POST',
		success     : function(data, textStatus, jqXHR){
			data = jQuery.parseJSON(data);
			FnDisplayEmployeeRes(data);
		}
	});
	return false;
}

function FnDisplayEmployeeRes(data){
	if(data!=''){ 
		if(data.errcode == '404') {
			fnCallSessionExpire();
			return false;
		} else if(data.errcode==-1){ 
			$('#ErrEmail').html(data.msg);
			return false;
		} else if(data.errcode==1){ 
			$("#divSuccessMsg").removeClass('hide');
			$("#divSuccessMsg").html("Your Employee Details has been saved at successfully!!!");
			if(GlbEmployeeId>=1) {
				fnRedirectPageTimeOut(base_path+'admin/administration/manageemployee');
			} else {
				resetForm("frmNameEmpProfile");
			}
		}
	}
}

function fnShowEditImg() {
	if($('#frmEditImg').prop("checked")==true) {
		$("#frmProfileImg").prop("disabled",false);
	} else {
		$("#frmProfileImg").prop("disabled",true);
		$("#frmProfileImg").val('');
	}
}

function fnSearchEmployee() {
	var EmployeeName							= $("#frmSrchEmpName").val();
	var Email									= $("#frmSrchEmpEmail").val();
	var Mobile									= $("#frmSrchEmpMobile").val();
	var ProfileName								= $("#frmSrchEmpProfileName").val();
	var ProfileStatus							= $("#frmSrchEmpProfileStatus").val();
	var GlbSearchParam							= "rfrom=1&en="+EmployeeName+"&e="+Email+"&m="+Mobile+"&pn="+ProfileName+"&s="+ProfileStatus;
	$("#DivTotalCntResult").html('');
	$("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
	MakePostRequest(base_path+'admin/administration/manageemployee',GlbSearchParam,'json',fnListEmployeeRes);
}

function fnListEmployee() {
	GlbSearchParam								= "rfrom=1";
	$("#DivTotalCntResult").html('');
	$("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
	MakePostRequest(base_path+'admin/administration/manageemployee',GlbSearchParam,'json',fnListEmployeeRes);
}

function fnListEmployeeRes(data){
	if(data!=''){ 
		if(data.errcode!=undefined) {
			if(data.errcode == '404') {
				fnCallSessionExpire();
				return false;
			} else {
				var PageContent='';
				if(data.cn>0) {
					ListCount	= '<div style="font-weight:bold;">Number of Employee(s) : '+data.cn+'</div>';	
					PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Name</th><th>E-Mail</th><th>Mobile</th><th>Profile Name</th><th>Updated By</th><th>Status</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
					if(data.ct>0) {
						$.each(data.re,function(index,value){ 
							PageContent=PageContent+'<tr><td>'+value.n+'</td><td>'+value.e+'</td><td>'+value.m+'</td><td>'+value.pp+'</td><td>'+value.ub+'</td><td>'+value.ps+'</td><td>'+value.du+'</td><td>';
							PageContent=PageContent+'<a href="'+base_path+'admin/administration/employee/'+value.id+'/"><i class="fa fa-file-text-o"></i> Edit</a>';
							PageContent=PageContent+'&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteEmployee('+value.id+')"><i class="fa fa-trash-o"></i> Delete</a>';
							PageContent=PageContent+'</td></td>';
						});
					}
					$("#DivTotalCntResult").html(ListCount);
				} else {
					PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Records found</td></tr>';
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
function fnPagination(VarURL) {
	var Parameters = GlbSearchParam;
	$("#DivTotalCntResult").html('');
	$("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
	MakePostRequest(VarURL,Parameters,'json',fnListEmployeeRes);
}

function fnDeleteEmployee(Id) {
	if(confirm("Are you want to delete this employee?")) {
		var Parameters = "id="+Id;
		MakePostRequest(base_path+'admin/administration/delEmployee',Parameters,'json',fnDeleteEmployeeRes);
	}
}

function fnDeleteEmployeeRes(data){
	if(data!=''){ 
		if(data.errcode!=undefined) {
			if(data.errcode == '404') {
				fnCallSessionExpire();
				return false;
			} else {
				fnSearchEmployee();
			}
		}
	}
}