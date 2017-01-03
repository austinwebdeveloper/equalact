<?php
/**
 * Register widgetized areas
 */
if ( ! function_exists( 'justice_widgets_init' ) ) {
	function justice_widgets_init() {
	
	global $tpath_options;
	
	// Primary Sidebar
	    
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'Templatepath' ),
		'id'            => 'primary',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'description' => __( 'The default sidebar used in two or three-column layouts.', 'Templatepath' ),
	) );
		
	// Header Right Sidebar
		
	register_sidebar( array(
		'name'          => __( 'Header Right Sidebar', 'Templatepath' ),
		'id'            => 'header-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'description' => __( 'A header right sidebar used in header only if enabled in theme options.', 'Templatepath' ),
	) );
	
	// Footer Widgets Sidebar
	$is_footer_widgets = '';
	$is_footer_widgets = isset($tpath_options['tpath_footer_widgets_enable']) ? $tpath_options['tpath_footer_widgets_enable'] : 0;
	
	if( $is_footer_widgets ) {
	
		$columns = $tpath_options['tpath_footer_widget_layout'];
		if ( ! $columns ) $columns = 4;
		for ( $i = 1; $i <= intval( $columns ); $i++ ) {
		
			register_sidebar( array(
				'name'          => sprintf( __( 'Footer %d', 'Templatepath' ), $i ),
				'id'            => sprintf( 'footer-widget-%d', $i ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
				'description'	=> sprintf( __( 'Footer widget Area %d.', 'Templatepath' ), $i ),
			) );
				
		}
		
	}
	
	/**
	 * Woocommerce Sidebar
	 */
	if( class_exists('Woocommerce') ) {
		register_sidebar( array(
			'name'          => __( 'Shop Sidebar', 'Templatepath' ),
			'id'            => 'shop-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'description' => __( 'Shop Sidebar to show your widgets on Shop Pages.', 'Templatepath' ),
		) );
	}
		
	} // End justice_widgets_init()
}

add_action( 'widgets_init', 'justice_widgets_init' );  
?>