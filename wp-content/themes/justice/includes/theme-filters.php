<?php
/**
* Filters and Actions
*/

// Theme Setup
add_action( 'after_setup_theme', 'justice_setup' );
// Admin Theme Activation Hook
add_action( 'admin_init', 'justice_theme_activation' );
// Add layout extra classes to body_class output
add_filter( 'body_class', 'justice_layout_body_class', 10 );
// Add custom meta tags to the <head>
add_action( 'wp_head', 'justice_meta_tags', 10 );
// Custom Css from Theme Option
add_action( 'wp_head', 'justice_enqueue_custom_styling' );
// Add Custom Visual Composer CSS for Block
add_action( 'wp_head', 'justice_vc_addfrontcss', 1000 );
// Load Theme Stylesheet and Jquery only on Frontend
if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'justice_load_theme_scripts', 20 );
}
// Store Ajax URL
add_action( 'wp_head', 'justice_ajaxurl' );
// Dynamic JS from Theme Option
add_action( 'wp_head', 'justice_enqueue_dynamic_js' );
// Custom Excerpt Length and Custom More Excerpt
add_filter( 'excerpt_length', 'justice_custom_excerpt_length', 999 );
add_filter( 'excerpt_more', 'justice_custom_excerpt_more' );

/* ======================================
 * Theme Setup
 * ====================================== */
 
/* Set the content width based on the theme's design and stylesheet. */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */

