function ucfirst(str,force){
	str=force ? str.toLowerCase() : str;
	return str.replace(/(\b)([a-zA-Z])/,
	function(firstLetter){
		return   firstLetter.toUpperCase();
	});
}

function ucwords(str,force){
	str=force ? str.toLowerCase() : str;
	return str.replace(/(\b)([a-zA-Z])/g,
	function(firstLetter){
		return   firstLetter.toUpperCase();
	});
}

function isEmail(strvalue) {
	return /^(\w+([\.-]?\w+){2,})*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(strvalue)
}

function isUsername(strvalue) {
	return /^[a-zA-Z0-9]+$/.test(strvalue);
}

function isPhoneNumber(strvalue){
	var ValidChars = "0123456789-\.";
	var IsNumber = true;
	var Char;
	for (i = 0; i < strvalue.length && IsNumber == true; i++) { 
		Char = strvalue.charAt(i);
		if (strvalue.match(/^0+$/)) return false;
		if (ValidChars.indexOf(Char) == -1) 
			IsNumber = false;
	}
	return IsNumber;
}

/*function isPastDate(StartDate,EndDate) {
	var firstValue = StartDate.split('-');
	var secondValue = EndDate.split('-');

	var firstDate=new Date(firstValue[2],firstValue[1],firstValue[1]);
	//firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[1]);

	var secondDate=new Date(secondValue[2],secondValue[1],secondValue[1]);
	//secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[1]);

	if (firstDate.getTime() < secondDate.getTime()) {
		return false;
	}
	return true;
}*/

function isPasswordRule(str){
	if (str.length < 6) {
		return false;
	} else if (str.search(/\d/) == -1) {
		return false;
	} else if (str.search(/[a-z]/) == -1) {
		return false;
	} else if (str.search(/[A-Z]/) == -1) {
		return false;
	}
	return true;
}

function isPassword(strvalue){
	return (/^[A-Za-z0-9\s!@#$_-]+$/).test(strvalue)
}

function isAplpha(strvalue) {
	return (/^[A-Z\sa-z]+$/).test(strvalue);
}

function isNumber(strvalue) {
	return /^(\d+)$/.test(strvalue);
}

function isFloatIntNumber(strvalue) {
	return /^[+-]?((\.\d+)|(\d+(\.\d+)?))$/.test(strvalue);
}

function isAlphaNumeric(strvalue) {
	return (/^[0-9A-Za-z]+([0-9A-Za-z-]*)+[0-9A-Za-z]+$/).test(strvalue)
}
function IsUrl(strvalue) {
	return (/^(ftp|https|http?):\/\/+(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,4}$/).test(strvalue);
}

function jsTrim(strvalue) {
	if(strvalue!=''){
		return strvalue.replace(/^(\s)+/g, '').replace(/(\s)+$/g, '');
	}else{
		return '';
	}
}

function resetForm(frmName) {
	$("#"+frmName).get(0).reset();
}

function fnCallSessionExpire(FolderName) {
	if(typeof(FolderName)  === "undefined") {
		window.location.href=base_path;
	} else {
		window.location.href=base_path+FolderName+'/';
	}
}

function string_to_slug(str) {
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();  
  // remove accents, swap � for n, etc
  var from = "����������������������/_,:;";
  var to   = "aaaaeeeeiiiioooouuuunc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }
  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes
  return str;
}

function base64_encode(data) {
	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
	ac = 0,
	enc = '',
	tmp_arr = [];

	if (!data) {
		return data;
	}

	do { // pack three octets into four hexets
	o1 = data.charCodeAt(i++);
	o2 = data.charCodeAt(i++);
	o3 = data.charCodeAt(i++);

	bits = o1 << 16 | o2 << 8 | o3;

	h1 = bits >> 18 & 0x3f;
	h2 = bits >> 12 & 0x3f;
	h3 = bits >> 6 & 0x3f;
	h4 = bits & 0x3f;

	// use hexets to index into b64, and append result to encoded string
	tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	} while (i < data.length);

	enc = tmp_arr.join('');

	var r = data.length % 3;

	return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

function in_array(needle, haystack, argStrict) {
	var key = '',
	strict = !! argStrict;
	if (strict) {
		for (key in haystack) {
		  if (haystack[key] === needle) {
			return true;
		  }
		}
	} else {
		for (key in haystack) {
		  if (haystack[key] == needle) {
			return true;
		  }
		}
	}

	return false;
}

function TrimWords(value,lengths) {
	var length=28;var overflowSuffix=' ...';
	if (value.length <= length) return value;
    var strAry = value.split(' ');
    var retLen = strAry[0].length;
    for (var i = 1; i < strAry.length; i++) {
        if(retLen == length || retLen + strAry[i].length + 1 > length) break;
        retLen+= strAry[i].length + 1
    }
    return strAry.slice(0,i).join(' ') + (overflowSuffix || '');
}

var GlbRedPageName='';
function fnRedirectPage() {
	window.location.href=GlbRedPageName;
}

function fnRedirectPageTimeOut(PageName) {
	GlbRedPageName=PageName;
	setTimeout("fnRedirectPage()",1000);
}

function base64_decode(data) {
  //  discuss at: http://phpjs.org/functions/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec.replace(/\0+$/, '');
}

function GetMultipleSelectValues(select) {
  var result = [];
  var optionss = select && select.options;
  var opt;

  for (var i=0, iLen=optionss.length; i<iLen; i++) {
    opt = optionss[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
    }
  }
  return result;
}

var GlbPAAVChElemId='';
function fnShowFollowupCommon(TypeId,VarElemId) {
	$("#"+VarElemId).removeClass('hide');
	$("#"+VarElemId).removeClass('show');
	if(TypeId==1) {
		$("#"+VarElemId).removeClass('hide');
	} else {
		$("#"+VarElemId).addClass('hide');
	}
}

function fnShowFollowupProduct(TypeId,VarElemId) {
	$("#"+VarElemId).removeClass('hide');
	$("#"+VarElemId).removeClass('show');
	if(TypeId==2) {
		$("#"+VarElemId).removeClass('hide');
	} else {
		$("#"+VarElemId).addClass('hide');
	}
}

function fnChkAllCheckBox(ClassName,SelBoxId) {
	$('.'+ClassName).prop('checked', $("#"+SelBoxId).prop("checked"));
}

function fnAddToCart(VarProductId) {
	GlbSearchParam								= "pid="+VarProductId;
	MakePostRequest(base_path+'checkout/addtocart',GlbSearchParam,'json',fnAddToCartRes);
}

function fnAddToCartRes(data){
	if(data!=''){
		if(data.errcode!=undefined) {
			if(data.errcode == '404') {
				fnCallSessionExpire();
				return false;
			} else if(data.errcode == '-1')  {
				alert("Already added this product to your cart. Please choose ther other product");
			} else {
				fnRedirectPageTimeOut(base_path+'checkout/cart/');
			}
		}
	}
}

function fnCommonShowProfileCont(VarDivShow) {
	var ArrProfileContList		  = GlbArrProfileContList;
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
	$("#"+VarDivShow).addClass('show');
}
