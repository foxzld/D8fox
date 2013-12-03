/* WPtouch Simple Theme JS File */
/* Public functions called here reside in base.js, found in the Foundation theme */

function doSimpleReady() {
	
	jQuery( 'iframe' ).load( function(){
		jQuery( '#map' ).addClass( 'hide' ).css( 'margin-top', 'hidden' );
	});
	
	jQuery( '.map-address' ).on( 'click', function() {
		jQuery( '#map' ).toggleClass( 'hide' );
	});
	
}
	
jQuery( document ).ready( function() { doSimpleReady(); } );