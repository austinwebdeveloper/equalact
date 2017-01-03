<?php global $post, $tpath_options;
$object_id = get_queried_object_id();

if( ( get_option('show_on_front') && get_option('page_for_posts') && is_home() ) || 
( get_option('page_for_posts') && is_archive() && ! is_post_type_archive() ) && 
!( is_tax('product_cat') || is_tax('product_tag') ) || 
( get_option('page_for_posts') && is_search() ) ) {

	$post_id = get_option('page_for_posts');		
} else {
	if( isset($object_id) ) {
		$post_id = $object_id;
	}

	if( class_exists('Woocommerce') ) {
		if( is_shop() ) {
			$post_id = get_option('woocommerce_shop_page_id');
		}
	}
	if ( ! is_singular() ) {
		$post_id = false;
	}
}

$hide_title_bar 	= get_post_meta( $post_id, 'tpath_hide_page_title_bar', true );
$show_title 		= get_post_meta( $post_id, 'tpath_show_page_title', true );
$show_breadcrumbs 	= get_post_meta( $post_id, 'tpath_show_breadcrumbs', true );
$header_image 		= get_post_meta( $post_id, 'tpath_page_header_image', true );

if( isset( $show_breadcrumbs ) && $show_breadcrumbs == '' ) {	
	$show_breadcrumbs = 'yes';
}

if( class_exists('Woocommerce') ) {
	if( is_product_category() || is_product_tag() ) {
		$header_image = $tpath_options['tpath_woo_archive_image'];
	}
}	

$extra_style = '';
if( isset($header_image) && $header_image != '' ) {
	$extra_style = " style='background-image: url(". esc_url( $header_image ) .");'";
}

$title = '';
$title = get_the_title();

if( is_home() ) {
	$title = $tpath_options['tpath_blog_title'];
}

if( is_search() ) {
	$title = __( 'Search results for:', 'Templatepath' ) . ' ' . get_search_query();
}

if( is_404() ) {
	$title = __('Error 404 Page', 'Templatepath');
}

if( ( class_exists( 'TribeEvents' ) && tribe_is_event() && ! is_single() && ! is_home() ) ||
	( class_exists( 'TribeEvents' ) && is_events_archive() ) ||
	( class_exists( 'TribeEvents' ) && is_events_archive() && is_404() ) ) { 
	$title = tribe_get_events_title();	
}

if( is_archive() && ! ( class_exists('bbPress') && is_bbpress() ) && ! is_search() ) {
	if ( is_day() ) {
		$title = __( 'Daily Archives:', 'Templatepath' ) . '<span> ' . get_the_date() . '</span>';
	} else if ( is_month() ) {
		$title = __( 'Monthly Archives:', 'Templatepath' ) . '<span> ' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Templatepath' ) ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives:', 'Templatepath' ) . '<span> ' . get_the_date( _x( 'Y', 'yearly archives date format', 'Templatepath' ) ) . '</span>';
	} elseif ( is_author() ) {
		$current_auth = get_user_by( 'id', get_query_var( 'author' ) );
		$title = $current_auth->nickname;
	} elseif( is_post_type_archive() ) {				
		$title = post_type_archive_title( '', false );
		
		$sermon_settings = get_option('wpfc_options');
		if( is_array( $sermon_settings ) ) {
			$title = $sermon_settings['archive_title'];
		}				
	} else {
		$title = single_cat_title( '', false );
	}
}

if( class_exists('Woocommerce') && is_woocommerce() && ( is_product() || is_shop() ) && ! is_search() ) {
	if( ! is_product() ) {
		$title = woocommerce_page_title( false );
	}
}

if( ! is_archive() && ! is_search() && ! ( is_home() && ! is_front_page() ) ) {
	if ( $hide_title_bar != 'yes' ) {
		if( $show_title == 'no' ) {
			$title = '';
		}
	}
} 
else {
	if ( $hide_title_bar != 'yes' ) {
		if( $show_title == 'no' ) {
			$title = '';
		}				
	}
}
		
$output_title_bar = '';
if( ! is_archive() && ! is_search() && ! ( is_home() && ! is_front_page() ) ) {
	if ( $show_title != 'no' && $hide_title_bar != 'yes' ) {
		if( is_home() && is_front_page() && ! $tpath_options['tpath_blog_page_title_bar'] ) {
			$output_title_bar = 'no';
		} else {
			$output_title_bar = 'yes';
		}
	}
} else {

	if( is_home() && ! $tpath_options['tpath_blog_page_title_bar'] ) {
		$output_title_bar = 'no';
	} else {	
		if( $hide_title_bar != 'yes' ) {
			$output_title_bar = 'yes';
		}
	}
}

if( isset( $output_title_bar ) && $output_title_bar == 'yes' ) { ?>
<div class="page-title-section"<?php echo esc_attr( $extra_style ); ?>>
	<div class="page-title-wrapper clearfix">
		<div class="container page-title-container">
			<div class="page-title-header">
				<?php if( isset( $title ) && $title != '' ) { ?>
					<?php echo sprintf( '<h1 class="entry-title">%s</h1>', $title ); ?>
				<?php } ?>
			</div>
						
			<?php if( isset( $show_breadcrumbs ) && $show_breadcrumbs == 'yes' ) { ?>
				<div class="page-breadcrumbs">
					<?php justice_breadcrumbs(); ?>
				</div>			
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>