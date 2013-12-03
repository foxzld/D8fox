<?php

define( 'FOUNDATION_VERSION', '1.0.4' );

define( 'FOUNDATION_DIR', WPTOUCH_DIR . '/themes/foundation' );
define( 'FOUNDATION_URL', WPTOUCH_URL . '/themes/foundation' );

define( 'FOUNDATION_SETTING_DOMAIN', 'foundation' );

define( 'FOUNDATION_PAGE_GENERAL', __( 'General', 'wptouch-pro' ) );
define( 'FOUNDATION_PAGE_BRANDING', __( 'Branding', 'wptouch-pro') );
define( 'FOUNDATION_PAGE_MEDIA', __( 'Media Handling', 'wptouch-pro' ) );
define( 'FOUNDATION_PAGE_WEB_APP', __( 'Web-App Mode', 'wptouch-pro' ) );
define( 'FOUNDATION_PAGE_HOMESCREEN_ICONS', __( 'Homescreen Icons', 'wptouch-pro' ) );
define( 'FOUNDATION_PAGE_ADVERTISING', __( 'Advertising', 'wptouch-pro' ) );
define( 'FOUNDATION_PAGE_CUSTOM', __( 'Custom Content', 'wptouch-pro' ) );
define( 'FOUNDATION_MAX_LOGO_SIZE', 1136 );

