<?php

class WPtouchProThree {
	// Set to true when the user is surfing on a supported mobile device
	var $is_mobile_device;

	// Set to true when WPtouch is showing a mobile theme
	var $showing_mobile_theme;

	// Contains information about the active user's mobile device
	var $active_device;

	// Contains information about the active user's mobile device class
	var $active_device_class;

	// Contains the BNC API object
	var $bnc_api;

	// Contains a list of installed modules
	var $modules;

	// Contains the version information while doing an update
	var $latest_version_info;

	// Stores a debug log
	var $debug_log;

	// Stores the current language locale
	var $locale;

	// Stores a hash map of icons to sets
	var $icon_to_set_map;

	// Stores the post-processed POST variables
	var $post;

	// Stores the post-processed GET variables
	var $get;

	// Stores a list of all internal notifications
	var $notifications;

	// Keeps track whether or not a settings restoration failed
	var $restore_failure;

	// 3.0 settings objects, based on domains
	var $settings_objects;

	// For storing menus in themes
	var $theme_menus;

	var $desktop_ajax_nonce;

	function WPtouchPro() {
		$this->is_mobile_device = false;
		$this->showing_mobile_theme = false;

		$this->active_device = false;
		$this->active_device_class = false;

		$this->latest_version_info = false;
		$this->icon_to_set_map = false;
		$this->restore_failure = false;

		$this->modules = array();
		$this->notifications = array();
		$this->post = array();
		$this->get = array();
		$this->settings_object = array();
		$this->theme_menus = array();

		$this->locale = '';
		$this->desktop_ajax_nonce = false;
	}

	function invalidate_settings( $domain  = false ) {
		if ( isset( $this->settings_objects[ $domain ] ) ) {
			unsset( $this->settings_objects[ $domain ] );
		} else {
			$this->settings_objects = false;
		}
	}

