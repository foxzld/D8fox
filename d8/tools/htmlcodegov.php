<h2 class="sitetip">贴入要转换的HTML代码：</h2>
<textarea onmouseover="this.focus();this.select();" class="tarea" id="content"></textarea>
<div class="subbtn">
	<input type="button" onclick="javascript();" value="转为Javascript" class="btn btn-primary">
	<input type="button" onclick="php();" value="转为PHP" class="btn btn-primary">
	<input type="button" onclick="jsp();" value="转为JSP" class="btn btn-primary">
	<input type="button" onclick="asp();" value="转为ASP" class="btn btn-primary">
	<input type="button" onclick="perl();" value="转为Perl" class="btn btn-primary">
	<input type="button" onclick="sws();" value="转为Sws" class="btn btn-primary">
	<input type="button" onclick="vbnet();" value="转为Vb.net" class="btn btn-primary">    <input type="button" onclick="Empty1();" value="清空&uarr;" class="btn btn-primary">	<input type="button" onclick="Empty2();" value="清空&darr;" class="btn btn-primary">
</div>
<h2 class="sitetip">转换结果：</h2>
<textarea onmouseover="this.focus();this.select();" class="tarea" id="result"></textarea>
<div class="subbtn">
<!--    <input type="button" onclick="htmlCov();" value="开始转换" id="conv" class="sbtn">-->
    <input type="button" onclick="copy('result')" value="复制" id="copy" class="btn btn-primary">
    <input type="button" onclick="remove();" value="清空结果" id="remove" class="btn btn-primary">
    <input type="button" onclick="saveCode();" value="保存为文件" id="save" class="btn btn-primary">
</div>
<script type="text/javascript">function Empty1() {	document.getElementById('content').value = '';	document.getElementById('content').select()}function Empty2() {	document.getElementById('result').value = '';	document.getElementById('result').select()}
//html浠ｇ爜杞崲javascript浠ｇ爜
function javascript(){
	document.getElementById('result').value="document.writeln(\""+document.getElementById('content').value.replace(/\\/g,"\\\\").replace(/\\/g,"\\/").replace(/\'/g,"\\\'").replace(/\"/g,"\\\"").split('\n').join("\");\ndocument.writeln(\"")+"\");"
}

function asp(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	   document.getElementById("result").value="<%\n%>";
	}
	else 
	{
	    output = "Response.Write \"";
	    for (var c = 0; c < input.length; c++){
		    if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			    output += "\"";
			    if (c != input.length - 1) output +="\nResponse.Write \"";
			    c++;
			    }
		    else {
			    if (input.charAt(c) == "\"") {
				    output += "\"\"";
				    }
			    else {
				    if (input.charAt(c) == "\\"){
					    output += "\\\\";
					    }
				    else {
					    output += input.charAt(c);
					    if (c == input.length -1) output += "\"";	
					    }
				    }
			    }
    		
		    }
        document.getElementById("result").value="<\%\n"+output+"\n%>";
    }
}
//html浠ｇ爜杞崲php浠ｇ爜
function php(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	    document.getElementById("result").value="<\?php\n?>";
	}
	else 
	{
	    output = "echo \"";
	    for (var c = 0; c < input.length; c++){
		    if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			    output += "\\n\";";
			    if (c != input.length - 1) output +="\necho \"";
			    c++;
			    }
		    else {
			    if (input.charAt(c) == "\"") {
				    output += "\\\"";
				    }
			    else {
				    if (input.charAt(c) == "\\"){
					    output += "\\\\";
					    }
				    else {
					    output += input.charAt(c);
					    if (c == input.length -1) output += "\\n\";";	
					    }
				    }
			    }
    		
		    }
           document.getElementById("result").value="<\?php\n"+output+"\n?>";
       }
}
//html浠ｇ爜杞崲Jsp浠ｇ爜
function jsp(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	    document.getElementById("result").value="<%\n%>";
	}
	else 
	{
	    output = "out.println(\"";
	    for (var c = 0; c < input.length; c++){
		    if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			    output += "\");";
			    if (c != input.length - 1) output +="\nout.println(\"";
			    c++;
			    }
		    else {
			    if (input.charAt(c) == "\"") {
				    output += "\\\"";
				    }
			    else {
				    if (input.charAt(c) == "\\"){
					    output += "\\\\";
					    }
				    else {
					    output += input.charAt(c);
					    if (c == input.length -1) output += "\");";	
					    }
				    }
			    }
    		
		    }
           document.getElementById("result").value="<\%\n"+output+"\n%>";
       }
}
//html浠ｇ爜杞崲Perl浠ｇ爜
function perl(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	      document.getElementById("result").value=output;
	}
	else 
	{
	    output = "print \"";
    	for (var c = 0; c < input.length; c++){
		if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			output += "\\n\";";
			if (c != input.length - 1) output +="\nprint \"";
			c++;
			}
		else {
			if (input.charAt(c) == "\"") {
				output += "\\\"";
				}
			else {
				if (input.charAt(c) == "\\"){
					output += "\\\\";
					}
				else {
					output += input.charAt(c);
					if (c == input.length -1) output += "\\n\";";	
					}
				}
			}
		
		}
       document.getElementById("result").value=output;
	}
}
//html浠ｇ爜杞崲vbnet浠ｇ爜
function vbnet(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	     document.getElementById("result").value="<%\n%>";
	}
	else 
	{
	    output = "Response.Write (\"";
	    for (var c = 0; c < input.length; c++){
		if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			output += "\");";
			if (c != input.length - 1) output +="\nResponse.Write (\"";
			c++;
			}
		else {
			if (input.charAt(c) == "\"") {
				output += "\"\"";
				}
			else {
				if (input.charAt(c) == "\\"){
					output += "\\\\";
					}
				else {
					output += input.charAt(c);
					if (c == input.length -1) output += "\");";	
					}
				}
			}
		
		}
       document.getElementById("result").value="<\%\n"+output+"\n%>";
	}
}
//html浠ｇ爜杞崲Sws浠ｇ爜
function sws(){
	var input = document.getElementById("content").value;
	if(input=="")
	{
	    document.getElementById("result").value=output;
	}
	else 
	{
	    output = "STRING \"";
    	for (var c = 0; c < input.length; c++){
		if ((input.charAt(c) == "\n" || input.charAt(c) == "\r")){
			output += "\"";
			if (c != input.length - 1) output +="\nSTRING \"";
			c++;
			}
		else {
			if (input.charAt(c) == "\"") {
				output += "\\\"";
				}
			else {
				if (input.charAt(c) == "\\"){
					output += "\\\\";
					}
				else {
					output += input.charAt(c);
					if (c == input.length -1) output += "\"";	
					}
				}
			}
		
		}
       document.getElementById("result").value=output;
	}
}
</script>