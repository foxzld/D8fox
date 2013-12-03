<?php

add_action( 'foundation_module_init_mobile', 'foundation_media_init' );

function foundation_media_init() {

	$settings = foundation_get_settings();
	if ( $settings->video_handling_type == 'fitvids' ) {

		// Load FitVids
		wp_enqueue_script( 
			'foundation_media_fitvids', 
			foundation_get_base_module_url() . '/media/fitvids.js', 
			array( 'foundation_base' ),
			FOUNDATION_VERSION,
			true
		);
	
	} elseif ( $settings->video_handling_type == 'fluidvids' ) {
	
		// Load Fluid Width Videos
		wp_enqueue_script( 
			'foundation_media_fluidvids', 
			foundation_get_base_module_url() . '/media/fluid-width-videos.js', 
			array( 'foundation_base' ),
			FOUNDATION_VERSION,
			true
		);
	
	}
	
	if ( $settings->video_handling_type != 'none' ) {
		wp_enqueue_script( 
			'foundation_media_handling', 
			foundation_get_base_module_url() . '/media/media.js',
			false,
			FOUNDATION_VERSION,
			true 
		);
	}
	
}