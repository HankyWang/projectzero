<?php 
$pattern = '/<(img.+?src|link.+?href) *= *[\"\'](.+?logo.*?\.(png|jpg|jpeg))[\"\'].*>/m';
$contents1 = '<img hidefocus="true" src="//www.baidu.com/img/bd_logo1.png" width="270" height="129">';
preg_match_all($pattern, $contents1, $matches1);
$contents2 = '<link rel="apple-touch-icon-precomposed" href="http://img1.cache.netease.com/www/logo/logo-ipad-icon.png">';
preg_match_all($pattern, $contents2, $matches2); 
echo '<pre>';
var_dump($matches1);
var_dump($matches2);
echo '</pre>';
?> 