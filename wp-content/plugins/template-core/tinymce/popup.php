<?php
// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new tpath_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="tpath-popup">
	<div id="tpath-shortcode-wrap">		
		<div id="tpath-sc-form-wrap">
			
			<?php
			$select_shortcode = array(
					'select' 			=> 'Choose a Shortcode',
					'accordion' 		=> 'Accordion',
					'alert' 			=> 'Alert',
					'bg_video' 			=> 'Background Video',
					'blockquotes' 		=> 'Blockquotes',
					'blog' 				=> 'Blog Posts',
					'bootcarousel' 		=> 'Bootstrap Carousel',					
					'button' 			=> 'Button',
					'columns' 			=> 'Columns',
					'contact_form' 		=> 'Contact Form',
					'contentboxes' 		=> 'Content Boxes',
					'counters' 			=> 'Counters',
					'dropcap' 			=> 'Dropcap',				
					'fontawesome' 		=> 'Font Awesome',
					'googlemap' 		=> 'Google Map',					
					'highlight' 		=> 'Highlight',
					'html_block' 		=> 'HTML Block',
					'imageframe' 		=> 'Image Frame',
					'imageframe_overlay' => 'Image Frame with Overlay',
					'jumbotron' 		=> 'Jumbotron',
					'leadpara' 			=> 'Lead Paragraph',
					'listitem' 			=> 'List Item',					
					'modal' 			=> 'Modals',					
					'popover' 			=> 'Popover',					
					'progressbar' 		=> 'Progress Bar',
					'serviceslist' 		=> 'Services',
					'soundcloud' 		=> 'SoundCloud',
					'tabs' 				=> 'Tabs',
					'table' 			=> 'Table',
					'textslider'  		=> 'Text Slider',
					'tooltip' 			=> 'Tooltip',
					'vimeo' 			=> 'Vimeo',
					'youtube' 			=> 'Youtube'
			);
			?>
			<table id="tpath-sc-form-table" class="tpath-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label">Choose Shortcode</td>
						<td class="field">
							<div class="tpath-form-select-field">
							<select name="tpath_select_shortcode" id="tpath_select_shortcode" class="tpath-form-select tpath-input">
								<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo esc_attr( $shortcode_key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $shortcode_value ); ?></option>
								<?php endforeach; ?>
							</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
			<form method="post" id="tpath-sc-form">
			
				<?php if( $shortcode->popup_title ) { ?>		
					<div id="tpath-sc-form-head">				
						<?php echo wp_kses_post( $shortcode->popup_title ); ?>				
					</div>
					<!-- #tpath-sc-form-head -->				
				<?php }
				
				echo '<table id="tpath-sc-form-table">'. $shortcode->output;
					echo '<tbody class="tpath-sc-form-button">';
						echo '<tr class="form-row">';
							if( ! $shortcode->has_child ) : ?>
								<td class="label">&nbsp;</td>
							<?php endif;
							echo '<td class="field"><a href="#" class="button-primary tpath-insert">'. __('Insert Shortcode', 'TemplateCore') .'</a></td>';
						echo '</tr>';
					echo '</tbody>';
				echo '</table>'; ?>
				<!-- /#tpath-sc-form-table -->
				
			</form>
			<!-- /#tpath-sc-form -->
		
		</div>
		<!-- /#tpath-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#tpath-shortcode-wrap -->

</div>
<!-- /#tpath-popup -->

</body>
</html>