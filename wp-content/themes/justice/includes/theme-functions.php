<?php
/**
* Theme Functions
*/

/* =========================================================
 * Plugin Activation
 * ========================================================= */

add_action( 'tgmpa_register', 'justice_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function justice_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'Revolution Slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/includes/plugins/revslider.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '4.6.93', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		
		array(
            'name'               => 'Template Core', // The plugin name.
            'slug'               => 'template-core', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/includes/plugins/template-core.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		
		array(
            'name'               => 'WPBakery Visual Composer', // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/includes/plugins/js_composer.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '4.5.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'install-required-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}

/* =========================================================
 * Header Content Area
 * ========================================================= */
 
if ( ! function_exists( 'justice_header_content_area' ) ) { 

	function justice_header_content_area( $section ) { 
	
		global $tpath_options;
		$menu_name = '';
		
		if( $section == 'social-links' ) {
			echo '<div id="header-sidebar-social" class="header-sidebar-social">';
			justice_display_social_icons();
			echo '</div>';
		}
		
		if( $section == 'top-navigation') {			
			echo '<div class="hidden-xs">';
			echo wp_nav_menu( array( 'container_class' => 'tpath-top-nav top-menu-navigation', 'container_id' => 'top-nav', 'menu_id' => 'top-menu', 'menu_class' => 'nav navbar-nav navbar-right tpath-top-nav', 'theme_location' => 'tpath-top', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker() ) );
			echo '</div>';			
			// ==================== Mobile Menu ==================== //
			echo '<div id="mobile-menu" class="visible-xs">';
			echo wp_nav_menu( array( 'container_class' => 'tpath-top-nav top-menu-navigation', 'container_id' => 'top-mobile-nav', 'menu_id' => 'top-mobile-menu', 'menu_class' => 'nav navbar-nav tpath-top-nav', 'theme_location' => 'tpath-top', 'fallback_cb' => 'wp_bootstrap_mobile_navwalker::fallback', 'walker' => new wp_bootstrap_mobile_navwalker() ) );
			echo '</div>';
		}
		
		if( $section == 'main-navigation' || $section == 'main-right-navigation' ) {
			if( $section == 'main-navigation' ) {
				$menu_name = 'tpath-primary';
				$tmenu_id = 'nav';
			} elseif( $section == 'main-right-navigation' ) {
				$menu_name = 'tpath-primary-right';
				$tmenu_id = 'rightnav';
			}
			
			echo '<div class="hidden-xs">';
			
			if( $tpath_options['tpath_menu_type'] != 'standard' && $tpath_options['tpath_menu_type'] == 'megamenu' ) {
				echo wp_nav_menu( array( 'container_class' => 'main-nav main-megamenu-navigation', 'container_id' => 'main-mega-'.$tmenu_id.'', 'menu_id' => 'main-mega-menu-'.$tmenu_id.'', 'menu_class' => 'nav navbar-nav navbar-main tpath-main-nav', 'theme_location' => $menu_name, 'fallback_cb' => 'TpathMegaMenuFrontendWalker::fallback', 'walker' => new TpathMegaMenuFrontendWalker() ) );
			} else {
				echo wp_nav_menu( array( 'container_class' => 'main-nav main-menu-navigation', 'container_id' => 'main-'.$tmenu_id.'', 'menu_id' => 'main-menu-'.$tmenu_id.'', 'menu_class' => 'nav navbar-nav navbar-main tpath-main-nav', 'theme_location' => $menu_name, 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker() ) );
			}

			echo '</div>';				
			// ==================== Mobile Menu ==================== //
			echo '<div id="mobile-menu'.$tmenu_id.'" class="visible-xs">';
			echo wp_nav_menu( array( 'container_class' => 'main-nav main-menu-navigation', 'container_id' => 'main-mobile-'.$tmenu_id.'', 'menu_id' => 'main-mobile-menu-'.$tmenu_id.'', 'menu_class' => 'nav navbar-nav navbar-main tpath-main-nav', 'theme_location' => $menu_name, 'fallback_cb' => 'wp_bootstrap_mobile_navwalker::fallback', 'walker' => new wp_bootstrap_mobile_navwalker() ) );
			echo '</div>';
		}
						
		if( $section == 'search-box') {
			echo '<div id="header-search-form" class="header-search-form">';
			echo '<i class="fa fa-search btn-trigger"></i>';
			echo get_search_form();
			echo '</div>';
		}
		
		if( $section == 'cart-icon') { ?>
		
			<div class="woo-header-cart">
				<?php if( ! $woocommerce->cart->cart_contents_count ) { ?>
				<a class="cart-empty cart-contents" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><span class="cart-count"><?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?></span><i class="fa fa-shopping-cart"></i></a>
				<?php } else { ?>
				<a class="cart-icon cart-contents" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><span class="cart-count"><?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?></span><i class="fa fa-shopping-cart"></i></a>
				
				<div class="woo-cart-contents">
					<?php foreach( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) { ?>
						<div class="woo-cart-item">
							<a href="<?php echo get_permalink($cart_item['product_id']); ?>" title="<?php echo esc_html( $cart_item['data']->post->post_title ); ?>">
								<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
								<?php echo get_the_post_thumbnail($thumbnail_id, 'thumbnail'); ?>
								<div class="cart-item-content">
									<h5 class="cart-product-name"><?php echo wp_kses_post( $cart_item['data']->post->post_title ); ?></h5>
									<h5 class="cart-product-quantity"><?php echo wp_kses_post( $cart_item['quantity'] ); ?> x <?php echo wp_kses_post( $woocommerce->cart->get_product_subtotal($cart_item['data'], 1) ); ?></h5>
								</div>
							</a>
							<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove remove-cart-item" title="%s" data-cart_id="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), esc_html__('Remove this item', 'Templatepath'), $cart_item_key ), $cart_item_key ); ?>
                            <div class="ajax-loading"></div>							
						</div>
					<?php } ?>
					
					<div class="woo-cart-total">
						<h5 class="cart-total"><?php esc_html_e('Total: ', 'Templatepath'); ?> <?php echo wp_kses_post( $woocommerce->cart->get_cart_total() ); ?></h5>						
					</div>
					
					<div class="woo-cart-buttons clearfix">
						<div class="cart-button"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="<?php esc_html_e('Cart', 'Templatepath'); ?>"><?php esc_html_e('View Cart', 'Templatepath'); ?></a></div>
						<div class="checkout-button"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="<?php esc_html_e('Checkout', 'Templatepath'); ?>"><?php esc_html_e('Checkout', 'Templatepath'); ?></a></div>
					</div>
				</div>
				<?php } ?>
			</div>
			
		<?php }
		
	}
	
}

