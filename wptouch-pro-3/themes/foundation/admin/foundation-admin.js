/* namespace all admin functions with fdnAdmin */

function fdnAdminCheckFeatured() {
	var featuredSelect = jQuery( '#featured_enabled' );
	jQuery( '#featured_category, #featured_tag, #featured_type, #featured_post_ids' ).parent().hide();
	// We're on the proper admin page
	if ( featuredSelect.attr( 'checked' ) ) {			
		var featuredType = jQuery( '#featured_type' ).val();
		if ( featuredType == 'latest' ) {
			jQuery( '#featured_type' ).parent().animate( { height: 'toggle', opacity: 'toggle' }, 280 );
		} else if ( featuredType == 'category' ) {
			jQuery( '#featured_category, #featured_type' ).parent().animate( { height: 'toggle', opacity: 'toggle' }, 280 );
		} else if ( featuredType == 'tag' ) {
			jQuery( '#featured_tag, #featured_type' ).parent().animate( { height: 'toggle', opacity: 'toggle' }, 280 );
		} else if ( featuredType == 'posts' ) {
			jQuery( '#featured_post_ids, #featured_type' ).parent().animate( { height: 'toggle', opacity: 'toggle' }, 280 );
		}
	} 
}

function fdnAdminAdsPlacement(){
	var presentationSelect = jQuery( '#advertising_location' );
	presentationSelect.change( function(){
		var selectedOption = presentationSelect.val();
		if ( selectedOption != 'header' ) {			
			jQuery( '#advertising_blog_listings, #advertising_search' ).prop( 'disabled', 'disabled' )
		} else {
			jQuery( '#advertising_blog_listings, #advertising_search' ).prop( 'disabled', '' )		
		}
	}).change();
}

function fdnAdminReady() {	
	fdnAdminAdsPlacement();

	wptouchCheckToggle( '#featured_enabled', '#setting-featured_continuous, #setting-featured_grayscale, #setting-featured_autoslide, #setting-featured_speed, #setting-featured_filter_posts' );
	
	fdnAdminCheckFeatured();

	jQuery( '#featured_enabled' ).click( function() { fdnAdminCheckFeatured(); });
	jQuery( '#featured_type' ).change( function() { fdnAdminCheckFeatured(); });

}

jQuery( document ).ready( function() { fdnAdminReady(); });