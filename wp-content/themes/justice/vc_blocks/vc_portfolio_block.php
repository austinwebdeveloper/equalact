<?php 
/**
 * The Shortcode 
 */

function tpath_portfolio_gallery_shortcode( $atts ) {	

	$output = $title = $posts = $columns = $gutter = $show_filter = $show_pagination = $categories = $alignment = '';	

	extract( 
		shortcode_atts( 
			array(				
				'posts' 			=> '8',
				'columns' 			=> '4',
				'gutter' 			=> '30',
				'show_filter' 		=> 'hide',
				'show_pagination' 	=> 'Yes',
				'categories' 		=> 'all',
				'alignment' 		=> 'all',
			), $atts
		)
	);	

	global $post;
	
	/**
	 * Portfolio Query Args
	 */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	

	$args = array(
		'post_type' 		=> 'tpath_portfolio',
		'posts_per_page' 	=> $posts,
		'paged' 			=> $paged,
	);
	
	if( isset( $show_filter  ) && $show_filter  != '' ) {
		$filter_type = $show_filter;
	} else {
		$filter_type= $show_filter;
	}
	if( ! ( $categories == 'all' ) ) {		

		$category_id = (int)$categories;	

		$args['tax_query'] = array( array(
								'taxonomy' 	=> 'portfolio_categories',
								'field' 	=> 'id',
								'terms' 	=> $category_id
							) );
	}

	$portfolio_query = new WP_Query( $args );

	if ( $portfolio_query->have_posts() ) {

		$portfolio_tags = get_terms('portfolio_categories');

		$output = '<div class="portfolio-gallery-wrapper">';	
			$output .= '<div class="tpath-portfolio portfolio-columns-'.$columns.'" data-columns="'.$columns.'" data-gutter="'.$gutter.'">';	
			
			if( is_array($portfolio_tags) && ! empty($portfolio_tags) && $show_filter != 'hide' && $categories == 'all' ) {
				$output .= '<div class="container">';
					$output .= '<div class="portfolio-top-wrapper">';
						$output .= '<ul class="portfolio-tabs list-inline '.esc_attr( $filter_type ).'">';
						$output .= '<li><a class="active" data-filter="*" href="#">'. esc_html__('All', 'Templatepath') .'</a></li>';
							foreach( $portfolio_tags as $tags ) {
								$output .= '<li><a data-filter=".'.$tags->slug.'" href="#">'. $tags->name .'</a></li>';
							}
						$output .= '</ul>';
					$output .= '</div>';
				$output .= '</div>';
			}

			$output .= '<div class="portfolio-container">';	

				while($portfolio_query->have_posts()) : $portfolio_query->the_post();		

				$portfolio_img = $portfolio_img_large = '';
				$portfolio_img_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$portfolio_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'theme-mid' );		

				$item_classes = '';
				$item_tags = get_the_terms($post->ID, 'portfolio_categories');
				if( $item_tags ) {
					foreach( $item_tags as $item_tag ) {
						$item_classes .=  ' ' . urldecode($item_tag->slug);
					}
				}
				$output .= '<div id="portfolio-'.get_the_ID().'" class="portfolio-item'.$item_classes.'">';
					$output .= '<div class="portfolio-image">';
						$output .= '<a href="'.esc_url( $portfolio_img_large[0] ).'" data-rel="prettyPhoto[portfolio]" title="'.get_the_title().'">';
						$output .= '<img class="img-responsive" src="'. esc_url( $portfolio_img[0] ).'" alt="'.get_the_title().'" />';
						$output .= '</a>';
					$output .= '</div>';

					$output .= '<div class="portfolio-content text-'.esc_attr( $alignment ).'">';
						$output .= '<div class="portfolio-top">';
							$output .= '<h4 class="portfolio-title"><a href="'. get_permalink() .'" title="'.get_the_title().'">'.get_the_title().'</a>';
							$output .= '</h4>';
						$output .= '</div>';

						$output .= '<div class="portfolio-excerpt">';
							$output .= justice_custom_wp_trim_excerpt('', 20);
						$output .= '</div>';

					$output .= '</div>';
				$output .= '</div>';

				endwhile;

			$output .= '</div>';	

			$output .= '</div>';
		$output .= '</div>';

		if( isset( $show_pagination ) && $show_pagination == 'Yes' ) {
			$output .= justice_pagination( $portfolio_query->max_num_pages, $range = 2, '' );
		}	

	}

	wp_reset_postdata();

	return $output;
}

add_shortcode( 'tpath_vc_portfolio', 'tpath_portfolio_gallery_shortcode' );

/**
 * The VC Element Config Functions
 */

function tpath_vc_portfolio_shortcode() {

	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __( 'Portfolio', 'Templatepath' ),
			"base" 			=> 'tpath_vc_portfolio',
			"category" 		=> __( 'Theme Addons', 'Templatepath' ),
			"params" 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("How Many Posts to Show?", "Templatepath"),
					"param_name" 	=> "posts",
					"value" 		=> '8',
					"description" 	=> ''
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Portfolio Columns", "Templatepath"),
					"param_name" 	=> "columns",
					"admin_label" 	=> true,
					"value" 		=> array_flip(array(
									'2' 	=> '2 Columns',
									'3'  	=> '3 Columns',
									'4' 	=> '4 Columns',
									)),
					"description" 	=> ''
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Items Spacing (without px)", "Templatepath"),
					"param_name" 	=> "gutter",
					"value" 		=> '30',
					"description" 	=> ''
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Filters Type", "Templatepath"),
					"param_name" 	=> "show_filter",
					"value" 		=> array_flip(array(
									'hide' 			 => 'Hide',
									'style1-box' 	 => 'Style 1 : Boxed',
									'style2-sep' 	 => 'Style 2 : Seperator',
									)),
					"description" => ''
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Show Pagination", "Templatepath"),
					"param_name" 	=> "show_pagination",
					"value" 		=> array(
										'Yes',
										'No'
									),
					"description" => ''
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
				),
			)
		) 
	);	

}
add_action( 'vc_before_init', 'tpath_vc_portfolio_shortcode');