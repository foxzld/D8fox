<?php

$dname = 'D8';

add_action( 'after_setup_theme', 'deel_setup' );

include('admin/d8.php');
include('widgets/index.php');

function deel_setup(){
  
	//去除头部冗余代码
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 

	//隐藏admin Bar
	add_filter('show_admin_bar','hide_admin_bar');

	//关键字
	add_action('wp_head','deel_keywords');   

	//页面描述 
	add_action('wp_head','deel_description');   

	//阻止站内PingBack
	if( dopt('d_pingback_b') ){
		add_action('pre_ping','deel_noself_ping');   
	}   

	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 

	//自动勾选评论回复邮件通知，不勾选则注释掉 
	// add_action('comment_form','deel_add_checkbox');

	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('smilies_src','deel_smilies_src',1,10); 

	//文章末尾增加版权
	add_filter('the_content','deel_copyright');    

	//移除自动保存和修订版本
	if( dopt('d_autosave_b') ){
		add_action('wp_print_scripts','deel_disable_autosave' );
		remove_action('pre_post_update','wp_save_post_revision' );
	}

	//去除自带js
	wp_deregister_script( 'l10n' ); 

	//修改默认发信地址
	add_filter('wp_mail_from', 'deel_res_from_email');
	add_filter('wp_mail_from_name', 'deel_res_from_name');

	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(220, 150, true); 

	add_editor_style('editor-style.css');

	//头像缓存  
	if( dopt('d_avatar_b') ){
		add_filter('get_avatar','deel_avatar');  
	}

	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('页面导航')
		));
	}

}

if (function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget_tit">',
		'after_title'   => '</h3>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget_tit">',
		'after_title'   => '</h3>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget_tit">',
		'after_title'   => '</h3>'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget_tit">',
		'after_title'   => '</h3>'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget_tit">',
		'after_title'   => '</h3>'
	));
}


function deel_breadcrumbs(){
    if( !is_single() ) return false;
    $categorys = get_the_category();
    $category = $categorys[0];
    
    return '你的位置：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> <small>></small> '.get_category_parents($category->term_id, true, ' <small>></small> ').'<span class="muted">'.get_the_title().'</span>';
}

// 取消原有jQuery
function footerScript() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', false, '2.2', dopt('d_jquerybom_b') ? true : false );   
        wp_enqueue_script( 'jquery' );   
    }  
}  
add_action( 'init', 'footerScript' );


if ( ! function_exists( 'deel_paging' ) ) :
function deel_paging() {
    $p = 4;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';

    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    // echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}
function p_link( $i, $title = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
endif;

function deel_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}

function dopt($e){
		return stripslashes(get_option($e));
	}

if ( ! function_exists( 'deel_views' ) ) :
function deel_record_visitors(){
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'deel_record_visitors');  

function deel_views($after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  echo $views, $after;
}
endif;

if ( ! function_exists( 'deel_thumbnail' ) ) :
function deel_thumbnail() {  
	global $post;  
	if ( has_post_thumbnail() ) {   
		$domsxe = simplexml_load_string(get_the_post_thumbnail());
		$thumbnailsrc = $domsxe->attributes()->src;  
		echo '<img src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
	} else {
		$content = $post->post_content;  
		preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
		$n = count($strResult[1]);  
		if($n > 0){
			echo '<img src="'.$strResult[1][0].'" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}else {
			echo '<img src="'.get_bloginfo('template_url').'/img/thumbnail.png" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}  
	}  
}
endif;


/*function custom_login() {   
	echo '<link rel="stylesheet" href="' . get_bloginfo('template_directory') . '/misc/login.css">'; 
}
add_action('login_head', 'custom_login');   */


$dHasShare = false;
function deel_share(){
  echo '<div class="share"><div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"><span class="share-tit">分享此文到：</span><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_tsina"></a><a class="bds_renren"></a><a class="bds_kaixin001"></a><a class="bds_tqf"></a><a class="bds_sqq sqq"></a><a class="bds_mshare mshare"></a><span class="bds_more">更多</span><a class="shareCount"></a></div></div>';
  global $dHasShare;
  $dHasShare = true;
}

function deel_avatar_default(){ 
  return get_bloginfo('template_directory').'/img/default.png';
}

//评论头像缓存
function deel_avatar($avatar) {
  $tmp = strpos($avatar, 'http');
  $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
  $tmp = strpos($g, 'avatar/') + 7;
  $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
  $w = get_bloginfo('wpurl');
  $e = ABSPATH .'avatar/'. $f .'.png';
  $t = dopt('d_avatarDate')*24*60*60; 
  if ( !is_file($e) || (time() - filemtime($e)) > $t ) 
	copy(htmlspecialchars_decode($g), $e);
  else  
	$avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.png'));
  if ( filesize($e) < 500 ) 
	copy(get_bloginfo('template_directory').'/img/default.png', $e);
  return $avatar;
}




//关键字
function deel_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
	if ( get_the_tags( $post->ID ) ) {
	  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
	}
	foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	$keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = dopt('d_keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
	echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}

//网站描述
function deel_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
	if( !empty( $post->post_excerpt ) ) {
	  $text = $post->post_excerpt;
	} else {
	  $text = $post->post_content;
	}
	$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
	if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = dopt('d_description'); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' );
  echo "<meta name=\"description\" content=\"$description\">\n";
}

function hide_admin_bar($flag) {
	return false;
}

//最新发布加new 单位'小时'
function deel_post_new($timer='48'){
  $t=( strtotime( date("Y-m-d H:i:s") )-strtotime( $post->post_date ) )/3600; 
  if( $t < $timer ) echo "<i>new</i>";
}

//修改评论表情调用路径
function deel_smilies_src ($img_src, $img, $siteurl){
	return get_bloginfo('template_directory').'/img/smilies/'.$img;
}


//阻止站内文章Pingback 
function deel_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}


