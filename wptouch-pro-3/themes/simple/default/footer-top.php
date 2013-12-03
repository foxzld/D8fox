<?php if ( !is_front_page() && !is_page() ) { ?>
	<a href="#" class="back-to-top">Back to top</a>
<?php } ?>

<?php if ( ( is_home() || is_single() ) && simple_show_search() ) { ?>
	<form method="get" id="searchform" action="<?php wptouch_bloginfo( 'search_url' ); ?>/">
		<input type="text" name="s" id="search-text" placeholder="<?php _e( 'search this website', 'wptouch-pro' ); ?>&hellip;" />
		<button name="submit" type="submit" id="search-submit" class="button-dark">
			<?php _e( 'search', 'wptouch-pro' ); ?>
		</button>	
	</form>
<?php } ?>
