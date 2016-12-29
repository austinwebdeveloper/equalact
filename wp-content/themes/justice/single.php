<?php
/**
 * Single Post Template
 *
 * @package TemplatePath
 */
 
global $tpath_options;
get_header();
?>
<div class="container">
	<div id="main-wrapper" class="tpath-row row">
		<div id="single-sidebar-container" class="single-sidebar-container main-col-full">
			<div class="tpath-row row">
				<div id="primary" class="content-area <?php justice_primary_content_classes(); ?>">
					<div id="content" class="site-content">	
						<?php if ( have_posts() ):
								while ( have_posts() ): the_post(); 
								
								$post_content_block 	= get_post_meta( $post->ID, 'tpath_additional_content_block', true ); ?>
								
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="posts-inner-container clearfix">
										<div class="posts-content-container">
											<?php include( locate_template('partials/content-single.php') ); ?>
										</div>
									</div>
								</article>
								
								<?php if( $tpath_options['tpath_blog_author_info'] ) {
									justice_author_info();
								}
								
								if( ! $tpath_options['tpath_blog_prev_next'] ) { 
									justice_postnavigation();
								}
								
								if( $tpath_options['tpath_blog_comments'] ) { 
									comments_template();
								}					
								endwhile;
								
								else : ?>
								<?php get_template_part( 'content', 'none' ); ?>
						<?php endif; ?>				
					</div><!-- #content -->
				</div><!-- #primary -->
			
				<?php get_sidebar(); ?>
			</div>
		</div><!-- #single-sidebar-container -->
		
	</div><!-- #main-wrapper -->
</div><!-- .container -->	

<?php if( isset( $post_content_block ) && ( $post_content_block != '' && $post_content_block != 0 ) ) {
	echo justice_block( $post_content_block );
} ?>
<?php get_footer(); ?>