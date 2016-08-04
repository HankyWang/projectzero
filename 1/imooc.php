<?php
    $token     = 'weixin';
    $timestamp = $_GET['timestamp'];
    $nonce     = $_GET['nonce'];
    $signature = $_GET['signature'];
    $array     = array($token, $timestamp, $nonce);
    $tmpstr    = implode('', $array);
    $tmpstr    = sha1($tmpstr);
    if ($tmpstr == $signature){
        echo "imooc";
        exit();
    }
?>