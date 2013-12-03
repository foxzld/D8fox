<?php

define( 'SIMPLE_THEME_VERSION', '1.0.3' );
define( 'SIMPLE_SETTING_DOMAIN', 'simple' );

// Simple Actions
add_action( 'foundation_init', 'simple_theme_init' );
add_action( 'foundation_modules_loaded', 'simple_register_fonts' );

// Simple Filters
add_filter( 'wptouch_registered_setting_domains', 'simple_setting_domain' );
add_filter( 'wptouch_setting_defaults', 'simple_setting_defaults' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-options', 'simple_render_theme_settings' );
add_filter( 'wptouch_body_classes', 'simple_body_classes' );
add_filter( 'wptouch_setting_version_compare', 'simple_setting_version_compare', 10, 2 );
add_filter( 'foundation_settings_blog', 'simple_blog_settings' );

function simple_setting_version_compare( $version, $domain ) {
	if ( $domain == SIMPLE_SETTING_DOMAIN ) {
		return SIMPLE_THEME_VERSION;
	}

	return $version;
}

// Load the modules Simple supports:
function simple_theme_init() {
	foundation_add_theme_support( 
		array( 
			'concat',
			'advertising',
			'fastclick', 
			'font-awesome', 
			'google-fonts',
			'load-more', 
			'media', 
			'menu', 
			'social-links',
			'spinjs', 
			'webapp'
		) 
	);

	// Load the fancy Meny menu for iOS devices 5.x or higher
	if ( simple_use_3d_menu() && wptouch_fdn_iOS_5_or_higher() ) {
		foundation_add_theme_support(
			array( 'meny' )
		);
	}

	wptouch_register_theme_menu( 
		array(
			'name' => 'site_menu',	// this is the name of the setting
			'friendly_name' => __( 'Site Menu (Pulldown)', 'wptouch-pro' ),	// the friendly name, shows as a section heading
			'settings_domain' => SIMPLE_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
			'tooltip' => __( 'Pull-down menu at top of pages', 'wptouch-pro' ),
			'can_be_disabled' => true
		)
	);

	wptouch_register_theme_menu( 
		array(
			'name' => 'secondary_menu',	// this is the name of the setting
			'friendly_name' => __( 'Front Page Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
			'settings_domain' => SIMPLE_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
			'tooltip' => __( 'Displayed below front page menu and content', 'wptouch-pro' ),
			'can_be_disabled' => true
		)
	);
	
	// Theme Colors
	foundation_register_theme_color( 'simple_heading_color', __( 'Header background', 'wptouch-pro' ), '', '#menu, .toggle-button, .menu-bumper, .homepage-menu a:active', SIMPLE_SETTING_DOMAIN );
	foundation_register_theme_color( 'simple_background_color', __( 'Theme background', 'wptouch-pro' ), '', 'html, body, .page-wrapper', SIMPLE_SETTING_DOMAIN );
	foundation_register_theme_color( 'simple_link_color', __( 'Links', 'wptouch-pro' ), 'a', '', SIMPLE_SETTING_DOMAIN );

}

function simple_register_fonts() {
	if ( foundation_is_theme_using_module( 'google-fonts' ) ) {

		foundation_register_google_font_pairing(
			'arvo_ptsans',
			foundation_create_google_font( 'heading', 'Arvo', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'PT Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);	

		foundation_register_google_font_pairing(
			'inika_raleway',
			foundation_create_google_font( 'heading', 'Inika', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Raleway', 'sans-serif', array( '500', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'domine_opensans',
			foundation_create_google_font( 'heading', 'Domine', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Open Sans', 'sans-serif', array( '500', '700', '500italic', '700italic' ) )
		);	

		foundation_register_google_font_pairing(
			'dosis_dsans',
			foundation_create_google_font( 'heading', 'Dosis', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Droid Sans', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);
	
		foundation_register_google_font_pairing(
			'fugaz_dsans',
			foundation_create_google_font( 'heading', 'Leckerli One', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Roboto', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);
	
		foundation_register_google_font_pairing(
			'fjalla_carrois',
			foundation_create_google_font( 'heading', 'Fjalla One', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Carrois Gothic', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

	}
}

function simple_body_classes( $classes ) {
	$settings = simple_get_settings();

	$heading_luma = wptouch_hex_to_luma( $settings->simple_heading_color );

	if ( $heading_luma <= 150 ) {
		$classes[] = 'dark-header';
	} else {
		$classes[] = 'light-header';
	}
	
	$body_luma = wptouch_hex_to_luma( $settings->simple_background_color );

	if ( $body_luma <= 150 ) {
		$classes[] = 'dark-body';
	} else {
		$classes[] = 'light-body';
	}

	return $classes;
}

function simple_setting_defaults( $settings ) {

	// Homepage setting defaults
	$settings->homepage_message = '';

	// Map address
	$settings->map_address = '';

	// Phone Number
	$settings->phone_number = '';
	
	// Show Search
	$settings->blog_search = true;
	
	// 3D Menu
	$settings->threed_menu = true;	

	// Menu defaults
	$settings->site_menu = 'wp';
	$settings->secondary_menu = 'wp';

	// Branding
	$settings->simple_heading_color  = '#0095dc';
	$settings->simple_link_color = '#0095dc';
	$settings->simple_background_color = '#e5e3db';
	$settings->background_image = '';
	$settings->css_noise = false;

	return $settings;
}

// Hook into Foundation page section for Blog and add a setting
function simple_blog_settings( $blog_settings ) {

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'blog_search',
		__( 'Enable search on blog pages', 'wptouch-pro' ),
		'',
		WPTOUCH_SETTING_BASIC,
		'1.0.1',
		'',
		SIMPLE_SETTING_DOMAIN	
	);

	return $blog_settings;
}

function simple_render_theme_settings( $page_options ) {
	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Homepage Call Us', 'wptouch-pro' ),
		'homepage-phone',
		array(
		wptouch_add_setting(
				'text',
				'phone_number',
				__( 'Phone number', 'wptouch-pro' ),
				__( 'Enter a phone number and a homepage menu item for \'call us\' will be shown.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Homepage Location', 'wptouch-pro' ),
		'homepage-location',
		array(
		wptouch_add_setting(
				'text',
				'map_address',
				__( 'Map address', 'wptouch-pro' ),
				__( 'Enter an address and a homepage menu item for \'Our Location\' will be shown.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Front Page Content', 'wptouch-pro' ),
		'homepage-message',
		array(
			wptouch_add_setting(
				'textarea',
				'homepage_message',
				__( 'Front page alternate content', 'wptouch-pro' ),
				__( 'Shows above the front page menu (if enabled), HTML allowed.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( '3D Menu', 'wptouch-pro' ),
		'3d-menu',
		array(
			wptouch_add_setting(
				'checkbox',
				'threed_menu',
				__( 'Use a 3D slide menu on supported devices', 'wptouch-pro' ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0.2'
			)
		),

		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Tiled Background Image', 'wptouch-pro' ),
		'background-image',
		array(
			wptouch_add_setting( 
				'image-upload', 
				'background_image', 
				__( '(Scaled for retina displays)', 'wptouch-pro' ), 
				'', 
				WPTOUCH_SETTING_BASIC, 
				'1.0'
			) 			
		),
		
		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'CSS Effects', 'wptouch-pro' ),
		'css-noise',
		array(
		wptouch_add_setting(
				'checkbox',
				'css_noise',
				__( 'Add a light noise effect to the drop-down menu and theme background', 'wptouch-pro' ),
				__( 'Will apply the effect overtop of any background image you upload.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		SIMPLE_SETTING_DOMAIN
	);

	return $page_options;
}

function simple_use_3d_menu() {
	$settings = simple_get_settings();
	
	if ( $settings->threed_menu ) {
		return true;
	} else {
		return false;
	}
}

function simple_setting_domain( $domains ) {
	$domains[] = SIMPLE_SETTING_DOMAIN;
	return $domains;
}

function simple_get_settings() {
	return wptouch_get_settings( SIMPLE_SETTING_DOMAIN );
}