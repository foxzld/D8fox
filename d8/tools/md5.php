

<script language="JavaScript">
function CalcuMD5()
{   
  var oText = document.getElementById("oText");
  jsMD5_Typ = 'Typ16';
  var aCode = MD5(oText);
  document.aCode.value = aCode;
  document.aCod2.value = aCode.toLowerCase();
  jsMD5_Typ = 'Typ32';
  var bCode = MD5(oText);
  document.bCode.value = bCode;
  document.bCod2.value = bCode.toLowerCase();
                        
}
</script>
<h2 class="sitetip">请输入要加密的字符串:</h2>

<textarea onmouseover="this.focus();this.select();" class="tarea" name="oText" id="oText"></textarea>

<div class="subbtn">

	<input type="button" onClick="CalcuMD5()" value="开始转换" class="btn btn-primary">
    
</div>

<h2 class="sitetip">相应的HTML代码: 16位</h2>

<input name="aCode" type="text" id="aCode"  size="70"></input>
<script language="JavaScript" src="<?php bloginfo('template_url') ?>/tools/jsMD5.js"></script>
