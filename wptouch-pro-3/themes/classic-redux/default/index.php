<?php get_header(); ?>

<div id="content">

	<?php if ( is_archive() ) { ?>
		<h2 class="heading-font archive-title"><?php wptouch_fdn_archive_title_text(); ?></h2>
	<?php } ?>

	<?php while ( wptouch_have_posts() ) { ?>
		<?php wptouch_the_post(); ?>
		<div class="<?php wptouch_post_classes(); ?>">
			<?php locate_template( 'post-loop.php', true, false ); ?>
		</div> <!-- post classes -->
	<?php } ?>

	<?php if ( foundation_is_theme_using_module( 'infinite-scroll' ) ) { ?>		

		<?php if ( get_next_posts_link() ) { ?>
			<a class="infinite-link" href="#" rel="<?php echo get_next_posts_page_link(); ?>"><!-- hidden in css --></a>
		<?php } ?>

	<?php } elseif ( foundation_is_theme_using_module( 'load-more' ) ) { ?>

		<!-- show the load more if we have more posts/pages -->
		<?php if ( get_next_posts_link() ) { ?>
			<a class="load-more-link no-ajax" href="javascript:return false;" rel="<?php echo get_next_posts_page_link(); ?>">
				<?php wptouch_fdn_archive_load_more_text(); ?>&hellip;
			</a>
		<?php } ?>

	<?php } else { ?>

		<div class="posts-nav">
			<?php posts_nav_link( ' | ', '&lsaquo; ' . __( 'newer posts', 'wptouch-pro' ), __( 'older posts', 'wptouch-pro' ) . ' &rsaquo;' ); ?>
		</div>

	<?php } ?>

</div> <!-- content -->

<?php get_footer(); ?>