<?php
/* =========================================================
 * Alert Shortcode
 * ========================================================= */
function tpath_alert_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'type' 				=> 'info',
				'close' 			=> 'no',
				'animation_type' 	=> 'none',
				'animation_delay' 	=> '',
			), $atts));
			
	$close_btn = $animation_class = $extra_data = '';
			
	if( $close == 'yes' ) {
		$close_btn = '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>';
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
  
	return '<div role="alert" class="alert fade in alert-'.$type.''.$animation_class.'" '.$extra_data.'>'. $close_btn . do_shortcode($content) . '</div>';
}
add_shortcode('tpath_alert', 'tpath_alert_shortcode');

/* =========================================================
 * Button Shortcode
 * ========================================================= */
function tpath_button_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'url' 					=> '',
				'style' 				=> 'default',
				'size' 					=> 'default',
				'color' 				=> '',
				'hover_color' 			=> '',
				'bg_color' 				=> '',
				'bg_hover_color' 		=> '',
				'border_width'			=> '',
				'border_color' 			=> '',
				'border_hover_color' 	=> '',
				'icon' 					=> '',
				'icon_pos' 				=> '',
				'extra_class'			=> '',
				'animation_type' 		=> 'none',
				'animation_delay' 		=> '',
				'target' 				=> '',
			), $atts));
			
	static $tpath_button_id = 1;
	$output = $styles = $icon_left = $icon_right = $animation_class = $extra_data = $btn_sizes = $color_styles = $hover_styles = '';
	
	if( $color != '' ) {		
		$color_styles = sprintf( 'color:%s;', $color );		
	}
	
	if( $hover_color != '' ) {
		$hover_styles = sprintf( 'color:%s;', $hover_color );
	} else {
		$hover_styles = sprintf( 'color:%s;', $color );
	}
	
	if( $style == 'custom' && $bg_color != '' ) {
		$color_styles .= sprintf( 'background-color:%s;', $bg_color );
	}
	
	if( $style == 'custom' && $bg_hover_color != '' ) {
		$hover_styles .= sprintf( 'background-color:%s;', $bg_hover_color );
	} else if( $style == 'custom' && $bg_hover_color == '' ) {
		$hover_styles .= sprintf( 'background-color:%s;', $bg_color );
	}
	
	if( $style == 'custom' && $border_width != '' || $border_color != '' ) {
		$color_styles .= sprintf( 'border:%spx solid %s;', $border_width, $border_color );
	}
	
	if( $style == 'custom' && $border_hover_color != '' ) {
		$hover_styles .= sprintf( 'border-color:%s;', $border_hover_color );
	}
	
	if( $style == 'custom' && $bg_color != '' || $color != '' ) {
		$styles .= '<style type="text/css">';
		$styles .= sprintf( 'a.tpath-button-%s{%s}', $tpath_button_id, $color_styles );
		$styles .= sprintf( 'a.tpath-button-%s:hover, a.tpath-button-%s:active, a.tpath-button-%s:focus{%s}', $tpath_button_id, $tpath_button_id, $tpath_button_id, $hover_styles );
		$styles .= '</style>';
	}
	
	if( $size ) {
		if( $size == 'large' ) $btn_sizes = ' btn-lg';
		if( $size == 'small' ) $btn_sizes = ' btn-sm';
		if( $size == 'mini' ) $btn_sizes = ' btn-xs';
		if( $size == 'wide' ) $btn_sizes = ' btn-wide';
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $icon != '' && $icon_pos == "left" ) {
		$icon_left = '<i class="fa fa-'.$icon.'"></i> ';
	}
	
	elseif( $icon != '' && $icon_pos == "right" ) {
		$icon_right = ' <i class="fa right-align fa-'.$icon.'"></i>';
	}
	
	$output = $styles . '<a class="tpath-button-'.$tpath_button_id.' btn btn-'.$style.''. $btn_sizes . $animation_class.' '.$extra_class.'" href="'.esc_url( $url ).'" target="'.$target.'" '.$extra_data.'>'. $icon_left . do_shortcode($content) . $icon_right .'</a>';
	
	$tpath_button_id++;
  
	return $output;
}
add_shortcode('tpath_button', 'tpath_button_shortcode');
	
/* =========================================================
 * Columns Shortcode
 * ========================================================= */ 
function tpath_columns_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'container' 		=> 'no',
				'container_class' 	=> '',
			), $atts));
			
	$output = $extra_class = '';
	
	if( isset( $container_class ) && $container_class != '' ) {
		$extra_class = ' ' . $container_class;
	}
		
	if( isset( $container ) && $container == 'yes' ) {
		$output .= '<div class="container'.$extra_class.'">';
	}
	
	$output .= '<div class="row">';
	$output .= do_shortcode( str_replace('<br />', '', $content) );
	$output .= '</div>';
	
	if( isset( $container ) && $container == 'yes' ) {
		$output .= '</div>';
	}
	return $output;
}
add_shortcode('tpath_columns', 'tpath_columns_shortcode');

function tpath_column_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'size' 				=> '6',
				'column_class' 		=> '',
				'animation_type' 	=> 'none',
				'animation_delay' 	=> '',
			), $atts));
			
	$animation_class = $extra_data = '';
			
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
			  
	return '<div class="col-md-'.$size.''.$animation_class.' '.$column_class.'" '.$extra_data.'>'. do_shortcode( str_replace('<br />', '', $content) ) . '</div>';
}
add_shortcode('tpath_column', 'tpath_column_shortcode');

/* =========================================================
 * Client Slider Shortcode
 * ========================================================= */ 
function tpath_client_slider_shortcode( $atts, $content = null ) {
	static $tpath_clients = 1;
	
	wp_enqueue_script( 'tpath-carousel-slider-js' );
		
	$output = '';
	$output = '<div id="tpath-client-slider'.$tpath_clients.'" class="tpath-client-slider">';
	$output .= do_shortcode(strip_tags($content));
	$output .= '</div>';
	
	$tpath_clients++;
	
	return $output;
}
add_shortcode('tpath_client_slider', 'tpath_client_slider_shortcode');

function tpath_client_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'link' 		=> '',
				'target' 	=> '_self',
				'image' 	=> '',
				'alt' 		=> '',
			), $atts));
			
	$output = '';
	
	$output .= '<div class="client-item">';
	if( $link != '' ) {
		$output .= '<a href="'.esc_url($link).'" target="'.$target.'"><img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" /></a>';
	} else {
		$output .= '<img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" />';
	}
	$output .= '</div>';
	
	return $output;
}
add_shortcode('tpath_client', 'tpath_client_shortcode');

/* =========================================================
 * Counters Shortcode
 * ========================================================= */ 
function tpath_counters_shortcode( $atts, $content = null ) {
	$output = '';
	$output = '<div class="row">';
	$output .= do_shortcode( str_replace('<br />', '', $content) );
	$output .= '</div>';
	return $output;
}
add_shortcode('tpath_counters', 'tpath_counters_shortcode');

function tpath_counter_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'title' 		=> '',
				'column_size' 	=> '',
				'value' 		=> '',
				'icon'			=> '',
				'iconcolor'		=> '',
			), $atts));
	
	$output = $inline_style = '';
	
	if( $iconcolor != '' ) {
		$inline_style = ' style="color: '.$iconcolor.'"';
	}
	
	wp_enqueue_script( 'tpath-countto-js' );
	
	$output .= '<div class="col-md-'.$column_size.' tpath-counter">';
		if( $icon != '' ) {
			$output .= '<div class="counter-icon">';				
				$output .= '<i class="fa fa-'.$icon.'"'.$inline_style.'></i>';						
			$output .= '</div>';
		}
		$output .= '<div class="counter-info">';		
			$output .= '<div class="tpath-count-number" data-count="'.$value.'">';
			$output .= '<span class="counter"></span>';		
			$output .= '</div>';
			$output .= $title;
		$output .= '</div>';		
	$output .= '</div>';
	
	return $output;
}
add_shortcode('tpath_counter', 'tpath_counter_shortcode');

/* =========================================================
 * Dropcap Shortcode
 * ========================================================= */ 
function tpath_dropcap_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'color' 	=> '',				
			), $atts));
	
	if( $color != '' ) {
		$styles = sprintf( 'color:%s;', $color );
		$inline_style = sprintf( ' style=%s', $styles );
	}
	
	return '<span class="dropcap"'.$inline_style.'>'. do_shortcode($content) . '</span>';	
}
add_shortcode('tpath_dropcap', 'tpath_dropcap_shortcode');

/* =========================================================
 * Highlight Shortcode
 * ========================================================= */ 
function tpath_highlight_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'bg_color' 	=> '',
				'color' 	=> '',
			), $atts));
	
	if( $color != '' || $bg_color != '' ) {
		$styles = sprintf( 'color:%s;', $color );
		$styles .= sprintf( 'background-color:%s;', $bg_color );
		$inline_style = sprintf( ' style=%s', $styles );
	}
	
	return '<span class="label"'.$inline_style.'>'. do_shortcode($content) . '</span>';	
}
add_shortcode('tpath_highlight', 'tpath_highlight_shortcode');

/* =========================================================
 * List Item Shortcode
 * ========================================================= */ 
function tpath_listitem_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'icon' 			 	=> '',
				'iconcolor' 	 	=> '',
				'iconbgcolor' 	 	=> '',
				'icontype'  	 	=> '',
				'listinline' 	 	=> '',
				'animation_type' 	=> '',
				'animation_delay'	=> '',
			), $atts));
			
	static $tpath_list_id = 1;
	$output = $extra_class = $icon_class = $icon_styles = $animation_class = $extra_data = $li_class = '';
	
	if( $icon != '' ) {
		$icon_class = $icon;
		$extra_class = ' icon';
	}
	
	if( $iconcolor != '' ) {
		$icon_styles .= sprintf( 'color:%s;', $iconcolor );
	}
	
	if( $icontype != 'none' ) {
		$icon_styles .= sprintf( 'background-color:%s;', $iconbgcolor );
		$extra_class .= sprintf( ' %s', $icontype );
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $listinline == 'yes' ) {
		$extra_class .= ' list-inline';
	}
	
	if( $icon_class == '' ) {
		$extra_class .= ' custom-icon';
	}
		
	if( $icon != '' ) {	
		$output .= "<style type='text/css'>#tpath-list-item-{$tpath_list_id} li:before{ {$icon_styles} };</style>";
	}
	
	$output .= str_replace('<ul>', '<ul id="tpath-list-item-'.$tpath_list_id.'" class="tpath-listitem'. $extra_class . $animation_class .'" '.$extra_data.'>', $content);
	if( $icon_class != '' ) {
		$output = str_replace('<li>', '<li class="'.$icon_class.'">', $output);
	}
	
	$output = do_shortcode( str_replace( array( '</p>', '<p>' ), '', $output) );
	
	$tpath_list_id++;
	
	return $output;
}
add_shortcode('tpath_listitem', 'tpath_listitem_shortcode');

/* =========================================================
 * FontAwesome Icons Shortcode
 * ========================================================= */ 
function tpath_fontawesome_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'icon' 				=> '',
				'icontype' 			=> '',
				'size' 				=> '',
				'iconcolor'			=> '',
				'iconbgcolor' 		=> '',
				'bordercolor' 		=> '',
				'borderwidth' 		=> '',
				'animation_type'	=> '',
				'animation_delay'	=> '',
			), $atts));
			
	$styles = $extra_class = $inline_style = $animation_class = $extra_data = '';
	
	if( $iconcolor != '' ) {
		$styles = sprintf( 'color:%s;', $iconcolor );
	}
	
	if( $bordercolor != '' ) {
		if( $borderwidth == '' ) {
			$borderwidth = 1;
		}
		$styles .= sprintf( 'border:%spx solid %s;', $borderwidth, $bordercolor );
	}
	
	if( $icontype != 'none' ) {
		$styles .= sprintf( 'background-color:%s;', $iconbgcolor );		
		$extra_class .= sprintf( ' %s', $icontype );
	}
	
	if( $size ) {		
		$extra_class .= sprintf( ' %s', $size );
	}	
	
	if( $iconcolor != '' || $bordercolor != '' || $iconbgcolor != '' ) {	
		$inline_style = $styles;	
	}
				
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	return '<i class="tpath-fa-icon fa fa-'. $icon . $extra_class . $animation_class .'" style="'.$inline_style.'" '.$extra_data.'></i>';	
}
add_shortcode('tpath_fontawesome', 'tpath_fontawesome_shortcode');

/* =========================================================
 * Blockquote Shortcode
 * ========================================================= */ 
function tpath_blockquote_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'footer_text' 		=> '',
				'position' 			=> '',
				'animation_type' 		=> '',
				'animation_delay' 		=> '',
			), $atts));
	
	$extra_class = $author_html = $extra_data = '';
	
	if( $position == 'right' ) {
		$extra_class = ' blockquote-reverse';
	}
	
	if( $footer_text != '' ) {
		$author_html = '<footer>'. $footer_text . '</footer>';
	}
	
	if( $animation_type != 'none' ) {
		$extra_class .= ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	$output = '';
	
	$output = '<blockquote class="tpath-blockquote'.$extra_class.'" '.$extra_data.'><p>' . do_shortcode($content) . '</p>'. $author_html . '</blockquote>';
	
	return $output;	
}
add_shortcode('tpath_blockquote', 'tpath_blockquote_shortcode');

/* =========================================================
 * Bootstrap Carousel Shortcode
 * ========================================================= */ 
function tpath_carousel_shortcode( $atts, $content = null ) {

	static $tpath_carousel = 1;
	$output = '';
	
	$output .= '<script type="text/javascript">';
	$output .= 'jQuery(document).ready(function($){';	
	$output .= '$("#tpath-carousel-'.$tpath_carousel.'").find(".item:first").addClass("active");';
	$output .= '});';
	$output .= '</script>';
	$output .= '<div id="tpath-carousel-'.$tpath_carousel.'" class="carousel slide" data-ride="carousel">';
	$output .= '<div class="carousel-inner">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	$output .= '<a class="left carousel-control" href="#tpath-carousel-'.$tpath_carousel.'" data-slide="prev">';
    $output .= '<span class="glyphicon glyphicon-chevron-left"></span>';
	$output .= '</a>';
	$output .= '<a class="right carousel-control" href="#tpath-carousel-'.$tpath_carousel.'" data-slide="next">';
	$output .= '<span class="glyphicon glyphicon-chevron-right"></span>';
	$output .= '</a>';
	$output .= '</div>';
	
	$tpath_carousel++;
	
	return $output;	
}
add_shortcode('tpath_carousel', 'tpath_carousel_shortcode');

