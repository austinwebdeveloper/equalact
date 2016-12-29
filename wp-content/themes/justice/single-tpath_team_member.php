<?php
/**
 * Single Team Page
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
							
							$member_designation 	= get_post_meta( $post->ID, 'tpath_member_designation', true );
							$member_address 		= get_post_meta( $post->ID, 'tpath_member_address', true );
							$member_latlng 			= get_post_meta( $post->ID, 'tpath_member_latlng', true );
							$member_phone 			= get_post_meta( $post->ID, 'tpath_member_phone', true );
							$member_practise_area 	= get_post_meta( $post->ID, 'tpath_member_practise_area', true );
							$member_office_hours 	= get_post_meta( $post->ID, 'tpath_member_office_hours', true );
							$member_content_block 	= get_post_meta( $post->ID, 'tpath_additional_content_block', true );
							
							$member_facebook 		= get_post_meta( $post->ID, 'tpath_member_facebook', true );
							$member_twitter 		= get_post_meta( $post->ID, 'tpath_member_twitter', true );
							$member_linkedin 		= get_post_meta( $post->ID, 'tpath_member_linkedin', true );
							$member_pinterest 		= get_post_meta( $post->ID, 'tpath_member_pinterest', true );
							$member_googleplus 		= get_post_meta( $post->ID, 'tpath_member_googleplus', true );
							$member_dribbble 		= get_post_meta( $post->ID, 'tpath_member_dribbble', true );
							$member_flickr 			= get_post_meta( $post->ID, 'tpath_member_flickr', true );
							$member_yahoo 			= get_post_meta( $post->ID, 'tpath_member_yahoo', true );
							$member_email 			= get_post_meta( $post->ID, 'tpath_member_email', true );							
							
							$team_full_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
							
							if( isset( $member_latlng ) && $member_latlng != '' ) {
								$data_attr = '';
								$data_attr = ' data-type="roadmap"';
								$data_attr .= ' data-zoom="12"';
								$data_attr .= ' data-scrollwheel="true"';
								$data_attr .= ' data-zoomcontrol="true"';
								$data_attr .= ' data-marker="'. TEMPLATETHEME_URL . '/images/map-marker.png"';
								$data_attr .= ' data-address="'. $member_latlng .'"';
								$data_attr .= ' data-title="'. get_the_title() .'"';
								$data_attr .= ' data-content="' . str_replace( '"', "'", $member_address ) .'"';
							}
							?>
				
							<div class="team-single-wrapper">
								<div class="team-single-inner clearfix">
									
									<div <?php post_class(); ?> id="team-member-<?php the_ID(); ?>">
										<div class="entry-content">												
											<div class="row">
												<!-- ============ Team Content Wrapper ============ -->
												<div class="col-md-8 col-xs-12 team-content-wrapper">
													<div class="row">
														<div class="col-sm-4 col-xs-12 team-single-image">
															<div class="team-member-image">
																<a href="<?php echo esc_url( $team_full_img[0] ); ?>" data-rel="prettyPhoto" title="<?php the_title(); ?>"><img class="img-responsive" src="<?php echo esc_url( $team_full_img[0] ); ?>" alt="<?php the_title(); ?>" /></a>
															</div>
														</div><!-- .col-sm-4 -->
														<div class="col-sm-8 col-xs-12 team-member-info">
															<div class="team-member-details">
																<h6 class="team-member-name"><?php the_title(); ?></h6>
																<p><span class="team-member-designation"><?php echo esc_html( $member_designation ); ?></span></p>
																<?php if( isset( $member_address ) && $member_address != '' ) { ?>
																<div class="team-member-address">
																	<?php echo force_balance_tags( $member_address ); ?>
																</div>
																<?php } ?>
																<?php if( isset( $member_phone ) && $member_phone != '' ) { ?>
																<p><span class="team-member-phone"><?php echo esc_html( $member_phone ); ?></span></p>
																<?php } ?>
																<!-- ============ Team Socials ============ -->
																<div class="team-member-social">
																<ul class="tpath-member-social-icons list-inline">
																	<?php if( isset( $member_facebook ) && $member_facebook != '' ) { ?>
																	<li class="facebook"><a target="_blank" href="<?php echo esc_url($member_facebook); ?>"><i class="fa fa-facebook"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_twitter ) && $member_twitter != '' ) { ?>
																	<li class="twitter"><a target="_blank" href="<?php echo esc_url($member_twitter); ?>"><i class="fa fa-twitter"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_linkedin ) && $member_linkedin != '' ) { ?>
																	<li class="linkedin"><a target="_blank" href="<?php echo esc_url($member_linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_pinterest ) && $member_pinterest != '' ) { ?>
																	<li class="pinterest"><a target="_blank" href="<?php echo esc_url($member_pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_googleplus ) && $member_googleplus != '' ) { ?>
																	<li class="googleplus"><a target="_blank" href="<?php echo esc_url($member_googleplus); ?>"><i class="fa fa-google-plus"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_dribbble ) && $member_dribbble != '' ) { ?>
																	<li class="dribbble"><a target="_blank" href="<?php echo esc_url($member_dribbble); ?>"><i class="fa fa-dribbble"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_flickr ) && $member_flickr != '' ) { ?>
																	<li class="flickr"><a target="_blank" href="<?php echo esc_url($member_flickr); ?>"><i class="fa fa-flickr"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_yahoo ) && $member_yahoo != '' ) { ?>
																	<li class="yahoo"><a target="_blank" href="<?php echo esc_url($member_yahoo); ?>"><i class="fa fa-yahoo"></i></a></li>
																	<?php } ?>
																	<?php if( isset( $member_email ) && $member_email != '' ) { ?>
																	<li class="email"><a target="_blank" href="<?php echo 'mailto:' . $member_email; ?>"><i class="fa fa-envelope-o"></i></a></li>
																	<?php } ?>
																</ul>
																</div>																
															</div>
														</div><!-- .col-sm-8 -->
													</div>
													
													<div class="row">
														<div class="col-xs-12 team-member-content">
															<?php the_content(); ?>
														</div>
													</div>
													
												</div><!-- .col-md-8 -->
												
												<div class="col-md-4 col-xs-12 team-member-right">
													<?php if( isset( $member_practise_area ) && $member_practise_area != '' ) { ?>
														<div class="team-member-box member-details-box">
															<h6 class="member-box-title"><?php esc_html_e( 'Practise Area', 'Templatepath' ); ?></h6>
															<div class="member-box-content">
																<?php echo force_balance_tags( $member_practise_area ); ?>
															</div>
														</div>
													<?php } ?>
													
													<?php if( isset( $member_latlng ) && $member_latlng != '' ) { ?>
														<div class="team-member-box member-details-box">
															<h6 class="member-box-title"><?php esc_html_e( 'Lawyer Office', 'Templatepath' ); ?></h6>
															<div class="member-box-content">
																<div class="gmap-wrapper">
																	<?php echo '<div class="gmap_canvas"'. $data_attr .'></div>'; ?>
																</div>
															</div>
														</div>
													<?php } ?>
													
													<?php if( isset( $member_office_hours ) && $member_office_hours != '' ) { ?>
														<div class="team-member-box member-details-box">
															<h6 class="member-box-title"><?php esc_html_e( 'Office Hours', 'Templatepath' ); ?></h6>
															<div class="member-box-content">
																<?php echo force_balance_tags( $member_office_hours ); ?>
															</div>
														</div>
													<?php } ?>
													
												</div><!-- .col-md-4 -->
											</div>
											
											<?php justice_related_team_members(); ?>
											
										</div>											
									</div>
									
								</div>
							</div><!-- .team-single-wrapper -->
							<?php endwhile;
								
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

<?php if( isset( $member_content_block ) && ( $member_content_block != '' && $member_content_block != 0 ) ) {
	echo justice_block( $member_content_block );
} ?>
<?php get_footer(); ?>