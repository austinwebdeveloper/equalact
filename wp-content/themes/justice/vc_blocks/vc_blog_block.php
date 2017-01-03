<?php 
/**
 * The Shortcode
 */
function tpath_blog_posts_shortcode( $atts ) {
	
	$output = $posts = $layout = $thumbnail = $readmore = $pagination = $grid_columns = $grid_color = $author_image = '';
	
	extract( 
		shortcode_atts( 
			array(
				'posts' 			=> '6',
				'layout' 			=> 'large',				
				'pagination' 		=> 'hide',
				'list_fullwidth' 	=> 'no',
				'grid_columns' 		=> 'two',
				'author_image'		=> ''
			), $atts 
		) 
	);
	
	global $tpath_options, $post;
		
	if( ( is_front_page() || is_home() ) ) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	
	/**
	 * Posts Query Args
	 */
	$args = array(
				'posts_per_page' 		=> $posts,
				'orderby' 		 		=> 'date',
				'order' 		 		=> 'DESC',
				'paged' 				=> $paged,
			);
		
	$post_class = '';
	$image_size = '';
	$container_class = '';
	$container_id = '';
	$excerpt_limit = '';
	
	if( $pagination == 'infinite' ) {
		$container_id = "tpath-posts-infinite-container";
		$container_class = "tpath-posts-container ";
	} else {
		$container_id = "vc-posts-container";
		$container_class = "tpath-posts-container ";
	}
	
	if($layout == 'large') {
		$post_class = 'large-posts';
		$image_size = 'blog-large';
		$container_class .= 'large-layout';
		$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_large'];
	} elseif($layout == 'list') {
		$post_class = 'list-posts';
		$image_size = 'blog-list';
		$container_class .= 'list-layout';
		$excerpt_limit = 20;
		if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
			$container_class .= ' list-columns';
		} else {
			$container_class .= ' list-fullwidth';
		}
	} elseif($layout == 'grid') {
		$post_class = 'grid-posts';
		$image_size = 'theme-mid';
		$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_grid'];
		
		if($grid_columns == 'two' ) {
			$container_class .= 'grid-layout grid-col-2';
		} elseif($grid_columns == 'three') {
			$container_class .= 'grid-layout grid-col-3';
		} elseif( $grid_columns == 'four' ) {
			$container_class .= 'grid-layout grid-col-4';
		}
	}
		
	$blog_query = new WP_Query( $args );
											
	if( $blog_query->have_posts() ) {
	
		$output .= '<div id="'.$container_id.'" class="'.$container_class.' clearfix">';
					
			while($blog_query->have_posts()) : $blog_query->the_post();
			
				$post_id = get_the_ID();
				$post_format = get_post_format();
				
				$post_format_class = '';
				if( $post_format == 'image' ) {
					$post_format_class = ' image-format';
				} elseif( $post_format == 'quote' ) {
					$post_format_class = ' quote-image';
				}
				
				$output .= '<article id="post-'.$post_id.'" ';
				ob_start();
					post_class($post_class);
				$output .= ob_get_clean() .'>';
				
				$output .= '<div class="posts-inner-container clearfix">';
					$output .= '<div class="posts-content-container">';
						if( $layout == 'list' || $layout == 'grid' ) {
							ob_start();
							include( locate_template('partials/content-list.php') );
							$output .= ob_get_clean();
						} elseif($layout == 'large') {
							ob_start();
							include( locate_template('partials/content-large.php') );
							$output .= ob_get_clean();
						}
					$output .= '</div>';
				$output .= '</div>';
							
				$output .= '</article>';

			endwhile;
	
		$output .= '</div>';
		
		if( $pagination != 'hide' ) {
			$output .= justice_pagination( $blog_query->max_num_pages, $range = 2, $pagination );
		}
	}
	
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'tpath_vc_blog', 'tpath_blog_posts_shortcode' );

/**
 * The VC Element Config Functions
 */
function tpath_vc_blog_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Blog', 'Templatepath' ),
			"base" 			=> 'tpath_vc_blog',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),			
			"params" 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Posts per Page", "Templatepath"),
					"param_name" 	=> "posts",
					"admin_label" 	=> true,
					"value" 		=> "6",
					"description" 	=> ""
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Blog Layout", "Templatepath" ),
					"param_name" 	=> "layout",
					"admin_label" 	=> true,
					"value" 		=> array_flip(array(
									'large' => 'Large Posts',
									'list' 	=> 'List Posts',
									'grid'  => 'Grid Posts'
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Pagination", "Templatepath" ),
					"param_name" 	=> "pagination",
					"value" 		=> array_flip(array(
									'hide' 			=> 'Hide',
									'pagination' 	=> 'Pagination',
									'infinite'  	=> 'Infinite Scroll'
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show List Layout in Fullwidth ?", "Templatepath" ),
					"param_name" 	=> "list_fullwidth",
					"value" 		=> array_flip(array(
									'no' 	=> 'No',
									'yes' 	=> 'Yes'									
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Number of Columns for Grid Layout", "Templatepath" ),
					"param_name" 	=> "grid_columns",
					"value" 		=> array_flip(array(
									'two' 		=> '2 Columns',
									'three'  	=> '3 Columns',
									'four'  	=> '4 Columns'
									)),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show Author Image", "Templatepath" ),
					"param_name" 	=> "author_image",
					"value" 		=> array_flip(array(
									'no' 	=> 'No',
									'yes' 	=> 'Yes'									
									)),
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'tpath_vc_blog_shortcode');