/* =========================================================
 * Main Layout Custom Classes
 * ========================================================= */
 
/**
 * Primary Content Classes works on all column layouts
 */
if ( ! function_exists( 'justice_primary_content_classes' ) ) { 

	function justice_primary_content_classes() {	
	
		global $tpath_options, $post;
		
		$layout = '';
		
		if( is_singular() ) {
			$layout = get_post_meta( $post->ID, 'tpath_layout', true );			
		}
		
		if( is_archive() ) {
			$layout = $tpath_options['tpath_blog_archive_layout'];
		}
		
		if( is_home() ) {
			$home_id = get_option( 'page_for_posts' );
			$layout = get_post_meta( $home_id, 'tpath_layout', true );
			if( !$layout ) {
				$layout = $tpath_options['tpath_blog_layout'];
			}
		}
		
		if( is_singular('tpath_portfolio') ) {
			$layout = $tpath_options['tpath_layout'];
		}
		else if( is_singular( 'post' ) ) {
			$layout = get_post_meta( $post->ID, 'tpath_layout', true );
			if( !$layout ) {
				$layout = $tpath_options['tpath_single_post_layout'];
			}			
		}
		
		if( !$layout ) {			
			if( $tpath_options['tpath_layout'] != '' ) {		
				$layout = $tpath_options['tpath_layout'];
			}
			else {
				$layout = 'two-col-right';
			}
		}
						
		if( $layout == 'two-col-left' || $layout == 'two-col-right' ) {
			echo 'content-col-small';
		}		
		elseif( $layout == 'one-col' ) {
			echo 'content-col-full';
		}
		
	}	
} 

/**
 * Footer Widget Classes based on columns
 */
if ( ! function_exists( 'footer_widget_classes' ) ) { 

	function footer_widget_classes( $columns ) {	
	
		global $tpath_options;
		
		if( !$columns && isset( $tpath_options['tpath_footer_widgets_enable'] ) ){
			$columns = $tpath_options['tpath_footer_widget_layout'];
		}
		if( $columns == 1 ) {
			echo 'col-xs-12';
		} elseif( $columns == 2 ) {
			echo 'col-sm-6';
		} elseif( $columns == 3 ) {
			echo 'col-sm-4';
		} elseif( $columns == 4 ) {
			echo 'col-sm-3';
		}
	}
}


/* =========================================================
 * Display Social Icons no Footer
 * ========================================================= */
 
