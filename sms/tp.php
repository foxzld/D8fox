<?php
//字体大小
$size = 30;
//字体类型，本例为宋体
$font ="c:/windows/fonts/simsun.ttc";
//显示的文字
$text = "www.phpddt.com";
//创建一个长为500高为80的空白图片
$img = imagecreate(500, 80);
//给图片分配颜色
imagecolorallocate($img, 0xff, 0xcc, 0xcc);
//设置字体颜色
$black = imagecolorallocate($img, 0, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, 0, 50, 50, $black, $font, $text);
//发送头信息
header('Content-Type: image/gif');
//输出图片
imagegif($img);
?>
