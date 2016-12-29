<?php 
/**
 * Force Visual Composer to initialize as "built into the theme".
 * This will hide certain tabs under the Settings -> Visual Composer
 */
if( function_exists('vc_set_as_theme') ) {
	function Justice_vcSetAsTheme() {
		vc_set_as_theme( $disable_updater = true );
	}
	add_action( 'vc_before_init', 'Justice_vcSetAsTheme' );
}

function justice_vc_add_extra_attr() {

	/**
	 * Add background style to VC Row
	 */
	 
	vc_add_param( 'vc_row', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Background Style', 'Templatepath' ),
		'param_name'	=> 'background_style',
		'value'			=> array(
			__( 'Standard Settings', 'Templatepath' )				=> 'tpath-standard',
			__( 'Primary Background Color', 'Templatepath' )		=> 'primary-color',
			__( 'Primary Dark Background Color', 'Templatepath' )	=> 'primary-dark-color',
			__( 'Background Overlay', 'Templatepath' )				=> 'overlay-wrapper',
			__( 'Dark Background', 'Templatepath' )					=> 'dark-wrapper',
			__( 'Grey Background', 'Templatepath' )					=> 'grey-wrapper',
			__( 'White Background', 'Templatepath' )				=> 'white-wrapper',
		),
	) );
	
	vc_add_param( 'vc_row', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Overlay Color', 'Templatepath' ),
		'param_name'	=> 'bg_overlay_style',
		'value'			=> array(
			__( 'Theme Color', 'Templatepath' )				=> 'theme-overlay-color',
			__( 'Dark Color', 'Templatepath' )				=> 'dark-overlay-color',
			__( 'White Color', 'Templatepath' )				=> 'white-overlay-color',
		),
		'dependency'	=> array(
			'element'	=> 'background_style',
			'value'		=> array( 'overlay-wrapper' ),
		),
	) );
	
	vc_add_param( 'vc_row', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Center Row Content', 'Templatepath' ),
		'param_name'	=> 'center_row',
		'value'			=> array(
			__( 'Yes', 'Templatepath' )	=> 'yes',
			__( 'No', 'Templatepath' )	=> 'no',
		),
		'description'	=> __( 'Use this option to add container and center the inner content. Useful when using full-width pages.', 'Templatepath' ),
	) );
	
	/**
	 * Add options to VC Column
	 */
	 
	 vc_add_param( 'vc_column', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Border Style', 'Templatepath' ),
		'param_name'	=> 'border_style',
		'value'			=> array(
			__( 'Default', 'Templatepath' )						=> 'default',
			__( 'Bottom Only', 'Templatepath' )					=> 'bottom_only',
			__( 'Right Only', 'Templatepath' )					=> 'right_only',
			__( 'Bottom and Right', 'Templatepath' )			=> 'bottom_right',
			__( 'Bottom and Right Rotate', 'Templatepath' )		=> 'bottom_right_rotate',
		),
	) );
	
	vc_add_param( 'vc_column', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Background Style', 'Templatepath' ),
		'param_name'	=> 'column_bg',
		'value'			=> array(
			__( 'Default', 'Templatepath' )							=> 'column-bg-default',
			__( 'Primary Background Color', 'Templatepath' )		=> 'primary-color',
			__( 'Primary Dark Background Color', 'Templatepath' )	=> 'primary-dark-color',
			__( 'Background Overlay', 'Templatepath' )				=> 'overlay-wrapper',
			__( 'Dark Background', 'Templatepath' )					=> 'dark-wrapper',
			__( 'Grey Background', 'Templatepath' )					=> 'grey-wrapper',
			__( 'White Background', 'Templatepath' )				=> 'white-wrapper',
		),
	) );
	
	vc_add_param( 'vc_column', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Overlay Color', 'Templatepath' ),
		'param_name'	=> 'bg_overlay_style',
		'value'			=> array(
			__( 'Theme Color', 'Templatepath' )				=> 'theme-overlay-color',
			__( 'Dark Color', 'Templatepath' )				=> 'dark-overlay-color',
			__( 'White Color', 'Templatepath' )				=> 'white-overlay-color',
		),
		'dependency'	=> array(
			'element'	=> 'column_bg',
			'value'		=> array( 'overlay-wrapper' ),
		),
	) );
		
	vc_add_param( 'vc_column', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Typography Style', 'Templatepath' ),
		'param_name'	=> 'typo_style',
		'value'			=> array(
			__( 'Default', 'Templatepath' )				=> 'default',
			__( 'Dark Color', 'Templatepath' )			=> 'dark',
			__( 'Grey Color', 'Templatepath' )			=> 'grey',
			__( 'White Color', 'Templatepath' )			=> 'white',
		),
	) );
	
	/**
	 * Add border options to VC Column Inner
	 */
	 
	vc_add_param( 'vc_column_inner', array(
		'type'			=> 'dropdown',
		'heading'		=> __( 'Border Style', 'Templatepath' ),
		'param_name'	=> 'border_style',
		'value'			=> array(
			__( 'Default', 'Templatepath' )						=> 'default',
			__( 'Bottom Only', 'Templatepath' )					=> 'bottom_only',
			__( 'Right Only', 'Templatepath' )					=> 'right_only',
			__( 'Bottom and Right', 'Templatepath' )			=> 'bottom_right',
			__( 'Bottom and Right Rotate', 'Templatepath' )		=> 'bottom_right_rotate',
		),
	) );
	
	/**
	 * Section
	 */
	
	vc_remove_param( 'vc_tta_section', 'el_class' );

	vc_add_param( 'vc_tta_section', array(
		"type" 			=> "dropdown",
		"heading" 		=> __( "Icon library", "Templatepath" ),
		"value" 		=> array(
			__( "Font Awesome", "Templatepath" ) 	=> "fontawesome",
			__( 'Open Iconic', 'Templatepath' ) 	=> 'openiconic',
			__( 'Typicons', 'Templatepath' ) 		=> 'typicons',
			__( 'Entypo', 'Templatepath' ) 			=> 'entypo',
			__( "Lineicons", "Templatepath" ) 		=> "lineicons",
			__( "Flaticons", "Templatepath" ) 		=> "flaticons",
		),
		"admin_label" 	=> true,
		"param_name" 	=> "i_type",
		"dependency" 	=> array(
							"element" 	=> "add_icon",
							"value" 	=> "true",
						),
		"description" 	=> __( "Select icon library.", "Templatepath" ),
	) );
	
	vc_add_param( 'vc_tta_section', array(
		"type" 			=> 'iconpicker',
		"heading" 		=> __( "Icon", "Templatepath" ),
		"param_name" 	=> "i_icon_lineicons",
		"value" 		=> "",
		"settings" 		=> array(
			"emptyIcon" 	=> true,
			"type" 			=> 'simpleicons',
			"iconsPerPage" 	=> 4000,
		),
		"dependency" 	=> array(
			"element" 	=> "i_type",
			"value" 	=> "lineicons",
		),
		"description" 	=> __( "Select icon from library.", "Templatepath" ),
	) );
	
	vc_add_param( 'vc_tta_section', array(
		"type" 			=> 'iconpicker',
		"heading" 		=> __( "Icon", "Templatepath" ),
		"param_name" 	=> "i_icon_flaticons",
		"value" 		=> "",
		"settings" 		=> array(
			"emptyIcon" 	=> true,
			"type" 			=> 'flaticons',
			"iconsPerPage" 	=> 4000,
		),
		"dependency" 	=> array(
			"element" 	=> "i_type",
			"value" 	=> "flaticons",
		),
		"description" 	=> __( "Select icon from library.", "Templatepath" ),
	) );
	
	vc_add_param( 'vc_tta_section', array(
		'type' 			=> 'textfield',
		'heading' 		=> __( 'Extra class name', 'Templatepath' ),
		'param_name' 	=> 'el_class',
		'description' 	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'Templatepath' )
	) );

	/**
	 * Add Style to VC Tour
	 */
	vc_add_param( 'vc_tta_tour', array(
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				__( 'Custom Theme Style', 'Templatepath' )		 => 'tpath_tour_design',
				__( 'Classic', 'Templatepath' )					 => 'classic',
				__( 'Modern', 'Templatepath' )					 => 'modern',
				__( 'Flat', 'Templatepath' )					 => 'flat',
				__( 'Outline', 'Templatepath' )					 => 'outline',
			),
			'heading' 		=> __( 'Style', 'Templatepath' ),
			'description' 	=> __( 'Select tour display style.', 'Templatepath' ),
	) );
	
	/**
	 * Button
	 */
	 vc_add_param( 'vc_btn', array(
		"type" 			=> "dropdown",
		'heading' 		=> __( 'Style', 'Templatepath' ),
		'description' 	=> __( 'Select button display style.', 'Templatepath' ),
		'value' 		=> array(
			__( 'Default', 'Templatepath' ) 		=> 'default',
			__( 'Transparent', 'Templatepath' ) 	=> 'transparent',
			__( 'Modern', 'Templatepath' ) 			=> 'modern',
			__( 'Classic', 'Templatepath' ) 		=> 'classic',
			__( 'Flat', 'Templatepath' ) 			=> 'flat',
			__( 'Outline', 'Templatepath' ) 		=> 'outline',
			__( '3d', 'Templatepath' ) 				=> '3d',
			__( 'Custom', 'Templatepath' ) 			=> 'custom',
			__( 'Outline custom', 'Templatepath' ) 	=> 'outline-custom',
		),
		"param_name" 	=> "style",
	) );
	
	vc_add_param( 'vc_btn', array(
		'type' 					=> 'dropdown',
		'heading' 				=> __( 'Color', 'Templatepath' ),
		'param_name' 			=> 'color',
		'description' 			=> __( 'Select button color.', 'Templatepath' ),
		// compatible with btn2, need to be converted from btn1
		'param_holder_class' 	=> 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' 				=> array(
					// Theme Colors
					__( 'Default', 'Templatepath' ) 			=> 'primary-bg',
				   // Btn1 Colors
				   __( 'Classic Grey', 'Templatepath' ) 		=> 'default',
				   __( 'Classic Blue', 'Templatepath' ) 		=> 'primary',
				   __( 'Classic Turquoise', 'Templatepath' ) 	=> 'info',
				   __( 'Classic Green', 'Templatepath' ) 		=> 'success',
				   __( 'Classic Orange', 'Templatepath' )		=> 'warning',
				   __( 'Classic Red', 'Templatepath' ) 			=> 'danger',
				   __( 'Classic Black', 'Templatepath' ) 		=> "inverse"
				   // + Btn2 Colors (default color set)
			   ) + getVcShared( 'colors-dashed' ),
		'std' 					=> 'primary-bg',
		// must have default color grey
		'dependency' => array(
			'element' => 'style',
			'value_not_equal_to' => array( 'custom', 'outline-custom' )
		),
	) );
		
	/**
	 * Call To Action
	 */
	
	vc_add_param( 'vc_cta', array(
		'type' 			=> 'dropdown',
		'heading' 		=> __( 'Style', 'Templatepath' ),
		'param_name' 	=> 'style',
		'value' 		=> array(
			__( 'Default', 'Templatepath' ) 	=> 'default',
			__( 'Classic', 'Templatepath' ) 	=> 'classic',
			__( 'Flat', 'Templatepath' ) 		=> 'flat',
			__( 'Outline', 'Templatepath' ) 	=> 'outline',
			__( '3d', 'Templatepath' ) 			=> '3d',
			__( 'Custom', 'Templatepath' ) 		=> 'custom',
		),
		'std' 			=> 'default',
		'description' 	=> __( 'Select call to action display style.', 'Templatepath' ),
	) );
	
	vc_add_param( 'vc_cta', array(
		"type" 			=> "dropdown",
		'heading' 		=> __( 'Style', 'Templatepath' ),
		'description' 	=> __( 'Select button display style.', 'Templatepath' ),
		'value' 		=> array(
			__( 'Default', 'Templatepath' ) 		=> 'default',
			__( 'Transparent', 'Templatepath' ) 	=> 'transparent',
			__( 'Modern', 'Templatepath' ) 			=> 'modern',
			__( 'Classic', 'Templatepath' ) 		=> 'classic',
			__( 'Flat', 'Templatepath' ) 			=> 'flat',
			__( 'Outline', 'Templatepath' ) 		=> 'outline',
			__( '3d', 'Templatepath' ) 				=> '3d',
			__( 'Custom', 'Templatepath' ) 			=> 'custom',
			__( 'Outline custom', 'Templatepath' ) 	=> 'outline-custom',
		),
		'dependency' 			=> array(
			'element' 		=> 'add_button',
			'not_empty' 	=> true,
		),
		"integrated_shortcode" 			=> "vc_btn",
		"integrated_shortcode_field" 	=> "btn_",
		"param_name" 					=> "btn_style",
		"group"							=> __( 'Button', 'Templatepath' ),
	) );
	
	/**
	 * Portfolio Categories
	 */
	$portfolio_args = array(
		'post_type' 		=> 'tpath_portfolio',
		'orderby' 			=> 'name',
		'hide_empty' 		=> 0,
		'hierarchical' 		=> 1,
		'taxonomy' 			=> 'portfolio_categories'
	);
	
	$portfolio_cats = get_categories( $portfolio_args );
	$portfolio_cats_list = array( 'Show All Categories' => 'all' );
	
	foreach( $portfolio_cats as $cat ) {
		$portfolio_cats_list[$cat->name] = $cat->term_id;
	}
	
	$attributes = array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Choose Portfolio Category", "Templatepath"),
					"param_name" 	=> "categories",
					"value" 		=> $portfolio_cats_list,
					"description" 	=> ''
				);
	
	vc_add_param('tpath_vc_portfolio', $attributes);
	
	/**
	 * Team Categories
	 */
	$team_args = array(
		'post_type' 		=> 'tpath_team_member',
		'orderby' 			=> 'name',
		'hide_empty' 		=> 0,
		'hierarchical' 		=> 1,
		'taxonomy' 			=> 'team_member_categories'
	);
	
	$team_cats = get_categories( $team_args );
	$team_cats_list = array( 'Show All Categories' => 'all' );
	
	foreach( $team_cats as $team_cat ){
		$team_cats_list[$team_cat->name] = $team_cat->term_id;
	}
	
	$attributes = array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Choose Team Category", "Templatepath"),
					"param_name" 	=> "categories",
					"value" 		=> $team_cats_list,
					"description" 	=> ''
				);
	
	vc_add_param('tpath_vc_team', $attributes);
	
	/**
	 * Testimonial Categories
	 */
	$testimonial_args = array(
		'post_type' 		=> 'tpath_testimonial',
		'orderby' 			=> 'name',
		'hide_empty' 		=> 0,
		'hierarchical' 		=> 1,
		'taxonomy' 			=> 'testimonial_categories'
	);
	
	$testimonial_cats = get_categories( $testimonial_args );
	$testimonial_cats_list = array( 'Show All Categories' => 'all' );
	
	foreach( $testimonial_cats as $testimonial_cat ){
		$testimonial_cats_list[$testimonial_cat->name] = $testimonial_cat->term_id;
	}
	
	$attributes = array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Choose Testimonial Category", "Templatepath"),
					"param_name" 	=> "categories",
					"value" 		=> $testimonial_cats_list,
					"description" 	=> ''
				);
	
	vc_add_param('tpath_vc_testimonial', $attributes);
	
	/**
	 * Client Categories
	 */
	$client_args = array(
		'post_type' 		=> 'tpath_clients',
		'orderby' 			=> 'name',
		'hide_empty' 		=> 0,
		'hierarchical' 		=> 1,
		'taxonomy' 			=> 'client_categories'
	);
	
	$client_cats = get_categories( $client_args );
	$client_cats_list = array( 'Show All Categories' => 'all' );
	
	foreach( $client_cats as $client_cat ){
		$client_cats_list[$client_cat->name] = $client_cat->term_id;
	}
	
	$attributes = array(
					"type" 			=> "dropdown",
					"heading" 		=> __("Choose Client Category", "Templatepath"),
					"param_name" 	=> "categories",
					"value" 		=> $client_cats_list,
					"description" 	=> ''
				);
	
	vc_add_param('tpath_vc_clients', $attributes);	
	
}
add_action('init', 'justice_vc_add_extra_attr', 999);