if ( ! function_exists( 'justice_display_social_icons' ) ) { 

	function justice_display_social_icons( $type = '' ) {	
	
		global $tpath_options;
		
		$zo_tooltip = '';
		
		if( $type == '' ) {
			$type = $tpath_options['tpath_social_icon_type'];
		}
		
		if( $type == "transparent" ) {
			$zo_tooltip = 1;
		}
		else {
			$zo_tooltip = 0;
		}
		
		echo '<ul class="tpath-social-icons soc-icon-'.$type.'">';		
		
		if( $tpath_options['tpath_facebook_link'] && $zo_tooltip != 1 ) {
			echo '<li class="facebook"><a target="_blank" href="'.esc_url( $tpath_options['tpath_facebook_link'] ).'"><i class="fa fa-facebook"></i></a></li>';
		}
		elseif( $tpath_options['tpath_facebook_link'] ) {
			echo '<li class="facebook"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Facebook" target="_blank" href="'.esc_url( $tpath_options['tpath_facebook_link'] ).'"><i class="fa fa-facebook"></i></a></li>';
		}
		
		if( $tpath_options['tpath_twitter_link'] && $zo_tooltip != 1 ) {
			echo '<li class="twitter"><a target="_blank" href="'.esc_url( $tpath_options['tpath_twitter_link'] ).'"><i class="fa fa-twitter"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_twitter_link'] ) {
			echo '<li class="twitter"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Twitter" target="_blank" href="'.esc_url( $tpath_options['tpath_twitter_link'] ).'"><i class="fa fa-twitter"></i></a></li>';
		}
		
		if( $tpath_options['tpath_linkedin_link'] && $zo_tooltip != 1 ) {
			echo '<li class="linkedin"><a target="_blank" href="'.esc_url( $tpath_options['tpath_linkedin_link'] ).'"><i class="fa fa-linkedin"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_linkedin_link'] ) {
			echo '<li class="linkedin"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="LinkedIn" target="_blank" href="'.esc_url( $tpath_options['tpath_linkedin_link'] ).'"><i class="fa fa-linkedin"></i></a></li>';
		}
		
		if( $tpath_options['tpath_pinterest_link'] && $zo_tooltip != 1 ) {
			echo '<li class="pinterest"><a target="_blank" href="'.esc_url( $tpath_options['tpath_pinterest_link'] ).'"><i class="fa fa-pinterest"></i></a></li>';
		}
		elseif( $tpath_options['tpath_pinterest_link'] ) {
			echo '<li class="pinterest"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Pinterest" target="_blank" href="'.esc_url( $tpath_options['tpath_pinterest_link'] ).'"><i class="fa fa-pinterest"></i></a></li>';
		}
		
		if( $tpath_options['tpath_googleplus_link'] && $zo_tooltip != 1 ) {
			echo '<li class="googleplus"><a target="_blank" href="'.esc_url( $tpath_options['tpath_googleplus_link'] ).'"><i class="fa fa-google-plus"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_googleplus_link'] ) {
			echo '<li class="googleplus"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Google Plus" target="_blank" href="'.esc_url( $tpath_options['tpath_googleplus_link'] ).'"><i class="fa fa-google-plus"></i></a></li>';
		}
		
		if( $tpath_options['tpath_youtube_link'] && $zo_tooltip != 1 ) {
			echo '<li class="youtube"><a target="_blank" href="'.esc_url( $tpath_options['tpath_youtube_link'] ).'"><i class="fa fa-youtube-play"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_youtube_link'] ) {
			echo '<li class="youtube"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="You Tube" target="_blank" href="'.esc_url( $tpath_options['tpath_youtube_link'] ).'"><i class="fa fa-youtube-play"></i></a></li>';
		}
		
		if( $tpath_options['tpath_rss_link'] && $zo_tooltip != 1 ) {
			echo '<li class="rss"><a target="_blank" href="'.esc_url( $tpath_options['tpath_rss_link'] ).'"><i class="fa fa-rss"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_rss_link'] ) {
			echo '<li class="rss"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="RSS" target="_blank" href="'.esc_url( $tpath_options['tpath_rss_link'] ).'"><i class="fa fa-rss"></i></a></li>';
		}
		
		if( $tpath_options['tpath_tumblr_link'] && $zo_tooltip != 1 ) {
			echo '<li class="tumblr"><a target="_blank" href="'.esc_url( $tpath_options['tpath_tumblr_link'] ).'"><i class="fa fa-tumblr"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_tumblr_link'] ) {
			echo '<li class="tumblr"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Tumblr" target="_blank" href="'.esc_url( $tpath_options['tpath_tumblr_link'] ).'"><i class="fa fa-tumblr"></i></a></li>';
		}
		
		if( $tpath_options['tpath_reddit_link'] && $zo_tooltip != 1 ) {
			echo '<li class="reddit"><a target="_blank" href="'.esc_url( $tpath_options['tpath_reddit_link'] ).'"><i class="fa fa-reddit"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_reddit_link'] ) {
			echo '<li class="reddit"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Reddit" target="_blank" href="'.esc_url( $tpath_options['tpath_reddit_link'] ).'"><i class="fa fa-reddit"></i></a></li>';
		}
		
		if( $tpath_options['tpath_dribbble_link'] && $zo_tooltip != 1 ) {
			echo '<li class="dribbble"><a target="_blank" href="'.esc_url( $tpath_options['tpath_dribbble_link'] ).'"><i class="fa fa-dribbble"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_dribbble_link'] ) {
			echo '<li class="dribbble"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Dribbble" target="_blank" href="'.esc_url( $tpath_options['tpath_dribbble_link'] ).'"><i class="fa fa-dribbble"></i></a></li>';
		}
		
		if( $tpath_options['tpath_digg_link'] && $zo_tooltip != 1 ) {
			echo '<li class="digg"><a target="_blank" href="'.esc_url( $tpath_options['tpath_digg_link'] ).'"><i class="fa fa-digg"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_digg_link'] ) {
			echo '<li class="digg"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Digg" target="_blank" href="'.esc_url( $tpath_options['tpath_digg_link'] ).'"><i class="fa fa-digg"></i></a></li>';
		}
		
		if( $tpath_options['tpath_flickr_link'] && $zo_tooltip != 1 ) {
			echo '<li class="flickr"><a target="_blank" href="'.esc_url( $tpath_options['tpath_flickr_link'] ).'"><i class="fa fa-flickr"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_flickr_link'] ) {
			echo '<li class="flickr"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Flickr" target="_blank" href="'.esc_url( $tpath_options['tpath_flickr_link'] ).'"><i class="fa fa-flickr"></i></a></li>';
		}
		
		if( $tpath_options['tpath_instagram_link'] && $zo_tooltip != 1 ) {
			echo '<li class="instagram"><a target="_blank" href="'.esc_url( $tpath_options['tpath_instagram_link'] ).'"><i class="fa fa-instagram"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_instagram_link'] ) {
			echo '<li class="instagram"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Instagram" target="_blank" href="'.esc_url( $tpath_options['tpath_instagram_link'] ).'"><i class="fa fa-instagram"></i></a></li>';
		}
		
		if( $tpath_options['tpath_skype_link'] && $zo_tooltip != 1 ) {
			echo '<li class="skype"><a target="_blank" href="'.esc_url( $tpath_options['tpath_skype_link'] ).'"><i class="fa fa-skype"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_skype_link'] ) {
			echo '<li class="skype"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Skype" target="_blank" href="'.esc_url( $tpath_options['tpath_skype_link'] ).'"><i class="fa fa-skype"></i></a></li>';
		}
		
		if( $tpath_options['tpath_blogger_link'] && $zo_tooltip != 1 ) {
			echo '<li class="blogger"><a target="_blank" href="'.esc_url( $tpath_options['tpath_blogger_link'] ).'"><i class="fa icon-blogger"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_blogger_link'] ) {
			echo '<li class="blogger"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Blogger" target="_blank" href="'.esc_url( $tpath_options['tpath_blogger_link'] ).'"><i class="fa icon-blogger"></i></a></li>';
		}
		
		if( $tpath_options['tpath_yahoo_link'] && $zo_tooltip != 1 ) {
			echo '<li class="yahoo"><a target="_blank" href="'.esc_url( $tpath_options['tpath_yahoo_link'] ).'"><i class="fa fa-yahoo"></i></a></li>';			
		}
		elseif( $tpath_options['tpath_yahoo_link'] ) {
			echo '<li class="yahoo"><a class="zo-tooltip" data-placement="top" data-toggle="tooltip" data-original-title="Yahoo" target="_blank" href="'.esc_url( $tpath_options['tpath_yahoo_link'] ).'"><i class="fa fa-yahoo"></i></a></li>';
		}
		
		echo '</ul>';
	}	
} 

/* =========================================================
 * Get Post Gallery Images in Slider
 * ========================================================= */

function get_gallery_post_images($size, $id) {

	if( !$size ) 
		$size = 'full';
	
	if($images = get_posts(array(
		'post_parent'    => get_the_ID(),
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
		'orderby'        => 'title',
		'order' 		 => 'ASC',
	))) {
		foreach($images as $image) {
		
			$posts_image   = wp_get_attachment_image($image->ID,$size);
			
			$posts_image_link = wp_get_attachment_image_src($image->ID, 'full');
			
			echo '<div class="blog-gallery-item"><a href="'.esc_url( $posts_image_link[0] ).'" data-rel="prettyPhoto[gallery'.esc_attr( $id ).']" >' . $posts_image . '</a></div>';

		}
	}
}

/* =========================================================
 * Display Social Sharing Icons in Blog Posts
 * ========================================================= */
 
