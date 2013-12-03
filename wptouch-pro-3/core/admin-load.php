<?php

define( 'WPTOUCH_PRO_ADMIN_SETTINGS_PAGE', 0 );
define( 'WPTOUCH_PRO_ADMIN_CUSTOM_PAGE', 1 );

require_once( WPTOUCH_DIR . '/core/admin-menu.php' );

function wptouch_admin_menu_get_nonce() {
	return wp_create_nonce( 'admin_nonce' );
}

function wptouch_admin_menu_the_nonce() {
	echo wptouch_admin_get_nonce();
}

function wptouch_admin_menu_nonce_is_valid( $nonce ) {
	return wp_verify_nonce( $nonce, 'admin_nonce' );
}

function wptouch_admin_build_menu() {
	$settings = wptouch_get_settings();

	$available_menus = wptouch_admin_get_predefined_menus();

	// Add the main plugin menu for WPtouch Pro
	add_menu_page(
		'WPtouch Pro',
		'WPtouch Pro',
		'manage_options',
		wptouch_admin_get_root_slug(),
		'',
		WPTOUCH_ADMIN_URL . '/images/wptouch-admin-icon.png'
	);

	// Iterate through available menus
	foreach( $available_menus as $id => $menu ) {
		add_submenu_page(
			$available_menus[ wptouch_admin_get_root_slug() ]->slug,
			$menu->friendly_name,
			$menu->friendly_name,
			'manage_options',
			$menu->slug,
			'wptouch_admin_render_menu'
		);
	}
}

function wptouch_add_sub_page( $sub_page_name, $sub_page_slug, &$options ) {
	$sub_page_info = new stdClass;
	$sub_page_info->name = $sub_page_name;
	$sub_page_info->slug = $sub_page_slug;
	$sub_page_info->sections = array();

	$options[ $sub_page_name ] = $sub_page_info;
}

function wptouch_add_page_section( $sub_page_name, $section_name, $section_slug, $section_settings, &$options, $domain = 'wptouch_pro' ) {
	$section = new stdClass;

	if ( isset( $options[ $sub_page_name ] ) ) {
		$section->sub_page_name = $sub_page_name;
		$section->name = $section_name;
		$section->slug = $section_slug;
		$section->settings = $section_settings;
		$section->domain = $domain;

		// Populate domain on default settings
		foreach( $section->settings as $setting ) {
			if ( !$setting->domain ) {
				$setting->domain = $section->domain;
			}
		}

		$options[ $sub_page_name ]->sections[] = $section;
	}
}

function wptouch_add_setting( $type, $name, $desc = '', $tooltip = '', $level = WPTOUCH_SETTING_BASIC, $version = false, $extra = false, $domain = '' ) {
	$setting = new stdClass;

	$setting->type = $type;
	$setting->name = $name;
	$setting->desc = $desc;
	$setting->level = $level;
	$setting->tooltip = $tooltip;
	$setting->version = $version;
	$setting->extra = $extra;
	$setting->domain = $domain;

	return $setting;
}

function wptouch_admin_render_menu() {
	global $panel_options;
	global $wptouch_panel_slug;

	// Determine which menu generated this page
	$page_name = $_GET[ 'page' ];
	$admin_panel_name = $page_name . '.php';

	$wptouch_panel_slug = $page_name;

	if ( file_exists( WPTOUCH_ADMIN_DIR . '/pages/' . $admin_panel_name ) ) {
		require_once( WPTOUCH_ADMIN_DIR . '/pages/' . $admin_panel_name );
	}

	$panel_options = apply_filters( 'wptouch_admin_page_render_' . $page_name, array() );

	include( WPTOUCH_DIR . '/core/admin-render.php' );
}

function wptouch_admin_can_render_setting( $setting ) {
	// Check the admin complexity level, i.e. Beginner, Advanced
	$admin_level = wptouch_get_quick_setting_value( 'wptouch_pro', 'settings_mode' );

	return ( $admin_level >= $setting->level );
}

