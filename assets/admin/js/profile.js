function fnSaveProfile() {
	$('.form-control').css("border", "1px solid #cccccc");
	$('div.herr').html('');
	var ProfileName		= $("#frmProfileName").val();
	if(jsTrim(ProfileName)== ""){
		$('#ErrProfileName').html("Please fill the Profile NAme");
		$('#frmProfileName').focus();
		$('#frmProfileName').css("border", "1px solid #B94A48");
		return false;		
	}
	var Parameters = "pn="+ProfileName+"&id="+GlbProfileId;	
	MakePostRequest(base_path+'admin/administration/updateProfile',Parameters,'json',FnDisplayProfileRes);
	return false;
}

function FnDisplayProfileRes(data){
	if(data!=''){ 
		if(data.errcode == '404') {
			fnCallSessionExpire();
			return false;
		} else if(data.errcode==-1){ 
			$('#ErrProfileName').html(data.msg);
			return false;
		} else if(data.errcode==1){ 
			$("#divSuccessMsg").removeClass('hide');
			$("#divSuccessMsg").html("Your Profile Name has been saved at successfully!!!");
			if(GlbProfileId=='') {
				resetForm("frmNameProfile");
			} else {
				fnRedirectPageTimeOut(base_path+'admin/administration/manageprofile');
			}
		}
	}
}

function fnListProfile() {
	GlbSearchParam								= "rfrom=1";
	$("#DivTotalCntResult").html('');
	$("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
	MakePostRequest(base_path+'admin/administration/manageprofile',GlbSearchParam,'json',fnListProfileRes);
}

function fnListProfileRes(data){
	if(data!=''){ 
		if(data.errcode!=undefined) {
			if(data.errcode == '404') {
				fnCallSessionExpire();
				return false;
			} else {
				var PageContent='';
				if(data.cn>0) {
					ListCount	= '<div style="font-weight:bold;">Number of Profile(s) : '+data.cn+'</div>';	
					PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Profile Name</th><th>Updated By</th><th>Status</th><th>Date Updated</th><th>Action</th></tr></thead><tbody>";
					if(data.ct>0) {
						$.each(data.re,function(index,value){ 
							PageContent=PageContent+'<tr><td>'+value.n+'</td><td>'+value.ub+'</td><td>'+value.ps+'</td><td>'+value.du+'</td><td>';
							PageContent=PageContent+'<a href="'+base_path+'admin/administration/profile/'+value.id+'/"><i class="fa fa-file-text-o"></i> Edit</a>';
							PageContent=PageContent+'&nbsp;&nbsp;<a href="javascript:void(0);" onclick="fnDeleteProfile('+value.id+')"><i class="fa fa-trash-o"></i> Delete</a>';
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
	MakePostRequest(VarURL,Parameters,'json',fnListProfileRes);
}

function fnDeleteProfile(Id) {
	if(confirm("Are you want to delete this profile?")) {
		var Parameters = "id="+Id;
		MakePostRequest(base_path+'admin/administration/delProfile',Parameters,'json',fnDeleteProfileRes);
	}
}

function fnDeleteProfileRes(data){
	if(data!=''){ 
		if(data.errcode!=undefined) {
			if(data.errcode == '404') {
				fnCallSessionExpire();
				return false;
			} else {
				fnListProfile();
			}
		}
	}
}