function tpath_image_shortcode( $atts, $content = null ) {
	
	$atts = extract(shortcode_atts(
			array(
				'linktype' 	=> 'lightbox',
				'link' 	 	=> '',
				'target' 	=> '',
				'image'  	=> '',
				'alt' 	 	=> '',
				'caption' 	=> '',
			), $atts));
		
	$output = $lightbox_class = '';
	
	if( $linktype == 'link' ) {
		$url = $link;
	}
	elseif( $linktype == 'lightbox' ) {
		$url = $image;
		$lightbox_class = ' rel="prettyPhoto"';
	}
	$output = '<div class="item">';
		if( $image != '' ) {
			if( $linktype == 'none' ) {
				$output .= '<img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" />';
			}
			else {
				$output .= '<a class="carousel-image" href="'.esc_url($url).'"'.$lightbox_class.' target="'.$target.'"><img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" /></a>';
			}
		}
		if( $caption != '' ) {
			$output .= '<div class="carousel-caption">'.$caption.'</div>';
		}
	$output .= '</div>';
	
	return $output;
}
add_shortcode('tpath_image', 'tpath_image_shortcode');

/* =========================================================
 * Map Shortcode
 * ========================================================= */ 
function tpath_map_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'address' 			=> '',
				'type' 				=> 'roadmap',
				'width' 			=> '100%',
				'height' 			=> '350px',
				'zoom' 				=> '5',
				'onclick' 			=> '',
				'scrollwheel' 		=> '',
				'scale' 			=> '',
				'zoom_pancontrol' 	=> '',
				'marker' 			=> '',
				'map_info' 			=> ''
			), $atts));
			
	static $tpath_map = 1;
	$output = '';
			
	$tpath_addresses = explode('|', $address);
	$markers = '';
	$marker_img = '';
	$map_type = strtoupper($type);
	if( $scrollwheel == 'yes' ) {
		$scroll_wheel = 'true';
	} else {
		$scroll_wheel = 'false';
	}
	
	if( $scale == 'yes' ) {
		$scale_control = 'true';
	} else {
		$scale_control = 'false';
	}
	
	if( $zoom_pancontrol == 'yes' ) {
		$zoom_control = 'true';
	} else {
		$zoom_control = 'false';
	}
	if( $marker ) {
		$marker_img = $marker;
	}
	else {
		$marker_img = TEMPLATETHEME_URL . '/images/map-marker.png';
	}
	
	if( isset( $map_info ) && $map_info == '' ) {
		$map_info = $addresses;
	}
	foreach($tpath_addresses as $addresses) {
		$markers .= '{address: "'.$addresses.'", data: "'.$map_info.'", options:{icon: "'.$marker_img.'"}},';
	}
	
	if( $onclick == 'yes' ) {
		$events = 'click: function(marker, event, context){
			var map = $(this).gmap3("get"),
			infowindow = $(this).gmap3({get:{name:"infowindow"}});
			if (infowindow){
				infowindow.open(map, marker);
				infowindow.setContent(context.data);
			} else {
				$(this).gmap3({
					infowindow:{
					anchor:marker,
					options:{content: context.data}
					}
				});
			}
		} ';
	} else {
		$events = 'mouseover: function(marker, event, context){
			var map = $(this).gmap3("get"),
			infowindow = $(this).gmap3({get:{name:"infowindow"}});
			if (infowindow){
				infowindow.open(map, marker);
				infowindow.setContent(context.data);
			} else {
				$(this).gmap3({
					infowindow:{
					anchor:marker, 
					options:{content: context.data}
					}
				});
			}
			},
			mouseout: function(){
				var infowindow = $(this).gmap3({get:{name:"infowindow"}});
				if (infowindow){
				infowindow.close();
				}
			} ';
	}
	
	if( !is_page_template( 'template-contact.php' ) ) {
		wp_enqueue_script( 'tpath-gmap-api-js' );
		wp_enqueue_script( 'tpath-gmap-js' );
	}
	
	$output = '<style type="text/css" scoped>#tpath_gmap_'.$tpath_map.'{ width: '.$width.'; height: '.$height.'; margin: 0 auto; }</style>';
	
	$output .= '<script type="text/javascript">
jQuery(document).ready(function($){
	$("#tpath_gmap_'.$tpath_map.'").gmap3({
		map:{
		  options:{
			styles: [ { "featureType": "landscape", "stylers": [ { "color": "#E2E2E2" } ] },{ "featureType": "road.highway", "stylers": [ { "color": "#B2B2B2" } ] },{ "featureType": "road.arterial", "stylers": [ { "color": "#FDFDFD" } ] },{ "featureType": "water", "stylers": [ { "color": "#D9D9D9" } ] },{ "elementType": "labels.text.fill", "stylers": [ { "color": "#d3cfcf" } ] },{ "featureType": "poi", "stylers": [ { "color": "#C8C8C8" } ] },{ "elementType": "labels.text", "stylers": [ { "color": "#000000" }, { "saturation": 1 }, { "weight": 0.1 } ] } ]
		  }
		},
		getlatlng:{
		address: "'.$tpath_addresses[0].'",		
		callback: function(results){
		if ( !results ) return;
		$(this).gmap3({
			map:{
				options:{
					center: results[0].geometry.location,
					zoom: '.$zoom.',
					mapTypeId: google.maps.MapTypeId.'.$map_type.',
					scrollwheel: '.$scroll_wheel.',
					scaleControl: '.$scale_control.',
					zoomControl: '.$zoom_control.',
					panControl: '.$zoom_control.',
				}
			},			
			marker:{
				values:['.$markers.' ],
				events:{
						'.$events.'
				} 
			},
		});
		}
		}
	});
});
</script>';
			
	$output .= '<div id="tpath_gmap_'.$tpath_map.'" class="gmap_canvas"></div>';
	
	$tpath_map++;
			
	return $output;	
}
add_shortcode('tpath_map', 'tpath_map_shortcode');

/* =========================================================
 * Image Frame Shortcode
 * ========================================================= */ 
function tpath_imageframe_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'shape' 		 	=> 'none',
				'shadow' 		 	=> 'no',
				'bordercolor' 	 	=> '',
				'borderwidth' 	 	=> '',
				'lightbox' 		 	=> 'no',
				'src' 			 	=> '',
				'alt' 			 	=> '',						
				'animation_type' 	=> '',
				'animation_delay' 	=> ''
			), $atts));
	
	static $tpath_image_frame = 1;
	
	$output = '';
	$animation_class = $img_shape = $extra_data = $extra_class = '';
	
	if( $shape != 'none' ) {
		$img_shape = 'img-' . $shape . ' ';
	}
	
	if( $shadow != 'none' ) {
		$extra_class = ' ' . $shadow;
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $bordercolor != '' ) {
		if( !$borderwidth ) {
			$borderwidth = '1px';
		}
		$output = '<style type="text/css">';
		$output .= '#tpath-imgframe-'.$tpath_image_frame.' img { border: '.$borderwidth.'px solid '.$bordercolor.'; }';
		$output .= '</style>';
	}
	
	$attachment_id = tpath_get_attachment_id_from_url($src);
	$full_image = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	$output .= '<div id="tpath-imgframe-'.$tpath_image_frame.'" class="tpath-imageframe'.$animation_class.$extra_class.'" '.$extra_data.'>';	
	
	if( $lightbox == 'yes' ) {
		$output .= '<a href="'.esc_url($full_image[0]).'" rel="prettyPhoto" title="'.esc_attr($alt).'">';		
	}
	
	$output .= '<img src="'.esc_url($src).'" alt="'.esc_attr($alt).'" class="'.$img_shape.'img-responsive" />';
	
	if( $lightbox == 'yes' ) {
		$output .= '</a>';
	}	
	
	$output .= '</div>';
	
	$tpath_image_frame++;
	
	return $output;
}
add_shortcode('tpath_imageframe', 'tpath_imageframe_shortcode');

/* =========================================================
 * Image Frame with Overlay Shortcode
 * ========================================================= */ 
function tpath_imageframe_overlay_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'shape' 		 	=> 'none',
				'shadow' 		 	=> 'no',
				'bordercolor' 	 	=> '',
				'borderwidth' 	 	=> '',				
				'src' 			 	=> '',
				'alt' 			 	=> '',
				'overlay' 			=> '',
				'overlay_position' 	=> '',				
				'animation_type' 	=> '',
				'animation_delay' 	=> ''
			), $atts));
	
	static $tpath_image_frame_overlay = 1;
	
	$output = '';
	$animation_class = $img_shape = $extra_data = $extra_class = '';
	
	if( $shape != 'none' ) {
		$img_shape = 'img-' . $shape . ' ';
	}
	
	if( $shadow != 'none' ) {
		$extra_class = ' ' . $shadow;
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $bordercolor != '' ) {
		if( !$borderwidth ) {
			$borderwidth = '1px';
		}
		$output = '<style type="text/css">';
		$output .= '#tpath-imgframe-overlay-'.$tpath_image_frame_overlay.' img { border: '.$borderwidth.'px solid '.$bordercolor.'; }';
		$output .= '</style>';
	}
	
	$attachment_id = tpath_get_attachment_id_from_url($src);
	$full_image = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	$output .= '<div id="tpath-imgframe-overlay-'.$tpath_image_frame_overlay.'" class="tpath-imageframe-overlay'.$animation_class.$extra_class.'" '.$extra_data.'>';
	
	if( $overlay == 'yes' ) {
		$output .= '<div class="imageframe-overlay">';
	}

	$output .= '<img src="'.esc_url($src).'" alt="'.esc_attr($alt).'" class="'.$img_shape.'img-responsive" />';	
	
	if( $overlay == 'yes' ) {
		$output .= '<div class="imageframe-overlay-content overlay-'.$overlay_position.'">';
			$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';
	}
		
	$output .= '</div>';
	
	$tpath_image_frame_overlay++;
	
	return $output;
}
add_shortcode('tpath_imageframe_overlay', 'tpath_imageframe_overlay_shortcode');

/* =========================================================
 * Progress Bars Shortcode
 * ========================================================= */ 
function tpath_progress_bar_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'title' 		=> '',
				'percentage' 	=> '',
				'filledcolor' 	=> '',
				'unfilledcolor' => '',
				'animation' 	=> '',
			), $atts));
			
	$progress_class = $extra_style = $filled_style = '';
	
	if( $filledcolor != '' ) {
		$filled_style = ' style="background-color: '.$filledcolor.';"';
	}
	
	if( $unfilledcolor != '' ) {
		$extra_style = ' style="background-color: '.$unfilledcolor.';"';
	}
	
	if( $animation == 'yes' ) {
		$progress_class = " progress-striped active";
	}
	
	$output = '';
	
	$output .= '<div class="tpath-sc-progress-bar">';
		if( $title != '' ) {
			$output .= '<h6 class="progress-bar-title">'.$title.'</h6>';
		}
		$output .= '<div class="tpath-progress-bar progress'.$progress_class.'"'.$extra_style.'>';
			$output .= '<div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100"'.$filled_style.'>';
			$output .= '<span>'.do_shortcode($content).'</span>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;	
}
add_shortcode('tpath_progress_bar', 'tpath_progress_bar_shortcode');

/* =========================================================
 * Jumbotron Shortcode
 * ========================================================= */ 
function tpath_jumbotron_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'title' 				=> '',
				'show_button' 			=> 'no',
				'bg_image' 				=> '',
				'bg_repeat' 			=> 'no-repeat',
				'bg_color' 				=> '',
				'content_color'			=> '',
				'borderradius'			=> '',
				'button_text' 			=> '',
				'button_link' 			=> '',
				'target' 				=> '',
				'size' 					=> '',
				'button_bg_color'		=> '',
				'button_bg_hover_color'	=> '',
				'color' 				=> '',
				'hovercolor' 			=> '',
				'icon' 					=> '',
				'icon_pos' 				=> '',
				'animation_type'		=> '',
				'animation_delay'		=> '',
			), $atts));
			
	static $tpath_jumbo_button_id = 1;
	
	$animation_class = $extra_data = $color_styles = $hover_styles = $container_styles = $btn_sizes = $icon_left = $icon_right = $styles = '';
		
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $color != '' ) {		
		$color_styles = sprintf( 'color:%s;', $color );		
	}
	
	if( $hovercolor != '' ) {		
		$hover_styles = sprintf( 'color:%s;', $hovercolor );
	}
	
	if( $bg_image != '' ) {
		$container_styles .= sprintf( 'background-image:url(%s);', $bg_image );
	}
	
	if( $bg_image != '' && $bg_repeat != '' ) {
		$container_styles .= sprintf( 'background-repeat:%s;', $bg_repeat );
	}
	
	if( $bg_color != '' ) {
		$container_styles .= sprintf( 'background-color:%s;', $bg_color );
	}
	
	if( $content_color != '' ) {
		$container_styles .= sprintf( 'color:%s;', $content_color );
	}
	
	if( $borderradius != '' ) {
		$container_styles .= 'border-radius:'.$borderradius.'; -moz-border-radius: '.$borderradius.'; -webkit-border-radius: '.$borderradius.'; -o-border-radius: '.$borderradius.'; -ms-border-radius: '.$borderradius.';';
	}
	
	if( $button_bg_color != '' ) {
		$color_styles .= sprintf( 'background-color:%s;', $button_bg_color );
	}
	
	if( $button_bg_hover_color != '' ) {
		$hover_styles .= sprintf( 'background-color:%s;', $button_bg_hover_color );
	}
	
	if( $button_bg_color != '' || $color != '' || $bg_image != '' || $bg_color != '' ) {
		$styles .= '<style type="text/css">';
		if( $button_bg_color != '' || $color != '' ) {
			$styles .= sprintf( 'a.tpath-jumbo-button-%s{%s}', $tpath_jumbo_button_id, $color_styles );
			$styles .= sprintf( 'a.tpath-jumbo-button-%s:hover{%s}', $tpath_jumbo_button_id, $hover_styles );
		}
		
		if( $bg_image != '' || $bg_color != '' ) {
			$styles .= sprintf( '.jumbotron.tpath-jumbotron-%s{%s}', $tpath_jumbo_button_id, $container_styles );	
		}
		
		$styles .= '</style>';
	}
	
	if( $size ) {
		if( $size == 'large' ) $btn_sizes = 'btn-lg';
		if( $size == 'small' ) $btn_sizes = 'btn-sm';
		if( $size == 'mini' ) $btn_sizes = 'btn-xs';
	}
	
	if( $icon != '' && $icon_pos == "left" ) {
		$icon_left = '<i class="fa fa-'.$icon.'"></i> ';
	}
	
	elseif( $icon != '' && $icon_pos == "right" ) {
		$icon_right = ' <i class="fa fa-'.$icon.'"></i>';
	}
	
	$output = '';
	
	$output = $styles;	
	$output .= '<div class="tpath-jumbotron-'.$tpath_jumbo_button_id.' jumbotron'.$animation_class.'" '.$extra_data.'>';
	$output .= '<div class="container">';
    $output .= '<h1>'.$title.'</h1>';
	$output .= '<p>'.$content.'</p>';
	
	if( $show_button == 'yes' ) {
		$output .= '<p><a class="tpath-jumbo-button-'.$tpath_jumbo_button_id.' btn '.$btn_sizes.'" href="'.esc_url($button_link).'" target="'.$target.'">'. $icon_left . $button_text . $icon_right .'</a></p>';	
	}
	
	$output .= '</div>';
	$output .= '</div>';
	
	$tpath_jumbo_button_id++;

	return $output;	
}
add_shortcode('tpath_jumbotron', 'tpath_jumbotron_shortcode');

