<h2 class="sitetip">贴入要格式化或压缩的CSS代码：</h2>
<textarea onmouseover="this.focus();this.select();" id="code" class="tarea"></textarea>
<div class="subbtn">
	<input type="button" onclick="CSS('packAdv');" value="高级压缩" class="btn btn-primary">
	<input type="button" onclick="CSS('pack');" value="普通压缩" class="btn btn-primary">
	<input type="button" onclick="CSS('format');" value="格式化" class="btn btn-primary">    	<input type="button" onclick="Empty1();" value="清空&uarr;" class="btn btn-primary">		<input type="button" onclick="Empty2();" value="清空&darr;" class="btn btn-primary">
</div>
<h2 class="sitetip">转换后的CSS代码：</h2>
<textarea onmouseover="this.focus();this.select();" id="packer" class="tarea"></textarea>
<script type="text/javascript">  function Empty1() {	document.getElementById('code').value = '';	document.getElementById('code').select()}function Empty2() {	document.getElementById('packer').value = '';	document.getElementById('packer').select()}
var CSSPacker = {
	format: function (s) {//鏍煎紡鍖栦唬鐮�
		s = s.replace(/\s*([\{\}\:\;\,])\s*/g, "$1");
		s = s.replace(/;\s*;/g, ";"); 
		s = s.replace(/\,[\s\.\#\d]*{/g, "{");
		s = s.replace(/([^\s])\{([^\s])/g, "$1 {\n\t$2");
		s = s.replace(/([^\s])\}([^\n]*)/g, "$1\n}\n$2");
		s = s.replace(/([^\s]);([^\s\}])/g, "$1;\n\t$2");
		return s;
	},
	pack: function (s) {//楂樼骇
		s = s.replace(/\/\*(.|\n)*?\*\//g, ""); 
		s = s.replace(/\s*([\{\}\:\;\,])\s*/g, "$1");
		s = s.replace(/\,[\s\.\#\d]*\{/g, "{"); 
		s = s.replace(/;\s*;/g, ";");
		s = s.replace(/;\s*}/g, "}"); 
		s = s.match(/^\s*(\S+(\s+\S+)*)\s*$/);
		return (s == null) ? "" : s[1];
	},
	packNor: function (s) {//鏅€�
		s = s.replace(/\/\*(.|\n)*?\*\//g, ""); 
		s = s.replace(/\s*([\{\}\:\;\,])\s*/g, "$1");
		s = s.replace(/\,[\s\.\#\d]*\{/g, "{");
		s = s.replace(/;\s*;/g, ";"); 
		s = s.replace(/;\s*}/g, "}"); 
		s = s.replace(/([^\s])\{([^\s])/g, "$1{$2");
		s = s.replace(/([^\s])\}([^\n]s*)/g, "$1}\n$2");
		return s;
	}
}

jQuery.noConflict();
jQuery(document).ready(function($) {
    $('.subbtn .btn').each(function(i){
	    $(this).click(function(){
	    	if($('#btn-resort').is(':checked')){
		    	var order = '',
			        code = $('#code').val();

			    if (!code) code = ' ';

			    $.post(themeUrl+'tpl/tools/csscomb/gate.php',{
		            code  : code, order : order
		        },function (data) {
		            $('#packer').val(data);
		            if(i==0) CSS1('pack');
		            if(i==1) CSS1('packNor');
		            if(i==2) CSS1('format');
		        },'text');
	    	}else{
	    		if(i==0) CSS2('pack');
	            if(i==1) CSS2('packNor');
	            if(i==2) CSS2('format');
	    	}
	    })
    })

    function CSS1(s) {
		$('#packer').val( CSSPacker[s]($('#packer').val()) );
	}
	function CSS2(s) {
		$('#packer').val( CSSPacker[s]($('#code').val()) );
	}
});
</script>
