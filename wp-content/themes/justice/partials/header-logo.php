<?php global $tpath_options;

$tpath_site_title = get_bloginfo( 'name' );
$tpath_site_url = home_url( '/' );
$tpath_site_description = get_bloginfo( 'description' );
 
$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>

<!-- ==================== Toggle Icon ==================== -->
<div class="navbar-header nav-respons tpath-logo">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".tpath-mainnavbar-collapse">
		<span class="sr-only"><?php esc_html_e('Toggle navigation', 'Templatepath'); ?></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
		<?php if( isset( $tpath_options['tpath_logo'] ) && $tpath_options['tpath_logo'] != '' ) {
			echo '<img class="img-responsive" src="' . esc_url( $tpath_options['tpath_logo'] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" width="'. esc_attr( $tpath_options['tpath_logo_width'] ) .'" height="'. esc_attr( $tpath_options['tpath_logo_height'] ) .'" />';
		} elseif( isset($tpath_options['tpath_logo_text']) && $tpath_options['tpath_logo_text'] != '' ) {
			echo '<div class="site-logo-text">'. $tpath_options['tpath_logo_text'] .'</div>';
		} else {				
			echo '<div class="site-logo-text">'. get_bloginfo( 'name' ) .'</div>';
		} ?>
	</a>
</div>