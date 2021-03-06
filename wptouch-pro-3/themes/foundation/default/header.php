<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title( ' | ', true, 'right' ); ?></title>
		<?php wptouch_head(); ?>
	</head>
	
	<!-- Help speed up display of the page -->
	<?php flush(); ?>
	
	<body <?php body_class( wptouch_get_body_classes() ); ?>>
		
		<?php do_action( 'wptouch_preview' ); ?>
		
		<?php do_action( 'wptouch_body_top' ); ?>
		
		<?php locate_template( 'header-bottom.php', true ); ?>