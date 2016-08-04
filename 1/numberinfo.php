<?php
function getPhoneNumInfo($mobile)
{
	if ( $mobile == "" || strlen($mobile) != 13 ){
		return "发送13位'手机号'，例如'13000000000'";
	}

	$url = "http://life.tenpay.com/cgi-bin/mobile/MobileQueryAttribution.cgi?chgmobile=".$mobile;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);

	$mobileInfo = simplexml_load_string($output);
	$resultStr="号码:".$mobileInfo->chgmobile." ".$mobileInfo->supplier."\n省份:".$mobileInfo->province."\n城市:".$mobileInfo->city;
	return $resultStr;
}

?>