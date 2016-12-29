<?php 
/**
 * The Shortcode
 */
function tpath_section_title_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'heading_type'		=> 'h2',
				'title' 			=> '',
				'title_transform' 	=> '',
				'title_weight' 		=> 'default',
				'alignment' 		=> 'left',
				'title_design'		=> 'none',
				'type' 				=> 'none',
				'icon_flaticons' 	=> '',
				'icon_fontawesome' 	=> '',
				'icon_lineicons' 	=> '',
				'title_color' 		=> '',
				'subtitle_color' 	=> '',	
				'border_color'		=> '',
				'icon_color'		=> '',
				'margin_bottom' 	=> '',
			), $atts 
		) 
	);
	
	$output = false;
	static $title_id = 1;
	$custom_stylings = '';
	
	$text_alignment = ( isset( $alignment ) && $alignment != '' ) ? ' text-'. strtolower( $alignment ) : '';
	$title_transform = ( isset( $title_transform ) && $title_transform != '' ) ? ' text-'. strtolower( $title_transform ) : '';
	$title_weight = ( isset( $title_weight ) && $title_weight != '' ) ? ' text-weight-'. strtolower( $title_weight ) : '';
	
	$title_style = ( isset( $title_color ) && $title_color != '' ) ? ' style="color: '.$title_color.';"' : '';
	$subtitle_style = ( isset( $subtitle_color ) && $subtitle_color != '' ) ? ' style="color: '.$subtitle_color.';"' : '';
	$border_style = ( isset( $border_color ) && $border_color != '' ) ? ' style="border-color: '.$border_color.';"' : '';
	$icon_style = ( isset( $icon_color ) && $icon_color != '' ) ? ' style="color: '.$icon_color.';"' : '';
	$margin_style = ( isset( $margin_bottom ) && $margin_bottom != '' ) ? ' style="margin-bottom: '.$margin_bottom.'px;"' : '';
	
	$custom_id = '';
	$custom_id = '#section-title' . $title_id;
	
	$output .= '<div id="section-title' . $title_id .'" class="tpath-section-title '. esc_attr( 'title-'. $title_design . $text_alignment ) .'"'.$margin_style.'>';
	
		if( isset( $title_design ) && $title_design == 'bottom_border' ) {
			if( isset( $border_color ) && $border_color != '' ) {	
				$custom_stylings .= $custom_id .'.tpath-section-title.title-bottom_border .section-title::before, 
				'.$custom_id .'.tpath-section-title.title-bottom_border .section-title::after, 
				'.$custom_id .'.tpath-section-title.title-bottom_border .section-sub-title::before, 
				'.$custom_id .'.tpath-section-title.title-bottom_border .section-sub-title::after { background-color:'. $border_color .'; }' . "\n";
			}
		}
	
		if( $title ) {
		
			if( isset( $custom_stylings ) && $custom_stylings != '' ) {
				$output .= '<style type="text/css">';
				$output .= $custom_stylings;
				$output .= '</style>';
			}
			
			$output .= '<div class="section-heading"><'.$heading_type.' class="section-title'. $title_transform . $title_weight .'" '.$title_style.'>';
				if( isset( $title_design ) && $title_design == 'left_border' ) {
					$output .= '<span class="leftborder" '.$border_style.'></span>';
				}
				if( isset( $type ) && $type != 'none' ) {
					if( isset( ${'icon_'. $type} ) && ${'icon_'. $type} != '' ) {
						$output .= '<span class="title_icon"><i class="'. esc_attr( ${'icon_'. $type} ) . ' title-icon"'.$icon_style.'></i></span>';
					}
				}
				$output .= esc_html( $title );
			$output .=  '</'.$heading_type.'>';
			
			if( $content ) {
				$output .= '<div class="section-sub-title"'.$subtitle_style.'>'. wpb_js_remove_wpautop( $content, true ) .'</div>';
			}
			$output .=  '</div>';
		}
		
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_section_title', 'tpath_section_title_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_section_title_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __("Section Title", "Templatepath"),
			"base" 			=> "tpath_section_title",
			"category" 		=> __("Theme Addons", "Templatepath"),
			"params" 		=> array(
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Heading Type", 'Templatepath' ),
					"param_name"	=> "heading_type",
					"value"			=> array(
						"h2"		=> "h2",
						"h3"		=> "h3",
						"h4"		=> "h4",
						"h5"		=> "h5",
						"h6"		=> "h6",
						"div"		=> "div",
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Heading Transform", 'Templatepath' ),
					"param_name"	=> "title_transform",
					"value"			=> array(
						__( "Default", 'Templatepath' )		=> '',
						__( "None", 'Templatepath' )		=> 'transform-none',
						__( "Capitalize", 'Templatepath' )	=> 'capitalize',
						__( "Uppercase", 'Templatepath' )	=> 'uppercase',
						__( "Lowercase", 'Templatepath' )	=> 'lowercase',
					),					
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Heading Weight", 'Templatepath' ),
					"param_name"	=> "title_weight",
					"value"			=> array(
						__( "Default", 'Templatepath' )		=> 'default',
						__( "Normal", 'Templatepath' )		=> 'normal',
						__( "Bold", 'Templatepath' )		=> 'bold',
						__( "Extra Bold", 'Templatepath' )	=> 'extra-bold',						
					),					
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Title", "Templatepath"),
					"param_name" 	=> "title",
					"admin_label" 	=> true,
					"value" 		=> '',
				),
				array(
					"type" 			=> "textarea_html",
					"heading" 		=> __("Sub Title", "Templatepath"),
					"param_name" 	=> "content",
					"value" 		=> '',
					"holder" 		=> 'div',
				),
				array(
					'type' 			=> "dropdown",
					'heading' 		=> __( "Choose from Icon library", "Templatepath" ),
					'value' 		=> array(
						__( 'None', 'Templatepath' )			=> 'none',
						__( 'Flaticons', 'Templatepath' ) 		=> 'flaticons',
						__( 'Font Awesome', 'Templatepath' ) 	=> 'fontawesome',
						__( 'Lineicons', 'Templatepath' ) 		=> 'lineicons',						
					),
					'admin_label' 	=> true,
					'param_name' 	=> 'type',
					'description' 	=> __( "Select icon library.", "Templatepath" ),
					'group' 		=> __( "Icon", "Templatepath" ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> __( 'Title Icon', 'Templatepath' ),
					'param_name' 	=> 'icon_flaticons',
					'value' 		=> '', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
						'type' 			=> 'flaticons',
						'iconsPerPage' 	=> 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'dependency' 	=> array(
						'element' 	=> 'type',
						'value' 	=> 'flaticons',
					),
					'description' 	=> __( 'Select icon from library.', 'Templatepath' ),
					'group' 		=> __( "Icon", "Templatepath" ),
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> __( 'Title Icon', 'Templatepath' ),
					'param_name' 	=> 'icon_fontawesome',
					'value' 		=> '', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
						'iconsPerPage' 	=> 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'dependency' 	=> array(
						'element' 	=> 'type',
						'value' 	=> 'fontawesome',
					),
					'description' 	=> __( 'Select icon from library.', 'Templatepath' ),
					'group' 		=> __( "Icon", "Templatepath" ),
				),				
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> __( 'Title Icon', 'Templatepath' ),
					'param_name' 	=> 'icon_lineicons',
					'value' 		=> '', // default value to backend editor admin_label
					'settings' 		=> array(
						'emptyIcon' 	=> true, // default true, display an "EMPTY" icon?
						'type' 			=> 'simpleicons',
						'iconsPerPage' 	=> 4000, // default 100, how many icons per/page to display
					),
					'dependency' 	=> array(
						'element' 	=> 'type',
						'value' 	=> 'lineicons',
					),
					'description' 	=> __( 'Select icon from library.', 'Templatepath' ),
					'group' 		=> __( "Icon", "Templatepath" ),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Title Design", "Templatepath"),
					"param_name" 	=> "title_design",
					"value" 		=> array(
						__('None', 'Templatepath') 			=> 'none',
						__('Bottom Border', 'Templatepath') => 'bottom_border',
						__('Left Border', 'Templatepath') 	=> 'left_border',
									),
					"group" 		=> __( "Design", "Templatepath" ),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Alignment", "Templatepath"),
					"param_name" 	=> "alignment",
					"value" 		=> array_flip(array(
								'left' 	 => 'Left',
								'right'  => 'Right',
								'center' => 'Center',
									)),
					"group" 		=> __( "Design", "Templatepath" ),
				),				
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Title Color", "Templatepath"),
					"param_name" 	=> "title_color",
					"value" 		=> '',
					"group" 		=> __( "Design", "Templatepath" ),
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Sub Title Color", "Templatepath"),
					"param_name" 	=> "subtitle_color",
					"value" 		=> '',
					"group" 		=> __( "Design", "Templatepath" ),
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Border Color", "Templatepath"),
					"param_name" 	=> "border_color",
					"value" 		=> '',
					"group" 		=> __( "Design", "Templatepath" ),
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Icon Color", "Templatepath"),
					"param_name" 	=> "icon_color",
					"value" 		=> '',
					"group" 		=> __( "Design", "Templatepath" ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Margin Bottom", "Templatepath"),
					"param_name" 	=> "margin_bottom",
					"value" 		=> '',
					"description" 	=> 'Example: 10 or 20.'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_section_title_shortcode' );