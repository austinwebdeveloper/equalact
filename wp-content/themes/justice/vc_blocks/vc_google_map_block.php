<?php 
/**
 * The Shortcode  
 */ 
function tpath_google_map_shortcode( $atts, $content = NULL ) { 
	
	$output = '';
	
	$atts = vc_map_get_attributes( 'tpath_google_map', $atts );
	extract( $atts );
	
	$addresses = explode('|', $address);
		
	if( $map_overlay == "true" && $hue_color == '' ) {
		$hue_color = "#256185";
	}
	
	$map_marker_img = wpb_getImageBySize( array( 'attach_id' => $marker_image, 'thumb_size' => 'full' ) );
	$marker_img = $map_marker_img['p_img_large'][0];
		
	if( ! $marker_img ) {
		$marker_img = TEMPLATETHEME_URL . '/images/map-marker.png';
	}
	
	$data_attr = '';
	$data_attr = ' data-type="'. $map_type .'"';
	$data_attr .= ' data-zoom="'. $map_zoom .'"';
	$data_attr .= ' data-scrollwheel="'. $scroll_wheel .'"';
	$data_attr .= ' data-zoomcontrol="'. $zoom_control .'"';
	if( $map_overlay == "true" ) {
		$data_attr .= ' data-hue="'. $hue_color .'"';
	}
	$data_attr .= ' data-marker="'. $marker_img .'"';
	$data_attr .= ' data-address="'. $addresses[0] .'"';
	$data_attr .= ' data-addresses="'. $address .'"';
	$data_attr .= ' data-title="'. $title .'"';
	$data_attr .= ' data-content="' . str_replace( '"', "'", $info_content ) .'"';
	
	if( isset( $map_width ) && $map_width != '' ) {
		$map_styles = ' style="width: '.$map_width.'; ';
		if( isset( $map_height ) && $map_height != '' ) {
			$map_styles .= 'height: '.$map_height.';"';
		} else {
			$map_styles .= '"';
		}
	}
	
	$output .= '<div class="gmap-wrapper">';
		$output .= '<div class="gmap_canvas"'. $data_attr .''.$map_styles.'>';
		$output .= '</div>';
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_google_map', 'tpath_google_map_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_google_map_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Google Map', 'Templatepath' ),
			"base" 			=> 'tpath_google_map',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Map Type", 'Templatepath'),
					"param_name" 	=> "map_type",
					"admin_label" 	=> true,
					"value" 		=> array(
						__( "Roadmap", "Templatepath" )		=> "roadmap",
						__( "Satellite", "Templatepath" )	=> "satellite",
						__( "Hybrid", "Templatepath" )		=> "hybrid",
						__( "Terrain", "Templatepath" )		=> "terrain"
					),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Map Width", 'Templatepath'),
					"param_name" 	=> "map_width",
					"value" 		=> '100%',
					"admin_label" 	=> true,					
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Map Height", 'Templatepath'),
					"param_name" 	=> "map_height",
					"value" 		=> '500px',
					"admin_label" 	=> true,					
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Map Zoom Level", 'Templatepath'),
					"param_name" 	=> "map_zoom",
					"value" 		=> '12',
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Map Scrollwheel", "Templatepath" ),
					"param_name"	=> "scroll_wheel",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false",
					),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Map Zoom Control", "Templatepath" ),
					"param_name"	=> "zoom_control",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false",
					),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Map Overlay", "Templatepath" ),
					"param_name"	=> "map_overlay",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false",
					),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Map Overlay Color", "Templatepath" ),
					"param_name"	=> "hue_color",						
				),
				array(
					"type"			=> "attach_image",
					"heading"		=> __( "Marker Image", "Templatepath" ),
					"param_name"	=> "marker_image",
					"value"			=> "",
				),
				array(
					"type"			=> "textarea",
					"heading"		=> __( "Latitude/ Longtitude", "Templatepath" ),
					"param_name"	=> "address",
					'admin_label' 	=> true,
					"description" 	=> __( "Add latitude/longtitude to show marker on map. To show multiple marker locations on map, to separate latitude/longtitude by using | symbol. <br />Ex: -33.867139, 151.207114|-4.325, 15.322222", "Templatepath" ),
					"value"			=> "-33.867139, 151.207114",
				),
				// Content
				array(
					"type"			=> "exploded_textarea",
					"heading"		=> __( "Title", "Templatepath" ),
					"param_name"	=> "title",
					"value" 		=> 'First Marker Title,Second Marker Title',
					"description" 	=> __( "Enter title for each marker position here. Divide titles with linebreaks (Enter).", "Templatepath" ),
					"group"			=> __( "Content", "Templatepath" ),
				),
				array(
					"type"			=> 'textarea',
					"heading"		=> __( "Content", "Templatepath" ),
					"param_name"	=> "info_content",
					"value" 		=> 'First Marker Content|Second Marker Content',
					"description" 	=> __( "Enter content for each marker position here. Divide content with | and divide new line with ,", "Templatepath" ),
					"group"			=> __( "Content", "Templatepath" ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_google_map_shortcode' );