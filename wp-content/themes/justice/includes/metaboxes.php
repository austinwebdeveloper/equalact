<?php
/** 
 * Custom Meta Boxes and Fields for Post, Pages and other custom post types
 *
 * @package TemplatePath
 */ 
 
class TpathMetaboxes {
	
	public function __construct() 
	{
		global $tpath_options;
		$this->tpath_options = $tpath_options;

		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
		add_action('admin_enqueue_scripts', array($this, 'load_admin_script'));
	}

	// Load Admin Scripts
	function load_admin_script() {
		global $pagenow;
		
		if( is_admin() && $pagenow != 'themes.php' ) {
			wp_enqueue_style('admin-style', get_template_directory_uri() .'/css/admin-custom.css');
		}
		
		if( is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php') ) {
			
			wp_register_style('select2-style', TEMPLATETHEME_URL . '/admin/assets/css/select2.css');
	    	wp_enqueue_style('select2-style');
						
			wp_register_script('admin-media', get_template_directory_uri().'/js/metabox.js');
	    	wp_enqueue_script('admin-media');
			
			wp_register_script('select2', TEMPLATETHEME_URL . '/admin/assets/js/select2.js');
	    	wp_enqueue_script('select2');
			
	    	wp_enqueue_media();
			
			wp_enqueue_script('jquery-ui-core');			
			wp_enqueue_script('jquery-ui-slider');
			
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
						
		}
	}
	
	// Add Meta Boxes for different Post types
	public function add_meta_boxes()
	{
		$this->add_meta_box('post_options', 'Post Options', 'post_metabox', 'post');
		$this->add_meta_box('page_options', 'Page Options', 'page_metabox', 'page');
		if( class_exists('Woocommerce') ) {
			$this->add_meta_box('product_options', 'Product Options', 'product_metabox', 'product');
		}
		$this->add_meta_box('testimonial_options', 'Testimonial Options', 'testimonial_metabox', 'tpath_testimonial');
		$this->add_meta_box('team_options', 'Team Member Options', 'team_metabox', 'tpath_team_member');
		$this->add_meta_box('portfolio_options', 'Portfolio Options', 'portfolio_metabox', 'tpath_portfolio');
		$this->add_meta_box('clients_options', 'Client Options', 'client_metabox', 'tpath_clients');
	}
	
	// Add Meta Box for each types
	public function add_meta_box($id, $title, $callback, $post_type)
	{
	    add_meta_box( 'tpath_' . $id, $title, array($this, 'tpath_' . $callback), $post_type, 'normal', 'high' );		 
	}
	
	// Save meta box fields
	public function save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
				
		// check permissions
		if( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if( !current_user_can('edit_page', $post_id) )
			return $post_id;
		} elseif( !current_user_can('edit_post', $post_id) ) {
			return $post_id;
		}
				
		foreach($_POST as $key => $value) {
			if(strstr($key, 'tpath_')) {
				update_post_meta($post_id, $key, $value );
			}
		}
	}

	public function tpath_post_metabox()
	{
		$tpathpostfields = new TpathMetaboxFields();
		$tpathpostfields->render_fields( $tpathpostfields->render_post_fields() );
	}

	public function tpath_page_metabox()
	{
		$tpathpagefields = new TpathMetaboxFields();
		$tpathpagefields->render_fields( $tpathpagefields->render_page_fields() );
	}	

	public function tpath_testimonial_metabox()
	{
		$tpathtestimonialfields = new TpathMetaboxFields();
		$tpathtestimonialfields->render_fields( $tpathtestimonialfields->render_testimonial_fields() );
	}
		
	public function tpath_team_metabox()
	{
		$tpathteamfields = new TpathMetaboxFields();
		$tpathteamfields->render_fields( $tpathteamfields->render_team_fields() );
	}
	
	public function tpath_portfolio_metabox()
	{
		$tpathportfoliofields = new TpathMetaboxFields();
		$tpathportfoliofields->render_fields( $tpathportfoliofields->render_portfolio_fields() );
	}
	
	public function tpath_client_metabox()
	{
		$tpathclientfields = new TpathMetaboxFields();
		$tpathclientfields->render_fields( $tpathclientfields->render_client_fields() );
	}
	
	public function tpath_product_metabox()
	{
		$tpathproductfields = new TpathMetaboxFields();
		$tpathproductfields->render_fields( $tpathproductfields->render_product_fields() );
	}
	
}

$metaboxes = new TpathMetaboxes;