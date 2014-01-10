<?php 
/*
 * Theme D4 => 酷站导航
 * template name: coolsite
*/
get_header();
?>
<script src="<? bloginfo('template_directory'); ?>/js/tool.js"></script>
<style type="text/css">
.clear{clear:both;height:1px;}
.sitecontent{margin-top:36px;border-radius:0 4px 4px 4px;background-color:#FFFFFF;box-shadow: 0 0 5px #CCCCCC;min-height:400px;position:relative;}
.main{margin: 20px;
min-height: 400px;
float: left;
width: 100%;} 
.tabnavbar{font-size: 14px;
left: -1px;
position: absolute;
top: -38px;}
.tabnavbar ul{display:block;}
.tabnavbar li{float:left}
.tabnavbar li a{background:#eee;background-image:-webkit-linear-gradient(#FAFAFA,#eee);background-image:-moz-linear-gradient(#FAFAFA,#eee);background-image:-o-linear-gradient(#FAFAFA,#eee);background-image:-ms-linear-gradient(#FAFAFA,#eee);background-image:linear-gradient(#FAFAFA,#eee);padding:0 20px;display:block;overflow:hidden;height:36px;line-height:36px;border-top-left-radius:4px;border-top-right-radius:4px;border:1px solid #DBDBDB;border-bottom:none;color:#555;margin-right:2px}
.tabnavbar li.on a,.tabnavbar li a:hover{background:#fff;padding:1px 20px 0}
.tabnavbar li.on a{font-weight:bold}
.tabnavbar span {position:absolute;cursor:pointer;right:-145px;top:5px;}
.get{padding:0 12px 0 0;height:28px;line-height:28px;border:#ccc 1px solid;box-shadow:0 0 3px #ddd;background:#ffffff;border-radius:4px}
.get em{display:inline-block;width:28px;height:28px;text-align:center;background-image:-webkit-linear-gradient(#FAFAFA,#eee);background-image:-moz-linear-gradient(#FAFAFA,#eee);background-image:-o-linear-gradient(#FAFAFA,#eee);background-image:-ms-linear-gradient(#FAFAFA,#eee);background-image:linear-gradient(#FAFAFA,#eee);border-top-left-radius:4px;border-bottom-left-radius:4px;border-right:#ccc 1px solid;margin-right:12px;font-style:normal;}
.abtn{margin-right:15px;border-radius:2px;color:#444;background:-webkit-linear-gradient(#fff,#f6f6f6);background:-moz-linear-gradient(#fff,#f6f6f6);background:linear-gradient(#fff,#f6f6f6);border:#C6C6C6 1px solid;overflow:hidden;}
.abtn:hover{color:#444;background:#f9f9f9;border-color:#bbb}
.abtn:active{box-shadow:inset 0 1px 2px #bbb}

.site-links{clear: both;
display: block;
margin: 0 40px 20px 0;
background: #FFF;}
.site-links ul.on{display:block}
.site-links ul{display:none;}
.site-links ul li {float:left;width:12.5%;}
.site-links ul li a{display:block;border:#DADADA 1px solid;padding:6px 5px;height:24px;overflow:hidden;border-radius:4px;line-height:24px;margin:0 -1px -1px 0;position:relative;z-index:4}
.site-links ul li a:hover{font-weight:bold;background-image:-webkit-linear-gradient(#FAFAFA,#eee);background-image:-moz-linear-gradient(#FAFAFA,#eee);background-image:-o-linear-gradient(#FAFAFA,#eee);background-image:-ms-linear-gradient(#FAFAFA,#eee);background-image:linear-gradient(#FAFAFA,#eee);border:#ccc 1px solid;position:relative;z-index:10;box-shadow:0 0 10px #ccc;left:-10px;margin-right:-20px;bottom:-5px;margin-top:-10px;height:34px;line-height:34px}
.site-links ul li img{top:4px;margin:0 10px 0 5px}

#siteform{background:#FEFEFE;border:1px solid #E4E4E4;border-radius:4px;display:none;position:absolute;z-index:15555;width:500px;height:360px;overflow:hidden;left:32%;top:5%; font-family:microsoft yahei, verdana, arial;}
#siteform h3{background:#fefefe;background:-webkit-linear-gradient(#fefefe,#f6f6f6);background:-moz-linear-gradient(#fefefe,#f6f6f6);background:linear-gradient(#fefefe,#f6f6f6); border-bottom:1px solid #E4E4E4;border-top-left-radius:4px;font-size:14px;height:30px;line-height:30px;margin-right:-2px;padding-left:15px;}
#siteform div{padding:10px;font-size:14px;}
#siteform p{line-height:0px;}
#siteform p label{display: inline;}
#siteform input,#siteform select,#siteform textarea{border:1px solid #999999;box-shadow:1px 2px 4px #CCCCCC;line-height:18px;font-size:14px;}
#siteform input{height:25px;width:200px;}
#siteform input.error{background:#F8DBDB;border-color:#E77776;}
#siteform select{height: 30px;
width: 110px;
padding: 2px;}
#siteform select option{line-height:25px;}
#siteform textarea{height:50px;width:470px;}
#siteform .btt{padding:5px;background:-moz-linear-gradient(-90deg,#FFFFFF,#DDDDDD) repeat scroll 0 0 transparent;border:1px solid #999999;border-radius:2px;width:100px;height:30px;}
#siteform .btt:hover,#siteform #close:hover{background:-moz-linear-gradient(-90deg,#FDF1D8,#F9D386) repeat scroll 0 0 transparent;}
#siteform #close{position:absolute;z-index:9;right:8px;margin-top:4px;border:1px solid #E4E4E4;border-radius:2px;background:-moz-linear-gradient(-90deg,#FFFFFF,#DDDDDD);padding:0 2px;cursor:pointer;}
#siteform #site_msg{box-shadow:1px 2px 4px #CCCCCC;border-radius:2px;width:300px;height:70px; background:#FFFFFF;}
#siteform #site_msg{position:absolute;z-index:16666;left:90px;top:100px;overflow:hidden;display:none;}
#siteform #site_msg p{line-height:20px;}
#siteform #site_msg .Y{color:#060;}
#siteform #site_msg .N{color:#F30;}
#siteform .error{border:1px solid #efefef;} 
#siteform span{font-size:12px;margin-left:10px;}
#siteform span.error {color:#E46C6E;border:none;}
#siteform em{font-family:Georgia,Tahoma,Arial;font-size:26px;position:relative;top:-5px;vertical-align:middle;}
#siteform #textinfo{float:right;}
</style>
<div class="sitecontent">
<div class="main">
	<div class="tabnavbar site-nav">
        <ul>
		<li class="on"><a href="javascript:;">热门站点</a></li>
        <li><a href="javascript:;">挖掘灵感</a></li>
        <li><a href="javascript:;">综合素材</a></li>
        <li><a href="javascript:;">资讯科技</a></li>
        <li><a href="javascript:;">国外酷站</a></li>
        <li><a href="javascript:;">前端开发</a></li>
        <li><a href="javascript:;">学习教程</a></li>
        <li><a href="javascript:;">UX团队</a></li>
		<li><a href="javascript:;">我喜欢！</a></li>
        <li><a href="javascript:;">左邻右舍</a></li>
        </ul>
        <span id="abtn" class="abtn get"><em>✚</em>申请加入</span>
   <div style="clear:both;"></div> 
   </div>
	<script type="text/javascript">
		/*jQuery(document).ready(function(){
			jQuery('#abtn').click(function(){
				jQuery('#siteform').fadeTo('slow',1);
			})	
		});*/
    </script>
    <div class="site-links">
        <ul class="on">
        <?php /*活跃站点 按当天来访时间排序*/
            $active = get_bookmarks(array('orderby' =>'link_updated','order' =>'DESC','limit' =>50, 'category' =>'560,559,555,561,558,557,556,563')); 
            if(!empty($active)){
                foreach($active as $v){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$v->link_url);?>" rel="nofollow"><?php echo $v->link_name;?></a></li>
        <?
                }	
            }
        ?>
        </ul>
        <ul>
        <?php
            $xx = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'560')); 
            if(!empty($xx)){
                foreach($xx as $x){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$x->link_url);?>"><?php echo $x->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $net = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'559')); 
            if(!empty($net)){
                foreach($net as $n){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$n->link_url);?>"><?php echo $n->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $em = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'555')); 
            if(!empty($em)){
                foreach($em as $e){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$e->link_url);?>"><?php echo $e->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $life = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'561')); 
            if(!empty($life)){
                foreach($life as $l){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$l->link_url);?>"><?php echo $l->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $edu = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'558')); 
            if(!empty($edu)){
                foreach($edu as $u){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$u->link_url);?>"><?php echo $u->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $blog = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'557')); 
            if(!empty($blog)){
                foreach($blog as $b){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$b->link_url);?>"><?php echo $b->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <ul>
        <?php
            $other = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'556')); 
            if(!empty($other)){
                foreach($other as $o){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$o->link_url);?>"><?php echo $o->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
		 <ul>
        <?php
            $other = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'563')); 
            if(!empty($other)){
                foreach($other as $o){
        ?>		
                    <li><a target="_blank" rel="nofollow" href="<?php bloginfo('url')?>/sitego?<?php echo $v->link_url?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$o->link_url);?>"><?php echo $o->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
		 <ul>
        <?php
            $other = get_bookmarks(array('orderby' =>'link_rating','order' =>'DESC','limit' =>50, 'category' =>'562')); 
            if(!empty($other)){
                foreach($other as $o){
        ?>		
                    <li><a target="_blank" href="http://<?php echo str_replace('http://','',$o->link_url);?>"><img src="http://www.google.com/s2/favicons?domain=<?php echo str_replace('http://','',$o->link_url);?>"><?php echo $o->link_name;?></a></li>
        <?
                }	
            }else{
                echo '<p style="5px;">暂无站点加入……如果你要显示在这里，请点击申请免费加入。</p>';	
            }
        ?>
        </ul>
        <div class="clear"></div>
    </div>

</div>
</div>
<?php echo @file_get_contents('<?php bloginfo('template_url'); ?>site/siteform.html','r');?>
<script language="javascript" src="<?php bloginfo('template_url'); ?>/site/siteform.js"></script>
<script language="javascript" src="<?php bloginfo('template_url'); ?>/site/dialog.js"></script>
<?php get_footer(); ?>