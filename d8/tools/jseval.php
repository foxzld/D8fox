
<h2 class="sitetip">贴入Javascript/HTML代码：</h2>

<textarea onmouseover="this.focus();this.select();" style="height:450px;" id="code" name="content" class="tarea"></textarea>

<div class="subbtn">


<input type="button" onclick="decode()" value="解码" class="btn btn-primary"> 
<input type="button" onclick="Empty();" value="清空" class="btn btn-primary"> 
</div>
<script type="text/javascript">
a=62; 
function encode() { 
 var code = document.getElementById('code').value; 
 code = code.replace(/[\r\n]+/g, ''); 
 code = code.replace(/'/g, "\\'"); 
 var tmp = code.match(/\b(\w+)\b/g); 
 tmp.sort(); 
 var dict = []; 
 var i, t = ''; 
 for(var i=0; i<tmp.length; i++) { 
   if(tmp[i] != t) dict.push(t = tmp[i]); 
 } 
 var len = dict.length; 
 var ch; 
 for(i=0; i<len; i++) { 
   ch = num(i); 
   code = code.replace(new RegExp('\\b'+dict[i]+'\\b','g'), ch); 
   if(ch == dict[i]) dict[i] = ''; 
 } 
 document.getElementById('code').value = "eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\\\b'+e(c)+'\\\\b','g'),k[c]);return p}(" 
   + "'"+code+"',"+a+","+len+",'"+ dict.join('|')+"'.split('|'),0,{}))"; 
} 

function num(c) { 
 return(c<a?'':num(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36)); 
} 

function run() { 
 eval(document.getElementById('code').value); 
} 

function decode() { 
 var code = document.getElementById('code').value; 
 code = code.replace(/^eval/, ''); 
 document.getElementById('code').value = eval(code); 
} 
function Empty() {
	document.getElementById('code').value = '';
	document.getElementById('code').select()
}
</script> 
 