if ( ! function_exists( 'justice_display_social_sharing_icons' ) ) { 

	function justice_display_social_sharing_icons() {	
	
		global $tpath_options, $post;
		
		echo '<div class="tpath-social-share-box"><ul class="tpath-social-share-icons share-box">';
		
		
		if( $tpath_options['tpath_sharing_facebook'] ) {
			echo '<li class="facebook"><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u='.urlencode(get_permalink()).'" title="facebook"><i class="fa fa-facebook"></i></a></li>';
		}		
		
		if( $tpath_options['tpath_sharing_twitter'] ) {
			echo '<li class="twitter"><a target="_blank" href="https://twitter.com/home?status='.urlencode($post->post_title). '%20-%20' . urlencode(get_permalink()).'" title="twitter"><i class="fa fa-twitter"></i></a></li>';			
		}
		
		if( $tpath_options['tpath_sharing_linkedin'] ) {
			echo '<li class="linkedin"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode(get_permalink()).'&amp;title='.urlencode(get_the_title()).'"><i class="fa fa-linkedin"></i></a></li>';			
		}
		
		if( $tpath_options['tpath_sharing_pinterest'] ) {
			$share_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-large');
			echo '<li class="pinterest"><a target="_blank" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&amp;description='.urlencode($post->post_title).'&amp;media='.urlencode($share_image[0]).'"><i class="fa fa-pinterest"></i></a></li>';			
		}
		
		if( $tpath_options['tpath_sharing_googleplus'] ) {
			echo '<li class="googleplus"><a target="_blank" href="https://plus.google.com/share?url='.urlencode(get_permalink()).'"><i class="fa fa-google-plus"></i></a></li>';			
		}
		
		if( $tpath_options['tpath_sharing_tumblr'] ) {
			if( has_post_format('quote') ) {
				echo '<li class="tumblr"><a target="_blank" href="http://www.tumblr.com/share/quote?quote='.urlencode(get_the_content()).'&amp;source='.urlencode($post->post_title).'"><i class="fa fa-tumblr"></i></a></li>';
			}
			else {
				echo '<li class="tumblr"><a target="_blank" href="http://www.tumblr.com/share/link?url='.urlencode(get_permalink()).'&amp;name='.urlencode($post->post_title).'&amp;description='.urlencode(get_the_excerpt()).'"><i class="fa fa-tumblr"></i></a></li>';
			}			
		}
		
		if( $tpath_options['tpath_sharing_reddit'] ) {
			echo '<li class="reddit"><a target="_blank" href="http://reddit.com/submit?url='.urlencode(get_permalink()).'&amp;title='.urlencode(get_the_title()).'"><i class="fa fa-reddit"></i></a></li>';			
		}
		
		if( $tpath_options['tpath_sharing_digg'] ) {
			echo '<li class="digg"><a target="_blank" href="http://digg.com/submit?url='.urlencode(get_permalink()).'&amp;title='.urlencode(get_the_title()).'"><i class="fa fa-digg"></i></a></li>';
		}
		
		if( $tpath_options['tpath_sharing_email'] ) {
			echo '<li class="email"><a target="_blank" href="mailto:?subject='.urlencode(get_the_title()).'&amp;body='.urlencode(get_permalink()).'"><i class="fa fa-envelope"></i></a></li>';			
		}
		
		echo '</ul></div>';
	}	
}

/* =========================================================
 * Display Pagination on Archive/Category and Index Pages
 * ========================================================= */
 
if ( ! function_exists( 'justice_pagination' ) ) { 

	function justice_pagination( $pages = '', $range = 2, $scroll = '' ) {
		
		global $tpath_options, $wp_rewrite;
		
		$output = '';
				
		$extra_class = '';
		if( $scroll == "infinite" ) {
			$extra_class = 'infinite-scroll';
		}

		// Don't print empty markup if there's only one page.
		// Get global $query
		if( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages; 			
		}
		
		if ( $pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
	
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
	
		$pagenum_link = esc_url( remove_query_arg( array_keys( $query_args ), $pagenum_link ) );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
	
		// Set up paginated links.
		$links = paginate_links( array(
			'base'     				=> $pagenum_link,
			'format'   				=> $format,
			'total'    				=> $pages,
			'current'  				=> $paged,
			'show_all' 				=> false,
			'mid_size' 				=> 3,
			'type' 					=> 'array',
			'add_args' 				=> array_map( 'urlencode', $query_args ),
			'prev_text' 			=> __( '&laquo;', 'Templatepath' ),
			'next_text' 			=> __( '&raquo;', 'Templatepath' ),			
		) );

		if ( !empty($links) ) {
			$output .= '<ul class="pagination ' . $extra_class . '">';
			foreach( $links as $link ) {
				$output .= '<li>'.$link.'</li>';
			}
			$output .= '</ul>';
		}
				
		return $output; 
	}
}

/* =========================================================
 * Display Post Navigation on Single Posts
 * ========================================================= */

if( ! function_exists( 'justice_postnavigation' ) ) {
	function justice_postnavigation() { 
		if ( is_single() ) { 
		?>
	        <div class="post-navigation">
				<ul class="pager">
					<li class="previous"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i> %title' ) ?></li>
					<li class="next"><?php next_post_link( '%link', '%title <i class="fa fa-angle-right"></i>' ) ?></li>
				</ul>	            
	        </div>	
		<?php 
		}
	}                	
}

/* =========================================================
 * Display Comments in different Layout
 * ========================================================= */
 
if( ! function_exists( "justice_custom_comments" ) ) {

	function justice_custom_comments( $comment, $args, $depth ) {
	   $GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">	    		      	
	      	<div id="li-comment-<?php comment_ID() ?>" class="comment-container">
				
	                <div class="comment-avatar">
						<?php echo get_avatar($comment, $args['avatar_size']); ?>
					</div>
					
					<div class="comments-box-container">
	
						<div class="comments-box">
							<div class="comment-list meta">								
								<h6 class="author-name"><?php echo get_comment_author_link(); ?></h6>
								<div class="comment-posted-date"><?php printf(__('<span>%1$s</span> %2$s', 'Templatepath'), get_comment_date(),  get_comment_time()) ?></div>														
							</div>
						</div><!-- .comments-box -->
				  
						<div class="comment-status-text" id="comment-<?php comment_ID(); ?>">
							<?php comment_text() ?>
							<?php if ($comment->comment_approved == '0') { ?>
								<p class='comment-unapproved'><?php esc_html_e('Your comment is awaiting moderation.', 'Templatepath'); ?></p>
							<?php } ?>							
						</div><!-- .comment-status-text -->
						
					</div>
					
					<div class="comment-post-meta">
						<span class="edit"><?php edit_comment_link( __('Edit', 'Templatepath'), '', ''); ?></span>
						<span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'Templatepath'), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
					</div>

			</div><!-- .comment-container -->
			
	<?php 
	}	
}

