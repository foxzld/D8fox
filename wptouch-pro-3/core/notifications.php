<?php

global $wptouch_plugin_notification_iterator;
global $wptouch_plugin_notification;

function wptouch_get_notification_count() {
	global $wptouch_pro;
	$settings = wptouch_get_settings();

	$warnings = apply_filters( 'wptouch_notifications', $wptouch_pro->notifications );

	$new_notifications = array();
	if ( is_array( $warnings ) && count( $warnings	 ) ) {
		foreach( $warnings as $key => $value ) {
			if ( !in_array( $key, $settings->dismissed_notifications ) ) {
				$new_notifications[ $key ] = $value;
			}
		}
	}

	return count( $new_notifications );
}

function wptouch_the_notification_count() {
	echo wptouch_get_notification_count();
}

function wptouch_get_notification_key() {
	global $wptouch_plugin_notification_iterator;

	return $wptouch_plugin_notification_iterator->the_key();
}

function wptouch_the_notification_key() {
	echo wptouch_get_notification_key();
}

function wptouch_has_notifications() {
	global $wptouch_pro;
	global $wptouch_plugin_notification_iterator;
	$settings = wptouch_get_settings();

	if ( !$wptouch_plugin_notification_iterator ) {
		$warnings = apply_filters( 'wptouch_notifications', $wptouch_pro->notifications );

		$new_notifications = array();
		if ( is_array( $warnings ) && count( $warnings ) ) {
			foreach( $warnings as $key => $value ) {
				if ( !in_array( $key, $settings->dismissed_notifications ) ) {
					$new_notifications[ $key ] = $value;
				}
			}
		}

		$wptouch_plugin_notification_iterator = new WPtouchArrayIterator( $new_notifications );
	}

	return $wptouch_plugin_notification_iterator->have_items();
}

function wptouch_the_notification() {
	global $wptouch_plugin_notification_iterator;
	global $wptouch_plugin_notification;

	if ( $wptouch_plugin_notification_iterator ) {
		$wptouch_plugin_notification = apply_filters( 'wptouch_notification', $wptouch_plugin_notification_iterator->the_item() );
	}
}

function wptouch_notification_the_name() {
	echo wptouch_notification_get_name();
}

function wptouch_notification_get_name() {
	global $wptouch_plugin_notification;
	return apply_filters( 'wptouch_notification_name', $wptouch_plugin_notification[0] );
}

function wptouch_notification_the_desc() {
	echo wptouch_notification_get_desc();
}

function wptouch_notification_get_desc() {
	global $wptouch_plugin_notification;
	return apply_filters( 'wptouch_notification_desc', $wptouch_plugin_notification[1] );
}

function wptouch_notification_get_type() {
	global $wptouch_plugin_notification;
	return apply_filters( 'wptouch_notification_type', $wptouch_plugin_notification[2] );
}

function wptouch_notification_the_type() {
	echo wptouch_notification_get_type();
}

function wptouch_notification_has_link() {
	global $wptouch_plugin_notification;

	return ( $wptouch_plugin_notification[3] );
}

function wptouch_notification_get_link() {
	global $wptouch_plugin_notification;

	return $wptouch_plugin_notification[3];
}

function wptouch_notification_the_link() {
	echo wptouch_notification_get_link();
}

