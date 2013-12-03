<?php

add_action( 'wp_enqueue_scripts', 'classic_enqueue_scripts' );

function classic_enqueue_scripts() {
	wp_enqueue_script( 
		'classic-js', 
		get_bloginfo( 'stylesheet_directory' ) . '/classic.js', 
		array( 'jquery' ), 
		CLASSIC_THEME_VERSION, 
		true 
	);
}

function classic_should_show_thumbnail() {
	$settings = classic_get_settings();

	switch( $settings->use_thumbnails ) {
		case 'none':
			return false;
		case 'index':
			return is_home();
		case 'index_single':
			return is_home() || is_single();
		case 'all':
			return is_home() || is_single() || is_page() || is_archive() || is_search();
		default:
			// in case we add one at some point
			return false;
	}
}

function classic_css_noise() {
	$classic_settings = classic_get_settings();

	if ( $classic_settings->css_noise ) {
		echo 'noise';
		return true;
	} else {
		return false;
	}
}

function classic_should_show_taxonomy() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_taxonomy ) {
		return true;
	} else {
		return false;
	}
}

function classic_should_show_author() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_author ) {
		return true;
	} else {
		return false;
	}
}

function classic_should_show_date() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_date ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_menu_button_text() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->menu_button_as_text ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_page_titles() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_page_titles ) {
		return true;
	} else {
		return false;
	}
}