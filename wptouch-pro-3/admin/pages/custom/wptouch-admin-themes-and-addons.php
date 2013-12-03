<?php require_once( WPTOUCH_DIR . '/core/admin-themes.php' ); ?>

<ul id="wptouch-theme-browser">
<?php while ( wptouch_has_themes() ) { ?>
	<?php wptouch_the_theme(); ?>
	<?php if ( wptouch_is_theme_active() ) { ?>
		<?php include( 'theme-browser-item.php' ); ?>
	<?php } ?>
<?php } ?>

<?php wptouch_rewind_themes(); ?>

<?php while ( wptouch_has_themes() ) { ?>
	<?php wptouch_the_theme(); ?>
	<?php if ( !wptouch_is_theme_active() ) { ?>
		<?php include( 'theme-browser-item.php' ); ?>
	<?php } ?>
<?php } ?>
</ul>
