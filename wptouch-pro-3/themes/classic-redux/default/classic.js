/* WPtouch Classic Redux JS File */

function classicHandleTextDropDowns() {
	jQuery( '#content' ).on( 'click', '.text-expand', function() {
		var arrow = jQuery( this );
		var content = jQuery( this ).parent().find( '.post-content' );
		if ( content.hasClass( 'slide-in' ) ) {
			arrow.removeClass( 'icon-chevron-up' ).addClass( 'icon-chevron-down' );
			content.webkitSlideToggle();
		} else {
			arrow.removeClass( 'icon-chevron-down' ).addClass( 'icon-chevron-up' );	
			content.webkitSlideToggle();
		}
	});
}

function classicHandleTabMenu() {
	if ( jQuery( 'ul.tab-menu' ).length ) {
		jQuery( 'ul.tab-menu' ).on( 'click', 'a', function( e ) {
			jQuery( 'ul.tab-menu li a' ).removeClass( 'active' );
			jQuery( this ).addClass( 'active' );
			jQuery( '.tab-section' ).hide();
			var sectionName = ( '.' + jQuery( this ).attr( 'data-section' ) );
			jQuery( sectionName ).show();
	
			// Triggers focus on the search field when the search tab item is clicked
			if ( jQuery( this ).hasClass( 'icon-search' ) ) {
				jQuery( '#search-text' ).focus();
			}
	
			e.preventDefault();		
		});

		jQuery( 'ul.tab-menu li' ).find( 'a' ).first().click();
	} else {
		jQuery( '.wptouch-menu' ).css( 'display', 'block' );
	}
}

function classicSwapGalleryNav(){
	var prevEl = jQuery( '.gallery-nav .left' );
	var nextEl = jQuery( '.gallery-nav .right' );
	var prevLink = prevEl.find( 'a' ).attr( 'href' );
	var nextLink = nextEl.find( 'a' ).attr( 'href' );
	if ( prevLink != undefined ) {
		prevEl.html( '<a class="gallery-nav-links" href="'+prevLink+'"><i class="icon-circle-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;|' );
	}
	if ( nextLink != undefined ) {
		nextEl.html( '<a class="gallery-nav-links" href="'+nextLink+'"><i class="icon-circle-arrow-right"></i></a>' );
	}
	
	jQuery( '.gallery-nav' ).on( 'click', 'a.gallery-nav-links', function( e ) {
		var galleryNavUrl = jQuery( this ).attr( 'href' );
		e.preventDefault();
		window.location = galleryNavUrl;
	});
}

function doClassicReady() {
	classicSwapGalleryNav();
	classicHandleTextDropDowns();
	classicHandleTabMenu();
}

jQuery( document ).ready( function() { doClassicReady(); } );