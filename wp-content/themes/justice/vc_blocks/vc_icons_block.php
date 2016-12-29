<?php 
/**
 * The Shortcode 
 */ 
function tpath_iconslist_shortcode( $atts, $content = null ) { 
	
	$output = '';
	
	extract(  
		shortcode_atts( 
			array(
				'type' 				=> 'flaticons',
				'icon_flaticons' 	=> '',
				'icon_fontawesome' 	=> '',
				'icon_lineicons' 	=> '',
				'title' 			=> '',
				'icon_color' 		=> '',
				), $atts 
		) 
	);
	
	$icon_style = '';
	if(isset( $icon_color ) && $icon_color != '') {
		$icon_style = ' style="color: '.$icon_color.';';
	}
	
	$output .= '<div class="tpath-icons-box">';	
	
		$output .= '<div class="tpath-icon-box-content icon-align-left">';
			$output .= '<div class="tpath-icon-view">';
				if( isset( ${'icon_'. $type} ) && ${'icon_'. $type} != '' ) {
					$output .= '<i class="'. esc_attr( ${'icon_'. $type} ) .'"'.$icon_style.'></i>';
				}
			$output .= '</div>';
			$output .= '<div class="tpath-icon-content">';
				$output .= '<h5>'. esc_html($title) .'</h5>';
				// Content
				$output .= wpb_js_remove_wpautop( $content, true );
			$output .= '</div>';
		$output .= '</div>';
	
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_iconslist', 'tpath_iconslist_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_iconslist_shortcode () {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Icons Box', 'Templatepath' ),
			"base" 			=> 'tpath_iconslist',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(	
 				array(
					'type' 			=> "dropdown",
					'heading' 		=> __( "Choose from Icon library", "Templatepath" ),
					'value' 		=> array(
						__( 'Flaticons', 'Templatepath' ) 		=> 'flaticons',
						__( 'Font Awesome', 'Templatepath' ) 	=> 'fontawesome',
						__( 'Lineicons', 'Templatepath' ) 		=> 'lineicons',						
					),
					'admin_label' 	=> true,
					'param_name' 	=> 'type',
					'description' 	=> __( "Select icon library.", "Templatepath" ),
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
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __("Icon Color", "Templatepath"),
					"param_name" 	=> "icon_color",
					"value" 		=> '',
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Title", "Templatepath"),
					"param_name" 	=> "title",
					"value" 		=> '',
				),
				array(
					"type" 			=> "textarea_html",
					"heading" 		=> __("Content", "Templatepath"),
					"param_name" 	=> "content",
					"value" 		=> '',
					"holder" 		=> 'div',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_iconslist_shortcode' );