/* =========================================================
 * Modals Shortcode
 * ========================================================= */ 
function tpath_modals_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'title' 				=> '',
				'modal_size' 			=> '',
				'button_size' 			=> '',	
				'button_text' 			=> '',			
				'button_bg_color'		=> '',
				'button_bg_hover_color'	=> '',
				'color' 				=> '',
				'hovercolor' 			=> '',
				'icon' 					=> '',
				'icon_pos' 				=> '',
				'animation_type' 		=> '',
				'animation_delay' 		=> '',
			), $atts));
			
	static $tpath_modals_id = 1;
	
	$animation_class = $color_styles = $hover_styles = $styles = $btn_sizes = $modal_sizes = $icon_left = $icon_right = $extra_data = '';
		
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $color != '' ) {		
		$color_styles = sprintf( 'color:%s;', $color );		
	}
	
	if( $hovercolor != '' ) {		
		$hover_styles = sprintf( 'color:%s;', $hovercolor );
	}
		
	if( $button_bg_color != '' ) {
		$color_styles .= sprintf( 'background-color:%s;', $button_bg_color );
	}
	
	if( $button_bg_hover_color != '' ) {
		$hover_styles .= sprintf( 'background-color:%s;', $button_bg_hover_color );
	}
	
	if( $button_bg_color != '' || $color != '' ) {
		$styles .= '<style type="text/css">';		
		$styles .= sprintf( '.tpath-modal-button-%s{%s}', $tpath_modals_id, $color_styles );
		$styles .= sprintf( '.tpath-modal-button-%s:hover{%s}', $tpath_modals_id, $hover_styles );		
		$styles .= '</style>';
	}
	
	if( $button_size ) {
		if( $button_size == 'large' ) $btn_sizes = 'btn-lg';
		if( $button_size == 'small' ) $btn_sizes = 'btn-sm';
		if( $button_size == 'mini' ) $btn_sizes = 'btn-xs';
	}
	
	if( $modal_size ) {
		if( $modal_size == 'large' ) $modal_sizes = ' modal-lg';
		if( $modal_size == 'small' ) $modal_sizes = ' modal-sm';		
	}
	
	if( $icon != '' && $icon_pos == "left" ) {
		$icon_left = '<i class="fa fa-'.$icon.'"></i> ';
	}
	
	elseif( $icon != '' && $icon_pos == "right" ) {
		$icon_right = ' <i class="fa fa-'.$icon.'"></i>';
	}

	$script = '<script type="text/javascript">
	jQuery(document).ready(function($) {
	function centerModal() {
		$(this).css("display", "block");
		var dialog = $(this).find(".modal-dialog");
		var windowHeight = $(window).height();
		var dialogHeight = dialog.height();
		if( dialogHeight < windowHeight ) {
			var offset = (windowHeight - dialogHeight) / 2;
			dialog.css("margin-top", offset);
		}		
	}
	$(".tpath-modal-'.$tpath_modals_id.'").on("show.bs.modal", centerModal);
     $(window).on("resize", function () {
    	$(".tpath-modal-'.$tpath_modals_id.':visible").each(centerModal);
	 });
	});
	</script>';
	
	$output = '';
	
	$output = $styles;
	$output .= $script;
	$output .= '<div id="tpath-modal-'.$tpath_modals_id.'" class="tpath-modal tpath-modal-'.$tpath_modals_id.' modal fade" tabindex="-1" role="dialog" aria-hidden="true">';
	$output .= '<div class="modal-dialog'.$modal_sizes.'"><div class="modal-content">';
		$output .= '<div class="modal-header">';
		$output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		$output .= '<h4 class="modal-title">'.$title.'</h1>';
		$output .= '</div>';
		$output .= '<div class="modal-body">';
		$output .= do_shortcode($content);
		$output .= '</div>';
	$output .= '</div></div>';
	$output .= '</div>';
	$output .= '<button class="tpath-modal-button-'.$tpath_modals_id.' btn '.$btn_sizes.$animation_class.'" data-toggle="modal" data-target="#tpath-modal-'.$tpath_modals_id.'">'. $icon_left . $button_text . $icon_right .'</button>';
	
	$tpath_modals_id++;

	return do_shortcode($output);
}
add_shortcode('tpath_modals', 'tpath_modals_shortcode');

/* =========================================================
 * Content Boxes Shortcode
 * ========================================================= */ 
function tpath_contentboxes_shortcode( $atts, $content = null ) {	
	$output = '';
	$output = '<div class="row">';
	$output .= do_shortcode( str_replace('<br />', '', $content) );
	$output .= '</div>';
	return $output;
}
add_shortcode('tpath_contentboxes', 'tpath_contentboxes_shortcode');

function tpath_contentbox_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'layout' 			=> '',
				'title' 			=> '',
				'thumb_image' 		=> '',
				'full_image' 		=> '',
				'alt' 				=> '',				
				'link'				=> '',
				'link_text' 		=> '',
				'target' 			=> '',
				'column' 			=> '6',
				'animation_type' 	=> '',
				'animation_delay' 	=> '',
			), $atts));
			
	static $tpath_content_box_id = 1;
		
	$animation_class = $extra_data = '';
			
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = 'data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
	
	if( $link != '' && $link_text == '' ) {
		$link_text = "Read More";
	}
	
	$output = '';
	
	if( $layout == 'thumb-boxed' ) {
		$output = '<div id="tpath-content-box-'.$tpath_content_box_id.'" class="content-boxes col-sm-'.$column.' tpath-'.$layout.$animation_class.'" '.$extra_data.'>';
		$output .= '<div class="thumbnail">';
			if( $thumb_image != '' ) {			
				$output .= '<img class="tpath-only-thumb img-responsive" src="'.esc_url($thumb_image).'" alt="'.esc_attr($alt).'">';
			} elseif( $full_image != '' ) {
				$output .= '<img class="tpath-only-thumb img-responsive" src="'.esc_url($full_image).'" alt="'.esc_attr($alt).'">';
			}
			$output .= '<div class="col-md-12 tpath-show-overlay">';
				$output .= '<div class="tpath-content-mask">';					
					$output .= '<span class="tpath-img-view">';
					if( $full_image != '' ) {			
						$output .= '<a href="'.esc_url($full_image).'" rel="prettyPhoto" title="'.esc_attr($title).'"><i class="fa fa-search"></i></a>';
					} elseif( $thumb_image != '' ) {
						$output .= '<a href="'.esc_url($thumb_image).'" rel="prettyPhoto" title="'.esc_attr($title).'"><i class="fa fa-search"></i></a>';
					}
					$output .= '</span>';					
					if( $link != '' ) {
						$output .= '<span class="tpath-more-view">';
						$output .= '<a href="'.esc_url($link).'" title="'.esc_attr($title).'" target="'.$target.'"><i class="fa fa-link"></i></a>';
						$output .= '</span>';
					}					
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	} elseif( $layout == 'thumb-on-top' ) {
		$output = '<div id="tpath-content-box-'.$tpath_content_box_id.'" class="content-boxes col-sm-'.$column.' tpath-'.$layout.$animation_class.'" '.$extra_data.'>';
		$output .= '<div class="thumbnail">';
		if( $full_image != '' ) {
			$output .= '<a href="'.esc_url($full_image).'" rel="prettyPhoto" title="'.esc_attr($title).'">';
		}
		if( $thumb_image != '' ) {
			$output .= '<img class="tpath-thumb-img img-responsive" src="'.esc_url($thumb_image).'" alt="'.esc_attr($alt).'">';
		} elseif( $full_image != '' ) {
			$output .= '<img class="tpath-thumb-img img-responsive" src="'.esc_url($full_image).'" alt="'.esc_attr($alt).'">';
		}
		if( $full_image != '' ) {
			$output .= '</a>';
		}
		$output .= '<div class="caption">';
		$output .= '<h3 class="tpath-cntbox-bottom-title">'.$title.'</h3>';
		$output .= '<p>' .do_shortcode($content). '</p>';
		if( $link != '' ) {
			$output .= '<a href="'.esc_url($link).'" class="btn btn-readmore" target="'.$target.'" role="button">'.$link_text.'</a>';
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';	
	} elseif( $layout == 'thumb-on-bottom' ) {
		$output = '<div id="tpath-content-box-'.$tpath_content_box_id.'" class="content-boxes col-sm-'.$column.' tpath-'.$layout.$animation_class.'" '.$extra_data.'>';
		$output .= '<div class="thumbnail">';
		$output .= '<div class="caption">';
		$output .= '<h3 class="tpath-cntbox-top-title">'.$title.'</h3>';
		$output .= '</div>';
		$output .= '<a href="'.esc_url($full_image).'" rel="prettyPhoto" title="'.esc_attr($title).'">';
		if( $thumb_image != '' ) {
			$output .= '<img class="tpath-thumb-img" src="'.esc_url($thumb_image).'" alt="'.esc_attr($alt).'">';
		} elseif( $full_image != '' ) {
			$output .= '<img class="tpath-thumb-img" src="'.esc_url($full_image).'" alt="'.esc_attr($alt).'">';
		}
		$output .= '</a>';
		$output .= '<div class="caption">';
		$output .= '<p>'.do_shortcode($content).'</p>';
		if( $link != '' ) {
			$output .= '<a href="'.esc_url($link).'" class="btn btn-readmore" target="'.$target.'" role="button">'.$link_text.'</a>';
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	} elseif( $layout == 'thumb-overlay' ) {
		$output = '<div id="tpath-content-box-'.$tpath_content_box_id.'" class="content-boxes col-sm-'.$column.' tpath-'.$layout.$animation_class.'" '.$extra_data.'>';
		$output .= '<div class="thumbnail">';
			if( $thumb_image != '' ) {
				$output .= '<img class="tpath-thumb-overlay-img" src="'.esc_url($thumb_image).'" alt="'.esc_attr($alt).'">';
			} elseif( $full_image != '' ) {
				$output .= '<img class="tpath-thumb-overlay-img" src="'.esc_url($full_image).'" alt="'.esc_attr($alt).'">';
			}
			$output .= '<div class="col-md-12 tpath-show-overlay">';
			$output .= '<div class="tpath-content-mask">';
				$output .= '<h3 class="tpath-cntbox-overlay-title">'.$title.'</h3>';
				$output .= '<div class="caption">';
				$output .= '<p>'.do_shortcode($content).'</p>';
				if( $link != '' ) {
					$output .= '<a href="'.esc_url($link).'" class="btn btn-readmore" target="'.$target.'" role="button">'.$link_text.'</a>';
				}
				$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}
	
	$tpath_content_box_id++;

	return $output;	
}
add_shortcode('tpath_contentbox', 'tpath_contentbox_shortcode');

/* =========================================================
 * Accordion Shortcode
 * ========================================================= */
function tpath_accordions_shortcode( $atts, $content = null ) {
	$output = '';
	$output .= '<div class="panel-group tpath-accordion" id="accordion">';
	$output .= do_shortcode( str_replace('<br />', '', $content) );
	$output .= '</div>';

   return $output;
}
add_shortcode('tpath_accordions', 'tpath_accordions_shortcode');

function tpath_accordion_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(				
				'title' 	=> '',
				'open' 		=> 'no',							
			), $atts));
			
	static $tpath_accordion_item_id = 1;
	
	$active_class = $extra_class = '';

	if( $open == 'yes' ){
		$active_class = ' in';
		$extra_class = '';
	} else if( $open == 'no' ) {
		$extra_class = 'collapsed';
	}
	
	$output = '';
	
	$output .= '<div class="tpath-accordion-panel panel panel-default">';
	$output .= '<div class="panel-heading">';
		$output .= '<h4 class="panel-title">';
		$output .= '<a class="'.$extra_class.'" data-toggle="collapse" data-parent="#accordion" href="#tpath-accordion-'.$tpath_accordion_item_id.'">';
		$output .= $title;
		$output .= '</a>';
		$output .= '</h4>';
	$output .= '</div>';
	$output .= '<div id="tpath-accordion-'.$tpath_accordion_item_id.'" class="panel-collapse collapse'.$active_class.'">';
		$output .= '<div class="panel-body">';
		$output .= '<p>'.do_shortcode($content).'</p>';
		$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	
	$tpath_accordion_item_id++;
	
	return $output;
}
add_shortcode('tpath_accordion', 'tpath_accordion_shortcode');