//移除自动保存
function deel_disable_autosave() {
  wp_deregister_script('autosave');
}


//修改默认发信地址
function deel_res_from_email($email) {
	$wp_from_email = get_option('admin_email');
	return $wp_from_email;
}
function deel_res_from_name($email){
	$wp_from_name = get_option('blogname');
	return $wp_from_name;
}


//评论回应邮件通知
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
	$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
	$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
	$to = trim(get_comment($parent_id)->comment_author_email);
	$subject = 'Hi，您在 [' . get_option("blogname") . '] 的留言有人回复啦！';
	$message = '
	<div style="color:#333;font:100 14px/24px microsoft yahei;">
	  <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
	  <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
	   . trim(get_comment($parent_id)->comment_content) . '</p>
	  <p>' . trim($comment->comment_author) . ' 给您的回应:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
	   . trim($comment->comment_content) . '<br /></p>
	  <p>点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回应完整內容</a></p>
	  <p>欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
	  <p style="color:#999">(此邮件由系统自动发出，请勿回复.)</p>
	</div>';
	$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
	//echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}

//自动勾选 
function deel_add_checkbox() {
  echo '<label for="comment_mail_notify" class="checkbox inline" style="padding-top:0"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}

//文章（包括feed）末尾加版权说明
function deel_copyright($content) {
	if( !is_page() ){
		$content.= '<p>转载请注明：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> &raquo; <a href="'.get_permalink().'">'.get_the_title().'</a></p>';
	}
	return $content;
}

//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}


function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}


//评论样式
function deel_comment_list($comment, $args, $depth) {
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //头像
 echo '<div class="c-avatar">';
  echo get_avatar( $comment->comment_author_email, $size = '36' ,$default = get_bloginfo('template_directory') . '/img/default.png'); 
  echo '</div>';
  //内容
  echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
	echo str_replace(' src=', ' data-original=', convert_smilies(get_comment_text()));
	if ($comment->comment_approved == '0'){
	  echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
	}
	//信息
	echo '<div class="c-meta">';
		echo '<span class="c-author">'.get_comment_author_link().'</span>';
		echo get_comment_time('Y-m-d H:i '); echo time_ago(); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
		echo edit_comment_link(__('(编辑)'),' - ','');
	  } 
	echo '</div>';
  echo '</div>';
}

/**
 * WordPress 自动为文章添加已使用过的标签
 * http://www.wpdaxue.com/auto-add-tags.html
 */
