		<?php do_action( 'wptouch_body_bottom' ); ?>
		
		<?php locate_template( 'footer-top.php', true ); ?>
		
		<div class="<?php wptouch_footer_classes(); ?>">
			<?php wptouch_footer(); ?>
		</div>
		
		<?php locate_template( 'switch-link.php', true ); ?>
	
	</div><!-- page wrapper -->
</body>
</html>
