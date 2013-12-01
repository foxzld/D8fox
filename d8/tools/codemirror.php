<h2 class="sitetip">贴入要高亮代码：<!--[if IE]>（本功能暂不支持IE浏览器）<![endif]--></h2>



<textarea class="tarea" id="code"><h2 class="demo">贴入要高亮代码：</h2></textarea>

<div class="subbtn">

	<input class="btn btn-primary" type="button" value="Html Mix" onclick="doHighlight('text/html');">

	<input class="btn btn-primary" type="button" value="CSS" onclick="doHighlight('text/css');">

	<input class="btn btn-primary" type="button" value="Javscript" onclick="doHighlight('text/javascript');">

	<input class="btn btn-primary" type="button" value="XML" onclick="doHighlight('application/xml');">

	<input class="btn btn-primary" type="button" value="PHP" onclick="doHighlight('application/x-httpd-php');">
    
	<input type="button" onclick="Empty();" value="清空" class="btn btn-primary">
</div>



<h2 class="sitetip">复制以下代码到编辑器（Html模式）：</h2>

<textarea class="tarea" id="getcode" style="height:100px"></textarea>



<h2 class="sitetip">高亮预览：</h2>

<pre id="output" class="cm-s-default"></pre>

<script type="text/javascript">
function Empty() {
	document.getElementById('code').value = '';
	document.getElementById('code').select()
}

</script>