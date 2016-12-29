<?php
/**
 * Search Page Template
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
								while ( have_posts() ): the_post(); ?>
									<div class="tpath-search-results search-item">
								
									<?php if( get_post_format() ) {
										get_template_part( 'content', get_post_format() );
									} else { ?>
										<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<div class="entry-header">
												<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
											</div>
											 <?php if ( has_post_thumbnail() ) { ?>
											<div class="entry-thumbnail">
												<?php the_post_thumbnail( 'blog-large' ); ?>
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
									<?php } ?>
									</div>
								<?php endwhile;	
								else:
									get_template_part( 'content', 'none' );
							endif;
							
							echo justice_pagination( $pages = '', $range = 2, '' );
						?>
					</div><!-- #content -->
				</div><!-- #primary -->
			
				<?php get_sidebar(); ?>
			</div>
		</div><!-- #single-sidebar-container -->
	
	</div><!-- #main-wrapper -->
</div><!-- .container -->
<?php get_footer(); ?>