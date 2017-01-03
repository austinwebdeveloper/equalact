<?php
/**
 * Contact Form shortcode 
 */

if ( ! function_exists( 'tpath_vc_contact_form_shortcode' ) ) {
	function tpath_vc_contact_form_shortcode( $atts, $content = NULL ) {
		
		extract(
			shortcode_atts( 
				array(
					'classes'				=> '',
					'css_animation'			=> '',
					'form_style'			=> 'default',
					'form_bgstyle'			=> 'default',
					'show_name'				=> 'yes',
					'name_label'			=> __('User Name', 'Templatepath'),
					'email_label'			=> __('Email', 'Templatepath'),
					'show_phone'			=> 'yes',
					'phone_label'			=> __('Phone Number', 'Templatepath'),
					'show_message' 			=> 'yes',
					'message_label' 		=> __('Message', 'Templatepath'),					
					'button_text' 			=> __('Send Now', 'Templatepath'),
					'button_align' 			=> 'left',
					'button_size' 			=> 'default',
					'button_block' 			=> '',
				), $atts 
			) 
		);

		$output = '';
		$button_class = '';
		$button_html = '';
		static $tpath_contactform_id = 1;
		
		// Button
		$button_html = $button_text;
		if ( 'yes' == $button_block ) {
			$button_class .= ' btn-block';
		}
		
	
		// Classes
		$main_classes = '';
		if( isset( $classes ) && $classes != '' ) {
			$main_classes .= ' ' . $classes;
		}
		if( isset( $form_style ) && $form_style != '' ) {
			$main_classes .= ' form-style-' . $form_style;
		}
		if( isset( $form_bgstyle ) && $form_bgstyle != '' ) {
			$main_classes .= ' form-bg-' . $form_bgstyle;
		}
	
		wp_enqueue_script( 'tpath-bootstrap-validator-js' );
		
		$output .= '<div class="contact-form-wrapper'. esc_attr( $main_classes ) .'">';
			$output .= '<p class="bg-success tpath-form-success"></p>'; 
			$output .= '<p class="bg-danger tpath-form-error"></p>';
				
				$output .= '<div class="tpath-contact-form-container">';
					$output .= '<form role="form" name="contactform" class="tpath-contact-form" id="contactform'.$tpath_contactform_id.'" method="post" action="#">';
					
					// Name Field
					if( isset( $show_name ) && $show_name == 'yes' ) {						
						$output .= '<div class="tpath-input-text form-group">';
							$output .= '<label class="sr-only" for="contact_name">'.$name_label.'</label>';
							$output .= '<input type="text" name="contact_name" id="contact_name" class="input-name form-control" placeholder="'.esc_attr($name_label).'">';		
						$output .= '</div>';
					}
					
					// Email Field
					$output .= '<div class="tpath-input-email form-group">';
						$output .= '<label class="sr-only" for="contact_email">'.$email_label.'</label>';							
						$output .= '<input type="email" name="contact_email" id="contact_email" class="input-email form-control" placeholder="'.esc_attr($email_label).'">';
					$output .= '</div>';
					
					// Phone Field
					if( isset( $show_phone ) && $show_phone == 'yes' ) {
						$output .= '<div class="tpath-input-phone form-group">';
							$output .= '<label class="sr-only" for="contact_phone">'.$phone_label.'</label>';
							$output .= '<input type="text" id="contact_phone" name="contact_phone" class="input-phone form-control" placeholder="'.esc_attr($phone_label).'">';
						$output .= '</div>';
					}
					
					if( isset( $form_layout ) && $form_layout == 'two-column' ) {
						$output .= '</div>';
						$output .= '<div class="col-md-6 col-xs-12">';
					}
					
					// Message Field
					if( isset( $show_message ) && $show_message == 'yes' ) {
						$output .= '<div class="tpath-textarea-message form-group">';								
							$output .= '<label class="sr-only" for="contact_message">'.$message_label.'</label>';
							$output .= '<textarea name="contact_message" id="contact_message" class="textarea-message form-control" rows="6" cols="25" placeholder="'.esc_attr($message_label).'"></textarea>';
						$output .= '</div>';
					}
					
					// Button
					$output .= '<div class="tpath-input-submit form-group text-'.$button_align.'">';
						$output .= '<button type="submit" class="btn btn_bgcolor btn-'. esc_attr( $button_size ) .' tpath-submit'. esc_attr( $button_class ) .'">'.$button_html.'</button>';
					$output .= '</div>';
					
					$output .= '</form>';
				$output .= '</div>';
				
		$output .= '</div>';
		
		$tpath_contactform_id++;
		
		return $output;
	}
}
add_shortcode( 'tpath_vc_contact_form', 'tpath_vc_contact_form_shortcode' );

