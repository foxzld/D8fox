<?php get_header(); ?>

<div id="content">
	<?php if ( wptouch_have_posts() ) { ?>
		<?php wptouch_the_post(); ?>

		<?php // include( 'nav-bar.php' ); ?>

		<div id="title-area" class="box <?php if ( has_post_thumbnail() && classic_should_show_thumbnail() ) { echo 'show-thumbnails'; } ?>">
			<?php if ( classic_should_show_thumbnail() ) { ?>
			<div class="icon-area">
				<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large' ); ?>
			</div>	
			<?php } ?>			
			<h2 class="post-title"><?php the_title(); ?></h2>
			<div class="post-meta">
				<?php if ( classic_should_show_date() ) { ?>
					<div class="time"><i class="icon-time"></i> <?php echo sprintf( __( '%s at %s', 'wptouch-pro' ), get_the_date(), get_the_time() ); ?></div>
				<?php } if ( classic_should_show_author() ) { ?>
					<div class="author"><i class="icon-user"></i> <?php echo sprintf( __( 'Written by %s', 'wptouch-pro' ), get_the_author() ); ?></div>
				<?php } ?>
			</div>
		</div>

		<div id="content-area" class="<?php wptouch_post_classes(); ?> box">
			<?php wptouch_the_content(); ?>
		</div>

		<?php include( 'nav-bar.php' ); ?>

		<div id="comments">
			<?php comments_template(); ?>
			
		</div>

	<?php } ?>
</div>

<?php get_footer(); ?>