<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function fnGetUserLoggedInfo($VarType='') {
	$ObjCI						= & get_instance();
	$ArrProfileInfo				= @$ObjCI->session->userdata['UI'];
	if(@$ArrProfileInfo['id']>=1) {
		if($VarType==1) {
			return $ArrProfileInfo;
		} else if($VarType==2) {

		} else {
			return $ArrProfileInfo['id'];
		}
	} else {
		return '';
	}
}

function fnIfCheckUserLoggedIn() {
	$VarUserId					= fnGetUserLoggedInfo();
	if (@$VarUserId=='') {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			echo json_encode(array('errcode'=>'404','rdl'=>'admin'));die;
		} else {
			redirect(base_url());
		}
	}
}

function fnGetWebUserLoggedInfo($VarType='') {
	$ObjCI						= & get_instance();
	$ArrProfileInfo				= @$ObjCI->session->userdata['WUI'];
	if(@$ArrProfileInfo['id']>=1) {
		if($VarType==1) {
			return $ArrProfileInfo;
		} else if($VarType==2) {

		} else {
			return $ArrProfileInfo['id'];
		}
	} else {
		return '';
	}
}

function fnIfCheckWebUserLoggedIn() {
	$VarUserId					= fnGetWebUserLoggedInfo();
	if (@$VarUserId=='') {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			echo json_encode(array('errcode'=>'404','rdl'=>''));die;
		} else {
			redirect(base_url());
		}
	}
}

function SendSMS($VarMobileNo='',$VarMessage='') {
	$ObjCI						= & get_instance();
	$VarUserName				= $ObjCI->config->item('SMSUSERNAME');
	$VarPassword				= $ObjCI->config->item('SMSPASSWORD');
	$VarSMSGatewayURL			="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
	$VarMessage					= urlencode($VarMessage);
	$ObjSMSCURL					= curl_init();
	curl_setopt($ObjSMSCURL, CURLOPT_URL,$VarSMSGatewayURL);
	curl_setopt($ObjSMSCURL, CURLOPT_POST, 1);
	curl_setopt($ObjSMSCURL, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ObjSMSCURL, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ObjSMSCURL, CURLOPT_POSTFIELDS,"User=$VarUserName&passwd=$VarPassword&mobilenumber=$VarMobileNo&message=$VarMessage&sid=smscntry&mtype=N&DR=N");
	curl_setopt($ObjSMSCURL, CURLOPT_RETURNTRANSFER, 1);
	$ObjRes						= curl_exec($ObjSMSCURL);
	$info						= curl_getinfo($ObjSMSCURL);
	curl_close($ObjSMSCURL);
	if (empty($ObjRes)) {
		return false;
	} else {
		return true;
	}	
}

function SendEmail($VarToEmailID,$VarSubject,$VarMailerInfo,$ArrReplace=array(),$VarTestEmail='') {
	if($VarMailerInfo<>"") {
		$VarEmailerTempFileName		= str_replace("\\", "/",dirname(dirname(dirname(__FILE__))))."/application/views/emailtemplate/".$VarMailerInfo.".html";
		$ObjCI						= & get_instance();
		if($VarMailTemplate			= fopen($VarEmailerTempFileName, "r")) {
			$VarContents			= '';
			$VarContents			= fread($VarMailTemplate, filesize($VarEmailerTempFileName));
			fclose($VarMailTemplate);
			if(!empty($ArrReplace)){
				foreach($ArrReplace as $VarSearchString => $VarReplaceString){
					$VarContents	= str_replace($VarSearchString,$VarReplaceString,$VarContents);
				}
			}
			//echo "Tests";
			$VarContents			= getNotificationTheme($VarSubject,$VarContents, '');
			$VarToEmailID			= 'ganeshsek@gmail.com';
			//if($VarTestEmail<>'') {
			//$VarToEmailID		= 'ganesh.sekaran@yahoo.com';
			//}
			$ObjCI->email->from('ganesh.s@karadipath.com', 'Karadipath.com');
			$ObjCI->email->to($VarToEmailID);
			$ObjCI->email->subject($VarSubject);
			$ObjCI->email->message($VarContents);
			$ObjCI->email->set_mailtype('html');
			if($ObjCI->email->send()) {
				return true;
			} else {
				return false;
			}
		}
	}
}

function SendEmailOld($VarToEmailID,$VarSubject,$VarMailerInfo,$ArrReplace=array(),$VarTestEmail='') {
	if($VarMailerInfo<>"") {
		$VarEmailerTempFileName		= str_replace("\\", "/",dirname(dirname(dirname(__FILE__))))."/application/views/emailtemplate/".$VarMailerInfo.".html";
		$ObjCI						= & get_instance();
		if($VarMailTemplate			= fopen($VarEmailerTempFileName, "r")) {
			$VarContents			= '';
			$VarContents			= fread($VarMailTemplate, filesize($VarEmailerTempFileName));
			fclose($VarMailTemplate);		
			if(!empty($ArrReplace)){
				foreach($ArrReplace as $VarSearchString => $VarReplaceString){
					$VarContents	= str_replace($VarSearchString,$VarReplaceString,$VarContents);
				}
			}
			$VarContents			= getNotificationTheme($VarSubject,$VarContents, '');
			//$VarToEmailID			= 'gerberbruno@yahoo.fr';
			//if($VarTestEmail<>'') {
				//$VarToEmailID		= 'ganeshsek@gmail.com';
			//}
			$ObjCI->email->from("");
			$ObjCI->email->to($VarToEmailID);
			$ObjCI->email->subject($VarSubject);
			$ObjCI->email->message($VarContents);
			$ObjCI->email->set_mailtype('html');
			return true;
			/*if($ObjCI->email->send()) {
				return true;
			} else {
				return false;
			}*/
		}
	}
}