/* =============================================================
 *	Add Custom Flaticons to VC
 * ============================================================= */
if( ! function_exists('justice_vc_custom_flaticons') ) {
	function justice_vc_custom_flaticons( $icons ) {
		
		$pattern = '/\.(flaticon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$flaticons_path = TEMPLATETHEME_DIR . '/css/flaticon.css';
		if( file_exists( $flaticons_path ) ) {
			$subject = file_get_contents($flaticons_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$all_flaticons = array();
		$all_new_flaticons = array();
		
		foreach($matches as $match){
			$all_flaticons['flaticon ' . $match[1]] = $match[1];
		}
		
		foreach($all_flaticons as $key => $value ){
			$all_new_flaticons[] = array( $key => $value );
		}
	
		return array_merge( $icons, $all_new_flaticons );
	
	}
}
add_filter('vc_iconpicker-type-flaticons', 'justice_vc_custom_flaticons', 10, 1);

/* =============================================================
 *	Add Simple Line Icons to VC
 * ============================================================= */
if( ! function_exists('justice_vc_custom_simpleicons') ) {
	function justice_vc_custom_simpleicons( $icons ) {
		$simple_icons = array(
			array( "simple-icon icon-user-female" 			=> __( "User Female", "Templatepath" ) ),
			array( "simple-icon icon-user-follow" 			=> __( "User Follow", "Templatepath" ) ),
			array( "simple-icon icon-user-following" 		=> __( "User Following", "Templatepath" ) ),
			array( "simple-icon icon-user-unfollow" 		=> __( "User Unfollow", "Templatepath" ) ),
			array( "simple-icon icon-trophy" 				=> __( "Trophy", "Templatepath" ) ),
			array( "simple-icon icon-screen-smartphone" 	=> __( "Screen Smartphone", "Templatepath" ) ),
			array( "simple-icon icon-screen-desktop" 		=> __( "Screen Desktop", "Templatepath" ) ),
			array( "simple-icon icon-plane" 				=> __( "Plane", "Templatepath" ) ),
			array( "simple-icon icon-notebook" 				=> __( "Notebook", "Templatepath" ) ),
			array( "simple-icon icon-moustache" 			=> __( "Moustache", "Templatepath" ) ),
			array( "simple-icon icon-mouse" 				=> __( "Mouse", "Templatepath" ) ),
			array( "simple-icon icon-magnet" 				=> __( "Magnet", "Templatepath" ) ),
			array( "simple-icon icon-energy" 				=> __( "Energy", "Templatepath" ) ),
			array( "simple-icon icon-emoticon-smile" 		=> __( "Emoticon Smile", "Templatepath" ) ),
			array( "simple-icon icon-disc" 					=> __( "Disc", "Templatepath" ) ),
			array( "simple-icon icon-cursor-move" 			=> __( "Cursor Move", "Templatepath" ) ),
			array( "simple-icon icon-crop" 					=> __( "Crop", "Templatepath" ) ),
			array( "simple-icon icon-credit-card" 			=> __( "Credit Card", "Templatepath" ) ),
			array( "simple-icon icon-chemistry" 			=> __( "Chemistry", "Templatepath" ) ),
			array( "simple-icon icon-user" 					=> __( "User", "Templatepath" ) ),
			array( "simple-icon icon-speedometer" 			=> __( "Speedometer", "Templatepath" ) ),
			array( "simple-icon icon-social-youtube" 		=> __( "Youtube", "Templatepath" ) ),
			array( "simple-icon icon-social-twitter" 		=> __( "Twitter", "Templatepath" ) ),
			array( "simple-icon icon-social-tumblr" 		=> __( "Tumblr", "Templatepath" ) ),
			array( "simple-icon icon-social-facebook" 		=> __( "Facebook", "Templatepath" ) ),
			array( "simple-icon icon-social-dropbox" 		=> __( "Dropbox", "Templatepath" ) ),
			array( "simple-icon icon-social-dribbble" 		=> __( "Dribbble", "Templatepath" ) ),
			array( "simple-icon icon-shield" 				=> __( "Shield", "Templatepath" ) ),
			array( "simple-icon icon-screen-tablet" 		=> __( "Screen Tablet", "Templatepath" ) ),
			array( "simple-icon icon-magic-wand" 			=> __( "Magic Wand", "Templatepath" ) ),
			array( "simple-icon icon-hourglass" 			=> __( "Hourglass", "Templatepath" ) ),
			array( "simple-icon icon-graduation" 			=> __( "Graduation", "Templatepath" ) ),
			array( "simple-icon icon-ghost" 				=> __( "Ghost", "Templatepath" ) ),
			array( "simple-icon icon-game-controller" 		=> __( "Game Controller", "Templatepath" ) ),
			array( "simple-icon icon-fire" 					=> __( "Fire", "Templatepath" ) ),
			array( "simple-icon icon-eyeglasses" 			=> __( "Eyeglasses", "Templatepath" ) ),
			array( "simple-icon icon-envelope-open" 		=> __( "Envelope Open", "Templatepath" ) ),
			array( "simple-icon icon-envelope-letter" 		=> __( "Envelope Letter", "Templatepath" ) ),
			array( "simple-icon icon-bell" 					=> __( "Bell", "Templatepath" ) ),
			array( "simple-icon icon-badge" 				=> __( "Badge", "Templatepath" ) ),
			array( "simple-icon icon-anchor" 				=> __( "Anchor", "Templatepath" ) ),
			array( "simple-icon icon-wallet" 				=> __( "Wallet", "Templatepath" ) ),
			array( "simple-icon icon-vector" 				=> __( "Vector", "Templatepath" ) ),
			array( "simple-icon icon-speech" 				=> __( "Speech", "Templatepath" ) ),
			array( "simple-icon icon-puzzle" 				=> __( "Puzzle", "Templatepath" ) ),
			array( "simple-icon icon-printer" 				=> __( "Printer", "Templatepath" ) ),
			array( "simple-icon icon-present" 				=> __( "Present", "Templatepath" ) ),
			array( "simple-icon icon-playlist" 				=> __( "Playlist", "Templatepath" ) ),
			array( "simple-icon icon-pin" 					=> __( "Pin", "Templatepath" ) ),
			array( "simple-icon icon-picture" 				=> __( "Picture", "Templatepath" ) ),
			array( "simple-icon icon-map" 					=> __( "Map", "Templatepath" ) ),
			array( "simple-icon icon-layers" 				=> __( "Layers", "Templatepath" ) ),
			array( "simple-icon icon-handbag" 				=> __( "Handbag", "Templatepath" ) ),
			array( "simple-icon icon-globe-alt" 			=> __( "Globe", "Templatepath" ) ),
			array( "simple-icon icon-globe" 				=> __( "Globe", "Templatepath" ) ),
			array( "simple-icon icon-frame" 				=> __( "Frame", "Templatepath" ) ),
			array( "simple-icon icon-folder-alt" 			=> __( "Folder", "Templatepath" ) ),
			array( "simple-icon icon-film" 					=> __( "Film", "Templatepath" ) ),
			array( "simple-icon icon-feed" 					=> __( "Feed", "Templatepath" ) ),
			array( "simple-icon icon-earphones-alt" 		=> __( "Earphones", "Templatepath" ) ),
			array( "simple-icon icon-earphones" 			=> __( "Earphones", "Templatepath" ) ),
			array( "simple-icon icon-drop" 					=> __( "Drop", "Templatepath" ) ),
			array( "simple-icon icon-drawer" 				=> __( "Drawer", "Templatepath" ) ),
			array( "simple-icon icon-docs" 					=> __( "Docs", "Templatepath" ) ),
			array( "simple-icon icon-directions" 			=> __( "Directions", "Templatepath" ) ),
			array( "simple-icon icon-direction" 			=> __( "Direction", "Templatepath" ) ),
			array( "simple-icon icon-diamond" 				=> __( "Diamond", "Templatepath" ) ),
			array( "simple-icon icon-cup" 					=> __( "Cup", "Templatepath" ) ),
			array( "simple-icon icon-compass" 				=> __( "Compass", "Templatepath" ) ),
			array( "simple-icon icon-call-out" 				=> __( "Call Out", "Templatepath" ) ),
			array( "simple-icon icon-call-in" 				=> __( "Call In", "Templatepath" ) ),
			array( "simple-icon icon-call-end" 				=> __( "Call End", "Templatepath" ) ),
			array( "simple-icon icon-calculator" 			=> __( "Calculator", "Templatepath" ) ),
			array( "simple-icon icon-bubbles" 				=> __( "Bubbles", "Templatepath" ) ),
			array( "simple-icon icon-briefcase" 			=> __( "Briefcase", "Templatepath" ) ),
			array( "simple-icon icon-book-open" 			=> __( "Book Open", "Templatepath" ) ),
			array( "simple-icon icon-basket-loaded" 		=> __( "Basket Loaded", "Templatepath" ) ),
			array( "simple-icon icon-basket" 				=> __( "Basket", "Templatepath" ) ),
			array( "simple-icon icon-bag" 					=> __( "Bag", "Templatepath" ) ),
			array( "simple-icon icon-action-undo" 			=> __( "Action Undo", "Templatepath" ) ),
			array( "simple-icon icon-action-redo" 			=> __( "Action Redo", "Templatepath" ) ),
			array( "simple-icon icon-wrench" 				=> __( "Wrench", "Templatepath" ) ),
			array( "simple-icon icon-umbrella" 				=> __( "Umbrella", "Templatepath" ) ),
			array( "simple-icon icon-trash" 				=> __( "Trash", "Templatepath" ) ),
			array( "simple-icon icon-tag" 					=> __( "Tag", "Templatepath" ) ),
			array( "simple-icon icon-support" 				=> __( "Support", "Templatepath" ) ),
			array( "simple-icon icon-size-fullscreen" 		=> __( "Size Fullscreen", "Templatepath" ) ),
			array( "simple-icon icon-size-actual" 			=> __( "Size Actual", "Templatepath" ) ),
			array( "simple-icon icon-shuffle" 				=> __( "Shuffle", "Templatepath" ) ),
			array( "simple-icon icon-share-alt" 			=> __( "Share", "Templatepath" ) ),
			array( "simple-icon icon-share" 				=> __( "Share", "Templatepath" ) ),
			array( "simple-icon icon-rocket" 				=> __( "Rocket", "Templatepath" ) ),
			array( "simple-icon icon-question" 				=> __( "Question", "Templatepath" ) ),
			array( "simple-icon icon-pie-chart" 			=> __( "Pie Chart", "Templatepath" ) ),
			array( "simple-icon icon-pencil" 				=> __( "Pencil", "Templatepath" ) ),
			array( "simple-icon icon-note" 					=> __( "Note", "Templatepath" ) ),
			array( "simple-icon icon-music-tone-alt" 		=> __( "Music Tone", "Templatepath" ) ),
			array( "simple-icon icon-music-tone" 			=> __( "Music Tone", "Templatepath" ) ),
			array( "simple-icon icon-microphone" 			=> __( "Microphone", "Templatepath" ) ),
			array( "simple-icon icon-loop" 					=> __( "Loop", "Templatepath" ) ),
			array( "simple-icon icon-logout" 				=> __( "Logout", "Templatepath" ) ),
			array( "simple-icon icon-login" 				=> __( "Login", "Templatepath" ) ),
			array( "simple-icon icon-list" 					=> __( "List", "Templatepath" ) ),
			array( "simple-icon icon-like" 					=> __( "Like", "Templatepath" ) ),
			array( "simple-icon icon-home" 					=> __( "Home", "Templatepath" ) ),
			array( "simple-icon icon-grid" 					=> __( "Grid", "Templatepath" ) ),
			array( "simple-icon icon-graph" 				=> __( "Graph", "Templatepath" ) ),
			array( "simple-icon icon-equalizer" 			=> __( "Equalizer", "Templatepath" ) ),
			array( "simple-icon icon-dislike" 				=> __( "Dislike", "Templatepath" ) ),
			array( "simple-icon icon-cursor" 				=> __( "Cursor", "Templatepath" ) ),
			array( "simple-icon icon-control-start" 		=> __( "Control Start", "Templatepath" ) ),
			array( "simple-icon icon-control-rewind" 		=> __( "Control Rewind", "Templatepath" ) ),
			array( "simple-icon icon-control-play" 			=> __( "Control Play", "Templatepath" ) ),
			array( "simple-icon icon-control-pause" 		=> __( "Control Pause", "Templatepath" ) ),
			array( "simple-icon icon-control-forward" 		=> __( "Control Forward", "Templatepath" ) ),
			array( "simple-icon icon-control-end" 			=> __( "Control End", "Templatepath" ) ),
			array( "simple-icon icon-calendar" 				=> __( "Calendar", "Templatepath" ) ),
			array( "simple-icon icon-bulb" 					=> __( "Bulb", "Templatepath" ) ),
			array( "simple-icon icon-bar-chart" 			=> __( "Bar Chart", "Templatepath" ) ),
			array( "simple-icon icon-arrow-up" 				=> __( "Arrow Up", "Templatepath" ) ),
			array( "simple-icon icon-arrow-right" 			=> __( "Arrow Right", "Templatepath" ) ),
			array( "simple-icon icon-arrow-left" 			=> __( "Arrow Left", "Templatepath" ) ),
			array( "simple-icon icon-arrow-down" 			=> __( "Arrow Down", "Templatepath" ) ),
			array( "simple-icon icon-ban" 					=> __( "Ban", "Templatepath" ) ),
			array( "simple-icon icon-bubble" 				=> __( "Bubble", "Templatepath" ) ),
			array( "simple-icon icon-camcorder" 			=> __( "Camcorder", "Templatepath" ) ),
			array( "simple-icon icon-camera" 				=> __( "Camera", "Templatepath" ) ),
			array( "simple-icon icon-check" 				=> __( "Check", "Templatepath" ) ),
			array( "simple-icon icon-clock" 				=> __( "Clock", "Templatepath" ) ),
			array( "simple-icon icon-close" 				=> __( "Close", "Templatepath" ) ),
			array( "simple-icon icon-cloud-download" 		=> __( "Cloud Download", "Templatepath" ) ),
			array( "simple-icon icon-cloud-upload" 			=> __( "Cloud Upload", "Templatepath" ) ),
			array( "simple-icon icon-doc" 					=> __( "Doc", "Templatepath" ) ),
			array( "simple-icon icon-envelope" 				=> __( "Envelope", "Templatepath" ) ),
			array( "simple-icon icon-eye" 					=> __( "Eye", "Templatepath" ) ),
			array( "simple-icon icon-flag" 					=> __( "Flag", "Templatepath" ) ),
			array( "simple-icon icon-folder" 				=> __( "Folder", "Templatepath" ) ),
			array( "simple-icon icon-heart" 				=> __( "Heart", "Templatepath" ) ),
			array( "simple-icon icon-info" 					=> __( "Info", "Templatepath" ) ),
			array( "simple-icon icon-key" 					=> __( "Key", "Templatepath" ) ),
			array( "simple-icon icon-link" 					=> __( "Link", "Templatepath" ) ),
			array( "simple-icon icon-lock" 					=> __( "Lock", "Templatepath" ) ),
			array( "simple-icon icon-lock-open" 			=> __( "Lock Open", "Templatepath" ) ),
			array( "simple-icon icon-magnifier" 			=> __( "Magnifier", "Templatepath" ) ),
			array( "simple-icon icon-magnifier-add" 		=> __( "Magnifier Add", "Templatepath" ) ),
			array( "simple-icon icon-magnifier-remove" 		=> __( "Magnifier Remove", "Templatepath" ) ),
			array( "simple-icon icon-paper-clip" 			=> __( "Paper Clip", "Templatepath" ) ),
			array( "simple-icon icon-paper-plane" 			=> __( "Paper Plane", "Templatepath" ) ),
			array( "simple-icon icon-plus" 					=> __( "Plus", "Templatepath" ) ),
			array( "simple-icon icon-pointer" 				=> __( "Pointer", "Templatepath" ) ),
			array( "simple-icon icon-power" 				=> __( "Power", "Templatepath" ) ),
			array( "simple-icon icon-refresh" 				=> __( "Refresh", "Templatepath" ) ),
			array( "simple-icon icon-reload" 				=> __( "Reload", "Templatepath" ) ),
			array( "simple-icon icon-settings" 				=> __( "Settings", "Templatepath" ) ),
			array( "simple-icon icon-star" 					=> __( "Star", "Templatepath" ) ),
			array( "simple-icon icon-symbol-female" 		=> __( "Symbol Female", "Templatepath" ) ),
			array( "simple-icon icon-symbol-male" 			=> __( "Symbol Male", "Templatepath" ) ),
			array( "simple-icon icon-target" 				=> __( "Target", "Templatepath" ) ),
			array( "simple-icon icon-volume-1" 				=> __( "Volume 1", "Templatepath" ) ),
			array( "simple-icon icon-volume-2" 				=> __( "Volume 2", "Templatepath" ) ),
			array( "simple-icon icon-volume-off" 			=> __( "Volume Off", "Templatepath" ) ),
			array( "simple-icon icon-users" 				=> __( "Users", "Templatepath" ) ),
		);
	
		return array_merge( $icons, $simple_icons );
	
	}
}
add_filter('vc_iconpicker-type-simpleicons', 'justice_vc_custom_simpleicons', 10, 1);