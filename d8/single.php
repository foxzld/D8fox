<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<div class="breadcrumbs"><?php echo deel_breadcrumbs() ?></div>
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<div class="meta">
				<?php  
					$category = get_the_category();
			        if($category[0]){
			            echo '<span class="muted"><a href="'.get_category_link($category[0]->term_id ).'"><i class="icon-list-alt icon12"></i> '.$category[0]->cat_name.'</a></span>';
			        }
				?>
				<span class="muted"><i class="icon-user icon12"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a></span>
				<time class="muted"><i class="ico icon-time icon12"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) )?></time>
				<span class="muted"><i class="ico icon-eye-open icon12"></i> <?php deel_views('浏览'); ?></span>
				<?php if ( comments_open() ) echo '<span class="muted"><i class="icon-comment icon12"></i> <a href="'.get_comments_link().'">'.get_comments_number('去', '1', '%').'评论</a></span>'; ?>
				<?php edit_post_link('[编辑]'); ?>
			</div>
		</header>

		<?php if( dopt('d_adpost_01_b') ) echo '<div class="banner banner-post">'.dopt('d_adpost_01').'</div>'; ?>
		
		<article class="article-content">
			<?php the_content(); ?>
		</article>

		<?php endwhile;  ?>

		<footer class="article-footer">
			<?php the_tags('<div class="article-tags">继续浏览有关 ','',' 的文章</div>'); ?>
			<?php deel_share(); ?>
		</footer>

		<nav class="article-nav">
			<span class="article-nav-prev"><?php previous_post_link('上一篇 %link'); ?></span>
			<span class="article-nav-next"><?php next_post_link('%link 下一篇'); ?></span>
		</nav>

		<div class="relates">
			<h3>与本文相关的文章</h3>
			<?php include( 'modules/related.php' ); ?>
		</div>

		<?php if( dopt('d_adpost_02_b') ) echo '<div class="banner banner-related">'.dopt('d_adpost_02').'</div>'; ?>

		<?php comments_template('', true); ?>

		<?php if( dopt('d_adpost_03_b') ) echo '<div class="banner banner-comment">'.dopt('d_adpost_03').'</div>'; ?>

	</div>
</div>
<?php get_sidebar(); get_footer(); ?>