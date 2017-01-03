<?php
/*
Plugin Name: Template Core
Plugin URI: http://templatepath.com
Description: Template Core Plugin for Template Path Themes
Version: 1.0
Author: Template Path
Author URI: http://themeforest.net/user/template_path
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/* ==========================================
 * Shortcodes
 * ========================================== */
if( ! class_exists( 'TemplateCore_Plugin' ) ) {
	class TemplateCore_Plugin {
	
		/**
		 * Plugin version.
		 *
		 * @since  1.0
		 */
		const VERSION = '1.0';	
		
		/**
		 * Instance of this class.
		 *
		 * @since  1.0
		 */
		protected static $instance = null;	
		
		/**
		 * Initialize the plugin
		 *
		 * @since  1.0
		 */
		private function __construct() {
		
			define( 'TEMPLATE_CORE_DIR', plugin_dir_path(__FILE__));
			define( 'TEMPLATE_CORE_URL', plugin_dir_url(__FILE__));
		
			define( 'TEMPLATE_TINYMCE_URI', plugin_dir_url( __FILE__ ) . 'tinymce' );			
			define( 'TEMPLATE_TINYMCE_DIR', plugin_dir_path( __FILE__ ) . 'tinymce' );
			
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('wp_enqueue_scripts', array(&$this, 'template_custom_scripts'), 30);
			add_action('after_setup_theme', array(&$this, 'load_template_core_text_domain'));
			add_action('wp_ajax_tpath_shortcodes_popup', array(&$this, 'template_popup'));
		}

		/**
		 * Registers TinyMCE rich editor buttons
		 *
		 * @return	void
		 */
		function init() {
			if ( get_user_option('rich_editing') == 'true' )
			{
				add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
				add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
			}

			require_once TEMPLATE_CORE_DIR . '/shortcodes/shortcodes.php';

		}
		
		/**
		 * Register the plugin text domain
		 *
		 * @return void
		 */		
		function load_template_core_text_domain() {
			load_plugin_textdomain( 'TemplateCore', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
		}
		
		/**
		 * Return an instance of this class.
		 *
		 * @since	 1.0
		 *
		 * @return	object	A single instance of this class.
		 */
		public static function tc_get_instance() {
			
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
			
		}		

		/**
		 * Defins TinyMCE rich editor js plugin
		 *
		 * @return	void
		 */
		function add_rich_plugins( $plugin_array )
		{
			if( is_admin() ) {
				$plugin_array['tpathShortcodes'] = TEMPLATE_TINYMCE_URI . '/plugin.js';
			}

			return $plugin_array;
		}

		/**
		 * Adds TinyMCE rich editor buttons
		 *
		 * @return	void
		 */
		function register_rich_buttons( $buttons )
		{
			array_push( $buttons, 'tpath_button' );
			return $buttons;
		}

		/**
		 * Enqueue Scripts and Styles
		 *
		 * @return	void
		 */
		function admin_init()
		{
			// css
			wp_enqueue_style( 'shortcodes-popup', TEMPLATE_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );			
			wp_enqueue_style( 'font-awesome', TEMPLATE_TINYMCE_URI . '/css/font-awesome.css', false, '4.2.0', 'all' );
			wp_enqueue_style( 'simple-line-icons', TEMPLATE_TINYMCE_URI . '/css/simple-line-icons.css', false, '1.0', 'all' );
			wp_enqueue_style( 'flat-icons', TEMPLATE_TINYMCE_URI . '/css/flaticon.css', false, '1.0', 'all' );
			wp_enqueue_style( 'wp-color-picker' );

			// js
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-livequery', TEMPLATE_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
			wp_enqueue_script( 'jquery-appendo', TEMPLATE_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
			wp_enqueue_script( 'base64', TEMPLATE_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
			wp_enqueue_script( 'bootstrap-tooltip', TEMPLATE_TINYMCE_URI . '/js/bootstrap-tooltip.js', false, '2.2.2', false );	
			wp_enqueue_script( 'bootstrap-popover', TEMPLATE_TINYMCE_URI . '/js/bootstrap-popover.js', false, '2.2.2', false );	
			wp_enqueue_script( 'wp-color-picker' );

			wp_enqueue_script( 'tpath-popup', TEMPLATE_TINYMCE_URI . '/js/popup.js', false, '1.0', true );

			wp_localize_script( 'tpath-popup', 'TpathShortcodes', array( 'plugin_folder' => plugins_url( '', __FILE__ ) ) );
		}
		
		/**
		 * Popup function to show shortcode options in thickbox.
		 *
		 * @return void
		 */
		function template_popup() {

			require_once( TEMPLATE_TINYMCE_DIR . '/popup.php' );

			die();

		}
		
		/**
		 * Enqueue Scripts and Styles
		 *
		 * @return	void
		 */
		function template_custom_scripts()
		{
			if( ! is_admin() ) {
				wp_enqueue_style( 'template-shortcodes', TEMPLATE_CORE_URL . 'shortcodes.css' );				
			}		
			
		}
				
	}
}
// Load the instance of the plugin
add_action( 'plugins_loaded', array( 'TemplateCore_Plugin', 'tc_get_instance' ) );

/* ==========================================
 * Register Custom Post Types
 * ========================================== */
function tpath_core_register_post_types() {
	
	global $tpath_options;
	
	$block_labels = array(
		'name' 					=> __( 'Blocks', 'TemplateCore' ),
		'singular_name' 		=> __( 'Blocks', 'TemplateCore' ),
		'add_new' 				=> __( 'Add New', 'TemplateCore' ),
		'add_new_item' 			=> __( 'Add New Block', 'TemplateCore' ),
		'edit_item' 			=> __( 'Edit Block', 'TemplateCore' ),
		'new_item' 				=> __( 'New Block', 'TemplateCore' ),
		'all_items' 			=> __( 'Blocks', 'TemplateCore' ),
		'view_item' 			=> __( 'View Block', 'TemplateCore' ),
		'search_items' 			=> __( 'Search Blocks', 'TemplateCore' ),
		'not_found' 			=> __( 'No Blocks found', 'TemplateCore' ),
		'not_found_in_trash' 	=> __( 'No Blocks found in Trash', 'TemplateCore' ), 
		'parent_item_colon' 	=> ''
	);
	
	$block_args = array(
		'labels' 				=> $block_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'block' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'editor' )
	);
	
	register_post_type( 'tpath_block', $block_args );
	
	$portfolio_labels = array(
		'name' 					=> __( 'Portfolio', 'TemplateCore' ),
		'singular_name' 		=> __( 'Portfolio', 'TemplateCore' ),
		'add_new' 				=> __( 'Add New', 'TemplateCore' ),
		'add_new_item' 			=> __( 'Add New Portfolio', 'TemplateCore' ),
		'edit_item' 			=> __( 'Edit Portfolio', 'TemplateCore' ),
		'new_item' 				=> __( 'New Portfolio', 'TemplateCore' ),
		'all_items' 			=> __( 'Portfolio', 'TemplateCore' ),
		'view_item' 			=> __( 'View Portfolio', 'TemplateCore' ),
		'search_items' 			=> __( 'Search Portfolio', 'TemplateCore' ),
		'not_found' 			=> __( 'No Portfolio found', 'TemplateCore' ),
		'not_found_in_trash' 	=> __( 'No Portfolio found in Trash', 'TemplateCore' ), 
		'parent_item_colon' 	=> ''
	);
	
	$portfolio_args = array(
		'labels' 				=> $portfolio_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'portfolio' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail', 'editor' )
	);
	
	register_post_type( 'tpath_portfolio', $portfolio_args );
	
	$portfolio_category_labels = array(
		'name'              	=> __( 'Categories', 'TemplateCore' ),
		'singular_name'     	=> __( 'Category', 'TemplateCore' ),
		'search_items'      	=> __( 'Search Categories', 'TemplateCore' ),
		'all_items'         	=> __( 'All Categories', 'TemplateCore' ),
		'parent_item'       	=> __( 'Parent Category', 'TemplateCore' ),
		'parent_item_colon' 	=> __( 'Parent Category:', 'TemplateCore' ),
		'edit_item'         	=> __( 'Edit Category', 'TemplateCore' ),
		'update_item'       	=> __( 'Update Category', 'TemplateCore' ),
		'add_new_item'      	=> __( 'Add New Category', 'TemplateCore' ),
		'new_item_name'     	=> __( 'New Category Name', 'TemplateCore' ),
		'menu_name'         	=> __( 'Categories', 'TemplateCore' ),
	);

	$portfolio_category_args = array(
		'hierarchical'      	=> true,
		'labels'            	=> $portfolio_category_labels,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_nav_menus' 	=> false,
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'portfolio-categories' ),
	);
	
	register_taxonomy( 'portfolio_categories', 'tpath_portfolio', $portfolio_category_args );
	
	$portfolio_skills_labels = array(
		'name'              	=> __( 'Tags', 'TemplateCore' ),
		'singular_name'     	=> __( 'Tag', 'TemplateCore' ),
		'search_items'      	=> __( 'Search Tags', 'TemplateCore' ),
		'all_items'         	=> __( 'All Tags', 'TemplateCore' ),
		'parent_item'       	=> __( 'Parent Tag', 'TemplateCore' ),
		'parent_item_colon' 	=> __( 'Parent Tag:', 'TemplateCore' ),
		'edit_item'         	=> __( 'Edit Tag', 'TemplateCore' ),
		'update_item'       	=> __( 'Update Tag', 'TemplateCore' ),
		'add_new_item'      	=> __( 'Add New Tag', 'TemplateCore' ),
		'new_item_name'     	=> __( 'New Tag', 'TemplateCore' ),
		'menu_name'         	=> __( 'Tags', 'TemplateCore' ),
	);

	$portfolio_skills_args = array(
		'hierarchical'      	=> true,
		'labels'            	=> $portfolio_skills_labels,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_nav_menus' 	=> false,
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'portfolio-skills' ),
	);
	
	register_taxonomy( 'portfolio_skills', 'tpath_portfolio', $portfolio_skills_args );
					
	$testimonial_labels = array(
		'name' 					=> __( 'Testimonial', 'TemplateCore' ),
		'singular_name' 		=> __( 'Testimonial', 'TemplateCore' ),
		'add_new' 				=> __( 'Add New', 'TemplateCore' ),
		'add_new_item' 			=> __( 'Add New Testimonial', 'TemplateCore' ),
		'edit_item' 			=> __( 'Edit Testimonial', 'TemplateCore' ),
		'new_item' 				=> __( 'New Testimonial', 'TemplateCore' ),
		'all_items' 			=> __( 'Testimonials', 'TemplateCore' ),
		'view_item' 			=> __( 'View Testimonial', 'TemplateCore' ),
		'search_items' 			=> __( 'Search Testimonials', 'TemplateCore' ),
		'not_found' 			=> __( 'No Testimonials found', 'TemplateCore' ),
		'not_found_in_trash' 	=> __( 'No testimonials found in Trash', 'TemplateCore' ), 
		'parent_item_colon' 	=> ''
	);
	
	$testimonial_args = array(
		'labels' 				=> $testimonial_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'testimonial' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail', 'editor' )
	);
	
	register_post_type( 'tpath_testimonial', $testimonial_args );
	
	$testimonial_category_labels = array(
		'name'              	=> __( 'Categories', 'TemplateCore' ),
		'singular_name'     	=> __( 'Category', 'TemplateCore' ),
		'search_items'      	=> __( 'Search Categories', 'TemplateCore' ),
		'all_items'         	=> __( 'All Categories', 'TemplateCore' ),
		'parent_item'       	=> __( 'Parent Category', 'TemplateCore' ),
		'parent_item_colon' 	=> __( 'Parent Category:', 'TemplateCore' ),
		'edit_item'         	=> __( 'Edit Category', 'TemplateCore' ),
		'update_item'       	=> __( 'Update Category', 'TemplateCore' ),
		'add_new_item'      	=> __( 'Add New Category', 'TemplateCore' ),
		'new_item_name'     	=> __( 'New Category Name', 'TemplateCore' ),
		'menu_name'         	=> __( 'Categories', 'TemplateCore' ),
	);

	$testimonial_category_args = array(
		'hierarchical'      	=> true,
		'labels'            	=> $testimonial_category_labels,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_nav_menus' 	=> false,
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'authors' ),
	);
	
	register_taxonomy( 'testimonial_categories', 'tpath_testimonial', $testimonial_category_args );
	
	// Team Member
	$team_labels = array(
		'name' 					=> __( 'Team Member', 'TemplateCore' ),
		'singular_name' 		=> __( 'Team Member', 'TemplateCore' ),
		'add_new' 				=> __( 'Add New', 'TemplateCore' ),
		'add_new_item' 			=> __( 'Add New Member', 'TemplateCore' ),
		'edit_item' 			=> __( 'Edit Member', 'TemplateCore' ),
		'new_item' 				=> __( 'New Member', 'TemplateCore' ),
		'all_items' 			=> __( 'Team Members', 'TemplateCore' ),
		'view_item' 			=> __( 'View Members', 'TemplateCore' ),
		'search_items' 			=> __( 'Search Members', 'TemplateCore' ),
		'not_found' 			=> __( 'No Members found', 'TemplateCore' ),
		'not_found_in_trash' 	=> __( 'No Members found in Trash', 'TemplateCore' ), 
		'parent_item_colon' 	=> ''
	);
	
	$team_args = array(
		'labels' 				=> $team_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'team' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail', 'editor' )
	);
	
	register_post_type( 'tpath_team_member', $team_args );
	
	$team_member_category_labels = array(
		'name'              	=> __( 'Categories', 'TemplateCore' ),
		'singular_name'     	=> __( 'Category', 'TemplateCore' ),
		'search_items'      	=> __( 'Search Categories', 'TemplateCore' ),
		'all_items'         	=> __( 'All Categories', 'TemplateCore' ),
		'parent_item'       	=> __( 'Parent Category', 'TemplateCore' ),
		'parent_item_colon' 	=> __( 'Parent Category:', 'TemplateCore' ),
		'edit_item'         	=> __( 'Edit Category', 'TemplateCore' ),
		'update_item'       	=> __( 'Update Category', 'TemplateCore' ),
		'add_new_item'      	=> __( 'Add New Category', 'TemplateCore' ),
		'new_item_name'     	=> __( 'New Category Name', 'TemplateCore' ),
		'menu_name'         	=> __( 'Categories', 'TemplateCore' ),
	);

	$team_member_category_args = array(
		'hierarchical'      	=> true,
		'labels'            	=> $team_member_category_labels,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_nav_menus' 	=> false,
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'members' ),
	);
	
	register_taxonomy( 'team_member_categories', 'tpath_team_member', $team_member_category_args );
	
	$client_labels = array(
		'name' 					=> __( 'Clients', 'TemplateCore' ),
		'singular_name' 		=> __( 'Client', 'TemplateCore' ),
		'add_new' 				=> __( 'Add New', 'TemplateCore' ),
		'add_new_item' 			=> __( 'Add New Client', 'TemplateCore' ),
		'edit_item' 			=> __( 'Edit Client', 'TemplateCore' ),
		'new_item' 				=> __( 'New Client', 'TemplateCore' ),
		'all_items' 			=> __( 'Clients', 'TemplateCore' ),
		'view_item' 			=> __( 'View Client', 'TemplateCore' ),
		'search_items' 			=> __( 'Search Clients', 'TemplateCore' ),
		'not_found' 			=> __( 'No Clients found', 'TemplateCore' ),
		'not_found_in_trash' 	=> __( 'No clients found in Trash', 'TemplateCore' ), 
		'parent_item_colon' 	=> ''
	);
	
	$client_args = array(
		'labels' 				=> $client_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'client' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail' )
	);
	
	register_post_type( 'tpath_clients', $client_args );
	
	$clients_category_labels = array(
		'name'              	=> __( 'Categories', 'TemplateCore' ),
		'singular_name'     	=> __( 'Category', 'TemplateCore' ),
		'search_items'      	=> __( 'Search Categories', 'TemplateCore' ),
		'all_items'         	=> __( 'All Categories', 'TemplateCore' ),
		'parent_item'       	=> __( 'Parent Category', 'TemplateCore' ),
		'parent_item_colon' 	=> __( 'Parent Category:', 'TemplateCore' ),
		'edit_item'         	=> __( 'Edit Category', 'TemplateCore' ),
		'update_item'       	=> __( 'Update Category', 'TemplateCore' ),
		'add_new_item'      	=> __( 'Add New Category', 'TemplateCore' ),
		'new_item_name'     	=> __( 'New Category Name', 'TemplateCore' ),
		'menu_name'         	=> __( 'Client Categories', 'TemplateCore' ),
	);

	$client_category_args = array(
		'hierarchical'      	=> true,
		'labels'            	=> $clients_category_labels,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_nav_menus' 	=> false,
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'clients' ),
	);
	
	register_taxonomy( 'client_categories', 'tpath_clients', $client_category_args );
	
	flush_rewrite_rules();

}
add_action( 'init', 'tpath_core_register_post_types' );