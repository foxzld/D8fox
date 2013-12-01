<div class="sticky">
	<h2 class="title">置顶推荐</h2>
	<ul>
	<?php $sticky = get_option('sticky_posts'); rsort( $sticky );
		query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1, 'showposts' => dopt('d_sticky_count')?dopt('d_sticky_count'):2 ) );
		while (have_posts()) : the_post(); 

		echo '<li class="item"><a href="'.get_permalink().'">';
		echo deel_thumbnail();

		echo '<h3>'.get_the_title().'</h3><p class="muted">'.deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 48, '...').'</p>';

		echo '</a></li>';

		endwhile; 
		wp_reset_query(); 
	?>
	</ul>
</div>