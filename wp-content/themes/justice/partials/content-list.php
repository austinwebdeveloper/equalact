<?php global $tpath_options, $post;

if($layout == 'list') {
	if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
		$excerpt_limit = 20;
	} else {
		$excerpt_limit = 30;
	}
	$image_size = 'blog-list';
} elseif($layout == 'grid') {
	$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_grid'];
	$image_size = 'theme-mid';
}

$post_id = get_the_ID();
$post_format = get_post_format();
				
$post_format_class = '';
if( $post_format == 'image' ) {
	$post_format_class = ' image-format';
} elseif( $post_format == 'quote' ) {
	$post_format_class = ' quote-image';
}

// Autoplay
if( $tpath_options['tpath_blog_slideshow_autoplay'] ) { 
	$auto_play = esc_attr( $tpath_options['tpath_blog_slideshow_autoplay'] ); 
} else { 
	$auto_play = 'false'; 
}
// Autoplay timeout
if( $tpath_options['tpath_blog_slideshow_autoplay_speed'] ) { 
	$autoplay_timeout = esc_attr( $tpath_options['tpath_blog_slideshow_autoplay_speed'] ); 
} else { 
	$autoplay_timeout = '5000'; 
}
// Animation Out Type
if( $tpath_options['tpath_blog_animation_out_type'] ) { 
	$animate_out = esc_attr( $tpath_options['tpath_blog_animation_out_type'] ); 
} else { 
	$animate_out = 'fadeOut'; 
}
// Animation In Type
if( $tpath_options['tpath_blog_animation_in_type'] ) { 
	$animate_in = esc_attr( $tpath_options['tpath_blog_animation_in_type'] ); 
} else { 
	$animate_in = 'fadeIn'; 
}
// Smart Speed
if( $tpath_options['tpath_blog_slideshow_speed'] ) { 
	$smart_speed = esc_attr( $tpath_options['tpath_blog_slideshow_speed'] ); 
} else { 
	$smart_speed = '450'; 
}
$data_attr = '';

$data_attr .= ' data-autoplay="'. $auto_play .'" ';
$data_attr .= ' data-autoplay-timeout="'. $autoplay_timeout .'" ';
$data_attr .= ' data-animate-out="'. $animate_out .'" ';
$data_attr .= ' data-animate-in="'. $animate_in .'" ';
$data_attr .= ' data-smart-speed="'. $smart_speed .'" ';

$link_url = '';
$link_url = get_post_meta( $post->ID, 'tpath_external_link_url', true ); 

if ( has_post_thumbnail() && ! post_password_required() ) { ?>
	<div class="post-media">
	<?php if( $post_format == 'gallery' ) { ?>
		<div class="entry-thumbnail">
			<?php echo '<div class="owl-carousel blog-carousel-slider"'.$data_attr .'>';
				get_gallery_post_images( $image_size, $post->ID );
			echo '</div>'; ?>
			
		</div>
	<?php } else { ?>
		<div class="entry-thumbnail<?php echo esc_attr( $post_format_class ); ?>">
			<?php if( $post_format == 'link' && isset( $link_url ) && $link_url != '' ) { ?>
				<a href="<?php echo esc_url( $link_url ); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
			<?php } else { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
			<?php } ?>
			<?php the_post_thumbnail( $image_size ); ?></a>
			</div>
			<?php } ?>
	</div>
<?php } ?>
<div class="post-content">
	<?php if( has_post_thumbnail() && ($layout == 'grid') ) { ?>
		<div class="post-author">
			<div class="post-author-image">
				<?php if( $tpath_options['tpath_blog_author_info'] ) {
					echo get_avatar( get_the_author_meta('email'), '80' ); 
				} ?>
			</div>
		</div>
		<div class="posted-date">
			<div class="entry-post-date">
				<?php echo esc_html__( 'Posted ', 'Templatepath' ); echo get_the_time( $tpath_options['tpath_blog_date_format'] ); ?>
			</div>
		</div>	
	<?php } ?>
				
	<div class="entry-header">
		<h3 class="entry-title">
			<?php if( $post_format == 'link' && isset( $link_url ) && $link_url != '' ) { ?>
				<a href="<?php echo esc_url( $link_url ); ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php } else { ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php } ?>
			
			<?php the_title(); ?></a>
		</h3>
	</div>

	<?php if( ! has_post_thumbnail() || ($layout == 'list') ) { ?>
		<div class="entry-meta-list">			    
			<ul class="entry-meta">	
				<?php if( ! $tpath_options['tpath_blog_post_meta_author'] ): ?>
				<li class="author"><?php echo esc_html__( 'Posted by ', 'Templatepath' ); the_author_posts_link(); ?></li>
				<?php endif; ?>
				<?php if( ! $tpath_options['tpath_blog_post_meta_date'] ): ?>
				<li class="date"><?php echo get_the_time( $tpath_options['tpath_blog_date_format'] ); ?></li>
				<?php endif; ?>
			</ul>
		</div><!-- .entry-meta-list -->				
	<?php  } ?>
	
	<?php if( $post_format == 'quote' ) { ?>
	<div class="entry-summary">
		<div class="entry-quotes quote-format">
			<blockquote>
				<?php echo justice_custom_wp_trim_excerpt('', $excerpt_limit); ?>
			</blockquote>
		</div>
	</div>		
	<?php } else { ?>
	<div class="entry-summary">
		<?php echo justice_custom_wp_trim_excerpt('', $excerpt_limit); ?>
	</div>
	<?php } ?>
	
	<div class="entry-footer">
		<div class="read-more">
			<?php if( $post_format == 'link' && isset( $link_url ) && $link_url != '' ) { ?>
				<a href="<?php echo esc_url( $link_url ); ?>" class="post-btn btn-more read-more-link" title="<?php the_title(); ?>">
			<?php } else { ?>
				<a href="<?php the_permalink(); ?>" class="post-btn btn-more read-more-link" title="<?php the_title(); ?>">
			<?php } ?>
				
				<?php if( ! $tpath_options['tpath_blog_read_more_text'] ) { echo esc_html__('Read More', 'Templatepath'); } 
				else { echo esc_attr( $tpath_options['tpath_blog_read_more_text'] ); } ?>
				
			</a>
		</div>
	</div>
</div>