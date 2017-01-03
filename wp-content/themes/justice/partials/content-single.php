<?php global $tpath_options, $post;
$image_size = 'blog-large';

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
			<?php } ?>
			
			<?php the_post_thumbnail( $image_size ); ?>
			
			<?php if( $post_format == 'link' && isset( $link_url ) && $link_url != '' ) { ?>
				</a>
			<?php } ?>
	
		</div>
	<?php } ?>
	</div>
<?php } ?>
<div class="post-content">
	
	<div class="entry-meta-list">
		<ul class="entry-meta">
			<?php if( ! $tpath_options['tpath_blog_post_meta_author'] ): ?>
			<li class="author"><?php echo esc_html__( 'Posted by ', 'Templatepath' ); the_author_posts_link(); ?></li>
			<?php endif; ?>
			<?php if( ! $tpath_options['tpath_blog_post_meta_date'] ): ?>
			<li class="date"><?php echo get_the_time( $tpath_options['tpath_blog_date_format'] ); ?></li>
			<?php endif; ?>
			<li class="category"><?php echo get_the_category_list(', '); ?></li>
			<?php if ( comments_open() ) { ?>
				<li class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comment', 'Templatepath' ) . '</span>', __( '1 Comment', 'Templatepath' ), __( '% Comments', 'Templatepath' ) ); ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	
	<?php if( $post_format == 'quote' ) { ?>
	<div class="entry-content">
		<div class="entry-quotes quote-format">
			<blockquote>
				<?php the_content(); ?>
			</blockquote>
		</div>
	</div>		
	<?php } else { ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php } ?>
	
	<?php if( $tpath_options['tpath_blog_social_sharing'] || has_tag() ) { ?>
		<div class="tag-share-wrapper">
			<?php if( has_tag() ) { ?>
				<div class="tags-share-section">					
					<?php the_tags('<div class="post-tags"><h6 class="inline-block">'.esc_html__('Tags:', 'Templatepath').'</h6>', ',', '</div>'); ?>
				</div>			
			<?php } ?>
			<?php if( $tpath_options['tpath_blog_social_sharing'] ) {
				echo '<div class="share-options">';
				justice_display_social_sharing_icons();
				echo '</div>';
			} ?>
		</div>
	<?php } ?>
</div>