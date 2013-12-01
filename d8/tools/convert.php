<h2 class="sitetip">贴入要转换的专用链地址（支持迅雷、快车、旋风地址）:</h2>
<?php
if(isset($_POST['convert']))
{
	$url = $_POST['before'];
	$url = str_ireplace('thunder://','',$url);
	$url = str_ireplace('qqdl://','',$url);
	$url = str_ireplace('flashget://','',$url);
	$url = base64_decode($url);
	$url = str_ireplace('[FLASHGET]','',$url);
	if(preg_match('/AA(.*)ZZ/',$url,$result))
	{
		$result = $result[1];
	}
	else
	{
		$result = $url;
	}
}
?>
<textarea onmouseover="this.focus();this.select();" class="tarea" id="oresult"><?php if(isset($_POST['before'])){echo $_POST['before'];} ?></textarea>
<input type="text" name="before" id="before" value="<?php if(isset($_POST['before'])){echo $_POST['before'];} ?>"/>
<div class="subbtn">
    <input type="button" name="convert" id="convert" class="btn btn-primary" value="立即转换" />
    <input type="button" name="reset" onclick="Empty();" id="reset" class="btn btn-primary" value="清空" />	
</div>

<h2 class="sitetip">相应的HTML代码: </h2>

<textarea onmouseover="this.focus();this.select();" class="tarea" ><?php if(isset($result)){echo $result;} ?></textarea>

<input name="after" type="text" id="after" readonly="readonly" value="<?php if(isset($result)){echo $result;} ?>"/>

<script type="text/javascript">

function Empty() {
	document.getElementById('oresult').value = '';
	document.getElementById('oresult').select()
}


</script>

