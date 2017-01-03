<?php 
/**
 * The Shortcode   
 */  
function tpath_counter_block_shortcode( $atts, $content = null ) {  
	
	$output = '';
	
	extract(  
		shortcode_atts( 
			array(
				'alignment' 		=> 'none',
				'counter_title' 	=> '',
				'counter_value' 	=> '',
				'counter_unit' 		=> '',
				'counter_font_size' => 'normal',
				'title_transform' 	=> '',
				'type' 				=> 'none',
				'icon_flaticons' 	=> '',
				'icon_fontawesome' 	=> '',
				'icon_lineicons' 	=> '',
				'icon_color'		=> '',
				'icon_bgcolor'		=> '',
				'counter_color'		=> '',
				'title_color' 		=> '',
				), $atts 
		) 
	);

	$text_alignment = ( isset( $alignment ) && $alignment != '' ) ? ' text-'. strtolower( $alignment ) : '';
	$title_transform = ( isset( $title_transform ) && $title_transform != '' ) ? ' text-'. strtolower( $title_transform ) : '';
	
	if(isset( $icon_color ) && $icon_color != '') {
		$icon_style = ' style="color: '.$icon_color.';';
	}
	
	if(isset( $icon_bgcolor ) && $icon_bgcolor != '') {
		$icon_bgstyle = ' style="background-color: '.$icon_bgcolor.';';
	}
	
	if(isset( $counter_color ) && $counter_color != '') {
		$counter_style = ' style="color: '.$counter_color.';';
	}
	
	if(isset( $title_color ) && $title_color != '') {
		$title_style = ' style="color: '.$title_color.';';
	}
	
	wp_enqueue_script( 'justice-countto-js' );
	
	$output .= '<div class="tpath-counter-section'. esc_attr( $text_alignment ).'">';
	
		if( isset( $type ) && $type != 'none' ) {
			if( isset( ${'icon_'. $type} ) && ${'icon_'. $type} != '' ) {
				$output .= '<div class="tpath-counter-icon"'.$icon_bgstyle.'><i class="'. esc_attr( ${'icon_'. $type} ) . ' counter-icon"'.$icon_style.'></i></div>';
			}
		}
		$output .= '<div '.$text_style.' class="counter-info">';
			$output .= '<div class="tpath-count-number" data-count="'.$counter_value.'">';
				$output .= '<div '.$counter_style.' class="counter-value counter-size'. $counter_font_size .'">';
					$output .= '<span class="counter"></span>';
					if( isset( $counter_unit ) && $counter_unit != '' ) {
						$output .= '<span class="counter-unit">'. $counter_unit .'</span>';
					}
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="counter-title'.$title_transform.'"'.$title_style.'>';
				$output .= $counter_title;
			$output .= '</div>';
		$output .= '</div>';
		
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_counter_block', 'tpath_counter_block_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_counters_section_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Counters Block', 'Templatepath' ),
			"base" 			=> 'tpath_counter_block',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Alignment", "Templatepath" ),
					"param_name" 	=> "alignment",
					"value" 		=> array_flip(array(
								'none' 	 => 'None',
								'left' 	 => 'Left',
								'right'  => 'Right',
								'center' => 'Center',
								)),					
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Counter Title", "Templatepath"),
					"param_name" 	=> "counter_title",
					"value" 		=> '',
				),	
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Counter Unit", "Templatepath"),
					"param_name" 	=> "counter_unit",
					"value" 		=> '',
					'description' 	=> __( "Insert a unit for the counter. ex % or +", "Templatepath" ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Counter Value", "Templatepath"),
					"param_name" 	=> "counter_value",
					"value" 		=> '',
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Counter Number Size", "Templatepath" ),
					"param_name" 	=> "counter_font_size",
					"std" 			=> "normal",
					"value" 		=> array_flip(array(
									'normal' 	 => 'Normal',
									'small' 	 => 'Small',
									)),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title Text Transform", 'Templatepath' ),
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
					'type' 			=> "dropdown",
					'heading' 		=> __( "Choose from Icon library", "Templatepath" ),
					'value' 		=> array(
						__( 'None', 'Templatepath' ) 			=> 'none',
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
					'heading' 		=> __( 'Icon', 'Templatepath' ),
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
					'heading' 		=> __( 'Icon', 'Templatepath' ),
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
					'heading' 		=> __( 'Icon', 'Templatepath' ),
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
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Counter Number Color", "Templatepath" ),
					"param_name" 	=> "counter_color",
					"value" 		=> '',
					'group' 		=> __( "Design", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Title color", "Templatepath" ),
					"param_name" 	=> "title_color",
					"value" 		=> '',
					'group' 		=> __( "Design", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Icon color", "Templatepath" ),
					"param_name" 	=> "icon_color",
					"value" 		=> '',					
					'group' 		=> __( "Design", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Icon Background color", "Templatepath" ),
					"param_name" 	=> "icon_bgcolor",
					"value" 		=> '',
					'group' 		=> __( "Design", "Templatepath" ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_counters_section_shortcode' );