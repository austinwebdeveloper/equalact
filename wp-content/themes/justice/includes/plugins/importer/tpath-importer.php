<?php 
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );

/* ================================================
 * Admin Init Hook for Importer
 * ================================================ */
if ( ! function_exists( 'tpath_demo_importer' ) ) {

	function tpath_demo_importer() {
		global $wpdb;
	
		if ( current_user_can( 'manage_options' ) && isset( $_GET['import_demo'] ) ) {
			if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers
	
			if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
				$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				include $wp_importer;
			}
	
			if ( ! class_exists('Tpath_WP_Import') ) { // if WP importer doesn't exist
				$wp_import = TEMPLATETHEME_DIR . '/includes/plugins/importer/wordpress-importer.php';
				include $wp_import;
			}
	
			if ( class_exists( 'WP_Importer' ) && class_exists( 'TPath_WP_Import' ) ) { // check for main import class and wp import class
			
				/* Import Demo Content */
				if( isset( $_GET['import_content'] ) ) {
					
					$importer = new Tpath_WP_Import();
					/* Import Posts, Pages, Portfolio, Images, Menus */
					$theme_xml = TEMPLATEINCLUDES . 'plugins/importer/data/demo.xml';
					$importer->fetch_attachments = true;
					ob_start();
					$importer->import($theme_xml);
					ob_end_clean();
					
					/* Set imported menus to Registered Menu locations in Theme */
								
					// Registered Menu Locations in Theme
					$locations = get_theme_mod( 'nav_menu_locations' );
					// Get Registered menus
					$menus = wp_get_nav_menus();
					
					// Assign menus to theme locations 
					if(is_array($menus)) {
						foreach($menus as $menu) {
							if( $menu->name == 'Main Menu' ) {
								$locations['primary-menu'] = $menu->term_id;
							}
						}
					}
		
					set_theme_mod( 'nav_menu_locations', $locations );
										
				}

				/* Import Theme Options */
				if( isset( $_GET['import_options'] ) ) {
					
					// Theme options file
					$theme_options = TEMPLATETHEME_URL . '/includes/plugins/importer/data/theme_options.txt';
					$theme_options = wp_remote_get( $theme_options );
					$smof_data = unserialize(base64_decode( $theme_options['body'] ));
					// Update Theme Options
					$theme = get_option( 'stylesheet' );
					update_option( "theme_mods_$theme", $smof_data );
					
				}
	
				// finally redirect to success page
				wp_redirect( admin_url( 'themes.php?page=tpath_options&imported=success' ) );
			}
		}
	}
}

add_action( 'admin_init', 'tpath_demo_importer' );