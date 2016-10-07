<?php
	function getMobile($mobile)
	{
		$ch = curl_init();
    $url = 'http://apis.baidu.com/apistore/mobilenumber/mobilenumber?phone=15210011578';
    $header = array(
        'apikey: 06bcc1beda76fa5951ae6e72448d3239',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = json_decode(curl_exec($ch), true);


    $template = "省份：%s\n城市：%s\n供应商：%s";
    $resultStr = sprintf($template, $res["retData"]["province"], $res["retData"]["city"], $res["retData"]["supplier"]);
		return $resultStr;
	}

?>