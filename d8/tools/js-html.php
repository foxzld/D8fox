<h2 class="sitetip">贴入要转换的Javascript代码:</h2>
<textarea onmouseover="this.focus();this.select();" class="tarea" id="oresult"></textarea>
<div class="subbtn">
	<input type="button" onclick="rechange();" value="开始转换" class="btn btn-primary">    <input type="button" onclick="Empty1();" value="清空&uarr;" class="btn btn-primary">	<input type="button" onclick="Empty2();" value="清空&darr;" class="btn btn-primary">
</div>
<h2 class="sitetip">相应的HTML代码: </h2>
<textarea onmouseover="this.focus();this.select();" class="tarea" id="re"></textarea>

<script type="text/javascript">
function rechange(){
	document.getElementById('re').value=document.getElementById('oresult').value.replace(/document.writeln\("/g,"").replace(/"\);/g,"").replace(/\\\"/g,"\"").replace(/\\\'/g,"\'").replace(/\\\//g,"\/").replace(/\\\\/g,"\\")
}function Empty1() {	document.getElementById('oresult').value = '';	document.getElementById('oresult').select()}function Empty2() {	document.getElementById('re').value = '';	document.getElementById('re').select()}
</script>
