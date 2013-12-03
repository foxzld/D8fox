
	<?php if ( wptouch_has_menu( 'site_menu' ) ) { ?>
		<div id="menu" class="wptouch-menu show-hide-menu <?php simple_css_noise(); ?>">
			<?php wptouch_show_menu( 'site_menu' ); ?>
		</div>
	<?php } ?>

	<div class="page-wrapper <?php simple_css_noise(); ?>" style="background-image: url(<?php simple_get_background_image(); ?>); background-size: 25%;"><!-- .page-wrapper tag closed in foundation's footer.php -->

	<?php do_action( 'wptouch_advertising_top' ); ?>

	<?php if ( wptouch_has_menu( 'site_menu' ) ) { ?>
		<div class="menu-bumper <?php simple_css_noise(); ?>">
			<a href="javascript:return false;" class="toggle-button meny-toggle slide-toggle <?php simple_css_noise(); ?>" data-effect-target="menu"><?php __( 'Toggle Menu', 'wptouch-pro' ); ?></a>	
		</div>
	<?php } ?>
	
		<div id="header-area">
			<a href="<?php wptouch_bloginfo( 'url' ); ?>">
				<?php if ( foundation_has_logo_image() ) { ?>
					<img src="<?php foundation_the_logo_image(); ?>" alt="logo image" />	
				<?php } else { ?>
					<h1 class="heading-font"><?php wptouch_bloginfo( 'site_title' ); ?></h1>
				<?php } ?>
			</a>
		</div>