function doClassicAdminReady() {
	wptouchCheckToggle( '#show_tab_bar', '#setting-tab_bar_cat_tags, #setting-tab_bar_max_cat_tags' );
}

jQuery( document ).ready( function() { doClassicAdminReady(); } );