<?php

define( 'WPTOUCH_PRO_BNCAPI_PRODUCT_NAME', 'wptouch-pro-3' );
define( 'WPTOUCH_BNCID_CACHE_TIME', 3600 );

function wptouch_has_license() {
	global $wptouch_pro;
	$wptouch_pro->setup_bncapi();

	return $wptouch_pro->bnc_api->verify_site_license( WPTOUCH_PRO_BNCAPI_PRODUCT_NAME );
}

function wptouch_is_upgrade_available() {
	global $wptouch_pro;
	$wptouch_pro->check_for_update();

	if ( function_exists( 'is_super_admin' ) ) {
		$upgrade_available = get_site_transient( WPTOUCH_VERSION_TRANSIENT );
	} else {
		$upgrade_available = get_transient( WPTOUCH_VERSION_TRANSIENT );
	}

	return $upgrade_available;
}

function wptouch_reset_upgrade_available() {
	if ( function_exists( 'is_super_admin' ) ) {
		delete_site_transient( WPTOUCH_VERSION_TRANSIENT );
	} else {
		delete_transient( WPTOUCH_VERSION_TRANSIENT );
	}
}