<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package TemplatePath
 */
 
global $tpath_options;
$sidebar_widget = $layout = $home_id = '';

	if( is_singular() ) {
		$layout = get_post_meta( $post->ID, 'tpath_layout', true );
		$sidebar_widget = get_post_meta( $post->ID, 'tpath_primary_sidebar', true );
	}
		
	if( is_archive() ) {
		$layout = $tpath_options['tpath_blog_archive_layout'];
	}
	
	if( is_home() ) {
		$home_id = get_option( 'page_for_posts' );			
		$layout = get_post_meta( $home_id, 'tpath_layout', true );
		if( !$layout ) {
			$layout = $tpath_options['tpath_blog_layout'];
		}
		$sidebar_widget = get_post_meta( $home_id, 'tpath_primary_sidebar', true );
	}
	
	if( is_singular('tpath_portfolio') ) {
		$layout = $tpath_options['tpath_layout'];
	}
	
	if ( is_singular( 'post' ) ) {
		$layout = get_post_meta( $post->ID, 'tpath_layout', true );
		if( !$layout ) {
			$layout = $tpath_options['tpath_single_post_layout'];
		}
		$sidebar_widget = get_post_meta( $post->ID, 'tpath_primary_sidebar', true );
	}
		
	if( !$layout ) {			
		if( $tpath_options['tpath_layout'] != '' ) {
			$layout = $tpath_options['tpath_layout'];
		}
		else {
			$layout = 'one-col';
		}
	}
	
	if( is_singular() ) {
		$sidebar_widget = get_post_meta( $post->ID, 'tpath_primary_sidebar', true );
	}
	
	if( $sidebar_widget == '' || $sidebar_widget == '0' ) {
		$sidebar_widget = 'primary';
	}
	
	if( $layout != 'one-col' ) {
		
		if ( is_active_sidebar( $sidebar_widget ) ) {	
?>
<div id="sidebar" class="primary-sidebar sidebar pm-sidebar">
	<?php dynamic_sidebar( $sidebar_widget ); ?>	
</div><!-- #sidebar -->

<?php } // End Active Sidebar IF Statement

	} // End Layout IF Statement
?>