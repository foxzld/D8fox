<?php include( 'nav-bar.php' ); ?>

<?php if ( classic_show_page_titles() ) { ?>
	<div id="title-area" class="box">
		<?php if ( classic_should_show_thumbnail() ) { ?>
			<?php if ( has_post_thumbnail() ) { ?>
			<div class="icon-area">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</div>	
			<?php } ?>
		<?php } ?>			
		<h2 class="post-title"><?php the_title(); ?></h2>
	</div>
<?php } ?>

<div id="content-area" class="<?php wptouch_post_classes(); ?> box">
	<?php the_content(); ?>
</div>		