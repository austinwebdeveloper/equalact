<?php
/**
 * Theme Functions and Definitions
 *
 * @package TemplatePath
 */
 
// Set path to theme specific functions
$library_path = get_template_directory() . '/lib/';
$includes_path = get_template_directory() . '/includes/';
$admin_path = get_template_directory() . '/admin/';

// Define path to theme specific functions
define( 'TEMPLATELIBRARY', $library_path );
define( 'TEMPLATEINCLUDES', $includes_path );
define( 'TEMPLATEADMIN', $admin_path );
define( 'TEMPLATEADMIN_URL', get_template_directory_uri() . '/admin/' );
define( 'TEMPLATETHEME_URL', get_template_directory_uri() );
define( 'TEMPLATETHEME_DIR', get_template_directory() );
define( 'TEMPLATETHEME_COLOR_SCHEMES', get_template_directory() . '/color-schemes/' );
 
/**
 * Theme Options Panel Admin
 */
require TEMPLATEADMIN . 'index.php';

class Justice_Init {

	public function __construct() {
	
		/**
		 * Register Sidebar
		 */
		require_once TEMPLATEINCLUDES . 'sidebar-register.php';
		
		/**
		 * Theme Actions and Filters
		 */
		require_once TEMPLATEINCLUDES . 'theme-filters.php';
		
		/**
		 * Theme Functions
		 */
		require_once TEMPLATEINCLUDES . 'theme-functions.php';
		
		/**
		 * Admin Custom Meta Boxes
		 */
		include_once TEMPLATEINCLUDES . 'metaboxes.php';
		
		/**
		 * Admin Custom Meta Box Fields
		 */
		include_once TEMPLATEINCLUDES . 'register-metabox-types.php';
		
		/**
		 * Bootstrap Library Files
		 */
		require_once TEMPLATELIBRARY . 'wp_bootstrap_navwalker.php';
		require_once TEMPLATELIBRARY . 'wp_bootstrap_mobile_navwalker.php';
		
		/**
		 * Mega Menu Framework
		 */
		require_once TEMPLATEINCLUDES . 'class-megamenu-framework.php';
		
		/**
		 * Woocommerce Config
		 */
		if( class_exists('Woocommerce') ) {
			include_once( TEMPLATEINCLUDES . 'woo-config.php' );
		}
		
		/**
		 * Breadcrumbs
		 */
		require_once TEMPLATEINCLUDES . 'class-tpath-breadcrumbs.php';
		
		/**
		 * Demo Importer
		 */
		include_once TEMPLATEINCLUDES . 'plugins/importer/tpath-importer.php';
		
		/**
		 * TGM Plugin Activation
		 */
		require_once TEMPLATETHEME_DIR . '/includes/class-tgm-plugin-activation.php';
		
		/**
		 * Visual Composer ( Page Builder Elements )
		 */
		if( function_exists('vc_set_as_theme') ) {
			require_once TEMPLATETHEME_DIR . '/vc_includes/vc_init.php';
		}
		
		/**
		 * Include Widgets
		 */
		require_once TEMPLATETHEME_DIR . '/widgets/about_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/testimonials_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/facebook_like_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/twitter-widget/tweets_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/call_to_action_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/flickr_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/instagram_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/popular_posts_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/category_posts_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/tabs_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/contact_widget.php';
		require_once TEMPLATETHEME_DIR . '/widgets/social_link_widget.php';
		
	}
	
}
$justice = new Justice_Init();

/*
* Post Star Ratings
*/
require_once TEMPLATETHEME_DIR . '/includes/class-tpath-ratings.php';

$config_options = array();	
$config_options[] = array(
	'meta_key'			=>	'tpath_post_item_rating',
	'name'				=>	'Rating',
	'disable_on_update'	=>	FALSE,
	'max_rating_size'	=> 	5,
	'min_rating_size'	=> 	0,
	'active_post_types'	=>	array( 'tpath_testimonial' )
);

//Instatiate plugin class and pass config options array
new TpathPostRatings( $config_options );