<li class="<?php wptouch_the_theme_classes(); ?>">
	<?php if ( wptouch_get_theme_screenshot() ) { ?>
	<div class="image-wrapper">
		<?php if ( wptouch_is_theme_active() ) { ?><span class="star"></span><span class="active-theme"></span><?php } ?>
		<a href="#" data-toggle="modal" data-target="#modal-<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>">
			<img src="<?php wptouch_the_theme_screenshot(); ?>" alt="<?php wptouch_the_theme_title(); ?>" />
			<span class="view"><?php _e( 'Click to view screenshots', 'wptouch-pro' ); ?></span>
		</a>

		<ul id="theme-actions">
			<?php if ( !wptouch_is_theme_active() && current_user_can( 'switch_themes' ) ) { ?>
				<li><a class="btn btn-small" href="<?php wtouch_the_theme_activate_link_url(); ?>"><?php _e( 'Activate', 'wptouch-pro' ); ?></a></li>
			<?php } ?>
			<li><a class="btn btn-small" href="<?php wtouch_the_theme_copy_link_url(); ?>"><?php _e( 'Copy', 'wptouch-pro' ); ?></a></li>
			<?php if ( wptouch_is_theme_custom() && !wptouch_is_theme_active() ) { ?>
				<li><a class="btn btn-small" class="delete-theme ajax-button" href="<?php wptouch_the_theme_delete_link_url(); ?>"><?php _e( 'Delete', 'wptouch-pro' ); ?></a></li>
			<?php } ?>		
			<?php if ( wptouch_is_theme_active() && current_user_can( 'manage_options' ) ) { ?>
				<li><a class="btn btn-small btn-success" href="admin.php?page=wptouch-admin-theme-options"><?php _e( 'Setup', 'wptouch-pro' ); ?></a></li>			
			<?php } ?>
		</ul>
		<div class="modal hide" id="modal-<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-header">
				<h3 id="<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>-title"><?php wptouch_the_theme_title(); ?></h3>
			</div>
			<div class="modal-body">
				<div id="carousel-<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>" class="carousel slide" data-interval="0">
				<!-- Carousel items -->
					<div class="carousel-inner">
						<?php wptouch_reset_theme_preview(); ?>
						<?php while ( wptouch_has_theme_preview_images() ) { ?>
							<?php wptouch_the_theme_preview_image(); ?>
							<div class="<?php if ( wptouch_is_first_theme_preview_image() ) echo 'active '; ?>item">
								<img src="<?php wptouch_the_theme_preview_url(); ?>" alt="preview-image" />
							</div>
						<?php } ?>
					</div>
					<!-- Carousel nav -->
				  	<a class="carousel-control left" href="#carousel-<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>" data-slide="prev">&laquo;</a>
	  				<a class="carousel-control right" href="#carousel-<?php echo wptouch_convert_to_class_name( wptouch_get_theme_title() ); ?>" data-slide="next">&raquo;</a>
		 		 </div>
			</div>
			<div class="modal-footer">
				<button class="button" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="theme-information">
		<h4>
			<?php wptouch_the_theme_title(); ?> <em>›</em> <span class="version"><?php wptouch_the_theme_version(); ?></span>
			<?php if ( wptouch_has_theme_tags() ) { ?>
				<?php $tags = wptouch_get_theme_tags(); ?>
				<?php foreach( $tags as $tag ) { ?>
				<i class="wptouch-tooltip theme-tag tag-<?php echo wptouch_convert_to_class_name( $tag ); ?>" title="<?php echo sprintf( __( 'This theme supports %s devices', 'wptouch-pro' ), wptouch_get_translated_device_type( $tag ) ); ?>"></i>
				<?php } ?>
			<?php } ?>
		</h4>
		<h5>
			<?php if ( wptouch_is_theme_child() ) { ?>
				<?php echo sprintf( __( 'a child theme of %s,', 'wptouch-pro' ), '<em>' . wptouch_get_theme_parent() . '</em>' ); ?><br />
			<?php } ?>		
			<?php echo sprintf( __( 'by %s', 'wptouch-pro' ), wptouch_get_theme_author() ); ?>
		</h5>
		<p class="desc"><?php wptouch_the_theme_description(); ?></p>
		
		<p class="info">
		<?php echo sprintf( __( 'Theme location: %s', 'wptouch-pro' ), wptouch_get_theme_location() ); ?> 
			<i class="wptouch-tooltip icon-question-sign" title="<?php _e( 'Relative to your WordPress wp-content directory.', 'wptouch-pro' ); ?>"></i>
			<br />
		</p>
	</div>
	<div class="clearer"></div>
</li>