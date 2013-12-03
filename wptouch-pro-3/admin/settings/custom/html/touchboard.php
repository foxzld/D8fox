<?php $settings = wptouch_get_settings(); ?>
<div id="touchboard-left">
	<?php if ( wptouch_should_show_license_nag() ) { ?>
		<div class="alert">
	  		<p><?php echo sprintf( __( 'This copy of %s is currently unlicensed!', 'wptouch-pro' ), 'WPtouch Pro' ); ?></p>
	  		<?php if ( wptouch_should_show_activation_nag() ) { ?>
	  			<a href="<?php echo admin_url( 'admin.php?page=wptouch-admin-license' ); ?>" class="btn btn-warning"><?php _e( 'Get started with activation &raquo;', 'wptouch-pro' ); ?></a>
	  		<?php } ?>
		</div>
	<?php } ?>

	<div id="touchboard-carousel" class="slide">
		<!-- Carousel items -->
		<div class="carousel-inner">
			<div class="active item">
				<img src="<?php echo WPTOUCH_ADMIN_URL; ?>/images/slider/loading.jpg" alt="<?php _e( 'Loading remote images', 'wptouch-pro' ); ?>">
			</div>
		</div>
		<ul class="dots"></ul>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#touchboard-carousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#touchboard-carousel" data-slide="next">&rsaquo;</a>
	</div><!-- touchboard-carousel -->

	<br class="clearer" />
	
	<div class="modal hide" id="modal-updates" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-header">
			<p><?php echo sprintf( __( '%s Change Log', 'wptouch-pro' ), 'WPtouch Pro' ); ?></p>
		</div>
		<div class="modal-body" id="change-log">
		</div>
		<div class="modal-footer">
			<button class="button" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
</div><!-- touchboard-left -->