function wptouch_admin_render_setting( $setting ) {
	require_once( WPTOUCH_DIR . '/core/settings.php' );

	// Check if this is a custom setting
	if ( $setting->type == 'custom' ) {
		return wptouch_admin_render_special_setting( $setting );
	}

	$setting_filename = $setting->type . '.php';
	if ( file_exists( WPTOUCH_ADMIN_DIR . '/settings/default/html/' . $setting_filename ) ) {
		wptouch_admin_prime_setting_for_display( $setting );

		// Load associated setting code if it exists
		if ( file_exists( WPTOUCH_ADMIN_DIR . '/settings/default/include/' . $setting_filename ) ) {
			require_once( WPTOUCH_ADMIN_DIR . '/settings/default/include/' . $setting_filename );
		}

		include( WPTOUCH_ADMIN_DIR . '/settings/default/html/' . $setting_filename );
	} else {
		do_action( 'wptouch_admin_render_setting', $setting );
	}
}

function wptouch_admin_render_special_setting( $setting ) {
	require_once( WPTOUCH_DIR . '/core/settings.php' );

	if ( $setting->type == 'custom' ) {
		$setting_filename = $setting->name . '.php';

		if ( file_exists( WPTOUCH_ADMIN_DIR . '/settings/custom/html/' . $setting_filename ) ) {
			wptouch_admin_prime_setting_for_display( $setting );

			// Load associated setting code if it exists
			if ( file_exists( WPTOUCH_ADMIN_DIR . '/settings/custom/include/' . $setting_filename ) ) {
				require_once( WPTOUCH_ADMIN_DIR . '/settings/custom/include/' . $setting_filename );
			}

			include( WPTOUCH_ADMIN_DIR . '/settings/custom/html/' . $setting_filename );
		}
	}
}

function wptouch_admin_get_menu_friendly_name( $slug = false ) {
	if ( !$slug ) {
		global $wptouch_panel_slug;
		$slug = $wptouch_panel_slug;
	}

	$menu_pages = wptouch_admin_get_predefined_menus();
	$friendly_name = '';

	foreach( $menu_pages as $page ) {
		if ( $page->slug == $slug ) {
			if ( $page->display_name ) {
				$friendly_name = $page->display_name;
			} else {
				$friendly_name = $page->friendly_name;
			}
			break;
		}
	}

	return $friendly_name;
}

function wptouch_admin_the_menu_friendly_name( $slug = false ) {
	echo wptouch_admin_get_menu_friendly_name( $slug );
}

function wptouch_admin_is_custom_page( $slug = false ) {
	if ( !$slug ) {
		global $wptouch_panel_slug;
		$slug = $wptouch_panel_slug;
	}

	$menu_pages = wptouch_admin_get_predefined_menus();

	if ( isset( $menu_pages[ $slug ] ) ) {
		return ( $menu_pages[ $slug ]->menu_type == WPTOUCH_PRO_ADMIN_CUSTOM_PAGE );
	}
}

function wptouch_admin_render_custom_page( $slug = false ) {
	require_once( WPTOUCH_DIR . '/core/settings.php' );

	if ( !$slug ) {
		global $wptouch_panel_slug;
		$slug = $wptouch_panel_slug;
	}

	$admin_panel_name = $wptouch_panel_slug . '.php';

	if ( file_exists( WPTOUCH_ADMIN_DIR . '/pages/custom/' . $admin_panel_name ) ) {
		require_once( WPTOUCH_ADMIN_DIR . '/pages/custom/' . $admin_panel_name );
	}

	$panel_options = do_action( 'wptouch_admin_page_render_custom', $admin_panel_name );
}

function wptouch_section_has_visible_settings( $section ) {
	$viewable_settings = 0;

	$settings = wptouch_get_settings();

	if ( isset( $section->settings) && is_array( $section->settings ) && count( $section->settings ) ) {
		foreach( $section->settings as $setting ) {
			if ( $setting->level <= $settings->settings_mode ) {
				// This setting is viewable
				$viewable_settings++;
			}
		}
	}

	return ( $viewable_settings > 0 );
}


function wptouch_admin_panel_get_classes( $classes = false ) {
	if ( $classes ) {
		if ( is_array( $classes ) ) {
			$final_classes = $classes;
		} else {
			$final_classes = array( $classes );
		}
	} else {
		$final_classes = array();
	}

	global $wptouch_pro;
	$final_classes[] = 'wplocale-' . $wptouch_pro->locale;

	return $final_classes;
}

function wptouch_admin_panel_classes( $classes = false ) {
	echo implode( ' ', wptouch_admin_panel_get_classes( $classes ) );
}
