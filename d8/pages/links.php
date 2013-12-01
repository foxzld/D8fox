<?php 
/*
	template name: 友情链接
	description: template for daqianduan.com d8 theme 
*/
get_header();
?>
<div class="pagewrapper clearfix">
	<aside class="pagesidebar">
		<ul class="pagesider-menu">
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'pagemenu', 'echo' => false)) )); ?>
		</ul>
	</aside>
	<div class="pagecontent">
		<header class="pageheader clearfix">
			<h1 class="pull-left">
				<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</h1>
			<div class="pull-right">
				<?php deel_share() ?>
			</div>
		</header>
		<?php while (have_posts()) : the_post(); ?>
			<article class="article-content">
				<?php the_content(); ?>
			</article>

			<ul class="plinks">
				<?php wp_list_bookmarks(array(
					'category' => dopt('d_linkpage_cat')?dopt('d_linkpage_cat'):''
				)); ?>
			</ul>

			<?php comments_template('', true); ?>

		<?php endwhile;  ?>
	</div>
</div>
<?php get_footer(); ?>