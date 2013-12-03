<?php
define( 'CLASSIC_THEME_VERSION', '1.0.3' );
define( 'CLASSIC_SETTING_DOMAIN', 'classic-redux' );

define( 'CLASSIC_DIR', WPTOUCH_DIR . '/themes/classic-redux' );
define( 'CLASSIC_URL', WPTOUCH_URL . '/themes/classic-redux' );
define( 'CLASSIC_PAGE_TABLETS', __( 'Tablets', 'wptouch-pro' ) );

add_action( 'foundation_init', 'classic_theme_init' );
add_action( 'foundation_modules_loaded', 'classic_register_fonts' );
add_action( 'admin_enqueue_scripts', 'classic_enqueue_admin_scripts' );

add_filter( 'wptouch_registered_setting_domains', 'classic_setting_domain' );
add_filter( 'wptouch_setting_defaults', 'classic_setting_defaults' );
add_filter( 'wptouch_body_classes', 'classic_body_classes' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-options', 'classic_render_theme_settings' );
add_filter( 'wptouch_setting_version_compare', 'classic_setting_version_compare', 10, 2 );
add_filter( 'foundation_settings_blog', 'classic_blog_settings' );
add_filter( 'foundation_settings_pages', 'classic_page_settings' );


function classic_setting_version_compare( $version, $domain ) {
	if ( $domain == CLASSIC_SETTING_DOMAIN ) {
		return CLASSIC_THEME_VERSION;
	}

	return $version;
}

function classic_theme_init() {
	// Add iPad homescreen icons and webapp loading images settings, and support for other tablets
	classic_if_tablets_supported();

	// Load the modules Classic supports:	
	foundation_add_theme_support( 
		array( 
			'concat',
			'advertising',
			'custom-posts', 
			'custom-latest-posts',			
			'font-awesome', 
			'fastclick', 
			'featured',
			'google-fonts',
			'load-more',
			'media', 
			'menu', 
			'reset', 
			'sharing',
			'social-links',
			'spinjs', 
			'twitter',
			'webapp'
		) 
	);
		
	// If enable in Classic settings, load up infinite scrolling
	classic_if_infinite_scroll_enabled();

	wptouch_register_theme_menu( 
		array(
			'name' => 'primary_menu',									// this is the name of the setting
			'friendly_name' => __( 'Header Menu', 'wptouch-pro' ),		// the friendly name, shows as a section heading
			'settings_domain' => CLASSIC_SETTING_DOMAIN,				// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	 	// the description
			'tooltip' => '', 	// Extra help info about this menu, perhaps?
			'can_be_disabled' => false 
		)
	);
	
	// Classic Colors
	foundation_register_theme_color( 'classic_header_color', __( 'Header background', 'wptouch-pro' ), '.arrow-down', '#header, ul.tab-menu, #menu, #slider', CLASSIC_SETTING_DOMAIN );	
	foundation_register_theme_color( 'classic_background_color', __( 'Theme background', 'wptouch-pro' ), '', '.page-wrapper', CLASSIC_SETTING_DOMAIN );
	foundation_register_theme_color( 'classic_link_color', __( 'Links', 'wptouch-pro' ), 'a', '.dots li.active, .placeholder', CLASSIC_SETTING_DOMAIN );

}

function classic_if_tablets_supported(){
	$settings = classic_get_settings();

	if ( $settings->tablet_support ) {
		foundation_add_theme_support( 'tablets' );
	}
}

function classic_if_infinite_scroll_enabled(){
	$settings = classic_get_settings();

	if ( $settings->use_infinite_scroll ) {
		foundation_add_theme_support( 'infinite-scroll' );
	}
}

function classic_setting_defaults( $settings ) {
	$settings->primary_menu = 'wp';

	$settings->use_thumbnails = 'index';
	$settings->tab_bar_cat_tags = 'categories_and_tags';
	$settings->show_tab_bar = true;
	$settings->tab_bar_max_cat_tags = 15;

	$settings->classic_header_color = '#333333';
	$settings->classic_background_color = '#eceef5';
	$settings->classic_link_color = '#0095dc';

	$settings->show_date = true;
	$settings->show_author = false;
	$settings->show_taxonomy = false;

	$settings->show_page_titles = true;
	
	$settings->menu_button_as_text = false;
	$settings->rounded_corners = false;
	$settings->use_infinite_scroll = false;
	$settings->css_noise = false;

	// Tablets
	$settings->tablet_support = true;

	return $settings;
}

function classic_register_fonts() {
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
			'dosis_dsans',
			foundation_create_google_font( 'heading', 'Dosis', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Droid Sans', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);	

		foundation_register_google_font_pairing(
			'bitter_sourcesans',
			foundation_create_google_font( 'heading', 'Bitter', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'lato_sourcesans',
			foundation_create_google_font( 'heading', 'Lato', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

	}
}

function classic_enqueue_admin_scripts() {
	wp_enqueue_script( 
		'classic-admin-js', 
		CLASSIC_URL . '/admin/classic-admin.js', 
		array( 'jquery', 'wptouch-pro-admin' ), 
		CLASSIC_THEME_VERSION, 
		false
	);
}

function classic_body_classes( $classes ) {
	$settings = classic_get_settings();

	if ( $settings->rounded_corners ) {
		$classes[] = 'rounded-corners';
	}
	
	$heading_luma = wptouch_hex_to_luma( $settings->classic_header_color );

	if ( $heading_luma <= 150 ) {
		$classes[] = 'dark-header';
	} else {
		$classes[] = 'light-header';
	}
	
	$body_luma = wptouch_hex_to_luma( $settings->classic_background_color );

	if ( $body_luma <= 150 ) {
		$classes[] = 'dark-body';
	} else {
		$classes[] = 'light-body';
	}
	
	return $classes;
}

// Hook into Foundation page section for Blog and add a setting
function classic_blog_settings( $blog_settings ) {
	
	$blog_settings[] = wptouch_add_setting( 
		'radiolist', 
		'use_thumbnails', 
		__( 'Post thumbnails', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0.2',
		array( 
			'none' => __( 'No thumbnails', 'wptouch-pro' ),
			'index' => __( 'Blog listing only', 'wptouch-pro' ),
			'index_single' => __( 'Blog listing, single posts', 'wptouch-pro' ),
			'all' => __( 'All (blog, single, search and archive)', 'wptouch-pro' )
		),
		CLASSIC_SETTING_DOMAIN
	);
	
	$blog_settings[] = wptouch_add_setting( 
		'checkbox', 
		'show_date', 
		__( 'Show post date', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0.2',
		'',
		CLASSIC_SETTING_DOMAIN	
	);

	$blog_settings[] = wptouch_add_setting( 
		'checkbox', 
		'show_author', 
		__( 'Show post author', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0',
		'',
		CLASSIC_SETTING_DOMAIN	
	);

	$blog_settings[] = wptouch_add_setting( 
		'checkbox', 
		'show_taxonomy', 
		__( 'Show post categories and tags', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0',
		'',
		CLASSIC_SETTING_DOMAIN	
	);

	$blog_settings[] = wptouch_add_setting( 
		'checkbox', 
		'use_infinite_scroll', 
		__( 'Use infinite scrolling for blog', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0',
		'',
		CLASSIC_SETTING_DOMAIN	
	);

	$blog_settings[] = wptouch_add_setting( 
		'checkbox', 
		'rounded_corners', 
		__( 'Use rounded corners', 'wptouch-pro' ), 
		'', 
		WPTOUCH_SETTING_BASIC, 
		'1.0',
		'',
		CLASSIC_SETTING_DOMAIN	
	);


	return $blog_settings;
}

// Hook into Foundation page section for Blog and add a setting
function classic_page_settings( $page_settings ) {

	$page_settings[] = wptouch_add_setting(
		'checkbox',
		'show_page_titles',
		__( 'Show page title areas on pages', 'wptouch-pro' ),
		'',
		WPTOUCH_SETTING_BASIC,
		'1.0.3',
		'',
		CLASSIC_SETTING_DOMAIN	
	);

	return $page_settings;
}

function classic_render_theme_settings( $page_options ) {
	wptouch_add_sub_page( CLASSIC_PAGE_TABLETS, 'classic-page-tablets', $page_options );

	wptouch_add_page_section(
		CLASSIC_PAGE_TABLETS,
		__( 'Tablets', 'wptouch-pro' ),
		'tablet-settings',
		array(
			wptouch_add_setting( 
			'checkbox', 
			'tablet_support', 
			__( 'Add tablet support', 'wptouch-pro' ), 
			'', 
			WPTOUCH_SETTING_BASIC, 
			'1.0' 
			)
		),
		$page_options,
		CLASSIC_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Header Menu Area', 'wptouch-pro' ),
		'menu-tab-bar-theme-settings',
		array(
			wptouch_add_setting( 
				'checkbox', 
				'menu_button_as_text', 
				__( 'Drop-down button says "Menu"', 'wptouch-pro' ), 
				'', 
				WPTOUCH_SETTING_BASIC, 
				'1.0.2' 
			),
			wptouch_add_setting( 
				'checkbox', 
				'show_tab_bar', 
				__( 'Show tab bar', 'wptouch-pro' ), 
				'', 
				WPTOUCH_SETTING_BASIC, 
				'1.0' 
			),			
			wptouch_add_setting( 
				'list',
				'tab_bar_cat_tags',
				__( 'Tab-bar shows categories or tags', 'wptouch-pro' ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0',
				array(
					'categories_and_tags' => __( 'Categories and tags', 'wptouch-pro' ),
					'categories' => __( 'Categories only', 'wptouch-pro' ),
					'tags' => __( 'Tags only', 'wptouch-pro' ),
					'none' => __( 'No categories or tags', 'wptouch-pro' )
				)
			),	
			wptouch_add_setting( 
				'list',
				'tab_bar_max_cat_tags',
				__( 'Max categories / tags', 'wptouch-pro' ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0',
				array(
					'5' => '5',
					'10' => '10',
					'25' => '25',
					'50' => '50'
				)
			)
		),
		$page_options,
		CLASSIC_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'CSS Effects', 'wptouch-pro' ),
		'css-noise',
		array(
		wptouch_add_setting(
				'checkbox',
				'css_noise',
				__( 'Add a noise effect to the header and theme background', 'wptouch-pro' ),
				__( 'Will apply the effect overtop of any background image you upload.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		CLASSIC_SETTING_DOMAIN
	);

	return $page_options;

}

function classic_setting_domain( $domain ) {
	$domain[] = CLASSIC_SETTING_DOMAIN;

	return $domain;
}

function classic_get_settings() {
	return wptouch_get_settings( CLASSIC_SETTING_DOMAIN );
}