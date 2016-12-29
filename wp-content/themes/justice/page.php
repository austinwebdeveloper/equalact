<?php
/**
 * Default Page Template
 *
 * @package TemplatePath
 */
 
global $tpath_options;
get_header(); ?>

<div class="container">
	<div id="main-wrapper" class="tpath-row row">
		<div id="single-sidebar-container" class="single-sidebar-container main-col-full">
			<div class="tpath-row row">	
				<div id="primary" class="content-area <?php justice_primary_content_classes(); ?>">
					<div id="content" class="site-content">				
						<?php if ( have_posts() ):
							while ( have_posts() ): the_post();	
							
								$page_content_block 	= get_post_meta( $post->ID, 'tpath_additional_content_block', true ); ?>
								
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									
									<?php if ( has_post_thumbnail() ) { ?>
									<div class="entry-thumbnail">
										<?php the_post_thumbnail(); ?>
									</div>
									<?php } ?>
									
									<div class="entry-content">
										<?php the_content(); ?>
										<?php wp_link_pages(); ?>
									</div>
									
									<?php if ( comments_open() ) {
										comments_template(); 
									} ?>
								</div>
								
							<?php endwhile;		
						endif; ?>
					</div><!-- #content -->
				</div><!-- #primary -->
	
				<?php get_sidebar(); ?>
			</div>
		</div><!-- #single-sidebar-container -->	
		
	</div><!-- #main-wrapper -->
</div><!-- .container -->

<?php if( isset( $page_content_block ) && ( $page_content_block != '' && $page_content_block != 0 ) ) {
	echo justice_block( $page_content_block );
} ?>
<?php get_footer(); ?>