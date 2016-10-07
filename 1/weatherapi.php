<?php
  $ch = curl_init();
  $phone = '13699192500';
  $url = 'http://apis.baidu.com/apistore/weatherservice/citylist?cityname=%E6%9C%9D%E9%98%B3';
  $header = array(
        'apikey: 06bcc1beda76fa5951ae6e72448d3239',
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch , CURLOPT_URL , $url);
  echo '<meta http-equiv="Content-Type" content="text/html;charset=UNICODE">';
  $res = curl_exec($ch);
  $arr = json_decode($res,true);
  echo "<pre>";
  var_dump($arr);
  echo "</pre>";
  //$content = "供应商: ".$arr['retData']['supplier']."\n省份:".$arr['retData']['province'];
  //echo $content;
?>