/* =========================================================
 * Display Author Info on Single Post pages
 * ========================================================= */
 
if( ! function_exists( "justice_author_info" ) ) {

	function justice_author_info() { 
		if( is_author() ) {
		
			$author_id = get_the_author_meta('ID');
			$author_name = get_the_author_meta('display_name', $author_id);			
			$author_description  = get_the_author_meta('description', $author_id); ?>
			
			<div class="author-info author-info-page clearfix">
				<div class="author-avatar">
					<?php echo get_avatar(get_the_author_meta('email', $author_id), '120'); ?>
				</div>
				<div class="author-info-container">
					<h5 class="author-name"><?php echo esc_html( $author_name ); ?></h5>
					<div class="author-links">
						<ul class="author-social">
							<li class="email"><a target="_blank" href="mailto:<?php echo get_the_author_meta('email'); ?>"><span class="simple-icon icon-envelope"></span></a></li>
						</ul>
					</div>
					<div class="author-description">
						<p><?php if( !$author_description ) {
							echo sprintf( __( 'This author %s has created %s entries.', 'Templatepath' ), $author_name, count_user_posts( $author_id ) );
						} else {
							echo esc_html( $author_description );
						} ?></p>
					</div>					
				</div>
			</div>
		<?php }	else { ?>
			<div class="author-info clearfix">
				<div class="author-avatar">
					<?php echo get_avatar(get_the_author_meta('email'), '120'); ?>
				</div>				
				<div class="author-info-container">
					<h5 class="author-name"><?php the_author_posts_link(); ?></h5>					
					<div class="author-description">
						<p><?php the_author_meta("description"); ?></p>
					</div>
				</div>
			</div>
		<?php }
	}	
}

/* =========================================================
 * Send Email via Ajax when contact form Submitted
 * ========================================================= */

add_action('wp_ajax_justice_sendmail', 'justice_contact_send_mail');
add_action('wp_ajax_nopriv_justice_sendmail', 'justice_contact_send_mail');

if( ! function_exists( "justice_contact_send_mail" ) ) {

	function justice_contact_send_mail() {
	
		global $tpath_options;
	
	   	$sendto = $tpath_options['tpath_contact_email'];
		
		if( isset( $sendto ) && $sendto == '' ) {
			$sendto = get_bloginfo('admin_email');
		}
		
		// Get Name value from submitted form
		if( $_POST['contact_name'] != '' ) {
			$name = trim($_POST['contact_name']);
		}		
		// Get Email id from submitted form
		$email = trim($_POST['contact_email']);
		
		// Get Phone number from submitted form
		if( $_POST['contact_phone'] != '' ) {		
			$phone = trim($_POST['contact_phone']);
		}
		
		// Get Subject from submitted form
		if( $_POST['contact_subject'] != '' ) {
			$subject = trim($_POST['contact_subject']);
		}
		
		// Get Message from submitted form
		$message = trim($_POST['contact_message']);
		
		$name_label = $tpath_options['tpath_labels_name'] ? $tpath_options['tpath_labels_name'] : esc_html__('Name', 'Templatepath');
		$email_label = $tpath_options['tpath_labels_email'] ? $tpath_options['tpath_labels_email'] : esc_html__('Email', 'Templatepath');
		$phone_label = $tpath_options['tpath_labels_phone'] ? $tpath_options['tpath_labels_phone'] : esc_html__('Phone', 'Templatepath');
		$subject_label = $tpath_options['tpath_labels_subject'] ? $tpath_options['tpath_labels_subject'] : esc_html__('Subject', 'Templatepath');
		$msg_label = $tpath_options['tpath_labels_message'] ? $tpath_options['tpath_labels_message'] : esc_html__('Message', 'Templatepath');
				
		$body = "<p>$name_label: $name </p>";
		$body .= "<p>$email_label: $email</p>";
		$body .= "<p>$phone_label: $phone</p>";
		$body .= "<p>$subject_label: $subject</p>";
		$body .= "<p>$msg_label: $message</p>";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$headers .= 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n";

		if( wp_mail($sendto, $subject, $body, $headers) ) {
			$msg_array = array( 'status' => 'true', 'data' => $name );
			echo json_encode($msg_array);
		} else {
			$msg_array = array( 'status' => 'false', 'data' => $name );
			echo json_encode($msg_array);
		}
		die();
	}
	
}

/* =========================================================
 * Register Additional Image field For Post Categories
 * ========================================================= */

if ( ! function_exists( 'justice_category_taxonomy_add_meta_fields' ) ) {
	function justice_category_taxonomy_add_meta_fields() {	?>	
		<div class="form-field">
			<label for="tpath_cat_thumbnail_image"><?php esc_html_e( 'Category Image', 'Templatepath' ); ?></label>
			<div class="tpath_cat_img_field">				
				<input type="text" class="media_field" id="tpath_cat_thumbnail_image" name="tpath_cat_thumbnail_image" value="" />
				<button type="button" class="tpath_img_upload_button btn"><?php esc_html_e( 'Upload/Add image', 'Templatepath' ); ?></button>
				<button type="button" class="tpath_img_remove_button btn"><?php esc_html_e( 'Remove image', 'Templatepath' ); ?></button>
			</div>					
			<p class="description"><?php esc_html_e( 'Select an image to list categories with images', 'Templatepath' ); ?></p>
			<?php wp_enqueue_media(); ?>
			<script type="text/javascript">

				// Only show remove button when needed
				if ( ! jQuery('#tpath_cat_thumbnail_image').val() ) {
					 jQuery('.tpath_img_remove_button').hide();
				}

				// Uploading files
				var file_frame;

				jQuery(document).on( 'click', '.tpath_img_upload_button', function( event ){

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}
					
					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						title: '<?php esc_html_e( 'Select image', 'Templatepath' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Upload image', 'Templatepath' ); ?>',
						},						
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();
						
						jQuery('#tpath_cat_thumbnail_image').val( attachment.url );
						jQuery('.tpath_img_remove_button').show();
					});
					
					// Finally, open the modal.
					if( file_frame ) {
						file_frame.open();
					}
					
				});

				jQuery(document).on( 'click', '.tpath_img_remove_button', function( event ){					
					jQuery('#tpath_cat_thumbnail_image').val('');
					jQuery('.tpath_img_remove_button').hide();
					return false;
				});
			</script>
		</div>		
	<?php
	}
}
add_action( 'category_add_form_fields', 'justice_category_taxonomy_add_meta_fields', 10, 2 );