if ( ! function_exists( 'justice_setup' ) ) {
	function justice_setup () {
	
		// load textdomain
    	load_theme_textdomain('Templatepath', get_template_directory() . '/languages');
		
		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( 'css/editor-style.css' );
			
		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		add_image_size('blog-large', 1000, 490, true);
		add_image_size('blog-list', 560, 498, true);
		add_image_size('team', 500, 500, true);
		add_image_size('team-vertical', 600, 800, true);
		add_image_size('theme-mid', 700, 470, true);		
		
		// Theme Support for Title Tag
		add_theme_support( 'title-tag' );
	
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// Add Woocommerce Support
		add_theme_support( 'woocommerce' );
		
		// Register Nav Menus
		if ( function_exists('wp_nav_menu') ) {
			add_theme_support( 'nav-menus' );
			register_nav_menus( array(
				'tpath-top' 			=> __( 'Top Menu' , 'Templatepath' ),
				'tpath-primary' 		=> __( 'Primary Menu' , 'Templatepath' ),
				'tpath-primary-right' 	=> __( 'Primary Right Menu' , 'Templatepath' ),
			) );
		}
		
		/*
		 * Switches default core markup for galleries to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'gallery', 'caption'	) );
		
		// Add Posts Format Support
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'video', 'audio' ) );
		
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
		
	} // End justice_setup()
}

/* ======================================
 * Admin Theme Activation Hook
 * ====================================== */
if ( ! function_exists( 'justice_theme_activation' ) ) {
	function justice_theme_activation() {
	
		global $pagenow;
		
		if( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			update_option( 'shop_catalog_image_size', array( 'width' => 500, 'height' => 335, 1 ) );
		}
		
	}
}

/* ======================================
 * Add layout to body_class output
 * ====================================== */
if ( ! function_exists( 'justice_layout_body_class' ) ) {

	function justice_layout_body_class( $classes ) {
	
		global $post, $wp_query, $tpath_options;

		$layout = $blog_type = $theme_class = $footer_layout = $logo_align = '';
		
		// Set Column Layout from singular posts
		if( is_singular() ) {
			$layout = get_post_meta( $post->ID, 'tpath_layout', true );			
		}
		
		if( class_exists('Woocommerce') ) {
			if( is_shop() ) {
				$shop_page_id = get_option('woocommerce_shop_page_id');
				if( is_object( $post ) ) {
					$layout = get_post_meta( $shop_page_id, 'tpath_layout', true );
				}
			} 
			
			else if( is_product_category() || is_product_tag() ) {
				$layout = 'two-col-right';				
			}
		}
		
		else if( is_archive() ) {
			$layout = $tpath_options['tpath_blog_archive_layout'];
			$blog_type = 'blog-' . $tpath_options['tpath_archive_blog_type'];
		}
		
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			$layout = get_post_meta( $home_id, 'tpath_layout', true );
			if( !$layout ) {
				$layout = $tpath_options['tpath_blog_layout'];
			}
			$blog_type = 'blog-' . $tpath_options['tpath_blog_type'];
		}
		
		if( class_exists('Woocommerce') ) {
			if( is_product() ) {				
				$layout = 'two-col-right';				
			}
			if( is_singular('tpath_portfolio') ) {
				$layout = $tpath_options['tpath_layout'];
			}
			if( is_singular() && is_single() ) {
				if( is_singular( 'post' ) ) {
					$layout = get_post_meta( $post->ID, 'tpath_layout', true );
					if( !$layout ) {
						$layout = $tpath_options['tpath_single_post_layout'];
					}
				} else if( !$layout ) {
					$layout = get_post_meta( $post->ID, 'tpath_layout', true );
				}			
			}
		}
		else if( is_singular('tpath_portfolio') ) {
			$layout = $tpath_options['tpath_layout'];
		}
		else if( is_singular() && is_single() ) {
			if( is_singular( 'post' ) ) {
				$layout = get_post_meta( $post->ID, 'tpath_layout', true );
				if( !$layout ) {
					$layout = $tpath_options['tpath_single_post_layout'];
				}
			} else if( !$layout ) {
				$layout = get_post_meta( $post->ID, 'tpath_layout', true );
			}			
		}
				
		// If Singular posts value empty set theme option value		
		if( !$layout ) {			
			if( $tpath_options['tpath_layout'] != '' ) {		
				$layout = $tpath_options['tpath_layout'];
			}
			else {
				$layout = 'one-col';
			}
		}
				
		// Theme Layout
		if( is_singular() ) {
			$theme_class = get_post_meta( $post->ID, 'tpath_theme_layout', true );			
		}
		
		if( $theme_class == '' || $theme_class == 'default' ) {		
			if( $tpath_options['tpath_theme_layout'] != '' ) {
				$theme_class = $tpath_options['tpath_theme_layout'];
			} else {
				$theme_class = 'boxed';
			}
		}
		
		$classes[] = $theme_class;
		
		// Blog Type
		$classes[] = $blog_type;
								
		// Add classes to body_class() output 
		$classes[] = $layout;
		return $classes;
		
	} // End justice_layout_body_class()
	
}

/* ======================================
 * Print custom meta tags
 * ====================================== */
if ( ! function_exists( 'justice_meta_tags' ) ) {

	function justice_meta_tags() {
	
		global $tpath_options;
				
		if( isset($tpath_options['tpath_enable_responsive']) ) {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />' . "\n";
		}
				
		if( isset( $tpath_options['tpath_favicon'] ) && $tpath_options['tpath_favicon'] != '' ) {
			echo '<link rel="shortcut icon" href="'. esc_url( $tpath_options['tpath_favicon'] ) .'" type="image/x-icon" />' . "\n";
		}
		
		// iPhone Icon
		if( isset( $tpath_options['tpath_apple_iphone_icon'] ) && $tpath_options['tpath_apple_iphone_icon'] != '' ) {
			echo '<link rel="apple-touch-icon" href="'. esc_url( $tpath_options['tpath_apple_iphone_icon'] ) .'">' . "\n";
		}
		// iPhone Retina Display Icon
		if( isset( $tpath_options['tpath_apple_iphone_retina_icon'] ) && $tpath_options['tpath_apple_iphone_retina_icon'] != '') {
			echo '<link rel="apple-touch-icon" sizes="114x114" href="'. esc_url( $tpath_options['tpath_apple_iphone_retina_icon'] ) .'">' . "\n";
		}
		// iPad Icon	
		if( isset( $tpath_options['tpath_apple_iphone_retina_icon'] ) && $tpath_options['tpath_apple_ipad_icon'] != '' ) {
			echo '<link rel="apple-touch-icon" sizes="72x72" href="'. esc_url( $tpath_options['tpath_apple_ipad_icon'] ) .'">' . "\n";
		}
		// iPad Retina Display Icon
		if( isset( $tpath_options['tpath_apple_iphone_retina_icon'] ) && $tpath_options['tpath_apple_ipad_retina_icon'] != '' ) {
			echo '<link rel="apple-touch-icon" sizes="144x144" href="'. esc_url( $tpath_options['tpath_apple_ipad_retina_icon'] ) .'">' . "\n";
		}
		
	} // End justice_meta_tags()
	
}

/* ======================================
 * Enqueue Custom Styling
 * ====================================== */

if ( ! function_exists( 'justice_enqueue_custom_styling' ) ) {

	function justice_enqueue_custom_styling () {
		echo '<!-- Custom CSS -->'. "\n";
		echo '<style type="text/css">' . "\n";
		echo justice_custom_styles();
		echo '</style>' . "\n";
	} // End justice_enqueue_custom_styling()
	
}

/* ==============================================
 * Visual Composer Front CSS for Block Post Type
 * ============================================== */

function justice_vc_addfrontcss( $id = null ) {

	global $post;

	if ( ! is_singular() ) {
		return;
	}
	if ( ! $id ) {
		$id = get_the_ID();
	}

	if ( $id ) {
		$additional_block_id = get_post_meta( $id, 'tpath_additional_content_block', true );
		
		if( isset( $additional_block_id ) && ( $additional_block_id != '' && $additional_block_id != 0 ) ) {
			
			$args = array(
				'post_type'  		=> 'tpath_block',
				'post__in'   		=> array( $additional_block_id )
		    );
			
			$block_query = new WP_Query($args);
			
			if( $block_query->have_posts() ) { 
				while ($block_query->have_posts()) {
					$block_query->the_post();
					
					$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
					if ( ! empty( $shortcodes_custom_css ) ) {
						echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
						echo $shortcodes_custom_css;
						echo '</style>';
					}
				}
			}
			
			wp_reset_postdata();
			
		}
	}
}

/* ======================================
 * Add theme custom styles 
 * ====================================== */
if ( ! function_exists( 'justice_custom_styles' ) ) {

	function justice_custom_styles() {
		global $tpath_options, $post;

		$output = '';
		
		// Custom CSS Code
		if( isset( $tpath_options['tpath_custom_css'] ) && $tpath_options['tpath_custom_css'] != '' ) {
			$output .= $tpath_options['tpath_custom_css'] . "\n";
		}
		
		// Custom Color Scheme Styles
		$color_scheme = '';
		if( isset( $tpath_options['tpath_custom_scheme_color'] ) && $tpath_options['tpath_custom_scheme_color'] != '' ) {
			$output .= 'a, .page-breadcrumbs ul li a:hover, .page-breadcrumbs ul li a:active, .page-breadcrumbs ul li a:focus, .btn.btn_trans_themecolor, .btn.btn_bgcolor:hover, .form-submit .submit:hover, .vc_general.vc_btn3.vc_btn3-color-primary-bg:hover, .vc_general.vc_btn3.vc_btn3-color-primary-bg:active, .vc_general.vc_btn3.vc_btn3-color-primary-bg:focus, .btn.btn_trans_white:hover, .btn.btn_trans_white:active, .btn.btn_trans_white:focus, .btn.btn-transparent-white:hover, .btn.btn-transparent-white:active, .btn.btn-transparent-white:focus, .nav.navbar-nav.tpath-main-nav a:hover, .nav.navbar-nav.tpath-main-nav a:focus, .nav.navbar-nav.tpath-main-nav a:active, .nav.navbar-nav.tpath-main-nav > li:hover > a, .nav.navbar-nav.tpath-main-nav li.active > a, .nav.navbar-nav.tpath-main-nav .current-menu-ancestor > a,  .nav.navbar-nav.tpath-main-nav .current-menu-ancestor .dropdown-menu .current-menu-item > a, .nav.navbar-nav .side-menu a:hover, .nav.navbar-nav .side-menu a:active, .nav.navbar-nav .side-menu a:focus, .link-url:hover, .link-url:hover a, .link-url a:hover, .nav.navbar-nav.tpath-main-nav .dropdown-menu .active > a, .nav.navbar-nav.tpath-main-nav .dropdown-menu a:hover, .nav.navbar-nav.tpath-main-nav .dropdown-menu .current-menu-parent > a, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu li.active > a, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:hover, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:active, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:focus, .header-top-section a:hover, .header-top-section a:focus, .header-top-section a:active, .tpath-listitem li:hover::before, .tpath-listitem.custom-icon li:hover:before, .tpath-feature-box-btn .btn.btn-no_border:hover, .tpath-feature-box .tpath-feature-icon i, .tpath-icons-box i, .portfolio-content .portfolio-title > a:hover, .portfolio-content .portfolio-title > a:active, .portfolio-content .portfolio-title > a:focus, .portfolio-gallery-wrapper .portfolio-tabs.style2-sep > li a.active, .btn.simple_text:hover, .btn.simple_text:active, .btn.simple_text:focus, .btn.btn-active:hover, .btn.btn-active:active, .btn.btn-active:focus, .vc-btn-active .vc_general.vc_btn3.vc_btn3-style-custom:hover, .vc-btn-active .vc_general.vc_btn3.vc_btn3-style-custom:active, .vc-btn-active .vc_general.vc_btn3.vc_btn3-style-custom:focus, .tpath-input-submit .btn.tpath-submit:hover, .tpath-input-submit .btn.tpath-submit:active, .tpath-input-submit .btn.tpath-submit:focus, .tp-caption.slider-btn .btn:hover, .tp-caption.slider-btn .btn:active, .tp-caption.slider-btn .btn:focus, .tp-caption.slider-btn .btn.btn-transparent-white:hover, .tp-caption.slider-btn .btn.btn-transparent-white:active, .tp-caption.slider-btn .btn.btn-transparent-white:focus, .tp-caption.slider-btn .btn.btn-transparent-color, .tpath-quote-box .author-title .author-designation, .team-style3 .team-item .team-member-designation, .team-style3 .team-item .team-content-wrapper .team-member-name a:hover, .team-style3 .team-item .team-content-wrapper .team-member-name a:active, .team-style3 .team-item .team-content-wrapper .team-member-name a:focus, .tpath-team-slider-wrapper .tpath-owl-carousel .owl-controls .owl-nav:hover .fa, .single-tpath_team_member .team-member-designation, .testimonial-info .author-designation, .clients-wrapper .owl-carousel.owl-theme .owl-controls .owl-nav div:hover i, .testimonial-carousel-slider.owl-carousel.owl-theme .owl-controls .owl-nav div:hover i, .tpath-social-share-box .tpath-social-share-icons li a:hover, .footer-widgets ul li:hover a, .footer-section a:hover, .footer-widgets h5, .tpath_contact_info_widget .contact_info-inner .fa, .tpath_contact_info_widget .contact_info-inner .simple-icon, .tpath-social-icons.widget-soc-icon li:hover a, .tpath-social-icons.widget-soc-icon li:hover a i, .sidebar .widget a:hover, .sidebar .widget li:hover a, .sidebar .widget li.posts-item h5 a:hover, .sidebar .widget li.posts-item h5 a:active, .sidebar .widget li.posts-item h5 a:focus, .sidebar .widget li:hover:before, .sidebar .contact_info-inner .fa, .sidebar .contact_info-inner .simple-icon, .post .entry-title a:hover, .post .entry-title a:active, .post .entry-title a:focus, .entry-footer .read-more .btn-more:hover, .large-posts .entry-header h3.entry-title:hover a, .tpath-posts-container .entry-footer .read-more .btn-more:hover, .has-post-thumbnail .posts-content-container .entry-thumbnail .owl-controls .owl-nav .fa, .comment-post-meta span a:hover, .vc_tta-accordion .vc_tta-panels-container .vc_tta-panel .vc_tta-panel-heading:hover a, .vc_tta-accordion .vc_tta-panels-container .vc_tta-panel .vc_tta-panel-heading:hover a .vc_tta-controls-icon:before, .vc_tta-accordion .vc_tta-panels-container .vc_tta-panel .vc_tta-panel-heading:hover a .vc_tta-controls-icon:after, .vc_tta-style-tpath_tour_design .vc_tta-tabs-list li.vc_tta-tab > a i, .vc_tta.vc_general .vc_tta-icon, .vc_general.vc_cta3.vc_cta3-style-default .vc_icon_element-icon { color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			// Border Color
			$output .= '.btn.btn_bgcolor, .form-submit .submit, .vc_general.vc_btn3.vc_btn3-color-primary-bg, .btn.btn_trans_themecolor, .tpath-listitem.custom-icon li:hover:before, .tpath-section-title.title-left_border .section-title, .testimonial-slider-wrapper.type-author_top .testimonial-info, .bg-style.primary-dark-color .vc_column_container.border-right_only, .portfolio-gallery-wrapper .portfolio-tabs.style1-box > li, .btn:hover, .btn:active, .btn:focus, .btn.btn-active, .btn.btn-style-2, .btn.btn-style-2:hover, .btn.btn-style-2:active, .btn.btn-style-2:focus, input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus, .wpcf7 input[type="submit"]:hover, .wpcf7 input[type="submit"]:active, .wpcf7 input[type="submit"]:focus, .tp-caption.slider-btn .btn, .tp-caption.slider-btn .btn.btn-transparent-color, .tpath-quote-box .author-title, .testimonial-slider-wrapper.type-default .client-author-info:before, .testimonial-carousel-slider.owl-carousel.owl-theme .owl-controls .owl-nav div:hover, .owl-carousel.owl-theme .owl-controls .owl-dot.active span, .tpath-social-share-box .tpath-social-share-icons li a, .tpath-social-icons.widget-soc-icon li:hover a, .sidebar .widget-title, .widget.widget_tag_cloud .tagcloud a:hover, .widget.widget_tag_cloud .tagcloud a:active, .widget.widget_tag_cloud .tagcloud a:focus, input[type="submit"], .wpcf7 input[type="submit"], .comment-post-meta span a, #main .vc_images_carousel .vc_carousel-indicators li, .vc_images_carousel .vc_carousel-indicators .vc_active { border-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			$output .= '.dropdown-menu { border-top-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			$output .= '.vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-left .vc_tta-tabs-list li.vc_tta-tab.vc_active > a, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-left .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:focus, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-left .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:hover, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-left .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:before, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-left .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:before { border-right-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			$output .= '.vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:focus, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:hover, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:before, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a:before, .vc_tta-container .vc_tta-style-tpath_tour_design.vc_tta-tabs-position-right .vc_tta-tabs-list li.vc_tta-tab.vc_active > a { border-left-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			$output .= '.sidebar .widget, .portfolio-gallery-wrapper .portfolio-section-title:after { border-bottom-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			// Background Color
			$output .= '#back-to-top, .btn.btn_bgcolor, .form-submit .submit, .vc_general.vc_btn3.vc_btn3-color-primary-bg, .nav.navbar-nav > li > a::before, .navbar-toggle, .flex-direction-nav a, .tpath-section-title.text-center::before, .tpath-social-icons li a:hover, .tpath-social-icons li a:active, .tpath-social-icons li a:focus, .tpath-counter-icon, .portfolio-gallery-wrapper .portfolio-tabs.style1-box > li a.active, .post-navigation .pager li a, .btn:hover, .btn:active, .btn:focus, .btn.btn-active, .btn.btn-style-2, .btn.btn-style-2:hover, .btn.btn-style-2:active, .btn.btn-style-2:focus, .tpath-input-submit .btn.tpath-submit, .tp-caption.slider-btn .btn, .tp-caption.slider-btn .btn.btn-transparent-color:hover, .tp-caption.slider-btn .btn.btn-transparent-color:active, .tp-caption.slider-btn .btn.btn-transparent-color:focus, .widget-title::before, .tpath-section-title::before, .page-title-header::before, .tpath-quote-box, .wpb_wrapper .wpb_tabs .wpb_tabs_nav li:hover > a, .wpb_wrapper .wpb_tabs .wpb_tabs_nav li.active > a:hover, .wpb_wrapper .wpb_tabs .wpb_tabs_nav li.active > a:focus, .wpb_wrapper .wpb_tabs .wpb_tabs_nav li.active a, .wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active a, .tpath-tabs-widget .nav-tabs > li:hover > a, .tpath-tabs-widget .nav-tabs > li.active > a:hover, .tpath-tabs-widget .nav-tabs > li.active > a:focus, .tpath-tabs-widget .nav-tabs > li.active a, .tpath-tabs-widget .nav-tabs > li.ui-tabs-active a, .owl-carousel.owl-theme .owl-controls .owl-dot.active span, .tpath-social-share-box .tpath-social-share-icons li a, .author-info, .footer-section .footer-widgets .widget_nav_menu li:before, .widget.widget_tag_cloud .tagcloud a:hover, .widget.widget_tag_cloud .tagcloud a:active, .widget.widget_tag_cloud .tagcloud a:focus, blockquote::before, .pagination > li > a:hover, .pagination > li > span.page-numbers.current, input[type="submit"], .wpcf7 input[type="submit"], .comment-post-meta span a, .bg-style.primary-color, .tpath-contact-info i, .vc_progress_bar .vc_single_bar .vc_bar, #main .vc_images_carousel .vc_carousel-control, #main .vc_images_carousel .vc_carousel-control:hover, #main .vc_images_carousel .vc_carousel-indicators li { background-color: '.$tpath_options['tpath_custom_scheme_color'].'; }' . "\n";
			
			$output .= '.rev_slider_wrapper .tp-bullets.preview4 .bullet:hover, .rev_slider_wrapper .tp-bullets.preview4 .bullet.selected { background-color: '. $tpath_options['tpath_custom_scheme_color'] . ' !important; }' . "\n";
			
			$color_rgb = '';
			$color_rgb = justice_hex2rgb( $tpath_options['tpath_custom_scheme_color'] );
			
			$output .= '.portfolio-image > a:after { background-color: rgba('.$color_rgb[0].', '.$color_rgb[1].', '.$color_rgb[2].', 0.75); }' . "\n";
			$output .= '.rev_slider .tp-caption.slider-subtitle.title-color, .bg-style.overlay-wrapper.bg-overlay.theme-overlay-color:before { color: rgba('.$color_rgb[0].', '.$color_rgb[1].', '.$color_rgb[2].', 0.8); }' . "\n";
			
			$output .= '.rev_slider .tp-bannertimer, .tpath-feature-box .tpath-feature-top .tpath-feature-image::after { background-color: rgba('.$color_rgb[0].', '.$color_rgb[1].', '.$color_rgb[2].', 0.7); }' . "\n";
			
			if( class_exists('Woocommerce') ) {
				$output .= '.header-top-cart .cart-contents > span, .woo-cart-contents .woo-cart-buttons a:hover, .woo-cart-contents .woo-cart-buttons a:active, .woo-cart-contents .woo-cart-buttons a:focus, .woocommerce ul.products li.product .button:hover, .woocommerce ul.products li.product .button:active, .woocommerce ul.products li.product .button:focus, .woocommerce span.onsale, .woocommerce .related.products h2:before, .woocommerce .upsells h2:before, .woocommerce .cross-sells h2:before, .woocommerce .cart_totals h2:before, .woocommerce .shipping_calculator h2:before, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .widget_product_tag_cloud .tagcloud a { background-color: '. $tpath_options['tpath_custom_scheme_color'] . '; }' . "\n";
				
				$output .= '.woo-cart-contents .woo-cart-buttons a, .woocommerce ul.products li.product:hover img, .woocommerce-page ul.products li.product:hover img, .woocommerce .quantity .qty:focus { border-color: '. $tpath_options['tpath_custom_scheme_color'] . '; }' . "\n";
				
				$output .= '.woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb a:active, .woocommerce .woocommerce-breadcrumb a:focus, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce p.stars a.active::after, .woocommerce p.stars a:hover::after, .woocommerce .star-rating span:before { color: '. $tpath_options['tpath_custom_scheme_color'] . '; }' . "\n";
				
				// Buttons
				$output .= '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt[disabled]:disabled, .woocommerce #respond input#submit.alt[disabled]:disabled:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt[disabled]:disabled, .woocommerce a.button.alt[disabled]:disabled:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt[disabled]:disabled, .woocommerce button.button.alt[disabled]:disabled:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt[disabled]:disabled, .woocommerce input.button.alt[disabled]:disabled:hover { background-color: '. $tpath_options['tpath_custom_scheme_color'] . '; }' . "\n";
				
				$output .= '.woocommerce ul.products li.product .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt[disabled]:disabled, .woocommerce #respond input#submit.alt[disabled]:disabled:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt[disabled]:disabled, .woocommerce a.button.alt[disabled]:disabled:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt[disabled]:disabled, .woocommerce button.button.alt[disabled]:disabled:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt[disabled]:disabled, .woocommerce input.button.alt[disabled]:disabled:hover { border-color: '. $tpath_options['tpath_custom_scheme_color'] . '; }' . "\n";
			}
		}
		
		// Light Color Scheme
		if( isset( $tpath_options['tpath_custom_scheme_color_light'] ) && $tpath_options['tpath_custom_scheme_color_light'] != '' ) {
			$output .= '.bg-style.primary-color .tpath-section-title .section-sub-title, .bg-style.primary-color .tpath-section-title .section-sub-title p, .bg-style.primary-color .tpath-feature-box .tpath-feature-icon i, .bg-style.primary-color .tpath-feature-box-content, .bg-style.primary-color .tpath-feature-box-content p, .author-description, .author-description p, .bg-style.primary-color .vc_cta3-content p { color: '. $tpath_options['tpath_custom_scheme_color_light'] . '; }' . "\n";
			
			$output .= '.bg-style.primary-color .vc_column_container.border-right_only { border-color: '. $tpath_options['tpath_custom_scheme_color_light'] . '; }' . "\n";
			
			$output .= '.bg-style.primary-color .tpath-section-title.title-bottom_border .section-title:before, .bg-style.primary-color .tpath-section-title.title-bottom_border .section-title:after, .bg-style.primary-color .tpath-section-title.title-bottom_border .section-sub-title:before, .bg-style.primary-color .tpath-section-title.title-bottom_border .section-sub-title:after { background-color: '. $tpath_options['tpath_custom_scheme_color_light'] . '; }' . "\n";
		}
		
		// Dark Color Scheme
		if( isset( $tpath_options['tpath_custom_scheme_color_dark'] ) && $tpath_options['tpath_custom_scheme_color_dark'] != '' ) {
			$output .= '.bg-style.primary-dark-color { background-color: '. $tpath_options['tpath_custom_scheme_color_dark'] . '; }' . "\n";
		}
		
		// Global Stylings
		if( isset( $tpath_options['tpath_link_color'] ) && $tpath_options['tpath_link_color'] != '' ) {
			$output .= 'a { color: '. $tpath_options['tpath_link_color'] . '; }' . "\n";
		}
		
		if( isset( $tpath_options['tpath_link_hover_color'] ) && $tpath_options['tpath_link_hover_color'] != '' ) {
			$output .= 'a:hover, a:active, a:focus, .related-post-item h5 > a:hover, .related-post-item h5 > a:active, .related-post-item h5 > a:focus, .link-url:hover, .link-url:hover a, .link-url a:hover { color: '. $tpath_options['tpath_link_hover_color'] . '; }' . "\n";			
		}
				
		// Header Stylings
		$header_bg_image = $tpath_options['tpath_header_bg_image'];
		$header_bg_image_repeat = $tpath_options['tpath_header_bg_repeat'];
		$header_bg_color = $tpath_options['tpath_header_background_color'];
		
		$header_styles = '';
				
		if( isset( $header_bg_image ) && $header_bg_image != '' ) {
			$header_styles .= 'background-image: url('.$header_bg_image.');';
		}
		if( isset( $header_bg_image ) && $header_bg_image != '' && isset( $header_bg_image_repeat ) && $header_bg_image_repeat != '' ) {
			$header_styles .= 'background-repeat: '.$header_bg_image_repeat.';';
		}
		
		// Background Color
		$header_rgb_color = '';
		$header_rgb_color = justice_hex2rgb( $header_bg_color );
		
		if( isset( $header_bg_color ) && $header_bg_color != '' ) {
			$header_styles .= 'background-color: '.$header_bg_color.';';
		}
		
		if( isset( $tpath_options['tpath_header_bg_full'] ) && $tpath_options['tpath_header_bg_full'] ) {
			$header_styles .= 'background-size: cover;';
			$header_styles .= '-moz-background-size: cover;';
			$header_styles .= '-webkit-background-size: cover;';
			$header_styles .= '-o-background-size: cover;';
			$header_styles .= '-ms-background-size: cover;';
		}
		if( isset( $tpath_options['tpath_header_padding_top'] ) && $tpath_options['tpath_header_padding_top'] != '' ) {
			$header_styles .= 'padding-top: '.$tpath_options['tpath_header_padding_top'].';';
		}			
		if( isset( $tpath_options['tpath_header_padding_bottom'] ) && $tpath_options['tpath_header_padding_bottom'] != '' ) {
			$header_styles .= 'padding-bottom: '.$tpath_options['tpath_header_padding_bottom'].';';
		}			
		if( isset( $tpath_options['tpath_header_padding_left'] ) && $tpath_options['tpath_header_padding_left'] != '' ) {
			$header_styles .= 'padding-left: '.$tpath_options['tpath_header_padding_left'].';';
		}			
		if( isset( $tpath_options['tpath_header_padding_right'] ) && $tpath_options['tpath_header_padding_right'] != '' ) {
			$header_styles .= 'padding-right: '.$tpath_options['tpath_header_padding_right'].';';			
		}
		
		if( isset( $tpath_options['tpath_header_parallax_bg'] ) && $tpath_options['tpath_header_parallax_bg'] != '' ) {
			$header_styles .= 'background-attachment: fixed;';
			$header_styles .= 'background-position: top center;';
		}
		
		if( isset( $header_styles ) && $header_styles != '' ) {
			$output .= '#tpath_wrapper .header-section { '. $header_styles . ' }' . "\n";
		}
		
		// Header Top Background Color Stylings		
		$header_top_bg_color = $tpath_options['tpath_header_top_background_color'];
		$header_top_bg_styles = '';				
		
		if( $header_top_bg_color ) {
			$header_top_bg_styles .= 'background: '.$header_top_bg_color.';';
		}
		
		if( $header_top_bg_styles ) {
			$output .= '#header-top-bar { '. $header_top_bg_styles . ' }' . "\n";
		}
		
		// Logo Stylings
		$logo_styles = '';
		if ( $tpath_options['tpath_logo_font_styles'] ) {
			$logo_styles .= 'font-family: '.$tpath_options['tpath_logo_font_styles']['face'].';';
			$logo_styles .= 'font-size: '.$tpath_options['tpath_logo_font_styles']['size'].';';
			$logo_styles .= 'font-style: '.$tpath_options['tpath_logo_font_styles']['style'].';';
			$logo_styles .= 'font-weight: '.$tpath_options['tpath_logo_font_styles']['weight'].';';
			$logo_styles .= 'color: '.$tpath_options['tpath_logo_font_styles']['color'].';';
		}
		
		if( $logo_styles ) {
			$output .= '.navbar-brand .site-logo-text { '. $logo_styles . ' }' . "\n";
		}
		
		$logo_first_letter_styles = '';
		if ( $tpath_options['tpath_logo_first_font_styles'] ) {
			$logo_first_letter_styles .= 'font-family: '.$tpath_options['tpath_logo_first_font_styles']['face'].';';
			$logo_first_letter_styles .= 'font-size: '.$tpath_options['tpath_logo_first_font_styles']['size'].';';
			$logo_first_letter_styles .= 'font-style: '.$tpath_options['tpath_logo_first_font_styles']['style'].';';
			$logo_first_letter_styles .= 'font-weight: '.$tpath_options['tpath_logo_first_font_styles']['weight'].';';
			$logo_first_letter_styles .= 'color: '.$tpath_options['tpath_logo_first_font_styles']['color'].';';
		}
		
		if( $logo_first_letter_styles ) {
			$output .= '.navbar-brand .site-logo-text .logo-first-letter { '. $logo_first_letter_styles . ' }' . "\n";
		}
		
		// Main Site Width
		$big_container = '';
		if ( $tpath_options['tpath_fullwidth_site_width'] ) {
			$output .= '.fullwidth .container, .tpath-owl-carousel .owl-controls { max-width: '.$tpath_options['tpath_fullwidth_site_width'].'px; }' . "\n";
			$big_container = $tpath_options['tpath_fullwidth_site_width'] + 60;
			$output .= '.fullwidth .container-big { max-width: '.$big_container.'px; }' . "\n";
		}
		
		if ( $tpath_options['tpath_boxed_site_width'] ) {
			$output .= '.boxed #tpath_wrapper { max-width: '.$tpath_options['tpath_boxed_site_width'].'px; }' . "\n";
			$output .= '.boxed .container, .tpath-owl-carousel .owl-controls, .boxed .is-sticky.header-main-section { max-width: '.$tpath_options['tpath_boxed_site_width'].'px; }' . "\n";
			$big_container = $tpath_options['tpath_boxed_site_width'] + 120;
			$output .= '.boxed .container-big { max-width: '.$big_container.'px; }' . "\n";
		}
				
		// Footer Widget Area Stylings
		$footer_bg_image = $tpath_options['tpath_footer_bg_image'];
		$footer_bg_image_repeat = $tpath_options['tpath_footer_bg_repeat'];
		$footer_bg_color = $tpath_options['tpath_footer_widget_area_background_color'];
		
		$footer_styles = '';
				
		if( $footer_bg_image ) {
			$footer_styles .= 'background-image: url('.$footer_bg_image.');';
		}
		if( $footer_bg_image && $footer_bg_image_repeat ) {
			$footer_styles .= 'background-repeat: '.$footer_bg_image_repeat.';';
		}
		if( $footer_bg_color ) {
			$footer_styles .= 'background-color: '.$footer_bg_color.';';
		}
		if( $tpath_options['tpath_footer_bg_full'] ) {
			$footer_styles .= 'background-size: cover;';
			$footer_styles .= '-moz-background-size: cover;';
			$footer_styles .= '-webkit-background-size: cover;';
			$footer_styles .= '-o-background-size: cover;';
			$footer_styles .= '-ms-background-size: cover;';
		}
		
		if( $tpath_options['tpath_footer_widget_padding_top'] ) {
			$footer_styles .= 'padding-top: '.$tpath_options['tpath_footer_widget_padding_top'].';';
		}			
		if( $tpath_options['tpath_footer_widget_padding_bottom'] ) {
			$footer_styles .= 'padding-bottom: '.$tpath_options['tpath_footer_widget_padding_bottom'].';';
		}			
		if( $tpath_options['tpath_footer_widget_padding_left'] ) {
			$footer_styles .= 'padding-left: '.$tpath_options['tpath_footer_widget_padding_left'].';';
		}			
		if( $tpath_options['tpath_footer_widget_padding_right'] ) {
			$footer_styles .= 'padding-right: '.$tpath_options['tpath_footer_widget_padding_right'].';';
		}	
		
		if( $footer_styles ) {
			$output .= '#footer .footer-widgets-section { '. $footer_styles . ' }' . "\n";
		}
				
		$footer_bar = '';
		
		$footer_bar_bg_color = $tpath_options['tpath_footer_background_color'];
		
		if( $footer_bar_bg_color ) {
			$footer_bar .= 'background-color: '.$footer_bar_bg_color.';';
		}
		if( $tpath_options['tpath_footer_padding_top'] ) {
			$footer_bar .= 'padding-top: '.$tpath_options['tpath_footer_padding_top'].';';
		}			
		if( $tpath_options['tpath_footer_padding_bottom'] ) {
			$footer_bar .= 'padding-bottom: '.$tpath_options['tpath_footer_padding_bottom'].';';
		}			
		if( $tpath_options['tpath_footer_padding_left'] ) {
			$footer_bar .= 'padding-left: '.$tpath_options['tpath_footer_padding_left'].';';
		}			
		if( $tpath_options['tpath_footer_padding_right'] ) {
			$footer_bar .= 'padding-right: '.$tpath_options['tpath_footer_padding_right'].';';
		}
		
		if( isset( $tpath_options['tpath_footer_divider_color'] ) && $tpath_options['tpath_footer_divider_color'] != '' ) {
			$footer_bar .= 'border-color: '.$tpath_options['tpath_footer_divider_color'].';';
		}
				
		if( $footer_bar ) {
			$output .= '#footer .footer-copyright-section { '. $footer_bar . ' }' . "\n";
		}
		
		// Body Background Stylings
		$post_meta_body_img = $body_bg_image_repeat = $body_bg_color = $body_bg_attachment = $body_bg_cover = '';
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			if( is_object($post) ) { 
				$post_meta_body_img = get_post_meta( $home_id, 'tpath_body_bg_image', true );
			}
		} else {
			if( is_object($post) ) { 
				$post_meta_body_img = get_post_meta( $post->ID, 'tpath_body_bg_image', true );
			}
		}
		$body_bg_image = !empty( $post_meta_body_img ) ? $post_meta_body_img : $tpath_options['tpath_body_bg_image'];
		
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			if( is_object($post) ) { 
				$body_bg_image_repeat = get_post_meta( $home_id, 'tpath_body_bg_repeat', true );
			}
		} else {
			if( is_object($post) ) { 
				$body_bg_image_repeat = get_post_meta( $post->ID, 'tpath_body_bg_repeat', true );
			}
		}
		if( !$body_bg_image_repeat || $body_bg_image_repeat == 'default' ) {
			$body_bg_image_repeat = $tpath_options['tpath_body_bg_repeat'];
		}
		
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			if( is_object($post) ) { 
				$body_bg_color = get_post_meta( $home_id, 'tpath_body_bg_color', true );
			}
		} else {
			if( is_object($post) ) { 
				$body_bg_color = get_post_meta( $post->ID, 'tpath_body_bg_color', true );
			}
		}
		if( !$body_bg_color ) {
			$body_bg_color = $tpath_options['tpath_body_bg_color'];
		}
		
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			if( is_object($post) ) { 
				$body_bg_attachment = get_post_meta( $home_id, 'tpath_body_bg_attachment', true );
			}
		} else {
			if( is_object($post) ) { 
				$body_bg_attachment = get_post_meta( $post->ID, 'tpath_body_bg_attachment', true );
			}
		}		
		if( !$body_bg_attachment || $body_bg_attachment == 'default' ) {
			$body_bg_attachment = $tpath_options['tpath_body_bg_attachment'];
		}
				
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			if( is_object($post) ) { 
				$body_bg_cover = get_post_meta( $home_id, 'tpath_body_bg_full', true );
			}
		} else {
			if( is_object($post) ) { 
				$body_bg_cover = get_post_meta( $post->ID, 'tpath_body_bg_full', true );
			}
		}
		if( $body_bg_cover != 1 ) {
			$body_bg_cover = $tpath_options['tpath_body_bg_full'];
		}
		
		$body_styles = '';
				
		if( $body_bg_image ) {
			$body_styles .= 'background-image: url('.$body_bg_image.');';
		}
		if( $body_bg_image && $body_bg_image_repeat ) {
			$body_styles .= 'background-repeat: '.$body_bg_image_repeat.';';
		}
		if( $body_bg_image && $body_bg_attachment ) {
			$body_styles .= 'background-attachment: '.$body_bg_attachment.';';
		}
		if( $body_bg_color ) {
			$body_styles .= 'background-color: '.$body_bg_color.';';
		}
		if( $body_bg_cover ) {
			$body_styles .= 'background-size: cover;';
			$body_styles .= '-moz-background-size: cover;';
			$body_styles .= '-webkit-background-size: cover;';
			$body_styles .= '-o-background-size: cover;';
			$body_styles .= '-ms-background-size: cover;';
		}
		
		if ( $tpath_options['tpath_body_font'] ) {
			$body_styles .= 'font-family: '.$tpath_options['tpath_body_font']['face'].';';
			$body_styles .= 'font-size: '.$tpath_options['tpath_body_font']['size'].';';
			$body_styles .= 'font-style: '.$tpath_options['tpath_body_font']['style'].';';
			$body_styles .= 'font-weight: '.$tpath_options['tpath_body_font']['weight'].';';
			$body_styles .= 'color: '.$tpath_options['tpath_body_font']['color'].';';
		}
		
		if( $body_styles ) {
			$output .= 'body { '. $body_styles . ' }' . "\n";
		}
		
		// Sticky Background Stylings
		if( $tpath_options['tpath_sticky_background_color'] ) {
			$output .= '.is-sticky .header-section { background-color: '.$tpath_options['tpath_sticky_background_color'].'; }' . "\n";
		}
				
		// Content Background Stylings					
		$content_styles = '';
				
		if( $tpath_options['tpath_primary_content_bg_image'] ) {
			$content_styles .= 'background-image: url('.$tpath_options['tpath_primary_content_bg_image'].');';
		}
		if( $tpath_options['tpath_primary_content_bg_image'] && $tpath_options['tpath_primary_content_bg_repeat'] ) {
			$content_styles .= 'background-repeat: '.$tpath_options['tpath_primary_content_bg_repeat'].';';
		}
		if( $tpath_options['tpath_primary_content_bg_color'] ) {		
			$content_styles .= 'background-color: '.$tpath_options['tpath_primary_content_bg_color'].';';
		}
		if( $tpath_options['tpath_primary_content_bg_full'] ) {
			$content_styles .= 'background-size: cover;';
			$content_styles .= '-moz-background-size: cover;';
			$content_styles .= '-webkit-background-size: cover;';
			$content_styles .= '-o-background-size: cover;';
			$content_styles .= '-ms-background-size: cover;';
		}
		
		if( $content_styles && $tpath_options['tpath_enable_content_full_bg'] == 1 ) {
			$output .= '#main { '. $content_styles . ' }' . "\n";
		} elseif( $content_styles && $tpath_options['tpath_enable_content_full_bg'] != 1 ) {
			$output .= '#main #primary { '. $content_styles . ' }' . "\n";
		}
		
		// Container Minimum Height
		if ( $tpath_options['tpath_primary_content_min_height'] ) {
			$output .= '#main-wrapper, #main-wrapper #primary, #main-wrapper #sidebar, #main-wrapper #secondary-sidebar { min-height: '.$tpath_options['tpath_primary_content_min_height'].'; }' . "\n";
		}
		
		// Primary Sidebar Background Stylings					
		$pm_sidebar_styles = '';
				
		if( $tpath_options['tpath_primary_sidebar_bg_image'] ) {
			$pm_sidebar_styles .= 'background-image: url('.$tpath_options['tpath_primary_sidebar_bg_image'].');';
		}
		if( $tpath_options['tpath_primary_sidebar_bg_image'] && $tpath_options['tpath_primary_sidebar_bg_repeat'] ) {
			$pm_sidebar_styles .= 'background-repeat: '.$tpath_options['tpath_primary_sidebar_bg_repeat'].';';
		}
		if( $tpath_options['tpath_primary_sidebar_bg_color'] ) {
			$pm_sidebar_styles .= 'background-color: '.$tpath_options['tpath_primary_sidebar_bg_color'].';';
		}
		if( $tpath_options['tpath_primary_sidebar_bg_full'] ) {
			$pm_sidebar_styles .= 'background-size: cover;';
			$pm_sidebar_styles .= '-moz-background-size: cover;';
			$pm_sidebar_styles .= '-webkit-background-size: cover;';
			$pm_sidebar_styles .= '-o-background-size: cover;';
			$pm_sidebar_styles .= '-ms-background-size: cover;';
		}
		
		if( $pm_sidebar_styles && $tpath_options['tpath_enable_content_full_bg'] != 1 ) {
			$output .= '#main #sidebar { '. $pm_sidebar_styles . ' }' . "\n";
		}		
		
		// Dropdown Menu Width
		$sub_menu_width = '';
		if ( $tpath_options['tpath_dropdown_menu_width'] ) {
			$output .= '.dropdown-menu { min-width: '.$tpath_options['tpath_dropdown_menu_width'].'; }' . "\n";
		}
		
		// Main Menu Font & Color Stylings
		$menu_font_styles = '';
		if ( $tpath_options['tpath_menu_font_styles'] ) {
			$menu_font_styles .= 'font-family: '.$tpath_options['tpath_menu_font_styles']['face'].';';
			$menu_font_styles .= 'font-size: '.$tpath_options['tpath_menu_font_styles']['size'].';';
			$menu_font_styles .= 'font-style: '.$tpath_options['tpath_menu_font_styles']['style'].';';
			$menu_font_styles .= 'font-weight: '.$tpath_options['tpath_menu_font_styles']['weight'].';';
			$menu_font_styles .= 'color: '.$tpath_options['tpath_menu_font_styles']['color'].';';
		}
		if( $menu_font_styles ) {
			$output .= '.nav.navbar-nav.tpath-main-nav li a, .nav.navbar-nav.tpath-main-nav li span.menu-toggler, .menu-icon-box { '. $menu_font_styles . ' }' . "\n";
		}
		
		$menu_styles = '';
		
		if ( $tpath_options['tpath_menu_font_hover_color'] ) {
			$menu_styles .= 'color: '.$tpath_options['tpath_menu_font_hover_color'].';';
		}
		
		if( $menu_styles ) {
			$output .= '.nav.navbar-nav.tpath-main-nav a:hover, .nav.navbar-nav.tpath-main-nav a:focus, .nav.navbar-nav.tpath-main-nav a:active, .nav.navbar-nav.tpath-main-nav li.active > a, .nav.navbar-nav.tpath-main-nav .current-menu-ancestor > a, .nav.navbar-nav.tpath-main-nav .current-menu-ancestor .dropdown-menu .current-menu-item > a, .nav.navbar-nav .side-menu a:hover, .nav.navbar-nav .side-menu a:active, .nav.navbar-nav .side-menu a:focus { '. $menu_styles .' }' . "\n";
		}
		
		$submenu_link_styles = '';
		if ( $tpath_options['tpath_submenu_font_styles'] ) {
			$submenu_link_styles .= 'font-family: '.$tpath_options['tpath_submenu_font_styles']['face'].';';
			$submenu_link_styles .= 'font-size: '.$tpath_options['tpath_submenu_font_styles']['size'].';';
			$submenu_link_styles .= 'font-style: '.$tpath_options['tpath_submenu_font_styles']['style'].';';
			$submenu_link_styles .= 'font-weight: '.$tpath_options['tpath_submenu_font_styles']['weight'].';';
			$submenu_link_styles .= 'color: '.$tpath_options['tpath_submenu_font_styles']['color'].';';
		}
		
		if ( $tpath_options['tpath_sub_menu_bg_color'] ) {
			$submenu_link_styles .= 'background-color: '.$tpath_options['tpath_sub_menu_bg_color'].';';
		}
		
		if( $submenu_link_styles ) {
			$output .= '.nav.navbar-nav.tpath-main-nav .dropdown-menu a, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a { '. $submenu_link_styles .' }' . "\n";
		}
		
		$hover_menu_styles = '';
				
		if ( $tpath_options['tpath_sub_menu_font_hover_color'] ) {
			$hover_menu_styles .= 'color: '.$tpath_options['tpath_sub_menu_font_hover_color'].';';			
		}
		if ( $tpath_options['tpath_sub_menu_bg_hover_color'] ) {
			$hover_menu_styles .= 'background-color: '.$tpath_options['tpath_sub_menu_bg_hover_color'].';';			
		}
		
		if( $hover_menu_styles ) {
			$output .= '.nav.navbar-nav.tpath-main-nav .dropdown-menu .active a, .nav.navbar-nav.tpath-main-nav .dropdown-menu a:hover, .nav.navbar-nav.tpath-main-nav .dropdown-menu .current-menu-parent > a, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu li.active a, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:hover, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:active, .nav.navbar-nav.tpath-main-nav li .tpath-megamenu-container .tpath-megamenu a:focus { '. $hover_menu_styles .' }' . "\n";
		}
			
		// Heading Styles
		$h1_styles = '';
		if ( isset($tpath_options['tpath_h1_font_styles']) && (!empty($tpath_options['tpath_h1_font_styles'])) ) {
			$h1_styles .= 'font-family: '.$tpath_options['tpath_h1_font_styles']['face'].';';
			$h1_styles .= 'font-size: '.$tpath_options['tpath_h1_font_styles']['size'].';';
			$h1_styles .= 'font-style: '.$tpath_options['tpath_h1_font_styles']['style'].';';
			$h1_styles .= 'font-weight: '.$tpath_options['tpath_h1_font_styles']['weight'].';';
			$h1_styles .= 'color: '.$tpath_options['tpath_h1_font_styles']['color'].';';
		}
		if( $h1_styles ) {
			$output .= 'h1, .tp-caption.slider-title { '. $h1_styles . ' }' . "\n";
		}
		
		$h2_styles = '';
		if ( isset($tpath_options['tpath_h2_font_styles']) && (!empty($tpath_options['tpath_h2_font_styles'])) ) {
			$h2_styles .= 'font-family: '.$tpath_options['tpath_h2_font_styles']['face'].';';
			$h2_styles .= 'font-size: '.$tpath_options['tpath_h2_font_styles']['size'].';';
			$h2_styles .= 'font-style: '.$tpath_options['tpath_h2_font_styles']['style'].';';
			$h2_styles .= 'font-weight: '.$tpath_options['tpath_h2_font_styles']['weight'].';';
			$h2_styles .= 'color: '.$tpath_options['tpath_h2_font_styles']['color'].';';
		}
		if( $h2_styles ) {
			$output .= 'h2, h2 a, .tp-caption.slider-subtitle { '. $h2_styles . ' }' . "\n";
		}
		
		$h3_styles = '';
		if ( isset($tpath_options['tpath_h3_font_styles']) && (!empty($tpath_options['tpath_h3_font_styles'])) ) {
			$h3_styles .= 'font-family: '.$tpath_options['tpath_h3_font_styles']['face'].';';
			$h3_styles .= 'font-size: '.$tpath_options['tpath_h3_font_styles']['size'].';';
			$h3_styles .= 'font-style: '.$tpath_options['tpath_h3_font_styles']['style'].';';
			$h3_styles .= 'font-weight: '.$tpath_options['tpath_h3_font_styles']['weight'].';';
			$h3_styles .= 'color: '.$tpath_options['tpath_h3_font_styles']['color'].';';
		}
		if( $h3_styles ) {
			$output .= 'h3 { '. $h3_styles . ' }' . "\n";
		}
		
		$h4_styles = '';
		if ( isset($tpath_options['tpath_h4_font_styles']) && (!empty($tpath_options['tpath_h4_font_styles'])) ) {
			$h4_styles .= 'font-family: '.$tpath_options['tpath_h4_font_styles']['face'].';';
			$h4_styles .= 'font-size: '.$tpath_options['tpath_h4_font_styles']['size'].';';
			$h4_styles .= 'font-style: '.$tpath_options['tpath_h4_font_styles']['style'].';';
			$h4_styles .= 'font-weight: '.$tpath_options['tpath_h4_font_styles']['weight'].';';
			$h4_styles .= 'color: '.$tpath_options['tpath_h4_font_styles']['color'].';';
		}
		if( $h4_styles ) {
			$output .= 'h4, .comment-reply-title, .widget-title { '. $h4_styles . ' }' . "\n";
		}
		
		$h5_styles = '';
		if (isset($tpath_options['tpath_h5_font_styles'])  && (!empty($tpath_options['tpath_h5_font_styles']))) {
			$h5_styles .= 'font-family: '.$tpath_options['tpath_h5_font_styles']['face'].';';
			$h5_styles .= 'font-size: '.$tpath_options['tpath_h5_font_styles']['size'].';';
			$h5_styles .= 'font-style: '.$tpath_options['tpath_h5_font_styles']['style'].';';
			$h5_styles .= 'font-weight: '.$tpath_options['tpath_h5_font_styles']['weight'].';';
			$h5_styles .= 'color: '.$tpath_options['tpath_h5_font_styles']['color'].';';
		}
		if( $h5_styles ) {
			$output .= 'h5 { '. $h5_styles . ' }' . "\n";
		}
		
		$h6_styles = '';
		if ( isset($tpath_options['tpath_h6_font_styles']) && (!empty($tpath_options['tpath_h6_font_styles']))) {
			$h6_styles .= 'font-family: '.$tpath_options['tpath_h6_font_styles']['face'].';';
			$h6_styles .= 'font-size: '.$tpath_options['tpath_h6_font_styles']['size'].';';
			$h6_styles .= 'font-style: '.$tpath_options['tpath_h6_font_styles']['style'].';';
			$h6_styles .= 'font-weight: '.$tpath_options['tpath_h6_font_styles']['weight'].';';
			$h6_styles .= 'color: '.$tpath_options['tpath_h6_font_styles']['color'].';';
		}
		if( $h6_styles ) {
			$output .= 'h6, .tp-caption.slider-thumb-title { '. $h6_styles . ' }' . "\n";
		}
		
		$section_styles = '';
		if ( isset($tpath_options['tpath_section_font_styles'])  && (!empty($tpath_options['tpath_section_font_styles'])) ) {
			$section_styles .= 'font-family: '.$tpath_options['tpath_section_font_styles']['face'].';';
			$section_styles .= 'font-size: '.$tpath_options['tpath_section_font_styles']['size'].';';
			$section_styles .= 'font-style: '.$tpath_options['tpath_section_font_styles']['style'].';';
			$section_styles .= 'font-weight: '.$tpath_options['tpath_section_font_styles']['weight'].';';
			$section_styles .= 'color: '.$tpath_options['tpath_section_font_styles']['color'].';';
		}
		if( $section_styles ) {
			$output .= '.parallax-title { '. $section_styles . ' }' . "\n";
		}
		
		$post_title_styles = '';
		if (isset($tpath_options['tpath_post_title_font_styles'])  && (!empty($tpath_options['tpath_post_title_font_styles'])) ) {
			$post_title_styles .= 'font-family: '.$tpath_options['tpath_post_title_font_styles']['face'].';';
			$post_title_styles .= 'font-size: '.$tpath_options['tpath_post_title_font_styles']['size'].';';
			$post_title_styles .= 'font-style: '.$tpath_options['tpath_post_title_font_styles']['style'].';';
			$post_title_styles .= 'font-weight: '.$tpath_options['tpath_post_title_font_styles']['weight'].';';
			$post_title_styles .= 'color: '.$tpath_options['tpath_post_title_font_styles']['color'].';';
		}
		if( $post_title_styles ) {
			$output .= '.post .entry-title a { '. $post_title_styles . ' }' . "\n";
		}
		
		$single_post_title_styles = '';
		if ( isset( $tpath_options['tpath_single_post_title_font_styles'] )  && (!empty($tpath_options['tpath_single_post_title_font_styles']))) {
			$single_post_title_styles .= 'font-family: '.$tpath_options['tpath_single_post_title_font_styles']['face'].';';
			$single_post_title_styles .= 'font-size: '.$tpath_options['tpath_single_post_title_font_styles']['size'].';';
			$single_post_title_styles .= 'font-style: '.$tpath_options['tpath_single_post_title_font_styles']['style'].';';
			$single_post_title_styles .= 'font-weight: '.$tpath_options['tpath_single_post_title_font_styles']['weight'].';';
			$single_post_title_styles .= 'color: '.$tpath_options['tpath_single_post_title_font_styles']['color'].';';
		}
		if( isset( $single_post_title_styles ) && $single_post_title_styles != '' ) {
			$output .= '.single-post .entry-title, .category-title { '. $single_post_title_styles . ' }' . "\n";
		}
		
		$footer_widget_heading_styles = '';
		if ( isset($tpath_options['tpath_footer_widget_heading_styles']) && (!empty($tpath_options['tpath_footer_widget_heading_styles'])) ) {
			$footer_widget_heading_styles .= 'font-family: '.$tpath_options['tpath_footer_widget_heading_styles']['face'].';';
			$footer_widget_heading_styles .= 'font-size: '.$tpath_options['tpath_footer_widget_heading_styles']['size'].';';
			$footer_widget_heading_styles .= 'font-style: '.$tpath_options['tpath_footer_widget_heading_styles']['style'].';';
			$footer_widget_heading_styles .= 'font-weight: '.$tpath_options['tpath_footer_widget_heading_styles']['weight'].';';
			$footer_widget_heading_styles .= 'color: '.$tpath_options['tpath_footer_widget_heading_styles']['color'].';';
		}
		if( $footer_widget_heading_styles ) {
			$output .= '.footer-widgets .widget h3 { '. $footer_widget_heading_styles . ' }' . "\n";
		}
		
		$footer_widget_text_styles = '';
		if ( isset($tpath_options['tpath_footer_widget_font_styles']) && (!empty($tpath_options['tpath_footer_widget_font_styles'])) ) {
			$footer_widget_text_styles .= 'font-family: '.$tpath_options['tpath_footer_widget_font_styles']['face'].';';
			$footer_widget_text_styles .= 'font-size: '.$tpath_options['tpath_footer_widget_font_styles']['size'].';';
			$footer_widget_text_styles .= 'font-style: '.$tpath_options['tpath_footer_widget_font_styles']['style'].';';
			$footer_widget_text_styles .= 'font-weight: '.$tpath_options['tpath_footer_widget_font_styles']['weight'].';';
			$footer_widget_text_styles .= 'color: '.$tpath_options['tpath_footer_widget_font_styles']['color'].';';
		}
		if( $footer_widget_text_styles ) {
			$output .= '.footer-widgets div, .footer-widgets p, .footer-widgets .widget_categories ul li a, .footer-copyright-section p { '. $footer_widget_text_styles . ' }' . "\n";
		}
		
		$map_styles = '';
		if( is_page_template( 'template-contact.php' ) && $tpath_options['tpath_show_google_map_contact'] && $tpath_options['tpath_gmap_address'] ) {
			$map_styles .= 'width: '.$tpath_options['tpath_gmap_width'].'; margin:0 auto; height: '.$tpath_options['tpath_gmap_height'].';';			
			if( $tpath_options['tpath_gmap_width'] != '100%') {
				$map_styles .= 'margin-top: 20px;';		
			}
		}
		
		if( $map_styles ) {
			$output .= '#tpath_gmap { '.$map_styles.' }' . "\n";
		}
		
		// Front Page Parallax Styles
		if( is_page_template( 'template-parallax.php' ) ) {
			/* Check for Query */
			$page_query = justice_parallax_front_query();	
				
			if( !empty( $page_query ) ) {
			
				$query_styles = new WP_Query( $page_query );
					
				if( $query_styles->have_posts() ) :
					while ( $query_styles->have_posts() ) : $query_styles->the_post();
						global $post;							
						$backup = $post;
					
						$tpath_additional_sections_order = get_post_meta( $post->ID, 'tpath_parallax_additional_sections_order', true );
						
						$output .= justice_parallax_custom_styles( $post );
						
						if( $tpath_additional_sections_order != '' ) {
							$additional_query = justice_parallax_additional_query( $tpath_additional_sections_order );
							
							if( !empty( $additional_query ) ) {							
								$custom_query = new WP_Query( $additional_query );
							}
							if ( $custom_query->have_posts() ):
								while ( $custom_query->have_posts() ): $custom_query->the_post();
								
									$output .= justice_parallax_custom_styles( $post );
									
								endwhile;
							endif;
							wp_reset_postdata();
						}
						
						$post = $backup;
						
					endwhile;
				endif;
				wp_reset_postdata();
			}			
		}
				
		// Output Custom Styles
		if (isset($output)) {			
			return $output;
		}
		
	} // End justice_custom_styles()
	
}

