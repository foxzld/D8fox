(function($) {
	var Y ='<p class="Y"><strong>网站提交成功！</strong>通过审核后，您的网站就会出现在对应的类别里。<br>或选择<strong>继续提交</strong>或<strong>关闭</strong></p>';
	var N= '<p class="N">对不起，提交未成功，请检查填写的信息或联系管理员。<br>或选择<strong>继续提交</strong>或<strong>关闭</strong></p>';
	var R = '<p class="N">对不起，该网站已提交过，请勿重复提交。<br>或选择<strong>提交其他网站</strong>或<strong>关闭</strong></p>';
	var form = $('#site_form');
	var name = $('#site_name');
	var nameinfo = $('#nameinfo');
	var web = $('#site_url');
	var webinfo = $('#urlinfo');
	var types = $('#site_type');
	var typeinfo = $('#typeinfo');
	var text = $('#site_content');
	var textinfo = $('#textinfo');
	var button = $('#but');
	var site_msg = $('#site_msg');
	textinfo.html('还能输入<em>200</em>字');
	function validateName(){
		if(name.val().length < 1){
			name.addClass("error");
			nameinfo.text("请填写一下网站名称。");
			nameinfo.addClass("error");
			return false;
		}else{
			name.removeClass("error");
			nameinfo.text("");
			nameinfo.removeClass("error");
			return true;
		}
	}
	function validateUrl(){
		if(web.val().length < 1 ||web.val()=='http://'){
			web.addClass("error");
			webinfo.text("请填写一下网站地址。");
			webinfo.addClass("error");
			return false;
		}else{
			web.removeClass("error");
			webinfo.text("记得加上http://");
			webinfo.removeClass("error");
			return true;
		}
	}
	function checkUrl(){
		var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
		if(tomatch.test(web.val())){
			web.removeClass("error");
			webinfo.text("记得加上http://");
			webinfo.removeClass("error");
			return true;
		}else{
			web.addClass("error");
			webinfo.text("请填写正确的网址。");
			webinfo.addClass("error");
			return false;
		}
	}
	function validateHttp(){
		if(web.val().length < 1){
			web.val('http://');
			return true;
		}else if(web.val().indexOf('http://')<0){
			web.val('http://'+web.val());
			return true;
		}
	}
	function validateType(){
		if(types.val()==0){
			types.addClass("error");
			typeinfo.text("你还没有选择类型呢。");
			typeinfo.addClass("error");
			return false;
		}else{
			types.removeClass("error");
			typeinfo.text("");
			typeinfo.removeClass("error");
			return true;
		}
	}
	function validateText(){
		if(text.val().length>=0){
			textinfo.html('还能输入<em>'+(200-text.val().length)+'</em>字');
		}
		if(text.val().length>200){
			text.val(text.val().substring(0,200));
		}
		return true;
	}
	function callback(msg){
		if(msg == 'True'){
			site_msg.html(Y);
			setInterval(showMsg,5000);
		}else if(msg == 'False'){
			site_msg.html(N);
			setInterval(showMsg,5000);
		}else if(msg == 'Repeat'){
			site_msg.html(R);
			setInterval(showMsg,5000);
		}else{
			site_msg.html(N);
			setInterval(showMsg,5000);
		}

		clearInterval(showMsg);
	}
	function error(er){

	}
	function showMsg(){
		site_msg.fadeOut(1500);
		button.removeAttr('disabled');
		button.val('提交');
	}

	name.blur(validateName);
	name.keyup(validateName);
	web.blur(validateUrl,validateHttp);
	web.keyup(validateUrl);
	web.focus(validateHttp);
	text.keyup(validateText);
	text.focus(validateText);

	/*异步提交*/
	form.submit(function(){
		if(validateName() && validateUrl() && validateType() && checkUrl()){
			button.attr('disabled','true');
			button.val('提交中…');
			site_msg.fadeIn('slow');
			site_msg.html('<p>提交中请稍候……</p>');
			$.ajax({
				type: "POST",
				url:"site_post.php",
				data:form.serialize(),
				dataType:"text",
				success: function(msg){
					callback(msg);
				},
				error:function(error){
					if(error.length>0){
						site_msg.html(N);
						setInterval(showMsg,5000);
					}
					clearInterval(showMsg);
				},
				timeout:30000 /*30秒超时*/
			});
			return false;
		}else{
			return false;
		}
	});
        //Tag切换
	$('.site-nav a').each(function(i){
		$(this).click(function(){
			$(this).parent().addClass('on').siblings('li').removeClass('on');
			$($('.site-links ul')[i]).addClass('on').siblings('.site-links ul').removeClass('on');
		})
	})

	$('.site-nav .abtn').click(function(){
		$('#siteform').fadeIn('slow');
	});

	/*关闭时处理*/
	$('#close').click(function(){
		button.removeAttr('disabled');
		button.val('提交');
		site_msg.css('display','none');
		$.event.trigger('ajaxStop');
		document.site_form.reset();
		textinfo.html('还能输入<em>200</em>字');
		$('#siteform').fadeOut('slow');
	});

	/*托拽代码*/
	var isIe = $.browser.msie;
    var isIe6 = $.browser.msie && ('6.0' == $.browser.version);
	if(isIe){
		$('#siteform').css('position','absolute');
		var top = parseInt($('#siteform').css('top')) - $(document).scrollTop();
		var left = parseInt($('#siteform').css('left')) - $(document).scrollLeft();
		$(window).scroll(function(){
			$('#siteform').css({'top':$(document).scrollTop() + top,'left':$(document).scrollLeft() + left});
		});
    }
	var mouse={x:0,y:0};
	function moveDialog(event)
	{
		var e = window.event || event;
		var top = parseInt($('#siteform').css('top')) + (e.clientY - mouse.y);
		var left = parseInt($('#siteform').css('left')) + (e.clientX - mouse.x);
		$('#siteform').css({top:top,left:left});
		mouse.x = e.clientX;
		mouse.y = e.clientY;
	};
	$('#siteform').find('h3').mousedown(function(event){
		var e = window.event || event;
		mouse.x = e.clientX;
		mouse.y = e.clientY;
		$(document).bind('mousemove',moveDialog);
		$('#siteform h3').css('cursor','move');
	});
	$(document).mouseup(function(event){
		$(document).unbind('mousemove', moveDialog);
		$('#siteform h3').css('cursor','');
	});

})(jQuery);