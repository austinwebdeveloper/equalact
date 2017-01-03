<?php
/**
 * 404 Template
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
						<div id="post-404" class="post post-404">
							<div class="entry-header">
								<h1 class="entry-title"><?php esc_html_e('Error 404 - Page not found!', 'Templatepath'); ?></h1>
							</div>
							<div class="entry-content">						
								<div class="content-404page">
									<h3 class="error-title">404</h3>
									<h2 class="title-404"><?php esc_html_e( 'Oops, This Page Could Not Be Found!', 'Templatepath' ); ?></h2>
									<h5><?php esc_html_e( 'The page you are trying to reach does not exist, or has been moved.', 'Templatepath' ); ?></h5>
									<div class="search-404page">
										<?php get_search_form(); ?>
									</div>
								</div>
							</div>
						</div>				
					</div><!-- #content -->
				</div><!-- #primary -->
				<?php get_sidebar(); ?>
			</div>
		</div><!-- #single-sidebar-container -->	
	</div><!-- #main-wrapper -->
</div><!-- .container -->

<?php get_footer(); ?>