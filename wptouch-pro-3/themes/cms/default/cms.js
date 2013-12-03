/* WPtouch CMS Theme Js File */

function doCMSReady() {
	
	// Triggers focus on the search field when the search tab item is clicked
	jQuery( '#search-menu-button' ).on( 'click', function(){
		jQuery( '#search-text' ).focus();
	});
	
	// Helps with usability and the fastclick module— it's too fast and triggers taps too quickly!
	jQuery( '#section-slider a' ).each( function(){
		jQuery( this ).addClass( 'needsclick' );
	});

	jQuery( '#content' ).on( 'click', '.entry', function(){
		var postLink = jQuery( this ).find( 'a:first').attr( 'href' );
		window.location = postLink;
	})

}
	
jQuery( document ).ready( function() { doCMSReady(); } );