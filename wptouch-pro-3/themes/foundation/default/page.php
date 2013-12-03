<?php if ( foundation_is_theme_using_module( 'custom-latest-posts' ) && wptouch_fdn_is_custom_latest_posts_page() ) { ?>

	<?php wptouch_fdn_custom_latest_posts_query(); ?>
	<?php locate_template( 'index.php', true ); ?>

<?php } else { ?>

	<?php get_header(); ?>

	<div id="content">
		<?php if ( wptouch_have_posts() ) { ?>
			<?php wptouch_the_post(); ?>
			<?php locate_template( 'page-content.php', true ); ?>
		<?php } ?>
	</div> <!-- content -->

	<?php if ( wptouch_fdn_show_comments_on_pages() ) { ?>
		<div id="comments">
			<?php comments_template(); ?>
		</div>
	<?php } ?>

	<?php get_footer(); ?>

<?php } ?>