add_action( 'admin_enqueue_scripts', 'foundation_enqueue_admin_scripts' );
add_filter( 'wptouch_registered_setting_domains', 'foundation_setting_domain' );
add_filter( 'wptouch_setting_defaults_foundation', 'foundation_setting_defaults' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-options', 'foundation_render_theme_settings' );
add_filter( 'wptouch_setting_version_compare', 'foundation_setting_version_compare', 10, 2 );
add_filter( 'wptouch_body_classes', 'foundation_body_classes' );
add_filter( 'wptouch_the_content', 'foundation_insert_multipage_links');

add_action( 'wptouch_post_head', 'foundation_setup_smart_app_banner' );
add_action( 'wptouch_post_head', 'foundation_setup_homescreen_icons' );
add_action( 'wptouch_post_head', 'foundation_setup_viewport' );
add_action( 'wptouch_pre_footer', 'foundation_handle_footer' );
add_action( 'pre_get_posts', 'foundation_posts_per_page' );
add_filter( 'pre_get_posts', 'foundation_exclude_categories_tags' );
add_action( 'wptouch_parent_style_queued', 'foundation_enqueue_color_data' );

add_action( 'wptouch_post_process_image_file', 'foundation_process_image_file', 10, 2 );

function foundation_setting_domain( $domains ) {
	$domains[] = FOUNDATION_SETTING_DOMAIN;

	return $domains;
}

function foundation_setting_version_compare( $version, $domain ) {
	if ( $domain == FOUNDATION_SETTING_DOMAIN ) {
		return FOUNDATION_VERSION;
	}

	return $version;
}

function foundation_process_image_file( $file_name, $setting_name ) {
	if ( $setting_name->domain == FOUNDATION_SETTING_DOMAIN && $setting_name->name == 'logo_image' ) {
		// Need to make sure this isn't too big
		if ( function_exists( 'getimagesize' ) && function_exists( 'imagecreatefrompng' ) && function_exists( 'imagecopyresampled' ) && function_exists( 'imagepng' ) ) {
			$size = getimagesize( $file_name );
			if ( $size ) {
				$width = $size[0];
				$height = $size[1];

				if ( $size['mime'] == 'image/png' ) {
					if ( $width > FOUNDATION_MAX_LOGO_SIZE ) {
						$new_width = FOUNDATION_MAX_LOGO_SIZE;
						$new_height = $height*$new_width/$width;

						$large_image = imagecreatefrompng( $file_name );
						$perfect_image = imagecreatetruecolor( $new_width, $new_height );

						imagecopyresampled( $perfect_image, $large_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

						// Get rid of the old file
						unlink( $file_name );

						imagepng( $perfect_image, $file_name );
					}
				}
			}
		}
	}
}

function foundation_setting_defaults( $settings ) {
	$settings->latest_posts_page = 'none';

	// General
	$settings->hide_address_bar = true;
	$settings->video_handling_type = 'fitvids';

	// Branding
	$settings->typography_sets = 'default';
	$settings->smart_app_banner = '';

	// Web App Mode
	$settings->webapp_mode_enabled = false;
	$settings->webapp_enable_persistence = true;
	$settings->webapp_show_notice = true;
	$settings->webapp_notice_message = __( 'Install this Web-App on your [device]: tap [icon] then "Add to Home Screen"', 'wptouch-pro' );
	$settings->webapp_ignore_urls = '';

	$settings->webapp_notice_expiry_days = 30;
	$settings->startup_screen_iphone_2g_3g = false;
	$settings->startup_screen_iphone_4_4s = false;
	$settings->startup_screen_iphone_5 = false;
	$settings->startup_screen_ipad_1_portrait = false;
	$settings->startup_screen_ipad_1_landscape = false;
	$settings->startup_screen_ipad_3_portrait = false;
	$settings->startup_screen_ipad_3_landscape = false;

	// Homescreen Icons
	$settings->homescreen_icon_title = get_bloginfo( 'name' );
	$settings->enable_glossy_icons = true;
	$settings->iphone_icon = false;
	$settings->iphone_icon_retina = false;
	$settings->ipad_icon = false;
	$settings->ipad_icon_retina = false;

	// Advertising
	$settings->advertising_type = 'none';
	$settings->advertising_location = 'header';

	// Sharing
	$settings->show_share = true;
	$settings->share_location = 'bottom';
	$settings->share_colour_scheme = 'default';

	// Social Links
	$settings->social_facebook_url = '';
	$settings->social_twitter_url = '';
	$settings->social_google_url = '';
	$settings->social_pinterest_url = '';
	$settings->social_vimeo_url = '';
	$settings->social_linkedin_url = '';
	$settings->social_email_url = '';
	$settings->social_rss_url = '';

	// New checkboxes
	$settings->advertising_blog_listings = true;
	$settings->advertising_single = true;
	$settings->advertising_pages = false;
	$settings->advertising_taxonomy = true;
	$settings->advertising_search = true;

	$settings->google_adsense_id = '';
	$settings->google_slot_id = '';
	$settings->custom_advertising_mobile = '';

	// Custom Content
	$settings->custom_footer_message = '';

	$settings->featured_enabled = true;
	$settings->featured_autoslide = false;
	$settings->featured_continuous = false;
	$settings->featured_grayscale = false;
	$settings->featured_type = 'latest';
	$settings->featured_tag = '';
	$settings->featured_category = '';
	$settings->featured_post_ids = '';
	$settings->featured_speed = 'normal';
	$settings->featured_filter_posts = true;

	$settings->logo_image = '';


	// Blog
//	$settings->posts_per_page = get_option( 'posts_per_page' );
	$settings->posts_per_page = '5';
	$settings->twitter_account = 'none';
	$settings->excluded_categories = '';
	$settings->excluded_tags = '';

	// Pages
	$settings->show_comments_on_pages = false;

	return $settings;
}

function foundation_has_logo_image() {
	$settings = foundation_get_settings();

	return ( $settings->logo_image != '' );
}

function foundation_the_logo_image() {
	$settings = foundation_get_settings();

	echo WPTOUCH_BASE_CONTENT_URL . $settings->logo_image;
}


function foundation_enqueue_admin_scripts() {
//	if ( foundation_is_theme_using_module( 'featured' ) || foundation_is_theme_using_module( 'social-links' ) ) {
		wp_enqueue_script(
			'foundation_admin',
			FOUNDATION_URL . '/admin/foundation-admin.js',
			array( 'jquery', 'wptouch-pro-admin' ),
			FOUNDATION_VERSION,
			true
		);
//	}
}

function foundation_enqueue_color_data() {
	$colors = foundation_get_theme_colors();
	if ( is_array( $colors ) && count( $colors ) ) {
		$inline_color_data = '';

		foreach( $colors as $color ) {
			$settings = wptouch_get_settings( $color->domain );
			$setting_name = $color->setting;
			if ( $color->fg_selectors ) {
				$inline_color_data .= $color->fg_selectors . " { color: " . $settings->$setting_name . "; }\n";
			}

			if ( $color->bg_selectors ) {
				$inline_color_data .= $color->bg_selectors . " { background-color: " . $settings->$setting_name . "; }\n";
			}
		}
		wp_add_inline_style( 'wptouch-parent', $inline_color_data );
	}
}

function foundation_handle_footer() {
	$settings = foundation_get_settings();

	if( $settings->custom_footer_message ) {
		$message = apply_filters( 'foundation_footer_message', $settings->custom_footer_message );

		if ( strip_tags( $message ) == $message ) {
			$output_message = '<p>' . $message . '</p>';
		} else {
			$output_message = $message;
		}

		echo apply_filters( 'foundation_footer_message_output', $output_message );
	}
}

function foundation_get_settings() {
	return wptouch_get_settings( FOUNDATION_SETTING_DOMAIN );
}

function foundation_posts_per_page( $query ) {
	if ( wptouch_is_showing_mobile_theme_on_mobile_device() && ( $query->is_home() || is_archive() ) ) {
		$settings = foundation_get_settings();

		set_query_var( 'posts_per_page', $settings->posts_per_page );
	}
}

function foundation_is_theme_using_module( $module_name ) {
	$theme_data = foundation_get_theme_data();

	return in_array( $module_name, $theme_data->theme_support );
}

function foundation_get_tag_list() {
	$all_tags = array();

	$tags = get_tags();
	foreach( $tags as $tag ) {
		$all_tags[ $tag->slug ] = $tag->name;
	}

	return $all_tags;
}

function foundation_get_category_list() {
	$all_cats = array();

	$categories = get_categories();
	foreach( $categories as $cat ) {
		$all_cats[ $cat->slug ] = $cat->name;
	}

	return $all_cats;
}

function foundation_setup_viewport(){
	if ( wptouch_fdn_is_web_app_mode() ) {
		// iPhone - iPhone 4S
		echo '<meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width" />';
		// iPhone 5
		echo '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" media="(device-height: 568px)" />';
	} else {
		// Standard viewport tag to set the viewport to the device's width, 
		// Android 2.3 devices need this so 100% width works properly and doesn't allow children to blow up the viewport width
		echo '<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, width=device-width" />';
		// iPhone 5
		echo '<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" media="(device-height: 568px)" />';
	}
}

function foundation_render_theme_settings( $page_options ) {
	wptouch_add_sub_page( FOUNDATION_PAGE_GENERAL, 'foundation-page-general', $page_options );
	wptouch_add_sub_page( FOUNDATION_PAGE_BRANDING, 'foundation-page-branding', $page_options );

	$foundation_blog_settings = array(
		wptouch_add_setting(
			'text',
			'posts_per_page',
			__( 'Number of posts in post listings', 'wptouch-pro' ),
			__( 'Overrides the WordPress Reading settings for "Blog pages show at most"', 'wptouch-pro' ),
			WPTOUCH_SETTING_BASIC,
			'1.0'
		),
		wptouch_add_setting(
			'text',
			'excluded_categories',
			__( 'Excluded categories', 'wptouch-pro' ),
			__( 'Comma separated by category name', 'wptouch-pro' ),
			WPTOUCH_SETTING_BASIC,
			'1.0'
		),
		wptouch_add_setting(
			'text',
			'excluded_tags',
			__( 'Excluded tags', 'wptouch-pro' ),
			__( 'Comma separated by tag name', 'wptouch-pro' ),
			WPTOUCH_SETTING_BASIC,
			'1.0'
		),
	);

	$foundation_blog_settings = apply_filters( 'foundation_settings_blog', $foundation_blog_settings );

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Blog', 'wptouch-pro' ),
		'foundation-web-theme-settings',
		$foundation_blog_settings,
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	$foundation_page_settings = array(
		wptouch_add_setting(
			'checkbox',
			'show_comments_on_pages',
			__( 'Show comments on pages', 'wptouch-pro' ),
			__( 'Overrides the WordPress settings for showing comments on pages.', 'wptouch-pro' ),
			WPTOUCH_SETTING_BASIC,
			'1.0'
		)	
	);	

	$foundation_page_settings = apply_filters( 'foundation_settings_pages', $foundation_page_settings );

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Pages', 'wptouch-pro' ),
		'foundation-pages',
		$foundation_page_settings,
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);
	

	if ( foundation_is_theme_using_module( 'twitter' ) ) {
		if ( defined( 'WORDTWIT_WPTOUCH_PRO_EXT' ) ) {
			$twitter_accounts = array( 'none' => __( 'Disabled', 'wptouch-pro' ) );

			$accounts = wordtwit_wptouch_get_accounts();
			foreach( $accounts as $name => $account ) {
				$twitter_accounts[ $name ] = $name;
			}

			wptouch_add_page_section(
				FOUNDATION_PAGE_GENERAL,
				'Twitter',
				'foundation-web-mobile-twitter',
				array(
					wptouch_add_setting(
						'list',
						'twitter_account',
						__( 'Twitter account to use for Tweet display', 'wptouch-pro' ),
						'',
						WPTOUCH_SETTING_BASIC,
						'1.0',
						$twitter_accounts
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);
		}
	}

	if ( foundation_is_theme_using_module( 'media' ) ) {
		wptouch_add_page_section(
			FOUNDATION_PAGE_GENERAL,
			__( 'Video Handling', 'wptouch-pro' ),
			'foundation-media-settings',
			array(
				wptouch_add_setting(
					'list',
					'video_handling_type',
					'',
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					array(
						'none' => __( 'None', 'wptouch-pro' ),
						'css' => __( 'CSS only (HTML5 videos)', 'wptouch-pro' ),
						'fitvids' => __( 'FitVids Method', 'wptouch-pro' ),
						'fluidvids' => __( 'Fluid-Width Method', 'wptouch-pro' )
					)
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
	}

	if ( foundation_is_theme_using_module( 'featured' ) ) {
		wptouch_add_page_section(
			FOUNDATION_PAGE_GENERAL,
			__( 'Featured Slider', 'wptouch-pro' ),
			'foundation-featured-settings',
			array(
				wptouch_add_setting(
					'checkbox',
					'featured_enabled',
					__( 'Enable featured slider', 'wptouch-pro' ),
					__( 'Requires at least 2 entries to contain featured images', 'wptouch-pro' ),
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_setting(
					'checkbox',
					'featured_continuous',
					__( 'Continuously slide', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0.2'
				),
				wptouch_add_setting(
					'checkbox',
					'featured_grayscale',
					__( 'Grayscale images (CSS 3 effect)', 'wptouch-pro' ),
					__( 'Featured slider images will be in grayscale for devices that support CSS filters.', 'wptouch-pro' ),
					WPTOUCH_SETTING_ADVANCED,
					'1.0'
				),
				wptouch_add_setting(
					'checkbox',
					'featured_filter_posts',
					__( 'Featured slider posts also show in listings', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0.3'
				),				
				wptouch_add_setting(
					'checkbox',
					'featured_autoslide',
					__( 'Automatically slide', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0.2'
				),
				wptouch_add_setting(
					'list',
					'featured_speed',
					__( 'Slide transition speed', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0.2',
					array(
						'slow' => __( 'Slow', 'wptouch-pro' ),
						'normal' => __( 'Normal', 'wptouch-pro' ),
						'fast' => __( 'Fast', 'wptouch-pro' )
					)
				),
				wptouch_add_setting(
					'list',
					'featured_type',
					'',
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					array(
						'latest' => __( 'Show latest posts', 'wptouch-pro' ),
						'tag' => __( 'Show posts from a specific tag', 'wptouch-pro' ),
						'category' => __( 'Show posts from a specific category', 'wptouch-pro' ),
						'posts' => __( 'Show only specific posts or pages', 'wptouch-pro' )
					)
				),
				wptouch_add_setting(
					'list',
					'featured_tag',
					__( 'Only this tag', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					foundation_get_tag_list()
				),
				wptouch_add_setting(
					'list',
					'featured_category',
					__( 'Only this category', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					foundation_get_category_list()
				),
				wptouch_add_setting(
					'text',
					'featured_post_ids',
					__( 'Comma-separated list of post/page IDs', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				)
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
	}

	if ( foundation_is_theme_using_module( 'webapp' ) ) {
		wptouch_add_sub_page( FOUNDATION_PAGE_WEB_APP, 'foundation-page-webapp', $page_options );

		wptouch_add_page_section(
			FOUNDATION_PAGE_WEB_APP,
			__( 'Settings', 'wptouch-pro' ),
			'foundation-web-app-settings',
			array(
				wptouch_add_setting( 'checkbox', 'webapp_mode_enabled', __( 'Enable Web-App Mode', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting(
					'checkbox',
					'webapp_enable_persistence',
					__( 'Enable persistence', 'wptouch-pro' ),
					__( 'WPtouch loads the last visited page or post for visitors in Web-App Mode.', 'wptouch-pro' ),
					WPTOUCH_SETTING_BASIC,
					'1.0.2'
				),
				wptouch_add_setting(
					'textarea',
					'webapp_ignore_urls',
					__( 'URLs to ignore in Web-App Mode', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0.2'
				)

			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_WEB_APP,
			__( 'Notice Message', 'wptouch-pro' ),
			'notice-message',
			array(
				wptouch_add_setting( 'checkbox', 'webapp_show_notice', __( 'Show a notice message for iPhone, iPod touch & iPad visitors about my Web-App', 'wptouch-pro' ), __( 'WPtouch shows a notice bubble on 1st visit letting users know about your Web-App enabled website on iOS devices.', 'wptouch-pro' ), WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'textarea', 'webapp_notice_message', __( 'Notice message contents', 'wptouch-pro' ), __( '[device] and [icon] are dynamic and used to determine the device and iOS version. Do not remove these from your message.', 'wptouch-pro' ), WPTOUCH_SETTING_ADVANCED, '1.0' ),
				wptouch_add_setting(
					'list',
					'webapp_notice_expiry_days',
					__( 'the notice message will be shown again for visitors', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_ADVANCED,
					'1.0',
					array(
						'1' => __( '1 day until', 'wptouch-pro' ),
						'7' => __( '7 days until', 'wptouch-pro' ),
						'30' => __( '1 month until', 'wptouch-pro' ),
						'0' => __( 'Every time', 'wptouch-pro' )
					)
				)
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		/* Startup Screen Area */
		wptouch_add_page_section(
			FOUNDATION_PAGE_WEB_APP,
			__( 'iPhone Startup Screen', 'wptouch-pro' ),
			'iphone-startup-screen',
			array(
				wptouch_add_setting(
					'image-upload',
					'startup_screen_iphone_2g_3g',
					sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 320, 460 ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_WEB_APP,
			__( 'Retina iPhone Startup Screen', 'wptouch-pro' ),
			'retina-iphone-startup-screen',
			array(
				wptouch_add_setting(
					'image-upload',
					'startup_screen_iphone_4_4s',
					sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 640, 920 ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_WEB_APP,
			__( 'iPhone 5 Startup Screen', 'wptouch-pro' ),
			'iphone-5-startup-screen',
			array(
				wptouch_add_setting(
					'image-upload',
					'startup_screen_iphone_5',
					sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 640,1096 ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		if ( foundation_is_theme_using_module( 'tablets' ) ) {
			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'iPad Mini and iPad Startup Screens', 'wptouch-pro' ),
				'ipad-mini-and-ipad-startup-screens',
				array(
					wptouch_add_setting(
						'image-upload',
						'startup_screen_ipad_1_portrait',
						sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 768, 1004 ),
						'',
						WPTOUCH_SETTING_BASIC,
						'1.0'
					),
					wptouch_add_setting(
						'image-upload',
						'startup_screen_ipad_1_landscape',
						sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 1024, 748 ),
						'',
						WPTOUCH_SETTING_BASIC,
						'1.0'
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);

			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Retina iPad Startup Screens', 'wptouch-pro' ),
				'retina-ipad-startup-screens',
				array(
					wptouch_add_setting(
						'image-upload',
						'startup_screen_ipad_3_portrait',
						sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 1536, 2008 ),
						'',
						WPTOUCH_SETTING_BASIC,
						'1.0'
					),
					wptouch_add_setting(
						'image-upload',
						'startup_screen_ipad_3_landscape',
						sprintf( __( '%d by %d pixels (PNG)', 'wptouch-pro' ), 2048, 1496 ),
						'',
						WPTOUCH_SETTING_BASIC,
						'1.0'
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);
		}
	}

	wptouch_add_sub_page( FOUNDATION_PAGE_HOMESCREEN_ICONS, 'foundation-page-homescreen-icons', $page_options );

	/* Homescreen Icon Area */

	wptouch_add_page_section(
		FOUNDATION_PAGE_HOMESCREEN_ICONS,
		__( 'Options', 'wptouch-pro' ),
		'admin_menu_homescreen_icons_options',
		array(
			wptouch_add_setting(
				'text',
				'homescreen_icon_title',
				__( 'Icon title', 'wptouch-pro' ),
				__( 'When visitors bookmark your website, this will be the title shown.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'checkbox',
				'enable_glossy_icons',
				__( 'Add glossy icon effect to uploaded icons', 'wptouch-pro' ),
				__( 'A glossy effect will automatically be applied to icons for iOS devices.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
		),
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_HOMESCREEN_ICONS,
		__( 'iPhone/Android', 'wptouch-pro' ),
		'admin_menu_homescreen_iphone_android',
		array(
			wptouch_add_setting(
				'image-upload',
				'iphone_icon',
				sprintf( __( '%d by %d pixels', 'wptouch-pro' ), 57, 57 ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
		),
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_HOMESCREEN_ICONS,
		__( 'iPhone/Android Retina', 'wptouch-pro' ),
		'admin_menu_homescreen_iphone_android_retina',
		array(
			wptouch_add_setting(
				'image-upload',
				'iphone_icon_retina',
				sprintf( __( '%d by %d pixels', 'wptouch-pro' ), 114, 114 ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
		),
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	if ( foundation_is_theme_using_module( 'tablets' ) ) {
		wptouch_add_page_section(
			FOUNDATION_PAGE_HOMESCREEN_ICONS,
			__( 'iPad', 'wptouch-pro' ),
			'admin_menu_homescreen_ipad',
			array(
				wptouch_add_setting(
					'image-upload',
					'ipad_icon',
					sprintf( __( '%d by %d pixels', 'wptouch-pro' ), 72, 72 ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_HOMESCREEN_ICONS,
			__( 'iPad Retina', 'wptouch-pro' ),
			'admin_menu_homescreen_ipad_retina',
			array(
				wptouch_add_setting(
					'image-upload',
					'ipad_icon_retina',
					sprintf( __( '%d by %d pixels', 'wptouch-pro' ), 144, 144 ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
	}

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Theme Footer', 'wptouch-pro' ),
		'foundation-custom-content',
		array(
			wptouch_add_setting( 'textarea', 'custom_footer_message', __( 'Custom footer content (HTML is allowed)', 'wptouch-pro' ), __( 'You can add custom footer content that will be displayed below the switch link.', 'wptouch-pro' ), WPTOUCH_SETTING_BASIC, '1.0' )
		),
		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	if ( foundation_is_theme_using_module( 'advertising' ) ) {
		wptouch_add_sub_page( FOUNDATION_PAGE_ADVERTISING, 'foundation-page-advertising', $page_options );

		wptouch_add_page_section(
			FOUNDATION_PAGE_ADVERTISING,
			__( 'Service', 'wptouch-pro' ),
			'service',
			array(
				wptouch_add_setting(
					'radiolist',
					'advertising_type',
					__( 'Choose a service', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					array(
						'none' => __( 'None', 'wptouch-pro' ),
						'google' => __( 'Google Adsense', 'wptouch-pro' ),
						'custom' => _x( 'Custom', 'Refers to a custom advertising service', 'wptouch-pro' )
					)
				)
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_ADVERTISING,
			__( 'Google AdSense', 'wptouch-pro' ),
			'google-adsense',
			array(
				wptouch_add_setting( 'text', 'google_adsense_id', __( 'Publisher ID', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'text', 'google_slot_id', __( 'Slot ID', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' )
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			FOUNDATION_PAGE_ADVERTISING,
			__( 'Custom Ads', 'wptouch-pro' ),
			'custom-ads',
			array(
				wptouch_add_setting( 'textarea', 'custom_advertising_mobile', __( 'Mobile advertising script', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' )
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);


		wptouch_add_page_section(
			FOUNDATION_PAGE_ADVERTISING,
			__( 'Ad Presentation', 'wptouch-pro' ),
			'ad-presentation',
			array(
				wptouch_add_setting(
					'list',
					'advertising_location',
					__( 'Theme location', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0',
					array(
						'header' => __( 'In the header', 'wptouch-pro' ),
						'top-content' => __( 'Above the page content', 'wptouch-pro' ),
						'bottom-content' => __( 'Below the page content', 'wptouch-pro' )
					//	'footer' => __( 'In the footer', 'wptouch-pro' )
					)
				),
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
		wptouch_add_page_section(
			FOUNDATION_PAGE_ADVERTISING,
			__( 'Active Pages', 'wptouch-pro' ),
			'active-pages',
			array(
				wptouch_add_setting( 'checkbox', 'advertising_blog_listings', __( 'Blog listings', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'checkbox', 'advertising_single', __( 'Single posts', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'checkbox', 'advertising_pages', __( 'Static pages', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'checkbox', 'advertising_taxonomy', __( 'Taxonomy', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' ),
				wptouch_add_setting( 'checkbox', 'advertising_search', __( 'Search results', 'wptouch-pro' ), '', WPTOUCH_SETTING_BASIC, '1.0' )
			),
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
	}

	if ( foundation_has_theme_colors() ) {
		$color_settings = array();

		$colors = foundation_get_theme_colors();

		foreach( $colors as $name => $color ) {
			$color_settings[] = wptouch_add_setting(
				'color',
				$color->setting,
				$color->desc,
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0',
				'',
				$color->domain
			);
		}

		wptouch_add_page_section(
			FOUNDATION_PAGE_BRANDING,
			__( 'Theme Colors', 'wptouch-pro' ),
			'foundation-colors',
			$color_settings,
			$page_options,
			FOUNDATION_SETTING_DOMAIN
		);
	}

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Site Logo', 'wptouch-pro' ),
		'foundation-logo',
		array(
			wptouch_add_setting(
				'image-upload',
				'logo_image',
				__( '(Scaled by themes to fit logo areas as needed)', 'wptouch-pro' ),
				'',
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Browser Behaviour', 'wptouch-pro' ),
		'browser-behaviour',
		array(
			wptouch_add_setting(
				'checkbox',
				'hide_address_bar',
				__( 'Hide browser address-bar on page load', 'wptouch-pro' ),
				__( 'Hides the browser address bar so that more of the mobile theme interface is shown.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Smart App Banner', 'wptouch-pro' ),
		'foundation-smart-app-banner',
		array(
			wptouch_add_setting(
				'text',
				'smart_app_banner',
				sprintf( __( 'Enter your app\'s %sApp Store ID%s', 'wptouch-pro' ), '<a href="http://itunes.apple.com/linkmaker/" target="_blank">', '</a>' ),
				__( 'Your app\'s unique identifier. Find your ID from the iTunes Link Maker: Search for your app. In the link it provides, your app ID is the nine-digit number in between id and ?mt. For example Angry Birds\'s ID is 343200656.', 'wptouch-pro' ),
				WPTOUCH_SETTING_ADVANCED,
				'1.0'
			),
		),

		$page_options,
		FOUNDATION_SETTING_DOMAIN
	);

	// No settings added to this by Foundation
	wptouch_add_sub_page( FOUNDATION_PAGE_CUSTOM, 'foundation-page-custom', $page_options );

	return $page_options;
}

function foundation_maybe_output_homescreen_icon( $image, $width, $height, $precomposed = 0, $pixel_ratio = 1 ) {
	$settings = foundation_get_settings();

	if ( $image ) {
		$precomposed_string = '-precomposed';
		if ( $settings->enable_glossy_icons ) {
		$precomposed_string = '';
		}

		if ( $width != 57 ) {
			$size_string = ' sizes="' . $width . 'x' . $height . '"';
		} else {
			$size_string = '';
		}

		echo '<link rel="apple-touch-icon' . $precomposed_string . '"' . $size_string . ' href="' . WPTOUCH_BASE_CONTENT_URL . $image  . '" />' . "\n";
	}
}

function foundation_setup_homescreen_icons() {
	$settings = foundation_get_settings();

	if ( wptouch_is_device_real_ipad() ) {
		// ipad home screen icons
		foundation_maybe_output_homescreen_icon( $settings->ipad_icon_retina, 144, 144, $settings->enable_glossy_icons, 2 );
		foundation_maybe_output_homescreen_icon( $settings->ipad_icon, 72, 72, $settings->enable_glossy_icons );
	} else {
		// iphone home screen icons
		foundation_maybe_output_homescreen_icon( $settings->iphone_icon_retina, 114, 114, $settings->enable_glossy_icons, 2 );
		foundation_maybe_output_homescreen_icon( $settings->iphone_icon, 57, 57, $settings->enable_glossy_icons );
	}
}

function foundation_setup_smart_app_banner(){
	$settings = foundation_get_settings();
	if ( $settings->smart_app_banner ) {
		echo '<meta name="apple-itunes-app" content="app-id=' . $settings->smart_app_banner . '">' . "\n";
	}
}

// Child Theme Functions

global $foundation_data;

add_action( 'init', 'foundation_signal_module_init' );
add_action( 'wptouch_root_functions_loaded', 'foundation_theme_init' );

function foundation_signal_module_init() {
	// Themes will tie into this to add theme support
	do_action( 'foundation_module_init' );
	do_action( 'foundation_enqueue_scripts' );

	if ( wptouch_is_showing_mobile_theme_on_mobile_device() ) {
		do_action( 'foundation_module_init_mobile' );
		do_action( 'foundation_enqueue_scripts_mobile' );
		do_action( 'foundation_enqueue_color_scripts' );
	}
}

function foundation_init_data() {
	global $foundation_data;

	$foundation_data = new stdClass;

	// The base module is always loaded; don't change this as horrible things will happen
	$foundation_data->theme_support = apply_filters(  'wptouch_theme_support', array( 'base' ) );
}

function foundation_get_theme_data() {
	global $foundation_data;

	return $foundation_data;
}

function foundation_set_theme_data( $theme_data ) {
	global $foundation_data;

	$foundation_data = $theme_data;
}

function foundation_load_theme_modules() {
	$settings = foundation_get_settings();

	$theme_data = foundation_get_theme_data();
	if ( count( $theme_data->theme_support ) ) {
		foreach( $theme_data->theme_support as $module ) {
			if ( $module == 'featured' && !$settings->featured_enabled ) {
				continue;
			}

			$bootstrap_file = dirname( __FILE__ ) . '/modules/' . $module . '/' . $module . '.php';

			if ( file_exists( $bootstrap_file ) ) {
				// Load the main bootstrap file
				require_once( $bootstrap_file );

				$defined_name = 'WPTOUCH_MODULE_' . str_replace( '-', '_', strtoupper( $module ) ) . '_INSTALLED';
				define( $defined_name, '1' );
			}
		}

		// Force settings to be reloaded
		global $wptouch_pro;
		$wptouch_pro->invalidate_settings();
	}
}

function foundation_theme_init() {
	foundation_init_data();

	do_action( 'foundation_init' );

	foundation_load_theme_modules();

	// Actions that happen immediately after the modules are loaded
	do_action( 'foundation_modules_loaded' );
	if ( wptouch_is_showing_mobile_theme_on_mobile_device() ) {
		do_action( 'foundation_modules_loaded_mobile' );
	}
}

function foundation_add_theme_support( $theme_support ) {
	$theme_data = foundation_get_theme_data();

	if ( is_array( $theme_support ) ) {
		foreach( $theme_support as $module ) {
			if ( !in_array( $module, $theme_data->theme_support ) ) {
				 $theme_data->theme_support[] = $module;
			}
		}
	} else {
		if ( !in_array( $theme_support, $theme_data->theme_support ) ) {
			 $theme_data->theme_support[] = $theme_support;
		}
	}
}

function foundation_body_classes( $classes ) {
	$settings = foundation_get_settings();


	if ( $settings->hide_address_bar && ( $settings->advertising_type = 'none' || !$settings->advertising_location = 'header' || $settings->smart_app_banner == false ) ) {
		$classes[] = 'hide-address-bar';
	}

	if ( $settings->video_handling_type != 'none' ) {
		$classes[] = 'css-videos';
	}

	if ( $settings->typography_sets != 'default' ) {
		$classes[] = 'body-font';
	}

	if ( isset( $_COOKIE['wptouch-device-type'] ) ) {
		if ( $_COOKIE['wptouch-device-type'] == 'smartphone' ) {
			$classes[] = 'smartphone';
		} else if ( $_COOKIE['wptouch-device-type'] == 'tablet' ) {
			$classes[] = 'tablet';
		}
	}

	if ( isset( $_COOKIE['wptouch-device-orientation'] ) ) {
		if ( $_COOKIE['wptouch-device-orientation'] == 'portrait' ) {
			$classes[] = 'portrait';
		} else if ( $_COOKIE['wptouch-device-orientation'] == 'landscape' ) {
			$classes[] = 'landscape';
		}
	}
	
	// iOS Device
	if ( strpos( $_SERVER['HTTP_USER_AGENT'],'iPhone' ) || strpos( $_SERVER['HTTP_USER_AGENT'],'iPod' ) || strpos( $_SERVER['HTTP_USER_AGENT'],'iPad' ) ) {
			$classes[] = 'ios';		
	}

	// Android Device
	if ( strpos( $_SERVER['HTTP_USER_AGENT'],'Android' ) ) {
			$classes[] = 'android';		
	}
	
	if ( wptouch_should_load_rtl() ) {
		$classes[] = 'rtl';
	}

	return $classes;
}

function foundation_get_base_url() {
	return WPTOUCH_URL . '/themes/foundation';
}

function foundation_get_base_module_url() {
	return WPTOUCH_URL . '/themes/foundation/modules';
}

global $foundation_registered_colors;
$foundation_registered_colors = array();

function foundation_register_theme_color( $setting_name, $desc, $fg_selectors, $bg_selectors, $domain = FOUNDATION_SETTING_DOMAIN ) {
	$theme_color = new stdClass;

	$theme_color->setting = $setting_name;
	$theme_color->desc = $desc;
	$theme_color->fg_selectors = $fg_selectors;
	$theme_color->bg_selectors = $bg_selectors;
	$theme_color->domain = $domain;

	global $foundation_registered_colors;
	$foundation_registered_colors[ $setting_name ] = $theme_color;
}

function foundation_has_theme_colors() {
	global $foundation_registered_colors;

	return count( $foundation_registered_colors );
}

function foundation_get_theme_colors() {
	global $foundation_registered_colors;

	return $foundation_registered_colors;
}

/* Foundation Functions (can be used by all child themes) */

/*
If we're on iOS5 or higher.

We'll setup media queries for client side detection of
css features for fixed positioning ( -webkit-overflow-scrolling ),
but if server-side iOS5/6 detection is needed, it's here  :)
*/
function wptouch_fdn_iOS_5_or_higher() {
	if ( strpos( $_SERVER['HTTP_USER_AGENT'],'OS 5_' ) || strpos( $_SERVER['HTTP_USER_AGENT'],'OS 6_' ) ) {
		return true;
	} else {
		return false;
	}
}

/*
Detects if we're in Web-App mode.

Caveats: Returns true in some other iOS browsers.
Can also probably be turned into a media query,
where we look for the browser window height in
addition to it being an iOS device.
*/
function wptouch_fdn_is_web_app_mode(){
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) === false &&
	( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) || strpos( $_SERVER['HTTP_USER_AGENT'], 'iPod' ) || strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) ) {
		return true;
	} else {
		return false;
	}
}


/* If there are more comments than the pagination setting, we know we should show the pagination links */
function wptouch_fdn_comments_pagination() {
	if ( get_option( 'comments_per_page' ) < wptouch_get_comment_count() ) {
		return true;
	} else {
		return false;
	}
}

/* Previous + Next Post Functions For Single Post Pages */
function wptouch_fdn_get_previous_post_link() {
//	$settings = wptouch_get_settings();

//	$prev_post = get_adjacent_post( false, $settings->classic_excluded_categories );
	$prev_post = get_adjacent_post( false, '', TRUE );
	echo get_permalink( $prev_post->ID );
}

function wptouch_fdn_get_next_post_link() {
//	$settings = wptouch_get_settings();

//	$next_post = get_adjacent_post( false, $settings->classic_excluded_categories, 0 );
	$next_post = get_adjacent_post( false, '', FALSE );
	echo get_permalink( $next_post->ID );
}

function wptouch_fdn_if_next_post_link(){
	$next_post = get_adjacent_post( false, '', FALSE );

	if ( $next_post ) {
		return true;
	} else {
		return false;
	}
}

function wptouch_fdn_if_previous_post_link(){
	$prev_post = get_adjacent_post( false, '', TRUE );

	if ( $prev_post ) {
		return true;
	} else {
		return false;
	}
}

function wptouch_fdn_show_comments_on_pages() {
	$settings = foundation_get_settings();
	if ( comments_open() && !post_password_required() && $settings->show_comments_on_pages ) {
		return true;
	} else {
		return false;
	}
}

// Dynamic archives heading text for archive result pages, and search
function wptouch_fdn_archive_title_text() {
	global $wp_query;
	$total_results = $wp_query->found_posts;

	if ( !( is_home() || is_single() ) ) {
		echo '<div class="archive-text">';
	}
	if ( is_search() ) {
		echo $total_results . '&nbsp;';
	echo sprintf( __( "search results for '%s'", "wptouch-pro" ), get_search_query() );
	} if ( is_category() ) {
		echo sprintf( __( "%sCategories &rsaquo;%s %s", "wptouch-pro" ), '<span class="type">',  '</span>', single_cat_title( "", false ) );
	} elseif ( is_tag() ) {
		echo sprintf( __( "Tags &rsaquo; %s", "wptouch-pro" ), single_tag_title(" ", false ) );
	} elseif ( is_day() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'F jS, Y' ) );
	} elseif ( is_month() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'F, Y' ) );
	} elseif ( is_year() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'Y' ) );
	} elseif ( get_post_type() ) {
//		echo get_post_type( $post->ID );
	}
	if ( !( is_home() || is_single() ) ) {
		echo '</div>';
	}
}

// Dynamic archives Load More text
function wptouch_fdn_archive_load_more_text() {
	global $wp_query;
	$total_results = $wp_query->found_posts;

	if ( is_category() ) {
		echo( __( 'Load more from this category', 'wptouch-pro' ) );
	} elseif ( is_tag() ) {
		echo( __( 'Load more tagged like this', 'wptouch-pro' ) );
	} elseif ( is_day() ) {
		echo( __( 'Load more from this day', 'wptouch-pro' ) );
	} elseif ( is_month() ) {
		echo( __( 'Load more from this month', 'wptouch-pro' ) );
	} elseif ( is_year() ) {
		echo( __( 'Load more from this year', 'wptouch-pro' ) );
	} elseif ( get_post_type() == 1 ) {
		echo( __( 'Load more in this section', 'wptouch-pro' ) );
	} else {
		echo( __( 'Load more entries', 'wptouch-pro' ) );
	}
}

function wptouch_fdn_ordered_cat_list( $num, $include_count = true ) {
	global $wpdb;

	$settings = wptouch_get_settings( 'foundation' );

	$excluded_cats = 0;
	if ( $settings->excluded_categories ) {
		$new_cats = _foundation_explode_and_trim_taxonomy( $settings->excluded_categories, 'category' );

		if ( is_array( $new_cats ) && count ( $new_cats ) ) {
			$excluded_cats = implode( ',', $new_cats );
		}
	}

	echo '<ul>';
	$sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id WHERE taxonomy = 'category' AND {$wpdb->prefix}term_taxonomy.term_id NOT IN ($excluded_cats) AND count >= 1 ORDER BY count DESC LIMIT 0, $num");

	if ( $sql ) {
		foreach ( $sql as $result ) {
			if ( $result ) {
				echo "<li><a href=\"" . get_category_link( $result->term_id ) . "\">" . $result->name;

				if ( $include_count ) {
					echo " <span>(" . $result->count . ")</span></a>";
				}

				echo '</a>';
				echo '</li>';
			}
		}
	}
	echo '</ul>';
}

function wptouch_fdn_ordered_tag_list( $num ) {
	global $wpdb;

	$settings = wptouch_get_settings( 'foundation' );

	$excluded_tags = 0;
	if ( $settings->excluded_tags ) {
		$new_tags = _foundation_explode_and_trim_taxonomy( $settings->excluded_tags, 'post_tag' );

		if ( is_array( $new_tags ) && count ( $new_tags ) ) {
			$excluded_tags = implode( ',', $new_tags );
		}
	}

	echo '<ul>';

	$sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id WHERE taxonomy = 'post_tag' AND {$wpdb->prefix}term_taxonomy.term_id NOT IN ($excluded_tags) AND count >= 1 ORDER BY count DESC LIMIT 0, $num");

	if ( $sql ) {
		foreach ( $sql as $result ) {
			if ( $result ) {
				echo "<li><a href=\"" . get_tag_link( $result->term_id ) . "\">" . $result->name . " <span>(" . $result->count . ")</span></a></li>";
			}
		}
	}
	echo '</ul>';
}

function wptouch_fdn_display_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	extract( $args, EXTR_SKIP );

	locate_template( 'one-comment.php', true, false );
}

function wptouch_fdn_get_search_post_types() {
	return apply_filters( 'foundation_search_post_types', array( 'post', 'page' ) );
}

function wptouch_fdn_get_search_post_type() {
	global $search_post_type;

	switch( $search_post_type ) {
		case 'post':
			return __( 'Post', 'wptouch-pro' );
		case 'page':
			return __( 'Page', 'wptouch-pro' );
		default:
			return apply_filters( 'wptouch_foundation_search_post_type_text', $search_post_type );
	}
}

function _foundation_explode_and_trim_taxonomy( $tax, $tax_type ) {
	$cats = explode( ',', $tax );
	$new_cats = array();

	foreach( $cats as $cat ) {
		$trimmed_cat = trim( $cat );
		if ( is_numeric( $trimmed_cat ) ) {
			$new_cats[] = $trimmed_cat;
		} else {
			$term_data = get_term_by( 'name', $trimmed_cat, $tax_type );
			if ( $term_data ) {
				$new_cats[] = $term_data->term_id;
			}
		}
	}

	return $new_cats;
}

function foundation_exclude_categories_tags( $query ) {
	if ( wptouch_is_mobile_theme_showing() ) {
		$settings = foundation_get_settings();

		if ( $settings->excluded_categories ) {
			$new_cats = _foundation_explode_and_trim_taxonomy( $settings->excluded_categories, 'category' );

			if ( !$query->is_single() ) {
				$query->set( 'category__not_in', $new_cats );
			}
		}

		if ( $settings->excluded_tags ) {
			$new_tags = _foundation_explode_and_trim_taxonomy( $settings->excluded_tags, 'post_tag' );

			if ( !$query->is_single() ) {
				$query->set( 'tag__not_in', $new_tags );
			}
		}
	}
	return $query;
}

function foundation_insert_multipage_links( $content ) {
	$multipage_links = wp_link_pages( 'before=<div class="wp-page-nav">' . __( 'Pages', 'wptouch-pro' ) . ':&after=</div>&echo=0' );
	if( !is_feed() && !is_home() ) {
		return $content . $multipage_links;
	} else {
		return $content;
	}
}

function foundation_number_of_posts_to_show() {
	$settings = wptouch_get_settings( 'foundation' );
	$num_posts = $settings->posts_per_page;
	return $num_posts;	
}