add_action('save_post', 'auto_add_tags');
function auto_add_tags(){
	$tags = get_tags( array('hide_empty' => false) );
	$post_id = get_the_ID();
	$post_content = get_post($post_id)->post_content;
	if ($tags) {
		foreach ( $tags as $tag ) {
			// 如果文章内容出现了已使用过的标签，自动添加这些标签
			if ( strpos($post_content, $tag->name) !== false)
				wp_set_post_tags( $post_id, $tag->name, true );
		}
	}
}
//增强默认编辑器
function Bing_editor_buttons($buttons){
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'backcolor';
	$buttons[] = 'underline';
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'cut';
	$buttons[] = 'copy';
	$buttons[] = 'paste';
	$buttons[] = 'cleanup';
	$buttons[] = 'wp_page';
	$buttons[] = 'newdocument';
	return $buttons;
}
add_filter("mce_buttons_3", "Bing_editor_buttons");
/**
 * WordPress 后台回复评论添加提交快捷键[Ctrl+Enter]
 * http://www.wpdaxue.com/admin-comment-ctrl-enter-reply.html
 */
function Bing_admin_comment_ctrlenter(){
	echo '<script type="text/javascript">
		jQuery(document).ready(function($){
			$("textarea").keypress(function(e){
				if(e.ctrlKey&&e.which==13||e.which==10){
					$("#replybtn").click();
				}
			});
		});
	</script>';
};
add_action('admin_footer', 'Bing_admin_comment_ctrlenter');


add_action( 'admin_print_footer_scripts', 'shortcode_buttons', 100 );
function shortcode_buttons() {
?>
	<script type="text/javascript">	 
	   QTags.addButton( 'm', 'D8代码', '[d8code]这里输入内容[/d8code]'); 
	   QTags.addButton( 'm0', 'D8图片框架', '[d8img]这里插图<div class="wp-caption-text">这里文字</div>[/d8img]'); 
	  
       QTags.addButton( 'm2', '下载面板', '[down]这里输入内容[/down]'); 
       QTags.addButton( 'm3', '警告面板', '[warn]这里输入内容[/warn]');	   
	   QTags.addButton( 'm4', '介绍面板', '[instruct]这里输入内容[/instruct]');
	   QTags.addButton( 'm5', '文字面板', '[text]这里输入内容[/text]');
	   QTags.addButton( 'm6', '问题面板', '[question]这里输入内容[/question]');
	   QTags.addButton( 'm7', '教程面板', '[course]这里输入内容[/course]');
	   QTags.addButton( 'm8', '禁止面板', '[noway]这里输入内容[/noway]');
	   QTags.addButton( 'm9', '项目面板', '[task]这里输入内容[/task]');
	   QTags.addButton( 'm10', '链接面板', '[link]这里输入内容[/link]');
	   QTags.addButton( 'm11', '代码面板', '[codee]这里输入内容[/codee]');
       	 
	</script>
<?php }

///////////////////////////短代码///////////////////////////
				//////////////下载/////////////
				function downbox($atts, $content=null, $code="") {
					$return = '<div class="down box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('down' , 'downbox' );
				//////////////警告/////////////
				function warnbox($atts, $content=null, $code="") {
					$return = '<div class="warn box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('warn' , 'warnbox' );
				//////////////介绍/////////////
				function instructbox($atts, $content=null, $code="") {
					$return = '<div class="instruct box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('instruct' , 'instructbox' );
				//////////////文本/////////////
				function textbox($atts, $content=null, $code="") {
					$return = '<div class="texts box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('text' , 'textbox' );
				//////////////问题/////////////
				function questionbox($atts, $content=null, $code="") {
					$return = '<div class="question box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('question' , 'questionbox' );
				//////////////教程/////////////
				function coursebox($atts, $content=null, $code="") {
					$return = '<div class="course box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('course' , 'coursebox' );
				//////////////禁止/////////////
				function nowaybox($atts, $content=null, $code="") {
					$return = '<div class="noway box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('noway' , 'nowaybox' );
				//////////////项目/////////////
				function taskbox($atts, $content=null, $code="") {
					$return = '<div class="task box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('task' , 'taskbox' );
				//////////////链接/////////////
				function linkbox($atts, $content=null, $code="") {
					$return = '<div class="link box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('link' , 'linkbox' );
				//////////////代码/////////////
				function codeebox($atts, $content=null, $code="") {
					$return = '<div class="codee box-content">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('codee' , 'codeebox' );
				//////////////D8代码/////////////
				function d8codebox($atts, $content=null, $code="") {
					$return = '<pre class="prettyprint linenums">';
					$return .= $content;
					$return .= '</pre>';
					return $return;
				}
				add_shortcode('d8code' , 'd8codebox' );
				//////////////D8图片框架/////////////
				function d8imgbox($atts, $content=null, $code="") {
					$return = '<div class="wp-caption aligncenter">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
				add_shortcode('d8img' , 'd8imgbox' );
							
?>