if ( ! function_exists( 'justice_category_taxonomy_edit_meta_fields' ) ) {
	function justice_category_taxonomy_edit_meta_fields($term) {
	 
		// put the term ID into a variable
		$term_id = $term->term_id;
	 
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$term_id" ); ?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tpath_cat_thumbnail_image"><?php esc_html_e( 'Category Image', 'Templatepath' ); ?></label></th>
			<td>
				<div class="tpath_cat_img_field">				
					<input type="text" class="media_field" id="tpath_cat_thumbnail_image" name="tpath_cat_thumbnail_image" value="<?php echo esc_url($term_meta['tpath_thumbnail_image']); ?>" />
					<button type="button" class="tpath_img_upload_button btn"><?php esc_html_e( 'Upload/Add image', 'Templatepath' ); ?></button>
					<button type="button" class="tpath_img_remove_button btn"><?php esc_html_e( 'Remove image', 'Templatepath' ); ?></button>
				</div>					
				<p class="description"><?php esc_html_e( 'Select an image to list categories with images', 'Templatepath' ); ?></p>
				<?php wp_enqueue_media(); ?>
				<script type="text/javascript">

					// Only show remove button when needed
					if ( ! jQuery('#tpath_cat_thumbnail_image').val() ) {
						 jQuery('.tpath_img_remove_button').hide();
					}
	
					// Uploading files
					var file_frame;
	
					jQuery(document).on( 'click', '.tpath_img_upload_button', function( event ){
	
						event.preventDefault();
	
						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}
						
						// Create the media frame.
						file_frame = wp.media.frames.file_frame = wp.media({
							title: '<?php esc_html_e( 'Select image', 'Templatepath' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Upload image', 'Templatepath' ); ?>',
							},						
							multiple: false
						});
	
						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							attachment = file_frame.state().get('selection').first().toJSON();
							
							jQuery('#tpath_cat_thumbnail_image').val( attachment.url );
							jQuery('.tpath_img_remove_button').show();
						});
						
						// Finally, open the modal.
						if( file_frame ) {
							file_frame.open();
						}
						
					});
	
					jQuery(document).on( 'click', '.tpath_img_remove_button', function( event ){					
						jQuery('#tpath_cat_thumbnail_image').val('');
						jQuery('.tpath_img_remove_button').hide();
						return false;
					});
				</script>
			</td>
		</tr>	
	<?php
	}
}
add_action( 'category_edit_form_fields', 'justice_category_taxonomy_edit_meta_fields', 10, 2 );

if ( ! function_exists( 'justice_save_category_taxonomy_custom_meta' ) ) {
	function justice_save_category_taxonomy_custom_meta( $term_id ) {
	
		if ( isset( $_POST['tpath_cat_thumbnail_image'] ) ) {
			$tpath_term_id = $term_id;
			$term_meta = get_option( "taxonomy_$tpath_term_id" );			
			$term_meta['tpath_thumbnail_image'] = esc_url($_POST['tpath_cat_thumbnail_image']);

			// Save the option array.
			update_option( "taxonomy_$tpath_term_id", $term_meta );
		}
		
	}
}
add_action( 'edited_category', 'justice_save_category_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_category', 'justice_save_category_taxonomy_custom_meta', 10, 2 );

/* =========================================================
 * Get FontAwesome Icons Array
 * ========================================================= */
