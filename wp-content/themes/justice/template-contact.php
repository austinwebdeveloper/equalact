<?php
/**
 * Template Name: Contact Page
 *
 * The contact page template displays map and contact form
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
									$page_content_block 	= get_post_meta( $post->ID, 'tpath_additional_content_block', true ); ?>
							<?php endwhile;
						endif; ?>
						
						<div class="row">
							<div class="col-md-8">
								<div class="page-title-header">
									<h6 class="entry-title contact-section-title"><?php esc_html_e('Contact Us', 'Templatepath'); ?></h6>
								</div>
								<div class="contact-description">
									<?php echo wp_kses_post( $tpath_options['tpath_contact_message'] ); ?>
								</div>
								<?php echo '<p class="tpath-form-success"></p>'; 
								echo '<p class="tpath-form-error"></p>'; ?>
								
								<div class="tpath-contact-form-wrapper tpath-tp-contactform">
									<form role="form" name="contactform" class="tpath-contact-form" id="contactform" method="post" action="">
										<div class="row">
											<div class="col-md-6">
												<div class="tpath-input-text form-group">
													<?php if( ! $tpath_options['tpath_form_name'] ) { 
														$name_label = $tpath_options['tpath_labels_name'] ? $tpath_options['tpath_labels_name'] : __('Your Name', 'Templatepath');
													?>
													<label class="sr-only" for="contact_name"><?php echo esc_html( $name_label ); ?></label>
													<input type="text" name="contact_name" class="input-name form-control" placeholder="<?php echo esc_html( $name_label ); ?>">
													<?php } ?>
												</div>
											</div>
											<div class="col-md-6">		
												<?php if( ! $tpath_options['tpath_form_subject'] ) { ?>
													<div class="tpath-input-subject form-group">																
														<?php $subject_label = $tpath_options['tpath_labels_subject'] ? $tpath_options['tpath_labels_subject'] : __('Subject', 'Templatepath'); ?>
														<label class="sr-only" for="contact_subject"><?php echo esc_html( $subject_label ); ?></label>
														<input type="text" name="contact_subject" class="input-subject form-control" placeholder="<?php echo esc_html( $subject_label ); ?>">
													</div>
												<?php } ?>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="tpath-input-email form-group">
													<?php $email_label = $tpath_options['tpath_labels_email'] ? $tpath_options['tpath_labels_email'] : __('Your Email', 'Templatepath'); ?>
													<label class="sr-only" for="contact_email"><?php echo esc_html( $email_label ); ?></label>
													<input type="email" name="contact_email" class="input-email form-control" placeholder="<?php echo esc_html( $email_label ); ?>">
												</div>
											</div>
										</div>													
										
										<div class="row">
											<div class="col-xs-12">														
												<div class="tpath-textarea-message form-group">															
													<?php $msg_label = $tpath_options['tpath_labels_message'] ? $tpath_options['tpath_labels_message'] : __('Your Message', 'Templatepath'); ?>
													<label class="sr-only" for="contact_message"><?php echo esc_html( $msg_label ); ?></label>
													<textarea name="contact_message" class="textarea-message form-control" rows="8" cols="30" placeholder="<?php echo esc_html( $msg_label ); ?>"></textarea>															
												</div>
											</div>
										</div>
									
										<div class="tpath-input-submit form-group">
											<button type="submit" class="btn tpath-submit"><?php esc_html_e('Send Message', 'Templatepath'); ?></button>										
										</div>
									</form>
								</div>
							</div>
						
							<div class="col-md-4">
								<div class="page-title-header">
									<h6 class="entry-title contact-section-title"><?php esc_html_e('Contact Information', 'Templatepath'); ?></h6>
								</div>
								<div class="tpath-contact-info">
									
									<div class="row">
										<?php if( $tpath_options['tpath_site_name'] ) { ?>					
										<div class="col-xs-12">					
											<div class="site-info">
												<p><i class="fa fa-user"></i> <strong><?php echo esc_html( $tpath_options['tpath_site_name'] ); ?></strong></p>											
											</div>
										</div>
										<?php } ?>
										
										<?php if( $tpath_options['tpath_site_address'] ) { ?>					
										<div class="col-xs-12">
											<div class="address-info">							
												<p><i class="fa fa-map-marker"></i> <?php echo esc_html( $tpath_options['tpath_site_address'] ); ?></p>
											</div>
										</div>
										<?php } ?>
										
										<?php if( $tpath_options['tpath_site_url'] ) { ?>
										<div class="col-xs-12">						
											<div class="website-info">
												<p><i class="fa fa-globe"></i> <?php echo '<a href="' .esc_url( $tpath_options['tpath_site_url'] ). '">' .$tpath_options['tpath_site_url']. '</a>'; ?></p>
											</div>
										</div>
										<?php } ?>
																			
										<?php if( $tpath_options['tpath_site_phone'] || $tpath_options['tpath_site_fax_number'] ) { ?>
										<div class="col-xs-12">						
											<div class="phone-info">
												<?php if( $tpath_options['tpath_site_phone'] ) { echo '<p><i class="fa fa-phone"></i> ' . $tpath_options['tpath_site_phone'] .'</p>'; } ?>
												<?php if( $tpath_options['tpath_site_fax_number'] ) { echo '<p><i class="fa fa-fax"></i> ' . $tpath_options['tpath_site_fax_number'] .'</p>'; } ?>							
											</div>
										</div>
										<?php } ?>
										
										<?php if( $tpath_options['tpath_site_email'] ) { ?>
										<div class="col-xs-12">						
											<div class="email-info">
												<p><i class="fa fa-envelope"></i> <?php echo '<a href="mailto:' .$tpath_options['tpath_site_email']. '">' .$tpath_options['tpath_site_email']. '</a>'; ?></p>
											</div>
										</div>
										<?php } ?>
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
<?php if( $tpath_options['tpath_show_google_map_contact'] && $tpath_options['tpath_gmap_address'] ) {
		echo '<div id="tpath_gmap" class="gmap_canvas"></div>';
} ?>
<?php if ( have_posts() ):
	while ( have_posts() ): the_post();	?>
		
		<?php the_content(); ?>		
	
<?php endwhile;
endif; ?>

<?php if( isset( $page_content_block ) && ( $page_content_block != '' && $page_content_block != 0 ) ) {
	echo justice_block( $page_content_block );
} ?>
<?php get_footer(); ?>