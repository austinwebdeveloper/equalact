<?php
/**
 * Single Portfolio Page
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
									$portfolio_date = $portfolio_client = '';											
									$portfolio_client = get_post_meta( $post->ID, 'tpath_client_name', true );						
									$portfolio_date = get_post_meta( $post->ID, 'tpath_portfolio_date', true );
									
									$portfolio_full_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
								?>
					
								<div class="portfolio-single">
									<div class="portfolio-content-inner clearfix">
										
										<div <?php post_class() ?> id="portfolio-<?php the_ID(); ?>">
											<div class="entry-content">												
												<div class="row">
													<div class="col-sm-6 portfolio-single-image">
														<div class="portfolio-gallery portfolio-image">
															<a href="<?php echo esc_url( $portfolio_full_img[0] ); ?>" data-rel="prettyPhoto" title="<?php the_title(); ?>"><img class="img-responsive" src="<?php echo esc_url( $portfolio_full_img[0] ); ?>" alt="<?php the_title(); ?>" /></a>
														</div>
														<!-- ============ Portfolio Details ============ -->
														<div class="portfolio-details">
															<h3 class="portfolio-info-title"><?php esc_html_e('Project Details', 'Templatepath'); ?></h3>
															<?php if( isset( $portfolio_date ) && $portfolio_date != '' ) { ?>
																<div class="portfolio-box">
																	<h5><?php esc_html_e('Date', 'Templatepath') ?>:</h5>
																	<div class="portfolio-date">
																		<?php echo esc_attr( $portfolio_date ); ?>
																	</div>
																</div>
															<?php } ?>
															<?php if( isset( $portfolio_client ) && $portfolio_client != '' ) { ?>
																<div class="portfolio-box">
																	<h5><?php esc_html_e('Client', 'Templatepath') ?>:</h5>
																	<div class="portfolio-client">
																		<?php echo esc_attr( $portfolio_client ); ?>
																	</div>
																</div>
															<?php } ?>
															<?php if(get_the_term_list($post->ID, 'portfolio_skills', '', ',', '')) { ?>
																<div class="portfolio-box">
																	<h5><?php esc_html_e('Tags', 'Templatepath') ?>:</h5>
																	<div class="portfolio-terms">
																		<?php echo get_the_term_list($post->ID, 'portfolio_skills', '', ', ', ''); ?>
																	</div>
																</div>
															<?php } ?>
															<?php if(get_the_term_list($post->ID, 'portfolio_categories', '', ',', '')) { ?>
																<div class="portfolio-box">
																	<h5><?php esc_html_e('Category', 'Templatepath') ?>:</h5>
																	<div class="portfolio-terms">
																		<?php echo get_the_term_list($post->ID, 'portfolio_categories', '', ', ', ''); ?>
																	</div>
																</div>
															<?php } ?>
														</div>
													</div>
													
													<div class="col-sm-6 portfolio-single-content">
														<h3 class="portfolio-desc-title"><?php esc_html_e('Project Description', 'Templatepath'); ?></h3>
														<div class="portfolio-content">
															<?php the_content(); ?>
														</div>
													</div>
												</div>
												
											</div>											
										</div>
										
									</div>
								</div>
								
								<?php justice_postnavigation();
																
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
<?php get_footer(); ?>