/* =========================================
 * Parallax Custom Styles Output
 * ========================================= */
 
if ( ! function_exists( 'justice_parallax_custom_styles' ) ) {
	function justice_parallax_custom_styles( $post ) {
	
		global $post;
		
		$output = '';
		
		// Section Padding Styles
		$tpath_section_padding_top = get_post_meta( $post->ID, 'tpath_section_padding_top', true);
		$tpath_section_padding_bottom = get_post_meta( $post->ID, 'tpath_section_padding_bottom', true);
		$tpath_section_header_padding = get_post_meta( $post->ID, 'tpath_section_header_padding', true);
		
		if( ( isset($tpath_section_padding_top) && $tpath_section_padding_top != '' ) || ( isset($tpath_section_padding_bottom) && $tpath_section_padding_bottom != '' ) ) {
			$output .= '#page-' . $post->post_name . ' {';
			if( isset($tpath_section_padding_top) && $tpath_section_padding_top != '' ) {
				$output .= ' padding-top:' . $tpath_section_padding_top . '; ';
			}
			if( isset($tpath_section_padding_bottom) && $tpath_section_padding_bottom != '' ) {
				$output .= 'padding-bottom:' . $tpath_section_padding_bottom . ';';
			}
			$output .= ' }'. "\n";
		}
		
		if( isset($tpath_section_header_padding) && $tpath_section_header_padding != '' ) {
			$output .= '#page-' . $post->post_name . ' .parallax-header { padding-bottom:' . $tpath_section_header_padding . '; }'. "\n";
		}		
		
		// Section Color Styles
		$tpath_section_title_color = get_post_meta( $post->ID, 'tpath_section_title_color', true);
		$tpath_section_slogan_color = get_post_meta( $post->ID, 'tpath_section_slogan_color', true);
		$tpath_section_text_color = get_post_meta( $post->ID, 'tpath_section_text_color', true);
		$tpath_section_content_heading_color = get_post_meta( $post->ID, 'tpath_section_content_heading_color', true);
		
		if( !empty($tpath_section_title_color) ) {
			$output.= '#page-' . $post->post_name . ' .parallax-title { color: ' . $tpath_section_title_color . '; }'. "\n";
		}
		
		if( !empty($tpath_section_slogan_color) ) {
			$output.= '#page-' . $post->post_name . ' .parallax-desc { color: ' . $tpath_section_slogan_color . '; }'. "\n";
		}
		
		if( !empty($tpath_section_text_color) ) {
			$output.= '#page-' . $post->post_name . ' .parallax-content { color: ' . $tpath_section_text_color . '; }'. "\n";
		}
		
		if( !empty($tpath_section_content_heading_color) ) {
			$output.= '#page-' . $post->post_name . ' .parallax-content h1, 
						#page-' . $post->post_name . ' .parallax-content h2, 
						#page-' . $post->post_name . ' .parallax-content h3, 
						#page-' . $post->post_name . ' .parallax-content h4, 
						#page-' . $post->post_name . ' .parallax-content h5, 
						#page-' . $post->post_name . ' .parallax-content h6 { color: ' . $tpath_section_content_heading_color . '; }'. "\n";
		}
		
		// Section Background
		$tpath_parallax_bg_image = get_post_meta( $post->ID, 'tpath_parallax_bg_image', true);
		$tpath_parallax_bg_repeat = get_post_meta( $post->ID, 'tpath_parallax_bg_repeat', true);
		$tpath_parallax_bg_attachment = get_post_meta( $post->ID, 'tpath_parallax_bg_attachment', true);
		$tpath_parallax_bg_postion = get_post_meta( $post->ID, 'tpath_parallax_bg_postion', true);
		$tpath_parallax_bg_size = get_post_meta( $post->ID, 'tpath_parallax_bg_size', true);
		
		$tpath_parallax_bg_repeat = !empty($tpath_parallax_bg_repeat) ? $tpath_parallax_bg_repeat : 'no-repeat';
		
		$parallax_background = '';
		
		if( !empty($tpath_parallax_bg_image) ) {
			$parallax_background = 'background-image: url(' . $tpath_parallax_bg_image . ');';
			$parallax_background .= 'background-repeat: ' . $tpath_parallax_bg_repeat . ';';
			if( !empty($tpath_parallax_bg_postion) ) {
				$parallax_background .= 'background-position: ' . $tpath_parallax_bg_postion . ';';
			}
			if( !empty($tpath_parallax_bg_size) ) {
				$parallax_background .= 'background-size: ' . $tpath_parallax_bg_size . ';';
			}
			if( !empty($tpath_parallax_bg_attachment) ) {
				$parallax_background .= 'background-attachment: ' . $tpath_parallax_bg_attachment . ';';
			}
		}
		if( !empty($tpath_parallax_bg_image) ) {						
			$output.= '#section-' . $post->post_name . ' { '. $parallax_background . ' }'. "\n";
		}
		
		$tpath_section_bg_color = get_post_meta( $post->ID, 'tpath_section_bg_color', true);
		if( !empty($tpath_section_bg_color) ) {						
			$output.= '#page-' . $post->post_name . ' { background-color: ' . $tpath_section_bg_color . '; }'. "\n";
		}
		
		$tpath_parallax_bg_overlay = get_post_meta( $post->ID, 'tpath_parallax_bg_overlay', true);
		if( $tpath_parallax_bg_overlay == 'yes' ) {
			$tpath_section_overlay_color = get_post_meta( $post->ID, 'tpath_section_overlay_color', true);
			$tpath_overlay_color_opacity = get_post_meta( $post->ID, 'tpath_overlay_color_opacity', true);
			
			$tpath_overlay_color_opacity = $tpath_overlay_color_opacity != 0 ? $tpath_overlay_color_opacity : '0.7';
			
			$rgb_color = '';
			$rgb_color = justice_hex2rgb( $tpath_section_overlay_color );
			
			$output.= '#page-' . $post->post_name . ' { background-color: rgba(' . $rgb_color[0] . ',' . $rgb_color[1] . ',' . $rgb_color[2] . ', ' . $tpath_overlay_color_opacity . '); }'. "\n";
		}
		
		return $output;
		
	}
}

