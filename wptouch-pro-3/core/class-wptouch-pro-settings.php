<?php

/* This is the main settings object for WPtouch Pro 3.x /*
/* It defines the default settings for the majority of features within WPtouch Pro */
/* To augment these settings, please use one of the appropriate WPtouch hooks */

class WPtouchSettings extends stdClass { 
	function save() {
		if ( isset( $this->domain ) ) {
			global $wptouch_pro;
			$wptouch_pro->save_settings( $this, $this->domain );
		} else {
			die( 'Setting domain not set' );
		}
	}
};

// These settings should never be adjusted, but rather should be augmented at a later time */
class WPtouchDefaultSettings30 extends WPtouchSettings {
	function WPtouchDefaultSettings30() {
		// Basic or advanced mode
		$this->settings_mode = WPTOUCH_SETTING_BASIC;
		
		// Setup - General
		$this->site_title = get_bloginfo( 'name' );
		$this->show_wptouch_in_footer = true;

		// Setup - Desktop / Mobile Switching
		$this->desktop_is_first_view = false;
		$this->show_switch_link = true;
		$this->switch_link_method = 'automatic';
		$this->mobile_switch_link_target = 'current_page';
		
		// Setup - Regionalization
		$this->force_locale = 'auto';
		$this->translate_admin = true;
		
		// Setup - Statistics
		$this->custom_stats_code = '';
		
		// Setup - Home Page Redirect
		$this->homepage_landing = 'none';
		$this->homepage_redirect_wp_target = 0;	
		$this->homepage_redirect_custom_target = '';

		// Setup - Backup and Import
		$this->automatically_backup_settings = true;
		
		// Setup - Tools and Debug
		$this->show_footer_load_times = false;
		$this->preview_mode = 'off';
		$this->use_jquery_2 = false;
		
		// Setup - Compatibility
		$this->include_functions_from_desktop_theme = false;
		$this->functions_php_loading_method = 'translate';
		
		$this->remove_shortcodes = '';
		$this->ignore_urls = '';
		$this->custom_user_agents = '';
		
		// Default Theme
		$this->current_theme_friendly_name = 'Classic Redux';
		$this->current_theme_location = '/plugins/' . WPTOUCH_ROOT_NAME . '/themes';
		$this->current_theme_name = 'classic-redux';
		
		// Updated when a license key is successfully added to the site
		$this->license_accepted = false;
		$this->license_accepted_time = 0;
		
		// Warnings
		$this->dismissed_notifications = array();
		
		// Menu				
		$this->custom_menu_name = 'wp';
		$this->appended_menu_name = 'none';
		$this->prepended_menu_name = 'none';

		$this->enable_parent_items = true;
		$this->enable_menu_icons = true;

		$this->default_menu_icon = WPTOUCH_DEFAULT_MENU_ICON;
		$this->disabled_menu_items = array();
		$this->temp_disabled_menu_items = array();

		// Debug Log
		$this->debug_log = false;
		$this->debug_log_level = WPTOUCH_ALL;	
		$this->debug_log_salt = substr( md5( mt_rand() ), 0, 10 );
		
		// Settings that are not yet hooked up and might go away
		$this->menu_icons = array();			// ?
		$this->menu_sort_order = 'wordpress';
		$this->menu_disable_parent_as_child = false;
		$this->disable_menu = false;
		$this->make_links_clickable = false;
		$this->footer_message = '';
		$this->custom_css_file = '';
		$this->wptouch_enable_custom_post_types = false;
		$this->always_refresh_css_js_files = false;
		$this->classic_excluded_categories = false;
		$this->convert_menu_links_to_internal = false;
		
		// Settings that probably need to go away
		$this->multisite_force_enable = false;
		$this->post_thumbnails_enabled = true;	
		$this->current_version = WPTOUCH_VERSION;
	}
};

class WPtouchDefaultSettingsBNCID30 extends WPtouchSettings {
	function WPtouchDefaultSettingsBNCID30() {	
		// License Information
		$this->bncid = '';
		$this->wptouch_license_key = '';	

		$this->next_update_check_time = 0;	
	}
};

class WPtouchDefaultSettingsCompat extends WPtouchSettings {
	function WPtouchDefaultSettingsCompat() {
		$this->plugin_hooks = '';
		$this->enabled_plugins = array();
	}
};