/* =========================================================
 * Tooltip Shortcode
 * ========================================================= */
function tpath_tooltip_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(				
				'title' 	=> '',
				'position' 	=> 'top',
			), $atts));
	
	$output = '';
	
	$output .= '<span class="tpath-tooltip" data-toggle="tooltip" data-placement="'.$position.'" title="'.$title.'">';
	$output .= do_shortcode($content);	
	$output .= '</span>';
	
	return $output;
}
add_shortcode('tpath_tooltip', 'tpath_tooltip_shortcode');

/* =========================================================
 * Lead Paragraph Shortcode
 * ========================================================= */
function tpath_leadpara_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(				
				'align' 	=> '',				
			), $atts));
			
	if( $align != '' ) {
		$text_align = ' text-'.$align.'';
	}
	
	$output = '';	
	$output .= '<p class="lead'.$text_align.'">'.do_shortcode($content).'</p>';
	
	return $output;
}
add_shortcode('tpath_leadpara', 'tpath_leadpara_shortcode');

/* =========================================================
 * Popover Shortcode
 * ========================================================= */
function tpath_popover_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(				
				'title' 				=> '',
				'popover_pos' 			=> 'top',
				'link_type' 			=> 'button',
				'show_on' 				=> 'click',
				'link_text' 			=> '',
				'link_url' 				=> '',
				'target' 				=> '',
				'size' 					=> '',
				'button_bg_color' 		=> '',
				'button_bg_hover_color' => '',
				'color' 				=> '',
				'hovercolor' 			=> '',
				'icon' 					=> '',
				'icon_pos' 				=> '',				
			), $atts));
			
	static $tpath_popover_id = 1;
	
	$color_styles = $hover_styles = $styles = $btn_sizes = $icon_left = $icon_right = '';	
	
	$output = '';
	
	if( $link_type == "button" ) {
	
		if( $color != '' ) {		
			$color_styles = sprintf( 'color:%s;', $color );		
		}
		
		if( $hovercolor != '' ) {		
			$hover_styles = sprintf( 'color:%s;', $hovercolor );
		}
			
		if( $button_bg_color != '' ) {
			$color_styles .= sprintf( 'background-color:%s;', $button_bg_color );
		}
		
		if( $button_bg_hover_color != '' ) {
			$hover_styles .= sprintf( 'background-color:%s;', $button_bg_hover_color );
		}
		
		if( $button_bg_color != '' || $color != '' ) {
			$styles .= '<style type="text/css">';		
			$styles .= sprintf( '.tpath-popover-button-%s{%s}', $tpath_popover_id, $color_styles );
			$styles .= sprintf( '.tpath-popover-button-%s:hover{%s}', $tpath_popover_id, $hover_styles );		
			$styles .= '</style>';
		}
	
		if( $size ) {
			if( $size == 'large' ) $btn_sizes = 'btn-lg';
			if( $size == 'small' ) $btn_sizes = 'btn-sm';
			if( $size == 'mini' ) $btn_sizes = 'btn-xs';
		}
			
		if( $icon != '' && $icon_pos == "left" ) {
			$icon_left = '<i class="fa fa-'.$icon.'"></i> ';
		}
		
		elseif( $icon != '' && $icon_pos == "right" ) {
			$icon_right = ' <i class="fa fa-'.$icon.'"></i>';
		}
		
		$output = $styles . '<button type="button" class="tpath-popover tpath-popover-button-'.$tpath_popover_id.' btn '.$btn_sizes.'" title="'.esc_attr($title).'" data-container="body" data-toggle="popover" data-placement="'.$popover_pos.'" data-trigger="'.$show_on.'" data-html="true" data-content="'.do_shortcode($content).'">'.$link_text.'</button>';
		
	} elseif( $link_type == "link" ) {
	
		$output = '<a href="'.esc_url($link_url).'" class="tpath-popover tpath-popover-link-'.$tpath_popover_id.'" target="'.$target.'" title="'.esc_attr($title).'" data-container="body" data-toggle="popover" data-placement="'.$popover_pos.'" data-trigger="hover" data-html="true" data-content="'.do_shortcode($content).'">'.$link_text.'</a>';
	
	}
	
	$tpath_popover_id++;
	
	return $output;
}
add_shortcode('tpath_popover', 'tpath_popover_shortcode');

/* =========================================================
 * Tabs Shortcode
 * ========================================================= */
function tpath_tabs_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'layout' 			=> '',
				'activecolor' 		=> '',
				'inactivecolor' 	=> '',
			), $atts));
	
	static $tpath_tabs_id = 1;
	static $tpath_tab_id = 1;
	
	$color_active_styles = $color_inactive_styles = $styles = $style_tag = $icon_tag = '';
	
	$preg_matches = preg_match_all( '/tpath_tab title="([^\"]+)" icon="([^\"]*)" color="([^\"]*)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	
	$tab_titles = array();	
	$new_tabs = array();
	
	if( isset($matches[1]) ) {
		$tab_titles = $matches[1];
		$tab_icons	= $matches[2];
		$color_codes = $matches[3];		
	
		if( isset($tab_icons) ) {
			foreach( $tab_icons as $key => $tabs_list ) {
				$tab_icons_incl[] = array_merge((array)$tab_titles[$key], (array)$tabs_list);
			}
		} else {
			$new_tabs[] = $tab_titles;
		}
		
		if( isset($color_codes) ) {
			if( isset($tab_icons_incl) ) {
				foreach( $color_codes as $key => $tabs_color ) {
					$new_tabs[] = array_merge((array)$tab_icons_incl[$key], (array)$tabs_color);
				}
			} else {
				foreach( $color_codes as $key => $tabs_color ) {
					$new_tabs[] = array_merge((array)$tab_titles[$key], (array)$tabs_color);
				}
			}
		} elseif( !isset($color_codes) && isset($tab_icons_incl) ) {
			$new_tabs[] = $tab_icons_incl;
		} else {
			$new_tabs[] = $tab_titles;
		}
				
	}
	
	if( $activecolor != '' ) {
		$color_active_styles = sprintf( 'background-color:%s;', $activecolor );
	}
	
	if( $inactivecolor != '' ) {
		$color_inactive_styles = sprintf( 'background-color:%s;', $inactivecolor );
	}
	
	if( $activecolor != '' || $inactivecolor != '' ) {
		$styles .= '<style type="text/css">';		
		$styles .= sprintf( '#tpath-tabs-%s .nav-tabs li.active a{%s}', $tpath_tabs_id, $color_active_styles );
		$styles .= sprintf( '#tpath-tabs-%s .nav-tabs li a{%s}', $tpath_tabs_id, $color_inactive_styles );		
		$styles .= '</style>';
	}
	
	$output = '';
	
	$output .= $styles;
	
	$output .= '<script type="text/javascript">';
	$output .= 'jQuery(document).ready(function($){	
	$("#tpath-tabs-'.$tpath_tabs_id.'").find("ul.nav li:first").addClass("active");
	$("#tpath-tabs-'.$tpath_tabs_id.'").find(".tab-content .tab-pane:first").addClass("in active");
	});';
	$output .= '</script>';
	
	if( $layout == 'horizontal' ) {
	
		if( count($tab_titles) ){
			$output .= '<div id="tpath-tabs-'.$tpath_tabs_id.'" class="tpath-tabs">';
			$output .= '<ul class="nav nav-tabs">';
			
			foreach( $new_tabs as $tab ) {			
				
				if( $tab[2] != '' ) {
					$icon_tag = '<i class="fa fa-'.$tab[2].'"></i> ';
				}
				
				if( $tab[4] != '' ) {
					$style_tag = ' style="color: '.$tab[4].';"';
				}
				$output .= '<li class="tpath-tab-'.$tpath_tab_id.'"><a href="#tpath-tab-'. sanitize_title( $tab[0] ) .'" data-toggle="tab"'.$style_tag.'>' . $icon_tag . $tab[0] . '</a></li>';
				
				$tpath_tab_id++;
			}
			
			$output .= '</ul>';
			$output .= '<div class="tab-content">';
			$output .= do_shortcode( str_replace('<br />', '', $content) );
			$output .= '</div>';
			$output .= '</div>';
		} else {
			$output .= do_shortcode( str_replace('<br />', '', $content) );
		}
		
	} elseif( $layout == 'vertical-left' ) {
		
		if( count($tab_titles) ){
			$output .= '<div id="tpath-tabs-'.$tpath_tabs_id.'" class="tpath-tabs tpath-left-vertical">';
			$output .= '<div class="col-xs-3">';
				$output .= '<ul class="nav tabs-left nav-tabs">';
				
				foreach( $new_tabs as $tab ) {
					if( $tab[2] != '' ) {
						$icon_tag = '<i class="fa fa-'.$tab[2].'"></i> ';
					}
					
					if( $tab[4] != '' ) {
						$style_tag = ' style="color: '.$tab[4].';"';
					}
				
					$output .= '<li class="tpath-tab-'.$tpath_tab_id.'"><a href="#tpath-tab-'. sanitize_title( $tab[0] ) .'" data-toggle="tab"'.$style_tag.'>' . $icon_tag . $tab[0] . '</a></li>';
					
					$tpath_tab_id++;
				}
				
				$output .= '</ul>';
			$output .= '</div>';
			$output .= '<div class="col-xs-9">';
				$output .= '<div class="tab-content">';
				$output .= do_shortcode( str_replace('<br />', '', $content) );
				$output .= '</div>';
			$output .= '</div>';
			$output .= '<div class="clearfix"></div>';
			$output .= '</div>';
		} else {
			$output .= do_shortcode( str_replace('<br />', '', $content) );
		}
	
	} elseif( $layout == 'vertical-right' ) {
		
		if( count($tab_titles) ){
			$output .= '<div id="tpath-tabs-'.$tpath_tabs_id.'" class="tpath-tabs tpath-right-vertical">';
			$output .= '<div class="col-xs-9">';
				$output .= '<div class="tab-content">';
				$output .= do_shortcode( str_replace('<br />', '', $content) );
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="col-xs-3">';
				$output .= '<ul class="nav nav-tabs tabs-right">';
				
				foreach( $new_tabs as $tab ) {
					if( $tab[2] != '' ) {
						$icon_tag = '<i class="fa fa-'.$tab[2].'"></i> ';
					}
					
					if( $tab[4] != '' ) {
						$style_tag = ' style="color: '.$tab[4].';"';
					}
					
					$output .= '<li class="tpath-tab-'.$tpath_tab_id.'"><a href="#tpath-tab-'. sanitize_title( $tab[0] ) .'" data-toggle="tab"'.$style_tag.'>' . $icon_tag . $tab[0] . '</a></li>';
					
					$tpath_tab_id++;
				}
				
				$output .= '</ul>';
			$output .= '</div>';			
			$output .= '<div class="clearfix"></div>';
			$output .= '</div>';
		} else {
			$output .= do_shortcode( str_replace('<br />', '', $content) );
		}
	
	}
	
	$tpath_tabs_id++;
	
	return $output;
}
add_shortcode('tpath_tabs', 'tpath_tabs_shortcode');

function tpath_tab_shortcode( $atts, $content = null ) {
	$atts = extract(shortcode_atts(
			array(
				'title' 	=> '',
				'icon' 		=> '',
				'color' 	=> '',
			), $atts));
			
	$output = '';
	
	$output .= '<div class="tab-pane fade" id="tpath-tab-'.sanitize_title( $title ).'">';
	$output .= '<p>' . do_shortcode( str_replace('<br />', '', $content) ) . '</p>';
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'tpath_tab', 'tpath_tab_shortcode' );

/* =========================================================
 * Soundcloud Shortcode
 * ========================================================= */ 
function tpath_soundcloud_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'url' 			=> '',
				'comments' 		=> '',
				'autoplay' 		=> '',
				'buy_like' 		=> '',
				'show_artwork' 	=> '',
				'color' 		=> '',				
				'width' 		=> '100%',
				'height' 		=> 81,
			), $atts));

		if( $comments == 'yes' ) {
			$comments = 'true';
		} elseif( $comments == 'no' ) {
			$comments = 'false';
		}

		if( $autoplay == 'yes' ) {
			$autoplay = 'true';
		} elseif( $autoplay == 'no' ) {
			$autoplay = 'false';
		}
		
		if( $buy_like == 'yes' ) {
			$buy_like = 'true';
		} elseif( $buy_like == 'no' ) {
			$buy_like = 'false';
		}
		
		if( $show_artwork == 'yes' ) {
			$show_artwork = 'true';
		} elseif( $show_artwork == 'no' ) {
			$show_artwork = 'false';
		}

		if( $color != '' ) {
			$color = str_replace('#', '', $color);
		}

		return '<div class="soundcloud-shortcode"><iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . urlencode($url) . '&amp;show_comments=' . $comments . '&amp;auto_play=' . $autoplay . '&amp;color=' . $color . '&amp;buying=' . $buy_like . '&amp;liking=' . $buy_like . '&amp;show_artwork=' . $show_artwork . '"></iframe></div>';
		
}

add_shortcode('tpath_soundcloud', 'tpath_soundcloud_shortcode');

/* =========================================================
 * Vimeo Shortcode
 * ========================================================= */
function tpath_vimeo_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'id' 			=> '',				
				'autoplay' 		=> '',				
				'color' 		=> '',				
				'width' 		=> 700,
				'height' 		=> 350,
				'show_title' 	=> '',
				'show_byline' 	=> '',
			), $atts));
			

		if( $autoplay == 'yes' ) {
			$autoplay = '1';
		} elseif( $autoplay == 'no' ) {
			$autoplay = '0';
		}
		
		if( $show_title == 'yes' ) {
			$show_title = '1';
		} elseif( $show_title == 'no' ) {
			$show_title = '0';
		}
		
		if( $show_byline == 'yes' ) {
			$show_byline = '1';
		} elseif( $show_byline == 'no' ) {
			$show_byline = '0';
		}

		if( $color != '' ) {
			$color = str_replace('#', '', $color);
		}
		
		$protocol = (is_ssl())? 's' : '';
		
		return '<div class="vimeo-shortcode"><div class="vimeo-inner" style="max-width:'.$width.'px; max-height:'.$height.'px;"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" src="http'.$protocol.'://player.vimeo.com/video/' . $id . '?autoplay=' . $autoplay . '&amp;color=' . $color . '&amp;title=' . $show_title . '&amp;byline=' . $show_byline . '"></iframe></div></div>';
		
}

