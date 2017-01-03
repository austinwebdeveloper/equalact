<?php
/**
 * Taxonomy Testimonial Categories Template
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
						<?php
							global $wp_query; 
							$term = $wp_query->get_queried_object();
							$term_id = $term->term_id;
							
							$query = new WP_Query(array('post_type'  => 'tpath_testimonial',
													'posts_per_page' => -1,
													'orderby' 		 => 'menu_order',
													'order' 		 => 'ASC',
													'tax_query' 	 => array(
																	   array(
																		'taxonomy' => 'testimonial_categories',
																		'field' => 'id',
																		'terms' => $term_id
																	) )));
						?>
						<?php if ( $query->have_posts() ):
								while ( $query->have_posts() ): $query->the_post(); ?>
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="posts-inner-container clearfix">
										<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
											<div class="entry-thumbnail">
												 <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay"><?php the_post_thumbnail(); ?></a>
											</div>
										<?php } ?>
										<div class="posts-content-container">
											<div class="entry-header">								 
												<h2 class="entry-title">
													<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</h2>
											</div><!-- .entry-header -->			
											<div class="entry-summary">
												<?php echo justice_custom_wp_trim_excerpt('', 80); ?>
											</div><!-- .entry-summary -->
										</div><!-- .posts-content-container -->
									</div><!-- .posts-inner-container -->
								</div><!-- #post -->
									
								<?php endwhile;
								
								else : ?>
								<?php get_template_part( 'content', 'none' ); ?>
								
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
						
					</div><!-- #content -->
				</div><!-- #primary -->
				<?php get_sidebar(); ?>
				
			</div>
		</div><!-- #single-sidebar-container -->
		
	</div><!-- #main-wrapper -->
</div><!-- .container -->
<?php get_footer(); ?>