if ( ! function_exists( 'justice_get_fontawesome_icon_array' ) ) {
	function justice_get_fontawesome_icon_array() {
	
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$fontawesome_path = TEMPLATETHEME_DIR . '/css/font-awesome.css';
		if( file_exists( $fontawesome_path ) ) {
			$subject = file_get_contents($fontawesome_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$icons = array();
		
		foreach($matches as $match){
			$icons[$match[1]] = $match[2];
		}
		
		return $icons;
		
	}
}

/* =========================================================
 * Get Glyphicons Array
 * ========================================================= */
if ( ! function_exists( 'justice_get_glyphicons_array' ) ) {
	function justice_get_glyphicons_array() {
	
		$pattern = '/\.(glyphicon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$glyphicon_path = TEMPLATETHEME_DIR . '/css/bootstrap.css';
		if( file_exists( $glyphicon_path ) ) {
			$subject = file_get_contents($glyphicon_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$icons = array();
		
		foreach($matches as $match){
			$icons[$match[1]] = $match[2];
		}
		
		return $icons;
		
	}
}

/* =========================================================
 * Get Taxonomies List array for any post type
 * ========================================================= */
if ( ! function_exists( 'justice_get_taxonomy_terms_array' ) ) {
	function justice_get_taxonomy_terms_array($taxonomy, $post_type, $msg) {
	
		$list_groups = get_categories('taxonomy='.$taxonomy.'&post_type='.$post_type.'');
		$groups_list[0] = $msg;
		if( !empty($list_groups) ) {
			foreach ($list_groups as $groups) {
				$group_name = $groups->name;
				$termid = $groups->term_id;		
				$groups_list[$termid] = $group_name;
			}
		}
	
		if( isset($groups_list) ) {
			return $groups_list;
		}
		
	}
}

/* =========================================================
 * Update Post Views Count to find Popular Posts
 * ========================================================= */
if ( ! function_exists( 'justice_set_post_views_count' ) ) {
	function justice_set_post_views_count() {
		global $post;
	
		if('post' == get_post_type() && is_single()) {
			$post_id = $post->ID;
	
			if(!empty($post_id)) {
				$count_key = 'tpath_post_views_count';
				$count = get_post_meta($post_id, $count_key, true);

				if($count == '') {
					$count = 0;
					delete_post_meta($post_id, $count_key);
					add_post_meta($post_id, $count_key, '0');
				} else {
					$count++;
					update_post_meta($post_id, $count_key, $count);
				}
			}
		}
	}
}
add_action('wp_head', 'justice_set_post_views_count');

/* ==================================================================
 * Add Current Category Class to Categories List on Single Post
 * ================================================================== */
if ( ! function_exists( 'justice_current_cat_on_single_posts' ) ) {

	function justice_current_cat_on_single_posts($output) {
		global $post;
		
		if(is_single()) {
			$categories = wp_get_post_categories($post->ID);			
			if($categories) { 
				foreach($categories as $value) {
					if(preg_match('#item-' . $value . '">#', $output)) {
						$output = str_replace('item-' . $value . '">', 'item-' . $value . ' current-cat">', $output);
					}
				}
			}
		}
		return $output;
	}
	
}
add_filter('wp_list_categories', 'justice_current_cat_on_single_posts');

/* =========================================================
 * Get RGB values from Hexadecimal
 * ========================================================= */ 
 
function justice_hex2rgb($hex) {

   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   
   $rgb = array($r, $g, $b);
   
   return $rgb;
}

/* ==================================================================
 * Parallax Menu Links Creation
 * ================================================================== */
if ( ! function_exists( 'justice_get_parallax_link' ) ) {

	function justice_get_parallax_link( $item ) {
		global $wp_query;
			
		$post_data = $link = '';
	   
		// Front and Blog page
		$blog_page_id 	= get_option('page_for_posts');
		$front_page_id 	= get_option('page_on_front');
		
		// Get URL
		if( !is_page_template( 'template-parallax.php' ) ) {
			$blog_url = esc_url( home_url() ) . '/';
		} else {
			$blog_url = '';
		}		
		$front_url   = is_front_page() ? $blog_url . '#section-top' : esc_url( home_url() ) . '/' ;
		
		if ( !empty( $item->object_id ) ) {
			$post_data = get_post($item->object_id);
		}
		
		$slug = ( isset($post_data->post_name)) ? $post_data->post_name : '';
		
		// Regular link for blog - all other menu items are anchors
		if( $blog_page_id == $item->object_id || $item->tpath_megamenu_menutype == 'page' ) {
			
			$link = ! empty( $item->url ) ? esc_attr( $item->url ) : '';
			
		} 
		// Regular link for the front page or an anchors
		elseif( $front_page_id == $item->object_id ) {
			
			// Front page
			if( is_front_page() ) {				
				$link = ! empty( $item->url ) ? $blog_url . '#section-top' : '';
			} else {
				// Regular link
				$link = ! empty( $item->url ) ? esc_attr( $item->url ) : '';				
				
			}
			
		} else {
			$link = ! empty( $slug ) ? $blog_url . '#section-' . esc_attr( $slug ) : '';
		}
		
		return $link;
		
	}
	
}

/* ==================================================================
 * Parallax Custom Query
 * ================================================================== */
if ( ! function_exists( 'justice_parallax_front_query' ) ) {

	function justice_parallax_front_query() {
	
		$pages_query = array();
		
		$tpath_menu_items = '';		
			
		// Check for primary navigation
		if( has_nav_menu( 'primary-menu' ) ) {			
			
			// Primary navigation ID
			$tpath_menu_theme_locations = get_nav_menu_locations();
			$tpath_menu_objects = get_term( $tpath_menu_theme_locations['primary-menu'] , 'nav_menu' );
			$tpath_menu_id = $tpath_menu_objects->term_id;
		
			$menu_args = array(
				'orderby' => 'menu_order'
			);
			
			$tpath_menu_items = wp_get_nav_menu_items( $tpath_menu_id , $menu_args );
							
			// Create array of query for WP_Query()
			foreach( (array) $tpath_menu_items as $key => $tpath_menu_item ) {
				
				$blog_page_id = get_option('page_for_posts');
				$front_page_id = get_option('page_on_front');
	
				if( $tpath_menu_item->tpath_megamenu_menutype == 'section' && $blog_page_id != $tpath_menu_item->object_id && $front_page_id != $tpath_menu_item->object_id) {						
					$pages_query[] = $tpath_menu_item->object_id;					
				}
				
			}			
				
			// Return query
			if( !empty( $pages_query ) ) {
					
				// Query Args
				$tpath_query = array(						
						'post_type' 		=> 'page',
						'post__in' 			=> $pages_query,
						'posts_per_page' 	=> count($pages_query),
						'orderby'			=> 'post__in'				
				);
				
				return $tpath_query;

			} else {			
				return array();				
			}				
		}
	
	}
}

/* ==================================================================
 * Parallax Additional Sections Query
 * ================================================================== */
if ( ! function_exists( 'justice_parallax_additional_query' ) ) {

	function justice_parallax_additional_query( $ids ) {
	
		$additional_query = array();
		
		$query_ids = explode(',', $ids);
				
		// Create array of query for WP_Query()
		foreach( (array) $query_ids as $id => $value ) {
			
			$blog_page_id = get_option('page_for_posts');
			$front_page_id = get_option('page_on_front');
	
			if( $blog_page_id != $value && $front_page_id != $value ) {
				$additional_query[] = $value;
			}
			
		}
				
		// Return query
		if( !empty( $additional_query ) ) {
				
			// Query Args
			$tpath_additional_query = array(						
					'post_type' 		=> 'page',
					'post__in' 			=> $additional_query,
					'posts_per_page' 	=> count($additional_query),
					'orderby'			=> 'post__in'
			);
			
			return $tpath_additional_query;

		} else {
			return array();
		}
	
	}
}
 
/* =============================================================
 *	Breadcrumbs
 * ============================================================= */
 
if( ! function_exists( 'justice_breadcrumbs' ) ) {
	function justice_breadcrumbs() {
		$breadcrumbs = new Justice_Breadcrumbs();
		$breadcrumbs->justice_display_breadcrumbs();
	}
}

/* =============================================================
 *	Disable default breadcrumbs from bbPress
 * ============================================================= */
add_filter( 'bbp_no_breadcrumb', '__return_true' );

/* =============================================================
 *	Woocommerce Build Query String
 * ============================================================= */
if( ! function_exists('justice_woo_build_query_string') ) {
	function justice_woo_build_query_string($params = array(), $overwrite_key, $overwrite_value) {
		$params[$overwrite_key] = $overwrite_value;
		
		$paged = (array_key_exists('product_count', $params)) ? 'paged=1&' : '';
		
		return "?" . $paged . http_build_query($params);
	}
}

/* =========================================================
 * Display Related Team Members on Single Post pages
 * ========================================================= */
 
if( ! function_exists( "justice_related_team_members" ) ) {

	function justice_related_team_members() {
		global $post;
		
		$categories = get_the_terms( $post->ID, 'team_member_categories' );
		
		if($categories) {
			$category_ids = array();
			foreach($categories as $category) {
				$category_ids[] = $category->term_id;
			}
			
			$args = array(
				'post_type'  		=> 'tpath_team_member',
				'post__not_in'   	=> array($post->ID),
				'posts_per_page' 	=> 4,
				'tax_query' 		=> array(
											array(
												'taxonomy' => 'team_member_categories',
												'field'    => 'id',
												'terms'    => $category_ids,
											),
										),
		    );
			
			$related_query = new WP_Query($args);
			if( $related_query->have_posts() ) { ?>
				<div class="related-posts-wrapper">
					<div class="row">
						<div class="col-md-12">
							<div class="related-post-inner">
								<h4 class="related-member-title"><?php esc_html_e('Similar Attorneys', 'Templatepath'); ?></h4>
								<ul class="related-members row">
									<?php while ($related_query->have_posts()) {
										$related_query->the_post();	
										
										$member_designation 	= get_post_meta( $post->ID, 'tpath_member_designation', true );			
										
										if ( has_post_thumbnail() ) { ?>
											<li class="col-sm-3">
												<div class="related-member-item">
													<div class="entry-thumbnail">
														<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-img">
															<?php the_post_thumbnail( 'team' ); ?>															
														</a>
													</div>
													<div class="team-content-wrapper">
														<h6 class="team-member-name"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="post-link"><?php the_title(); ?></a></h6>
														<p><span class="team-member-designation"><?php echo esc_html( $member_designation ); ?></span></p>
														<div class="team-member-btn"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Contact Now', 'Templatepath' ); ?></a></div>
													</div>
												</div>
											</li>
										<?php } else { ?>
											<li class="col-sm-3">
												<div class="related-member-item">
													<div class="entry-thumbnail">
														<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-img">
															<img src="<?php echo ZOZOTHEME_URL; ?>/images/empty-500.jpg" class="img-responsive" alt="<?php the_title_attribute(); ?>" />											
														</a>
													</div>
													<div class="team-content-wrapper">
														<h6 class="team-member-name"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="post-link"><?php the_title(); ?></a></h6>
														<p><span class="team-member-designation"><?php echo esc_html( $member_designation ); ?></span></p>
														<div class="team-member-btn"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Contact Now', 'Templatepath' ); ?></a></div>
													</div>						
												</div>
											</li>
										<?php }
									} ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php }
			
			wp_reset_postdata();
			
		}
	}	
}

/* =========================================================
 * Show Block
 * ========================================================= */
 
if( ! function_exists( "justice_block" ) ) {

	function justice_block( $block_id ) {
		global $post;
				
		if($block_id) {
					
			$args = array(
				'post_type'  		=> 'tpath_block',
				'post__in'   		=> array( $block_id )
		    );
			
			$block_query = new WP_Query($args);
			
			$output = '';
			
			if( $block_query->have_posts() ) { 
				while ($block_query->have_posts()) {
					$block_query->the_post();
					
					$post_content = $post->post_content;
					
					$output = '<div class="tpath-block tpath-block-wrapper">';
					
					$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $post_content ) . "\n" );
					$output .= do_shortcode( shortcode_unautop( $post_content ) );
					
					$output .= '</div>';
					
				}
			}
			
			wp_reset_postdata();
			
			return $output;
			
		}
		
	}	
}

/* =============================================================
 *	Remove Extra P Tags
 * ============================================================= */
 
function justice_shortcodes_formatter($content) {
	$block = join("|", array("tpath_section_title", "tpath_about_me", "tpath_feature_box", "tpath_iconslist"));

	// opening tag
	$shortcode = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$shortcode = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$shortcode);

	return $shortcode;
}

add_filter('the_content', 'justice_shortcodes_formatter');
add_filter('widget_text', 'justice_shortcodes_formatter');

/* =============================================================
 *	HTML Allowed Tags for wp_kses
 * ============================================================= */
if( ! function_exists('justice_wp_allowed_tags') ) {
	function justice_wp_allowed_tags() {
		$allowed_tags = wp_kses_allowed_html( 'post' );
		
		// iframe
		$allowed_tags['iframe'] = array(
			'src' 				=> array(),
			'height' 			=> array(),
			'width' 			=> array(),
			'frameborder' 		=> array(),
			'allowfullscreen' 	=> array(),
		);
		
		// style
		$allowed_tags['style'] = array(
			'type' => array(),
		);
		
		// link
		$allowed_tags['link'] = array(
			'type'  => array(),
			'href'  => array(),
			'rel'   => array(),
			'sizes' => array(),
		);
		
		// meta
		$allowed_tags['meta'] = array(
			'name'  	=> array(),
			'content'   => array(),			
		);
		
		// select
		$allowed_tags['select'] = array(
			'name'  	=> array(),
			'multiple'  => array(),
			'required'  => array(),
			'class' 	=> array(),	
			'size' 		=> array(),
		);
		
		// option
		$allowed_tags['option'] = array(
			'id'  		=> array(),
			'value'  	=> array(),
			'label'  	=> array(),
			'selected'  => array(),			
		);
		
		// input
		$allowed_tags['input'] = array(
			'type'  	=> array(),
			'id'  		=> array(),
			'class' 	=> array(),	
			'value' 	=> array(),
			'name'  	=> array(),
			'checked'   => array(),
			'readonly'  => array(),
		);
		 
		return $allowed_tags;
	}
}
?>