add_shortcode('tpath_vimeo', 'tpath_vimeo_shortcode');

/* =========================================================
 * Youtube Shortcode
 * ========================================================= */ 
function tpath_youtube_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'id' 			=> '',				
				'autoplay' 		=> '',				
				'rel_video' 	=> '',				
				'width' 		=> 700,
				'height' 		=> 350				
			), $atts));
			

		if( $autoplay == 'yes' ) {
			$autoplay = '1';
		} elseif( $autoplay == 'no' ) {
			$autoplay = '0';
		}
		
		if( $rel_video == 'yes' ) {
			$rel_video = '1';
		} elseif( $rel_video == 'no' ) {
			$rel_video = '0';
		}		
		
		return '<div class="youtube-shortcode"><div class="youtube-inner" style="max-width:'.$width.'px; max-height:'.$height.'px;"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" src="http://www.youtube.com/embed/' . $id . '?autoplay=' . $autoplay . 'amp;rel=' . $rel_video . '"></iframe></div></div>';
		
}

add_shortcode('tpath_youtube', 'tpath_youtube_shortcode');

/* =========================================================
 * Pricing Table Shortcode
 * ========================================================= */ 
function tpath_pricing_table_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'id' 		=> '',
			), $atts));
			
	global $post;
	
	$column_count = get_post_meta( $id, 'tpath_pricing_column_count', true );
	
	if( $column_count == 1 ) $pricing_col = "col-md-12 col-xs-12";
	if( $column_count == 2 ) $pricing_col = "col-md-6 col-sm-6";
	if( $column_count == 3 ) $pricing_col = "col-md-4 col-sm-4";
	if( $column_count >= 4 ) $pricing_col = "col-md-3 col-sm-6";
	
	$output = '';
	
	$tpath_pricing = get_post_meta( $id, 'tpathpricing_tb', true );
	
	$tpath_val = array();
		
	if( $tpath_pricing ) {
		foreach( $tpath_pricing as $i => $fields ) {			
			$tpath_val[] = $fields;			
		}
	}
	
	$i = 0;
	
	if( $column_count >= 1 ) {
		//$output .= '<div class="row tpath-pricing">';
		for( $col=1; $col<=$column_count; $col++ ) {
		
			if( $col == 5 ) {
				$output .= '<div class="clear"></div>';
			}		
			
			$output .= '<div id="tpath-pricing-table'.$col.'" class="'.$pricing_col.' pricing-item'.$col.'">';
			
			$title_color = $price_color = $currency_color = $pricing_head = $pricing_details = '';
			
			if( $tpath_val[$i]['title_color'] != '' ) {
				$title_color .= sprintf( 'color:%s;', $tpath_val[$i]['title_color'] );				
			}
			
			if( $tpath_val[$i]['bg_color'] != '' ) {
				$pricing_details .= sprintf( 'background-color:%s;', $tpath_val[$i]['bg_color'] );				
			}
			
			if( $tpath_val[$i]['price_bg_color'] != '' ) {
				$pricing_head .= sprintf( 'background-color:%s;', $tpath_val[$i]['price_bg_color'] );				
			}
			
			if( $tpath_val[$i]['price_color'] != '' ) {
				$price_color .= sprintf( 'color:%s;', $tpath_val[$i]['price_color'] );				
			}
			
			if( $tpath_val[$i]['currency_color'] != '' ) {
				$currency_color .= sprintf( 'color:%s;', $tpath_val[$i]['currency_color'] );				
			}
			
			if( $tpath_val[$i]['text_color'] != '' ) {
				$pricing_details .= sprintf( 'color:%s;', $tpath_val[$i]['text_color'] );				
			}			
			
			if( $tpath_val[$i]['border_color'] != '' && $tpath_val[$i]['border_width'] != '' ) {
				$pricing_details .= sprintf( 'border:%s solid %s;', $tpath_val[$i]['border_width'], $tpath_val[$i]['border_color'] );
			} elseif( $tpath_val[$i]['border_color'] != '' ) {
				$pricing_details .= sprintf( 'border-color: %s;', $tpath_val[$i]['border_color'] );
			} elseif( $tpath_val[$i]['border_width'] != '' ) {
				$pricing_details .= sprintf( 'border-width: %s;', $tpath_val[$i]['border_width'] );
			}
			
			if( $tpath_val[$i]['border_radius'] != '' ) {		
				
				$pricing_details .= sprintf( 'border-radius: 0 0 %s %s;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_details .= sprintf( '-moz-border-radius: 0 0 %s %s;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_details .= sprintf( '-webkit-border-radius: 0 0 %s %s;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_details .= sprintf( '-ms-border-radius: 0 0 %s %s;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_details .= sprintf( '-o-border-radius: 0 0 %s %s;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				
				$pricing_head .= sprintf( 'border-radius: %s %s 0 0;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_head .= sprintf( '-moz-border-radius: %s %s 0 0;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );				
				$pricing_head .= sprintf( '-webkit-border-radius: %s %s 0 0;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );				
				$pricing_head .= sprintf( '-ms-border-radius: %s %s 0 0;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
				$pricing_head .= sprintf( '-o-border-radius: %s %s 0 0;', $tpath_val[$i]['border_radius'], $tpath_val[$i]['border_radius'] );
			}
			
			$styles = '';
			
			if( $pricing_details != '' || $pricing_head != '' || $title_color != '' || $price_color != '' || $currency_color != '' ) {
				$styles .= '<style type="text/css">';				
				
				if( $pricing_head != '' ) {
					$styles .= sprintf( '#tpath-pricing-table #pricing-plan-%s .pricing-head {%s}', $col, $pricing_head ) . "\n";
				}
				if( $title_color != '' ) {
					$styles .= sprintf( '#tpath-pricing-table #pricing-plan-%s .pricing-head .pricing-title {%s}', $col, $title_color ) . "\n";
				}
				if( $price_color != '' ) {
					$styles .= sprintf( '#tpath-pricing-table #pricing-plan-%s .pricing-head .tpath-price-item h6 {%s}', $col, $price_color ) . "\n";
				}
				if( $currency_color != '' ) {
					$styles .= sprintf( '#tpath-pricing-table #pricing-plan-%s .pricing-head .tpath-price-item span {%s}', $col, $currency_color ) . "\n";
				}
				if( $pricing_details != '' ) {
					$styles .= sprintf( '#tpath-pricing-table #pricing-plan-%s.pricing-plan-list .pricing-details {%s}', $col, $pricing_details ) . "\n";
				}
				
				$styles .= '</style>';
			}	
						
			$output .= '<div id="pricing-plan-'.$col.'" class="pricing-plan-list pricing-box">';
			
			$output .= $styles;			
			
			$output .= '<div class="pricing-head">';
			$output .= '<h5 class="pricing-title">'.$tpath_val[$i]['title'].'</h5>';			
			
			$currency = '';
			if( $tpath_val[$i]['currency'] != '0' ) {
				$currency = $tpath_val[$i]['currency'];
			}
			
			switch ( $currency ) {				
				case 'AUD' :
				case 'CAD' :
				case 'CLP' :
				case 'MXN' :
				case 'NZD' :
				case 'HKD' :
				case 'SGD' :
				case 'USD' :
					$currency_symbol = '&#36;';
					break;
				case 'EUR' :
					$currency_symbol = '&euro;';
					break;
				case 'CNY' :
				case 'RMB' :
				case 'JPY' :
					$currency_symbol = '&yen;';
					break;
				case 'RUB' :
					$currency_symbol = '&#1088;&#1091;&#1073;.';
					break;
				case 'KRW' : $currency_symbol = '&#8361;'; break;
				case 'TRY' : $currency_symbol = '&#84;&#76;'; break;
				case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
				case 'ZAR' : $currency_symbol = '&#82;'; break;
				case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
				case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
				case 'DKK' : $currency_symbol = '&#107;&#114;'; break;
				case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
				case 'IDR' : $currency_symbol = 'Rp'; break;
				case 'INR' : $currency_symbol = 'Rs.'; break;
				case 'ISK' : $currency_symbol = 'Kr.'; break;
				case 'ILS' : $currency_symbol = '&#8362;'; break;
				case 'PHP' : $currency_symbol = '&#8369;'; break;
				case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
				case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
				case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
				case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
				case 'THB' : $currency_symbol = '&#3647;'; break;
				case 'GBP' : $currency_symbol = '&pound;'; break;
				case 'RON' : $currency_symbol = 'lei'; break;
				case 'VND' : $currency_symbol = '&#8363;'; break;
				case 'NGN' : $currency_symbol = '&#8358;'; break;
				case 'HRK' : $currency_symbol = 'Kn'; break;
				default    : $currency_symbol = ''; break;
			}
			
			if( $tpath_val[$i]['price'] != '' ) {
				$extra_content = '';
				if( $tpath_val[$i]['month_year'] != '' ) {
					$extra_content = '<span class="pricing-duration">'.$tpath_val[$i]['month_year'].'</span>';
				}				
				$output .= '<div class="tpath-price-item text-center">';				
				$output .= '<h6><span class="currency-symbol">'.$currency_symbol.'</span>'. $tpath_val[$i]['price'] . $extra_content .'</h6>';
				$output .= '</div>';				
			}
			
			$output .= '</div>';
			
			$output .= '<div class="pricing-details">';
			
			$repeatable_fields = $tpath_val[$i]['features'];
			if( $repeatable_fields ) {
				$rf = 1;
				$output .= '<ul class="tpath-features-list list-unstyled">';
				foreach( $repeatable_fields as $row => $re_fields ) {					
					$output .= '<li class="item-features features-'.$rf.'">'.do_shortcode($re_fields).'</li>';
					$rf++;				
				}
				$output .= '</ul>';
			}
			
			if( $tpath_val[$i]['button_text'] != '' && $tpath_val[$i]['button_link'] != '' ) {
				$target_type = '';
				if( $tpath_val[$i]['button_target'] == 1 ) {
					$target_type = '_blank';
				} else {
					$target_type = '_self';
				}
				
				$pricing_btn_sizes = '';
				
				if( $tpath_val[$i]['button_size'] != '0' ) {
					if( $tpath_val[$i]['button_size'] == 'large' ) { $pricing_btn_sizes = ' btn-lg'; }
					if( $tpath_val[$i]['button_size'] == 'small' ) { $pricing_btn_sizes = ' btn-sm'; }
					if( $tpath_val[$i]['button_size'] == 'medium' ) { $pricing_btn_sizes = ''; }
				}
				
				$pricing_btn_styles = '';
				
				if( $tpath_val[$i]['button_style'] != '0' ) {
					$pricing_btn_styles = ' btn-'.$tpath_val[$i]['button_style'].'';					
				}
				
				$output .= '<div class="tpath-pricing-btn-item text-center"><a class="tpath-pricing-button btn btn-primary'.$pricing_btn_sizes.$pricing_btn_styles.'" href="'.esc_url($tpath_val[$i]['button_link']).'" target="'.$target_type.'">'.$tpath_val[$i]['button_text'].'</a></div>';
			}
			
			$output .= '</div>';
			
			$output .= '</div>';
			$output .= '</div>';
			
			$i++;
			
		}
		//$output .= '</div>';
	}
	
	return $output;
}

add_shortcode('tpath_pricing_table', 'tpath_pricing_table_shortcode');

/* =========================================================
 * Pricing Icon Shortcode
 * ========================================================= */ 
function tpath_pricing_icon_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'type' 	=> 'yes',
				'color' => '#000000'
			), $atts));
		

		if( $type == 'yes' ) {
			$type = 'check';
		} elseif( $type == 'no' ) {
			$type = 'times';
		}
		
		return '<i class="fa fa-'.$type.'" style="color: '.$color.'"></i> ';

}

add_shortcode('tpath_pricing_icon', 'tpath_pricing_icon_shortcode');

/* =========================================================
 * Portfolio Gallery Shortcode
 * ========================================================= */ 
