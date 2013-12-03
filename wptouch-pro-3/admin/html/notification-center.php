<?php $settings = wptouch_get_settings(); ?>

<div class="dropdown notifications">
	<?php if ( $settings->preview_mode == 'on' ) { ?>
	<div id="preview-notification"><a href="<?php echo admin_url( 'admin.php?page=wptouch-admin-general-settings#section-setup-backup' ); ?>"><?php echo sprintf( __( 'Preview Mode %sOn%s', 'wptouch-pro' ), '<span>', '</span>' ); ?></a></div>
	<?php } ?>

	<button id="notification-drop" class="notifications-btn btn btn-small dropdown-toggle" type="button" data-toggle="dropdown">
		<?php _e( 'Notifications', 'wptouch-pro' ); ?>
	</button>
	<span class="number" style="display: none;"></span>
	
	<div class="dropdown-menu notifications-div" role="menu" aria-labelledby="notification-drop">
		<span id="ajax-notifications"></span>
	</div><!-- drop-down menu -->
</div>