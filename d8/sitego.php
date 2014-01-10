<?php
/*
Template Name: sitego
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">body{ margin:0; padding:0; overflow:hidden}</style>
</head>
<body scroll="no" id="msg">

<iframe id="goframe" src="" width="100%" marginwidth="0" height="100%" marginheight="0" align="top" scrolling="yes" frameborder="0"></iframe>
<div style="display:none;">
<script type="text/javascript">
document.getElementById('goframe').height=document.documentElement.clientHeight;
var urllink=document.URL;
var l=urllink.split('?')[1];
if(l){
	document.getElementById('goframe').src=l;	
}else{
	document.getElementById('msg').innerHTML='<p style="padding:20px;line-height:50px;">警告：请勿非法操作，系统3秒后将跳回首页。</p>';
	setTimeout('location.href="http://www.newsky365.com/daohang/"',3000);	
}
</script>


</div>
</body>
</html>