if ( ! function_exists( 'tpath_vc_contact_form_shortcode_map' ) ) {
	function tpath_vc_contact_form_shortcode_map() {
	
		vc_map( 
			array(
				"name"					=> __( "Contact Form", "Templatepath" ),
				"base"					=> "tpath_vc_contact_form",
				"category"				=> __( "Theme Addons", "Templatepath" ),
				"icon" 					=> 'tpath-vc-block',
				"params"				=> array(					
					array(
						'type'			=> 'textfield',
						'admin_label' 	=> true,
						'heading'		=> __( 'Extra Class', "Templatepath" ),
						'param_name'	=> 'classes',
						'value' 		=> '',
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> __( "Form Style", "Templatepath" ),
						"param_name"	=> "form_style",
						"value"			=> array(
							__( "Default", "Templatepath" )			=> "default",
							__( "Style 1", "Templatepath" )			=> "style1",
							__( "Fullwidth", "Templatepath" )		=> "fullwidth" ),
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> __( "Form Background", "Templatepath" ),
						"param_name"	=> "form_bgstyle",
						"value"			=> array(
							__( "Default", "Templatepath" )			=> "default",
							__( "Transparent", "Templatepath" )		=> "transparent" ),
					),
					// Fields
					array(
						"type"			=> 'dropdown',
						"heading"		=> __( "Show Name Field", "Templatepath" ),
						"param_name"	=> "show_name",
						"value"			=> array(
							__( "Yes", "Templatepath" )	=> "yes",
							__( "No", "Templatepath" )	=> "no",
						),
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> __( "Name Field Label", "Templatepath" ),
						"param_name"	=> "name_label",
						"value"			=> "User Name",
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> __( "Email Field Label", "Templatepath" ),
						"param_name"	=> "email_label",
						"value"			=> "Email",
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> __( "Show Phone Field", "Templatepath" ),
						"param_name"	=> "show_phone",
						"value"			=> array(
							__( "Yes", "Templatepath" )	=> "yes",
							__( "No", "Templatepath" )	=> "no",
						),
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> __( "Phone Field Label", "Templatepath" ),
						"param_name"	=> "phone_label",
						"value"			=> "Phone Number",
						"group"			=> __( "Fields", "Templatepath" ),
					),					
					array(
						"type"			=> 'dropdown',
						"heading"		=> __( "Show Message Field", "Templatepath" ),
						"param_name"	=> "show_message",
						"value"			=> array(
							__( "Yes", "Templatepath" )	=> "yes",
							__( "No", "Templatepath" )	=> "no",
						),
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> __( "Message Field Label", "Templatepath" ),
						"param_name"	=> "message_label",
						"value"			=> "Message",
						"group"			=> __( "Fields", "Templatepath" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> __( "Button Text", "Templatepath" ),
						"param_name"	=> "button_text",
						'admin_label' 	=> true,
						"value"			=> __( 'Send Now', 'Templatepath' ),
						"group"			=> __( "Button", "Templatepath" ),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> __( 'Button Alignment', 'Templatepath' ),
						'param_name' 	=> 'button_align',
						'description' 	=> __( 'Select button alignment.', 'Templatepath' ),
						'value' 		=> array(
							__( 'Left', 'Templatepath' ) 	=> 'left',
							__( 'Right', 'Templatepath' ) 	=> 'right',
							__( 'Center', 'Templatepath' ) 	=> 'center'
						),
						"group"			=> __( "Button", "Templatepath" ),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> __( 'Button Size', 'Templatepath' ),
						'param_name' 	=> 'button_size',
						'description' 	=> __( 'Select button size.', 'Templatepath' ),
						'value' 		=> array(
							__( 'Default', 'Templatepath' ) => 'default',
							__( 'Large', 'Templatepath' ) 	=> 'large',
						),
						"group"			=> __( "Button", "Templatepath" ),
					),
					array(
						'type' 			=> 'checkbox',
						'heading' 		=> __( 'Set full width button?', 'Templatepath' ),
						'param_name' 	=> 'button_block',
						"value"			=> array(
							__( "Yes", "Templatepath" )	=> "yes"
						),
						"group"			=> __( "Button", "Templatepath" ),
					),
				)
			) 
		);
	}
}
add_action( 'vc_before_init', 'tpath_vc_contact_form_shortcode_map' );