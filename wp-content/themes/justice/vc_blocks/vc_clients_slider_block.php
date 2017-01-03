<?php 
/**
 * The Shortcode
 */
function tpath_clients_slider_shortcode( $atts ) {
	
	$output = $posts = $items = $pagination = $navigation = $pagenav_style = $autoplay = $categories = $data_attr = '';
	
	extract( 
		shortcode_atts( 
			array(
				'posts' 			=> '-1',
				'items' 			=> '4',
				'items_scroll' 		=> '1',
				'infinite_loop' 	=> 'true',
				'pagination' 		=> 'false',
				'navigation' 		=> 'true',
				'pagenav_style' 	=> 'light',
				'auto_play' 		=> 'true',
				'autoplay_timeout' 	=> '5000',
				'categories' 		=> 'all',
			), $atts 
		) 
	);
	
	static $client_id = 1;
	global $post;
	
	/**
	 * Clients Query Args
	 */
	$args = array(
		'post_type' 		=> 'tpath_clients',
		'posts_per_page' 	=> $posts,
		'orderby' 			=> 'menu_order',
	);
		
	if( ! ( $categories == 'all' ) ) {
		
		$category_id = (int)$categories;
		
		$args['tax_query'] = array( array(
								'taxonomy' 	=> 'client_categories',
								'field' 	=> 'id',
								'terms' 	=> $category_id
							) );
	}
	
	$data_attr .= ' data-items="' . $items . '" ';
	$data_attr .= ' data-slideby="' . $items_scroll . '" ';
	$data_attr .= ' data-items-tablet="2" ';
	$data_attr .= ' data-items-mobile-landscape="2" ';
	$data_attr .= ' data-items-mobile-portrait="1" ';
		
	$data_attr .= ' data-loop="'. $infinite_loop .'" ';
	$data_attr .= ' data-pagination="'. $pagination .'" ';
	$data_attr .= ' data-navigation="'. $navigation .'" ';
	$data_attr .= ' data-autoplay="'. $auto_play .'" ';
	$data_attr .= ' data-autoplay-timeout="'. $autoplay_timeout .'" ';
		
	$client_query = new WP_Query( $args );
	
	if( $client_query->have_posts() ) {
	
		$output .= '<div class="clients-wrapper">';
		
			$output .= '<div id="clients-slider'.$client_id.'" class="tpath-owl-carousel owl-carousel clients-carousel-slider navstyle-'.$pagenav_style.'"'.$data_attr.'>';
			
				while($client_query->have_posts()) : $client_query->the_post();
		
				$client_url = '';
				$client_url = get_post_meta( $post->ID, 'tpath_client_url', true );
				$client_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
				
				$output .= '<div class="client-item">';
					
					if( isset( $client_url ) && $client_url != '' ) {
						$output .= '<a href="'. esc_url($client_url) .'" target="_blank">';
					}
					
					$output .= '<img src="'. esc_url($client_img[0]) .'" alt="'. get_the_title() .'" class="img-responsive" />';
	
					if( isset( $client_url ) && $client_url != '' ) {
						$output .= '</a>';
					}
					
				$output .= '</div>';

				endwhile;
	
			$output .= '</div>';
	
		$output .= '</div>';
		
	}
	
	wp_reset_postdata();
	$client_id++;
	
	return $output;
}
add_shortcode( 'tpath_vc_clients', 'tpath_clients_slider_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_client_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Clients Slider', 'Templatepath' ),
			"base" 			=> 'tpath_vc_clients',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),			
			"params" 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("How Many Posts to Show?", "Templatepath"),
					"param_name" 	=> "posts",
					"admin_label" 	=> true,
					"value" 		=> "6",
					"description" 	=> ""
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Items To Display", "Templatepath"),
					"param_name" 	=> "items",
					"value" 		=> "4",
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Items To Scrollby", "Templatepath"),
					"param_name" 	=> "items_scroll",
					"value" 		=> "1",
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( 'Infinite Loop', 'Templatepath' ),
					'param_name'	=> 'infinite_loop',
					'value'			=> array(
						__( 'True', 'Templatepath' )	=> 'true',
						__( 'False', 'Templatepath' )	=> 'false',
					),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show Slider Pagination?", "Templatepath" ),
					"param_name" 	=> "pagination",
					"value" 		=> array_flip(array(									
									'false'  => 'No',
									'true' 	 => 'Yes'
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show Slider Navigation?", "Templatepath" ),
					"param_name" 	=> "navigation",
					"value" 		=> array_flip(array(									
									'false'  => 'No',
									'true' 	 => 'Yes'
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Pagination & Navigation Style", "Templatepath" ),
					"param_name" 	=> "pagenav_style",
					"value" 		=> array_flip(array(									
									'light'  => 'Light',
									'dark' 	 => 'Dark'
									)),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( 'Auto Play', 'Templatepath' ),
					'param_name'	=> 'auto_play',
					'value'			=> array(
						__( 'True', 'Templatepath' )	=> 'true',
						__( 'False', 'Templatepath' )	=> 'false',
					),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Auto Play Timeout Duration (in milliseconds)", "Templatepath"),
					"param_name" 	=> "autoplay_timeout",
					"value" 		=> "5000",
					'dependency'	=> array(
						'element'	=> 'auto_play',
						'value'		=> 'true'
					),
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'tpath_vc_client_shortcode');