function SendEmailAfter($VarToEmailID,$VarSubject,$VarMailerInfo,$ArrReplace=array()) {
	if($VarMailerInfo<>"") {
		$VarEmailerTempFileName		= str_replace("\\", "/",dirname(dirname(dirname(__FILE__))))."/application/views/emailtemplate/".$VarMailerInfo.".html";
		$ObjCI						= & get_instance();
		if($VarMailTemplate			= fopen($VarEmailerTempFileName, "r")) {
			$VarContents			= '';
			$VarContents			= fread($VarMailTemplate, filesize($VarEmailerTempFileName));
			fclose($VarMailTemplate);
			if(!empty($ArrReplace)){
				foreach($ArrReplace as $VarSearchString => $VarReplaceString){
					$VarContents	= str_replace($VarSearchString,$VarReplaceString,$VarContents);
				}
			}
			$VarContents			= getNotificationTheme($VarSubject,$VarContents, '');
			$VarToEmailID			= 'ganeshsek@gmail.com';
			$headers = 'From: contact@subraa.xyz' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			mail($VarToEmailID, $VarSubject, $VarContents, $headers);
		}
	}
}

function str_rand($length = 8, $seeds = 'alphanum') {
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $seedings['hexidec'] = '0123456789abcdef';

    // Choose seed
    if (isset($seedings[$seeds])) {
        $seeds = $seedings[$seeds];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $seeds_count = strlen($seeds);

    for ($i = 0; $length > $i; $i++) {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }

    return strtoupper($str);
}

function fnCreateSlugURL($VarString=''){
   $VarSlugURL						= strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $VarString));
   return $VarSlugURL;
}

function encrypt_url($string) {
	$key							= "MAL_979805"; //key to encrypt and decrypts.
	$result							= '';
	$test							= "";
	for($i=0; $i<strlen($string); $i++) {
		$char						= substr($string, $i, 1);
		$keychar					= substr($key, ($i % strlen($key))-1, 1);
		$char						= chr(ord($char)+ord($keychar));
		$test[$char]				= ord($char)+ord($keychar);
		$result.=$char;
	}
	return urlencode(base64_encode($result));
}

function decrypt_url($string) {
	$key							= "MAL_979805"; //key to encrypt and decrypts.
	$result							= '';
	$string							= base64_decode(urldecode($string));
	for($i=0; $i<strlen($string); $i++) {
		$char						= substr($string, $i, 1);
		$keychar					= substr($key, ($i % strlen($key))-1, 1);
		$char						= chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

function fnTruncWords($phrase, $max_words) {
	$phrase_array = explode(' ',$phrase);
	if(count($phrase_array) > $max_words && $max_words > 0)
		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
	return $phrase;
}

function encrypt($plainText,$key) {
	$secretKey = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
	$plainPad = pkcs5_pad($plainText, $blockSize);
	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
		$encryptedText = mcrypt_generic($openMode, $plainPad);
		mcrypt_generic_deinit($openMode);

	}
	return bin2hex($encryptedText);
}

function decrypt($encryptedText,$key) {
	$secretKey = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText=hextobin($encryptedText);
	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	mcrypt_generic_init($openMode, $secretKey, $initVector);
	$decryptedText = mdecrypt_generic($openMode, $encryptedText);
	$decryptedText = rtrim($decryptedText, "\0");
	mcrypt_generic_deinit($openMode);
	return $decryptedText;
}

function fnOperatorList($VarOperatorCode='') {
	$ArrNetworkList		= unserialize(ARRMOBILERECHARGENETWORKNAME);
	if($VarOperatorCode<>'') {
		$OperatorInfo	= $ArrNetworkList[$VarOperatorCode];
	} else {
		$OperatorInfo	= $ArrNetworkList;
	}
	return $OperatorInfo;
}



//*********** Padding Function *********************
function pkcs5_pad ($plainText, $blockSize) {
	$pad = $blockSize - (strlen($plainText) % $blockSize);
	return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
	$length = strlen($hexString);
	$binString="";
	$count=0;
	while($count<$length) {
		$subString =substr($hexString,$count,2);
		$packedString = pack("H*",$subString);
		if ($count==0) {
			$binString=$packedString;
		} else {
			$binString.=$packedString;
		}

		$count+=2;
	}
	return $binString;
}

function fnGetLoginWithGooglePlusURL() {
	$CI						= & get_instance();
	$VarGooglePlusURL		= $CI->googleplus->loginURL();

	return $VarGooglePlusURL;
}

function fnGetLoginWithFacebookURL() {
	$CI						= & get_instance();
	$VarFacebookURL			= $CI->facebook->getLoginUrl(array('redirect_uri' => base_url().'register/socialresponse/2','scope' => array("email")));
	return $VarFacebookURL;
}

function fnGetLoginWithLinkedInURL() {
	return base_url()."register/linkedin_connect/";
}

?>