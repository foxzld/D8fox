<!-- post loop -->
<div class="box clearfix <?php if ( classic_should_show_thumbnail() ) { echo 'show-thumbnails'; } ?>">
	<?php if ( classic_should_show_thumbnail() && wptouch_has_post_thumbnail() ) { ?>
		<img src="<?php wptouch_the_post_thumbnail( 'thumbnail' ); ?>" alt="thumbnail" class="post-thumbnail wp-post-image" />
	<?php } elseif ( classic_should_show_thumbnail() && !wptouch_has_post_thumbnail() ) { ?> 
		<span class="placeholder"><!-- styled in css --></span>
	<?php } ?>
	<div class="text-expand icon-chevron-down"></div>

	<h2 class="post-title heading-font">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>

	<div class="post-meta clearfix">
		<div class="time-author">
			<?php if ( classic_should_show_date() ) { ?>
				<i class="icon-time"></i> <?php wptouch_the_time(); ?> 
			<?php } ?>
			<?php if ( classic_should_show_author() ) { ?>
				<div class="author">
					<?php if ( !classic_should_show_date() ) { ?>
						<i class="icon-user"></i>
					<?php } ?>
					<em><?php _e( 'by', 'wptouch-pro' ); ?></em> <?php the_author(); ?>
				</div>
			<?php } ?>
		</div>
		
		<?php if ( wptouch_get_comment_count() > 0 && comments_open() ) { ?>
			<div class="comments">
				<i class="icon-comment"></i>
				<a href="<?php the_permalink(); ?>#comments">
					<?php comments_number( __( 'no responses', 'wptouch-pro' ), __( '1 response', 'wptouch-pro' ), __( '% responses', 'wptouch-pro' ) ); ?>
				</a>
			</div>
		<?php } ?>

		<?php if ( classic_should_show_taxonomy() ) { ?>
			<?php if ( wptouch_has_categories() ) { ?>
				<div class="cat-tags"><i class="icon-th"></i> <?php wptouch_the_categories(); ?></div>
			<?php } ?>
		
			<?php if ( wptouch_has_tags() ) { ?>
				<div class="cat-tags"><i class="icon-tags"></i> <?php wptouch_the_tags(); ?></div>
			<?php } ?>
		<?php } ?>
	</div>

	<div class="post-content" style="display: none;">
		<?php wptouch_the_excerpt(); ?>
		<a class="read-more" href="<?php the_permalink(); ?>">
			<?php if ( wptouch_should_load_rtl() ) { ?>
				<i class="icon-chevron-left"></i>
			<?php } ?>
			
			<?php _e( 'Read This Post', 'wptouch-pro' ); ?>
			
			<?php if ( !wptouch_should_load_rtl() ) { ?>
				<i class="icon-chevron-right"></i>
			<?php } ?>
		</a>
	</div>
</div>