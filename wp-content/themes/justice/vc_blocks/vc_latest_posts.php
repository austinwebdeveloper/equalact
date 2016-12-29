<?php 
/**
 * Latest Posts shortcode
 */

function tpath_latest_posts_shortcode( $atts ) {
		
	$atts = vc_map_get_attributes( 'tpath_vc_latest_posts', $atts );
	extract( $atts );

	$output = '';
	global $post, $tpath_options;
	
	// Include categories
	$include_categories = ( '' != $include_categories ) ? $include_categories : '';
	$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
	if( $include_categories ) {
		$include_categories = explode( ',', $include_categories );
		if ( ! empty( $include_categories ) && is_array( $include_categories ) ) {
			$include_categories = array(
				'taxonomy'	=> 'category',
				'field'		=> 'slug',
				'terms'		=> $include_categories,
				'operator'	=> 'IN',
			);
		} else {
			$include_categories = '';
		}
	}
				
	// Exclude categories
	if( $exclude_categories ) {
		$exclude_categories = explode( ',', $exclude_categories );
		if ( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
			$exclude_categories = array(
					'taxonomy'	=> 'category',
					'field'		=> 'slug',
					'terms'		=> $exclude_categories,
					'operator'	=> 'NOT IN',
				);
		} else {
			$exclude_categories = '';
		}
	}
			
	if( ( is_front_page() || is_home() ) ) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	
	$query_args = array(
					'posts_per_page'	=> $posts,
					'paged' 			=> $paged,
					'orderby' 		 	=> 'date',
					'order' 		 	=> 'DESC',
				  );
					  		
	$query_args['tax_query'] 	= array(
									'relation'	=> 'AND',
									$include_categories,
									$exclude_categories );
	
	$blog_query = new WP_Query( $query_args );
	
	$post_class = '';
	$excerpt_limit = '12';
	
	$date_format = '';
	$date_format = $tpath_options['tpath_blog_date_format'];
	
	// Classes
	$main_classes = '';
	
	if( isset( $classes ) && $classes != '' ) {
		$main_classes .= ' ' . $classes;
	}
		
	if( $blog_query->have_posts() ) {
		$output = '<div class="tpath-latest-posts-wrapper'.$main_classes.'">';
			$output .= '<div class="latest-posts-layout">';
			
			while($blog_query->have_posts()) : $blog_query->the_post();
			
				$post_id = get_the_ID();				
				$post_format = get_post_format();
	
				$output .= '<div id="post-'.$post_id.'" ';
				ob_start();
					post_class();
				$output .= ob_get_clean() .'>';
				
				$output .= '<div class="posts-inner-container clearfix">';
				
					if ( has_post_thumbnail() && ! post_password_required() ) {
						
						if( has_post_format('link') ) { 			
							$external_url = '';
							$external_url = get_post_meta( $post_id, 'tpath_external_link_url', true );
							if( isset( $external_url ) && $external_url == '' ) {
								$external_url = get_permalink( $post_id );
							}

							$output .= '<div class="entry-thumbnail">';
								$output .= '<a href="'. esc_url($external_url) .'" title="'. get_the_title() .'" class="post-img">'. get_the_post_thumbnail( $post_id, 'theme-mid' ) .'</a>';
								$output .= '</div>';
							$output .= '</div>';
						}
						
						else {
							$output .= '<div class="entry-thumbnail">';
								$output .= '<a href="'. get_permalink($post_id) .'" class="post-img" title="'. get_the_title() .'">'. get_the_post_thumbnail( $post_id, 'theme-mid' ) .'</a>';
							$output .= '</div>';
						}

					}
					
					$output .= '<div class="posts-content-container">';
						$output .= '<div class="entry-header">';
							$output .= '<h2 class="entry-title">';
								$output .= '<a href="'. get_permalink($post_id) .'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a>';
							$output .= '</h2>';
						$output .= '</div>';
						
						if( $posted_date == 'yes' ) {
							$output .= '<div class="entry-meta-wrapper">';							
							$output .= '<ul class="entry-meta">';
								$output .= '<li class="posted-date">' .get_the_time( $date_format ).'</li>';
							$output .= '</ul>';
							$output .= '</div>';
						}
																		
						$output .= '<div class="entry-summary">';
							$output .= '<p>'. justice_custom_excerpts($excerpt_limit) .'</p>';
						$output .= '</div>';
						
						if( $read_more == 'yes' ) {
							if( ! $tpath_options['tpath_blog_read_more_text'] ) {
								$more_text = esc_html__('Read more', 'Templatepath'); 
							} else { 
								$more_text = $tpath_options['tpath_blog_read_more_text'];
							}
							$output .= '<div class="read-more"><a href="'. get_permalink($post_id) .'" class="read-more-link" title="'. get_the_title() .'">'.$more_text.'</a></div>';
						}
						
					$output .= '</div>';
					
				$output .= '</div>';
				$output .= '</div>';
			endwhile;
			
		$output .= '</div>';
		$output .= '</div>';
		
	}
	
	wp_reset_postdata();
	
	return $output;
	
}
add_shortcode( 'tpath_vc_latest_posts', 'tpath_latest_posts_shortcode' );

/**
 * The VC Element Config Functions
 */ 
function tpath_vc_latest_posts_shortcode() {
		
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Latest Posts', 'Templatepath' ),
			"base" 			=> 'tpath_vc_latest_posts',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),	
			"params"				=> array(					
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Extra Class', "Templatepath" ),
					'param_name'	=> 'classes',
					'value' 		=> '',
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Posts to Show?", "Templatepath" ),
					"admin_label" 	=> true,
					"param_name"	=> "posts",						
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Include Categories', 'Templatepath' ),
					'param_name'	=> 'include_categories',
					'admin_label'	=> true,
					'description'	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','Templatepath'),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Exclude Categories', 'Templatepath' ),
					'param_name'	=> 'exclude_categories',
					'admin_label'	=> true,
					'description'	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','Templatepath'),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Show Posted Date", "Templatepath" ),
					"param_name"	=> "posted_date",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "yes",
						__( "No", "Templatepath" )	=> "no" ),
				),
				array(
					"type"			=> 'dropdown',
					"heading"		=> __( "Show Read More Link", "Templatepath" ),
					"param_name"	=> "read_more",
					"value"			=> array(
						__( "Yes", "Templatepath" )	=> "yes",
						__( "No", "Templatepath" )	=> "no" ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_latest_posts_shortcode' );