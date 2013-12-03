<div class="entry">
	<?php if ( wptouch_has_post_thumbnail() ) { ?>
		<img src="<?php wptouch_the_post_thumbnail( 'thumbnail' ); ?>" alt="thumbnail" class="post-thumbnail wp-post-image" />
	<?php } else { ?> 
		<span class="placeholder">
			<!-- styled in css -->
			<?php if ( foundation_is_theme_using_module( 'font-awesome' ) ) { ?>
				<i class="icon-camera-retro"></i>
			<?php } ?>
		</span>
	<?php } ?>
	 
	<a href="<?php the_permalink(); ?>">
		<div class="entry-inner">
			<span class="post-date"><?php the_time( 'F d, Y' ); ?></span>
			<h2 class="post-title heading-font"><?php the_title(); ?></h2>
			<?php if ( foundation_is_theme_using_module( 'font-awesome' ) ) { ?>
				<a class="post-link-button">
					<?php if ( wptouch_should_load_rtl() ) { ?>
					<i class="icon-chevron-left"></i>
					<?php } else { ?>
					<i class="icon-chevron-right"></i>
					<?php } ?>
				</a>
			<?php } ?>
		</div><!-- entry-inner -->
	</a><!-- permalink -->
</div><!-- entry -->