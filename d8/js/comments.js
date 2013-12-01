jQuery.noConflict();


jQuery(document).ready(function($) {
	function addEditor(a, b, c) {
		if (document.selection) {
			a.focus();
			sel = document.selection.createRange();
			c ? sel.text = b + sel.text + c: sel.text = b;
			a.focus()
		} else if (a.selectionStart || a.selectionStart == '0') {
			var d = a.selectionStart;
			var e = a.selectionEnd;
			var f = e;
			c ? a.value = a.value.substring(0, d) + b + a.value.substring(d, e) + c + a.value.substring(e, a.value.length) : a.value = a.value.substring(0, d) + b + a.value.substring(e, a.value.length);
			c ? f += b.length + c.length: f += b.length - e + d;
			if (d == e && c) f -= c.length;
			a.focus();
			a.selectionStart = f;
			a.selectionEnd = f
		} else {
			a.value += b + c;
			a.focus()
		}
	}
	var myDate = new Date();
	var mytime=myDate.toLocaleTimeString()
	var g = document.getElementById('comment') || 0;
	var h = {
		daka: function() {
			addEditor(g, '<blockquote>签到成功！签到时间：' + mytime, '，每日打卡，生活更精彩哦~</blockquote>')
			$('.comment-editor').hide();
		},
		good: function() {
			addEditor(g, '<blockquote> :grin:  :grin: 好羞射，文章真的好赞啊，顶博主！', '</blockquote>')
			$('.comment-editor').hide();
		},
		bad: function() {
			addEditor(g, '<blockquote> :twisted:  :twisted: 有点看不懂哦，希望下次写的简单易懂一点！', '</blockquote>')
			$('.comment-editor').hide();
		},
		pre: function() {
			addEditor(g, '<pre class="prettyprint">', '</pre>')
		}
	};
	window['SIMPALED'] = {};
	window['SIMPALED']['Editor'] = h
	

});
