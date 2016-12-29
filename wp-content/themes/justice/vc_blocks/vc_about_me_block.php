<?php 
/**
 * The Shortcode   
 */ 
function tpath_about_me_shortcode ( $atts, $content = null ) {  
	
	$output = $feature_image = $bg_color = $author_image = $author_name = $author_desigination = '';
	
	extract(  
		shortcode_atts( 
			array(
				'feature_image' 		=> '',
				'author_image' 			=> '',
				'author_name' 			=> '',
				'author_desigination' 	=> '',
				'bg_color'				=> '',
				'border_color'			=> '',
				'author_border'			=> '',
				), $atts 
		) 
	);
	
	$feature_img_id = preg_replace( '/[^\d]/', '', $feature_image );
	$feature_img = wpb_getImageBySize( array( 'attach_id' => $feature_img_id, 'thumb_size' => "full", 'class' => 'vc_feature_box-img' ) );
	
	$author_img_id = preg_replace( '/[^\d]/', '', $author_image );
	$img_size = 'theme-mid';
	$author_img = wpb_getImageBySize( array( 'attach_id' => $author_img_id, 'thumb_size' => $img_size, 'class' => 'vc_author-img' ) );
	
	if(isset( $bg_color ) && $bg_color != '') {
		$bg_style = 'style="background-color: '.$bg_color.';"';
	}
	if(isset( $border_color ) && $border_color != '') {
		$border_style = 'style="border-color: '.$border_color.';"';
	}
	if(isset( $author_border ) && $author_border != '') {
		$author_style = 'style="border-color: '.$author_border.';"';
	}
	
	if(isset( $author_image ) && $author_image != '') {
		$extra_class = 'with_author_img';
	}
	
	$output .= '<div '.$bg_style.' class="tpath-quote-box '.esc_attr( $extra_class ).'">';
	
		// Background main image
		if( isset( $feature_image ) && $feature_image != '' ) {
		$output .= '<div class="tpath-quote-bg-image">';
			$output .= $feature_img['thumbnail'];
		$output .= '</div>';
		}
		
		$output .= '<div '.$border_style.' class="tpath-quote-border">';
			$output .= '<div class="tpath-quote-content">';
			// Author Image
			if( isset( $author_img ) && $author_img != '' ) {
				$output .= '<div class="author-img padding5">';
					$output .= $author_img['thumbnail'];
				$output .= '</div>';
			} 
			$output .= '<div class="quote-author-info padding5">';
				// Content 
				$output .= wpb_js_remove_wpautop( $content, true );
				$output .= '<div '.$author_style.' class="author-title">';
					if(isset( $author_desigination ) && $author_desigination != '') {
						$output .= '<span class="author-designation">'. esc_html($author_desigination) .',</span>';
					}
					$output .= '' . esc_html($author_name) .'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_about_me', 'tpath_about_me_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_our_quotes_shortcode () {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'About Me', 'Templatepath' ),
			"base" 			=> 'tpath_about_me',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(	
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Author Name", "Templatepath"),
					"param_name" 	=> "author_name",
					"value" 		=> '',
				),	
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Author Designation", "Templatepath"),
					"param_name" 	=> "author_desigination",
					"value" 		=> '',
				),	
				array(
					"type" 			=> "attach_image",
					"heading" 		=> __( "Author Image", "Templatepath" ),
					"param_name" 	=> "author_image",
					"value" 		=> '',
				),
				array(
					"type" 			=> "textarea_html",
					"heading" 		=> __("Content", "Templatepath"),
					"param_name" 	=> "content",
					"value" 		=> '',
					"holder" 		=> 'div',
				),	
				array(
					"type" 			=> "attach_image",
					"heading" 		=> __( "Background Image", "Templatepath" ),
					"param_name" 	=> "feature_image",
					"value" 		=> '',
					"group"			=> __( "Style", "Templatepath" ),
				),	
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Background Color", "Templatepath" ),
					"param_name" 	=> "bg_color",
					"value" 		=> '',
					"group"			=> __( "Style", "Templatepath" ),
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Border Color", "Templatepath" ),
					"param_name" 	=> "border_color",
					"value" 		=> '',
					"group"			=> __( "Style", "Templatepath" ),
				),
				array(
					"type" 			=> "colorpicker",
					"heading" 		=> __( "Author Border Color", "Templatepath" ),
					"param_name" 	=> "author_border",
					"value" 		=> '',
					"group"			=> __( "Style", "Templatepath" ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_our_quotes_shortcode' );