	function initialize() {
		// Check to see if we should initialize WPtouch Pro - can be used by certain other plugins to disable WPtouch Pro
		// When not initialized, WPtouch Pro is effectively disabled
		$should_init = apply_filters( 'wptouch_should_init_pro', true );
		if ( !$should_init ) {
			return false;
		}

		// Only check directories when admin is showing
		if ( is_admin() ) {
			$this->check_directories();
		}

		// Prime the settings
		$settings = $this->get_settings();

		// Check license
		if ( $settings->current_version != WPTOUCH_VERSION ) {
			do_action( 'wptouch_version_update' );

			$settings->current_version = WPTOUCH_VERSION;
			$settings->save();
		}

		$this->cleanup_post_and_get();

		if ( is_admin() ) {
			// New 3.0 Admin panels
			require_once( WPTOUCH_DIR . '/core/admin-load.php' );

			// Admin panel warnings notifications
			require_once( WPTOUCH_DIR . '/core/notifications.php' );

			add_action( 'admin_init', array( &$this, 'admin_handle_init' ) );
			add_action( 'admin_head', array( &$this, 'handle_admin_head' ) );
			add_action( 'admin_menu', 'wptouch_admin_build_menu' );

			// Icon Upload Ajax
			add_action( 'wp_ajax_upload_file', array( &$this, 'handle_upload_file' ) );
			add_action( 'wp_ajax_nopriv_upload_file', array( &$this, 'handle_upload_file' ) );

			// Handle admin AJAX requests from JS
			add_action( 'wp_ajax_wptouch_client_ajax', array( &$this, 'handle_client_ajax' ) );
			add_action( 'wp_ajax_nopriv_wptouch_client_ajax', array( &$this, 'handle_client_ajax' ) );

			// Languages
			add_filter( 'wptouch_admin_languages', array( &$this, 'setup_custom_languages' ) );

			// Plugin page
			add_filter( 'plugin_action_links', array( &$this, 'wptouch_pro_settings_link' ), 9, 2 );
			add_action( 'install_plugins_pre_plugin-information', array( &$this, 'show_plugin_info' ) );
			add_action( 'after_plugin_row_wptouch-pro-3/wptouch-pro-3.php', array( &$this, 'plugin_row' ) );

			// Backup/Restore
			add_action( 'wptouch_settings_saved', array( &$this, 'check_for_restored_settings' ) );

			add_action( 'wptouch_ajax_desktop_switch', array( &$this, 'handle_desktop_switch_ajax' ) );
		}

		// Set up debug log
		if ( $settings->debug_log ) {
			wptouch_debug_enable( true );
			wptouch_debug_set_log_level( WPTOUCH_ALL );
		}

		add_filter( 'wptouch_available_icon_sets_post_sort', array( &$this, 'setup_custom_icons' ) );

		// Can be used to adjust the support mobile devices
		add_filter( 'wptouch_supported_device_classes', array( &$this, 'augment_supported_devices' ) );

		$this->check_for_settings_changes();
		$this->setup_languages();

		WPTOUCH_DEBUG( WPTOUCH_INFO, 'Adding root functions files' );

		// Loads root functions files from the themes
		$this->load_root_functions_files();

		// Do settings download after we load root functions
		if ( $this->admin_is_wptouch_page() ) {
			$this->check_for_settings_download();
		}

		// Foundation modules are loaded off of this one
		do_action( 'wptouch_root_functions_loaded' );

		// This is where the main user-agent matching happens to determine module or non-mobile
		$this->analyze_user_agent_string();

		// We have a mobile device, so WPtouch Pro could potentially cache it or allow another app to cache
		if ( $this->is_mobile_device ) {
			WPTOUCH_DEBUG( WPTOUCH_INFO, 'User is viewing on a MOBILE device' );
			do_action( 'wptouch_cache_enable' );
		} else {
			WPTOUCH_DEBUG( WPTOUCH_INFO, 'User is viewing on a NON-MOBILE device' );
		}

		// Check if we're using a version of WordPress that supports themes
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'menus' );
			add_action( 'after_setup_theme', array( &$this, 'finish_thumbnail_setup' ) );
		}

		// Check to see if the mobile theme should be shown - if so, initialize it
		if ( $this->is_showing_mobile_theme_on_mobile_device() ) {
			$this->setup_mobile_theme_for_viewing();
		}

		add_action( 'init', array( &$this, 'finish_initialization' ) );
		add_action( 'init', array( &$this, 'setup_desktop_nonce') );
	}

	function finish_thumbnail_setup() {
		$settings = wptouch_get_settings();

		// Setup Post Thumbnails
		$create_thumbnails = apply_filters( 'wptouch_create_thumbnails', $settings->post_thumbnails_enabled && function_exists( 'add_theme_support' ) );
		if ( $create_thumbnails ) {
			add_theme_support( 'post-thumbnails' );

			$thumbnail_size = apply_filters( 'wptouch_thumbnail_size', WPTOUCH_THUMBNAIL_SIZE );
			add_image_size( 'wptouch-new-thumbnail', $thumbnail_size, $thumbnail_size, true );
		}
	}

	function check_for_settings_changes() {
		// Process settings
		if ( $this->admin_is_wptouch_page() ) {
			$this->process_submitted_settings();

			do_action( 'wptouch_settings_processed' );
		}
	}

	function finish_initialization() {
		$settings = wptouch_get_settings();

		$this->check_for_settings_changes();
		$this->setup_languages();
		$this->check_third_party_plugins();

		// For the wptouch shortcode
		add_shortcode( 'wptouch', array( &$this, 'handle_shortcode' ) );
	}

	function setup_desktop_nonce() {
		$this->desktop_ajax_nonce = wp_create_nonce( 'wptouch-ajax' );	
	}

	function augment_supported_devices( $devices) {
		if ( isset( $devices[ WPTOUCH_DEFAULT_DEVICE_CLASS ] ) ) {
			$settings = wptouch_get_settings();

			$user_agents = trim( $settings->custom_user_agents );

			if ( strlen( $user_agents) ) {
				// get user agents
				$agents = explode( "\n", str_replace( "\r\n", "\n", $user_agents ) );
				if ( is_array( $agents) && count( $agents ) ) {
					// add our custom user agents
					$devices[ WPTOUCH_DEFAULT_DEVICE_CLASS ] = array_merge( $devices[ WPTOUCH_DEFAULT_DEVICE_CLASS ], $agents );
				}
			}
		}

		return $devices;
	}

	function admin_handle_init() {
		$this->admin_initialize();
		$this->setup_admin_twitter_bootstrap();
		$this->setup_admin_stylesheets();
		$this->handle_admin_menu_commands();
		$this->setup_automatic_backup();
	}

	function setup_automatic_backup() {
		$settings = wptouch_get_settings();
		if ( $settings->automatically_backup_settings ) {
			// Check to see if we've schedule the event
			if ( !wp_next_scheduled( 'wptouch_cron_backup_settings' ) ) {
				$next_time = floor( time() / WPTOUCH_SECS_IN_DAY ) + WPTOUCH_SECS_IN_DAY;
				wp_schedule_event( $next_time, 'daily', 'wptouch_cron_backup_settings' );
			}
		} else {
			// Make sure the event isn't scheduled
			if ( wp_next_scheduled( 'wptouch_cron_backup_settings' ) ) {
				wp_clear_scheduled_hook( 'wptouch_cron_backup_settings' );
			}
		}
	}

	function check_for_settings_download() {
		if ( isset( $this->get[ 'action' ] ) && $this->get[ 'action' ] == 'wptouch-download-settings' ) {
			$nonce = $this->get[ 'nonce' ];
			if( wp_verify_nonce( $nonce, 'wptouch_admin' ) ) {
				if ( current_user_can( 'manage_options' ) ) {

					$file_name = WPTOUCH_BACKUP_DIRECTORY . '/' . $this->get[ 'backup_file' ];

					$backup_data = $this->load_file( $file_name );

					header( 'Content-type: text/plain' );
					header( 'Content-Disposition: attachment; filename="' . $this->get[ 'backup_file' ] . '"' );
					header( 'Content-length: ' . strlen( $backup_data ) );

					echo $backup_data;
					die;
				}
			}
		}

	}

	function admin_is_wptouch_page() {
		return ( is_admin() && strpos( $_SERVER['REQUEST_URI'], 'page=wptouch-' ) !== false );
	}

	function admin_initialize() {
		$is_plugins_page = ( strpos( $_SERVER['REQUEST_URI'], 'plugins.php' ) !== false );

		// We need the BNCAPI for checking for plugin updates and all the wptouch-pro admin functions
		if ( $this->admin_is_wptouch_page() || $is_plugins_page ) {
			$this->setup_bncapi();
		}

		// Only check for updates explicitly on plugins page
		if ( $is_plugins_page ) {
			$can_check_for_update = true;

			// Only check for the main site for multisite
			if ( wptouch_is_multisite_enabled() && !wptouch_is_multisite_primary() ) {
				$can_check_for_update = false;
			}

			if ( $can_check_for_update ) {
				WPTOUCH_DEBUG( WPTOUCH_INFO, 'Checking for product update' );
				$this->check_for_update( true );
			}
		}

		// only load admin scripts when we're looking at the WPtouch Pro page
		if ( $this->admin_is_wptouch_page() ) {
			$localize_params = 	array(
				'admin_url' => get_bloginfo('wpurl') . '/wp-admin',
				'admin_nonce' => wp_create_nonce( 'wptouch_admin' ),
				'plugin_url' => admin_url( 'admin.php?page=' . $_GET['page'] ),
				'text_preview_title' => __( 'Heads up!', 'wptouch-pro' ),
				'text_preview_content' => __( 'Theme Preview requires Chrome or Safari.', 'wptouch-pro' ),
				'reset_settings' => __( "This will reset all WPtouch Pro settings.\nAre you sure?", 'wptouch-pro' ),
				'reset_menus' => __( "This will reset all WPtouch Pro menu and icon settings.\nAre you sure?", 'wptouch-pro' )
			);

			wp_enqueue_script( 'jquery-plugins', WPTOUCH_URL . '/admin/js/wptouch-admin-plugins.js', 'jquery', md5( WPTOUCH_VERSION ) );
			wp_enqueue_script( 'wptouch-pro-ajax', WPTOUCH_URL . '/admin/js/wptouch-ajax.js', array( 'jquery', 'jquery-plugins' ) );

			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );

			wp_enqueue_script(
				'wptouch-pro-admin',
				WPTOUCH_URL . '/admin/js/wptouch-admin-3.js',
				array( 'jquery-plugins', 'wptouch-pro-ajax', 'jquery', 'jquery-ui-draggable', 'jquery-ui-droppable' )
			);

			// Set up AJAX requests here
			wp_localize_script( 'jquery-plugins', 'WPtouchCustom', $localize_params );
		}

		$this->setup_wptouch_admin_ajax();
	}

	function handle_admin_head() {
		if ( $this->admin_is_wptouch_page() ) {
			// Set up contextual help
			do_action( 'wptouch_admin_head' );
		}
	}

	function load_root_functions_files() {
		// Load root functions files only if we are in the admin or we are showing a mobile theme
		require_once( WPTOUCH_DIR . '/core/menu.php' );
		$clear_settings = false;

		// Load the parent root-functions if it exists
		if ( $this->has_parent_theme() ) {
			$parent_info = $this->get_parent_theme_info();
			if ( file_exists( WP_CONTENT_DIR . $parent_info->location . '/root-functions.php' ) ) {
				require_once( WP_CONTENT_DIR . $parent_info->location . '/root-functions.php' );
			}

			// next time get_settings is called, the current theme defaults will be added in
			$clear_settings = true;
		}

		// Load the current theme functions.php, or the child root functions if it exists in WPtouch themes
		if ( file_exists( $this->get_current_theme_directory() . '/root-functions.php' ) ) {
			require_once( $this->get_current_theme_directory() . '/root-functions.php' );

			// next time get_settings is called, the current theme defaults will be added in
			$clear_settings = true;
		}

		// Load a custom functions.php file
		if ( file_exists( WPTOUCH_BASE_CONTENT_DIR . '/functions.php' ) ) {
			require_once( WPTOUCH_BASE_CONTENT_DIR . '/functions.php' );
		}

		do_action( 'wptouch_functions_loaded' );

		if ( $clear_settings ) {
			// each theme can add it's own default settings, so we need to reset our internal settings object
			// so that the defaults will get merged in from the current theme
			$this->reload_settings();
		}
	}

	function analyze_user_agent_string() {
		// check and set cookie
		if ( isset( $this->get['wptouch_switch'] ) ) {

			setcookie( WPTOUCH_COOKIE, $this->get['wptouch_switch'] );
			$this->redirect_to_page( $this->get['redirect'] );
		}

		// Mobile support is only for clients, not the admin
		if ( is_admin() && !isset( $this->post[ 'wptouch_switch_location' ] ) ) {
			$this->is_mobile_device = false;
			$this->showing_mobile_theme = false;

			return;
		}

		$settings = $this->get_settings();

		// Settings are reloaded inside this function since themes can augment the user-agent data
		$this->is_mobile_device = $this->is_supported_device();

		// We can have a mobile device detected, but not show the mobile theme
		// usually this is a result of the user manually disabling it via a link in the footer
		if ( $this->is_mobile_device ) {
			if ( !isset( $_COOKIE[ WPTOUCH_COOKIE ] ) ) {
				$this->showing_mobile_theme = !$settings->desktop_is_first_view;
			} else {
				$this->showing_mobile_theme = ( $_COOKIE[WPTOUCH_COOKIE] === 'mobile' );
			}

			if ( $this->showing_mobile_theme ) {
				if ( $settings->ignore_urls ) {
					$server_url = strtolower( $_SERVER['REQUEST_URI'] );
					$url_list = explode( "\n", trim( strtolower( $settings->ignore_urls ) ) );
					foreach( $url_list as $url ) {
						if ( strpos( $server_url, trim( $url ) ) !== false ) {
							$this->showing_mobile_theme = false;
							$this->is_mobile_device = false;
							break;
						}
					}
				}
			}
		}

		// Filter to programmatically disable WPtouch Pro on a certain page
		$this->showing_mobile_theme = apply_filters( 'wptouch_should_show_mobile_theme', $this->showing_mobile_theme );

		if ( !$this->showing_mobile_theme ) {
			if ( $settings->switch_link_method == 'automatic' || $settings->switch_link_method == 'ajax' ) {
				add_action( 'wp_footer', array( &$this, 'show_desktop_switch_link' ) );
			}	
		}


		/*
		// Add switch link for desktop
		if ( !$this->showing_mobile_theme && $this->is_mobile_device ) {

		}
		*/
	}

	function setup_mobile_theme_for_viewing() {
		$settings = wptouch_get_settings();

		do_action( 'wptouch_mobile_theme_showing' );

		// Remove the admin bar in WPtouch Pro themes for now
		if ( function_exists( 'show_admin_bar' ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}

		// Theme functions
		require_once( WPTOUCH_DIR . '/core/theme.php' );

		// Menu Tags
		require_once( WPTOUCH_DIR . '/core/menu.php' );

		add_action( 'wptouch_functions_start', array( &$this, 'load_functions_file_for_desktop' ) );

		// These actions and filters are only loaded when WPtouch and a mobile theme are active
		add_action( 'wp', array( &$this, 'check_for_redirect' ) );
		add_filter( 'init', array( &$this, 'init_theme' ) );
		add_filter( 'excerpt_length', array( &$this, 'get_excerpt_length' ) );
		add_filter( 'excerpt_more', array( &$this, 'get_excerpt_more' ) );

		// New switch hooks
		add_filter( 'template_directory', array( &$this, 'get_template_directory' ) );
		add_filter( 'template_directory_uri', array( &$this, 'get_template_directory_uri' ) );
		add_filter( 'stylesheet_directory', array( &$this, 'get_stylesheet_directory' ) );
		add_filter( 'stylesheet_directory_uri', array( &$this, 'get_stylesheet_directory_uri' ) );

		add_action( 'wptouch_pre_head', array( &$this, 'setup_theme_styles' ) );
		add_action( 'wptouch_pre_footer', array( &$this, 'handle_custom_footer_styles' ) );

		if ( isset( $settings->remove_shortcodes ) && strlen( $settings->remove_shortcodes ) ) {
			$this->remove_shortcodes( $settings->remove_shortcodes );
		}

		require_once( WPTOUCH_DIR . '/core/theme.php' );
	}

	function check_third_party_plugins() {
		if ( defined( 'WORDTWIT_PRO_INSTALLED' ) ) {
			add_filter( 'wptouch_default_settings', array( &$this, 'add_default_wordtwit_pro_settings' ) );
		}
	}

	function handle_activation() {
		// activation hook
	}

	function handle_deactivation() {
		// Cancel our automatic backup hook
		if ( wp_next_scheduled( 'wptouch_cron_backup_settings' ) ) {
			wp_clear_scheduled_hook( 'wptouch_cron_backup_settings' );
		}
	}

	function update_encoded_setting( $encoded_setting, $new_value ) {
		require_once( WPTOUCH_DIR . '/core/settings.php' );

		$decoded_setting = wptouch_decode_encoded_setting( $encoded_setting );

		$settings = wptouch_get_settings( $decoded_setting->domain );
		$name = $decoded_setting->name;

		$settings->$name = $new_value;
		$settings->save();
	}

	function handle_upload_file() {
		$this->cleanup_post_and_get();

		header( 'HTTP/1.1 200 OK' );
		$nonce = $this->post[ 'wp_nonce' ];
		if( wp_verify_nonce( $nonce, 'wptouch_admin' ) ) {
			switch( $this->post[ 'file_type'] ) {
				case 'homescreen_image':
					WPTOUCH_DEBUG( WPTOUCH_INFO, 'Uploading new HOMESCREEN image' );
					// Move uploaded file
					if ( isset( $_FILES[ 'myfile' ] ) ) {
						$temp_name = $_FILES[ 'myfile' ][ 'tmp_name' ];
						$real_name = $_FILES[ 'myfile' ][ 'name' ];
						$destination_file = WPTOUCH_CUSTOM_UPLOAD_DIRECTORY . '/' . $real_name;
						if ( file_exists( $destination_file ) ) {
							unlink( $destination_file );
						}

						move_uploaded_file( $temp_name, $destination_file );

						require_once( WPTOUCH_DIR . '/core/settings.php' );
						do_action( 'wptouch_post_process_image_file', $destination_file, wptouch_decode_encoded_setting( $this->post[ 'setting_name'] ) );

						$image_file = str_replace( WPTOUCH_BASE_CONTENT_DIR, '', $destination_file ) ;
						$this->update_encoded_setting( $this->post[ 'setting_name'], $image_file );
					}

					echo WPTOUCH_BASE_CONTENT_URL . $image_file;
					break;
				case 'custom_image':
					WPTOUCH_DEBUG( WPTOUCH_INFO, 'Uploading new CUSTOM image' );
					if ( isset( $_FILES[ 'myfile' ] ) ) {
						$temp_name = $_FILES[ 'myfile' ][ 'tmp_name' ];
						$real_name = $_FILES[ 'myfile' ][ 'name' ];
						$destination_file = WPTOUCH_CUSTOM_ICON_DIRECTORY . '/' . $real_name;
						if ( file_exists( $destination_file ) ) {
							unlink( $destination_file );
						}

						move_uploaded_file( $temp_name, $destination_file );
					}
					break;
				case 'settings_backup':
					WPTOUCH_DEBUG( WPTOUCH_INFO, 'Uploading SETTINGS BACKUP file' );
					if ( isset( $_FILES[ 'myfile' ] ) ) {
						$temp_name = $_FILES[ 'myfile' ][ 'tmp_name' ];
						if ( file_exists( $temp_name ) ) {
							$settings_info = $this->load_file( $temp_name );
							if ( $settings_info ) {
								require_once( WPTOUCH_DIR . '/core/admin-backup-restore.php' );
								wptouch_restore_settings( $settings_info );
							}

							unlink( $temp_name );
						}
					}
					break;
				default:
					// For different file uploads
					WPTOUCH_DEBUG( WPTOUCH_INFO, 'Handling default file upload' );
					do_action( 'wptouch_upload_file', $this->post[ 'file_type'] );
					break;
			}
		}
		die;
	}

	function handle_admin_menu_commands() {
		if ( isset( $this->get['admin_command'] ) ) {
			$admin_menu_nonce = $this->get['admin_menu_nonce'];
			if ( wptouch_admin_menu_nonce_is_valid( $admin_menu_nonce ) ) {
				// check user permissions
				if ( current_user_can( 'switch_themes' ) ) {
					switch( $this->get['admin_command'] ) {
						case 'activate_theme':
							WPTOUCH_DEBUG( WPTOUCH_INFO, 'Activating theme [' . $this->get['theme_name'] . ']' );
							$theme_to_activate = $this->get['theme_name'];
							if ( $theme_to_activate ) {
								$settings = $this->get_settings();

								$paths = explode( '/', ltrim( rtrim( $this->get['theme_location'], '/' ), '/' ) );

								$settings->current_theme_name = $paths[ count( $paths ) - 1 ];
								unset( $paths[ count( $paths ) - 1 ] );

								$settings->current_theme_location = '/' . implode( '/', $paths );
								$settings->current_theme_friendly_name = $this->get['theme_name'];

								$settings->save();
							}
							break;
						case 'copy_theme':
							WPTOUCH_DEBUG( WPTOUCH_INFO, 'Copying theme [' . $this->get['theme_name'] . ']' );
							require_once( WPTOUCH_DIR . '/core/file-operations.php' );

							$copy_src = WP_CONTENT_DIR . $this->get['theme_location'];
							$theme_name = wptouch_convert_to_class_name( $this->get[ 'theme_name' ] );

							$num = $this->get_theme_copy_num( $theme_name );
							$copy_dest = WPTOUCH_CUSTOM_THEME_DIRECTORY . '/' . $theme_name . '-copy-' . $num;

							wptouch_create_directory_if_not_exist( $copy_dest );

							$this->recursive_copy( $copy_src, $copy_dest );

							$readme_file = $copy_dest . '/readme.txt';
							$readme_info = $this->load_file( $readme_file );
							if ( $readme_info ) {
								if ( preg_match( '#Theme Name: (.*)#', $readme_info, $matches ) ) {
									$readme_info = str_replace( $matches[0], 'Theme Name: ' . $matches[1] . ' Copy #' . $num, $readme_info );
									$f = fopen( $readme_file, "w+t" );
									if ( $f ) {
										fwrite( $f, $readme_info );
										fclose( $f );
									}
								}
							} else {
								WPTOUCH_DEBUG( WPTOUCH_ERROR, "Unable to modify readme.txt file after copy" );
							}
							break;
						case 'delete_theme':
							WPTOUCH_DEBUG( WPTOUCH_INFO, 'Deleting theme [' . $this->get['theme_location'] . ']' );
							require_once( WPTOUCH_DIR . '/core/file-operations.php' );

							$theme_location = WP_CONTENT_DIR . $this->get['theme_location'];

							$this->recursive_delete( $theme_location );
							break;
					}
				}
			}

			$used_query_args = array( 'admin_menu_nonce', 'admin_command', 'theme_name', 'theme_location' );

			header( 'Location: ' . remove_query_arg( $used_query_args ) );
			die;
		}
	}

	function is_showing_mobile_theme_on_mobile_device() {
		return ( $this->is_mobile_device && $this->showing_mobile_theme );
	}

	function load_functions_file_for_desktop() {
		$settings = wptouch_get_settings();

		// Check to see if we should include the functions.php file from the desktop theme
		if ( $settings->include_functions_from_desktop_theme ) {
			$desktop_theme_directory = get_theme_root() . '/'. get_template();
			$desktop_functions_file = $desktop_theme_directory . '/functions.php';

			// Check to see if the theme has a functions.php file
			if ( file_exists( $desktop_functions_file ) ) {
				switch( $settings->functions_php_loading_method ) {
					case 'direct':
						WPTOUCH_DEBUG( WPTOUCH_INFO, 'Include desktop functions file using DIRECT method' );
						require_once( $desktop_functions_file );
						break;
					case 'translate':
						WPTOUCH_DEBUG( WPTOUCH_INFO, 'Include desktop functions file using TRANSLATE method' );
						require_once( WPTOUCH_DIR . '/core/desktop-functions.php' );
						wptouch_include_functions_file( $desktop_functions_file, dirname( $desktop_functions_file ), dirname( $desktop_functions_file ), 'require_once' );
						break;
				}
			}
		}
	}

	function nullify_shortcode( $params ) {
		return '';
	}

	function remove_shortcodes( $shortcodes ) {
		$all_short_codes = explode( ',', str_replace( ', ', ',', $shortcodes ) );
		if ( $all_short_codes ) {
			foreach( $all_short_codes as $code ) {
				add_shortcode( $code, array( &$this, 'nullify_shortcode' ) );
			}
		}
	}

	function get_template_directory( $directory, $template = false, $root = false ) {
		$theme_info = $this->get_current_theme_info();

		if ( $this->has_parent_theme() ) {
			$parent_info = $this->get_parent_theme_info();

			return WP_CONTENT_DIR . $parent_info->location . '/' . apply_filters( 'wptouch_parent_device_class', $this->get_active_device_class() );
		} else {
			return WP_CONTENT_DIR . $theme_info->location . '/' . $this->get_active_device_class();
		}
	}

	function get_template_directory_uri( $directory, $template = false, $root = false ) {
		$theme_info = $this->get_current_theme_info();

		if ( $this->has_parent_theme() ) {
			$parent_info = $this->get_parent_theme_info();

			return wptouch_check_url_ssl( WP_CONTENT_URL . $parent_info->location . '/' . apply_filters( 'wptouch_parent_device_class', $this->get_active_device_class() ) );
		} else {
			return wptouch_check_url_ssl( WP_CONTENT_URL . $theme_info->location . '/' . $this->get_active_device_class() );
		}
	}

	function get_stylesheet_directory( $directory, $template = false, $root = false ) {
		$theme_info = $this->get_current_theme_info();

		return WP_CONTENT_DIR . $theme_info->location . '/' . $this->get_active_device_class();
	}

	function get_stylesheet_directory_uri( $directory, $template = false, $root = false ) {
		$theme_info = $this->get_current_theme_info();

		return wptouch_check_url_ssl( WP_CONTENT_URL . $theme_info->location . '/' . $this->get_active_device_class() );
	}

	function has_parent_theme() {
		$theme_info = $this->get_current_theme_info();

		return ( isset( $theme_info->parent_theme ) && strlen( $theme_info->parent_theme ) );
	}

	function is_child_theme() {
		return $this->has_parent_theme();
	}

	function get_parent_theme_info() {
		$theme_info = $this->get_current_theme_info();

		if ( $theme_info ) {
			$themes = $this->get_available_themes();
			if ( isset( $themes[ $theme_info->parent_theme ] ) ) {
				return $themes[ $theme_info->parent_theme ];
			}
		}

		return false;
	}

	function setup_custom_languages( $languages ) {
		$custom_lang_files = $this->get_files_in_directory( WPTOUCH_CUSTOM_LANG_DIRECTORY, '.mo' );

		if ( $custom_lang_files && count( $custom_lang_files ) ) {
			foreach( $custom_lang_files as $lang_file ) {
				$locale_name = str_replace( 'wptouch-pro-', '',  basename( $lang_file, '.mo' ) );
				$languages[ $locale_name ] = $locale_name;
			}
		}

		return $languages;
	}

	function check_for_restored_settings() {
		$settings = $this->get_settings();

		if ( $settings->restore_string ) {
			if ( function_exists( 'gzuncompress' ) ) {
				$new_settings = @unserialize( gzuncompress( base64_decode( $settings->restore_string ) ) );
				if ( is_object( $new_settings ) ) {
					$settings = $new_settings;
				} else {
					$this->restore_failure = true;
				}
			}

			$settings->restore_string = '';
			$settings->save();
		}
	}

	function handle_shortcode( $attr, $content ) {
		$new_content = '';

		// Add a default for target=mobile
		if ( !isset( $attr[ 'target' ] ) ) {
			$attr[ 'target' ] = 'mobile';
		}

		if ( isset( $attr['target'] ) ) {
			switch( $attr['target'] ) {
				case 'non-mobile':
					if ( !$this->is_mobile_device ) {
						$new_content = '<span class="wptouch-shortcode-non-mobile">' . $content . '</span>';
					}
					break;
				case 'desktop':
					if ( $this->is_mobile_device && !$this->showing_mobile_theme ) {
						$new_content = '<span class="wptouch-shortcode-desktop">' . $content . '</span>';
					}
					break;
				case 'non-webapp':
					if ( $this->is_showing_mobile_theme_on_mobile_device() ) {
						$new_content = '<span class="wptouch-shortcode-mobile-only" style="display: none;">' . $content . '</span>';
					}
					break;
				case 'webapp':
					if ( $this->is_showing_mobile_theme_on_mobile_device() ) {
						$new_content = '<span class="wptouch-shortcode-webapp-only" style="display: none;">' . $content . '</span>';
					}
					break;
				case 'mobile':
					if ( $this->is_showing_mobile_theme_on_mobile_device() ) {
						$new_content = '<span class="wptouch-shortcode-webapp-mobile">' . $content . '</span>';
					}
					break;
				default:
					$new_content = apply_filters( 'wptouch_shortcode_' . $attr[ 'target' ], $content );
					break;
			}
		}

		return do_shortcode( $new_content );
	}

	function copy_file( $src_name, $dst_name ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		wptouch_copy_file( $src_name, $dst_name );
	}

	function get_friendly_plugin_name( $name ) {
		require_once( WPTOUCH_DIR . '/core/plugins.php' );

		return wptouch_plugins_get_friendly_name( $this, $name );
	}

	function cleanup_post_and_get() {
		if ( count( $_GET ) ) {
			foreach( $_GET as $key => $value ) {
				if ( get_magic_quotes_gpc() ) {
					$this->get[ $key ] = @stripslashes( $value );
				} else {
					$this->get[ $key ] = $value;
				}
			}
		}

		if ( count( $_POST ) ) {
			foreach( $_POST as $key => $value ) {
				if ( get_magic_quotes_gpc() ) {
					if ( is_array( $value ) ) {
						$new_value = array();
						foreach( $value as $x ) {
							$new_value[] = @stripslashes( $x );
						}

						$this->post[ $key ] = $new_value;
					} else {
						$this->post[ $key ] = @stripslashes( $value );
					}
				} else {
					$this->post[ $key ] = $value;
				}
			}
		}
	}

    function plugin_row( $plugin_name ) {
		$plugin_name = "wptouch-pro-3/wptouch-pro-3.php";

		include( WPTOUCH_DIR . '/admin/html/plugin-area.php' );
    }

	function wptouch_pro_settings_link( $links, $file ) {
	 	if ( $file == 'wptouch-pro-3/wptouch-pro-3.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'admin.php?page=wptouch-admin-touchboard' ) . '">' . __( 'Settings' ) . '</a>';
			array_push( $links, $settings_link );
		}

		return $links;
	}

	function remove_transient_info() {
    	$bnc_api = $this->get_bnc_api();

    	$plugin_name = WPTOUCH_ROOT_NAME . '/wptouch-pro-3.php';

		if ( function_exists( 'is_super_admin' ) ) {
			$option = get_site_transient( 'update_plugins' );
		} else {
			$option = function_exists( 'get_transient' ) ? get_transient( 'update_plugins' ) : get_option( 'update_plugins' );
		}

		unset( $option->response[ $plugin_name ] );

		if ( function_exists( 'is_super_admin' ) ) {
			set_site_transient( 'update_plugins', $option );
		} else if ( function_exists( 'set_transient' ) ) {
			set_transient( 'update_plugins', $option );
		}
	}

    function check_for_update() {
    	// Make sure we are setup

    	$this->setup_bncapi();

    	$bnc_api = $this->get_bnc_api();

    	$plugin_name = WPTOUCH_ROOT_NAME . '/wptouch-pro-3.php';

    	WPTOUCH_DEBUG( WPTOUCH_INFO, 'Checking BNC server for a new product update' );

        // Check for WordPress 3.0 function
		if ( function_exists( 'is_super_admin' ) ) {
			$option = get_site_transient( 'update_plugins' );
		} else {
			$option = function_exists( 'get_transient' ) ? get_transient( 'update_plugins' ) : get_option( 'update_plugins' );
		}

    	$version_available = false;
    	$latest_info = $bnc_api->get_product_version( 'wptouch-pro-3' );
    	if ( $latest_info && $latest_info[ 'version' ] != WPTOUCH_VERSION && isset( $latest_info[ 'upgrade_url' ] ) ) {
    		if ( !isset( $option->response[ $plugin_name ] ) ) {
				$option->response[ $plugin_name ] = new stdClass();
			}

			WPTOUCH_DEBUG( WPTOUCH_INFO, 'A new product update is available [' . $latest_info['version'] . ']' );

			// Update upgrade options
			$option->response[ $plugin_name ]->url = '';
			$option->response[ $plugin_name ]->package = $latest_info[ 'upgrade_url' ];
			$option->response[ $plugin_name ]->new_version = $latest_info['version'];
			$option->response[ $plugin_name ]->id = '0';
			$option->response[ $plugin_name ]->slug = WPTOUCH_ROOT_NAME;

			$this->latest_version_info = $latest_info;

			$version_available = $latest_info['version'];
    	} else {
    		unset( $option->response[ $plugin_name ] );
    	}

    	// WordPress 3.0 changed some stuff, so we check for a WP 3.0 function
		if ( function_exists( 'is_super_admin' ) ) {
			set_site_transient( 'update_plugins', $option );
			set_site_transient( WPTOUCH_VERSION_TRANSIENT, $version_available );
		} else if ( function_exists( 'set_transient' ) ) {
			set_transient( 'update_plugins', $option );
			set_transient( WPTOUCH_VERSION_TRANSIENT, $version_available );
		}
    }

    function show_plugin_info() {
		switch( $_REQUEST[ 'plugin' ] ) {
			case 'wptouch-pro-3':
				echo "<h2 style='font-family: Georgia, sans-serif; font-style: italic; font-weight: normal'>" . __( 'WPtouch Pro Changelog', 'wptouch-pro' ) . "</h2>";

				require_once( WPTOUCH_DIR . '/core/admin-ajax.php' );

				wptouch_admin_handle_ajax( $this, 'admin-change-log' );
				exit;
			default:
				break;
		}
    }

	function get_information_fragment( &$style_info, $fragment ) {
		if ( preg_match( '#' . $fragment . ': (.*)#i', $style_info, $matches ) ) {
			return trim( $matches[1] );
		} else {
			return false;
		}
	}

	function get_theme_information( $theme_location, $theme_url, $custom = false ) {
		$style_file = $theme_location . '/readme.txt';
		if ( file_exists( $style_file ) ) {
			$style_info = $this->load_file( $style_file );

			$theme_info = new stdClass;

			$theme_info->name = $this->get_information_fragment( $style_info, 'Theme Name' );
			$theme_info->theme_url = $this->get_information_fragment( $style_info, 'Theme URI' );
			$theme_info->description = $this->get_information_fragment( $style_info, 'Description' );
			$theme_info->author = $this->get_information_fragment( $style_info, 'Author' );
			$theme_info->version = $this->get_information_fragment( $style_info, 'Version' );
			$features = $this->get_information_fragment( $style_info, 'Features' );

			if ( $features ) {
				$theme_info->features = explode( ',', str_replace( ', ', ',', $features ) );
			} else {
				$theme_info->features = false;
			}

			$parent_info = $this->get_information_fragment( $style_info, 'Parent' );
			if ( $parent_info ) {
				$theme_info->parent_theme = $parent_info;
			}

			$theme_info->tags = explode( ',', str_replace( ', ', ',', $this->get_information_fragment( $style_info, 'Tags' ) ) );
			$theme_info->screenshot = $theme_url . '/screenshot.png';
			$theme_info->location = str_replace( WP_CONTENT_DIR, '', $theme_location );
			$theme_info->custom_theme = $custom;

			return $theme_info;
		}

		return false;
	}

	function get_files_in_directory( $directory_name, $extension ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		return wptouch_get_files_in_directory( $directory_name, $extension );
	}

	function get_theme_directories() {
		$theme_directorys = array();

		$theme_directories[] = array( WPTOUCH_DIR . '/themes', WPTOUCH_URL . '/themes' );
		$theme_directories[] = array( WPTOUCH_BASE_CONTENT_DIR . '/themes', WPTOUCH_BASE_CONTENT_URL . '/themes' );

		return apply_filters( 'wptouch_theme_directories', $theme_directories );
	}

	function get_available_themes() {
		$themes = array();
		$theme_directories = $this->get_theme_directories();

		$custom = false;
		foreach( $theme_directories as $theme_dir ) {
			$list_dir = @opendir( $theme_dir[0] );

			if ( $list_dir ) {
				while ( ( $f = readdir( $list_dir ) ) !== false ) {
					// Skip common files in each directory
					if ( $f == '.' || $f == '..' || $f == '.svn' || $f == '._.DS_Store' || $f == 'core' ) {
						continue;
					}

					$theme_info = $this->get_theme_information( $theme_dir[0] . '/' . $f, $theme_dir[1] . '/' . $f, $custom );

					if ( $theme_info ) {
						$themes[ $theme_info->name ] = $theme_info;
					}
				}

				closedir( $list_dir );
			}

			if ( !$custom ) {
				$custom = true;
			}

		}

		ksort( $themes );

		return apply_filters( 'wptouch_available_themes', $themes );
	}

	function get_current_theme_info() {
		$settings = $this->get_settings();

		$themes = $this->get_available_themes();

		if ( isset( $themes[ $settings->current_theme_friendly_name ] ) ) {
			return $themes[ $settings->current_theme_friendly_name ];
		} else {
			// check to see if we can find it using the path, in the case where the Theme Friendly Name has changed
			$active_theme_location = $settings->current_theme_location . '/' . $settings->current_theme_name;
			foreach( $themes as $name => $theme_info ) {
				if ( $theme_info->location == $active_theme_location ) {
					return $theme_info;
				}
			}
		}

		return false;
	}

	function create_icon_set_info( $name, $desc, $author, $author_url, $url, $location, $dark = false ) {
		$icon_pack_info = new stdClass;

		$icon_pack_info->name = $name;
		$icon_pack_info->description = $desc;

		// Check to see if we have an author.  It's not required that you do, i.e. in the case of Custom
		if ( $author ) {
			$icon_pack_info->author = $author;
			$icon_pack_info->author_url = $author_url;
		}

		$icon_pack_info->url = $url;
		$icon_pack_info->location = $location;
		$icon_pack_info->class_name = wptouch_convert_to_class_name( $icon_pack_info->name );
		$icon_pack_info->dark_background = $dark;

		require_once( WPTOUCH_DIR . '/core/file-operations.php' );
		$icon_pack_info->icons = wptouch_get_files_in_directory( $location, 'png' );

		if ( is_array( $icon_pack_info->icons ) && count( $icon_pack_info->icons ) ) {
			$icon_pack_info->thumbnail = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $icon_pack_info->icons[ 0 ] );
		}

		return $icon_pack_info;
	}

	function get_icon_set_information( $icon_pack_location, $icon_pack_url ) {
		$info_file = $icon_pack_location . '/wptouch.info';

		if ( file_exists( $info_file ) ) {
			$icon_info = $this->load_file( $info_file );

			$dark = false;
			$background_type = $this->get_information_fragment( $icon_info, 'Background' );
			if ( $background_type == 'Dark' ) {
				$dark = true;
			}

			// Create icon set information
			$icon_pack_info = $this->create_icon_set_info(
				$this->get_information_fragment( $icon_info, 'Name' ),
				$this->get_information_fragment( $icon_info, 'Description' ),
				$this->get_information_fragment( $icon_info, 'Author' ),
				$this->get_information_fragment( $icon_info, 'Author URL' ),
				$icon_pack_url,
				$icon_pack_location,
				$dark
			);

			return $icon_pack_info;
		}

		return false;
	}

	function get_available_icon_packs() {
		$icon_packs = array();
		$icon_pack_directories = array();
		$icon_pack_directories[] = array( WPTOUCH_DIR . '/resources/icons', WPTOUCH_URL . '/resources/icons' );
		$icon_pack_directories[] = array( WPTOUCH_BASE_CONTENT_DIR . '/icons', WPTOUCH_BASE_CONTENT_URL . '/icons' );

		foreach( $icon_pack_directories as $some_key => $icon_dir ) {
			$list_dir = @opendir( $icon_dir[0] );
			if ( $list_dir ) {
				while ( ( $f = readdir( $list_dir ) ) !== false ) {
					// Skip common files in each directory
					if ( $f == '.' || $f == '..' || $f == '.svn' || $f == '._.DS_Store' ) {
						continue;
					}

					$icon_pack_info = $this->get_icon_set_information( $icon_dir[0] . '/' . $f, $icon_dir[1] . '/' . $f );

					if ( $icon_pack_info ) {
						$icon_packs[ $icon_pack_info->name ] = $icon_pack_info;
					}
				}
			}
		}

		$icon_packs = apply_filters( 'wptouch_available_icon_sets_pre_sort', $icon_packs );

		ksort( $icon_packs );

		return apply_filters( 'wptouch_available_icon_sets_post_sort', $icon_packs );
	}

	function setup_custom_icons( $icon_pack_info ) {
		$icon_info = array();
		$icon_info[ __( 'Custom Icons', 'wptouch-pro' ) ] = $this->create_icon_set_info(
			__( 'Custom Icons', 'wptouch-pro' ),
			'Custom Icons',
			false,
			'',
			WPTOUCH_CUSTOM_ICON_URL,
			WPTOUCH_CUSTOM_ICON_DIRECTORY
		);

		return array_merge( $icon_pack_info, $icon_info );
	}

	function get_icon_pack( $set_name ) {
		$available_packs = $this->get_available_icon_packs();

		if ( isset( $available_packs[ $set_name ] ) ) {
			return $available_packs[ $set_name ];
		} else {
			return false;
		}
	}

	function is_image_file( $file_name ) {
		$file_name = strtolower( $file_name );
		$allowable_extensions = apply_filters( 'wptouch_image_file_types', array( '.png', '.jpg', '.gif', '.jpeg' ) );

		$is_image = false;
		foreach( $allowable_extensions as $ext ) {
			if ( strpos( $file_name, $ext ) !== false ) {
				$is_image = true;
				break;
			}
		}

		return $is_image;
	}

	function get_icons_from_packs( $setname ) {
		$settings = $this->get_settings();
		$icon_packs = $this->get_available_icon_packs();

		$icons = array();

		if ( isset( $icon_packs[ $setname ] ) ) {
			$pack = $icon_packs[ $setname ];
			$dir = @opendir( $pack->location );

			$class_name = wptouch_convert_to_class_name( $setname );

			if ( $dir ) {
				while ( $f = readdir( $dir ) ) {
					if ( $f == '.' || $f == '..' || $f == '.svn' || !$this->is_image_file( $f ) ) continue;

					$icon_info = new stdClass;
					$icon_info->location = $pack->location . '/' . $f;
					$icon_info->short_location = str_replace( WP_CONTENT_DIR, '', $icon_info->location );
					$icon_info->url = $pack->url . '/' . $f;
					$icon_info->name = $f;
					$icon_info->set = $setname;
					$icon_info->class_name = $class_name;

					$short_name_array = explode( '.', $f );
					$short_name = $short_name_array[0];
					$icon_info->short_name = $short_name;

					// add image size information if the user has the GD library installed
					if ( function_exists( 'getimagesize' ) ) {
						$icon_info->image_size = getimagesize( $pack->location . '/' . $f );
					}

					$icons[ $f . '/' . $setname ] = $icon_info;
				}

				closedir( $dir );
			}
		}

		ksort( $icons );

		return $icons;
	}

	function check_and_use_min_file( $file_name, $file_ext, $rel_path = WPTOUCH_DIR, $rel_url = WPTOUCH_URL ) {
		$min_file = str_replace( $file_ext, '.min' . $file_ext, $file_name );

		if ( file_exists( $rel_path . $min_file ) ) {
			return $rel_url . $min_file;
		} else {
			return $rel_url . $file_name;
		}
	}

	function check_and_use_js_file( $file_name, $rel_path = WPTOUCH_DIR, $rel_url = WPTOUCH_URL ) {
		return $this->check_and_use_min_file( $file_name, '.js', $rel_path, $rel_url  );
	}

	function check_and_use_css_file( $file_name, $rel_path = WPTOUCH_DIR, $rel_url = WPTOUCH_URL  ) {
		return $this->check_and_use_min_file( $file_name, '.css', $rel_path, $rel_url );
	}

	function setup_admin_stylesheets() {
		if ( $this->admin_is_wptouch_page() ) {
			wp_enqueue_style( 'wptouch-admin-styles', $this->check_and_use_css_file( '/admin/css/wptouch-admin-3.css' ), false, md5( WPTOUCH_VERSION ) );

			if ( wptouch_should_load_rtl() && file_exists( WPTOUCH_DIR . '/admin/css/rtl.css' ) ) {
				WPTOUCH_DEBUG( WPTOUCH_INFO, 'Loading RTL stylesheet' );
				wp_enqueue_style(
					'wptouch-admin-rtl',
					wptouch_check_url_ssl( $this->check_and_use_css_file(
						'/admin/css/rtl.css',
						WPTOUCH_DIR,
						WPTOUCH_URL
					) ),
		 			array( 'wptouch-admin-styles', 'wptouch-admin-css-bootstrap' ),
		 			WPTOUCH_VERSION
		 		);
			}
		}
	}

	function setup_admin_twitter_bootstrap() {
		if ( $this->admin_is_wptouch_page() ) {
			wp_enqueue_style( 'wptouch-admin-css-bootstrap', $this->check_and_use_css_file( '/admin/bootstrap/css/bootstrap.css' ), false, md5( WPTOUCH_VERSION ) );
			wp_enqueue_script( 'wptouch-admin-js-bootstrap', $this->check_and_use_js_file( '/admin/bootstrap/js/bootstrap.js' ), false, md5( WPTOUCH_VERSION ) );
		}
	}

	function handle_client_ajax() {
		$nonce = $this->post['wptouch_nonce'];
		if ( !wp_verify_nonce( $nonce, 'wptouch-ajax' ) ) {
			die( 'Security problem with nonce' );
		}

		if ( isset( $this->post['wptouch_action'] ) ) {
			do_action( 'wptouch_ajax_' . $this->post['wptouch_action'] );
			exit;
		}

		die;
	}

	function init_theme() {
		$settings = $this->get_settings();

		add_action( 'wp_footer', array( &$this, 'handle_footer' ) );

		wp_enqueue_script( 'wptouch-ajax', WPTOUCH_URL . '/include/js/wptouch.js', array( 'jquery' ), md5( WPTOUCH_VERSION ) );

		$localize_params = 	array(
			'ajaxurl' => get_bloginfo( 'wpurl' ) . '/wp-admin/admin-ajax.php',
			'siteurl' => str_replace( array( 'http://' . $_SERVER['SERVER_NAME'] . '','https://' . $_SERVER['SERVER_NAME'] . '' ), '', get_bloginfo( 'url' ) . '/' ),
			'security_nonce' => wp_create_nonce( 'wptouch-ajax' )
		);

		wp_localize_script( 'wptouch-ajax', 'wptouchMain', apply_filters( 'wptouch_localize_scripts', $localize_params  ) );

		do_action( 'wptouch_init' );

		// Do the theme init
		do_action( 'wptouch_theme_init' );

		$this->disable_plugins();
	}

	function add_notification( $area_or_plugin, $warning_desc, $notification_type = 'warning', $link = false ) {
		$this->notifications[ $area_or_plugin ] = array( $area_or_plugin, $warning_desc, $notification_type, $link );
	}

	function generate_plugin_hook_list( $update_list = false ) {
		$settings = $this->get_settings( 'compat' );

		if ( $update_list ) {
			require_once( WPTOUCH_DIR . '/core/plugins.php' );
			wptouch_plugins_generate_hook_list( $this, $settings );
		} else {
			$this->plugin_hooks = $settings->plugin_hooks;
		}

		$this->reload_settings();
	}

	function disable_plugins() {
		$settings = $this->get_settings( 'compat' );

		if ( $settings->plugin_hooks && count( $settings->plugin_hooks ) ) {
			require_once( WPTOUCH_DIR . '/core/plugins.php' );

			wptouch_plugins_disable( $this, $settings );
		}
	}

	function remove_directory( $dir_name ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		wptouch_remove_directory( $dir_name );
	}

	function setup_languages() {
		$current_locale = get_locale();

		// Check for language override
		$settings = wptouch_get_settings();
		if ( $settings->force_locale != 'auto' ) {
			$current_locale = $settings->force_locale;
		}

		if ( !empty( $current_locale ) ) {
			$current_locale = apply_filters( 'wptouch_language', $current_locale );

			$use_lang_file = false;
			$custom_lang_file = WPTOUCH_CUSTOM_LANG_DIRECTORY . '/wptouch-pro-' . $current_locale . '.mo';

			if ( file_exists( $custom_lang_file ) && is_readable( $custom_lang_file ) ) {
				$use_lang_file = $custom_lang_file;

				$rel_path = str_replace( WP_CONTENT_DIR, '../', WPTOUCH_CUSTOM_LANG_DIRECTORY );
				$use_lang_rel_path = $rel_path;
			} else {
				$lang_file = WPTOUCH_DIR . '/lang/wptouch-pro-' . $current_locale . '.mo';
				if ( file_exists( $lang_file ) && is_readable( $lang_file ) ) {
					$use_lang_file = $lang_file;
					$use_lang_rel_path = 'wptouch-pro-3/lang';
				}
			}

			add_filter( 'plugin_locale', array( &$this, 'get_wordpress_locale' ), 10, 2 );

			$this->locale = $current_locale;

			if ( $use_lang_file ) {
				$can_load = true;
				if ( is_admin() && !$settings->translate_admin ) {
					$can_load = false;
				}

				if ( $can_load ) {
					load_plugin_textdomain( 'wptouch-pro', false, $use_lang_rel_path );

					WPTOUCH_DEBUG( WPTOUCH_INFO, 'Loading language file ' . $use_lang_file );
				}
			}

			do_action( 'wptouch_language_loaded', $this->locale );
		}
	}

	function get_wordpress_locale( $locale, $domain ) {
		if ( $domain == 'wptouch-pro' ) {
			return $this->locale;
		} else {
			return $locale;
		}
	}

	function get_setting_defaults( $domain ) {
		$setting_defaults = new WPtouchSettings;

		if ( $domain == 'wptouch_pro' ) {
			$setting_defaults = new WPtouchDefaultSettings30;
		} else if ( $domain == 'bncid' ) {
			$setting_defaults = new WPtouchDefaultSettingsBNCID30;
		} else if ( $domain == 'compat' ) {
			$setting_defaults = new WPtouchDefaultSettingsCompat;
		} else {
			$setting_defaults = apply_filters( 'wptouch_setting_defaults', $setting_defaults, $domain );
			$setting_defaults = apply_filters( 'wptouch_setting_defaults_' . wptouch_strip_dashes( $domain ), $setting_defaults );
		}

		return $setting_defaults;
	}

	function get_active_setting_domains() {
		$active_domains = array( 'wptouch_pro', 'bncid' , 'compat' );

		return apply_filters( 'wptouch_registered_setting_domains', $active_domains );
	}

	function get_wp_setting_name_for_domain( $domain ) {
		return 'wpts_' . wptouch_strip_dashes( $domain );
	}

	function get_settings( $domain = 'wptouch_pro', $clone_it = true ) {
		// Load main settings information
		require_once( WPTOUCH_DIR . '/core/class-wptouch-pro-settings.php' );

		$settings = new WPtouchSettings;

		if ( isset( $this->settings_objects[ $domain ] ) ) {
			// settings have been loaded before
			$settings = $this->settings_objects[ $domain ];
		} else {
			// settings have not been loaded
			$setting_name = $this->get_wp_setting_name_for_domain( $domain );
			$settings = get_option( $setting_name, false );
			if ( !$settings ) {
				// Nothing stored in the database, return default settings
				$settings = $this->get_setting_defaults( $domain );
			} else {
				// Check for stray serialization
				if ( is_serialized( $settings ) ) {
					$settings = unserialize( $settings );
				}

				$defaults = $this->get_setting_defaults( $domain );

				// Merge in default settings
				foreach( (array)$defaults as $name => $value ) {
					if ( !isset( $settings->$name ) ) {
						$settings->$name = $value;
					}
				}
			}
		}

		// Old settings filter
		if ( $domain == 'wptouch_pro' ) {
			$settings = apply_filters( 'wptouch_settings', $settings );
		}

		$settings = apply_filters( 'wptouch_settings_domain', $settings, $domain );

		// Update our internal cache of the settings
		$this->settings_objects[ $domain ] = $settings;

		if ( $clone_it ) {
			$new_domain = clone $settings;
			$new_domain->domain = $domain;
			return $new_domain;
		} else {
			$settings->domain = $domain;
			return $settings;
		}
	}

	function reload_settings() {
		$this->settings_objects = array();
	}

	function add_default_wordtwit_pro_settings( $defaults ) {
		if ( function_exists( 'wordtwit_wptouch_has_accounts' ) && wordtwit_wptouch_has_accounts() ) {
			$accounts = wordtwit_wptouch_get_accounts();

			foreach( $accounts as $name => $account ) {
				$setting_name = 'wordtwit_account_' . $name;

				$defaults->$setting_name = true;
			}
		}

		return $defaults;
	}

	function get_supported_device_classes() {
		global $wptouch_device_classes;

		$supported_classes = apply_filters( 'wptouch_supported_device_classes', $wptouch_device_classes );

		foreach( $wptouch_device_classes as $device_class => $device_info ) {
			$supported_classes[] = $device_class;
		}

		return $supported_classes;
	}

	function get_supported_theme_device_classes() {
		global $wptouch_device_classes;

		// Get a list of all supported mobile device classes
		$supported_device_classes = apply_filters( 'wptouch_theme_device_classes', $this->get_supported_device_classes() );

		$device_listing = array();
		foreach( $wptouch_device_classes as $class_name => $class_info ) {
			if ( in_array( $class_name, $supported_device_classes ) ) {
				if ( file_exists( $this->get_current_theme_directory() . '/' . $class_name ) ) {
					$device_listing[ $class_name ] = $class_info;
				}
			}
		}

		// We have a complete list of device classes and device user agents
		// but we'll give themes and plugins a chance to modify them
		return apply_filters( 'wptouch_supported_device_classes', $device_listing );
	}

	function get_supported_user_agents() {
		// Get a list of the supported theme device classes
		$device_listing = $this->get_supported_theme_device_classes();

		// Now we'll create a master list of user agents
		$useragents = array();
		foreach( $device_listing as $device_class => $device_user_agents ) {
			$useragents = array_merge( $useragents, $device_user_agents );
		}

		return apply_filters( 'wptouch_supported_agents', $useragents );
	}

	function inject_preview_javascript() {
		echo $this->load_file( WPTOUCH_DIR . '/admin/js/wptouch-preview.js' );
	}

	function user_agent_matches( $browser_user_agent, $user_agent_to_check ) {
		$is_detected = true;

		if ( is_array( $user_agent_to_check ) ) {
			$check_against = $user_agent_to_check;
		} else {
			$check_against = array( $user_agent_to_check );
		}

		foreach( $check_against as $this_user_agent ) {
			$friendly_agent = preg_quote( $this_user_agent );

			if ( !preg_match( "#$friendly_agent#i", $browser_user_agent ) ) {
				$is_detected = false;
				break;
			}
		}

		return $is_detected;
	}

	function is_supported_device() {
		global $wptouch_exclusion_list;

		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$settings = $this->get_settings();

		// If we're in preview mode, always say it's a supported device
		if ( $this->is_in_preview_mode() ) {
			return true;
		}

		// If our preview parameter is set, we also are a supported device
		if ( $this->is_previewing_mobile_theme() ) {
			return true;
		}

		// Now that preview mode is out of the way, let's figure out the proper list of user agents
		$supported_agents = $this->get_supported_user_agents();

		// Figure out the active device type and the active device class
		foreach( $supported_agents as $agent ) {
			if ( $this->user_agent_matches( $user_agent, $agent ) ) {
				$agent_ok = true;

				$exclusion_list = apply_filters( 'wptouch_exclusion_list', $wptouch_exclusion_list );

				foreach( $exclusion_list as $exclude_user_agent ) {
					$friendly_exclude = preg_quote( $exclude_user_agent );
					if ( preg_match( "#$friendly_exclude#i", $user_agent ) ) {
						$agent_ok = false;
						break;
					}
				}

				if ( !$agent_ok ) {
					continue;
				}

				$this->active_device = $agent;

				$supported_device_classes = $this->get_supported_theme_device_classes();
				foreach ( $supported_device_classes as $device_class => $device_user_agents ) {
					if ( in_array( $agent, $device_user_agents ) ) {
						$this->active_device_class = $device_class;
					}
				}

				return true;
			} else {
				$this->active_device = $this->active_device_class = false;
			}
		}

		return false;
	}

	function is_in_preview_mode() {
		$settings = $this->get_settings();
		return ( $settings->preview_mode == 'on' && current_user_can( 'manage_options' ) );
	}

	function is_previewing_mobile_theme() {
		return ( isset( $this->get[ 'wptouch_preview_theme'] ) && $this->get[ 'wptouch_preview_theme' ] == 'enabled' );
	}

	function get_active_device_class() {
		$settings = $this->get_settings();

		if ( $this->is_in_preview_mode() ) {
			// the default theme for preview mode is the iphone
			// a developer could override this by implementing the following filter in the functions.php file of the active theme
			return apply_filters( 'wptouch_preview_mode_device_class', 'default' );
		} else if ( $this->is_previewing_mobile_theme() ) {
			return 'default';
		} else {
			return $this->active_device_class;
		}
	}

	function activate_license() {
		WPTOUCH_DEBUG( WPTOUCH_INFO, 'Attempting to activate a site license' );
		$bnc_api = $this->get_bnc_api();
		if ( $bnc_api ) {
			WPTOUCH_DEBUG( WPTOUCH_INFO, 'Adding license for wptouch-pro-3' );
			$bnc_api->user_add_license( 'wptouch-pro-3' );

			$settings = wptouch_get_settings( 'bncid' );

			// Force a license check next time
			$settings->last_bncid_time = 0;

			$settings->save();
		}
	}

	function remove_license( $site = false ) {
		$bnc_api = $this->get_bnc_api();
		if ( $bnc_api ) {
			if ( !$site ) {
				$site = $this->post['site'];
			}

			$bnc_api->user_remove_license( 'wptouch-pro-3', $site );
		}
	}

	function get_active_mobile_device() {
		return $this->active_device;
	}

	function active_mobile_device() {
		echo $this->get_active_mobile_device();
	}

	function get_bnc_api() {
		return $this->bnc_api;
	}

	function has_site_license() {
		$api = $this->get_bnc_api();
		$licenses = $api->user_list_licenses( 'wptouch-pro-3' );
		$this_site = $_SERVER['HTTP_HOST'];
		return ( in_array( $this_site, (array)$licenses['licenses'] ) );
	}

	function setup_bncapi( $bncid = 'default', $key = 'default' ) {
		if ( !$this->bnc_api ) {
			require_once( WPTOUCH_DIR . '/core/class-bncapi.php' );
			require_once( WPTOUCH_DIR . '/core/bncid.php' );

			$settings = $this->get_settings( 'bncid' );

			if ( $bncid == 'default' ) {
				$bncid = $settings->bncid;
			}

			if ( $key == 'default' ) {
				$key = $settings->wptouch_license_key;
			}

			$this->bnc_api = new BNCAPI( $bncid, $key );
		}
	}

	function handle_footer() {
		$settings = wptouch_get_settings();

		if ( $settings->show_wptouch_in_footer ) {
			echo wptouch_capture_include_file( WPTOUCH_DIR . '/include/html/footer.php' );
		}

		if ( $settings->show_footer_load_times ) {
			echo apply_filters( 'wptouch_footer_load_time', wptouch_capture_include_file( WPTOUCH_DIR . '/include/html/load-times.php' ) );
		}

		if ( $settings->custom_stats_code ) {
			echo apply_filters( 'wptouch_custom_stats_code', $settings->custom_stats_code );
		}
	}

	function handle_custom_footer_styles() {
		$settings = wptouch_get_settings();

		if ( $settings->custom_css_file ) {
			wp_enqueue_style( 'wptouch-custom', $settings->custom_css_file, false, WPTOUCH_VERSION, 'all' );
		}
	}

	function redirect_to_page( $url ) {
		header( 'Location: ' . urldecode( $url ) );
		die;
	}

	function check_for_redirect() {
		$settings = $this->get_settings();
		if ( $this->is_front_page() ) {
			$redirect_target = false;

			switch( $settings->homepage_landing ) {
				case 'select':
					$redirect_target = get_permalink( $settings->homepage_redirect_wp_target );
					break;
				case 'custom':
					$redirect_target = $settings->homepage_redirect_custom_target;
					break;
				case 'none':
					break;
			}

			if ( $redirect_target ) {
				$can_do_redirect = true;
				if ( get_option( 'show_on_front', false ) == 'page' ) {
					$front_page = get_option( 'page_on_front' );
					if ( $front_page == $settings->homepage_redirect_wp_target ) {
						$can_do_redirect = false;
					}
				}

				if ( $can_do_redirect ) {
					$this->redirect_to_page( $redirect_target );
				}
			}
		}
	}

	function is_front_page() {
		$front_option = get_option( 'show_on_front', false );
		if ( $front_option == 'page' ) {
			$front_page = get_option( 'page_on_front' );
			if ( $front_page ) {
				return is_front_page();
			} else {
				return is_home();
			}
		} else {
			// user hasn't defined a dedicated front page, so we return true when on the blog page
			return is_home();
		}
	}

	function setup_wptouch_admin_ajax() {
		add_action( 'wp_ajax_wptouch_ajax', array( &$this, 'admin_ajax_handler' ) );
	}

	function admin_ajax_handler() {
		if ( current_user_can( 'manage_options' ) ) {
			// Check security nonce
			$wptouch_nonce = $this->post['wptouch_nonce'];

			if ( !wp_verify_nonce( $wptouch_nonce, 'wptouch_admin' ) ) {
				WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Invalid security nonce for AJAX call' );
				exit;
			}

			$this->setup_bncapi();
			header( 'HTTP/1.1 200 OK' );

			// AJAX is split out into another file to reduce class load times for main WPtouch Pro class
			require_once( WPTOUCH_DIR . '/core/admin-ajax.php' );
			wptouch_admin_handle_ajax( $this, $this->post['wptouch_action'] );
		} else {
			WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Insufficient security privileges for AJAX call' );
		}

		die;
	}

	function check_directories() {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );
		$creation_failure = false;

		$directories_to_check = apply_filters(
			'wptouch_create_directories',
			array(
				WPTOUCH_BASE_CONTENT_DIR,
				WPTOUCH_TEMP_DIRECTORY,
				WPTOUCH_TEMP_DIRECTORY,
				WPTOUCH_BASE_CONTENT_DIR . '/cache',
				WPTOUCH_BASE_CONTENT_DIR . '/themes',
				WPTOUCH_BASE_CONTENT_DIR . '/modules',
				WPTOUCH_CUSTOM_SET_DIRECTORY,
				WPTOUCH_CUSTOM_ICON_DIRECTORY,
				WPTOUCH_CUSTOM_LANG_DIRECTORY,
				WPTOUCH_CUSTOM_UPLOAD_DIRECTORY,
				WPTOUCH_BACKUP_DIRECTORY,
				WPTOUCH_DEBUG_DIRECTORY
			)
		);

		// Loop through all directories
		foreach( $directories_to_check as $dir_name ) {
			$creation_failure = $creation_failure | !wptouch_create_directory_if_not_exist( $dir_name );
		}

		if ( $creation_failure ) {
			WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Unable to create one or more directories' );
			$this->add_notification(
				__( 'Directory Problem', 'wptouch-pro' ),
				__( 'One or more required directories could not be created', 'wptouch-pro' )
			);
		}
	}

	function get_excerpt_length( $length ) {
		return apply_filters( 'wptouch_excerpt_length', WPTOUCH_EXCERPT_LENGTH );
	}

	function get_excerpt_more( $more ) {
		$settings = $this->get_settings();

		return apply_filters( 'wptouch_excerpt_more', ' ...' );
	}

	function load_file( $file_name ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		return wptouch_load_file( $file_name );
	}

	function get_current_theme_directory() {
		return WP_CONTENT_DIR . $this->get_current_theme_location();
	}

	function get_current_theme_uri() {
		return wptouch_check_url_ssl( WP_CONTENT_URL . $this->get_current_theme_location() );
	}

	function get_current_theme() {
		$settings = $this->get_settings();

		return $settings->current_theme_name;
	}

	function get_current_theme_location() {
		$settings = $this->get_settings();

		return $settings->current_theme_location . '/' . $settings->current_theme_name;
	}

	function setup_theme_styles() {
		$settings = $this->get_settings();

		// Add the default stylesheet to the end, use min if available
		$dependencies = array();
		if ( $this->has_parent_theme() ) {
			$dependencies = array( 'wptouch-parent' );
			$parent_info = $this->get_parent_theme_info();

			$css_file = $this->check_and_use_css_file(
				$parent_info->location . '/' . $this->get_active_device_class() . '/style.css',
				WP_CONTENT_DIR,
				WP_CONTENT_URL
			);

			wp_enqueue_style( 'wptouch-parent', wptouch_check_url_ssl( $css_file ), false, WPTOUCH_VERSION );
			do_action( 'wptouch_parent_style_queued' );

			// Load parent RTL css file
			if ( wptouch_should_load_rtl() && file_exists( WP_CONTENT_DIR . '/' . $parent_info->location . '/' . $this->get_active_device_class() . '/' . $parent_info->location . '-rtl.css' ) ) {
				wp_enqueue_style(
					'wptouch-parent-rtl',
					wptouch_check_url_ssl( $this->check_and_use_css_file(
						$parent_info->location . '/' . $this->get_active_device_class() . '/' . $parent_info->location . '-rtl.css',
						WP_CONTENT_DIR,
						WP_CONTENT_URL
					) ),
		 			array( 'wptouch-parent' ),
		 			WPTOUCH_VERSION
		 		);
			}
		}

		$css_file = $this->check_and_use_css_file(
			$settings->current_theme_location . '/' . $settings->current_theme_name . '/' . $this->get_active_device_class() . '/style.css',
			WP_CONTENT_DIR,
			WP_CONTENT_URL
		);

		wp_enqueue_style( 'wptouch', wptouch_check_url_ssl( $css_file ), $dependencies, WPTOUCH_VERSION );

		// Load child RTL css file
		if ( wptouch_should_load_rtl() && file_exists( WP_CONTENT_DIR . '/' . $settings->current_theme_location . '/' . $settings->current_theme_name . '/' . $this->get_active_device_class() . '/' . $settings->current_theme_name . '-rtl.css' ) ) {
			wp_enqueue_style(
				'wptouch-rtl',
				wptouch_check_url_ssl( $this->check_and_use_css_file(
					$settings->current_theme_location . '/' . $settings->current_theme_name . '/' . $this->get_active_device_class() . '/' . $settings->current_theme_name . '-rtl.css',
					WP_CONTENT_DIR,
					WP_CONTENT_URL
				) ),
	 			array( 'wptouch' ),
	 			WPTOUCH_VERSION
	 		);
	 		
		}
	}

	function setup_child_theme_styles() {
		$css_file = $this->check_and_use_css_file( $this->get_stylesheet_directory( false )  . '/style.css' );
		wp_enqueue_style( 'wptouch_child', wptouch_check_url_ssl( $css_file ), array( 'wptouch-parent' ), WPTOUCH_VERSION );
	}

	function handle_desktop_switch_ajax() {
		$this->show_desktop_switch_link( true );
		die;
	}

	function show_desktop_switch_link( $ajax_request = false ) {
		require_once( WPTOUCH_DIR . '/core/theme.php' );
		require_once( WPTOUCH_DIR . '/core/globals.php' );

		if ( $ajax_request ) {
			// Do the actual output
			if ( $this->is_mobile_device && !$this->showing_mobile_theme ) {
				if ( file_exists( WPTOUCH_DIR . '/include/html/desktop-switch.php' ) ) {
					$settings = wptouch_get_settings();
					if ( $settings->switch_link_method != 'template_tag' ) {
						wptouch_show_desktop_switch_link();
					}
				}
			}
		} else {
			$settings = wptouch_get_settings();

			if ( $settings->switch_link_method == 'ajax' ) {
				echo "<div id='wptouch_desktop_switch'></div>\n";
				echo "<script type='text/javascript'>var wptouchAjaxUrl = '" . admin_url('admin-ajax.php') . "'; wptouchAjaxNonce = '" . $this->desktop_ajax_nonce . "'; wptouchAjaxSwitchLocation = '" . esc_attr( $_SERVER[ 'REQUEST_URI' ] ) . "';</script>\n";
				echo "<script type='text/javascript' src='" . WPTOUCH_URL . "/include/js/desktop-switch.js'></script>\n";				
			} else if ( $this->is_mobile_device && !$this->showing_mobile_theme ) {
				wptouch_show_desktop_switch_link();
			}
		}
	}

	function verify_post_nonce() {
		$nonce = $this->post['wptouch-admin-nonce'];
		if ( !wp_verify_nonce( $nonce, 'wptouch-post-nonce' ) ) {
			WPTOUCH_DEBUG( WPTOUCH_SECURITY, "Unable to verify WPtouch post nonce" );
			die( 'Unable to verify WPtouch Pro post nonce' );
		}

		return true;
	}

	function reset_icon_states() {
		global $wpdb;

		$wpdb->query(
			$wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = %s', '_wptouch_pro_menu_item_disabled' )
		);

		$wpdb->query(
			$wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = %s', '_wptouch_pro_menu_item_icon' )
		);

		$settings = wptouch_get_settings();
		$settings->default_menu_icon = WPTOUCH_DEFAULT_MENU_ICON;
		$settings->save();
	}

	function erase_all_settings() {
		WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Erasing all settings' );
		$this->load_root_functions_files();

		$setting_domains = $this->get_active_setting_domains();

		if ( is_array( $setting_domains ) && count( $setting_domains ) ) {
			foreach( $setting_domains as $domain ) {
				$setting_name = $this->get_wp_setting_name_for_domain( $domain );
				delete_option( $setting_name );
			}
		}

		$this->settings_objects = array();
	}

	function process_submitted_settings() {
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			return;
		}

		require_once( WPTOUCH_DIR . '/core/admin-settings.php' );
		wptouch_settings_process( $this );
	}

	function get_theme_copy_num( $base ) {
		$num = 1;
		while( true ) {
			if ( !file_exists( WPTOUCH_CUSTOM_THEME_DIRECTORY . '/' . $base . '-copy-' . $num ) ) {
				break;
			}

			$num++;
		}

		return $num;
	}

	function save_settings( $settings, $domain = 'wptouch_pro' ) {
		if ( $domain == 'wptouch_pro' ) {
			$settings = apply_filters( 'wptouch_update_settings', $settings );
		}

		// 3.0 domain specific filtering
		$settings = apply_filters( 'wptouch_update_settings_domain', $settings, $domain );

		WPTOUCH_DEBUG( WPTOUCH_VERBOSE, 'Saving settings to database' );

		// Save the old domain
		$old_domain = $settings->domain;
		unset( $settings->domain );

		$setting_name = $this->get_wp_setting_name_for_domain( $domain );

		delete_option( $setting_name );
		add_option( $setting_name, $settings, '', 'no' );

		// Restore old domain
		$settings->domain = $old_domain;

		require_once( WPTOUCH_DIR . '/core/menu.php' );

		$this->settings_objects[ $domain ] = $settings;
	}

	function recursive_copy( $source_dir, $dest_dir ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		wptouch_recursive_copy( $source_dir, $dest_dir );
	}

	function recursive_delete( $source_dir ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		wptouch_recursive_delete( $source_dir );
	}

	function mwp_get_latest_info() {
    	$latest_info = false;

    	// Do some basic caching
    	$mwp_info = get_option( 'wptouch_pro_mwp', false );
    	if ( !$mwp_info || !is_object( $mwp_info ) ) {
    		$mwp_info = new stdClass;
    		$mwp_info->last_check = 0;
    		$mwp_info->last_result = false;
    	}

    	$time_since_last_check = time() - $mwp_info->last_check;
    	if ( $time_since_last_check > 300 ) {
    		$this->setup_bncapi();
	    	$bnc_api = $this->get_bnc_api();
	    	if ( $bnc_api ) {
	    		$latest_info = $bnc_api->get_product_version( 'wptouch-pro' );
	    		if ( $latest_info ) {
	    			$mwp_info->last_result = $latest_info;
	    			$mwp_info->last_check = time();

	    			// Save the result
	    			update_option( 'wptouch_pro_mwp', $mwp_info );
	    		}
	    	}
    	} else {
    		// Use the cached copy
    		$latest_info = $mwp_info->last_result;
    	}

    	return $latest_info;
	}
}