function tpath_portfolio_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'category' 	=> '',
				'filters' 	=> '',
				'filter_by' => '',
				'columns' 	=> '',
				'gutter' 	=> '',
				'style' 	=> ''
			), $atts));
	
		$category_ids = explode(',', $category);
		
		static $tpath_portfolio_id = 1;
		
		$output = '';		
		global $post;
		
		if( !empty($category_ids) ) {
	
			if( $category_ids[0] == 0 ) {
				unset($category_ids[0]);
			}
			
			$args = array(
						'post_type' 		=> 'tpath_portfolio',
						'posts_per_page'	=> -1,
						'orderby' 			=> 'menu_order',
						'order' 			=> 'ASC',
					);
			
			if( !empty($category_ids) ){				
				$args['tax_query'] = array(	array(
										'taxonomy' 	=> 'portfolio_categories',
										'field' 	=> 'id',
										'terms' 	=> $category_ids
									));
			}
			
			$portfolio_query = new WP_Query($args);
											
			if ( $portfolio_query->have_posts() ) {
				$portfolio_tags = get_terms('portfolio_'.$filter_by.'');
				$output = '<div id="tpath_portfolio_'.$tpath_portfolio_id.'" class="tpath-portfolio" data-columns="'.$columns.'" data-gutter="'.$gutter.'">';
				$output .= '<div id="portfolio-loading-'.$tpath_portfolio_id.'" class="portfolio-loading">Loading...</div><div id="portfolio-frame-'.$tpath_portfolio_id.'" class="portfolio-frame"> </div>';
				
				if( is_array($portfolio_tags) && !empty($portfolio_tags) && $filters != 'hide' ) {
					$output .= '<ul class="portfolio-tabs list-inline">';
					$output .= '<li><a class="active" data-filter="*" href="#">'.__('All', 'TemplateCore').'</a></li>';
					foreach( $portfolio_tags as $tags ) {
						$output .= '<li><a data-filter=".'.$tags->slug.'" href="#">'.$tags->name.'</a></li>';
					}
					$output .= '</ul>';
				}
				$output .= '<div class="portfolio-inner">';
				
				while($portfolio_query->have_posts()) : $portfolio_query->the_post();
				
					$portfolio_full_img = '';
					if( $style == "original" ) {
						$portfolio_full_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
					} elseif( $style == "square" ) {
						$portfolio_full_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio-square');
					}
					
					$item_classes = '';
					$item_tags = get_the_terms($post->ID, 'portfolio_'.$filter_by.'');
					if( $item_tags ) {
						foreach( $item_tags as $item_tag ) {
							$item_classes .= urldecode($item_tag->slug) . ' ';
						}
					}
					
					$output .= '<div id="portfolio-'.get_the_ID().'" class="portfolio-item '.$item_classes.'">';
					$output .= '<div class="portfolio-content">';					
					$output .= '<img class="img-responsive" src="'.$portfolio_full_img[0].'" alt="'.get_the_title().'" />';
						$output .= '<div class="portfolio-overlay">';
							$output .= '<div class="portfolio-mask">';
							
							$portfolio_large = ''; 
							$portfolio_large = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
							
							$output .= '<a href="'.esc_url($portfolio_large[0]).'" rel="prettyPhoto[gallery-'.$tpath_portfolio_id.']" title="'.get_the_title().'"><i class="fa fa-search"></i></a>';
							$output .= '<div class="portfolio-link"><i class="fa fa-link"></i></div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';

				endwhile;
			
				$output .= '</div>';
				
				$output .= '</div>';
			} 
			
		}
		
		wp_reset_postdata();
		
		$tpath_portfolio_id++;
	
		return $output;
}

add_shortcode('tpath_portfolio', 'tpath_portfolio_shortcode');

/* =========================================================
 * Testimonials Shortcode
 * ========================================================= */ 
function tpath_testimonials_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'category' 			=> '',
				'show_navigation' 	=> '',				
				'style' 			=> ''
			), $atts));
		
		$output = '';
		global $post;
		
		if( $category != '0' && $category != '' ) {
			
			$testimonial_query = new WP_Query(array('post_type'  => 'tpath_testimonial',
													'posts_per_page' => -1,
													'orderby' 		 => 'menu_order',
													'order' 		 => 'ASC',
													'tax_query' 	 => array(
																		   array(
																			'taxonomy' => 'testimonial_categories',
																			'field' => 'id',
																			'terms' => $category
																		) )));
											
			if ( $testimonial_query->have_posts() ) {
				if( $style == "slider" ) {
					$output = '<div id="tpath_testimonial_'.$category.'" class="tpath-testimonial testimonial-'.$style.'-section carousel slide" data-ride="carousel">';
				} elseif( $style == "list" ) {
					$output = '<div id="tpath_testimonial_'.$category.'" class="tpath-testimonial-list">';
				}
				
				if( $show_navigation == "yes" ) {
					$output .= '<div class="tpath-carousel-indicators container">';
						$output .= '<a class="tpath-carousel-slide-left" href="#tpath_testimonial_'.$category.'" data-slide="prev">';
						$output .= '<i class="fa fa-chevron-left"></i>';
						$output .= '</a>';
						$output .= '<a class="tpath-carousel-slide-right" href="#tpath_testimonial_'.$category.'" data-slide="next">';
						$output .= '<i class="fa fa-chevron-right"></i>';
						$output .= '</a>';
					$output .= '</div>';
				}
				
				if( $style == "slider" ) {
					$output .= '<div class="carousel-inner">';
					$img_class = "";
				} elseif( $style == "list" ) {
					$output .= '<div class="testimonial-list">';
					$img_class = "img-rounded";
				}				
								
				while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
				
					$testi_img = $author_company = $author_company_url = '';
					
					$testi_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');					
					$author_company = get_post_meta( $post->ID, 'tpath_author_company_name', true );
					$author_company_url = get_post_meta( $post->ID, 'tpath_author_company_url', true );
					
					if( $style == "slider" ) {
					
						$output .= '<div class="item container">';				
						$output .= '<div class="row item-grid">';
						
							$output .= '<div class="col-lg-3 col-md-3 testimonial-image">';
								$output .= '<div class="main-testimonial-image">';
									$output .= '<img class="img-responsive '.$img_class.'" src="'.$testi_img[0].'" alt="'.get_the_title().'" />';															
								$output .= '</div>';
							$output .= '</div>';
							
							$output .= '<div class="col-lg-9 col-md-9 testimonial-info">';
								$output .= '<div class="testimonial-msg">';
									$output .= '<p>'.get_the_content().'</p>';
								$output .= '</div>';
								
								$output .= '<div class="testimonial-author">';
									$output .= '<p class="testimonial-author-name author-margin">'.get_the_title().'</p>';
									if( $author_company_url != '' ) {
										$output .= '<p class="author-sub"><a href="'.esc_url($author_company_url).'" target="_blank" title="'.get_the_title().'">'.$author_company.'</a></p>';
									} else {
										$output .= '<p class="author-sub">'.$author_company.'</p>';
									}									
								$output .= '</div>';
							$output .= '</div>';							
							
						$output .= '</div>';
						$output .= '</div>';
					
					} elseif( $style == "list" ) {
					
						$output .= '<div class="item">';				
						$output .= '<div class="grid">';
							$output .= '<div class="testimonial-author-img col-md-4">';					
							$output .= '<img class="img-responsive '.$img_class.'" src="'.$testi_img[0].'" alt="'.get_the_title().'" />';					
							$output .= '</div>';
							$output .= '<div class="testimonial-info col-md-8">';				
							$output .= '<blockquote class="blockquote">'.get_the_excerpt().'</blockquote>';
							$output .= '</div>';
							$output .= '<div class="testimonial-author clear">';				
							$output .= '<span><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></span>';
							$output .= '</div>';
						$output .= '</div>';
						$output .= '</div>';
						
					}

				endwhile;
			
				$output .= '</div>';				
				$output .= '</div>';
			} 
			
		}
		
		wp_reset_postdata();		
	
		return $output;
}

add_shortcode('tpath_testimonials', 'tpath_testimonials_shortcode');

/* =========================================================
 * Blog Shortcode
 * ========================================================= */ 
function tpath_blog_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'layout' 			=> 'grid',
				'posts' 			=> '-1',
				'categories' 		=> '',
				'title' 			=> '',
				'thumbnail' 		=> '',
				'content' 			=> '',
				'hide_author' 		=> '',
				'hide_date' 		=> '',
				'hide_categories' 	=> '',
				'hide_comments' 	=> '',
				'hide_morelink' 	=> '',				
				'pagination' 		=> '',
				'grid_columns' 		=> '',
				'grid_color' 		=> '',
			), $atts));

	$output = $category_ids = '';
	
	global $tpath_options, $post;
	
	$category_ids = explode(',', $categories);

	if( $category_ids[0] == 0 ) {
		unset($category_ids[0]);
	}
	
	if( !$posts ) {
		$posts = -1;
	}
	
	if( ( is_front_page() || is_home() ) ) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	
	$args = array(
				'posts_per_page' 		=> $posts,				
				'orderby' 		 		=> 'date',
				'order' 		 		=> 'DESC',
				'ignore_sticky_posts' 	=> 1,
				'paged' 				=> $paged,
			);
	
	if( !empty($category_ids) ) {
		$args['tax_query'] = array(	array(
								'taxonomy' 	=> 'category',
								'field' 	=> 'id',
								'terms' 	=> $category_ids
							));
	}
	
	$post_class = '';
	$image_size = '';
	$container_class = '';
	$container_id = '';
	$excerpt_limit = '';
	
	if($layout == 'large') {
		$post_class = 'large-posts col-sm-12';
		$image_size = 'blog-large';		
		$container_class = 'large-layout';
		$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_large'];
	} elseif($layout == 'grid') {
		$post_class = 'grid-posts';
		$image_size = 'blog-grid';
		$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_grid'];
		
		if($grid_columns == 'two' ) {
			$container_class = 'grid-layout grid-col-2';
		} elseif($grid_columns == 'three') {
			$container_class = 'grid-layout grid-col-3';
		} elseif( $grid_columns == 'four' ) {
			$container_class = 'grid-layout grid-col-4';
		}
	} 
	
	$blog_query = new WP_Query($args);
	
	if( $pagination == 'infinite' ) {
		$container_id = "tpath-posts-infinite-container";		
	} else {
		$container_id = "sc-posts-container";
		$container_class = "tpath-posts-container ";
	}
	
	if( $grid_color != '' ) {
		$output = '<style type="text/css">';
		$output .= '.grid-posts { background-color: '.$grid_color.'; }';
		$output .= '</style>';
	}
	
	$output .= '<div id="'.$container_id.'" class="'.$container_class.' clearfix">';	
	
	$post_count = 1;
	
	$prev_post_timestamp = null;
	$prev_post_month = null;
	$first_timeline_loop = false;
	
	if ( $blog_query->have_posts() ):
		while ( $blog_query->have_posts() ): $blog_query->the_post();
		
			$post_id = get_the_ID();
			$post_timestamp = strtotime($post->post_date);
			$post_month = date('n', $post_timestamp);
			$post_year = get_the_date('o');
			$current_date = get_the_date('o-n');
		
			$post_format = get_post_format();
			
			$post_format_class = '';
			if( $post_format == 'image' ) {
				$post_format_class = ' image-format';
			} elseif( $post_format == 'quote' ) {
				$post_format_class = ' quote-image';
			}
			
			$extra_post_class = '';
			
			$output .= '<div id="post-'.$post_id.'" ';
			ob_start();
				post_class($post_class.$extra_post_class);
			$output .= ob_get_clean() .'>';
			
				$output .= '<div class="posts-inner-container clearfix">';
					$output .= '<div class="posts-content-container">';
					
						if ( $thumbnail == 'yes' && has_post_thumbnail() && ! post_password_required() ) {
							if( $post_format == 'gallery' ) {
								$output .= '<div class="entry-thumbnail">';
									$output .= '<div class="flexslider blog-slider">';
									$output .= '<ul class="slides">';
										ob_start();
										get_gallery_post_images( $image_size, $post_id );
										$output .= ob_get_clean();
									$output .= '</ul>';
									$output .= '</div>';
									if( $hide_date != 'yes' ) {
										$output .= '<div class="posted-date"><span class="entry-date">'.get_the_time( $tpath_options['tpath_blog_date_format'] ).'</span></div>';
									}
								$output .= '</div>';
							}
							
							else {
								$output .= '<div class="entry-thumbnail'.$post_format_class.'">';
									$output .= '<a href="'.get_permalink($post_id).'" class="post-img-overlay" title="'.get_the_title().'">'.get_the_post_thumbnail( $post_id, $image_size ).'</a>';
									if( $hide_date != 'yes' ) {
										$output .= '<div class="posted-date"><span class="entry-date">'.get_the_time( $tpath_options['tpath_blog_date_format'] ).'</span></div>';
									}
								$output .= '</div>';
							}				
						}
						
						if( $post_format == 'audio' ) {
							$output .= '<div class="audio-player">';
								$output .= do_shortcode( get_post_meta( $post_id, 'tpath_single_audio_code', true ) );
							$output .= '</div>';					
						}
					
						elseif( $post_format == 'video' ) {
							$output .= '<div class="video-player">';
								$output .= do_shortcode( get_post_meta( $post_id, 'tpath_single_video_code', true ) );
							$output .= '</div>';					
						}
						
						if( $title == 'yes' ) {
							$output .= '<div class="entry-header">';
								$output .= '<h3 class="entry-title">';
									$output .= '<a href="'.get_permalink($post_id).'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a>';
								$output .= '</h3>';
							$output .= '</div>';							
						}
						
						if( $layout == 'grid' && ( ! has_post_thumbnail() && ! post_password_required() || $post_format == 'audio' || $post_format == 'video' ) ) {
							if( $hide_date != 'yes' ) {
								$output .= '<div class="posted-date"><span class="entry-date">'.get_the_time( $tpath_options['tpath_blog_date_format'] ).'</span></div>';
							}
						}
						
						if( $layout != 'grid' ) {
							if( $hide_author != 'yes' || $hide_date != 'yes' || $hide_categories != 'yes' || $hide_comments != 'yes' ) {
								$output .= '<div class="entry-meta-list">';
								$output .= '<ul class="entry-meta">';
								
									if( $hide_date != 'yes' ) {
										$output .= ' <li class="date"><span class="entry-date">'.get_the_time( $tpath_options['tpath_blog_date_format'] ).'</span></li>';
									}
									
									if( $hide_author != 'yes' ) {
										$output .= '<li class="author">';
										ob_start();										
										the_author_posts_link();
										$output .=  ob_get_clean() . '</li>';
									}
									
									if( $hide_categories != 'yes' ) {
										$output .= '<li class="category">'. __( 'in', 'TemplateCore' ) . ' '. get_the_category_list(', ') .'</li>';									
									}
									
									if( $hide_comments != 'yes' ) {							
										if ( comments_open() ) {
											$output .= '<li class="comments-link">';
											ob_start();
											comments_popup_link( '<span class="leave-reply">' . __( '0 Comment', 'TemplateCore' ) . '</span>', __( '1 Comment', 'TemplateCore' ), __( '% Comments', 'TemplateCore' ) );
											$output .= ob_get_clean();
											
											$output .= '</li>';
										}
									}								
									
								$output .= '</ul>';
								$output .= '</div>';
							}
						}
						
						if( $content != 'none' ) {
							if( $content == 'excerpt' ) {
								if( $post_format == 'quote' ) {
									$output .= '<div class="entry-summary">';
										$output .= '<div class="entry-quotes quote-format">';
											$output .= '<blockquote>';
												$output .= tpath_custom_wp_trim_excerpt('', $excerpt_limit);
											$output .= '</blockquote>';
										$output .= '</div>';
									$output .= '</div>';								
								} else {							
									$output .= '<div class="entry-summary">';
										$output .= tpath_custom_wp_trim_excerpt('', $excerpt_limit);
									$output .= '</div>';
								}
								
							} elseif ( $content == 'content' ) {
								if( $post_format == 'quote' ) {
									$output .= '<div class="entry-content">';
										$output .= '<div class="entry-quotes quote-format">';
											$output .= '<blockquote>';
												$output .= get_the_content();
											$output .= '</blockquote>';
										$output .= '</div>';
									$output .= '</div>';								
								} else {							
									$output .= '<div class="entry-content">';
										$output .= get_the_content();
									$output .= '</div>';
								}								
							}
						}
						
						if( $post_format == 'link' ) {
							$output .= '<div class="link-url">';
							$output .= '<span class="simple-icon icon-link"></span> <a href="' .get_post_meta( $post_id, 'tpath_external_link_url', true ). '" target="_blank">' . get_post_meta( $post_id, 'tpath_external_link_title', true ) .'</a>';							
							$output .= '</div>';
						}
			
						if( $hide_morelink != 'yes' ) {
							$output .= '<div class="entry-footer">';								
								$output .= '<div class="read-more">';
									if( ! $tpath_options['tpath_blog_read_more_text'] ) {
										$more_text = __('Read More', 'TemplateCore'); 
									} else { 
										$more_text = $tpath_options['tpath_blog_read_more_text'];
									}
									$output .= '<a href="'.get_permalink($post_id).'" class="btn btn-more read-more-link" title="'.get_the_title().'">'.$more_text.'</a>';
								$output .= '</div>';							
							$output .= '</div>';
						}
						
					$output .= '</div>';
				$output .= '</div>';				
			$output .= '</div>';
			
			$prev_post_timestamp = $post_timestamp;
			$prev_post_month = $post_month;
			$post_count++;
			
		endwhile;		
	endif;	
					
	$output .= '</div>';
	
	$output .= tpath_pagination( $blog_query->max_num_pages, $range = 2, $pagination );
	
	wp_reset_postdata();
	return $output;

}

