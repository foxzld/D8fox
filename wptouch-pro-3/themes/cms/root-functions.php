<?php

// CMS Defines
define( 'CMS_THEME_VERSION', '1.0.2' );
define( 'CMS_SETTING_DOMAIN', 'cms' );

// CMS Actions
add_action( 'foundation_init', 'cms_theme_init' );
add_action( 'foundation_modules_loaded', 'cms_register_fonts' );

// CMS Filters
add_filter( 'wptouch_registered_setting_domains', 'cms_setting_domain' );
add_filter( 'wptouch_setting_defaults_cms', 'cms_setting_defaults' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-options', 'cms_render_theme_settings' );
add_filter( 'wptouch_body_classes', 'cms_body_classes' );

add_filter( 'foundation_featured_should_modify_query', 'cms_featured_check_query', 10, 2 );
add_filter( 'wptouch_setting_version_compare', 'cms_setting_version_compare', 10, 2 );

function cms_setting_version_compare( $version, $domain ) {
	if ( $domain == CMS_SETTING_DOMAIN ) {
		return CMS_THEME_VERSION;
	}

	return $version;
}

function cms_setting_defaults( $settings ) {

	// Main Menu
	$settings->main_menu = 'wp';

	// Alternate Menu (Optional)
	$settings->alternate_menu = 'none';

	// Custom theme colors
	$settings->cms_heading_color = '#990000';
	$settings->cms_link_color = '#990000';
	$settings->cms_background_color = '#f6f3e0';

	$settings->css_noise = false;
	$settings->category_slider = true;
	$settings->second_menu_title = __( 'Alt Menu', 'wptouch-pro' );
	$settings->background_image = '';
	$settings->frontpage_message = '';

	return $settings;
}

function cms_featured_check_query( $should_be_ignored, $query ) {
	$should_be_ignored = $should_be_ignored || $query->is_archive;

	return $should_be_ignored;
}

function cms_body_classes( $classes ) {
	$settings = cms_get_settings();

	$heading_luma = wptouch_hex_to_luma( $settings->cms_heading_color );

	if ( $heading_luma <= 150 ) {
		$classes[] = 'dark-header';
	} else {
		$classes[] = 'light-header';
	}

	$body_luma = wptouch_hex_to_luma( $settings->cms_background_color );

	if ( $body_luma <= 150 ) {
		$classes[] = 'dark-body';
	} else {
		$classes[] = 'light-body';
	}

	return $classes;
}

// Add Foundation Module Support
function cms_theme_init() {
	foundation_add_theme_support(
		array(
			'concat',
			'advertising',
			'custom-posts',
			'custom-latest-posts',
			'fastclick',
			'featured',
			'font-awesome',
			'google-fonts',
			'load-more',
			'media',
			'menu',
			'sharing',
			'social-links',
			'spinjs',
			'webapp'
		)
	);

	wptouch_register_theme_menu( array(
		'name' => 'main_menu',	// this is the name of the setting
		'friendly_name' => __( 'Main Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
		'settings_domain' => CMS_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
		'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
		'tooltip' => '',
		'can_be_disabled' => false
	));

	wptouch_register_theme_menu( array(
		'name' => 'alternate_menu',	// this is the name of the setting
		'friendly_name' => __( 'Alternate Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
		'settings_domain' => CMS_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
		'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
		'tooltip' => '',
		'can_be_disabled' => true
	));

	// Theme Colours
	foundation_register_theme_color( 'cms_heading_color', __( 'Header background', 'wptouch-pro' ), '', '#header, .generic-slider, #single-nav-bar, .post-link-button, #main-menu, #alt-menu, .dots li.active', CMS_SETTING_DOMAIN );
	foundation_register_theme_color( 'cms_background_color', __( 'Theme background', 'wptouch-pro' ), '', 'body', CMS_SETTING_DOMAIN );
	foundation_register_theme_color( 'cms_link_color', __( 'Links', 'wptouch-pro' ), 'a', '', CMS_SETTING_DOMAIN );
}

function cms_register_fonts() {
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
			foundation_create_google_font( 'body', 'Open Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'bitter_sourcesans',
			foundation_create_google_font( 'heading', 'Bitter', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
	}
}

function cms_render_theme_settings( $page_options ) {

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Category Slider', 'wptouch-pro' ),
		'category-slider',
		array(
		wptouch_add_setting(
				'checkbox',
				'category_slider',
				__( 'Enable category slider', 'wptouch-pro' ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0.1'
			)
		),

		$page_options,
		CMS_SETTING_DOMAIN
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
		CMS_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Alternate Menu Title', 'wptouch-pro' ),
		'secondary-menu',
		array(
		wptouch_add_setting(
				'text',
				'second_menu_title',
				__( 'Alternate menu title (if used)', 'wptouch-pro' ),
				__( 'If you use a second menu in CMS, this text will be used for the drop-down button title.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		CMS_SETTING_DOMAIN
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
		CMS_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Static Front Page', 'wptouch-pro' ),
		'frontpage-message',
		array(
			wptouch_add_setting(
				'textarea',
				'frontpage_message',
				__( 'Static front page alternate content', 'wptouch-pro' ),
				__( 'Shows after the featured slider (if enabled), and replaces your Static Front Page content. HTML allowed.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		CMS_SETTING_DOMAIN
	);

	return $page_options;
}

function cms_setting_domain( $domains ) {
	$domains[] = CMS_SETTING_DOMAIN;
	return $domains;
}

function cms_get_settings() {
	return wptouch_get_settings( CMS_SETTING_DOMAIN );
}
