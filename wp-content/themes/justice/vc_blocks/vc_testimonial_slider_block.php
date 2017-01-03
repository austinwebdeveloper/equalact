<?php 
/**
 * The Shortcode
 */
function tpath_testimonial_slider_shortcode( $atts ) {
	
	$output = $posts = $categories = $testimonial_type = $designation = '';
	
	extract( 
		shortcode_atts( 
			array(
				'testimonial_type'			=> 'default',
				'designation'				=> 'yes',
				'posts' 					=> '3',
				'categories' 				=> 'all',
				'excerpt_length' 			=> '',
				'items'						=> '2',
				'items_scroll' 				=> '1',
				'auto_play' 				=> 'true',					
				'timeout_duration' 			=> '5000',
				'infinite_loop' 			=> 'false',
				'margin' 					=> '30',
				'items_tablet'				=> '2',
				'items_mobile_landscape'	=> '1',
				'items_mobile_portrait'		=> '1',
				'navigation' 				=> 'true',
				'pagination' 				=> 'true',	
			), $atts 
		) 
	);
	
	global $post;
	
	// Slider Configuration
	$data_attr = '';

	if( isset( $items ) && $items != '' ) {
		$data_attr .= ' data-items="' . $items . '" ';
	}
	
	if( isset( $items_scroll ) && $items_scroll != '' ) {
		$data_attr .= ' data-slideby="' . $items_scroll . '" ';
	}
	
	if( isset( $items_tablet ) && $items_tablet != '' ) {
		$data_attr .= ' data-items-tablet="' . $items_tablet . '" ';
	}
	
	if( isset( $items_mobile_landscape ) && $items_mobile_landscape != '' ) {
		$data_attr .= ' data-items-mobile-landscape="' . $items_mobile_landscape . '" ';
	}
	
	if( isset( $items_mobile_portrait ) && $items_mobile_portrait != '' ) {
		$data_attr .= ' data-items-mobile-portrait="' . $items_mobile_portrait . '" ';
	}
	
	if( isset( $auto_play ) && $auto_play != '' ) {
		$data_attr .= ' data-autoplay="' . $auto_play . '" ';
	}
	if( isset( $timeout_duration ) && $timeout_duration != '' ) {
		$data_attr .= ' data-autoplay-timeout="' . $timeout_duration . '" ';
	}
	
	if( isset( $infinite_loop ) && $infinite_loop != '' ) {
		$data_attr .= ' data-loop="' . $infinite_loop . '" ';
	}
	
	if( isset( $margin ) && $margin != '' ) {
		$data_attr .= ' data-margin="' . $margin . '" ';
	}
	
	if( isset( $pagination ) && $pagination != '' ) {
		$data_attr .= ' data-pagination="' . $pagination . '" ';
	}
	if( isset( $navigation ) && $navigation != '' ) {
		$data_attr .= ' data-navigation="' . $navigation . '" ';
	}	
	
	/**
	 * Testimonial Query Args
	 */
	$args = array(
		'post_type' 		=> 'tpath_testimonial',
		'posts_per_page' 	=> $posts,
		'orderby' 		 	=> 'date',
		'order' 		 	=> 'DESC',
	);
		
	if( ! ( $categories == 'all' ) ) {
		
		$category_id = (int)$categories;
		
		$args['tax_query'] = array( array(
								'taxonomy' 	=> 'testimonial_categories',
								'field' 	=> 'id',
								'terms' 	=> $category_id
							) );
	}	
		
	$testimonial_query = new WP_Query( $args );
	
	
	// Classes
	$main_classes = '';
	$excerpt_limit = '';
	if( isset( $testimonial_type ) && $testimonial_type != '' ) {
		$main_classes .= ' type-' . $testimonial_type;
		
	}
	if( isset( $designation ) && $designation != '' ) {
		$main_classes .= ' designation-' . $designation;
	}
	
	if( isset( $excerpt_length ) && $excerpt_length == '' ) {
		$excerpt_limit = '20';
	} else {
		$excerpt_limit = $excerpt_length;
	}
	
	if( $testimonial_query->have_posts() ) {
	
		$output = '<div class="testimonial-slider-wrapper'. $main_classes .'">';
			$output .= '<div id="testimonial-slider" class="tpath-owl-carousel owl-carousel testimonial-carousel-slider"'.$data_attr.'>';
			
				while($testimonial_query->have_posts()) : $testimonial_query->the_post();
		
				$author_designation = $company_name = $company_url = $company_info = '';
				
				$testi_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');	
				$author_designation = get_post_meta( $post->ID, 'tpath_author_designation', true );
				$company_name = get_post_meta( $post->ID, 'tpath_author_company_name', true );
				$company_url = get_post_meta( $post->ID, 'tpath_author_company_url', true );
				if( $company_url != '' ) {
					$company_info = '<span class="author-company"> - <a href="'. esc_url( $company_url ) .'" target="_blank">'. esc_html( $company_name ) .'</a></span>';
				} 
			
				$output .= '<div class="testimonial-item">';
				
				// Author TOP
				if( $testimonial_type == 'author_top' ) {
					$output .= '<div class="testimonial-author">';
						$output .= '<div class="author-image">';
							$output .= '<img class="img-responsive" src="'.$testi_img[0].'" alt="'.get_the_title().'" />';	
						$output .= '</div>';														
						$output .= '<div class="testimonial-detail">';
							$output .= '<div class="testimonial-info">';
								$output .= '<h5 class="client-author-name">'.get_the_title().'</h5>';
								if( $designation == 'yes' ) {
									$output .= '<p class="client-author-info"><span class="author-designation">'.$author_designation.'</span>' . $company_info .'</p>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
					}
					
				// Author DEFAULT
				if( $testimonial_type == 'default' ) {
					$output .= '<div class="author-image author-left">';
						$output .= '<img class="img-responsive" src="'.$testi_img[0].'" alt="'.get_the_title().'" />';	
					$output .= '</div>';
				}
				
				// Testimonials Content
				$output .= '<div class="testimonial-content">';
					$output .= '<div class="testimonial-text">';
						$output .= wp_trim_words(get_the_content(), $excerpt_limit, '');
					$output .= '</div>';
					// Author DEFAULT
					if( $testimonial_type == 'default' ) {
						$output .= '<div class="testimonial-info">';
							$output .= '<h5 class="client-author-name">'.get_the_title().'</h5>';
							if( $designation == 'yes' ) {
								$output .= '<p class="client-author-info"><span class="author-designation">'.$author_designation.'</span>' . $company_info .'</p>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';
					
				// Author Bottom
				if( $testimonial_type == 'author_bottom' ) {
					$output .= '<div class="testimonial-author">';
						$output .= '<div class="author-image">';
							$output .= '<img class="img-responsive" src="'.$testi_img[0].'" alt="'.get_the_title().'" />';	
						$output .= '</div>';														
						$output .= '<div class="testimonial-detail">';
							$output .= '<div class="testimonial-info">';
								$output .= '<h5 class="client-author-name">'.get_the_title().'</h5>';
								if( $designation == 'yes' ) {
									$output .= '<p class="client-author-info"><span class="author-designation">'.$author_designation.'</span>' . $company_info .'</p>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
					
				$output .= '</div>';

				endwhile;
	
			$output .= '</div>';
		$output .= '</div>';
		
	}
	
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'tpath_vc_testimonial', 'tpath_testimonial_slider_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_testimonial_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Testimonial Slider', 'Templatepath' ),
			"base" 			=> 'tpath_vc_testimonial',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),		
			"params" 		=> array(
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Testimonials Style", "Templatepath" ),
					"param_name" 	=> "testimonial_type",
					"value" 		=> array_flip(array(
									'default' 		 => 'Default',
									'author_top' 	 => 'Author Info on Top',
									'author_bottom'  => 'Author Info on Bottom',
									)),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("How Many Posts to Show?", "Templatepath"),
					"param_name" 	=> "posts",
					"value" 		=> "3",
					"description" 	=> ""
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Excerpt Limit", "Templatepath"),
					"param_name" 	=> "excerpt_length",
					"value" 		=> "",
					"description" 	=> ""
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Display Author Designation", "Templatepath" ),
					"param_name" 	=> "designation",
					"value" 		=> array_flip(array(
									'yes' 	 => 'Yes',
									'no' 	 => 'No'
									)),
				),
				// Slider
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items to Display", "Templatepath" ),
					"param_name"	=> "items",
					'admin_label'	=> true,
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items to Scrollby", "Templatepath" ),
					"param_name"	=> "items_scroll",
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Auto Play", 'Templatepath' ),
					'param_name'	=> "auto_play",
					'admin_label'	=> true,				
					'value'			=> array(
						__( 'True', 'Templatepath' )	=> 'true',
						__( 'False', 'Templatepath' )	=> 'false',
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Timeout Duration (in milliseconds)', 'Templatepath' ),
					'param_name'	=> "timeout_duration",
					'value'			=> "5000",
					'dependency'	=> array(
						'element'	=> "auto_play",
						'value'		=> 'true'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Infinite Loop", 'Templatepath' ),
					'param_name'	=> "infinite_loop",
					'value'			=> array(
						__( 'False', 'Templatepath' )	=> 'false',
						__( 'True', 'Templatepath' )	=> 'true',
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Margin ( Items Spacing )", "Templatepath" ),
					"param_name"	=> "margin",
					'admin_label'	=> true,
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display in Tablet", "Templatepath" ),
					"param_name"	=> "items_tablet",
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display In Mobile Landscape", "Templatepath" ),
					"param_name"	=> "items_mobile_landscape",
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display In Mobile Portrait", "Templatepath" ),
					"param_name"	=> "items_mobile_portrait",
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Navigation", "Templatepath" ),
					"param_name"	=> "navigation",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false" ),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Pagination", "Templatepath" ),
					"param_name"	=> "pagination",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false" ),
					"group"			=> __( "Slider", "Templatepath" ),
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'tpath_vc_testimonial_shortcode');