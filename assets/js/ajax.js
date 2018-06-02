function MakePostRequest(url,parameters,datatype,FnManageList) {
	$.ajax({
		type: 'POST',
		cache: false,
		async: false,
		contentType: 'application/x-www-form-urlencoded',
		url: url,
		data: parameters,
		dataType: datatype,
		success:FnManageList,
		error:FnErrcallback
	});
}

function MakeGetRequest(url,parameters,datatype,FnManageList) {
	$.ajax({
		type: 'GET',
		cache: false,
		async: false,
		contentType: 'application/x-www-form-urlencoded',
		url: url,
		data: parameters,
		dataType: datatype,
		success:FnManageList,
		error:FnErrcallback
	});
}

function MakeAsynPostRequest(url,parameters,datatype,FnManageList) {
	$.ajax({
		type: 'POST',
		cache: false,
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		url: url,
		data: parameters,
		dataType: datatype,
		success:FnManageList,
		error:FnErrcallback
	});
}

function FnErrcallback() {
	
}