</section>
<footer class="footer">
    <div class="footer-inner">
        <div class="copyright pull-left">
            版权所有，保留一切权利！ &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>　Theme <a href="http://www.daqianduan.com/" target="_blank"><?php echo get_current_theme(); ?></a>  | <a href="http://www.miitbeian.gov.cn" target="_blank"><?php if( dopt('d_beian_b') ) echo dopt('d_beian'); ?></a>   <?php if( dopt('d_stp_b') ) echo ' | <a href="'.get_bloginfo('url').'/sitemap.xml" target="_blank">[Sitemap]</a>'; ?>  <?php if( dopt('d_stpx_b') ) echo ' | <a href="'.get_bloginfo('url').'/sitemap.html" target="_blank">[网站地图]</a>'; ?>
        </div>
        <div class="trackcode pull-right">
            <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
        </div>
    </div>
</footer>
<?php 
wp_footer(); 
global $dHasShare; 
if($dHasShare == true){ 
    echo '<script id="bdshare_js" data="type=tools&amp;uid='.(dopt('d_bdshare')?dopt('d_bdshare'):13688).'" ></script><script id="bdshell_js"></script><script>document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();</script>';
} 
if( dopt('d_footcode_b') ) echo dopt('d_footcode'); 
?>
<?php if( is_single() || is_page() && comments_open() ){ ?>
<script src="<?php bloginfo('template_directory'); ?>/js/comments.js"></script>
<?php }; ?>
</body>
</html>