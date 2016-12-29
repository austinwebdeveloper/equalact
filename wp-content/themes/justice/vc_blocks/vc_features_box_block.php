<?php 
/**
 * The Shortcode   
 */
function tpath_features_box_shortcode( $atts, $content = null ) {
	
	$output = $feature_image = $image_url = $type = $icon_flaticons = $icon_fontawesome = $icon_linecons = $title_type = $title = $title_link = $btn_title = $btn_link = $btn_type = $icon_color = $title_color = $text_color = $title_bottom = '';
	
	extract( 
		shortcode_atts( 
			array(
				'display' 			=> '',
				'alignment' 		=> 'left',
				'feature_image' 	=> '',
				'image_url'			=> '',
				'type' 				=> 'none',
				'icon_flaticons' 	=> '',
				'icon_fontawesome' 	=> '',
				'icon_lineicons' 	=> '',
				'icon_color'		=> '',
				'title' 			=> '',
				'title_type'		=> 'h2',
				'title_transform' 	=> '',
				'title_weight' 		=> 'default',
				'title_link' 		=> '',
				'btn_title' 		=> '',
				'btn_link'			=> '',
				'btn_type'			=> 'btn_bgcolor',
				'title_color'		=> '',
				'text_color'		=> '',
				'title_bottom'		=> '',
			), $atts 
		) 
	);
	
	$text_alignment = ( isset( $alignment ) && $alignment != '' ) ? ' text-'. strtolower( $alignment ) : '';
	$title_transform = ( isset( $title_transform ) && $title_transform != '' ) ? ' text-'. strtolower( $title_transform ) : '';
	$title_weight = ( isset( $title_weight ) && $title_weight != '' ) ? ' text-weight-'. strtolower( $title_weight ) : '';
	
	if(isset( $icon_color ) && $icon_color != '') {
		$icon_style = 'style="color: '.$icon_color.';"';
	}
	if(isset( $title_bottom ) && $title_bottom != '') {
		$title_bottom_style = 'style="margin-bottom: '.$title_bottom.'px;"';
	}
	if(isset( $title_color ) && $title_color != '') {
		$text_style = 'style="color: '.$title_color.';"';
	}
	if(isset( $text_color ) && $text_color != '') {
		$text_content_style = 'style="color: '.$text_color.'!important;"';
	}
	// Image URL
	$img_link = $img_title = $img_target = '';
	if( $image_url && $image_url != '' ) {
		$link = vc_build_link( $image_url );
		$img_link = isset( $link['url'] ) ? $link['url'] : '';
		$img_title = isset( $link['title'] ) ? $link['title'] : '';
		$img_target = isset( $link['target'] ) ? $link['target'] : '';
	}
	
	$feature_img_id = preg_replace( '/[^\d]/', '', $feature_image );
	$img_size = '';
	$img_size = 'theme-mid';
	
	$feature_img = wpb_getImageBySize( array( 'attach_id' => $feature_img_id, 'thumb_size' => $img_size, 'class' => 'vc_feature_box-img' ) );
	
	$output .= '<div class="tpath-feature-box tpath-featurebox-image btn-'.esc_attr( $btn_type . $text_alignment ).'">';
			
		// Image or Icon 
		$output .= '<div class="tpath-feature-top">';
			if( isset( $feature_img ) && $feature_img != '' ) {
			$output .= '<div class="tpath-feature-image">';
				if( isset( $img_link ) && $img_link != '' ) {
					$output .= '<a href="'. esc_url( $img_link ) .'" title="'. esc_attr( $img_title ) .'" target="'. esc_attr( $img_target ) .'">';
				}
				$output .= $feature_img['thumbnail'];
				if( isset( $img_link ) && $img_link != '' ) {
					$output .= '</a>';
				}
			$output .= '</div>';
			} else {
				$output .= '<div class="tpath-feature-icon">';
					if(isset( ${'icon_'. $type} ) && ${'icon_'. $type} != '') {
						$output .=  '<i '.$icon_style.' class="'. esc_attr( ${'icon_'. $type} ).'"></i>';
					}
				$output .= '</div>';
			}
		$output .= '</div>';
		
		// Title
		$output .= '<div '.$title_bottom_style.' class="tpath-feature-box-title">';
			
			if( isset( $title_link ) && $title_link != '' ) {
				$output .= '<a href="'. esc_url( $title_link ) .'" title="'. esc_attr($title) .'">';
			}
			if( isset( $title ) && $title != '' ) {
				$output .= '<'.$title_type.' '.$text_style.' class="feature-title'. $title_transform . $title_weight .'">'. esc_html($title) .'</'.$title_type.'>';
			}
			if( isset( $title_link ) && $title_link != '' ) {
				$output .= '</a>';
			}
		$output .= '</div>';		
		
		
		// Content 
		$output .= '<div '.$text_content_style.' class="tpath-feature-box-content">';
			$output .= wpb_js_remove_wpautop( $content , true );
		$output .= '</div>';
			
		// Button
		if( isset( $btn_title ) && $btn_title != '' ) {
			$output .= '<div class="tpath-feature-box-btn">';
				if( isset( $btn_link ) && $btn_link != '' ) {
					$output .= '<a href="'. esc_url($btn_link) .'" class="btn btn-default ' .$btn_type.'">'.  esc_html($btn_title) .'</a>';
				}
			$output .= '</div>';
		}
		
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_feature_box', 'tpath_features_box_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_features_box_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Feature Box', 'Templatepath' ),
			"base" 			=> 'tpath_feature_box',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(	
				array(
					"type" 			=> "attach_image",
					"heading" 		=> __( "Feature Image", "Templatepath" ),
					"param_name" 	=> "feature_image",
					"value" 		=> '',
				),
				array(
					"type"			=> "vc_link",
					"heading"		=> __( "Image Link", 'Templatepath' ),
					"param_name"	=> "image_url",
					"value"			=> "",
					'dependency'	=> array(
						'element'	=> 'feature_image',
						'not_empty'	=> true,
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
				),
				array(
					'type' 			=> 'iconpicker',
					'heading' 		=> __( 'Icon', 'Templatepath' ),
					'param_name' 	=> 'icon_flaticons',
					'value' 		=> 'flaticon flaticon-branch5', // default value to backend editor admin_label
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
					'value' 		=> 'fa fa-minus-circle', // default value to backend editor admin_label
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
					'value' 		=> 'simple-icon icon-close', // default value to backend editor admin_label
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
					"type" 			=> "dropdown",
					"heading" 		=> __( "Title Type", "Templatepath" ),
					"param_name" 	=> "title_type",
					"value"			=> array(
							"h2"		=> "h2",
							"h3"		=> "h3",
							"h4"		=> "h4",
							"h5"		=> "h5",
							"h6"		=> "h6",
					),
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Title", "Templatepath"),
					"param_name" 	=> "title",
					"value" 		=> '',
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Title Link", 'Templatepath' ),
					"param_name"	=> "title_link",
					"value"			=> "",
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title Transform", 'Templatepath' ),
					"param_name"	=> "title_transform",
					"value"			=> array(
						__( "Default", 'Templatepath' )		=> '',
						__( "None", 'Templatepath' )		=> 'transform-none',
						__( "Capitalize", 'Templatepath' )	=> 'capitalize',
						__( "Uppercase", 'Templatepath' )	=> 'uppercase',
						__( "Lowercase", 'Templatepath' )	=> 'lowercase',
					),
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title Weight", 'Templatepath' ),
					"param_name"	=> "title_weight",
					"value"			=> array(
						__( "Default", 'Templatepath' )		=> 'default',
						__( "Normal", 'Templatepath' )		=> 'normal',
						__( "Bold", 'Templatepath' )		=> 'bold',
						__( "Extra Bold", 'Templatepath' )	=> 'extra-bold',						
					),
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type" 			=> "textarea_html",
					"heading" 		=> __("Content", "Templatepath"),
					"param_name" 	=> "content",
					"value" 		=> '',
					"holder" 		=> 'div',
					"group" 		=> __( "Content", "Templatepath" ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Button Text", 'Templatepath'),
					"param_name" 	=> "btn_title",
					"value" 		=> '',
					"group" 		=> __( "Button", "Templatepath" ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Button URL", 'Templatepath'),
					"param_name" 	=> "btn_link",
					"value" 		=> '',
					"group" 		=> __( "Button", "Templatepath" ),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Button Type", 'Templatepath'),
					"param_name" 	=> "btn_type",
					"value" 		=> array_flip(array(
									'btn_bgcolor' 				 => 'Default',
									'simple_text' 				 => 'Simple Text',
									'btn_trans_white' 	 		 => 'Transparent with White',
									'btn_trans_themecolor'	 	 => 'Transparent with default',
									)),
					'group' 		=> __( "Button", "Templatepath" ),
				),				
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Title Margin Bottom (Enter Values in Number - without px)", 'Templatepath'),
					"param_name" 	=> "title_bottom",
					"value" 		=> '',
					"group" 		=> __( "Style", "Templatepath" ),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Alignment", "Templatepath" ),
					"param_name" 	=> "alignment",
					"value" 		=> array_flip(array(
									'left' 	 => 'Left',
									'right'  => 'Right',
									'center' => 'Center',
									)),
					"group" 		=> __( "Style", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Icon color", "Templatepath" ),
					"param_name" 	=> "icon_color",
					"value" 		=> '',
					"description" 	=> '',
					"group" 		=> __( "Style", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Title color", "Templatepath" ),
					"param_name" 	=> "title_color",
					"value" 		=> '',
					"description" 	=> '',
					'group' 		=> __( "Style", "Templatepath" ),
				),
				array(            
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Text color", "Templatepath" ),
					"param_name" 	=> "text_color",
					"value" 		=> '',
					"description" 	=> '',
					'group' 		=> __( "Style", "Templatepath" ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_features_box_shortcode' );