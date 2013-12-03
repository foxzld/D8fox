<?php

add_action( 'foundation_module_init_mobile', 'foundation_featured_init' );
add_action( 'init', 'foundation_featured_setup' );

define( 'FOUNDATION_FEATURED_MIN_NUM', 2 );

global $foundation_featured_args;
global $foundation_featured_posts;
global $foundation_featured_data;

function foundation_featured_init() {
	wp_enqueue_script( 
		'foundation_featured', 
		foundation_get_base_module_url() . '/featured/swipe.min.js',
		false,
		FOUNDATION_VERSION,
		true
	);

	wp_enqueue_script( 
		'foundation_featured_init', 
		foundation_get_base_module_url() . '/featured/wptouch-swipe.js',
		'foundation_featured',
		FOUNDATION_VERSION,
		true
	);

	foundation_determine_images();
}

function foundation_featured_setup() {
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'foundation_featured_image', 900, 676, false ); 
	}
}

function foundation_featured_config( $args ) {
	global $foundation_featured_args;

	$foundation_featured_args = $args;
}

function foundation_featured_modify_query( $query ) {
	$settings = foundation_get_settings();
	if ( $settings->featured_filter_posts ) {
		return;
	}

	$should_be_ignored = apply_filters( 
		'foundation_featured_should_modify_query', 
		$query->is_single || $query->is_page || $query->is_feed || $query->is_search || $query->is_archive || $query->is_category, 
		$query 
	);
	if ( $should_be_ignored ) {
		return;
	}
	
	global $foundation_featured_posts;

	if ( count( $foundation_featured_posts ) < FOUNDATION_FEATURED_MIN_NUM ) {
		return $query;
	}

	$post_array = array();

	foreach( $foundation_featured_posts as $post_id ) {
		$post_array[] = '-' . $post_id;
	}

	$query->query_vars[ 'post__not_in']  = $post_array;

	return $query;
}

function foundation_featured_get_args() {
	global $foundation_featured_args;

	$defaults = array(
		'type' => 'post',
		'num' => 5,
		'show_dots' => true,		// might not be needed
		'before' => '',
		'after' => '',
		'max_search' => 20	
	);	
	// Parse defaults into arguments
	return wp_parse_args( $foundation_featured_args, $defaults );			
}

function foundation_determine_images() {
	global $foundation_featured_posts;
	global $foundation_featured_data;
	global $post;

	$settings = foundation_get_settings();

	$foundation_featured_posts = array();
	$foundation_featured_data = array();

	$args = foundation_featured_get_args();

	$new_posts = false;
	switch( $settings->featured_type ) {
		case 'tag':
			$new_posts = new WP_Query( 'tag=' . $settings->featured_tag . '&posts_per_page=' . $args[ 'max_search' ] );
			break;
		case 'category':
			$new_posts = new WP_Query( 'category_name=' . $settings->featured_category . '&posts_per_page=' . $args[ 'max_search' ] );
			break;
		case 'posts':
			$post_ids = explode( ',', str_replace( ' ', '', $settings->featured_post_ids ) );
			if ( is_array( $post_ids ) && count( $post_ids ) ) {
				$new_posts = new WP_Query( array( 'post__in'  => $post_ids, 'posts_per_page' => $args[ 'max_search' ], 'post_type' => 'any' ) );	
			}
			break;
		case 'latest':
		default:
			break;			
	}

	if ( !$new_posts ) {
		$new_posts = new WP_Query( 'posts_per_page=' . $args[ 'max_search' ] );
	}
	
	while ( $new_posts->have_posts() ) { 
		$new_posts->the_post();	

		$image = get_the_post_thumbnail( $post->ID, 'foundation_featured_image' );
		$real_image = preg_match( '#src=\"(.*)\"#iU', $image, $matches );		

		if ( $real_image ) {
			$results = new stdClass;
			$results->image = $matches[1];
			$results->title = get_the_title();
			$results->link = get_permalink();

			$foundation_featured_data[] = $results;

			$foundation_featured_posts[] = $post->ID;
		}

		// Break out if we have enough images
		if ( count( $foundation_featured_data ) == $args[ 'num' ] ) {
			break;
		}
	}	

	add_filter( 'parse_query', 'foundation_featured_modify_query' );
}

function foundation_featured_get_slider_classes() {
	$settings = foundation_get_settings();

	$featured_classes = array( 'swipe' );

	if ( $settings->featured_grayscale ) {
		$featured_classes[] = 'grayscale';
	} 
	
	if ( $settings->featured_autoslide ) {
		$featured_classes[] = 'slide';
	} 
	
	if ( $settings->featured_continuous ) {
		$featured_classes[] = 'continuous';
	}

	switch( $settings->featured_speed ) {
		case 'slow':
			$featured_classes[] = 'slow';
			break;
		case 'fast':
			$featured_classes[] = 'fast';
			break;
	}
	
	return $featured_classes;
}

function foundation_featured_slider() {
	global $foundation_featured_data;
	$args = foundation_featured_get_args();
	$settings = foundation_get_settings();
	
	if ( count( $foundation_featured_data ) >= FOUNDATION_FEATURED_MIN_NUM ) {
		echo $args['before'];

		echo "<div id='slider' class='" . implode( ' ', foundation_featured_get_slider_classes() ) . "'>\n";
		echo "<div class='swipe-wrap'>\n";

		foreach( $foundation_featured_data as $image_data ) {
			echo "<div><a href='" . $image_data->link . "' class='needsclick'><img src='" . $image_data->image . "' alt='" . $image_data->title . "' / ><p>" . $image_data->title . "</p></a></div>";
		}
		echo "</div>\n";
		echo "</div>\n";
		echo $args['after'];		
	}
}