add_shortcode('tpath_blog', 'tpath_blog_shortcode');

/* =========================================================
 * Newsticker Shortcode
 * ========================================================= */ 
function tpath_text_slider_shortcode( $atts, $content = null ) {

	static $tpath_text_slider = 1;

	$atts = extract(shortcode_atts(
			array(
				'direction' => 'up',
				'interval' 	=> '3000',
				'color' 	=> '',					
			), $atts));
	
	wp_enqueue_script( 'tpath-easy-ticker-js' );
	
	$output = '';
	$output = '<div id="tpath-text-slider'.$tpath_text_slider.'" class="tpath-text-slider" data-interval="'.$interval.'" data-direction="'.$direction.'">';
	if( ( isset($color) ) && $color!="" ) {
		$output .='<style type="text/css">#tpath-text-slider'.$tpath_text_slider.' li { color: '.$color.'; }</style>';
	}	 
	$output .= '<ul class="slide-text">';
	$output .= do_shortcode( str_replace('<br />', '', $content) );
	$output .= '</ul>';
	$output .= '</div>';
	
	$tpath_text_slider++;
	
	return $output;	
}
add_shortcode('tpath_text_slider', 'tpath_text_slider_shortcode');

function tpath_text_item_shortcode( $atts, $content = null ) {

	$atts = extract(shortcode_atts( array(), $atts));
	
	$output = '';
	$output = '<li class="slide-text-item">'.do_shortcode( $content ).'</li>';
	
	return $output;	
}
add_shortcode('tpath_text_item', 'tpath_text_item_shortcode');

/* =========================================================
 * Services Shortcode
 * ========================================================= */ 
function tpath_services_shortcode( $atts, $content = null ) {

	static $tpath_services_id = 1;

	$atts = extract(shortcode_atts(
			array(
				'icon_size' 	=> '',
				'icon_color' 	=> '',
				'title_color' 	=> '',
				'desc_color' 	=> '',
				'extra_class' 	=> '',
			), $atts));
		
	$icon_styles = '';
	if( ( isset( $icon_size ) && $icon_size != '' ) || ( isset( $icon_color ) && $icon_color != '' ) ) {
		if( isset( $icon_size ) && $icon_size != '' ) {
			$icon_styles = 'font-size: '.$icon_size.';';
		}
		if( isset( $icon_color ) && $icon_color != '' ) {
			$icon_styles .= 'color: '.$icon_color.';';
		}
	}
	
	$output = '';
	$output = '<div id="tpath-services'.$tpath_services_id.'" class="tpath-services'.$tpath_services_id.' tpath-services container '.$extra_class.'">';
		if( ( isset($icon_styles) && $icon_styles != '' ) || $title_color != '' || $desc_color != '' ) {
			$output .= '<style type="text/css">';
			if( isset($icon_styles) && $icon_styles != '' ) {
				$output .= '.tpath-services'.$tpath_services_id.' .services-icon { '.$icon_styles.' }' . "\n";
			}
			if( isset($title_color) && $title_color != '' ) {
				$output .= '.tpath-services'.$tpath_services_id.' .services-title { color: '.$title_color.' }' . "\n";
			}
			if( isset($desc_color) && $desc_color != '' ) {
				$output .= '.tpath-services'.$tpath_services_id.' .services-desc { color: '.$desc_color.' }' . "\n";
			}
			$output .= '</style>';
		}
		
		$output .= '<div class="row">';
			$output .= do_shortcode( str_replace('<br />', '', $content) );
		$output .= '</div>';
	$output .= '</div>';
	
	$tpath_services_id++;
	
	return $output;	
}
add_shortcode('tpath_services', 'tpath_services_shortcode');

function tpath_services_item_shortcode( $atts, $content = null ) {

	static $tpath_servicesitem_id = 1;

	$atts = extract(shortcode_atts(
			array(
				'column' 			=> '',
				'title'				=> '',
				'faicon' 			=> '',
				'btn_text' 			=> '',
				'button_url' 		=> '',
				'button_style' 		=> '',	
				'button_size' 		=> '',			
				'target' 			=> '',
				'animation_type'	=> '',
				'animation_delay'	=> '',
			), $atts));
	
	$output = $btn_sizes = $animation_class = $extra_data = '';
	
	if( $button_size ) {
		if( $button_size == 'large' ) $btn_sizes = ' btn-lg';
		if( $button_size == 'small' ) $btn_sizes = ' btn-sm';
		if( $button_size == 'mini' ) $btn_sizes = ' btn-xs';
	}
	
	if( $animation_type != 'none' ) {
		$animation_class = ' animated';
		$extra_data = ' data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}
		
	$output .= '<div class="col-md-'.$column.' tpath-services-item'.$animation_class.'" id="services-item'.$tpath_servicesitem_id.'"'.$extra_data.'>';
		$output .= '<div class="services-inner">';
	
			if( $faicon != '' ) {
				$output .= '<i class="fa fa-' .$faicon. ' services-icon"></i>';
			}
						
			$output .= '<h6 class="services-title">' .$title. '</h6>';
			$output .= '<div class="services-desc">';
				$output .= do_shortcode($content);
			$output .= '</div>';
			
			if( $button_url != '' ) {
				$output .= '<a class="tpath-button btn btn-'.$button_style.''. $btn_sizes .'" href="'.esc_url($button_url).'" target="'.$target.'">'. $btn_text .'</a>';
			}
		
		$output .= '</div>';
	$output .= '</div>';	
	
	$tpath_servicesitem_id++;
	
	return $output;	
}
add_shortcode('tpath_services_item', 'tpath_services_item_shortcode');

/* =========================================================
 * HTML Block Shortcode
 * ========================================================= */ 
 
function tpath_html_block_shortcode( $atts, $content = null ) {

	$atts = extract(shortcode_atts(
			array(
				'tag' 		=> '',
				'class' 	=> '',				
			), $atts));
				
	$output = $extra_data = '';
			
	if( isset($class) && $class != '' ) {		
		$extra_data = ' class="'.$class.'"';
	}
	
	$output .= '<'. $tag . $extra_data . '>';
	$output .= do_shortcode( $content );
	$output .= '</'. $tag .'>';
		
	return $output;
}

add_shortcode('tpath_html_block', 'tpath_html_block_shortcode');

/* =========================================================
 * Background Video Shortcode
 * ========================================================= */ 
 
function tpath_bg_video_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'video_id' 		=> '',
				'autoplay' 		=> 'true',
				'screen_height' => '510',
				'fallback' 		=> '',
				'controls' 		=> '',
				'mute' 			=> '',
			), $atts));
			
	static $tpath_video_count = 1;
	
	$output = $video_data = '';
	wp_enqueue_script( 'tpath-video-slider-js' );
	
	if( ( isset($screen_height) && $screen_height != '' ) || ( isset($fallback) && $fallback != '' ) ) {		
		$output .= '<style type="text/css" scoped>';
		
		if( isset($screen_height) && $screen_height != '') {
			$output .= '#video_container'.$tpath_video_count.' { height:'.$screen_height.'px; }' . "\n";
			$output .= '#video-bg'.$tpath_video_count.' { height:'.( $screen_height + 4 ).'px; }' . "\n";
		}
		
		if( isset($fallback) && $fallback != '') {
			$output .= '#video-bg'.$tpath_video_count.' { background-image: url("'.$fallback.'"); }';
		}		
		$output .= '</style>';
	}
	
	$video_data = "videoURL:'".$video_id."',showControls:".$controls.",autoPlay:".$autoplay.",mute:".$mute."";
	
	ob_start();	?>
	
	<div id="video-bg<?php echo esc_attr( $tpath_video_count );?>" class="video-bg">
		<div id="video_container<?php echo esc_attr( $tpath_video_count );?>" class="video_container"></div>
		<div id="player-<?php echo esc_attr( $tpath_video_count );?>" class="tpath-yt-player bg-video-container" data-property="{<?php echo esc_html( $video_data ); ?>,containment:'#video_container<?php echo esc_attr( $tpath_video_count ); ?>',startAt:0}">
		</div>
	</div>
	
	<?php $output .= ob_get_clean();	
	
	$tpath_video_count++;
		
	return $output;
}

add_shortcode('tpath_bg_video', 'tpath_bg_video_shortcode');

/* =========================================================
 * Mailchimp Shortcode
 * ========================================================= */ 
 
function tpath_mailchimp_shortcode( $atts, $content = null ) {

	$atts = extract(shortcode_atts(
			array(
				'list_id' 	=> '',
				'btn_text' 	=> 'Subscribe',
				'style' 	=> '',
				'size' 		=> '',
			), $atts));
			
	static $tpath_mailchimp_id = 1;
	
	$output = $list_result = $btn_sizes = '';
	
	if( $size ) {
		if( $size == 'large' ) {
			$btn_sizes = ' btn-lg';
		}
		if( $size == 'small' ) {
			$btn_sizes = ' btn-sm';
		}
		if( $size == 'mini' ) {
			$btn_sizes = ' btn-xs';
		}
		if( $size == 'wide' ) {
			$btn_sizes = ' btn-wide';
		}
	}
	
	if( isset( $list_id ) && $list_id != '' ) {
	
		$error = '';
		
		if ( isset( $_POST['tpath_mc_submit'] ) ) {
			if( ! isset( $_POST['subscribe_email'] ) || ! is_email( $_POST['subscribe_email'] ) ) {
				$list_result = "Invalid Email. Please enter correct Email ID.";
				$error = true;
			} else {
				$email = $_POST['subscribe_email'];
			}
			
			$merge_vars = array();
							
			if( !$error ) {
				$list_result = mc_subscribeformat( $email, $merge_vars, $list_id );
			}
		}
		
		$output .= '<div id="mc-subscribe'.$tpath_mailchimp_id.'" class="subscribe-form">';
				
		$output .= '<p class="subscribe-result">'.$list_result.'</p>';
		
		if( isset( $list_result ) && $list_result != '' ) {
			ob_start(); ?>
<script type="text/javascript">
jQuery(window).load(function() {			
	jQuery.scrollTo('#mc-subscribe<?php echo esc_attr( $tpath_mailchimp_id ); ?>', 0, {duration: 2000, easing: 'easeInOutQuint', offset: -120});
});
</script>
			<?php $output .= ob_get_clean();
		}
		
		$output .= '<form role="form" method="post" action="'.tpath_get_current_url().'" id="tpath-mailchimp-form" name="tpath-mailchimp-form" class="tpath-mailchimp-form form-horizontal">';
			$output .= '<div class="col-md-12">';
				$output .= '<div class="form-group mailchimp-email">';
					$output .= '<input type="email" placeholder="'.__('Your Email Address', 'TemplateCore').'" class="tpath-subscribe input-email form-control text-center" name="subscribe_email">';
				$output .= '</div>';
				$output .= '<div class="tpath-input-submit submit">';
					$output .= '<button type="submit" id="tpath_mc_form_submit" name="tpath_mc_submit" class="btn btn-'.$style.' mc-subscribe'.$btn_sizes.'">'.$btn_text.'</button>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</form>';
		
		$output .= '</div>';

	}
	
	$tpath_mailchimp_id++;
		
	return $output;
}

add_shortcode('tpath_mailchimp', 'tpath_mailchimp_shortcode');

/* =========================================================
 * Contact Form Shortcode
 * ========================================================= */ 
 
