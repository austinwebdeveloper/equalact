<?php 

/**
 * VC Functions
 */
require_once TEMPLATETHEME_DIR . '/vc_includes/admin_vc_functions.php';

/**
 * VC Base layouts
 */
require_once TEMPLATETHEME_DIR . '/vc_includes/vc_layouts.php';

/**
 * Page builder Additional blocks
 */

// Section Title Shortcode
if( ! function_exists('tpath_section_title_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_section_title_block.php';
}

// Icons Shortcode
if( ! function_exists('tpath_iconslist_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_icons_block.php';
}

// Features Shortcode
if( ! function_exists('tpath_features_box_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_features_box_block.php';
}

// Counters Shortcode
if( ! function_exists('tpath_counter_block_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_counters_block.php';
}

// Contact Form Shortcode
if( ! function_exists('tpath_vc_contact_form_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_contact_form.php';
}

// Portfolio Shortcode
if( ! function_exists('tpath_portfolio_gallery_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_portfolio_block.php';
}

// Team Shortcode
if( ! function_exists('tpath_team_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_team_block.php';
}

// Testimonial Shortcode
if( ! function_exists('tpath_testimonial_slider_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_testimonial_slider_block.php';
}

// Clients Shortcode
if( ! function_exists('tpath_clients_slider_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_clients_slider_block.php';
}

// Google Map Shortcode
if( ! function_exists('tpath_google_map_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_google_map_block.php';
}

// Twitter Shortcode
if( ! function_exists('tpath_twitter_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_twitter_block.php';
}

// Blog Shortcode
if( ! function_exists('tpath_blog_posts_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_blog_block.php';
}

// Latest Posts Shortcode
if( ! function_exists('tpath_latest_posts_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_latest_posts.php';
}

// About Me Shortcode
if( ! function_exists('tpath_about_me_shortcode') ) {
	require_once TEMPLATETHEME_DIR. '/vc_blocks/vc_about_me_block.php';
}