<?php
/*-------------------------------------------------
   |     weather.php [ 财付通手机归属地接口 ]
------------------------------------------------*/


function getPhoneNumInfo($mobile)
{
	if ($mobile == "" || (strstr($mobile, "+"))){
		return "发送'手机号+归属'，例如'13000000000归属'";
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