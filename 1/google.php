<?php
  $url = "www.baidu.com/s?wd=".$_POST['q'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $contents = curl_exec($ch);
  echo $contents;
  curl_close($ch);
?>