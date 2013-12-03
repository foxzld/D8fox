
<?php  if ( is_single() || ( is_page() && wptouch_fdn_is_web_app_mode() ) ) { ?>
	<div class="nav-bar clearfix">		
		<?php if ( is_single() ) { ?>
			<div class="nav-controls">
				<?php if ( wptouch_fdn_if_previous_post_link() ) { ?>
					<a  class="prev-post" href="<?php wptouch_fdn_get_previous_post_link(); ?>">
						<?php _e( "previous post", "wptouch-pro" ); ?>
					</a>
				<?php } ?>
					
				<?php if ( wptouch_fdn_if_next_post_link() ) { ?>
					<a class="next-post" href="<?php wptouch_fdn_get_next_post_link(); ?>">
						<?php _e( "next post", "wptouch-pro" ); ?>
					</a>
				<?php } ?>
			</div>
		<?php } ?>
	</div><!-- nav-bar -->
<?php } ?>