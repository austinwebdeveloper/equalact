<?php
/**
 * No Posts found Template
 *
 * It is used to display not found posts
 *
 * @package TemplatePath 
 */

global $tpath_options;
if( is_single() ) {
	$post_class = '';	
} elseif( is_archive() ) {	
	if( $tpath_options['tpath_archive_blog_type'] == 'large' ) {
		$post_class = 'large-posts col-sm-12';		
	} 
	elseif( $tpath_options['tpath_archive_blog_type'] == 'list' ) {
		$post_class = 'list-posts';			
	}
	elseif( $tpath_options['tpath_archive_blog_type'] == 'grid' ) {
		$post_class = 'grid-posts';			
	}
} else {	
	if( $tpath_options['tpath_blog_type'] == 'large' ) {
		$post_class = 'large-posts col-sm-12';		
	} 
	elseif( $tpath_options['tpath_blog_type'] == 'list' ) {
		$post_class = 'list-posts';
	} 
	elseif( $tpath_options['tpath_blog_type'] == 'grid' ) {
		$post_class = 'grid-posts';		
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<div class="posts-inner-container">
		<div class="posts-content-container">
			<div class="entry-header">			   
				<h1 class="entry-title"><?php esc_html_e('Nothing Found', 'Templatepath'); ?></h1>			
			</div><!-- .entry-header -->
			<div class="entry-content">
				<p><?php esc_html_e('Sorry, but no posts matched your search terms.', 'Templatepath'); ?></p>
			</div><!-- .entry-content -->
		</div><!-- .posts-content-container -->		
	</div><!-- .posts-inner-container -->
</article><!-- #post -->