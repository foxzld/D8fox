<style>
.itembox{ margin:10px auto;}
.mulu{ padding:5px; text-align:center;}
.robot{ padding:5px;}
.seo{ background:#BBD7E6;}
.add{ float:right; background:#D4E6F7; border:1px solid #BBD7E6; padding:0 5px; cursor:pointer;}
.addsite{ float:right; background:#D4E6F7; border:1px solid #BBD7E6; padding:0 5px; cursor:pointer;}
.xianzhi{ margin-left:190px;_margin-left:183px;}
td, input, textarea, select, button{ line-height:20px;}
.input{ width:240px;}
.titlealern{color:red;}
</style>

<h2 class="sitetip">robots.txt文件生成</h2>
<form id="form1" method="get" onsubmit="return onget('IP','address')">
<div class="box">
   <div id="b_1">
     <h3><div class="titlealern" align="center">由于该功能引入了通用jquery，如点击按钮无反应，无法生成robots.txt，请使用CTRL+F5刷新页面即可使用！</div></h3>
     <div class="box1">
      <div class="itembox">
      <div id="xianzhi">
      <div class="mulu"><span class="add">增加限制目录</span><span class="xianzhi">限制目录: <input type="text" class="input" value="/bin/" ref="xianzhi"><font color="red">    每个路径之前都要包含："/" </font></span></div>
      <div class="mulu"><input type="text" class="input" ref="xianzhi"></div>
      <div class="mulu"><input type="text" class="input" ref="xianzhi"></div>
      <div class="mulu"><input type="text" class="input" ref="xianzhi"></div>
      </div>
       <div id="sitemap">
       <div class="mulu"><span class="addsite">增加Sitemap</span><span style=" margin-left:151px;_margin-left:147px">Sitemap: (留空为无): <input type="text" class="input" ref="sitemap" value="http://domain.com/sitemap.xml"><font color="red">    谷歌为xml格式，百度为html格式  </font></span></div>
       </div>
                   <div class="mulu">检索间隔: <select size="1" name="delay" id="delay">
                        <option value="" selected="selected">不限</option>
                        <option value="5">5 Seconds</option>
                        <option value="10">10 Seconds</option>
                        <option value="20">20 Seconds</option>
                        <option value="60">60 seconds</option>
                        <option value="120">120 Seconds</option>
                    </select>
          </div>

      <div class="robot">
     <table width="100%" border="0" class="seo" cellspacing="1" cellpadding="5">
              <tbody><tr class="seo_item">
                  <td width="160" style=" font-weight:bold;">
                      默认-所有搜索引擎
                  </td>
                  <td colspan="4" align="center">
                      <select size="1" name="all" id="all">
                          <option value=" " selected="selected">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td style=" font-weight:bold;">
                      国内搜索引擎
                  </td>
                  <td align="left">
                      百度
                  </td>
                  <td align="center">
                      <select size="1" id="baidu">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      SOSO
                  </td>
                  <td align="center">
                     <select size="1" id="soso">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      搜狗
                  </td>
                  <td align="center">
                     <select size="1" id="sogou">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      有道
                  </td>
                  <td align="center">
                     <select size="1" id="youdao">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td style=" font-weight:bold;">
                      国外搜索引擎
                  </td>
                  <td align="left">
                      谷歌
                  </td>
                  <td align="center">
                     <select size="1" id="google">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Bing
                  </td>
                  <td align="center">
                     <select size="1" id="bing">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      雅虎
                  </td>
                  <td align="center">
                      <select size="1" id="yahoo">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Ask/Teoma
                  </td>
                  <td align="center">
                      <select size="1" id="ask">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      Alexa/Wayback
                  </td>
                  <td align="center">
                     <select size="1" id="alexa">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Cuil
                  </td>
                  <td align="center">
                     <select size="1" id="cuil">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      MSN Search
                  </td>
                  <td align="center">
                     <select size="1" id="msn">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Scrub The Web
                  </td>
                  <td align="center">
                     <select size="1" id="scrub">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      DMOZ
                  </td>
                  <td align="center">
                     <select size="1" id="dmoz">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      GigaBlast
                  </td>
                  <td align="center">
                      <select size="1" id="giga">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td style=" font-weight:bold;">
                      特殊搜索引擎(机器人)
                  </td>
                  <td align="left">
                      Google Image
                  </td>
                  <td align="center">
                     <select size="1" id="googleimage">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Google Mobile
                  </td>
                  <td align="center">
                     <select size="1" id="googlemobile">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      Yahoo MM
                  </td>
                  <td align="center">
                      <select size="1" id="yahoomm">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                      Yahoo Blogs
                  </td>
                  <td align="center">
                     <select size="1" id="yahooblogs">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
              </tr>
              <tr class="seo_item">
                  <td>
                      &nbsp;
                  </td>
                  <td align="left">
                      MSN PicSearch
                  </td>
                  <td align="center">
                      <select size="1" id="msnpic">
                          <option value="" selected="selected">默认</option>
                          <option value=" ">允许</option>
                          <option value=" /">拒绝</option>
                      </select>
                  </td>
                  <td align="left">
                       &nbsp;
                  </td>
                  <td align="center">
                      &nbsp;
                  </td>
              </tr>
          </tbody></table>

      </div>
      <div class="robot">
      <div style="text-align:center"><input type="button" value="生成" class="but" id="create">&nbsp;&nbsp;<input type="button" value="清空结果" class="but" id="clear"></div>
      <textarea align="center" class="HJtxt" style=" width:99%; height:400px;" rows="20" cols="20"># robots.txt generated at http://foxzld.com/
User-agent: *
Disallow:</textarea>
<div style=" text-align:center;">请将以上结果保存到记事本,命名为robots.txt上传到网站根目录</div>
</div>
      </div>
      </div>
   </div>
</div>

</form>