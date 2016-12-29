<?php
/**
 * Archive Template
 *
 * @package TemplatePath
 */
 
global $tpath_options;
get_header();
 
$container_class = $scroll_type = '';
if( $tpath_options['tpath_archive_blog_type'] == 'grid' ) {	
	if( $tpath_options['tpath_blog_grid_columns'] != '' ) {
		if( $tpath_options['tpath_blog_grid_columns'] == 'two' ) {
			$container_class = 'grid-layout grid-col-2';
		} elseif ( $tpath_options['tpath_blog_grid_columns'] == 'three' ) {
			$container_class = 'grid-layout grid-col-3';
		} elseif ( $tpath_options['tpath_blog_grid_columns'] == 'four' ) {
			$container_class = 'grid-layout grid-col-4';
		}
	}
	$post_class = 'grid-posts';
	$layout = 'grid';
	$image_size = 'theme-mid';
	$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_grid'];
	
} elseif( $tpath_options['tpath_archive_blog_type'] == 'large' ) {
	$container_class = 'large-layout';
	$post_class = 'large-posts';
	$image_size = 'blog-large';
	$layout = 'large';
	$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_large'];
	
} elseif( $tpath_options['tpath_archive_blog_type'] == 'list' ) {
	$container_class = 'list-layout';
	$post_class = 'list-posts';
	$image_size = 'blog-list';
	$layout = 'list';
	$list_fullwidth = $tpath_options['tpath_blog_list_fullwidth'];
	if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
		$excerpt_limit = 20;
	} else {
		$excerpt_limit = 30;
	}
	$list_fullwidth = $tpath_options['tpath_blog_list_fullwidth'];
	if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
		$container_class .= ' list-columns';
	} else {
		$container_class .= ' list-fullwidth';
	}
}

if( $tpath_options['tpath_disable_blog_pagination'] ) {
	$scroll_type = "infinite";
	$scroll_type_class = " scroll-infinite";
} else {
	$scroll_type = "pagination";
	$scroll_type_class = " scroll-pagination";
}
?>
<div class="container">
	<div id="main-wrapper" class="tpath-row row">
		<div id="single-sidebar-container" class="single-sidebar-container main-col-full">
			<div class="tpath-row row">	
				<div id="primary" class="content-area <?php justice_primary_content_classes(); ?>">
					<div id="content" class="site-content">
						<?php 
						$category = '';
						$category = get_queried_object();						
						if( isset( $category->term_id ) && $category->term_id != '' ) {
						   	$term_meta = get_option( "taxonomy_$category->term_id" ); 
						} ?>
						
						<?php if( isset( $term_meta['tpath_thumbnail_image'] ) && $term_meta['tpath_thumbnail_image'] != '' ) { ?>
						<div class="archive-header">
							<div class="category-image">
								<img class="img-responsive" src="<?php echo esc_url( $term_meta['tpath_thumbnail_image'] ); ?>" alt="" />
							</div>
						</div>
						<?php } ?>
						
						<?php if( isset( $category->term_id ) && is_tag( $category->term_id  ) ) {
							$args['tax_query'] = array( array( 
													'taxonomy' => 'post_tag', 
													'field' => 'id', 
													'terms' => $category->term_id 
												));
							} elseif( isset( $category->term_id ) ) {
								$args['tax_query'] = array( array( 
														'taxonomy' => 'category', 
														'field' => 'id', 
														'terms' => $category->term_id 
													));
							}
							
							if( ! empty( $args ) ) {
								new WP_Query($args); 
							} ?>
				
							<div id="archive-posts-container" class="tpath-posts-container <?php echo esc_attr( $container_class ); ?><?php echo esc_attr( $scroll_type_class ); ?> clearfix">
							
								<?php if ( have_posts() ):
									while ( have_posts() ): the_post();
									
										$post_id = get_the_ID();
										$post_format = get_post_format();
										
										$post_format_class = '';
										if( $post_format == 'image' ) {
											$post_format_class = ' image-format';
										} elseif( $post_format == 'quote' ) {
											$post_format_class = ' quote-image';
										} ?>
										
										<article id="post-<?php echo esc_attr( $post_id ); ?>" <?php post_class($post_class); ?>>
											<div class="posts-inner-container clearfix">
												<div class="posts-content-container">
													<?php if( $layout == 'list' || $layout == 'grid' ) {
														include( locate_template('partials/content-list.php') );
													} 
													elseif($layout == 'large') {
														include( locate_template('partials/content-large.php') );
													} ?>
												</div>
											</div>
										</article>
										
									<?php endwhile;
									
									else :
										get_template_part( 'content', 'none' );
								endif; ?>
								
							</div>
							<?php echo justice_pagination( $pages = '', $range = 2, $scroll_type );
							
							wp_reset_postdata(); ?>
							
					</div><!-- #content -->
				</div><!-- #primary -->
			
				<?php get_sidebar(); ?>
			</div>		
		</div><!-- #single-sidebar-container -->
		
	</div><!-- #main-wrapper -->
</div><!-- .container -->
<?php get_footer(); ?>