function tpath_contact_form_shortcode( $atts, $content = null ) {

	$atts = extract(shortcode_atts(
			array(
				'form' 			=> 'on',
				'form_align' 	=> '',
				'info' 			=> '',
				'btn_text' 		=> '',
			), $atts));
	
	static $tpath_contactform_id = 1;
			
	global $tpath_options;
				
	$output = $name = $email = $subject = $budget = $priority = $message = $extra_class = '';
	
	if( isset($btn_text) && $btn_text == '' ) {
		$btn_text = __('Send Message', 'TemplateCore');
	}
	
	if( isset($form_align) && $form_align == 'on' ) {
		$extra_class = ' tpath-form-center';
	}
	
	$name = $tpath_options['tpath_labels_name'] ? $tpath_options['tpath_labels_name'] : __('Your Name', 'TemplateCore');
	$email = $tpath_options['tpath_labels_email'] ? $tpath_options['tpath_labels_email'] : __('Your Email', 'TemplateCore');
	$subject = $tpath_options['tpath_labels_subject'] ? $tpath_options['tpath_labels_subject'] : __('Subject', 'TemplateCore');
	$budget = $tpath_options['tpath_labels_budget'] ? $tpath_options['tpath_labels_budget'] : __('Budget 50 000$', 'TemplateCore');
	$priority = $tpath_options['tpath_form_priority'] ? $tpath_options['tpath_form_priority'] : __('Priority medium', 'TemplateCore');
	$message = $tpath_options['tpath_labels_message'] ? $tpath_options['tpath_labels_message'] : __('Your Message', 'TemplateCore');	
	$form_class = '';
	if( isset( $info ) && $info == 'on' ) {
		$form_class = "col-md-8";
	} else {
		$form_class = "col-xs-12";
	}

	$output .= '<div class="row">';
		if( isset( $form ) && $form == 'on' ) {
			$output .= '<div class="'.$form_class.''.$extra_class.' tpath-contactform">';
				$output .= '<p class="tpath-form-success"></p>'; 
				$output .= '<p class="tpath-form-error"></p>'; 
				$output .= '<div class="tpath-contact-form-wrapper">';
					$output .= '<form role="form" name="contactform'.$tpath_contactform_id.'" class="tpath-contact-form" id="contactform'.$tpath_contactform_id.'" method="post" action="#">';															
						$output .= '<div class="row">';
							$output .= '<div class="col-md-6">';								
								if( ! $tpath_options['tpath_form_name'] ) {
									$output .= '<div class="tpath-input-text form-group">';
										$output .= '<label class="sr-only" for="contact_name">'.$name.'</label>';
										$output .= '<input type="text" name="contact_name" id="contact_name" class="input-name form-control" placeholder="'.$name.'">';
									$output .= '</div>';
								} 
							$output .= '</div>';
								
							$output .= '<div class="col-md-6">';								
								if( ! $tpath_options['tpath_form_subject'] ) {
									$output .= '<div class="tpath-input-subject form-group">';											
										$output .= '<label class="sr-only" for="contact_subject">'.$subject.'</label>';
										$output .= '<input type="text" name="contact_subject" id="contact_subject" class="input-subject form-control" placeholder="'.$subject.'">';												
									$output .= '</div>';
								}
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="row">';							
							$output .= '<div class="col-md-6">';
								$output .= '<div class="tpath-input-email form-group">';
									$output .= '<label class="sr-only" for="contact_email">'.$email.'</label>';
									$output .= '<input type="email" name="contact_email" id="contact_email" class="input-email form-control" placeholder="'.$email.'">';
								$output .= '</div>';
							$output .= '</div>';
							
							if( ! $tpath_options['tpath_form_budget'] ) {
								$output .= '<div class="col-md-3">';
									$output .= '<div class="tpath-input-budget form-group">';									
										$output .= '<label class="sr-only" for="contact_budget">'.$budget.'</label>';
										$output .= '<input type="number" name="contact_budget" id="contact_budget" min="1" class="input-budget form-control" placeholder="'.$budget.'">';									
									$output .= '</div>';
								$output .= '</div>';
							}
							
							if( ! $tpath_options['tpath_form_priority'] ) {
								$output .= '<div class="col-md-3">';
									$output .= '<div class="tpath-input-select form-group">';										
										$output .= '<label class="sr-only" for="contact_priority">'.$priority.'</label>';
										$output .= '<select name="contact_priority" id="contact_priority">';
											$output .= '<option value="" disabled selected>' . esc_html( $priority ) .'</option>';
											$output .= '<option value="high">'. esc_html__('High', 'TemplateCore') .'</option>';
											$output .= '<option value="medium">'. esc_html__('Medium', 'TemplateCore') .'</option>';
											$output .= '<option value="low">'. esc_html__('Low', 'TemplateCore') .'</option>';
										$output .= '</select>';
									$output .= '</div>';
								$output .= '</div>';
							}
						$output .= '</div>';
						
						$output .= '<div class="row">';
							$output .= '<div class="col-xs-12">';							
								$output .= '<div class="tpath-textarea-message form-group">';								
									$output .= '<label class="sr-only" for="contact_message">'.$message.'</label>';
									$output .= '<textarea name="contact_message" id="contact_message" class="textarea-message form-control" rows="8" cols="30" placeholder="'.$message.'"></textarea>';										
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
							
						$output .= '<div class="tpath-input-submit form-group">';
							$output .= '<button type="submit" class="btn tpath-submit">'.$btn_text.'</button>';
						$output .= '</div>';							
											
					$output .= '</form>';					
				$output .= '</div>';				
			$output .= '</div>';
		}	
		
		if( isset( $info ) && $info == 'on' ) {
			$output .= '<div class="col-md-4">';
				$output .= '<div class="tpath-contact-info">';
					$output .= '<div class="row">';
						if( $tpath_options['tpath_site_name'] != '' ) {
							$output .= '<div class="col-xs-12 contact-row">';
								$output .= '<div class="site-info">';														
									$output .= '<p class="contact-info-title"><i class="fa fa-user"></i> <strong>' . esc_html( $tpath_options['tpath_site_name'] ) .'</p>';									
								$output .= '</div>';
							$output .= '</div>';
						}
						
						if( $tpath_options['tpath_site_address'] != '' ) {
							$output .= '<div class="col-xs-12 contact-row">';
								$output .= '<div class="address-info">';														
									$output .= '<p><i class="fa fa-map-marker"></i> '. esc_html( $tpath_options['tpath_site_address'] ) .'</p>';									
								$output .= '</div>';
							$output .= '</div>';
						}
						
						if( $tpath_options['tpath_site_url'] != '' ) {
							$output .= '<div class="col-xs-12 contact-row">';
								$output .= '<div class="website-info">';									
									$output .= '<p><i class="fa fa-globe"></i> <a href="' .$tpath_options['tpath_site_url']. '">' .$tpath_options['tpath_site_url']. '</a></p>';									
								$output .= '</div>';
							$output .= '</div>';
						}
						
						if( $tpath_options['tpath_site_phone'] || $tpath_options['tpath_site_fax_number'] ) {
							$output .= '<div class="col-xs-12 contact-row">';
								$output .= '<div class="phone-info">';
								if( $tpath_options['tpath_site_phone'] ) { 
										$output .= '<p><i class="fa fa-phone"></i> ' . $tpath_options['tpath_site_phone'] .'</p>'; 
									}
									if( $tpath_options['tpath_site_fax_number'] ) { 
										$output .= '<p><i class="fa fa-fax"></i> ' . $tpath_options['tpath_site_fax_number'] .'</p>'; 
									}
								$output .= '</div>';
							$output .= '</div>';
						}
						
						if( $tpath_options['tpath_site_email'] != '' ) {
							$output .= '<div class="col-xs-12 contact-row">';
								$output .= '<div class="email-info">';
									$output .= '<p><i class="simple-icon icon-envelope"></i> <a href="mailto:' .$tpath_options['tpath_site_email']. '">' .$tpath_options['tpath_site_email']. '</a></p>';
								$output .= '</div>';
							$output .= '</div>';
						}
						
					$output .= '</div>';
				$output .= '</div>';				
			$output .= '</div>';	
		}
	$output .= '</div>';
		
	$tpath_contactform_id++;
		
	return $output;
}

add_shortcode('tpath_contact_form', 'tpath_contact_form_shortcode');

/* =========================================================
 * Team Member Shortcode
 * ========================================================= */ 
function tpath_team_member_shortcode( $atts ) {

	$atts = extract(shortcode_atts(
			array(
				'category' 			=> '',
				'items' 			=> '',
				'itemsdesktopsmall' => '',
				'itemstablet' 		=> '',
				'itemsmobile' 		=> '',
				'navigation' 		=> '',
				'pagination'		=> '',				
				'animation_type' 	=> '',
				'animation_delay'   => '',
			), $atts));
		
	$output = '';
	global $post;
	
	$data_attr = $extra_class = $extra_data = '';
	
	static $tpath_team_member = 1;
	
	if( isset( $items ) && $items != '' ) {
		$data_attr .= ' data-items="' . $items . '" ';
		$data_attr .= ' data-itemsDesktop="1199, ' . $items . '" ';
	}
	
	if( isset( $itemsdesktopsmall ) && $itemsdesktopsmall != '' ) {
		$data_attr .= ' data-itemsDesktopSmall="980, ' . $itemsdesktopsmall . '" ';
		$data_attr .= ' data-itemsTablet="979, ' . $itemsdesktopsmall . '" ';
	}
	
	if( isset( $itemstablet ) && $itemstablet != '' ) {
		$data_attr .= ' data-itemsTabletSmall="768, ' . $itemstablet . '" ';
	}
	
	if( isset( $itemsmobile ) && $itemsmobile != '' ) {
		$data_attr .= ' data-itemsMobile="480, ' . $itemsmobile . '" ';
	}
	
	if( isset( $pagination ) && $pagination != '' ) {
		$data_attr .= ' data-pagination="' . $pagination . '" ';
	}
	if( isset( $navigation ) && $navigation != '' ) {
		$data_attr .= ' data-navigation="' . $navigation . '" ';
	}
	$data_attr .= ' data-autoplay="true" ';
	
	if( isset($animation_type) && $animation_type != 'none' ) {
		$extra_class = ' animated';
		$extra_data = ' data-animation="'.$animation_type.'"';
	}
	
	if( $animation_delay != '' && $animation_type != 'none' ) {
		$extra_data .= ' data-animation-delay="'.$animation_delay.'"';
	}	
		
	if( $category != '0' && $category != '' ) {
		
		$team_query = new WP_Query(array('post_type'  	 => 'tpath_team_member',
										'posts_per_page' => -1,
										'orderby' 		 => 'menu_order',
										'order' 		 => 'ASC',
										'tax_query' 	 => array(
															   array(
																'taxonomy' => 'team_member_categories',
																'field' => 'id',
																'terms' => $category
															) )));
										
		if ( $team_query->have_posts() ) {
		
			$output .= '<div id="tpath-team-slider'.$tpath_team_member.'" class="container-big tpath-owl-carousel owl-carousel team-carousel-slider"'.$data_attr.'>';
			
			while ($team_query->have_posts()) : $team_query->the_post();
				$team_member_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
				$member_name = get_post_meta( $post->ID, 'tpath_member_name', true );
				$member_designation = get_post_meta( $post->ID, 'tpath_member_designation', true );
				$member_facebook = get_post_meta( $post->ID, 'tpath_member_facebook', true );
				$member_twitter = get_post_meta( $post->ID, 'tpath_member_twitter', true );
				$member_googleplus = get_post_meta( $post->ID, 'tpath_member_googleplus', true );
				$member_linkedin = get_post_meta( $post->ID, 'tpath_member_linkedin', true );
				$member_yahoo = get_post_meta( $post->ID, 'tpath_member_yahoo', true );
				$member_email = get_post_meta( $post->ID, 'tpath_member_email', true );
				
				$output .= '<div class="team-box text-center'.$extra_class.'"'.$extra_data.'>';
					$output .= '<div class="member-item">';
						$output .= '<div class="member-wrapper">';
						if( isset( $team_member_img ) && $team_member_img != '' ) {
							$output .= '<div class="member-image">';
							$output .= '<img src="'.esc_url($team_member_img[0]).'" alt="'.esc_attr($member_name).'" class="img-responsive" />';
							$output .= '</div>';
						}
				
						$output .= '<div class="member-social">';
							$output .= '<ul class="list-inline">';
							if( isset( $member_facebook ) && $member_facebook != '' ) {
								$output .= '<li class="facebook"><a target="_blank" href="'.esc_url($member_facebook).'"><i class="fa fa-facebook"></i></a></li>';
							}
							if( isset( $member_twitter ) && $member_twitter != '' ) {
								$output .= '<li class="twitter"><a target="_blank" href="'.esc_url($member_twitter).'"><i class="fa fa-twitter"></i></a></li>';
							}
							if( isset( $member_googleplus ) && $member_googleplus != '' ) {
								$output .= '<li class="googleplus"><a target="_blank" href="'.esc_url($member_googleplus).'"><i class="fa fa-google-plus"></i></a></li>';
							}	
							if( isset( $member_linkedin ) && $member_linkedin != '' ) {
								$output .= '<li class="linkedin"><a target="_blank" href="'.esc_url($member_linkedin).'"><i class="fa fa-linkedin"></i></a></li>';
							}
							if( isset( $member_yahoo ) && $member_yahoo != '' ) {
								$output .= '<li class="yahoo"><a target="_blank" href="'.esc_url($member_yahoo).'"><i class="fa fa-yahoo"></i></a></li>';
							}
							if( isset( $member_email ) && $member_email != '' ) {
								$output .= '<li class="email"><a target="_blank" href="mailto:'.esc_url($member_email).'"><i class="fa fa-envelope-o"></i></a></li>';
							}
							$output .= '</ul>';
						$output .= '</div>';
					$output .= '</div>';
						
					$output .= '<div class="member-info">';
						$output .= '<h3 class="team-member-title">'.$member_name.'</h3>';
						$output .= '<h5 class="member-designation">'.$member_designation.'</h5>';
						$output .= '<div class="member-description">'. tpath_custom_wp_trim_excerpt('', 50) .'</div>';
					$output .= '</div>';
					
				$output .= '</div>';
								
				$output .= '</div>';
			
			endwhile;
			$output .= '</div>';
		}
		
		$tpath_team_member++;		
		wp_reset_postdata();
	}
	
	return $output;
	
}
add_shortcode('tpath_team_member', 'tpath_team_member_shortcode');

/* =========================================================
 * Get Attachment ID from attachment URL
 * ========================================================= */ 
 
function tpath_get_attachment_id_from_url( $attachment_url = '' ) {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ( '' == $attachment_url )
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

    }

    return $attachment_id;
}
?>