/* =========================================
 * Load theme style and js in the <head>
 * ========================================= */

if ( ! function_exists( 'justice_load_theme_scripts' ) ) {

	function justice_load_theme_scripts () {
	
		global $tpath_options, $is_IE;
		
		// Stylesheet
		wp_register_style( 'justice-prettyphoto-style', get_template_directory_uri() . '/css/prettyPhoto.css' );
		wp_enqueue_style( 'justice-prettyphoto-style' );
		
		wp_register_style( 'justice-font-awesome-style', get_template_directory_uri() . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'justice-font-awesome-style' );
		
		wp_register_style( 'justice-simple-line-icons-style', get_template_directory_uri() . '/css/simple-line-icons.css' );
		wp_enqueue_style( 'justice-simple-line-icons-style' );
		
		wp_register_style( 'justice-font-awesome-social-style', get_template_directory_uri() . '/css/font-awesome-social.css' );
		wp_enqueue_style( 'justice-font-awesome-social-style' );
		
		wp_register_style( 'justice-flaticons-style', get_template_directory_uri() . '/css/flaticon.css' );
		wp_enqueue_style( 'justice-flaticons-style' );
		
		wp_register_style( 'justice-owlcarousel-style', get_template_directory_uri() . '/css/owl.carousel.css' );
		wp_enqueue_style( 'justice-owlcarousel-style' );
		
		wp_register_style( 'justice-effects-style', get_template_directory_uri() . '/css/animate.css' );
		wp_enqueue_style( 'justice-effects-style' );
		
		wp_enqueue_style( 'justice-ratings-stars', get_template_directory_uri() . '/css/rateit.css' );
		
		wp_enqueue_style('wp-mediaelement');
		
		if( is_singular( 'post' ) ) {
			wp_enqueue_style( 'js_composer_front' );
			wp_enqueue_style( 'js_composer_custom_css' );
		}
		
		wp_register_style( 'justice-mediaelement-style', get_template_directory_uri() . '/css/mediaelementplayer.css' );
		wp_enqueue_style( 'justice-mediaelement-style' );
		
		wp_register_style( 'justice-bootstrap-validation-style', get_template_directory_uri() . '/css/bootstrapValidator.min.css' );
		wp_enqueue_style( 'justice-bootstrap-validation-style' );
		
		wp_register_style( 'justice-theme-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style( 'justice-theme-bootstrap-style' );
		
		wp_register_style( 'justice-theme-style', get_stylesheet_uri() );
		wp_enqueue_style( 'justice-theme-style' );		
		
		if($tpath_options['tpath_enable_responsive']) {
			wp_register_style( 'justice-theme-responsive-style', get_template_directory_uri() . '/css/responsive.css' );
			wp_enqueue_style( 'justice-theme-responsive-style' );
		}
		
		if( isset( $tpath_options['tpath_color_scheme'] ) && $tpath_options['tpath_color_scheme'] != '' ) {
			wp_register_style( 'justice-color-scheme-style', get_template_directory_uri() . '/color-schemes/'.$tpath_options['tpath_color_scheme'].'' );
			wp_enqueue_style( 'justice-color-scheme-style' );
		} else {
			wp_register_style( 'justice-color-scheme-style', get_template_directory_uri() . '/color-schemes/default.css' );
			wp_enqueue_style( 'justice-color-scheme-style' );
		}
				
		wp_register_style( 'justice-bg-videoplayer-style', get_template_directory_uri() . '/css/mb.YTPlayer.css' );
		wp_enqueue_style( 'justice-bg-videoplayer-style' );
		
		// Load Google Fonts
		$google_font = array();
		$fonts_options = array();
		
		$fonts_options = array( 
				$tpath_options['tpath_body_font'],
				$tpath_options['tpath_logo_first_font_styles'],
				$tpath_options['tpath_logo_font_styles'],
				$tpath_options['tpath_h1_font_styles'], 
				$tpath_options['tpath_h2_font_styles'], 
				$tpath_options['tpath_h3_font_styles'], 
				$tpath_options['tpath_h4_font_styles'], 
				$tpath_options['tpath_h5_font_styles'], 
				$tpath_options['tpath_h6_font_styles'],
				$tpath_options['tpath_top_menu_font_styles'],
				$tpath_options['tpath_menu_font_styles'],
				$tpath_options['tpath_submenu_font_styles'],
				$tpath_options['tpath_single_post_title_font_styles'],
				$tpath_options['tpath_widget_title_fonts'],
				$tpath_options['tpath_widget_text_fonts'],
				$tpath_options['tpath_footer_widget_title_fonts'],
				$tpath_options['tpath_footer_widget_text_fonts']
			);
		
		foreach( $fonts_options as $fonts_option ) {
			$font = urlencode( $fonts_option['face'] );
			if( !in_array($font, $google_font) ) {
				$google_font[] = $font;
			}
		}
		
		$font_family = '';
		foreach( $google_font as $font ) {
			$font_family .= $font . ':200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic%7C';
		}
		
		if( $font_family ) {
			wp_register_style( 'justice-google-fonts', "//fonts.googleapis.com/css?family=" . $font_family . "&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
			wp_enqueue_style( 'justice-google-fonts' );
		}
		
		// Javascripts
		wp_register_script( 'justice-html5-js', get_template_directory_uri() . '/js/html5.js', array() );
		wp_register_script( 'justice-respond-js', get_template_directory_uri() . '/js/respond.min.js', array() );
		wp_register_script( 'justice-lineicon-ie-js', get_template_directory_uri() . '/js/icons-lte-ie7.js', array() );
		
		if( $is_IE ) {
			wp_enqueue_script( 'justice-html5-js' );
			wp_enqueue_script( 'justice-respond-js' );
			wp_enqueue_script( 'justice-lineicon-ie-js' );
		}
		
		wp_register_script( 'justice-bootstrap-validator-js', get_template_directory_uri() . '/js/bootstrapValidator.min.js', array('jquery') );
		wp_enqueue_script( 'justice-bootstrap-validator-js' );
				
        wp_register_script( 'justice-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
		wp_enqueue_script( 'justice-bootstrap-js' );
		
		wp_register_script( 'justice-general-js', get_template_directory_uri() . '/js/general.js', array('jquery') );
		wp_enqueue_script( 'justice-general-js' );
		
		// Map Js load only where needed
		$gmap_key = $tpath_options['google_map_api']?$tpath_options['google_map_api']:'';
		wp_register_script( 'justice-gmap-js', get_template_directory_uri() . '/js/gmap.min.js', array('jquery') );
		wp_register_script( 'justice-gmap-api-js', 'http://maps.google.com/maps/api/js?key='.$gmap_key.'sensor=false&amp;language=en', array('jquery') );		
				
		// Easy Ticker Js		
		wp_register_script( 'justice-easy-ticker-js', get_template_directory_uri() . '/js/jquery.easy-ticker.min.js', array('jquery') );
		
		wp_enqueue_script( 'mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
		
		// Video Slider Js
		wp_register_script( 'justice-video-slider-js', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array('jquery') );
		
		// Countdown Js
		wp_register_script( 'justice-countdown-plugin-js', get_template_directory_uri() . '/js/jquery.countdown-plugin.min.js', array('jquery'), null );
		wp_register_script( 'justice-countdown-js', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), null );
		
		// Counter Js
		wp_register_script( 'justice-countto-js', get_template_directory_uri() . '/js/jquery.countTo.js', array('jquery') );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		// Load Javascripts	in Footer
		wp_register_script( 'justice-main-js', get_template_directory_uri() . '/js/jquery.main.js', array(), null, true );
		wp_enqueue_script( 'justice-main-js' );
		
		wp_register_script( 'justice-modernizr-js', get_template_directory_uri() . '/js/modernizr.min.js', array('jquery'), '2.8.3', true );
		wp_enqueue_script( 'justice-modernizr-js' );
		
		wp_register_script( 'justice-prettyphoto-js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), '3.1.5', true );
		wp_enqueue_script( 'justice-prettyphoto-js' );
		
		wp_register_script( 'justice-ratings', get_template_directory_uri() . '/js/jquery.rateit.min.js', array('jquery'), null, true );
		wp_enqueue_script( 'justice-ratings' );
		
		// Carousel Slider Js
		wp_register_script( 'justice-carousel-slider-js', get_template_directory_uri() . '/js/jquery.carousel.min.js', array('jquery'), null, true );
		wp_enqueue_script( 'justice-carousel-slider-js' );
		
		wp_register_script( 'justice-carousel-custom-js', get_template_directory_uri() . '/js/carousel-custom.js', array('jquery'), null, true );
		wp_enqueue_script( 'justice-carousel-custom-js' );
	
		if( is_page_template( 'template-contact.php' ) && $tpath_options['tpath_show_google_map_contact'] && $tpath_options['tpath_gmap_address'] ) {
			wp_enqueue_script( 'justice-gmap-api-js' );
			wp_enqueue_script( 'justice-gmap-js' );
		}
		
		$template_uri = get_template_directory_uri();
		
		wp_localize_script('jquery', 'justice_js_vars', array( 'justice_template_uri' 	=> $template_uri,
															  'justice_ajax_url'		=> admin_url('admin-ajax.php') ));

	} // End justice_load_theme_scripts()
	
}

/* =========================================
 * Load theme dynamic js in the <head>
 * ========================================= */

if ( ! function_exists( 'justice_enqueue_dynamic_js' ) ) {

	function justice_enqueue_dynamic_js () {
	
		global $tpath_options; ?>	

		<?php 
		ob_start();
		include_once TEMPLATEINCLUDES . '/theme-dynamic-js.php';
		$theme_dynamic_js = ob_get_contents();
		ob_get_clean();
		
		if( isset( $theme_dynamic_js ) && $theme_dynamic_js != '' ) {
			echo '<script type="text/javascript">'. $theme_dynamic_js . '</script>';
		}
		
	} // End justice_enqueue_dynamic_js()
}

/* =================================================================
 * Add [year] shortcode to display current year on copyright bar
 * ================================================================= */
 
if ( ! function_exists( 'justice_year_shortcode' ) ) { 
 
	function justice_year_shortcode() {
		$year = date('Y');
		return $year;
	}

}
add_shortcode('year', 'justice_year_shortcode');

/* =================================================================
 * Custom Excerpt Length used on archive/category and blog pages
 * ================================================================= */
 
function justice_custom_excerpt_length( $limit ) {	
	return '30';	
}

function justice_custom_excerpt_more( $more ) {
	return '...';
}

function justice_custom_excerpts($limit) {
    return wp_trim_words(get_the_excerpt(), $limit, '...');
}

/* =================================================================
 * Store Ajax admin url in head to call wherever need
 * ================================================================= */
if ( ! function_exists( 'justice_ajaxurl' ) ) { 

	function justice_ajaxurl() { ?>
	
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

	<?php } // End justice_ajaxurl()
}

/* =================================================================
 * Excerpt with allow some tags
 * ================================================================= */

function wpse_allowedtags() {
    // Add custom tags to this string
    return '<script>,<style>,<strong>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<blockquote>,<table>,<thead>,<tbody>,<th>,<tr>,<td>,<address>,<pre>,<code>,<span>,<iframe>,<div>,<source>,<button>,<dl>,<dt>,<dd>,<figure>,<figcaption>';
}

if ( ! function_exists( 'justice_custom_wp_trim_excerpt' ) ) {

    function justice_custom_wp_trim_excerpt($wpse_excerpt, $limit) {
		global $tpath_options, $post;
				
    	$raw_excerpt = $wpse_excerpt;
        if( '' == $wpse_excerpt ) {
		
			if( isset( $limit ) && $limit == '' ) {
				$limit = 168;
			}
		
			$post = get_post(get_the_ID());
			$pos = strpos($post->post_content, '<!--more-->');
			
			$readmore_link = '';
			
			$readmore_link = ' <span class="meta-link-more">&#91;...&#93;</span>';						

            $wpse_excerpt = get_the_content( $readmore_link );
			
			if( $post->post_excerpt || $pos !== false ) {
				if( ! $pos ) {
					$wpse_excerpt = rtrim( get_the_excerpt(), '[&hellip;]' );
				}				
			}
						
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
			$excerpt_word_count = $limit;
			//$excerpt_length = apply_filters('tpath_custom_excerpt_length', $excerpt_word_count); 
			$tokens = array();
			$excerptOutput = '';
			$count = 0;

			// Divide the string into tokens; HTML tags, or words, followed by any whitespace
			preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

			foreach ($tokens[0] as $token) { 

				if ($count >= $excerpt_word_count && preg_match('/[\,\:\;\?\.\!]\s*$/uS', $token)) { 
					// Limit reached, continue until , : ; ? . or ! occur at the end
					$excerptOutput .= trim($token);
					break;
				}

				// Add words to complete sentence
				$count++;

				// Append what's left of the token
				$excerptOutput .= $token;
			}

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));
			
			$wpse_excerpt = do_shortcode( $wpse_excerpt );
             
            return $wpse_excerpt;

        }
		
        return apply_filters('justice_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

}