<?php get_header(); ?>

	<div id="content">
		<?php simple_homepage_content(); ?>

		<?php if ( wptouch_has_menu( 'secondary_menu' ) ) { ?>
			<nav class="homepage-menu">
				<?php wptouch_show_menu( 'secondary_menu' ); ?>
			</nav>
		<?php } ?>
		
		<?php if ( simple_has_phone_number() ) { ?>
			<nav class="homepage-menu">
				<a href="tel:<?php simple_phone_number(); ?>" class="phone-number"><?php _e( 'Call Us', 'wptouch-pro' ); ?></a></li>
			</nav>
		<?php } ?>

		<?php if ( simple_has_map() ) { ?>
			<nav class="homepage-menu">
				<a href="javascript:return false;" class="map-address" data-effect-target="map">
					<?php _e( 'Our Location', 'wptouch-pro' ); ?>
				</a>
			</nav>			
		<?php } ?>
		
		<div id="map">
			<?php simple_map_display(); ?>
		</div>

	</div><!-- #content -->

<?php get_footer(); ?>