function wptouch_notification_setup() {
	global $wptouch_pro;
	$settings = wptouch_get_settings();

	// Check if licensed
	if ( ( WPTOUCH_SIMULATE_ALL || !$settings->license_accepted ) ) {
		if ( wptouch_should_show_license_nag() ) {
			$wptouch_pro->add_notification(
				__( 'License Missing', 'wptouch-pro' ),
				__( 'This installation of WPtouch Pro is currently unlicensed.', 'wptouch-pro' ),
				'error',
				( wptouch_is_multisite_primary() ? admin_url( 'admin.php?page=wptouch-admin-license' ) : false )
			);
		}
	}

	// Upgrade available
	$version = wptouch_is_upgrade_available();
	if ( ( WPTOUCH_SIMULATE_ALL || $version ) ) {
		$wptouch_pro->add_notification(
			sprintf( __( 'WPtouch Pro %s', 'wptouch-pro' ), $version ),
			__( 'A new version of WPtouch Pro is available.', 'wptouch-pro' ),
			'upgrade',
			admin_url( 'plugins.php?plugin_status=upgrade' )
		);
	}

	// Error
	if ( WPTOUCH_SIMULATE_ALL || function_exists( 'wptouch_init' ) ) {
		$wptouch_pro->add_notification(
			'WPtouch 1.x',
			__( 'WPtouch Pro 3 cannot co-exist with WPtouch 1.x. Disable it first in the WordPress Plugins settings.', 'wptouch-pro' ),
			'error',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/known-incompatibilities/#wptouchfree'
		);
	}

	// Error
	if ( WPTOUCH_SIMULATE_ALL || defined( 'WPTOUCH_PRO_MIN_BACKUP_FILES' ) ) {
		$wptouch_pro->add_notification(
			'WPtouch 2.x',
			__( 'WPtouch Pro 3 cannot co-exist with WPtouch Pro 2.x. Disable it first in the WordPress Plugins settings.', 'wptouch-pro' ),
			'error',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/known-incompatibilities/#wptouch2'
		);
	}

	// Warning
	$permalink_structure = get_option('permalink_structure');
	if ( WPTOUCH_SIMULATE_ALL || !$permalink_structure ) {
		$wptouch_pro->add_notification(
			'WordPress Permalinks',
			__( 'WPtouch Pro prefers pretty permalinks to be enabled within WordPress.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/wordpress-permalinks/'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || ini_get('safe_mode' ) ) {
		$wptouch_pro->add_notification(
			'PHP Safe Mode',
			__( 'WPtouch Pro will not work fully in safe mode.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/php-safe-mode/'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || function_exists( 'wp_super_cache_init' ) ) {
		$wptouch_pro->add_notification(
			'WP Super Cache',
			__( 'Extra configuration is required. The plugin must be configured to exclude the user agents that WPtouch Pro uses.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/optimizing-caching-plugins-for-mobile-use/#supercache'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || class_exists( 'W3_Plugin_TotalCache' ) ) {
		$wptouch_pro->add_notification(
			'W3 Total Cache',
			__( 'Extra configuration is required. The plugin must be configured to exclude the user agents that WPtouch Pro uses.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/optimizing-caching-plugins-for-mobile-use/#W3totalcache'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || function_exists( 'hyper_activate' ) ) {
		$wptouch_pro->add_notification(
			'Hyper Cache',
			__( 'Extra configuration is required. The plugin must be configured to exclude the user agents that WPtouch Pro uses.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/optimizing-caching-plugins-for-mobile-use/#hypercache'
			);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || class_exists( 'WPMinify' ) ) {
		$wptouch_pro->add_notification(
			'WPMinify',
			__( 'Extra configuration is required. Add paths to your active WPtouch Pro theme CSS and Javascript files as files to ignore in WPMinify.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/wpminify/'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || function_exists( 'lightbox_styles' ) ) {
		$wptouch_pro->add_notification(
			'Lightbox 2',
			__( 'This plugin may not work correctly in WPtouch Pro, and should be disabled in the Plugin Compatibility section.', 'wptouch-pro' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/known-incompatibilities/#imageplugins'
		);
	}

	// Warning
	if ( WPTOUCH_SIMULATE_ALL || !is_writable( WPTOUCH_CUSTOM_SET_DIRECTORY ) ) {
		$wptouch_pro->add_notification(
			'Icon Installation Issue',
			sprintf( __( 'The %s%s%s directory is not currently writable. %sPlease fix this issue to enable installation of additional icon sets.', 'wptouch-pro' ), '', '/uploads/wptouch-data/icons', '', '' ),
			'warning',
			'http://derefer.me/?http://www.bravenewcode.com/support/knowledgebase/server-setup/#permissions'
		);
	}

//	if ( WPTOUCH_SIMULATE_ALL || function_exists( 'cfmobi_check_mobile' ) ) {
//		$wptouch_pro->add_notification(
//			'WP Mobile Edition',
//			__( 'Extra configuration is required. The plugin must be configured to exclude the user agents that WPtouch Pro uses.', 'wptouch-pro' ),
//			'warning',
//			'http://www.bravenewcode.com/support/knowledgebase/known-incompatibilities/#otherplugins'
//		);
//	}

//	if ( WPTOUCH_SIMULATE_ALL || ( function_exists( 'gallery_styles' ) && !$settings->plugin_disable_featured_content_gallery ) ) {
//		$wptouch_pro->add_notification(
//			'Featured Content Gallery',
//			__( 'The Featured Content Gallery plugin does not work correctly with WPtouch Pro. Please disable it in the Plugin Compatibility section.', 'wptouch-pro' ),
//			'warning',
//			'http://www.bravenewcode.com/support/knowledgebase/known-incompatibilities/#imageplugins'
//		);
//	}

}