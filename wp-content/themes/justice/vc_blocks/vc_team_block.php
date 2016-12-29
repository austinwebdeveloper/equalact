<?php 
/**
 * The Shortcode
 */
function tpath_vc_team_shortcode( $atts ) {
	
	$output = '';
	
	extract( 
		shortcode_atts( 
			array(
				'team_type'					=> 'grid',
				'columns'					=> '2',
				'team_style' 				=> 'style1',
				'posts' 					=> '3',
				'show_pagination' 			=> 'no',
				'btn_txt' 					=> __('Contact Now', 'Templatepath'),
				'categories' 				=> 'all',
				'items'						=> '2',
				'items_scroll' 				=> '1',
				'auto_play' 				=> 'true',					
				'timeout_duration' 			=> '5000',
				'infinite_loop' 			=> '',
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
	static $team_id = 1;
	$extra_class = '';
	
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
	 * Team Query Args
	 */
	 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	 
	$args = array(
		'post_type' 		=> 'tpath_team_member',
		'posts_per_page' 	=> $posts,
		'paged' 			=> $paged,
		'orderby' 		 	=> 'date',
		'order' 		 	=> 'DESC',
	);
		
	if( ! ( $categories == 'all' ) ) {
		
		$category_id = (int)$categories;
		
		$args['tax_query'] = array( array(
								'taxonomy' 	=> 'team_member_categories',
								'field' 	=> 'id',
								'terms' 	=> $category_id
							) );
	}	
		
	$team_query = new WP_Query( $args );
	
	// Classes
	$main_classes = '';
	if( isset( $team_style ) && $team_style != '' ) {
		$main_classes .= ' team-' . $team_style;
	}
	if( isset( $team_type ) && $team_type != '' ) {
		$main_classes .= ' team-type-' . $team_type;
	}		
												
	if( $team_query->have_posts() ) {
	
		if( isset( $team_type ) && $team_type == 'slider' ) {
			$output = '<div class="tpath-team-slider-wrapper'.$main_classes.'">';
			$output .= '<div id="tpath-team-slider'.$team_id.'" class="tpath-owl-carousel owl-carousel team-carousel-slider"'.$data_attr.'>';
		} else {
			$output = '<div class="tpath-team-grid-wrapper'.$main_classes.'">';
			$output .= '<div id="tpath-team-grid'.$team_id.'" class="row tpath-grid-inner team-columns-'.$columns.'">';
			
			if( $columns == "2" ) {
				$extra_class = " col-md-6 col-xs-12";
			} elseif( $columns == "3" ) {
				$extra_class = " col-md-4 col-xs-12";
			} elseif( $columns == "4" ) {
				$extra_class = " col-md-3 col-xs-12";
			}
		}	
		
		while ($team_query->have_posts()) : $team_query->the_post();
		
			$team_img = '';
			
			if( isset( $team_style ) && $team_style == 'style3' ) {
				$team_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'team' );
			} else {
				$team_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'team-vertical' );
			}
			
			$member_designation 	= get_post_meta( $post->ID, 'tpath_member_designation', true );
			$member_overview 		= get_post_meta( $post->ID, 'tpath_member_overview', true );
			
			$output .= '<div class="team-item'.$extra_class.'">';
			$output .= '<div class="team-item-wrapper">';
			
				$output .= '<div class="team-image-wrapper">';
				if( isset( $team_img ) && $team_img != '' ) {
					$output .= '<div class="team-item-img">';
						$output .= '<img src="'.esc_url($team_img[0]).'" width="'.esc_attr($team_img[1]).'" height="'.esc_attr($team_img[2]).'" alt="'.get_the_title().'" class="img-responsive" />';
					$output .= '</div>';
				}
				$output .= '</div>';
				
				$output .= '<div class="team-content-wrapper">';
					if( isset( $team_style ) && $team_style == 'style1' ) {
						$output .= '<h5 class="team-member-name"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a><span class="team-sep">/</span><span class="team-member-designation">'.$member_designation.'</span></h5>';
					} else {
						$output .= '<h5 class="team-member-name"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h5>';
						$output .= '<p><span class="team-member-designation">'.$member_designation.'</span></p>';
					}
					
					if( isset( $team_style ) && $team_style == 'style3' ) {
						if( isset( $member_overview ) && $member_overview != '' ) {
							$output .= '<div class="team-member-overview">'.do_shortcode( $member_overview ).'</div>';
						}
					}
					$output .= '<div class="team-member-btn"><a class="btn btn_trans_themecolor" href="'. get_permalink() .'" title="'. get_the_title() .'">'. $btn_txt .'</a></div>';
				$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

		endwhile;
	
		$output .= '</div>';
		
		if( isset( $team_type ) && $team_type == 'grid' ) {
			if( isset( $show_pagination ) && $show_pagination == 'yes' ) {
				$output .= justice_pagination( $team_query->max_num_pages, $range = 2, '' );
			}
		}
			
		$output .= '</div>';
		
	}
	
	$team_id++;
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'tpath_vc_team', 'tpath_vc_team_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_team_map() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Team', 'Templatepath' ),
			"base" 			=> 'tpath_vc_team',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),		
			"params" 		=> array(
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Team Type", "Templatepath" ),
					"param_name" 	=> "team_type",
					"admin_label" 	=> true,
					"value" 		=> array_flip(array(
									'grid' 		 => 'Grid',
									'slider' 	 => 'Slider',									
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Team Columns", "Templatepath"),
					"param_name" 	=> "columns",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'grid'
					),
					"value" 		=> array_flip(array(
									'2' 	=> '2 Columns',
									'3'  	=> '3 Columns',
									'4' 	=> '4 Columns',
									)),
					"description" 	=> ''
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Team Style", "Templatepath" ),
					"param_name" 	=> "team_style",
					"admin_label" 	=> true,
					"value" 		=> array_flip(array(
									'style1' 		=> 'Style 1',
									'style2' 	 	=> 'Style 2',
									'style3' 		=> 'Style 3',
									)),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("How Many Posts to Show?", "Templatepath"),
					"param_name" 	=> "posts",
					"admin_label" 	=> true,
					"value" 		=> "3",
					"description" 	=> ""
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show Pagination", "Templatepath" ),
					"param_name" 	=> "show_pagination",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'grid'
					),
					"value" 		=> array_flip(array(
									'no' 		=> 'No',
									'yes' 	 	=> 'Yes',
									)),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Button Text", "Templatepath"),
					"param_name" 	=> "btn_txt",
					"value" 		=> "",
				),
				// Slider
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items to Display", "Templatepath" ),
					"param_name"	=> "items",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items to Scrollby", "Templatepath" ),
					"param_name"	=> "items_scroll",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Auto Play", 'Templatepath' ),
					'param_name'	=> "auto_play",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),		
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
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
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
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display in Tablet", "Templatepath" ),
					"param_name"	=> "items_tablet",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display In Mobile Landscape", "Templatepath" ),
					"param_name"	=> "items_mobile_landscape",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Display In Mobile Portrait", "Templatepath" ),
					"param_name"	=> "items_mobile_portrait",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Navigation", "Templatepath" ),
					"param_name"	=> "navigation",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false" ),
					"group"			=> __( "Slider", "Templatepath" ),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Pagination", "Templatepath" ),
					"param_name"	=> "pagination",
					'dependency'	=> array(
						'element'	=> "team_type",
						'value'		=> 'slider'
					),
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "true",
						__( "No", "Templatepath" )	=> "false" ),
					"group"			=> __( "Slider", "Templatepath" ),
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'tpath_vc_team_map');