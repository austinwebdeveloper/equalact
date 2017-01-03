<?php
/**
 * The template for displaying the footer.
 *
 * @package TemplatePath
 */
 
 global $tpath_options;
?>
	</div><!-- #main -->
	
	<div id="footer" class="footer-section">	
		<?php $is_footer_widgets = $tpath_options['tpath_footer_widgets_enable'];	
		if( isset( $is_footer_widgets ) && $is_footer_widgets ) { ?>
			<div id="footer-widgets-container" class="footer-widgets-section">
				<div class="container">
					<div class="tpath-row row">
						<?php
							$columns = $tpath_options['tpath_footer_widget_layout'];
							if( ! $columns ) $columns = 4;
							for( $i = 1; $i <= intval( $columns ); $i++ ) { 
								if( is_active_sidebar( 'footer-widget-' . $i ) ) { ?>
								<div id="footer-widgets-<?php echo esc_attr( $i ); ?>" class="footer-widgets <?php footer_widget_classes( $columns ); ?>">
									<?php dynamic_sidebar( 'footer-widget-' . $i ); ?>
								</div>
								<?php }	
							} ?>
					</div><!-- .row -->
				</div>
			</div><!-- #footer-widgets-container -->
		<?php } ?>
		<div id="footer-copyright-container" class="footer-copyright-section">
			<div class="container">
				<div class="tpath-row row">					
					<div id="copyright-text" class="copyright-info col-xs-12 text-center">
						<?php if( isset( $tpath_options['tpath_copyright_text'] ) && $tpath_options['tpath_copyright_text'] != '' ) {
							echo '<p>'.do_shortcode( $tpath_options['tpath_copyright_text'] ).'</p>';
						} else { ?>
							<p><?php esc_html_e('Copyright', 'Templatepath'); ?> <?php echo date('Y'); ?> <?php esc_html_e('by', 'Templatepath'); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php echo bloginfo( 'name' ); ?></a> | <?php esc_html_e('All rights reserved', 'Templatepath'); ?></p>
						<?php } ?>
					</div><!-- #copyright-text -->
					<?php if( $tpath_options['tpath_enable_social_icons_footer'] ) { ?>
					<div id="social-icons" class="footer-social col-xs-12 text-center">					
						<?php echo justice_display_social_icons(); ?>						
					</div><!-- #social-icons -->
					<?php } ?>
					
				</div>
			</div>
		</div><!-- #footer-copyright-container -->		
	</div><!-- #footer -->
</div>
<?php wp_footer(); ?>

</body>
</html>